@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Edit Service - ArtisanConnect')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-6">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="mb-0"><i class="ri-edit-circle-line me-2 text-primary"></i>Edit Service</h4>
          <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
            <i class="ri-arrow-left-line me-1"></i> Back
          </a>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.services.update', $service->id) }}" method="POST"
              enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <div class="row mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Service Name <span class="text-danger">*</span></label>
                  <input type="text" name="service_name"
                    class="form-control @error('service_name') is-invalid @enderror" required
                    placeholder="Enter service name" value="{{ old('service_name', $service->service_name) }}">
                  @error('service_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                  <input type="text" name="category" class="form-control @error('category') is-invalid @enderror"
                    required placeholder="e.g., Home Repair, Cleaning" value="{{ old('category', $service->category) }}">
                  @error('category')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <div class="row mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Price Estimate (ZWL) <span class="text-danger">*</span></label>
                  <input type="number" name="price_estimate"
                    class="form-control @error('price_estimate') is-invalid @enderror" required step="0.01"
                    min="0" placeholder="0.00" value="{{ old('price_estimate', $service->price_estimate) }}">
                  @error('price_estimate')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Service Status <span class="text-danger">*</span></label>
                  <select name="availability" class="form-select @error('availability') is-invalid @enderror" required>
                    <option value="">Select Status</option>
                    <option value="available" @if (old('availability', $service->availability) == 'available') selected @endif>Available</option>
                    <option value="unavailable" @if (old('availability', $service->availability) == 'unavailable') selected @endif>Unavailable</option>
                  </select>
                  @error('availability')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                  placeholder="Enter service description">{{ old('description', $service->description) }}</textarea>
                @error('description')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>

              <div class="row mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Service Image</label>
                  <input type="file" name="image_path" class="form-control @error('image_path') is-invalid @enderror"
                    accept="image/*">
                  <small class="text-muted">Max 2MB (JPEG, PNG, GIF)</small>
                  @error('image_path')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                  @enderror
                </div>
                @if ($service->image_path)
                  <div class="col-md-6">
                    <label class="form-label fw-bold">Current Image</label>
                    <img src="{{ asset('storage/' . $service->image_path) }}" alt="Service" class="img-thumbnail"
                      style="max-height: 150px;">
                  </div>
                @endif
              </div>

              <div class="row mt-6">
                <div class="col-12">
                  <button type="submit" class="btn btn-primary me-2">
                    <i class="ri-save-line me-1"></i> Update Service
                  </button>
                  <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
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
            <h6 class="card-title mb-3"><i class="ri-info-line me-2"></i>Service Info</h6>
            <div class="mb-3">
              <small class="text-muted d-block">Artisan</small>
              <strong>{{ $service->artisan->user->name ?? 'N/A' }}</strong>
            </div>
            <div class="mb-3">
              <small class="text-muted d-block">Created</small>
              <strong>{{ $service->created_at->format('M d, Y H:i') }}</strong>
            </div>
            <div>
              <small class="text-muted d-block">Last Updated</small>
              <strong>{{ $service->updated_at->format('M d, Y H:i') }}</strong>
            </div>
          </div>
        </div>

        <div class="card bg-light mt-4">
          <div class="card-body">
            <h6 class="card-title mb-3"><i class="ri-error-warning-line me-2 text-warning"></i>Danger Zone</h6>
            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-outline-danger w-100"
                onclick="return confirm('Are you sure? This cannot be undone.')">
                <i class="ri-delete-bin-line me-1"></i> Delete Service
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
