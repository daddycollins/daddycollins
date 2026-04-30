@extends('layouts/layoutMaster')

@section('title', 'Order Confirmation')

@section('content')
  <!-- Success Message -->
  @if (session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="row">
    <div class="col-lg-8 mx-auto">
      <!-- Success Card -->
      <div class="card mb-4">
        <div class="card-body text-center py-5">
          <div class="mb-4">
            <i class="ri-checkbox-circle-line text-success" style="font-size: 5rem;"></i>
          </div>
          <h3 class="mb-2">Order Created Successfully!</h3>
          <p class="text-muted mb-4">Your order has been received and is being processed.</p>

          <div class="bg-light rounded p-3 mb-4">
            <div class="row">
              <div class="col-md-4 mb-3 mb-md-0">
                <small class="text-muted d-block">Order Number</small>
                <strong>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong>
              </div>
              <div class="col-md-4 mb-3 mb-md-0">
                <small class="text-muted d-block">Order Date</small>
                <strong>{{ $order->created_at->format('M d, Y') }}</strong>
              </div>
              <div class="col-md-4">
                <small class="text-muted d-block">Total Amount</small>
                <strong class="text-primary">${{ number_format($order->total_amount, 2) }}</strong>
              </div>
            </div>
          </div>

          @if ($order->payment_status === 'unpaid')
            <div class="alert alert-warning">
              <i class="ri-information-line me-2"></i>
              <strong>Payment Pending:</strong> Payment processing will be available soon. You'll receive instructions on how to complete your payment.
            </div>
          @endif
        </div>
      </div>

      <!-- Order Details -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="card-title mb-0">Order Details</h5>
        </div>
        <div class="card-body">
          <!-- Artisan Info -->
          <div class="d-flex align-items-center gap-3 mb-4 pb-4 border-bottom">
            @if ($order->artisan->profile_photo_path)
              <img src="{{ asset('storage/' . $order->artisan->profile_photo_path) }}"
                alt="{{ $order->artisan->user->name }}" class="rounded-circle" width="60" height="60"
                style="object-fit: cover;">
            @else
              <div class="avatar avatar-lg rounded-circle bg-label-primary">
                <span class="avatar-initial fs-4">{{ substr($order->artisan->user->name, 0, 1) }}</span>
              </div>
            @endif
            <div>
              <h6 class="mb-1">{{ $order->artisan->user->name }}</h6>
              <p class="text-muted small mb-0">{{ $order->artisan->business_name }}</p>
              @if ($order->artisan->phone)
                <small><i class="ri-phone-line me-1"></i>{{ $order->artisan->phone }}</small>
              @endif
            </div>
          </div>

          <!-- Items -->
          <h6 class="mb-3">Order Items</h6>
          <div class="table-responsive mb-4">
            <table class="table">
              <thead>
                <tr>
                  <th>Item</th>
                  <th>Type</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th class="text-end">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($order->items as $item)
                  @php
                    $itemDetails = $item->item_type === 'service' ? $item->artisanService : $item->artisanGood;
                    $itemName = $itemDetails ? ($item->item_type === 'service' ? $itemDetails->service_name : $itemDetails->product_name) : 'Item';
                  @endphp
                  <tr>
                    <td>{{ $itemName }}</td>
                    <td>
                      <span class="badge bg-label-{{ $item->item_type === 'service' ? 'info' : 'warning' }}">
                        {{ ucfirst($item->item_type) }}
                      </span>
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td class="text-end">${{ number_format($item->price * $item->quantity, 2) }}</td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                  <td class="text-end">
                    ${{ number_format($order->items->sum(fn($item) => $item->price * $item->quantity), 2) }}</td>
                </tr>
                <tr>
                  <td colspan="4" class="text-end"><strong>Service Fee:</strong></td>
                  <td class="text-end">${{ number_format($order->service_fee ?? 0, 2) }}</td>
                </tr>
                <tr class="table-active">
                  <td colspan="4" class="text-end"><strong>Total:</strong></td>
                  <td class="text-end"><strong class="text-primary">${{ number_format($order->total_amount, 2) }}</strong>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>

          <!-- Addresses -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <h6 class="small text-uppercase text-muted mb-2">Shipping Address</h6>
              <p class="mb-0">{{ $order->shipping_address ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <h6 class="small text-uppercase text-muted mb-2">Billing Address</h6>
              <p class="mb-0">{{ $order->billing_address ?? 'N/A' }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Next Steps -->
      <div class="card">
        <div class="card-body">
          <h6 class="mb-3">What's Next?</h6>
          <ul class="mb-3">
            <li class="mb-2">You'll receive an email confirmation with order details</li>
            <li class="mb-2">The artisan will be notified and will begin processing your order</li>
            <li class="mb-2">You can track your order status from your orders page</li>
            <li class="mb-2">Once completed, you'll be able to leave a review</li>
          </ul>

          <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('user-my-orders') }}" class="btn btn-primary">
              <i class="ri-list-check-2 me-2"></i>View My Orders
            </a>
            <a href="{{ route('user-browse-artisans') }}" class="btn btn-outline-secondary">
              <i class="ri-arrow-left-line me-2"></i>Continue Shopping
            </a>
            @if ($order->artisan->phone)
              <a href="tel:{{ $order->artisan->phone }}" class="btn btn-outline-success">
                <i class="ri-phone-line me-2"></i>Contact Artisan
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
