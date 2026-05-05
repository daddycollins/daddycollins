@extends('layouts/layoutMaster')

@section('title', 'Edit Product Unit - ArtisanConnect')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-6">
      <div class="col-12">
        <h4 class="mb-4"><i class="ri-ruler-line me-2 text-primary"></i>Edit Product Unit</h4>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">{{ $productUnit->name }}</h5>
          </div>
          <form action="{{ route('admin.product-units.update', $productUnit->id) }}" method="POST" class="card-body">
            @csrf
            @method('PUT')

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label" for="name">Unit Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                  name="name" value="{{ old('name', $productUnit->name) }}" required>
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label" for="abbreviation">Abbreviation <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('abbreviation') is-invalid @enderror" id="abbreviation"
                  name="abbreviation" value="{{ old('abbreviation', $productUnit->abbreviation) }}" required>
                @error('abbreviation')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label" for="description">Description</label>
              <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                rows="3">{{ old('description', $productUnit->description) }}</textarea>
              @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                  {{ old('is_active', $productUnit->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">
                  Active
                </label>
              </div>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="ri-save-line me-1"></i>Update Unit
              </button>
              <a href="{{ route('admin.product-units.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
