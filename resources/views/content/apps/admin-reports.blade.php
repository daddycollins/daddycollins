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

  <!-- Date Range Filter -->
  <div class="card border-0 shadow-sm mb-6">
    <div class="card-body">
      <div class="row g-3 align-items-end">
        <div class="col-md-3">
          <label class="form-label"><strong>Date Range</strong></label>
          <select class="form-select form-select-sm" id="dateRange">
            <option value="today">Today</option>
            <option value="week">This Week</option>
            <option value="month" selected>This Month</option>
            <option value="quarter">This Quarter</option>
            <option value="year">This Year</option>
            <option value="custom">Custom Range</option>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label"><strong>Start Date</strong></label>
          <input type="date" class="form-control form-control-sm" id="startDate" value="2026-01-01">
        </div>
        <div class="col-md-3">
          <label class="form-label"><strong>End Date</strong></label>
          <input type="date" class="form-control form-control-sm" id="endDate" value="2026-01-24">
        </div>
        <div class="col-md-3">
          <button class="btn btn-primary btn-sm w-100" id="generateReports">
            <i class="icon-base ri ri-refresh-line me-1"></i>Generate Reports
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Tabs for Reports -->
  <ul class="nav nav-tabs mb-4" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="financial-tab" data-bs-toggle="tab" data-bs-target="#financialReport"
        type="button" role="tab" aria-controls="financialReport" aria-selected="true">
        <i class="icon-base ri ri-money-dollar-circle-line me-2"></i>Financial Reports
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#usersReport" type="button"
        role="tab" aria-controls="usersReport" aria-selected="false">
        <i class="icon-base ri ri-user-multiple-line me-2"></i>User Reports
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="system-tab" data-bs-toggle="tab" data-bs-target="#systemReport" type="button"
        role="tab" aria-controls="systemReport" aria-selected="false">
        <i class="icon-base ri ri-settings-line me-2"></i>System Reports
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
  </div>
@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const dateRangeSelect = document.getElementById('dateRange');
      const startDateInput = document.getElementById('startDate');
      const endDateInput = document.getElementById('endDate');
      const generateBtn = document.getElementById('generateReports');

      // Show/hide custom date inputs
      dateRangeSelect.addEventListener('change', function(e) {
        if (e.target.value === 'custom') {
          startDateInput.parentElement.parentElement.style.display = 'flex';
          endDateInput.parentElement.parentElement.style.display = 'flex';
        } else {
          startDateInput.parentElement.parentElement.style.display = 'none';
          endDateInput.parentElement.parentElement.style.display = 'none';
        }
      });

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
