@extends('layouts/layoutMaster')

@section('title', 'Create Product Category - ArtisanConnect')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-6">
      <div class="col-12">
        <h4 class="mb-4"><i class="ri-folder-2-line me-2 text-primary"></i>Create Product Category</h4>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">Category Details</h5>
          </div>
          <form action="{{ route('admin.product-categories.store') }}" method="POST" class="card-body">
            @csrf

            <div class="mb-3">
              <label class="form-label" for="name">Category Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name') }}" required>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label class="form-label" for="description">Description</label>
              <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                rows="4">{{ old('description') }}</textarea>
              @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                  {{ old('is_active') ? 'checked' : '' }} checked>
                <label class="form-check-label" for="is_active">
                  Active
                </label>
              </div>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="ri-save-line me-1"></i>Create Category
              </button>
              <a href="{{ route('admin.product-categories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
