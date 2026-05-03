@extends('layouts/layoutMaster')

@section('title', 'Reports - ArtisanConnect Admin')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('content')
  <!-- Header -->
  <div
    class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-between mb-6 text-center text-sm-start gap-2">
    <div class="mb-2 mb-sm-0">
      <h4 class="mb-1"><i class="icon-base ri ri-file-chart-line me-2 text-primary"></i>Reports</h4>
      <p class="mb-0">Generate and analyze platform performance reports</p>
    </div>
  </div>

  <!-- Date Range & Additional Filters -->
  <div class="card border-0 shadow-sm mb-6">
    <div class="card-body">
      <div class="row g-3 align-items-end">
        <div class="col-md-2">
          <label class="form-label"><strong>Date Range</strong></label>
          <select class="form-select form-select-sm" id="dateRange">
            <option value="today">Today</option>
            <option value="week">This Week</option>
            <option value="month">This Month</option>
            <option value="quarter">This Quarter</option>
            <option value="year" selected>This Year</option>
            <option value="custom">Custom Range</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label"><strong>Start Date</strong></label>
          <input type="date" class="form-control form-control-sm" id="startDate" value="2026-01-01">
        </div>
        <div class="col-md-2">
          <label class="form-label"><strong>End Date</strong></label>
          <input type="date" class="form-control form-control-sm" id="endDate" value="2026-01-24">
        </div>
        <div class="col-md-2">
          <label class="form-label"><strong>Status</strong></label>
          <select class="form-select form-select-sm" id="filterStatus">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="suspended">Suspended</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label"><strong>Order Status</strong></label>
          <select class="form-select form-select-sm" id="filterOrderStatus">
            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="paid">Paid</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
          </select>
        </div>
        <div class="col-md-2">
          <button class="btn btn-primary btn-sm w-100" id="generateReports">
            <i class="icon-base ri ri-refresh-line me-1"></i>Refresh
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Tabs for Reports -->
  <ul class="nav nav-tabs mb-4" role="tablist" style="overflow-x: auto; white-space: nowrap;">
    <!-- Financial Reports -->
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="financial-tab" data-bs-toggle="tab" data-bs-target="#financialReport"
        type="button" role="tab" aria-controls="financialReport" aria-selected="true">
        <i class="icon-base ri ri-money-dollar-circle-line me-2"></i>Financial
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="revenue-trends-tab" data-bs-toggle="tab" data-bs-target="#revenueTrendsReport"
        type="button" role="tab" aria-controls="revenueTrendsReport" aria-selected="false"
        data-report="revenue-trends">
        <i class="icon-base ri ri-line-chart-line me-2"></i>Revenue Trends
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="payment-status-tab" data-bs-toggle="tab" data-bs-target="#paymentStatusReport"
        type="button" role="tab" aria-controls="paymentStatusReport" aria-selected="false"
        data-report="payment-status">
        <i class="icon-base ri ri-bank-card-line me-2"></i>Payment Status
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="artisan-perf-tab" data-bs-toggle="tab" data-bs-target="#artisanPerformanceReport"
        type="button" role="tab" aria-controls="artisanPerformanceReport" aria-selected="false"
        data-report="artisan-performance">
        <i class="icon-base ri ri-user-star-line me-2"></i>Artisan Performance
      </button>
    </li>

    <!-- User Reports -->
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#usersReport" type="button"
        role="tab" aria-controls="usersReport" aria-selected="false">
        <i class="icon-base ri ri-user-multiple-line me-2"></i>Users
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="user-growth-tab" data-bs-toggle="tab" data-bs-target="#userGrowthReport"
        type="button" role="tab" aria-controls="userGrowthReport" aria-selected="false"
        data-report="user-growth">
        <i class="icon-base ri ri-user-add-line me-2"></i>User Growth
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="verification-tab" data-bs-toggle="tab" data-bs-target="#verificationReport"
        type="button" role="tab" aria-controls="verificationReport" aria-selected="false"
        data-report="artisan-verification">
        <i class="icon-base ri ri-verified-badge-line me-2"></i>Verification
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="inactive-tab" data-bs-toggle="tab" data-bs-target="#inactiveUsersReport"
        type="button" role="tab" aria-controls="inactiveUsersReport" aria-selected="false"
        data-report="inactive-users">
        <i class="icon-base ri ri-user-unfollow-line me-2"></i>Inactive Users
      </button>
    </li>

    <!-- Order Reports -->
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orderStatusReport"
        type="button" role="tab" aria-controls="orderStatusReport" aria-selected="false"
        data-report="order-status">
        <i class="icon-base ri ri-shopping-cart-line me-2"></i>Order Status
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="services-tab" data-bs-toggle="tab" data-bs-target="#topServicesReport"
        type="button" role="tab" aria-controls="topServicesReport" aria-selected="false"
        data-report="top-services">
        <i class="icon-base ri ri-hammer-2-line me-2"></i>Top Services
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelledOrdersReport"
        type="button" role="tab" aria-controls="cancelledOrdersReport" aria-selected="false"
        data-report="cancelled-orders">
        <i class="icon-base ri ri-close-circle-line me-2"></i>Cancelled Orders
      </button>
    </li>

    <!-- Quality Reports -->
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="quality-tab" data-bs-toggle="tab" data-bs-target="#qualityReport" type="button"
        role="tab" aria-controls="qualityReport" aria-selected="false" data-report="artisan-quality">
        <i class="icon-base ri ri-star-line me-2"></i>Quality
      </button>
    </li>
  </ul>

  <!-- Report Content -->
  <div class="tab-content">
    <!-- Financial Report -->
    <div class="tab-pane fade show active" id="financialReport" role="tabpanel" aria-labelledby="financial-tab">

      <!-- Summary Cards -->
      <div class="row g-6 mb-6">
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Total Revenue</p>
              <h3 class="mb-2">ZWL {{ number_format($totalRevenue, 0) }}</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>All Time</span></p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Monthly Revenue</p>
              <h3 class="mb-2">ZWL {{ number_format($monthlyRevenue, 0) }}</h3>
              <p class="mb-0"><span class="badge bg-label-info">Current Month</span></p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Completed Payments</p>
              <h3 class="mb-2">ZWL {{ number_format($completedPayments, 0) }}</h3>
              <p class="mb-0"><span class="badge bg-label-success">Paid</span></p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Pending Payments</p>
              <h3 class="mb-2">ZWL {{ number_format($pendingPayments, 0) }}</h3>
              <p class="mb-0"><span class="badge bg-label-warning">Awaiting</span></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Charts Row -->
      <div class="row g-6 mb-6">
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
              <h5 class="card-title m-0">Top Earning Artisans</h5>
              <button class="btn btn-sm btn-outline-primary" data-action="download-artisan-report">
                <i class="icon-base ri ri-download-cloud-line me-1"></i>Download PDF
              </button>
            </div>
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="bg-light">
                  <tr>
                    <th class="py-3">Artisan</th>
                    <th class="py-3">Services Completed</th>
                    <th class="py-3">Avg Rating</th>
                    <th class="py-3">Total Revenue</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($topArtisans as $artisan)
                    <tr>
                      <td class="py-3">
                        <strong>{{ $artisan->user?->name ?? 'N/A' }}</strong><br>
                        <small class="text-muted">{{ $artisan->category }}</small>
                      </td>
                      <td class="py-3">{{ $artisan->orders_count ?? 0 }}</td>
                      <td class="py-3">
                        <span class="text-warning">
                          @php
                            $rating = $artisan->reviews_avg_rating ?? 0;
                            $fullStars = floor($rating);
                            for ($i = 0; $i < $fullStars; $i++) {
                                echo '★';
                            }
                            for ($i = $fullStars; $i < 5; $i++) {
                                echo '☆';
                            }
                          @endphp
                        </span>
                        {{ round($artisan->reviews_avg_rating ?? 0, 2) }}
                      </td>
                      <td class="py-3"><strong>ZWL
                          {{ number_format($artisan->orders_sum_total_amount ?? 0, 0) }}</strong></td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="4" class="text-center py-4">No artisans found</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title m-0">Revenue by Category</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-sm mb-0">
                  <thead class="bg-light">
                    <tr>
                      <th class="py-3">Category</th>
                      <th class="py-3">Total Revenue</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($revenueByCategory as $category)
                      <tr>
                        <td class="py-3"><strong>{{ $category->category }}</strong></td>
                        <td class="py-3">ZWL {{ number_format($category->orders_sum_total_amount ?? 0, 0) }}</td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="2" class="text-center py-4">No categories found</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Performance Metrics -->
      <div class="row g-6">
        <div class="col-lg-12">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
              <h5 class="card-title m-0">Financial Metrics</h5>
              <button class="btn btn-sm btn-outline-primary" data-action="download-artisan-metrics">
                <i class="icon-base ri ri-download-cloud-line me-1"></i>Download PDF
              </button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover mb-0">
                  <thead class="bg-light">
                    <tr>
                      <th class="py-3">Metric</th>
                      <th class="py-3">Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="py-3"><strong>Average Order Value</strong></td>
                      <td class="py-3">ZWL {{ number_format($avgOrderValue, 0) }}</td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Total Orders</strong></td>
                      <td class="py-3">{{ number_format($totalOrders) }}</td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Completed Orders</strong></td>
                      <td class="py-3">{{ number_format($completedOrders) }}</td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Platform Avg Rating</strong></td>
                      <td class="py-3">{{ $avgRating }}★ ({{ $totalReviews }} reviews)</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Users Report -->
    <div class="tab-pane fade" id="usersReport" role="tabpanel" aria-labelledby="users-tab">

      <!-- Summary Cards -->
      <div class="row g-6 mb-6">
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Total Users</p>
              <h3 class="mb-2">{{ number_format($totalUsers) }}</h3>
              <p class="mb-0"><span class="badge bg-label-success">All platforms</span></p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Active Users</p>
              <h3 class="mb-2">{{ number_format($activeUsers) }}</h3>
              <p class="mb-0"><span
                  class="badge bg-label-info">{{ $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 1) : 0 }}%
                  of total</span></p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Total Artisans</p>
              <h3 class="mb-2">{{ number_format($totalArtisans) }}</h3>
              <p class="mb-0"><span class="badge bg-label-success">{{ number_format($verifiedArtisans) }}
                  verified</span></p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Total Clients</p>
              <h3 class="mb-2">{{ number_format($totalClients) }}</h3>
              <p class="mb-0"><span class="badge bg-label-info">Service seekers</span></p>
            </div>
          </div>
        </div>
      </div>

      <!-- User Distribution -->
      <div class="row g-6 mb-6">
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title m-0">Top Artisans by Orders</h5>
            </div>
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="bg-light">
                  <tr>
                    <th class="py-3">Artisan</th>
                    <th class="py-3">Category</th>
                    <th class="py-3">Total Orders</th>
                    <th class="py-3">Avg Rating</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($topArtisansByOrders as $artisan)
                    <tr>
                      <td class="py-3"><strong>{{ $artisan->user?->name ?? 'N/A' }}</strong></td>
                      <td class="py-3">{{ $artisan->category }}</td>
                      <td class="py-3">{{ $artisan->orders_count }}</td>
                      <td class="py-3">
                        <span class="text-warning">
                          @php
                            $rating = $artisan->reviews_avg_rating ?? 0;
                            $fullStars = floor($rating);
                            for ($i = 0; $i < $fullStars; $i++) {
                                echo '★';
                            }
                            for ($i = $fullStars; $i < 5; $i++) {
                                echo '☆';
                            }
                          @endphp
                        </span>
                        {{ round($artisan->reviews_avg_rating ?? 0, 2) }}
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="4" class="text-center py-4">No artisans found</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title m-0">User Status Breakdown</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-sm mb-0">
                  <thead class="bg-light">
                    <tr>
                      <th class="py-3">Status</th>
                      <th class="py-3">Count</th>
                      <th class="py-3">Percentage</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="py-3"><span class="badge bg-label-success">Active</span></td>
                      <td class="py-3">{{ number_format($activeUsers) }}</td>
                      <td class="py-3">{{ $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 1) : 0 }}%</td>
                    </tr>
                    <tr>
                      <td class="py-3"><span class="badge bg-label-danger">Suspended</span></td>
                      <td class="py-3">{{ number_format($suspendedUsers) }}</td>
                      <td class="py-3">{{ $totalUsers > 0 ? round(($suspendedUsers / $totalUsers) * 100, 1) : 0 }}%
                      </td>
                    </tr>
                    <tr>
                      <td class="py-3"><span class="badge bg-label-info">Artisans</span></td>
                      <td class="py-3">{{ number_format($totalArtisans) }}</td>
                      <td class="py-3">{{ $totalUsers > 0 ? round(($totalArtisans / $totalUsers) * 100, 1) : 0 }}%
                      </td>
                    </tr>
                    <tr>
                      <td class="py-3"><span class="badge bg-label-secondary">Clients</span></td>
                      <td class="py-3">{{ number_format($totalClients) }}</td>
                      <td class="py-3">{{ $totalUsers > 0 ? round(($totalClients / $totalUsers) * 100, 1) : 0 }}%</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- System Report -->
    <div class="tab-pane fade" id="systemReport" role="tabpanel" aria-labelledby="system-tab">

      <!-- Summary Cards -->
      <div class="row g-6 mb-6">
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Total Orders</p>
              <h3 class="mb-2">{{ number_format($totalOrders) }}</h3>
              <p class="mb-0"><span class="badge bg-label-info">All time</span></p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Completed Orders</p>
              <h3 class="mb-2">{{ number_format($completedOrders) }}</h3>
              <p class="mb-0"><span
                  class="badge bg-label-success">{{ $totalOrders > 0 ? round(($completedOrders / $totalOrders) * 100, 1) : 0 }}%</span>
              </p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Pending Orders</p>
              <h3 class="mb-2">{{ number_format($pendingOrders) }}</h3>
              <p class="mb-0"><span class="badge bg-label-warning">In progress</span></p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Cancelled Orders</p>
              <h3 class="mb-2">{{ number_format($cancelledOrders) }}</h3>
              <p class="mb-0"><span
                  class="badge bg-label-danger">{{ $totalOrders > 0 ? round(($cancelledOrders / $totalOrders) * 100, 1) : 0 }}%</span>
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- System Health -->
      <div class="row g-6 mb-6">
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title m-0">Order Status Distribution</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-sm mb-0">
                  <thead class="bg-light">
                    <tr>
                      <th class="py-3">Status</th>
                      <th class="py-3">Count</th>
                      <th class="py-3">Percentage</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $statusData = [
                          'pending' => ['label' => 'Pending', 'badge' => 'bg-label-warning'],
                          'paid' => ['label' => 'Paid', 'badge' => 'bg-label-info'],
                          'completed' => ['label' => 'Completed', 'badge' => 'bg-label-success'],
                          'cancelled' => ['label' => 'Cancelled', 'badge' => 'bg-label-danger'],
                      ];
                    @endphp
                    @foreach ($orderStatusBreakdown as $status => $count)
                      <tr>
                        <td class="py-3"><span
                            class="badge {{ $statusData[$status]['badge'] ?? 'bg-label-secondary' }}">{{ $statusData[$status]['label'] ?? ucfirst($status) }}</span>
                        </td>
                        <td class="py-3">{{ number_format($count) }}</td>
                        <td class="py-3">{{ $totalOrders > 0 ? round(($count / $totalOrders) * 100, 1) : 0 }}%</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title m-0">Service Category Performance</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-sm mb-0">
                  <thead class="bg-light">
                    <tr>
                      <th class="py-3">Category</th>
                      <th class="py-3">Total Orders</th>
                      <th class="py-3">Avg Rating</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($categoryPerformance as $category)
                      <tr>
                        <td class="py-3"><strong>{{ $category->category }}</strong></td>
                        <td class="py-3">{{ $category->orders_count }}</td>
                        <td class="py-3">
                          <span class="text-warning">
                            @php
                              $rating = $category->reviews_avg_rating ?? 0;
                              $fullStars = floor($rating);
                              for ($i = 0; $i < $fullStars; $i++) {
                                  echo '★';
                              }
                              for ($i = $fullStars; $i < 5; $i++) {
                                  echo '☆';
                              }
                            @endphp
                          </span>
                          {{ round($category->reviews_avg_rating ?? 0, 2) }}
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="3" class="text-center py-4">No categories found</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- System Activity -->
      <div class="row g-6">
        <div class="col-lg-12">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title m-0">System Overview</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-sm mb-0">
                  <thead class="bg-light">
                    <tr>
                      <th class="py-3">Metric</th>
                      <th class="py-3">Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="py-3"><strong>Total System Logs</strong></td>
                      <td class="py-3">{{ number_format($systemLogs) }}</td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Platform Average Rating</strong></td>
                      <td class="py-3">{{ $avgRating }}★ out of 5</td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Total Reviews</strong></td>
                      <td class="py-3">{{ number_format($totalReviews) }}</td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Avg Order Value</strong></td>
                      <td class="py-3">ZWL {{ number_format($avgOrderValue, 0) }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Revenue Trends Report -->
    <div class="tab-pane fade" id="revenueTrendsReport" role="tabpanel" aria-labelledby="revenue-trends-tab">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0">Revenue Trends Over Time</h5>
        </div>
        <div class="card-body">
          <div id="revenueTrendsData" class="table-responsive">
            <div class="text-center py-5">
              <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
              <p class="mt-3 text-muted">Loading...</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Payment Status Report -->
    <div class="tab-pane fade" id="paymentStatusReport" role="tabpanel" aria-labelledby="payment-status-tab">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0">Payment Status Breakdown</h5>
        </div>
        <div class="card-body">
          <div id="paymentStatusData" class="table-responsive">
            <div class="text-center py-5">
              <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
              <p class="mt-3 text-muted">Loading...</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Artisan Performance Report -->
    <div class="tab-pane fade" id="artisanPerformanceReport" role="tabpanel" aria-labelledby="artisan-perf-tab">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0">Top Artisan Performance</h5>
        </div>
        <div class="card-body">
          <div id="artisanPerformanceData" class="table-responsive">
            <div class="text-center py-5">
              <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
              <p class="mt-3 text-muted">Loading...</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- User Growth Report -->
    <div class="tab-pane fade" id="userGrowthReport" role="tabpanel" aria-labelledby="user-growth-tab">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0">User Growth Report</h5>
        </div>
        <div class="card-body">
          <div id="userGrowthData" class="table-responsive">
            <div class="text-center py-5">
              <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
              <p class="mt-3 text-muted">Loading...</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Artisan Verification Report -->
    <div class="tab-pane fade" id="verificationReport" role="tabpanel" aria-labelledby="verification-tab">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0">Artisan Verification Status</h5>
        </div>
        <div class="card-body">
          <div id="verificationData" class="table-responsive">
            <div class="text-center py-5">
              <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
              <p class="mt-3 text-muted">Loading...</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Inactive Users Report -->
    <div class="tab-pane fade" id="inactiveUsersReport" role="tabpanel" aria-labelledby="inactive-tab">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0">Inactive Users</h5>
        </div>
        <div class="card-body">
          <div id="inactiveUsersData" class="table-responsive">
            <div class="text-center py-5">
              <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
              <p class="mt-3 text-muted">Loading...</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Order Status Report -->
    <div class="tab-pane fade" id="orderStatusReport" role="tabpanel" aria-labelledby="orders-tab">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0">Order Status Distribution</h5>
        </div>
        <div class="card-body">
          <div id="orderStatusData" class="table-responsive">
            <div class="text-center py-5">
              <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
              <p class="mt-3 text-muted">Loading...</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Top Services Report -->
    <div class="tab-pane fade" id="topServicesReport" role="tabpanel" aria-labelledby="services-tab">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0">Top Services by Revenue</h5>
        </div>
        <div class="card-body">
          <div id="topServicesData" class="table-responsive">
            <div class="text-center py-5">
              <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
              <p class="mt-3 text-muted">Loading...</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Cancelled Orders Report -->
    <div class="tab-pane fade" id="cancelledOrdersReport" role="tabpanel" aria-labelledby="cancelled-tab">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0">Cancelled Orders Analysis</h5>
        </div>
        <div class="card-body">
          <div id="cancelledOrdersData" class="table-responsive">
            <div class="text-center py-5">
              <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
              <p class="mt-3 text-muted">Loading...</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quality Report -->
    <div class="tab-pane fade" id="qualityReport" role="tabpanel" aria-labelledby="quality-tab">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0">Artisan Quality Metrics</h5>
        </div>
        <div class="card-body">
          <div id="qualityData" class="table-responsive">
            <div class="text-center py-5">
              <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
              <p class="mt-3 text-muted">Loading...</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('page-script')
  <script>
    // Report API endpoints
    const reportEndpoints = {
      'revenue-trends': '{{ route('reports.revenue-trends') }}',
      'payment-status': '{{ route('reports.payment-status') }}',
      'artisan-performance': '{{ route('reports.artisan-performance') }}',
      'user-growth': '{{ route('reports.user-growth') }}',
      'artisan-verification': '{{ route('reports.artisan-verification') }}',
      'inactive-users': '{{ route('reports.inactive-users') }}',
      'order-status': '{{ route('reports.order-status') }}',
      'top-services': '{{ route('reports.top-services') }}',
      'cancelled-orders': '{{ route('reports.cancelled-orders') }}',
      'artisan-quality': '{{ route('reports.artisan-quality') }}'
    };

    // Container ID mapping for each report
    const reportContainers = {
      'revenue-trends': 'revenueTrendsData',
      'payment-status': 'paymentStatusData',
      'artisan-performance': 'artisanPerformanceData',
      'user-growth': 'userGrowthData',
      'artisan-verification': 'verificationData',
      'inactive-users': 'inactiveUsersData',
      'order-status': 'orderStatusData',
      'top-services': 'topServicesData',
      'cancelled-orders': 'cancelledOrdersData',
      'artisan-quality': 'qualityData'
    };

    // Store current filter state
    let currentDateRange = 'year';
    let currentStartDate = null;
    let currentEndDate = null;

    // Get filter parameters from form
    function getFilterParams() {
      const dateRangeSelect = document.getElementById('dateRange');
      const startDateInput = document.getElementById('startDate');
      const endDateInput = document.getElementById('endDate');
      const statusFilter = document.getElementById('filterStatus');
      const orderStatusFilter = document.getElementById('filterOrderStatus');

      currentDateRange = dateRangeSelect ? dateRangeSelect.value : 'year';
      currentStartDate = startDateInput ? startDateInput.value : null;
      currentEndDate = endDateInput ? endDateInput.value : null;

      return {
        dateRange: currentDateRange,
        startDate: currentStartDate,
        endDate: currentEndDate,
        status: statusFilter ? statusFilter.value : '',
        orderStatus: orderStatusFilter ? orderStatusFilter.value : ''
      };
    }

    // Helper function to render table from API data
    function renderTable(data, containerId) {
      if (!data || data.length === 0) {
        document.getElementById(containerId).innerHTML =
          '<div class="alert alert-info"><i class="icon-base ri ri-information-line me-2"></i>No data available</div>';
        return;
      }

      const headers = Object.keys(data[0]);
      let html = '<table class="table table-hover"><thead class="bg-light"><tr>';

      headers.forEach(header => {
        html += `<th class="py-3">${formatHeader(header)}</th>`;
      });

      html += '</tr></thead><tbody>';

      data.forEach(row => {
        html += '<tr>';
        headers.forEach(header => {
          const value = row[header];
          html += `<td class="py-3">${formatValue(header, value)}</td>`;
        });
        html += '</tr>';
      });

      html += '</tbody></table>';
      document.getElementById(containerId).innerHTML = html;
    }

    // Format header names
    function formatHeader(header) {
      return header
        .replace(/_/g, ' ')
        .replace(/([a-z])([A-Z])/g, '$1 $2')
        .split(' ')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
    }

    // Format values based on type
    function formatValue(header, value) {
      if (!value && value !== 0) {
        return 'N/A';
      }
      if (header.includes('revenue') || header.includes('amount') || header.includes('total')) {
        return 'ZWL ' + Number(value).toLocaleString('en-US', {
          maximumFractionDigits: 0
        });
      } else if (header.includes('rating')) {
        return Number(value).toFixed(2) + '★';
      }
      return value || 'N/A';
    }

    // Load report data
    function loadReport(reportType) {
      const containerId = reportContainers[reportType];
      const endpoint = reportEndpoints[reportType];

      if (!endpoint || !containerId) return;

      // Get current filter values
      const filters = getFilterParams();

      // Build URL with query parameters
      const url = new URL(endpoint, window.location.origin);
      url.searchParams.append('dateRange', filters.dateRange);
      if (filters.dateRange === 'custom' && filters.startDate) {
        url.searchParams.append('startDate', filters.startDate);
      }
      if (filters.dateRange === 'custom' && filters.endDate) {
        url.searchParams.append('endDate', filters.endDate);
      }
      if (filters.status) {
        url.searchParams.append('status', filters.status);
      }
      if (filters.orderStatus) {
        url.searchParams.append('orderStatus', filters.orderStatus);
      }

      // Show loading spinner
      const container = document.getElementById(containerId);
      container.innerHTML = `
        <div class="text-center py-5">
          <div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>
          <p class="mt-3 text-muted">Loading...</p>
        </div>
      `;

      fetch(url.toString())
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.json();
        })
        .then(result => {
          console.log('Report data:', result);
          if (result.success && result.data) {
            renderTable(result.data, containerId);
          } else {
            document.getElementById(containerId).innerHTML =
              '<div class="alert alert-warning"><i class="icon-base ri ri-alert-line me-2"></i>No data available for selected filters</div>';
          }
        })
        .catch(error => {
          console.error('Error loading report:', error);
          console.error('URL:', url.toString());
          document.getElementById(containerId).innerHTML =
            '<div class="alert alert-danger"><i class="icon-base ri ri-error-warning-line me-2"></i>Error loading report data: ' +
            error.message + '</div>';
        });
    }

    // Listen for tab changes
    document.addEventListener('DOMContentLoaded', function() {
      const tabButtons = document.querySelectorAll('[data-report]');

      tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', function() {
          const reportType = this.getAttribute('data-report');
          loadReport(reportType);
        });
      });
    });
  </script>
  <script>
    // Show/hide custom date inputs and reload active report
    dateRangeSelect.addEventListener('change', function(e) {
      if (e.target.value === 'custom') {
        startDateInput.parentElement.parentElement.style.display = 'flex';
        endDateInput.parentElement.parentElement.style.display = 'flex';
      } else {
        startDateInput.parentElement.parentElement.style.display = 'none';
        endDateInput.parentElement.parentElement.style.display = 'none';
        // Reload active report when date range changes
        const activeTab = document.querySelector('.nav-link.active[data-report]');
        if (activeTab) {
          const reportType = activeTab.getAttribute('data-report');
          loadReport(reportType);
        }
      }
    });

    // Also reload on custom date change (when date inputs change)
    if (startDateInput) {
      startDateInput.addEventListener('change', function() {
        const activeTab = document.querySelector('.nav-link.active[data-report]');
        if (activeTab && dateRangeSelect.value === 'custom') {
          const reportType = activeTab.getAttribute('data-report');
          loadReport(reportType);
        }
      });
    }

    if (endDateInput) {
      endDateInput.addEventListener('change', function() {
        const activeTab = document.querySelector('.nav-link.active[data-report]');
        if (activeTab && dateRangeSelect.value === 'custom') {
          const reportType = activeTab.getAttribute('data-report');
          loadReport(reportType);
        }
      });
    }

    // Reload reports on status filter change
    const statusFilter = document.getElementById('filterStatus');
    if (statusFilter) {
      statusFilter.addEventListener('change', function() {
        const activeTab = document.querySelector('.nav-link.active[data-report]');
        if (activeTab) {
          const reportType = activeTab.getAttribute('data-report');
          loadReport(reportType);
        }
      });
    }

    // Reload reports on order status filter change
    const orderStatusFilter = document.getElementById('filterOrderStatus');
    if (orderStatusFilter) {
      orderStatusFilter.addEventListener('change', function() {
        const activeTab = document.querySelector('.nav-link.active[data-report]');
        if (activeTab) {
          const reportType = activeTab.getAttribute('data-report');
          loadReport(reportType);
        }
      });
    }

    // Generate Reports Handler
    generateBtn.addEventListener('click', function() {
      const dateRange = dateRangeSelect.value;
      const startDate = startDateInput.value;
      const endDate = endDateInput.value;

      // Validate custom date range
      if (dateRange === 'custom') {
        if (!startDate || !endDate) {
          Swal.fire({
            title: 'Missing Dates',
            text: 'Please select both start and end dates for custom range',
            icon: 'warning'
          });
          return;
        }
        if (new Date(startDate) > new Date(endDate)) {
          Swal.fire({
            title: 'Invalid Date Range',
            text: 'Start date must be before end date',
            icon: 'error'
          });
          return;
        }
      }

      // Show loading
      Swal.fire({
        title: 'Generating Reports...',
        html: 'Please wait while we compile the reports from the database.',
        didOpen: () => {
          Swal.showLoading();
        },
        allowOutsideClick: false,
        allowEscapeKey: false
      });

      // Send AJAX request
      fetch('{{ route('reports.generate') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
          },
          body: JSON.stringify({
            dateRange: dateRange,
            startDate: dateRange === 'custom' ? startDate : null,
            endDate: dateRange === 'custom' ? endDate : null
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              title: 'Reports Generated!',
              html: `<div class="text-start">
    <p><strong>Date Range:</strong> ${data.data.startDate} to ${data.data.endDate}</p>
    <p><strong>Total Revenue:</strong> ZWL ${Number(data.data.totalRevenue).toLocaleString()}</p>
    <p><strong>Total Orders:</strong> ${data.data.totalOrders}</p>
    <p><strong>Completed Orders:</strong> ${data.data.completedOrders}</p>
    <p><strong>Active Users:</strong> ${data.data.activeUsers}/${data.data.totalUsers}</p>
  </div>`,
              icon: 'success',
              confirmButtonText: 'OK'
            }).then(() => {
              // Reload the page to show updated data
              location.reload();
            });
          } else {
            Swal.fire({
              title: 'Error',
              text: data.message || 'Failed to generate reports',
              icon: 'error'
            });
          }
        })
        .catch(error => {
          console.error('Error:', error);
          Swal.fire({
            title: 'Error',
            text: 'An error occurred while generating reports',
            icon: 'error'
          });
        });
    });

    // PDF Download handlers
    document.querySelectorAll('[data-action^="download-"]').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const action = this.getAttribute('data-action');
      let reportName = '';

      switch (action) {
        case 'download-artisan-report':
          reportName = 'Artisan Performance Report';
          break;
        case 'download-artisan-metrics':
          reportName = 'Artisan Performance Metrics';
          break;
        case 'download-platform-report':
          reportName = 'Platform Usage Report';
          break;
        case 'download-revenue-report':
          reportName = 'Revenue & Financial Report';
          break;
      }

      Swal.fire({
        title: 'Download Report?',
        text: `Download "${reportName}" as PDF?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Download PDF',
        confirmButtonColor: '#696cff',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: 'Downloading...',
            html: `Generating ${reportName}`,
            didOpen: () => {
              Swal.showLoading();
            },
            timer: 2000,
            timerProgressBar: true,
            allowOutsideClick: false,
            allowEscapeKey: false
          }).then(() => {
            Swal.fire('Success!', `${reportName} downloaded successfully`, 'success');
          });
        }
      });
    });
    });
    });
  </script>
@endsection
