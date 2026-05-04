<?php

namespace App\Http\Controllers\admin;

use App\Models\Payout;
use App\Models\ArtisanProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PayoutManagement extends Controller
{
  // Display all payouts
  public function index(Request $request)
  {
    $query = Payout::with('artisan.user');

    // Filter by status
    if ($request->filled('status')) {
      $query->where('status', $request->status);
    }

    // Filter by artisan
    if ($request->filled('artisan_id')) {
      $query->where('artisan_id', $request->artisan_id);
    }

    // Filter by date range
    if ($request->filled('date_from')) {
      $query->whereDate('created_at', '>=', $request->date_from);
    }
    if ($request->filled('date_to')) {
      $query->whereDate('created_at', '<=', $request->date_to);
    }

    $payouts = $query->orderBy('created_at', 'desc')->paginate(20);
    $artisans = ArtisanProfile::with('user')->get();

    // Summary stats
    $stats = [
      'total_pending' => Payout::where('status', 'pending')->sum('amount'),
      'total_completed' => Payout::where('status', 'completed')->sum('amount'),
      'total_failed' => Payout::where('status', 'failed')->sum('amount'),
    ];

    return view('content.apps.admin.payouts.index', compact('payouts', 'artisans', 'stats'));
  }

  // Show create payout form
  public function create()
  {
    $artisans = ArtisanProfile::with('user')->get();
    return view('content.apps.admin.payouts.create', compact('artisans'));
  }

  // Store payout
  public function store(Request $request)
  {
    $validated = $request->validate([
      'artisan_id' => 'required|exists:artisan_profiles,id',
      'amount' => 'required|numeric|min:0.01',
      'payment_method' => 'required|string|max:100',
      'notes' => 'nullable|string|max:500'
    ]);

    $validated['status'] = 'pending';

    Payout::create($validated);

    return redirect()->route('admin.payouts.index')
      ->with('success', 'Payout request created successfully!');
  }

  // Process/approve payout
  public function approve(Request $request, Payout $payout)
  {
    $validated = $request->validate([
      'transaction_id' => 'nullable|string|max:100',
      'notes' => 'nullable|string|max:500'
    ]);

    $payout->update([
      'status' => 'completed',
      'processed_at' => now(),
      'transaction_id' => $validated['transaction_id'] ?? null,
      'notes' => $validated['notes'] ?? $payout->notes
    ]);

    return redirect()->route('admin.payouts.index')
      ->with('success', 'Payout processed successfully!');
  }

  // Mark payout as failed
  public function markFailed(Request $request, Payout $payout)
  {
    $validated = $request->validate([
      'notes' => 'required|string|max:500'
    ]);

    $payout->update([
      'status' => 'failed',
      'notes' => $validated['notes']
    ]);

    return redirect()->route('admin.payouts.index')
      ->with('success', 'Payout marked as failed!');
  }

  // Delete payout (only if pending)
  public function destroy(Payout $payout)
  {
    if ($payout->status !== 'pending') {
      return redirect()->route('admin.payouts.index')
        ->with('error', 'Only pending payouts can be deleted!');
    }

    $payout->delete();
    return redirect()->route('admin.payouts.index')
      ->with('success', 'Payout deleted successfully!');
  }

  // Get payout summary report
  public function summary(Request $request)
  {
    $dateFrom = $request->date_from ? Carbon::parse($request->date_from) : Carbon::now()->subMonths(1);
    $dateTo = $request->date_to ? Carbon::parse($request->date_to) : Carbon::now();

    $summary = [
      'total_payouts' => Payout::whereBetween('created_at', [$dateFrom, $dateTo])->count(),
      'total_amount' => Payout::whereBetween('created_at', [$dateFrom, $dateTo])->sum('amount'),
      'by_status' => Payout::whereBetween('created_at', [$dateFrom, $dateTo])
        ->selectRaw('status, COUNT(*) as count, SUM(amount) as total')
        ->groupBy('status')
        ->get(),
      'by_method' => Payout::whereBetween('created_at', [$dateFrom, $dateTo])
        ->selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total')
        ->groupBy('payment_method')
        ->get(),
      'top_artisans' => Payout::whereBetween('created_at', [$dateFrom, $dateTo])
        ->with('artisan.user')
        ->selectRaw('artisan_id, COUNT(*) as count, SUM(amount) as total')
        ->groupBy('artisan_id')
        ->orderByRaw('SUM(amount) DESC')
        ->limit(10)
        ->get(),
    ];

    return view('content.apps.admin.payouts.summary', compact('summary', 'dateFrom', 'dateTo'));
  }

  // Get payouts data for API
  public function getPayoutsData(Request $request)
  {
    $query = Payout::with('artisan.user');

    if ($request->filled('status')) {
      $query->where('status', $request->status);
    }

    if ($request->filled('artisan_id')) {
      $query->where('artisan_id', $request->artisan_id);
    }

    if ($request->filled('date_from')) {
      $query->whereDate('created_at', '>=', $request->date_from);
    }
    if ($request->filled('date_to')) {
      $query->whereDate('created_at', '<=', $request->date_to);
    }

    $payouts = $query->orderBy('created_at', 'desc')->paginate(20);

    return response()->json([
      'success' => true,
      'data' => $payouts->items(),
      'pagination' => [
        'current_page' => $payouts->currentPage(),
        'last_page' => $payouts->lastPage(),
        'total' => $payouts->total(),
      ]
    ]);
  }
}
