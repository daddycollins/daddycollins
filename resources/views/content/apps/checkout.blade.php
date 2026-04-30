@extends('layouts/layoutMaster')

@section('title', 'Checkout')

@section('content')
  <!-- Flash Messages -->
  @if (session('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="row">
    <div class="col-12 mb-4">
      <h4><i class="ri-secure-payment-line me-2"></i>Checkout</h4>
      <p class="text-muted">Complete your order with {{ $cart->artisan->business_name }}</p>
    </div>
  </div>

  <form action="{{ route('checkout.process', $cart->id) }}" method="POST">
    @csrf
    <div class="row">
      <!-- Left Column - Checkout Form -->
      <div class="col-lg-8 mb-4">
        <!-- Shipping Address -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="card-title mb-0">
              <i class="ri-map-pin-line me-2"></i>Shipping Address
            </h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label for="shipping_address" class="form-label">Full Address <span class="text-danger">*</span></label>
              <textarea name="shipping_address" id="shipping_address" class="form-control" rows="3" required
                placeholder="Enter your full shipping address">{{ old('shipping_address') }}</textarea>
              <small class="text-muted">Include street address, city, and any relevant landmarks</small>
            </div>
          </div>
        </div>

        <!-- Billing Address -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="card-title mb-0">
              <i class="ri-bill-line me-2"></i>Billing Address
            </h5>
          </div>
          <div class="card-body">
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" id="sameAsShipping">
              <label class="form-check-label" for="sameAsShipping">
                Same as shipping address
              </label>
            </div>
            <div class="mb-3">
              <label for="billing_address" class="form-label">Full Address <span class="text-danger">*</span></label>
              <textarea name="billing_address" id="billing_address" class="form-control" rows="3" required
                placeholder="Enter your billing address">{{ old('billing_address') }}</textarea>
            </div>
          </div>
        </div>

        <!-- Payment Information -->
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">
              <i class="ri-smartphone-line me-2"></i>Payment Information
            </h5>
          </div>
          <div class="card-body">
            <div class="alert alert-info mb-3">
              <i class="ri-information-line me-2"></i>
              <small>Payment will be processed via Paynow. You can use EcoCash, OneMoney, or other mobile money
                services.</small>
            </div>

            <div class="mb-3">
              <label for="phone" class="form-label">Mobile Number <span class="text-danger">*</span></label>
              <input type="tel" name="phone" id="phone" class="form-control" required
                placeholder="07XXXXXXXX or 02637XXXXXXX" value="{{ old('phone', auth()->user()->phone ?? '') }}">
              <small class="text-muted">Enter the mobile number you'll use for payment</small>
            </div>

            <div class="mb-3">
              <label class="form-label">Payment Method</label>
              <div class="border rounded p-3 bg-light">
                <div class="d-flex align-items-center">
                  <i class="ri-smartphone-line fs-3 text-primary me-3"></i>
                  <div>
                    <strong>Paynow Mobile Payment</strong>
                    <p class="text-muted small mb-0">Supports EcoCash, OneMoney, Telecash</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column - Order Summary -->
      <div class="col-lg-4 mb-4">
        <div class="card sticky-top" style="top: 90px;">
          <div class="card-header">
            <h5 class="card-title mb-0">Order Summary</h5>
          </div>
          <div class="card-body">
            <!-- Artisan Info -->
            <div class="d-flex align-items-center gap-3 mb-4 pb-4 border-bottom">
              @if ($cart->artisan->profile_photo_path)
                <img src="{{ asset('storage/' . $cart->artisan->profile_photo_path) }}"
                  alt="{{ $cart->artisan->user->name }}" class="rounded-circle" width="48" height="48"
                  style="object-fit: cover;">
              @else
                <div class="avatar avatar-md rounded-circle bg-label-primary">
                  <span class="avatar-initial">{{ substr($cart->artisan->user->name, 0, 1) }}</span>
                </div>
              @endif
              <div>
                <h6 class="mb-0">{{ $cart->artisan->user->name }}</h6>
                <small class="text-muted">{{ $cart->artisan->business_name }}</small>
              </div>
            </div>

            <!-- Order Items -->
            <div class="mb-4">
              <h6 class="small text-uppercase text-muted mb-3">Items ({{ $cart->items->count() }})</h6>
              @foreach ($cart->items as $item)
                @php
                  $itemDetails = $item->item_type === 'service' ? $item->artisanService : $item->artisanGood;
                @endphp
                <div class="d-flex justify-content-between mb-2">
                  <div>
                    <span class="badge bg-label-{{ $item->item_type === 'service' ? 'info' : 'warning' }} me-1">
                      {{ ucfirst($item->item_type) }}
                    </span>
                    <small>{{ $item->item_name }}</small>
                    @if ($item->quantity > 1)
                      <small class="text-muted">x{{ $item->quantity }}</small>
                    @endif
                  </div>
                  <small class="fw-semibold">${{ number_format($item->price * $item->quantity, 2) }}</small>
                </div>
              @endforeach
            </div>

            <!-- Price Breakdown -->
            <div class="border-top pt-3">
              <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Subtotal:</span>
                <span>${{ number_format($totals['subtotal'], 2) }}</span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Service Fee (10%):</span>
                <span>${{ number_format($totals['service_fee'], 2) }}</span>
              </div>
              <hr>
              <div class="d-flex justify-content-between mb-4">
                <strong>Total:</strong>
                <strong class="text-primary fs-5">${{ number_format($totals['total'], 2) }}</strong>
              </div>

              <button type="submit" class="btn btn-primary w-100 mb-2">
                <i class="ri-secure-payment-line me-2"></i>Complete Order
              </button>
              <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100">
                <i class="ri-arrow-left-line me-2"></i>Back to Cart
              </a>

              <div class="alert alert-warning mt-3 small mb-0">
                <i class="ri-information-line me-1"></i>
                You'll be redirected to Paynow to complete the payment securely.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Same as shipping address checkbox
      const sameAsShippingCheckbox = document.getElementById('sameAsShipping');
      const shippingAddress = document.getElementById('shipping_address');
      const billingAddress = document.getElementById('billing_address');

      sameAsShippingCheckbox.addEventListener('change', function() {
        if (this.checked) {
          billingAddress.value = shippingAddress.value;
          billingAddress.setAttribute('readonly', true);
        } else {
          billingAddress.removeAttribute('readonly');
        }
      });

      // Update billing if shipping changes and checkbox is checked
      shippingAddress.addEventListener('input', function() {
        if (sameAsShippingCheckbox.checked) {
          billingAddress.value = this.value;
        }
      });
    });
  </script>
@endsection
