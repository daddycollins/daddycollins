@extends('layouts/layoutMaster')

@section('title', 'Payment Successful')

@section('content')
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <!-- Success Card -->
        <div class="card">
          <div class="card-body text-center py-5">
            <div style="font-size: 4rem; color: #28a745; margin-bottom: 1rem;">
              <i class="ri-check-double-line"></i>
            </div>
            <h2 class="text-success mb-2">Payment Successful!</h2>
            <p class="text-muted">Your order has been placed and payment has been received.</p>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="card mt-4">
          <div class="card-header bg-light">
            <h6 class="mb-0">Order Details</h6>
          </div>
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-md-6">
                <p class="text-muted mb-1">Order ID</p>
                <h6 class="mb-0 fw-bold">#{{ $order->id }}</h6>
              </div>
              <div class="col-md-6 text-end">
                <p class="text-muted mb-1">Payment Status</p>
                <span class="badge bg-success">PAID</span>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-6">
                <p class="text-muted mb-1">Payment Reference</p>
                <small class="text-monospace d-block mb-3">{{ $order->paynow_reference }}</small>
              </div>
              <div class="col-md-6 text-end">
                <p class="text-muted mb-1">Order Date</p>
                <small>{{ $order->created_at->format('M d, Y \a\t h:i A') }}</small>
              </div>
            </div>
          </div>
        </div>

        <!-- Items -->
        <div class="card mt-4">
          <div class="card-header bg-light">
            <h6 class="mb-0">Items Ordered</h6>
          </div>
          <div class="card-body">
            @foreach ($items as $item)
              <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                <div class="flex-grow-1">
                  <h6 class="mb-1">
                    {{ $item->item_type === 'service'
                        ? $item->artisanService->service_name ?? 'Service'
                        : $item->artisanGood->product_name ?? 'Product' }}
                  </h6>
                  <small class="text-muted">
                    Quantity: <strong>{{ $item->quantity }}</strong> ×
                    <strong>${{ number_format($item->price, 2) }}</strong>
                  </small>
                </div>
                <h6 class="mb-0 text-primary">${{ number_format($item->price * $item->quantity, 2) }}</h6>
              </div>
            @endforeach

            <div class="row mt-4 pt-3 border-top">
              <div class="col-6 text-end">
                <p class="text-muted mb-2">Subtotal:</p>
                <p class="text-muted mb-2">Service Fee (10%):</p>
                <h6 class="mb-0">Total Amount:</h6>
              </div>
              <div class="col-6 text-end">
                <p class="text-muted mb-2">${{ number_format($order->amount, 2) }}</p>
                <p class="text-success mb-2">${{ number_format($order->service_fee, 2) }}</p>
                <h6 class="mb-0 text-primary">${{ number_format($order->total_amount, 2) }}</h6>
              </div>
            </div>
          </div>
        </div>

        <!-- Provider Information -->
        <div class="card mt-4">
          <div class="card-header bg-light">
            <h6 class="mb-0">Service Provider</h6>
          </div>
          <div class="card-body">
            <div class="d-flex align-items-center gap-3 mb-3">
              @if ($order->artisan->profile_photo_path)
                <img src="{{ asset('storage/' . $order->artisan->profile_photo_path) }}"
                  alt="{{ $order->artisan->business_name }}" class="rounded-circle" width="60" height="60"
                  style="object-fit: cover;">
              @else
                <div class="avatar avatar-lg bg-label-primary rounded-circle">
                  <span class="avatar-initial rounded-circle fs-4">
                    {{ substr($order->artisan->business_name, 0, 1) }}
                  </span>
                </div>
              @endif
              <div>
                <h6 class="mb-0 fw-bold">{{ $order->artisan->business_name }}</h6>
                <small class="text-muted d-block">{{ $order->artisan->category }}</small>
                @if ($order->artisan->verified)
                  <span class="badge bg-label-success mt-1">
                    <i class="ri-verified-badge-line me-1"></i>Verified
                  </span>
                @endif
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <p class="text-muted mb-1 small">Phone</p>
                <p class="mb-2">{{ $order->artisan->phone ?? 'Not provided' }}</p>
              </div>
              <div class="col-md-6">
                <p class="text-muted mb-1 small">Location</p>
                <p class="mb-2">{{ $order->artisan->city }}, {{ $order->artisan->province }}</p>
              </div>
            </div>

            <div class="alert alert-info mt-3 mb-0">
              <small>
                <i class="ri-information-line me-2"></i>
                The provider will review your order and contact you shortly to confirm the details.
              </small>
            </div>
          </div>
        </div>

        <!-- Shipping Information (if provided) -->
        @if ($order->shipping_address)
          <div class="card mt-4">
            <div class="card-header bg-light">
              <h6 class="mb-0">Delivery Address</h6>
            </div>
            <div class="card-body">
              <p class="mb-0">{{ $order->shipping_address }}</p>
            </div>
          </div>
        @endif

        <!-- Action Buttons -->
        <div class="d-grid gap-2 mt-4">
          <a href="{{ route('dashboard') ?? '/' }}" class="btn btn-primary btn-lg">
            <i class="ri-dashboard-line me-2"></i>Back to Dashboard
          </a>
          @if (auth()->user()->role === 'artisan')
            <a href="{{ route('artisan-my-orders') ?? '#' }}" class="btn btn-outline-primary">
              <i class="ri-list-check-line me-2"></i>View My Orders
            </a>
          @else
            <a href="{{ route('user-my-orders') ?? '#' }}" class="btn btn-outline-primary">
              <i class="ri-list-check-line me-2"></i>View My Orders
            </a>
          @endif
        </div>

        <!-- Support Section -->
        <div class="card mt-4 border-0 bg-light">
          <div class="card-body text-center py-4">
            <p class="text-muted mb-2">Need help?</p>
            <a href="javascript:;" class="btn btn-sm btn-outline-primary">
              <i class="ri-question-line me-1"></i>Contact Support
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .text-monospace {
      font-family: 'Courier New', monospace;
      font-size: 0.85rem;
    }
  </style>
@endsection
