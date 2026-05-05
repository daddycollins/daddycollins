@extends('layouts/layoutMaster')

@section('title', 'Bid Checkout')

@section('content')
  <div class="container py-5">
    <div class="row">
      <!-- Left: Bid Details -->
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-header bg-light d-flex align-items-center">
            <i class="ri-briefcase-line me-3 text-primary" style="font-size: 1.5rem;"></i>
            <div>
              <h5 class="mb-0">Requirement: {{ $bid->requirement->title }}</h5>
              <small class="text-muted">Awarded to: {{ $bid->artisan->name }}</small>
            </div>
          </div>
          <div class="card-body">
            <div class="row mb-4">
              <div class="col-md-6">
                <p class="text-muted small mb-1">Requirement Category</p>
                <p class="fw-semibold">{{ $bid->requirement->category ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6">
                <p class="text-muted small mb-1">Bid Status</p>
                <span class="badge bg-label-success me-0">Accepted</span>
              </div>
            </div>

            <div class="row mb-4">
              <div class="col-md-6">
                <p class="text-muted small mb-1">Requirement Description</p>
                <p>{{ $bid->requirement->description }}</p>
              </div>
              <div class="col-md-6">
                <p class="text-muted small mb-1">Artisan's Proposal</p>
                <p>{{ $bid->proposal ?? 'No proposal provided' }}</p>
              </div>
            </div>

            <hr>

            <!-- Service Provider Info -->
            <div class="row mt-4">
              <div class="col-12">
                <p class="text-muted small mb-3">Service Provider</p>
                <div class="d-flex align-items-center">
                  @if (optional($bid->artisan->artisanProfile)->profile_photo_path)
                    <img src="{{ asset('storage/' . $bid->artisan->artisanProfile->profile_photo_path) }}" alt="Profile"
                      width="60" height="60" class="rounded-circle me-3">
                  @else
                    <div class="avatar-initial rounded-circle bg-primary text-white me-3"
                      style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                      {{ substr($bid->artisan->name, 0, 1) }}
                    </div>
                  @endif
                  <div>
                    <h6 class="mb-0">{{ $bid->artisan->name }}</h6>
                    <small
                      class="text-muted">{{ optional($bid->artisan->artisanProfile)->category ?? 'Service Provider' }}</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Payment Form -->
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">Billing Information</h5>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('bids.payment', $bid) }}">
              @csrf

              <div class="mb-4">
                <label class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                  placeholder="256700000000" value="{{ old('phone') }}" required>
                <small class="text-muted d-block mt-2">Used for Paynow payment verification</small>
                @error('phone')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-4">
                <label class="form-label fw-semibold">Shipping Address <span class="text-muted">(Optional)</span></label>
                <textarea name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" rows="3"
                  placeholder="Enter delivery address..." maxlength="500">{{ old('shipping_address') }}</textarea>
                @error('shipping_address')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              <div class="d-flex gap-2">
                <a href="{{ route('requirements.show', $bid->requirement) }}" class="btn btn-outline-secondary">
                  <i class="ri-arrow-left-line me-2"></i>Back to Requirement
                </a>
                <button type="submit" class="btn btn-primary ms-auto">
                  <i class="ri-secure-payment-line me-2"></i>Proceed to Payment
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Right: Order Summary -->
      <div class="col-lg-4">
        <div class="card sticky-top" style="top: 20px;">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Payment Summary</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <div class="d-flex justify-content-between mb-2">
                <span>Bid Amount</span>
                <span class="fw-semibold">${{ number_format($subtotal, 2) }}</span>
              </div>
              <div class="d-flex justify-content-between mb-3">
                <span>Service Fee (10%)</span>
                <span class="fw-semibold">${{ number_format($serviceFee, 2) }}</span>
              </div>

              <hr>

              <div class="d-flex justify-content-between">
                <span class="fw-bold">Total Amount</span>
                <span class="fw-bold text-primary" style="font-size: 1.25rem;">
                  ${{ number_format($total, 2) }}
                </span>
              </div>
            </div>

            <div class="alert alert-info small mb-0" role="alert">
              <i class="ri-information-line me-2"></i>
              <strong>Note:</strong> You will be redirected to Paynow to complete the payment securely.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
