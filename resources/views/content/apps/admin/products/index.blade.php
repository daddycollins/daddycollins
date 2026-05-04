@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Product Management - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-6">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="mb-0"><i class="ri-shopping-bag-line me-2 text-primary"></i>Product Inventory Management</h4>
          <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="ri-add-line me-1"></i> Add New Product
          </a>
        </div>
      </div>
    </div>

    <!-- Summary Stats -->
    <div class="row g-4 mb-6">
      <div class="col-md-3">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <p class="text-muted small mb-1">Total Products</p>
                <h4>{{ $stats['total_products'] ?? 0 }}</h4>
              </div>
              <i class="ri-shopping-bag-line" style="font-size: 2rem; color: #0d6efd;"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <p class="text-muted small mb-1">Stock Value</p>
                <h4>US$ {{ number_format($stats['total_stock_value'] ?? 0, 2) }}</h4>
              </div>
              <i class="ri-money-dollar-circle-line" style="font-size: 2rem; color: #28a745;"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <p class="text-muted small mb-1">Low Stock</p>
                <h4 class="text-warning">{{ $stats['low_stock_items'] ?? 0 }}</h4>
              </div>
              <i class="ri-alert-line" style="font-size: 2rem; color: #ffc107;"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <p class="text-muted small mb-1">Out of Stock</p>
                <h4 class="text-danger">{{ $stats['out_of_stock'] ?? 0 }}</h4>
              </div>
              <i class="ri-close-circle-line" style="font-size: 2rem; color: #dc3545;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
      <div class="card-body pb-2">
        <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3">
          <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search products..."
              value="{{ request('search') }}">
          </div>
          <div class="col-md-2">
            <select name="stock_status" class="form-select">
              <option value="">All Stock Status</option>
              <option value="in_stock" @if (request('stock_status') === 'in_stock') selected @endif>In Stock</option>
              <option value="low_stock" @if (request('stock_status') === 'low_stock') selected @endif>Low Stock (1-10)</option>
              <option value="out_of_stock" @if (request('stock_status') === 'out_of_stock') selected @endif>Out of Stock</option>
            </select>
          </div>
          <div class="col-md-3">
            <select name="artisan_id" class="form-select">
              <option value="">All Artisans</option>
              @foreach ($artisans as $artisan)
                <option value="{{ $artisan->id }}" @if (request('artisan_id') == $artisan->id) selected @endif>
                  {{ $artisan->user->name ?? 'N/A' }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <button type="submit" class="btn btn-outline-primary w-100">
              <i class="ri-search-line me-1"></i> Filter
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Products Table -->
    <div class="card">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="table-light">
            <tr>
              <th><i class="ri-hashtag-line"></i> ID</th>
              <th><i class="ri-user-line"></i> Artisan</th>
              <th><i class="ri-shopping-bag-line"></i> Product</th>
              <th><i class="ri-tag-line"></i> Category</th>
              <th><i class="ri-money-dollar-circle-line"></i> Price (US$)</th>
              <th><i class="ri-archive-line"></i> Stock</th>
              <th><i class="ri-ruler-line"></i> Unit</th>
              <th class="text-center"><i class="ri-tools-line"></i> Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($products as $product)
              <tr>
                <td><span class="badge bg-label-info">{{ $product->id }}</span></td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm bg-label-primary me-2">
                      <span class="avatar-initial">{{ substr($product->artisan->user->name ?? 'A', 0, 1) }}</span>
                    </div>
                    <span>{{ $product->artisan->user->name ?? 'N/A' }}</span>
                  </div>
                </td>
                <td><strong>{{ $product->product_name }}</strong></td>
                <td><span class="badge bg-label-secondary">{{ $product->category }}</span></td>
                <td><strong class="text-success">{{ number_format($product->price, 2) }}</strong></td>
                <td>
                  @if ($product->stock_quantity > 10)
                    <span class="badge bg-label-success">{{ $product->stock_quantity }} items</span>
                  @elseif($product->stock_quantity > 0)
                    <span class="badge bg-label-warning">{{ $product->stock_quantity }} items</span>
                  @else
                    <span class="badge bg-label-danger">Out of Stock</span>
                  @endif
                </td>
                <td><small class="font-monospace">{{ $product->unit ?? '-' }}</small></td>
                <td class="text-center">
                  <div class="dropdown">
                    <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill" type="button"
                      data-bs-toggle="dropdown">
                      <i class="ri-more-2-line"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{ route('admin.products.edit', $product->id) }}">
                        <i class="ri-edit-line me-2"></i> Edit
                      </a>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal"
                        data-bs-target="#adjustStock{{ $product->id }}">
                        <i class="ri-exchange-line me-2"></i> Adjust Stock
                      </a>
                      <hr class="dropdown-divider">
                      <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger"
                          onclick="return confirm('Are you sure?')">
                          <i class="ri-delete-bin-line me-2"></i> Delete
                        </button>
                      </form>
                    </div>
                  </div>
                </td>
              </tr>

              <!-- Adjust Stock Modal -->
              <div class="modal fade" id="adjustStock{{ $product->id }}" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Adjust Stock - {{ $product->product_name }}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.products.adjust-stock', $product->id) }}" method="POST">
                      @csrf
                      <div class="modal-body">
                        <div class="mb-3">
                          <label class="form-label">Current Stock</label>
                          <input type="text" class="form-control" disabled value="{{ $product->stock_quantity }}">
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Type <span class="text-danger">*</span></label>
                          <select name="type" class="form-select" required>
                            <option value="add">Add Stock</option>
                            <option value="remove">Remove Stock</option>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Quantity <span class="text-danger">*</span></label>
                          <input type="number" name="quantity" class="form-control" required min="1">
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Reason</label>
                          <input type="text" name="reason" class="form-control"
                            placeholder="e.g., Restocking, Damage, etc.">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary"
                          data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Adjust Stock</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            @empty
              <tr>
                <td colspan="8" class="text-center text-muted py-4">
                  <i class="ri-inbox-line" style="font-size: 2rem;"></i><br>
                  No products found
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    @if ($products->hasPages())
      <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
          Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} products
        </div>
        {{ $products->links() }}
      </div>
    @endif
  </div>
@endsection
