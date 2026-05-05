@extends('layouts/layoutMaster')

@section('title', 'Edit Product Category - ArtisanConnect')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-6">
      <div class="col-12">
        <h4 class="mb-4"><i class="ri-folder-2-line me-2 text-primary"></i>Edit Product Category</h4>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">{{ $productCategory->name }}</h5>
          </div>
          <form action="{{ route('admin.product-categories.update', $productCategory->id) }}" method="POST"
            class="card-body">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label class="form-label" for="name">Category Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name', $productCategory->name) }}" required>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label class="form-label" for="description">Description</label>
              <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                rows="4">{{ old('description', $productCategory->description) }}</textarea>
              @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                  {{ old('is_active', $productCategory->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">
                  Active
                </label>
              </div>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="ri-save-line me-1"></i>Update Category
              </button>
              <a href="{{ route('admin.product-categories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
