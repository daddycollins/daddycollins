@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Edit Product - ArtisanConnect')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-6">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="mb-0"><i class="ri-edit-circle-line me-2 text-primary"></i>Edit Product</h4>
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
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST"
              enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <div class="row mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Product Name <span class="text-danger">*</span></label>
                  <input type="text" name="product_name"
                    class="form-control @error('product_name') is-invalid @enderror" required
                    placeholder="Enter product name" value="{{ old('product_name', $product->product_name) }}">
                  @error('product_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Unit <span class="text-muted">(e.g., piece, kg, meter)</span></label>
                  <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror"
                    placeholder="Product unit of measurement" value="{{ old('unit', $product->unit) }}">
                  @error('unit')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <div class="row mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                  <select name="category" class="form-select select2 @error('category') is-invalid @enderror" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                      <option value="{{ $category->name }}" @if ($product->category == $category->name) selected @endif>
                        {{ $category->name }}
                      </option>
                    @endforeach
                  </select>
                  @error('category')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Price (ZWL) <span class="text-danger">*</span></label>
                  <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" required
                    step="0.01" min="0.01" placeholder="0.00" value="{{ old('price', $product->price) }}">
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
                    placeholder="0" value="{{ old('stock_quantity', $product->stock_quantity) }}">
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

              @if ($product->image_path)
                <div class="mb-4">
                  <label class="form-label fw-bold">Current Image</label><br>
                  <img src="{{ asset('storage/' . $product->image_path) }}" alt="Product" class="img-thumbnail"
                    style="max-height: 150px;">
                </div>
              @endif

              <div class="mb-4">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                  placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                @error('description')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>

              <div class="row mt-6">
                <div class="col-12">
                  <button type="submit" class="btn btn-primary me-2">
                    <i class="ri-save-line me-1"></i> Update Product
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
        <div class="card">
          <div class="card-body">
            <h6 class="card-title mb-3"><i class="ri-info-line me-2"></i>Product Info</h6>
            <div class="mb-3">
              <small class="text-muted d-block">Artisan</small>
              <strong>{{ $product->artisan->user->name ?? 'N/A' }}</strong>
            </div>
            <div class="mb-3">
              <small class="text-muted d-block">Created</small>
              <strong>{{ $product->created_at->format('M d, Y H:i') }}</strong>
            </div>
            <div>
              <small class="text-muted d-block">Last Updated</small>
              <strong>{{ $product->updated_at->format('M d, Y H:i') }}</strong>
            </div>
          </div>
        </div>

        <div class="card bg-light mt-4">
          <div class="card-body">
            <h6 class="card-title mb-3"><i class="ri-error-warning-line me-2 text-warning"></i>Danger Zone</h6>
            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-outline-danger w-100"
                onclick="return confirm('Are you sure? This cannot be undone.')">
                <i class="ri-delete-bin-line me-1"></i> Delete Product
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

@section('page-script')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%'
      });
    });
  </script>
@endsection
