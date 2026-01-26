@extends('layouts/layoutMaster')

@section('title', 'Order Details - ' . $order->id)

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/tagify/tagify.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/select2/select2.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/cleave-zen/cleave-zen.js', 'resources/assets/vendor/libs/tagify/tagify.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/select2/select2.js'])
@endsection

@section('page-script')
  @vite(['resources/assets/js/app-ecommerce-order-details.js', 'resources/assets/js/modal-add-new-address.js', 'resources/assets/js/modal-edit-user.js'])
@endsection

@section('content')
  <!-- Order Header -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 gap-6">
    <div class="d-flex flex-column justify-content-center">
      <div class="d-flex align-items-center mb-1">
        <h5 class="mb-0">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h5>

        <!-- Payment Status Badge -->
        @php
          $paymentBadgeClass = match ($order->payment_status) {
              'paid' => 'bg-label-success',
              'pending' => 'bg-label-warning',
              'unpaid' => 'bg-label-danger',
              default => 'bg-label-secondary',
          };
          $paymentStatusText = match ($order->payment_status) {
              'paid' => 'Paid',
              'pending' => 'Pending',
              'unpaid' => 'Unpaid',
              default => $order->payment_status,
          };
        @endphp
        <span class="badge {{ $paymentBadgeClass }} me-2 ms-2 rounded-pill">{{ ucfirst($paymentStatusText) }}</span>

        <!-- Order Status Badge -->
        @php
          $statusBadgeClass = match ($order->status) {
              'pending' => 'bg-label-secondary',
              'processing' => 'bg-label-info',
              'paid' => 'bg-label-primary',
              'completed' => 'bg-label-success',
              'cancelled' => 'bg-label-danger',
              default => 'bg-label-secondary',
          };
          $statusText = match ($order->status) {
              'pending' => 'Pending',
              'processing' => 'Processing',
              'paid' => 'Paid',
              'completed' => 'Completed',
              'cancelled' => 'Cancelled',
              default => $order->status,
          };
        @endphp
        <span class="badge {{ $statusBadgeClass }} rounded-pill">{{ $statusText }}</span>
      </div>
      <p class="mb-0">{{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-2">
      <button class="btn btn-outline-danger delete-order">Delete Order</button>
    </div>
  </div>

  <!-- Order Details Table -->
  <div class="row">
    <div class="col-12 col-lg-8">
      <div class="card mb-6">
        <div class="card-header">
          <h5 class="card-title m-0">Order Items</h5>
        </div>
        <div class="table-responsive">
          <table class="table mb-0">
            <thead>
              <tr>
                <th class="w-50">Service</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @forelse($order->items as $item)
                <tr>
                  <td>
                    @if ($item->artisanService)
                      <div class="d-flex align-items-center">
                        @if ($item->artisanService->image_path)
                          <img src="{{ asset('storage/' . $item->artisanService->image_path) }}"
                            alt="{{ $item->artisanService->service_name }}" class="img-fluid rounded me-3"
                            style="width: 50px; height: 50px; object-fit: cover;">
                        @endif
                        <div>
                          <h6 class="mb-0">{{ $item->artisanService->service_name }}</h6>
                          <small class="text-muted">{{ $item->artisanService->category ?? 'Service' }}</small>
                        </div>
                      </div>
                    @else
                      <span class="text-muted">Item #{{ $item->item_id }}</span>
                    @endif
                  </td>
                  <td>${{ number_format($item->price, 2) }}</td>
                  <td>{{ $item->quantity }}</td>
                  <td><strong>${{ number_format($item->price * $item->quantity, 2) }}</strong></td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center text-muted py-4">No items in this order</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Order Calculations -->
        <div class="d-flex justify-content-end align-items-center m-4 p-1 mb-0 pb-0">
          <div class="order-calculations">
            <div class="d-flex justify-content-start gap-4">
              <span class="w-px-100 text-heading">Subtotal:</span>
              <h6 class="mb-0">${{ number_format($subtotal, 2) }}</h6>
            </div>
            <div class="d-flex justify-content-start gap-4">
              <span class="w-px-100 text-heading">Tax:</span>
              <h6 class="mb-0">${{ number_format($tax, 2) }}</h6>
            </div>
            <div class="d-flex justify-content-start gap-4">
              <h6 class="w-px-100 mb-0">Total:</h6>
              <h6 class="mb-0">${{ number_format($total, 2) }}</h6>
            </div>
          </div>
        </div>
      </div>

      <!-- Shipping Activity Timeline -->
      <div class="card mb-6">
        <div class="card-header">
          <h5 class="card-title m-0">Order Activity</h5>
        </div>
        <div class="card-body mt-3">
          <ul class="timeline pb-0 mb-0">
            @foreach ($timeline as $index => $event)
              <li
                class="timeline-item timeline-item-transparent border-primary {{ $index === count($timeline) - 1 ? 'border-transparent pb-0' : '' }}">
                <span class="timeline-point timeline-point-primary"></span>
                <div class="timeline-event {{ $index === count($timeline) - 1 ? 'pb-0' : '' }}">
                  <div class="timeline-header mb-2">
                    <h6 class="mb-0">{{ $event['status'] }}</h6>
                    <small class="text-body-secondary">{{ $event['date']->format('l h:i A') }}</small>
                  </div>
                  <p class="mt-1 mb-2">
                    @switch($event['status'])
                      @case('Order Placed')
                        Your order has been placed successfully
                      @break

                      @case('Processing')
                        Your order is being prepared by the artisan
                      @break

                      @case('Ready for Pickup')
                        Your order is ready for pickup or delivery
                      @break

                      @case('Completed')
                        Order has been completed and delivered
                      @break

                      @default
                        Order status updated
                    @endswitch
                  </p>
                </div>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="col-12 col-lg-4">
      <!-- Customer Details Card -->
      <div class="card mb-6">
        <div class="card-body">
          <h5 class="card-title mb-6">Customer Details</h5>
          <div class="d-flex justify-content-start align-items-center mb-6">
            <div class="avatar me-3">
              @if ($order->client->profile_photo_path)
                <img src="{{ asset('storage/' . $order->client->profile_photo_path) }}" alt="{{ $order->client->name }}"
                  class="rounded-circle" />
              @else
                <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle" />
              @endif
            </div>
            <div class="d-flex flex-column">
              <h6 class="mb-0">{{ $order->client->name }}</h6>
              <span>Customer ID: #{{ str_pad($order->client->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
          </div>
          <div class="d-flex justify-content-start align-items-center mb-6">
            <span class="avatar rounded-circle bg-label-success me-3 d-flex align-items-center justify-content-center">
              <i class="icon-base ri ri-shopping-cart-line icon-24px"></i>
            </span>
            <h6 class="text-nowrap mb-0">{{ $order->client->orders()->count() }} Orders</h6>
          </div>
          <div class="d-flex justify-content-between">
            <h6 class="mb-1">Contact Info</h6>
          </div>
          <p class="mb-1">Email: {{ $order->client->email }}</p>
          <p class="mb-0">Phone: {{ $order->client->phone ?? 'Not provided' }}</p>
        </div>
      </div>

      <!-- Artisan Details Card -->
      <div class="card mb-6">
        <div class="card-body">
          <h5 class="card-title mb-6">Artisan Details</h5>
          <div class="d-flex justify-content-start align-items-center mb-6">
            <div class="avatar me-3">
              @if ($order->artisan->profile_photo_path)
                <img src="{{ asset('storage/' . $order->artisan->profile_photo_path) }}"
                  alt="{{ $order->artisan->user->name }}" class="rounded-circle" />
              @else
                <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Avatar" class="rounded-circle" />
              @endif
            </div>
            <div class="d-flex flex-column">
              <h6 class="mb-0">{{ $order->artisan->user->name }}</h6>
              <small class="text-muted">
                @if ($order->artisan->verified)
                  <i class="ri ri-verify-badge-fill text-success"></i> Verified
                @else
                  <i class="ri ri-close-circle-line text-danger"></i> Not Verified
                @endif
              </small>
            </div>
          </div>
          @if ($order->artisan->average_rating)
            <div class="d-flex align-items-center mb-3">
              <span class="badge bg-label-warning me-2">⭐ {{ number_format($order->artisan->average_rating, 1) }}</span>
              <small class="text-muted">Average Rating</small>
            </div>
          @endif
        </div>
      </div>

      <!-- Shipping Address Card -->
      <div class="card mb-6">
        <div class="card-header d-flex justify-content-between">
          <h5 class="card-title mb-1">Shipping Address</h5>
        </div>
        <div class="card-body">
          <p class="mb-0">{{ nl2br(e($shippingAddress)) }}</p>
        </div>
      </div>

      <!-- Billing Address Card -->
      <div class="card mb-6">
        <div class="card-header d-flex justify-content-between pb-0">
          <h5 class="card-title mb-1">Billing Address</h5>
        </div>
        <div class="card-body">
          <p class="mb-3">{{ nl2br(e($billingAddress)) }}</p>
          @if ($order->payment_method)
            <h6 class="mb-1">{{ ucfirst($order->payment_method) }}</h6>
            <p class="mb-0">Payment Method</p>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Modals -->
  @include('_partials/_modals/modal-edit-user')
  @include('_partials/_modals/modal-add-new-address')

@endsection
