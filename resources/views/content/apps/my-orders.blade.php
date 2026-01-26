@extends('layouts/layoutMaster')

@section('title', 'My Orders - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
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
          <h4 class="mb-2">My Orders</h4>
          <p class="text-muted mb-0">Track and manage all your artisan service orders</p>
        </div>
        <span class="badge bg-label-info">{{ $totalOrders }} Total Order{{ $totalOrders !== 1 ? 's' : '' }}</span>
      </div>
    </div>
  </div>

  <!-- Order Statistics Cards -->
  <div class="row g-6 mb-6">
    <!-- Completed Orders -->
    <div class="col-lg-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="mb-1 text-muted">Completed Orders</p>
              <h4 class="mb-2">{{ $completedCount }}</h4>
              <p class="mb-0 text-success"><i class="icon-base ri ri-arrow-up-s-line"></i>
                Order{{ $completedCount !== 1 ? 's' : '' }} finished</p>
            </div>
            <div class="avatar bg-label-success">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-check-double-line icon-24px"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Orders -->
    <div class="col-lg-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="mb-1 text-muted">In Progress</p>
              <h4 class="mb-2">{{ $inProgressCount }}</h4>
              <p class="mb-0 text-warning"><i class="icon-base ri ri-time-line"></i> Being worked on</p>
            </div>
            <div class="avatar bg-label-warning">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-progress-5-line icon-24px"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Payment -->
    <div class="col-lg-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="mb-1 text-muted">Pending Payment</p>
              <h4 class="mb-2">{{ $pendingPaymentCount }}</h4>
              <p class="mb-0 text-danger"><i class="icon-base ri ri-alert-line"></i> Awaiting payment</p>
            </div>
            <div class="avatar bg-label-danger">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-wallet-3-line icon-24px"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Spent -->
    <div class="col-lg-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="mb-1 text-muted">Total Spent</p>
              <h4 class="mb-2">${{ number_format($totalSpent, 2) }}</h4>
              <p class="mb-0 text-primary"><i class="icon-base ri ri-money-dollar-circle-line"></i> Completed orders</p>
            </div>
            <div class="avatar bg-label-primary">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-price-tag-line icon-24px"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Order Trends Chart -->
  <div class="row g-6 mb-6">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Order Trends (Last 30 Days)</h5>
            <div class="d-flex gap-2">
              <button class="btn btn-sm btn-outline-secondary">Weekly</button>
              <button class="btn btn-sm btn-primary">Monthly</button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div id="orderTrendsChart" style="height: 350px;"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Filter & Search Bar -->
  <div class="row g-6 mb-6">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row g-3 align-items-end">
            <!-- Search Input -->
            <div class="col-md-4">
              <label class="form-label">Search Orders</label>
              <div class="input-group">
                <span class="input-group-text">
                  <i class="icon-base ri ri-search-line"></i>
                </span>
                <input type="text" class="form-control" placeholder="Order ID, Artisan name..." />
              </div>
            </div>

            <!-- Status Filter -->
            <div class="col-md-3">
              <label class="form-label">Status</label>
              <select class="form-select">
                <option value="">All Status</option>
                <option value="completed">Completed</option>
                <option value="in-progress">In Progress</option>
                <option value="pending">Pending Payment</option>
                <option value="cancelled">Cancelled</option>
              </select>
            </div>

            <!-- Date Range Filter -->
            <div class="col-md-3">
              <label class="form-label">Date Range</label>
              <select class="form-select">
                <option value="">All Time</option>
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
                <option value="year">This Year</option>
              </select>
            </div>

            <!-- Action Buttons -->
            <div class="col-md-2">
              <div class="d-flex gap-2">
                <button class="btn btn-primary w-100">
                  <i class="icon-base ri ri-search-line"></i>
                </button>
                <button class="btn btn-outline-secondary">
                  <i class="icon-base ri ri-refresh-line"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Orders Table -->
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Recent Orders</h5>
        <a href="javascript:void(0);" class="text-primary small fw-medium">View All</a>
      </div>
    </div>
    <div class="card-datatable table-responsive">
      <table class="datatables-order table">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Artisan</th>
            <th>Service/Good</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Payment Status</th>
            <th>Order Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($orders as $order)
            <tr>
              <td><span class="badge bg-label-primary">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span></td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-sm me-2">
                    <img
                      src="{{ $order->artisan->profile_photo_path ? asset('storage/' . $order->artisan->profile_photo_path) : asset('assets/img/avatars/1.png') }}"
                      alt="Avatar" class="rounded-circle" />
                  </div>
                  <span>{{ $order->artisan->user->name }}</span>
                </div>
              </td>
              <td>{{ $order->items->first()?->artisanService?->service_name ?? 'N/A' }}</td>
              <td>{{ $order->created_at->format('M d, Y') }}</td>
              <td><strong>${{ number_format($order->total_amount ?? 0, 2) }}</strong></td>
              <td>
                @if ($order->payment_status === 'paid')
                  <span class="badge bg-label-success">Paid</span>
                @else
                  <span class="badge bg-label-warning">Pending</span>
                @endif
              </td>
              <td>
                @php
                  $statusColors = [
                      'completed' => 'success',
                      'processing' => 'info',
                      'paid' => 'success',
                      'pending' => 'warning',
                      'cancelled' => 'danger',
                  ];
                  $statusColor = $statusColors[$order->status] ?? 'secondary';
                  $statusLabel = ucfirst(str_replace('_', ' ', $order->status));
                @endphp
                <span class="badge bg-label-{{ $statusColor }}">{{ $statusLabel }}</span>
              </td>
              <td>
                <div class="dropdown">
                  <button class="btn btn-icon btn-text-secondary rounded-pill p-0" type="button"
                    data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-line"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('user-order-details', $order->id) }}">
                      <i class="icon-base ri ri-eye-line me-2"></i>View Details
                    </a>
                    @if ($order->status === 'completed')
                      <a class="dropdown-item" href="javascript:void(0);">
                        <i class="icon-base ri ri-download-line me-2"></i>Download Invoice
                      </a>
                      <a class="dropdown-item" href="javascript:void(0);">
                        <i class="icon-base ri ri-star-line me-2"></i>Leave Review
                      </a>
                    @elseif($order->status === 'processing' || $order->status === 'paid')
                      <a class="dropdown-item" href="javascript:void(0);">
                        <i class="icon-base ri ri-phone-line me-2"></i>Contact Artisan
                      </a>
                      <a class="dropdown-item" href="javascript:void(0);">
                        <i class="icon-base ri ri-time-line me-2"></i>Track Progress
                      </a>
                    @elseif($order->payment_status === 'unpaid')
                      <a class="dropdown-item" href="javascript:void(0);">
                        <i class="icon-base ri ri-bank-card-line me-2"></i>Pay Now
                      </a>
                    @endif
                  </div>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-4">
                <div class="text-muted mb-3">
                  <i class="icon-base ri ri-inbox-archive-line icon-48px"></i>
                </div>
                <p class="mb-2 fw-medium">No orders yet</p>
                <p class="text-muted mb-3">Start browsing artisans and place your first order</p>
                <a href="{{ route('user-browse-artisans') }}" class="btn btn-primary btn-sm">Browse Artisans</a>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Custom Script for Charts -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const orderTrendsChart = new ApexCharts(document.querySelector("#orderTrendsChart"), {
        series: [
          @if ($chartData['series'])
            @foreach ($chartData['series'] as $series)
              {
                name: '{{ $series['name'] }}',
                data: {{ json_encode($series['data']) }}
              },
            @endforeach
          @endif
        ],
        chart: {
          type: 'bar',
          height: 350,
          toolbar: {
            show: true
          }
        },
        colors: ['#28c76f', '#ff9f43', '#ea5455'],
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            borderRadius: 4
          }
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          categories: {{ json_encode($chartData['categories']) }}
        },
        yaxis: {
          title: {
            text: 'Number of Orders'
          }
        },
        legend: {
          position: 'top'
        }
      });
      orderTrendsChart.render();
    });
  </script>

@endsection
