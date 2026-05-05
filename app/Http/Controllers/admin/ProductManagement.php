<?php

namespace App\Http\Controllers\admin;

use App\Models\ArtisanGood;
use Illuminate\Http\Request;
use App\Models\ArtisanProfile;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;

class ProductManagement extends Controller
{
  // Display all goods/products
  public function index(Request $request)
  {
    $query = ArtisanGood::with('artisan.user');

    // Filter by artisan
    if ($request->filled('artisan_id')) {
      $query->where('artisan_id', $request->artisan_id);
    }

    // Filter by stock status
    if ($request->filled('stock_status')) {
      if ($request->stock_status === 'in_stock') {
        $query->where('stock_quantity', '>', 0);
      } elseif ($request->stock_status === 'low_stock') {
        $query->whereBetween('stock_quantity', [1, 10]);
      } elseif ($request->stock_status === 'out_of_stock') {
        $query->where('stock_quantity', 0);
      }
    }

    // Search by product name or category
    if ($request->filled('search')) {
      $query->where(function ($q) use ($request) {
        $q->where('product_name', 'like', "%{$request->search}%")
          ->orWhere('category', 'like', "%{$request->search}%")
          ->orWhere('description', 'like', "%{$request->search}%");
      });
    }

    $products = $query->orderBy('created_at', 'desc')->paginate(15);
    $artisans = ArtisanProfile::with('user')->get();

    // Summary stats
    $stats = [
      'total_products' => ArtisanGood::count(),
      'total_stock_value' => ArtisanGood::selectRaw('SUM(stock_quantity * price) as value')->value('value') ?? 0,
    ];

    return view('content.apps.admin.products.index', compact('products', 'artisans', 'stats'));
  }

  // Show create form
  public function create()
  {
    $artisans = ArtisanProfile::with('user')->get();
    $categories = ProductCategory::where('is_active', true)->get();
    return view('content.apps.admin.products.create', compact('artisans', 'categories'));
  }

  // Store product
  public function store(Request $request)
  {
    $validated = $request->validate([
      'artisan_id' => 'required|exists:artisan_profiles,id',
      'product_name' => 'required|string|max:255',
      'category' => 'required|string|max:100',
      'description' => 'nullable|string',
      'price' => 'required|numeric|min:0.01',
      'stock_quantity' => 'required|integer|min:0',
      'unit' => 'nullable|string|max:50',
      'availability' => 'nullable|in:available,unavailable',
    ]);
    ArtisanGood::create($validated);

    return redirect()->route('admin.products.index')
      ->with('success', 'Product created successfully!');
  }

  // Show edit form
  public function edit(ArtisanGood $product)
  {
    $artisans = ArtisanProfile::with('user')->get();
    $categories = ProductCategory::where('is_active', true)->get();
    return view('content.apps.admin.products.edit', compact('product', 'artisans', 'categories'));
  }

  // Update product
  public function update(Request $request, ArtisanGood $product)
  {
    $validated = $request->validate([
      'product_name' => 'required|string|max:255',
      'category' => 'required|string|max:100',
      'description' => 'nullable|string',
      'price' => 'required|numeric|min:0.01',
      'stock_quantity' => 'required|integer|min:0',
      'unit' => 'nullable|string|max:50',
      'availability' => 'nullable|in:available,unavailable',
    ]);

    $product->update($validated);

    return redirect()->route('admin.products.index')
      ->with('success', 'Product updated successfully!');
  }

  // Delete product
  public function destroy(ArtisanGood $product)
  {
    $product->delete();
    return redirect()->route('admin.products.index')
      ->with('success', 'Product deleted successfully!');
  }

  // Adjust stock
  public function adjustStock(Request $request, ArtisanGood $product)
  {
    $validated = $request->validate([
      'quantity' => 'required|integer',
      'reason' => 'nullable|string|max:255',
      'type' => 'required|in:add,remove'
    ]);

    if ($validated['type'] === 'add') {
      $product->increment('stock_quantity', abs($validated['quantity']));
    } else {
      if ($product->stock_quantity < $validated['quantity']) {
        return redirect()->back()->with('error', 'Cannot reduce stock below 0!');
      }
      $product->decrement('stock_quantity', abs($validated['quantity']));
    }

    return redirect()->route('admin.products.index')
      ->with('success', 'Stock adjusted successfully!');
  }

  // Bulk update stock
  public function bulkUpdateStock(Request $request)
  {
    $validated = $request->validate([
      'updates' => 'required|array',
      'updates.*.product_id' => 'required|exists:artisan_goods,id',
      'updates.*.quantity' => 'required|integer|min:0'
    ]);

    foreach ($validated['updates'] as $update) {
      ArtisanGood::find($update['product_id'])->update(['stock_quantity' => $update['quantity']]);
    }

    return redirect()->route('admin.products.index')
      ->with('success', 'Stock updated for all products!');
  }

  // Get products data for API
  public function getProductsData(Request $request)
  {
    $query = ArtisanGood::with('artisan.user');

    if ($request->filled('artisan_id')) {
      $query->where('artisan_id', $request->artisan_id);
    }

    if ($request->filled('stock_status')) {
      if ($request->stock_status === 'in_stock') {
        $query->where('stock_quantity', '>', 0);
      } elseif ($request->stock_status === 'low_stock') {
        $query->whereBetween('stock_quantity', [1, 10]);
      } elseif ($request->stock_status === 'out_of_stock') {
        $query->where('stock_quantity', 0);
      }
    }

    if ($request->filled('search')) {
      $query->where(function ($q) use ($request) {
        $q->where('product_name', 'like', "%{$request->search}%")
          ->orWhere('category', 'like', "%{$request->search}%");
      });
    }

    $products = $query->orderBy('created_at', 'desc')->paginate(15);

    return response()->json([
      'success' => true,
      'data' => $products->items(),
      'pagination' => [
        'current_page' => $products->currentPage(),
        'last_page' => $products->lastPage(),
        'total' => $products->total(),
      ]
    ]);
  }
}