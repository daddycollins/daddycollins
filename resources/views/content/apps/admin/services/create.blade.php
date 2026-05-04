@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Add New Service - ArtisanConnect')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-6">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="mb-0"><i class="ri-add-circle-line me-2 text-primary"></i>Add New Service</h4>
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
            <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
              @csrf

              <div class="row mb-4">
                <div class="col-md-6">
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

                <div class="col-md-6">
                  <label class="form-label fw-bold">Service Status <span class="text-danger">*</span></label>
                  <select name="availability" class="form-select @error('availability') is-invalid @enderror" required>
                    <option value="">Select Status</option>
                    <option value="available" @if (old('availability') == 'available') selected @endif>Available</option>
                    <option value="unavailable" @if (old('availability') == 'unavailable') selected @endif>Unavailable</option>
                  </select>
                  @error('availability')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <div class="row mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Service Name <span class="text-danger">*</span></label>
                  <input type="text" name="service_name"
                    class="form-control @error('service_name') is-invalid @enderror" required
                    placeholder="Enter service name" value="{{ old('service_name') }}">
                  @error('service_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                  <input type="text" name="category" class="form-control @error('category') is-invalid @enderror"
                    required placeholder="e.g., Home Repair, Cleaning" value="{{ old('category') }}">
                  @error('category')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                  placeholder="Enter service description">{{ old('description') }}</textarea>
                @error('description')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>

              <div class="row mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Price Estimate (ZWL) <span class="text-danger">*</span></label>
                  <input type="number" name="price_estimate"
                    class="form-control @error('price_estimate') is-invalid @enderror" required step="0.01"
                    min="0" placeholder="0.00" value="{{ old('price_estimate') }}">
                  @error('price_estimate')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Rate Type <span class="text-danger">*</span></label>
                  <select name="rate_type" class="form-select @error('rate_type') is-invalid @enderror" required>
                    <option value="">Select Rate Type</option>
                    <option value="per_minute" @if (old('rate_type') == 'per_minute') selected @endif>Per Minute</option>
                    <option value="per_hour" @if (old('rate_type') == 'per_hour') selected @endif>Per Hour</option>
                    <option value="per_day" @if (old('rate_type') == 'per_day') selected @endif>Per Day</option>
                    <option value="per_week" @if (old('rate_type') == 'per_week') selected @endif>Per Week</option>
                    <option value="per_month" @if (old('rate_type') == 'per_month') selected @endif>Per Month</option>
                    <option value="per_project" @if (old('rate_type') == 'per_project') selected @endif>Per Project</option>
                    <option value="fixed" @if (old('rate_type') == 'fixed') selected @endif>Fixed Rate</option>
                  </select>
                  @error('rate_type')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
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
              </div>

              <div class="row mt-6">
                <div class="col-12">
                  <button type="submit" class="btn btn-primary me-2">
                    <i class="ri-save-line me-1"></i> Create Service
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
        <div class="card bg-light">
          <div class="card-body">
            <h6 class="card-title mb-3"><i class="ri-information-line me-2 text-info"></i>Service Creation Tips</h6>
            <ul class="list-unstyled small text-muted">
              <li class="mb-2"><i class="ri-check-line text-success me-2"></i>Use clear, descriptive service names
              </li>
              <li class="mb-2"><i class="ri-check-line text-success me-2"></i>Set realistic price estimates</li>
              <li class="mb-2"><i class="ri-check-line text-success me-2"></i>Add detailed descriptions to attract
                clients</li>
              <li class="mb-2"><i class="ri-check-line text-success me-2"></i>Update availability regularly</li>
              <li><i class="ri-check-line text-success me-2"></i>Use high-quality service images</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
