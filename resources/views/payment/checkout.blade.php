@extends('layouts/layoutMaster')

@section('title', 'Checkout - ' . ($item->service_name ?? $item->product_name))

@section('content')
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <!-- Display Session Errors/Warnings -->
        @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6 class="alert-heading mb-2">
              <i class="ri-error-warning-line me-2"></i>Validation Errors
            </h6>
            <ul class="mb-0 ps-3">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if (session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ri-checkbox-circle-line me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <!-- Check Authentication -->
        @if (!auth()->check())
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="ri-alert-line me-2"></i>Please <a href="{{ route('login') }}" class="alert-link">log in</a>
            to proceed with checkout.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="card">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
              <i class="ri-shopping-cart-line me-2"></i>Secure Checkout
            </h5>
          </div>
          <div class="card-body">

            <!-- Item Summary -->
            <div class="card bg-light mb-4">
              <div class="card-body">
                <h6 class="card-title mb-3">{{ $itemType === 'service' ? 'Service' : 'Product' }}</h6>
                <div class="row">
                  <div class="col-md-8">
                    <h5 class="mb-2">{{ $item->service_name ?? $item->product_name }}</h5>
                    <p class="text-muted small mb-2">{{ Illuminate\Support\Str::limit($item->description, 100) }}</p>
                    <p class="mb-0"><strong>Provider:</strong> {{ $artisan->business_name }}</p>
                  </div>
                  <div class="col-md-4 text-end">
                    <span class="d-block mb-2"><strong>Qty:</strong> {{ $quantity }}</span>
                    <h6 class="text-primary">${{ number_format($price, 2) }} each</h6>
                  </div>
                </div>
              </div>
            </div>

            <!-- Price Breakdown -->
            <div class="card mb-4 border">
              <div class="card-body">
                <h6 class="card-title mb-3">Price Summary</h6>
                <div class="row mb-3">
                  <div class="col-8">
                    <p class="mb-2">Subtotal ({{ $quantity }} × ${{ number_format($price, 2) }})</p>
                    <p class="mb-2">Service Fee (10%)</p>
                    <hr>
                    <h5 class="mb-0">Total Amount</h5>
                  </div>
                  <div class="col-4 text-end">
                    <p class="mb-2">${{ number_format($subtotal, 2) }}</p>
                    <p class="mb-2 text-success">${{ number_format($serviceFee, 2) }}</p>
                    <hr>
                    <h5 class="mb-0 text-primary">${{ number_format($total, 2) }}</h5>
                  </div>
                </div>
              </div>
            </div>

            <!-- Checkout Form -->
            <form action="{{ route('payment.process') }}" method="POST" id="checkoutForm">
              @csrf

              <input type="hidden" name="item_type" value="{{ $itemType }}">
              <input type="hidden" name="item_id" value="{{ $item->id }}">
              <input type="hidden" name="artisan_id" value="{{ $artisan->id }}">
              <input type="hidden" name="quantity" value="{{ $quantity }}">

              <div class="mb-3">
                <label for="phone" class="form-label">
                  <i class="ri-phone-line me-1"></i>Phone Number <span class="text-danger">*</span>
                </label>
                <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone"
                  name="phone" placeholder="Enter your phone number" value="{{ old('phone') }}" required>
                @error('phone')
                  <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
              </div>

              <div class="mb-3">
                <label for="shipping_address" class="form-label">
                  <i class="ri-map-pin-line me-1"></i>Delivery Address
                </label>
                <textarea class="form-control @error('shipping_address') is-invalid @enderror" id="shipping_address"
                  name="shipping_address" placeholder="Enter delivery address" rows="3">{{ old('shipping_address') }}</textarea>
                @error('shipping_address')
                  <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
              </div>

              <!-- Payment Method Info -->
              <div class="alert alert-info mb-4">
                <small>
                  <i class="ri-information-line me-1"></i>
                  You will be redirected to PayNow to complete your payment securely.
                  Payment will be processed via {{ 'EcoCash' }}.
                </small>
              </div>

              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                  <span id="btnText"><i class="ri-paypal-line me-2"></i>Proceed to Payment
                    (${{ number_format($total, 2) }})</span>
                  <span id="btnLoader" style="display:none;">
                    <span class="spinner-border spinner-border-sm me-2" role="status"
                      aria-hidden="true"></span>Processing...
                  </span>
                </button>
                <a href="javascript:history.back()" class="btn btn-outline-secondary btn-lg">
                  <i class="ri-arrow-left-line me-2"></i>Cancel
                </a>
              </div>
            </form>
          </div>
        </div>

        <!-- Security Badge -->
        <div class="text-center mt-4">
          <small class="text-muted">
            <i class="ri-shield-check-line me-1"></i>Secure payment powered by PayNow
          </small>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
      const phone = document.getElementById('phone').value.trim();

      // Validate phone number
      if (!phone) {
        e.preventDefault();
        alert('Please enter a phone number');
        return false;
      }

      // Show loading state
      const submitBtn = document.getElementById('submitBtn');
      const btnText = document.getElementById('btnText');
      const btnLoader = document.getElementById('btnLoader');

      submitBtn.disabled = true;
      btnText.style.display = 'none';
      btnLoader.style.display = 'inline';

      // Log form data for debugging
      console.log('Form Data:', {
        item_type: document.querySelector('input[name="item_type"]').value,
        item_id: document.querySelector('input[name="item_id"]').value,
        artisan_id: document.querySelector('input[name="artisan_id"]').value,
        quantity: document.querySelector('input[name="quantity"]').value,
        phone: phone,
        shipping_address: document.getElementById('shipping_address').value,
      });

      // Allow form to submit normally
      return true;
    });

    // Show validation errors in console
    window.addEventListener('load', function() {
      console.log('✓ Checkout page loaded successfully');
      console.log('Form ID: checkoutForm');
      console.log('Action URL: {{ route('payment.process') }}');
      console.log('Auth User: {{ auth()->check() ? auth()->user()->name : 'Not authenticated' }}');
    });
  </script>
@endsection
