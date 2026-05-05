<?php

namespace App\Http\Controllers\admin;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
  public function index(Request $request)
  {
    $query = ProductCategory::query();

    if ($request->filled('search')) {
      $query->where('name', 'like', "%{$request->search}%")
        ->orWhere('description', 'like', "%{$request->search}%");
    }

    if ($request->filled('status')) {
      $query->where('is_active', $request->status === 'active');
    }

    $categories = $query->orderBy('created_at', 'desc')->paginate(15);

    return view('content.apps.admin.product-categories.index', compact('categories'));
  }

  public function create()
  {
    return view('content.apps.admin.product-categories.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255|unique:product_categories',
      'description' => 'nullable|string',
      'is_active' => 'nullable|boolean',
    ]);

    $validated['is_active'] = $validated['is_active'] ?? true;

    ProductCategory::create($validated);

    return redirect()->route('admin.product-categories.index')
      ->with('success', 'Product Category created successfully!');
  }

  public function edit(ProductCategory $productCategory)
  {
    return view('content.apps.admin.product-categories.edit', compact('productCategory'));
  }

  public function update(Request $request, ProductCategory $productCategory)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255|unique:product_categories,name,' . $productCategory->id,
      'description' => 'nullable|string',
      'is_active' => 'nullable|boolean',
    ]);

    $validated['is_active'] = $validated['is_active'] ?? false;

    $productCategory->update($validated);

    return redirect()->route('admin.product-categories.index')
      ->with('success', 'Product Category updated successfully!');
  }

  public function destroy(ProductCategory $productCategory)
  {
    $productCategory->delete();

    return redirect()->route('admin.product-categories.index')
      ->with('success', 'Product Category deleted successfully!');
  }
}
