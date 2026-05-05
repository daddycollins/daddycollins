<?php

namespace App\Http\Controllers\admin;

use App\Models\ProductUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductUnitController extends Controller
{
  public function index(Request $request)
  {
    $query = ProductUnit::query();

    if ($request->filled('search')) {
      $query->where('name', 'like', "%{$request->search}%")
        ->orWhere('abbreviation', 'like', "%{$request->search}%")
        ->orWhere('description', 'like', "%{$request->search}%");
    }

    if ($request->filled('status')) {
      $query->where('is_active', $request->status === 'active');
    }

    $units = $query->orderBy('created_at', 'desc')->paginate(15);

    return view('content.apps.admin.product-units.index', compact('units'));
  }

  public function create()
  {
    return view('content.apps.admin.product-units.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255|unique:product_units',
      'abbreviation' => 'required|string|max:50|unique:product_units',
      'description' => 'nullable|string',
      'is_active' => 'nullable|boolean',
    ]);

    $validated['is_active'] = $validated['is_active'] ?? true;

    ProductUnit::create($validated);

    return redirect()->route('admin.product-units.index')
      ->with('success', 'Product Unit created successfully!');
  }

  public function edit(ProductUnit $productUnit)
  {
    return view('content.apps.admin.product-units.edit', compact('productUnit'));
  }

  public function update(Request $request, ProductUnit $productUnit)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255|unique:product_units,name,' . $productUnit->id,
      'abbreviation' => 'required|string|max:50|unique:product_units,abbreviation,' . $productUnit->id,
      'description' => 'nullable|string',
      'is_active' => 'nullable|boolean',
    ]);

    $validated['is_active'] = $validated['is_active'] ?? false;

    $productUnit->update($validated);

    return redirect()->route('admin.product-units.index')
      ->with('success', 'Product Unit updated successfully!');
  }

  public function destroy(ProductUnit $productUnit)
  {
    $productUnit->delete();

    return redirect()->route('admin.product-units.index')
      ->with('success', 'Product Unit deleted successfully!');
  }
}
