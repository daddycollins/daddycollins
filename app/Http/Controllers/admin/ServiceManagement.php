<?php

namespace App\Http\Controllers\admin;

use App\Models\ArtisanService;
use App\Models\ArtisanProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceManagement extends Controller
{
  // Display all services
  public function index(Request $request)
  {
    $query = ArtisanService::with('artisan.user')->orderBy('created_at', 'desc');

    // Filter by category
    if ($request->filled('category')) {
      $query->where('category', $request->category);
    }

    // Filter by artisan
    if ($request->filled('artisan_id')) {
      $query->where('artisan_id', $request->artisan_id);
    }

    // Search by service name or description
    if ($request->filled('search')) {
      $query->where(function ($q) use ($request) {
        $q->where('service_name', 'like', "%{$request->search}%")
          ->orWhere('description', 'like', "%{$request->search}%");
      });
    }

    $services = $query->paginate(15);
    $artisans = ArtisanProfile::with('user')->get();
    $categories = ArtisanService::select('category')->distinct()->pluck('category');

    return view('content.apps.admin.services.index', compact('services', 'artisans', 'categories'));
  }

  // Show create form
  public function create()
  {
    $artisans = ArtisanProfile::with('user')->get();
    return view('content.apps.admin.services.create', compact('artisans'));
  }

  // Store service
  public function store(Request $request)
  {
    $validated = $request->validate([
      'artisan_id' => 'required|exists:artisan_profiles,id',
      'service_name' => 'required|string|max:255',
      'category' => 'required|string|max:100',
      'description' => 'nullable|string',
      'price_estimate' => 'required|numeric|min:0',
      'rate_type' => 'required|in:per_minute,per_hour,per_day,per_week,per_month,per_project,fixed',
      'availability' => 'required|in:available,unavailable',
      'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    if ($request->hasFile('image_path')) {
      $path = $request->file('image_path')->store('services', 'public');
      $validated['image_path'] = $path;
    }

    ArtisanService::create($validated);

    return redirect()->route('admin.services.index')
      ->with('success', 'Service created successfully!');
  }

  // Show edit form
  public function edit(ArtisanService $service)
  {
    $artisans = ArtisanProfile::with('user')->get();
    return view('content.apps.admin.services.edit', compact('service', 'artisans'));
  }

  // Update service
  public function update(Request $request, ArtisanService $service)
  {
    $validated = $request->validate([
      'service_name' => 'required|string|max:255',
      'category' => 'required|string|max:100',
      'description' => 'nullable|string',
      'price_estimate' => 'required|numeric|min:0',
      'rate_type' => 'required|in:per_minute,per_hour,per_day,per_week,per_month,per_project,fixed',
      'availability' => 'required|in:available,unavailable',
      'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    if ($request->hasFile('image_path')) {
      $path = $request->file('image_path')->store('services', 'public');
      $validated['image_path'] = $path;
    }

    $service->update($validated);

    return redirect()->route('admin.services.index')
      ->with('success', 'Service updated successfully!');
  }

  // Delete service
  public function destroy(ArtisanService $service)
  {
    $service->delete();
    return redirect()->route('admin.services.index')
      ->with('success', 'Service deleted successfully!');
  }

  // Get services data for API
  public function getServicesData(Request $request)
  {
    $query = ArtisanService::with('artisan.user');

    if ($request->filled('category')) {
      $query->where('category', $request->category);
    }

    if ($request->filled('artisan_id')) {
      $query->where('artisan_id', $request->artisan_id);
    }

    if ($request->filled('search')) {
      $query->where(function ($q) use ($request) {
        $q->where('service_name', 'like', "%{$request->search}%")
          ->orWhere('description', 'like', "%{$request->search}%");
      });
    }

    $services = $query->orderBy('created_at', 'desc')->paginate(15);

    return response()->json([
      'success' => true,
      'data' => $services->items(),
      'pagination' => [
        'current_page' => $services->currentPage(),
        'last_page' => $services->lastPage(),
        'total' => $services->total(),
      ]
    ]);
  }
}
