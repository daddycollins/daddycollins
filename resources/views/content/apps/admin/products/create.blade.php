@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Add Product - ArtisanConnect')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-6">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="mb-0"><i class="ri-add-circle-line me-2 text-primary"></i>Add New Product</h4>
          <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="ri-arrow-left-line me-1"></i> Back
          </a>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
              @csrf

              <div class="mb-4">
                <label class="form-label fw-bold">Artisan <span class="text-danger">*</span></label>
                <select name="artisan_id" class="form-select @error('artisan_id') is-invalid @enderror" required>
                  <option value="">Select Artisan</option>
                  @foreach ($artisans as $artisan)
                    <option value="{{ $artisan->id }}" @if (old('artisan_id') == $artisan->id) selected @endif>
                      {{ $artisan->user->name ?? 'N/A' }}
                    </option>
                  @endforeach
                </select>
                @error('artisan_id')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>

              <div class="row mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
                  <input type="text" name="product_name"
                    class="form-control @error('product_name') is-invalid @enderror" required
                    placeholder="Enter product name" value="{{ old('product_name') }}">
                  @error('product_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Unit <span class="text-muted">(e.g., piece, kg, meter)</span></label>
                  <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror"
                    placeholder="Product unit of measurement" value="{{ old('unit') }}">
                  @error('unit')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <div class="row mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                  <input type="text" name="category" class="form-control @error('category') is-invalid @enderror"
                    required placeholder="e.g., Electronics, Furniture" value="{{ old('category') }}">
                  @error('category')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Price (ZWL) <span class="text-danger">*</span></label>
                  <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                    required step="0.01" min="0.01" placeholder="0.00" value="{{ old('price') }}">
                  @error('price')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <div class="row mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Stock Quantity <span class="text-danger">*</span></label>
                  <input type="number" name="stock_quantity"
                    class="form-control @error('stock_quantity') is-invalid @enderror" required min="0"
                    placeholder="0" value="{{ old('stock_quantity', 0) }}">
                  @error('stock_quantity')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Product Image</label>
                  <input type="file" name="image_path" class="form-control @error('image_path') is-invalid @enderror"
                    accept="image/*">
                  <small class="text-muted">Max 2MB (JPEG, PNG, GIF)</small>
                  @error('image_path')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                  placeholder="Enter product description">{{ old('description') }}</textarea>
                @error('description')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>

              <div class="row mt-6">
                <div class="col-12">
                  <button type="submit" class="btn btn-primary me-2">
                    <i class="ri-save-line me-1"></i> Add Product
                  </button>
                  <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                    <i class="ri-close-line me-1"></i> Cancel
                  </a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card bg-light">
          <div class="card-body">
            <h6 class="card-title mb-3"><i class="ri-information-line me-2 text-info"></i>Product Guidelines</h6>
            <ul class="list-unstyled small text-muted">
              <li class="mb-2"><i class="ri-check-line text-success me-2"></i>Use clear product names</li>
              <li class="mb-2"><i class="ri-check-line text-success me-2"></i>Set accurate stock quantities</li>
              <li class="mb-2"><i class="ri-check-line text-success me-2"></i>Add detailed descriptions</li>
              <li><i class="ri-check-line text-success me-2"></i>Use high-quality product images</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
