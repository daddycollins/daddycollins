@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Order Details - ArtisanConnect')

@section('content')
  <!-- Flash Messages Alert Component -->
  <x-alert />

  <!-- Header -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 gap-6">
    <div class="d-flex flex-column justify-content-center">
      <div class="d-flex align-items-center mb-1">
        <h5 class="mb-0">Order #ORD-{{ $order->id }}</h5>
        <span
          class="badge bg-label-{{ $order->status === 'completed' ? 'success' : ($order->status === 'paid' ? 'info' : ($order->status === 'pending' ? 'warning' : 'danger')) }} me-2 ms-2 rounded-pill">
          {{ ucfirst($order->status) }}
        </span>
        <span class="badge bg-label-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }} rounded-pill">
          {{ ucfirst($order->payment_status) }}
        </span>
      </div>
      <p class="mb-0">{{ $order->created_at->format('M d, Y, H:i') }}</p>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-2">
      <a href="{{ route('artisan-my-orders') }}" class="btn btn-outline-secondary">
        <i class="icon-base ri ri-arrow-left-line me-2"></i>Back to Orders
      </a>
    </div>
  </div>

  <!-- Order Details -->
  <div class="row g-6">
    <!-- Left Column -->
    <div class="col-12 col-lg-8">
      <!-- Order Items -->
      <div class="card mb-6">
        <div class="card-header">
          <h5 class="mb-0">Order Items</h5>
        </div>
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="bg-light">
              <tr>
                <th>Product/Service</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @forelse($order->items as $item)
                <tr>
                  <td>
                    <strong>{{ $item->service_name ?? ($item->product_name ?? 'N/A') }}</strong>
                    <br />
                    <small class="text-muted">{{ Str::limit($item->description ?? '', 50) }}</small>
                  </td>
                  <td>ZWL {{ number_format($item->unit_price, 2) }}</td>
                  <td>{{ $item->quantity }}</td>
                  <td><strong>ZWL {{ number_format($item->total_price, 2) }}</strong></td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center text-muted py-4">
                    <i class="icon-base ri ri-inbox-line me-2"></i>No items found
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <!-- Order Summary -->
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Order Summary</h5>
        </div>
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-6 text-start"><strong>Subtotal:</strong></div>
            <div class="col-6 text-end">ZWL {{ number_format($order->total_amount * 0.85, 2) }}</div>
          </div>
          <div class="row mb-3">
            <div class="col-6 text-start"><strong>Shipping:</strong></div>
            <div class="col-6 text-end">ZWL {{ number_format($order->total_amount * 0.05, 2) }}</div>
          </div>
          <div class="row mb-3">
            <div class="col-6 text-start"><strong>Tax (10%):</strong></div>
            <div class="col-6 text-end">ZWL {{ number_format($order->total_amount * 0.1, 2) }}</div>
          </div>
          <hr />
          <div class="row">
            <div class="col-6 text-start">
              <h5 class="mb-0">Total Amount:</h5>
            </div>
            <div class="col-6 text-end">
              <h5 class="mb-0 text-success">ZWL {{ number_format($order->total_amount, 2) }}</h5>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column -->
    <div class="col-12 col-lg-4">
      <!-- Client Information -->
      <div class="card mb-6">
        <div class="card-header">
          <h5 class="mb-0">Client Information</h5>
        </div>
        <div class="card-body">
          <div class="d-flex align-items-center mb-4">
            <div class="avatar avatar-lg me-3">
              <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Client" class="rounded-circle" />
            </div>
            <div>
              <h6 class="mb-0">{{ $order->client->name ?? 'Unknown' }}</h6>
              <small class="text-muted">Client</small>
            </div>
          </div>
          <hr />
          <div class="mb-3">
            <small class="text-muted d-block mb-1">Email:</small>
            <strong>{{ $order->client->email ?? 'N/A' }}</strong>
          </div>
          <div class="mb-3">
            <small class="text-muted d-block mb-1">Phone:</small>
            <strong>{{ $order->client->phone ?? 'Not provided' }}</strong>
          </div>
          <div>
            <small class="text-muted d-block mb-1">Location:</small>
            <strong>{{ $order->client->location ?? 'Not provided' }}</strong>
          </div>
        </div>
      </div>

      <!-- Order Status Timeline -->
      <div class="card mb-6">
        <div class="card-header">
          <h5 class="mb-0">Order Status</h5>
        </div>
        <div class="card-body">
          <div class="timeline-item">
            <span class="badge badge-center rounded-pill bg-success mb-3">
              <i class="icon-base ri ri-check-line"></i>
            </span>
            <h6 class="mb-1">Order Placed</h6>
            <p class="mb-3 text-muted">{{ $order->created_at->format('M d, Y H:i') }}</p>
          </div>
          <div class="timeline-item">
            <span
              class="badge badge-center rounded-pill {{ $order->status === 'pending' ? 'bg-warning' : 'bg-success' }} mb-3">
              @if ($order->status === 'pending')
                <i class="icon-base ri ri-time-line"></i>
              @else
                <i class="icon-base ri ri-check-line"></i>
              @endif
            </span>
            <h6 class="mb-1">{{ ucfirst($order->status) }}</h6>
            <p class="mb-3 text-muted">{{ $order->updated_at->format('M d, Y H:i') }}</p>
          </div>
        </div>
      </div>

      <!-- Order Type -->
      <div class="card">
        <div class="card-body">
          <div class="mb-3">
            <small class="text-muted d-block mb-1">Order Type:</small>
            <span class="badge bg-label-{{ $order->order_type === 'service' ? 'primary' : 'info' }}">
              {{ ucfirst($order->order_type) }}
            </span>
          </div>
          <div class="mb-3">
            <small class="text-muted d-block mb-1">Payment Status:</small>
            <span class="badge bg-label-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
              {{ ucfirst($order->payment_status) }}
            </span>
          </div>
          <div>
            <small class="text-muted d-block mb-1">Order ID:</small>
            <strong class="text-monospace">#ORD-{{ $order->id }}</strong>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
