<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\PaynowAccount;
use App\Models\ArtisanProfile;
use App\Http\Controllers\Controller;

class PaynowAccountManagement extends Controller
{
  // Display all payment accounts
  public function index(Request $request)
  {
    $query = PaynowAccount::with('artisan.user');

    // Filter by account type
    if ($request->filled('account_type')) {
      $query->where('account_type', $request->account_type);
    }

    // Filter by artisan
    if ($request->filled('artisan_id')) {
      $query->where('artisan_id', $request->artisan_id);
    }

    // Search by account holder or account number
    if ($request->filled('search')) {
      $query->where(function ($q) use ($request) {
        $q->where('account_holder', 'like', "%{$request->search}%")
          ->orWhere('account_number', 'like', "%{$request->search}%");
      });
    }

    $accounts = $query->orderBy('created_at', 'desc')->paginate(15);
    $artisans = ArtisanProfile::with('user')->get();

    return view('content.apps.admin.payment-accounts.index', compact('accounts', 'artisans'));
  }
  // Show create form
  public function create()
  {
    $artisans = ArtisanProfile::with('user')->get();
    return view('content.apps.admin.payment-accounts.create', compact('artisans'));
  }

  // Store payment account
  public function store(Request $request)
  {
    $validated = $request->validate([
      'artisan_id' => 'required|exists:artisan_profiles,id|unique:paynow_accounts,artisan_id',
      'paynow_integration_id' => 'required|string|max:255',
      'paynow_integration_key' => 'required|string|max:255',
      'account_holder' => 'required|string|max:255',
      'account_number' => 'required|string|max:100',
      'account_type' => 'required|in:paynow,bank,mobile_money',
      'phone_number' => 'nullable|string|max:20',
      'bank_name' => 'nullable|string|max:255',
      'branch' => 'nullable|string|max:255',
      'swift_code' => 'nullable|string|max:20',
      'iban' => 'nullable|string|max:50',
      'is_primary' => 'boolean'
    ]);

    PaynowAccount::create($validated);

    return redirect()->route('admin.payment-accounts.index')
      ->with('success', 'Payment account created successfully!');
  }

  // Show edit form
  public function edit(PaynowAccount $account)
  {
    $artisans = ArtisanProfile::with('user')->get();
    return view('content.apps.admin.payment-accounts.edit', compact('account', 'artisans'));
  }

  // Update payment account
  public function update(Request $request, PaynowAccount $account)
  {
    $validated = $request->validate([
      'artisan_id' => 'required|exists:artisan_profiles,id|unique:paynow_accounts,artisan_id,' . $account->id,
      'paynow_integration_id' => 'required|string|max:255',
      'paynow_integration_key' => 'required|string|max:255',
      'account_holder' => 'required|string|max:255',
      'account_number' => 'required|string|max:100',
      'account_type' => 'required|in:paynow,bank,mobile_money',
      'bank_name' => 'nullable|string|max:255',
      'branch' => 'nullable|string|max:255',
      'swift_code' => 'nullable|string|max:20',
      'iban' => 'nullable|string|max:50',
      'phone_number' => 'nullable|string|max:20',
      'is_primary' => 'boolean'
    ]);

    $account->update($validated);

    return redirect()->route('admin.payment-accounts.index')
      ->with('success', 'Payment account updated successfully!');
  }

  // Set as primary account
  public function setPrimary(PaynowAccount $account)
  {
    // Unset other primary accounts for same artisan
    PaynowAccount::where('artisan_id', $account->artisan_id)
      ->where('id', '!=', $account->id)
      ->update(['is_primary' => false]);

    $account->update(['is_primary' => true]);

    return redirect()->route('admin.payment-accounts.index')
      ->with('success', 'Primary account updated!');
  }

  // Delete account
  public function destroy(PaynowAccount $account)
  {
    if ($account->is_primary) {
      return redirect()->route('admin.payment-accounts.index')
        ->with('error', 'Cannot delete primary payment account!');
    }

    $account->delete();
    return redirect()->route('admin.payment-accounts.index')
      ->with('success', 'Payment account deleted successfully!');
  }

  // Get accounts data for API
  public function getAccountsData(Request $request)
  {
    $query = PaynowAccount::with('artisan.user');

    if ($request->filled('artisan_id')) {
      $query->where('artisan_id', $request->artisan_id);
    }

    if ($request->filled('account_type')) {
      $query->where('account_type', $request->account_type);
    }

    if ($request->filled('search')) {
      $query->where(function ($q) use ($request) {
        $q->where('account_number', 'like', "%{$request->search}%")
          ->orWhere('account_holder', 'like', "%{$request->search}%");
      });
    }

    $accounts = $query->orderBy('created_at', 'desc')->paginate(15);

    return response()->json([
      'success' => true,
      'data' => $accounts->items(),
      'pagination' => [
        'current_page' => $accounts->currentPage(),
        'last_page' => $accounts->lastPage(),
        'total' => $accounts->total(),
      ]
    ]);
  }
}