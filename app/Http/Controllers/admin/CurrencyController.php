<?php

namespace App\Http\Controllers\admin;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
  public function index(Request $request)
  {
    $query = Currency::query();

    if ($request->filled('search')) {
      $query->where('name', 'like', "%{$request->search}%")
        ->orWhere('code', 'like', "%{$request->search}%")
        ->orWhere('symbol', 'like', "%{$request->search}%");
    }

    if ($request->filled('status')) {
      $query->where('is_active', $request->status === 'active');
    }

    $currencies = $query->orderBy('created_at', 'desc')->paginate(15);
    $defaultCurrency = Currency::where('is_default', true)->first();

    return view('content.apps.admin.currencies.index', compact('currencies', 'defaultCurrency'));
  }

  public function create()
  {
    return view('content.apps.admin.currencies.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'code' => 'required|string|max:3|unique:currencies',
      'name' => 'required|string|max:255|unique:currencies',
      'symbol' => 'required|string|max:10|unique:currencies',
      'exchange_rate' => 'required|numeric|min:0.0001',
      'description' => 'nullable|string',
      'is_active' => 'nullable|boolean',
      'is_default' => 'nullable|boolean',
    ]);

    $validated['is_active'] = $validated['is_active'] ?? true;
    $validated['is_default'] = $validated['is_default'] ?? false;

    // If setting as default, unset other defaults
    if ($validated['is_default']) {
      Currency::where('is_default', true)->update(['is_default' => false]);
    }

    Currency::create($validated);

    return redirect()->route('admin.currencies.index')
      ->with('success', 'Currency created successfully!');
  }

  public function edit(Currency $currency)
  {
    return view('content.apps.admin.currencies.edit', compact('currency'));
  }

  public function update(Request $request, Currency $currency)
  {
    $validated = $request->validate([
      'code' => 'required|string|max:3|unique:currencies,code,' . $currency->id,
      'name' => 'required|string|max:255|unique:currencies,name,' . $currency->id,
      'symbol' => 'required|string|max:10|unique:currencies,symbol,' . $currency->id,
      'exchange_rate' => 'required|numeric|min:0.0001',
      'description' => 'nullable|string',
      'is_active' => 'nullable|boolean',
      'is_default' => 'nullable|boolean',
    ]);

    $validated['is_active'] = $validated['is_active'] ?? false;
    $validated['is_default'] = $validated['is_default'] ?? false;

    // If setting as default, unset other defaults
    if ($validated['is_default']) {
      Currency::where('is_default', true)->where('id', '!=', $currency->id)->update(['is_default' => false]);
    }

    $currency->update($validated);

    return redirect()->route('admin.currencies.index')
      ->with('success', 'Currency updated successfully!');
  }

  public function destroy(Currency $currency)
  {
    if ($currency->is_default) {
      return redirect()->route('admin.currencies.index')
        ->with('error', 'Cannot delete the default currency. Set another currency as default first.');
    }

    $currency->delete();

    return redirect()->route('admin.currencies.index')
      ->with('success', 'Currency deleted successfully!');
  }

  public function setDefault(Currency $currency)
  {
    Currency::where('is_default', true)->update(['is_default' => false]);
    $currency->update(['is_default' => true]);

    return redirect()->route('admin.currencies.index')
      ->with('success', 'Default currency updated successfully!');
  }
}
