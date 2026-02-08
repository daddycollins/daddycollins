@extends('layouts/layoutMaster')

@section('title', 'Track Order - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/apex-charts/apexcharts.js'])
@endsection

@section('page-script')
  @vite(['resources/assets/js/app-ecommerce-order-list.js'])
@endsection

@section('content')
  <!-- Page Header -->
  <div class="row mb-6">
    <div class="col-12">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h4 class="mb-2">Track Order</h4>
          <p class="text-muted mb-0">Monitor your order progress in real-time</p>
        </div>
        <a href="{{ route('user-order-details', $order->id) }}" class="btn btn-outline-primary">View Details</a>
      </div>
    </div>
  </div>

  <!-- Order Summary -->
  <div class="row g-6 mb-6">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <h6 class="mb-3">Order Information</h6>
              <div class="mb-3">
                <span class="text-muted small">Order ID:</span>
                <p class="mb-0"><strong>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong></p>
              </div>
              <div class="mb-3">
                <span class="text-muted small">Order Date:</span>
                <p class="mb-0"><strong>{{ $order->created_at->format('M d, Y H:i A') }}</strong></p>
              </div>
              <div class="mb-3">
                <span class="text-muted small">Order Total:</span>
                <p class="mb-0"><strong>${{ number_format($order->total_amount ?? 0, 2) }}</strong></p>
              </div>
            </div>
            <div class="col-md-6">
              <h6 class="mb-3">Artisan Information</h6>
              <div class="mb-3">
                <span class="text-muted small">Artisan Name:</span>
                <p class="mb-0 d-flex align-items-center gap-2">
                <div class="avatar avatar-sm">
                  <img
                    src="{{ $order->artisan->profile_photo_path ? asset('storage/' . $order->artisan->profile_photo_path) : asset('assets/img/avatars/1.png') }}"
                    alt="Avatar" class="rounded-circle" />
                </div>
                <strong>{{ $order->artisan->user->name ?? 'Unknown' }}</strong>
                </p>
              </div>
              <div class="mb-3">
                <span class="text-muted small">Business Name:</span>
                <p class="mb-0"><strong>{{ $order->artisan->business_name ?? 'N/A' }}</strong></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Order Status Timeline -->
  <div class="row g-6 mb-6">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Order Status Timeline</h5>
        </div>
        <div class="card-body">
          @php
            $statuses = [
                'paid' => ['label' => 'Payment Confirmed', 'icon' => 'ri ri-bank-card-line', 'color' => 'success'],
                'processing' => ['label' => 'In Progress', 'icon' => 'ri ri-settings-4-line', 'color' => 'info'],
                'completed' => ['label' => 'Completed', 'icon' => 'ri ri-check-double-line', 'color' => 'success'],
                'cancelled' => ['label' => 'Cancelled', 'icon' => 'ri ri-close-circle-line', 'color' => 'danger'],
            ];

            $currentStatus = $order->status;
            $paymentStatus = $order->payment_status;
          @endphp

          <div class="timeline">
            <!-- Payment Status -->
            <div class="timeline-item">
              <span
                class="timeline-point 
                @if ($paymentStatus === 'paid') bg-success
                @elseif($paymentStatus === 'unpaid')
                  bg-warning
                @else
                  bg-secondary @endif
              "></span>
              <div class="timeline-event">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h6 class="mb-0">
                    @if ($paymentStatus === 'paid')
                      Payment Confirmed
                    @else
                      Payment Pending
                    @endif
                  </h6>
                  <span
                    class="badge 
                    @if ($paymentStatus === 'paid') bg-label-success
                    @elseif($paymentStatus === 'unpaid')
                      bg-label-warning
                    @else
                      bg-label-secondary @endif
                  ">
                    {{ ucfirst($paymentStatus) }}
                  </span>
                </div>
                <p class="text-muted mb-0">
                  @if ($paymentStatus === 'paid')
                    Your payment has been successfully processed
                  @else
                    Awaiting payment confirmation
                  @endif
                </p>
              </div>
            </div>

            <!-- Processing Status -->
            <div class="timeline-item">
              <span
                class="timeline-point 
                @if (in_array($currentStatus, ['processing', 'completed'])) bg-info
                @else
                  bg-secondary @endif
              "></span>
              <div class="timeline-event">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h6 class="mb-0">In Progress</h6>
                  <span
                    class="badge 
                    @if (in_array($currentStatus, ['processing', 'completed'])) bg-label-info
                    @else
                      bg-label-secondary @endif
                  ">
                    {{ in_array($currentStatus, ['processing', 'completed']) ? 'Active' : 'Waiting' }}
                  </span>
                </div>
                <p class="text-muted mb-0">
                  @if (in_array($currentStatus, ['processing', 'completed']))
                    Your artisan is working on your order
                  @else
                    Waiting for payment confirmation
                  @endif
                </p>
              </div>
            </div>

            <!-- Completed Status -->
            <div class="timeline-item">
              <span
                class="timeline-point 
                @if ($currentStatus === 'completed') bg-success
                @else
                  bg-secondary @endif
              "></span>
              <div class="timeline-event">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h6 class="mb-0">Order Completed</h6>
                  <span
                    class="badge 
                    @if ($currentStatus === 'completed') bg-label-success
                    @else
                      bg-label-secondary @endif
                  ">
                    {{ $currentStatus === 'completed' ? 'Done' : 'Pending' }}
                  </span>
                </div>
                <p class="text-muted mb-0">
                  @if ($currentStatus === 'completed')
                    Your order has been completed successfully. Thank you for your business!
                  @else
                    Your artisan is still working on your order
                  @endif
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Service/Good Details -->
  <div class="row g-6">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Order Items</h5>
        </div>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Item</th>
                <th>Type</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @forelse($order->items as $item)
                <tr>
                  <td>
                    <span class="fw-medium">
                      {{ $item->artisanService?->service_name ?? ($item->artisanGood?->good_name ?? 'N/A') }}
                    </span>
                  </td>
                  <td>
                    <span class="badge bg-label-primary">
                      {{ $item->artisanService ? 'Service' : 'Good' }}
                    </span>
                  </td>
                  <td>
                    {{ $item->quantity ?? 1 }}
                  </td>
                  <td>
                    ${{ number_format($item->price ?? 0, 2) }}
                  </td>
                  <td>
                    <strong>${{ number_format(($item->price ?? 0) * ($item->quantity ?? 1), 2) }}</strong>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center text-muted py-3">
                    No items found
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
