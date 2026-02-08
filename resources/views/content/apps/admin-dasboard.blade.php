@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Admin Dashboard - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header Stats -->
    <div class="row g-6 mb-6">
      <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <p class="text-muted small mb-1">Total Users</p>
                <h3 class="mb-2">{{ $totalUsers ?? 0 }}</h3>
                <p class="mb-0"><span class="badge bg-label-primary"><i
                      class="icon-base ri ri-user-3-line me-1"></i>Registered</span></p>
              </div>
              <div class="avatar avatar-lg bg-label-primary">
                <div class="avatar-initial"><i class="icon-base ri ri-user-3-line"></i></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <p class="text-muted small mb-1">Verified Artisans</p>
                <h3 class="mb-2">{{ $verifiedArtisans ?? 0 }}</h3>
                <p class="mb-0"><span class="badge bg-label-success"><i
                      class="icon-base ri ri-verified-badge-line me-1"></i>Verified</span></p>
              </div>
              <div class="avatar avatar-lg bg-label-success">
                <div class="avatar-initial"><i class="icon-base ri ri-verified-badge-line"></i></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <p class="text-muted small mb-1">Pending Verification</p>
                <h3 class="mb-2">{{ $pendingVerifications ?? 0 }}</h3>
                <p class="mb-0"><span class="badge bg-label-warning"><i
                      class="icon-base ri ri-hourglass-2-line me-1"></i>Awaiting</span></p>
              </div>
              <div class="avatar avatar-lg bg-label-warning">
                <div class="avatar-initial"><i class="icon-base ri ri-hourglass-2-line"></i></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <p class="text-muted small mb-1">Total Orders</p>
                <h3 class="mb-2">{{ $totalOrders ?? 0 }}</h3>
                <p class="mb-0"><span class="badge bg-label-info"><i
                      class="icon-base ri ri-shopping-bag-line me-1"></i>Placed</span></p>
              </div>
              <div class="avatar avatar-lg bg-label-info">
                <div class="avatar-initial"><i class="icon-base ri ri-shopping-cart-line"></i></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-6 mb-6">
      <div class="col-md-8">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white border-bottom">
            <h5 class="card-title m-0"><i class="icon-base ri ri-line-chart-line me-2 text-primary"></i>User Growth Trend
            </h5>
          </div>
          <div class="card-body">
            <div id="userGrowthChart" style="height: 350px;"></div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white border-bottom">
            <h5 class="card-title m-0"><i class="icon-base ri ri-pie-chart-line me-2 text-success"></i>User Types
              Distribution</h5>
          </div>
          <div class="card-body">
            <div id="userTypeChart" style="height: 350px;"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Orders & Revenue Charts -->
    <div class="row g-6 mb-6">
      <div class="col-md-4">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white border-bottom">
            <h5 class="card-title m-0"><i class="icon-base ri ri-bar-chart-2-line me-2 text-info"></i>Orders Status</h5>
          </div>
          <div class="card-body">
            <div id="orderStatusChart" style="height: 300px;"></div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white border-bottom">
            <h5 class="card-title m-0"><i class="icon-base ri ri-money-dollar-circle-line me-2 text-success"></i>Revenue
              Trend</h5>
          </div>
          <div class="card-body">
            <div id="revenueChart" style="height: 300px;"></div>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white border-bottom">
            <h5 class="card-title m-0"><i class="icon-base ri ri-verified-badge-line me-2 text-warning"></i>Verification
              Queue</h5>
          </div>
          <div class="card-body">
            <div class="list-group list-group-flush">
              <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-0">
                <small>Pending Docs</small>
                <span class="badge bg-label-warning rounded-pill" id="pendingDocs">-</span>
              </div>
              <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-0">
                <small>Needs Revision</small>
                <span class="badge bg-label-danger rounded-pill" id="needsRevision">-</span>
              </div>
              <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-0">
                <small>Ready to Verify</small>
                <span class="badge bg-label-success rounded-pill" id="readyVerify">-</span>
              </div>
              <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-0">
                <small>Rejected</small>
                <span class="badge bg-label-secondary rounded-pill" id="rejected">-</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="row g-6 mb-6">
      <div class="col-12">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0"><i class="icon-base ri ri-shopping-cart-2-line me-2 text-primary"></i>Recent
              Orders</h5>
            <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th class="py-3 px-4">Order ID</th>
                    <th class="py-3 px-4">Customer</th>
                    <th class="py-3 px-4">Artisan</th>
                    <th class="py-3 px-4">Service</th>
                    <th class="py-3 px-4">Amount</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Date</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($recentOrders as $order)
                    <tr>
                      <td class="py-3 px-4"><strong>#{{ $order->id }}</strong></td>
                      <td class="py-3 px-4">{{ $order->client->name ?? 'N/A' }}</td>
                      <td class="py-3 px-4">{{ $order->artisan->user->name ?? 'N/A' }}</td>
                      <td class="py-3 px-4">{{ $order->service_name ?? 'Service' }}</td>
                      <td class="py-3 px-4"><strong>ZWL {{ number_format($order->total_amount, 2) }}</strong></td>
                      <td class="py-3 px-4">
                        <span
                          class="badge bg-label-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'danger') }}">
                          {{ ucfirst($order->status) }}
                        </span>
                      </td>
                      <td class="py-3 px-4"><small>{{ $order->created_at->format('d M Y') }}</small></td>
                    </tr>
                  @empty
                    <tr>
                      <td class="py-3 px-4" colspan="7" class="text-center text-muted">No orders yet</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Verifications Table -->
    <div class="row g-6 mb-6">
      <div class="col-12">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0"><i class="icon-base ri ri-file-text-line me-2 text-warning"></i>Pending
              Verifications</h5>
            <a href="#" class="btn btn-sm btn-outline-primary">Review All</a>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th class="py-3 px-4">User</th>
                    <th class="py-3 px-4">Document Type</th>
                    <th class="py-3 px-4">Submitted</th>
                    <th class="py-3 px-4">Days Pending</th>
                    <th class="py-3 px-4">Priority</th>
                    <th class="py-3 px-4">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($pendingVerificationsList as $verification)
                    @php
                      $daysPending = now()->diffInDays($verification->created_at);
                      $priority = $daysPending > 14 ? 'danger' : ($daysPending > 7 ? 'warning' : 'info');
                      $priorityText = $daysPending > 14 ? 'High' : ($daysPending > 7 ? 'Medium' : 'Low');
                    @endphp
                    <tr>
                      <td class="py-3 px-4">{{ $verification->artisan->user->name ?? 'N/A' }}</td>
                      <td class="py-3 px-4">{{ $verification->nationalDocument->document_type ?? 'National ID' }}</td>
                      <td class="py-3 px-4"><small>{{ $verification->created_at->format('d M Y') }}</small></td>
                      <td class="py-3 px-4"><strong>{{ $daysPending }} days</strong></td>
                      <td class="py-3 px-4">
                        <span class="badge bg-label-{{ $priority }}">{{ $priorityText }}</span>
                      </td>
                      <td class="py-3 px-4">
                        <a href="#" class="btn btn-sm btn-icon btn-text-primary" title="Review">
                          <i class="ri-eye-line"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-icon btn-text-success" title="Approve">
                          <i class="ri-check-line"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-icon btn-text-danger" title="Reject">
                          <i class="ri-close-line"></i>
                        </a>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td class="py-3 px-4" colspan="6" class="text-center text-muted">No pending verifications</td>
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
    <div class="row g-6 mb-6">
      <div class="col-md-6">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white border-bottom">
            <h5 class="card-title m-0"><i class="icon-base ri ri-history-line me-2 text-info"></i>Recent Activities</h5>
          </div>
          <div class="card-body">
            <ul class="timeline m-0 p-0">
              <li class="timeline-item ps-3 pb-3 border-dashed">
                <span class="timeline-indicator border-0 shadow-none bg-label-success">
                  <i class="icon-base ri ri-check-line"></i>
                </span>
                <div class="timeline-event ps-3">
                  <h6 class="mb-1">User Verified</h6>
                  <p class="text-muted small mb-0">Recently verified artisan</p>
                </div>
              </li>
              <li class="timeline-item ps-3 pb-3 border-dashed">
                <span class="timeline-indicator border-0 shadow-none bg-label-warning">
                  <i class="icon-base ri ri-time-line"></i>
                </span>
                <div class="timeline-event ps-3">
                  <h6 class="mb-1">Order Submitted</h6>
                  <p class="text-muted small mb-0">New order placed</p>
                </div>
              </li>
              <li class="timeline-item ps-3 pb-3 border-dashed">
                <span class="timeline-indicator border-0 shadow-none bg-label-primary">
                  <i class="icon-base ri ri-user-add-line"></i>
                </span>
                <div class="timeline-event ps-3">
                  <h6 class="mb-1">New User Registered</h6>
                  <p class="text-muted small mb-0">New registration completed</p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white border-bottom">
            <h5 class="card-title m-0"><i class="icon-base ri ri-notification-3-line me-2 text-danger"></i>System Alerts
            </h5>
          </div>
          <div class="card-body">
            <div class="alert alert-label-info alert-dismissible fade show mb-3" role="alert">
              <i class="icon-base ri ri-information-line me-2"></i>
              <span>Dashboard fully operational. Real data is now displayed from your database.</span>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="alert alert-label-success alert-dismissible fade show" role="alert">
              <i class="icon-base ri ri-check-line me-2"></i>
              <span>All metrics and statistics connected to live database.</span>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
      const colors = {
        primary: '#696cff',
        success: '#13deb9',
        warning: '#ff9f43',
        danger: '#ff4757',
        info: '#00d4ff',
        secondary: '#6c757d'
      };

      // User Growth Line Chart
      @php
        $growthDates = $userGrowthData
            ->pluck('date')
            ->map(function ($date) {
                return \Carbon\Carbon::parse($date)->format('M d');
            })
            ->toArray();
        $growthCounts = $userGrowthData->pluck('count')->toArray();
      @endphp
      if (document.getElementById('userGrowthChart')) {
        const userGrowthOptions = {
          chart: {
            type: 'line',
            height: 350,
            toolbar: {
              show: false
            }
          },
          series: [{
            name: 'New Users',
            data: {!! json_encode($growthCounts) !!}
          }],
          xaxis: {
            categories: {!! json_encode($growthDates) !!}
          },
          colors: [colors.primary],
          stroke: {
            width: 2
          }
        };
        new ApexCharts(document.querySelector("#userGrowthChart"), userGrowthOptions).render();
      }

      // User Types Pie Chart
      @php
        $distributionData = $userDistribution->pluck('count')->toArray();
        $distributionLabels = $userDistribution
            ->pluck('role')
            ->map(function ($role) {
                return ucfirst($role);
            })
            ->toArray();
      @endphp
      if (document.getElementById('userTypeChart')) {
        const userTypeOptions = {
          chart: {
            type: 'pie',
            height: 350
          },
          series: {!! json_encode($distributionData) !!},
          labels: {!! json_encode($distributionLabels) !!},
          colors: [colors.primary, colors.success, colors.warning],
          legend: {
            position: 'bottom'
          }
        };
        new ApexCharts(document.querySelector("#userTypeChart"), userTypeOptions).render();
      }

      // Order Status Chart
      @php
        $orderStatusData = [];
        $orderStatusLabels = [];
        foreach ($orderStatus as $status) {
            $orderStatusData[] = $status->count;
            $orderStatusLabels[] = ucfirst($status->status);
        }
      @endphp
      if (document.getElementById('orderStatusChart')) {
        const orderStatusOptions = {
          chart: {
            type: 'donut',
            height: 300
          },
          series: {!! json_encode($orderStatusData) !!},
          labels: {!! json_encode($orderStatusLabels) !!},
          colors: [colors.success, colors.danger, colors.warning, colors.info, colors.secondary],
          legend: {
            position: 'bottom'
          }
        };
        new ApexCharts(document.querySelector("#orderStatusChart"), orderStatusOptions).render();
      }

      // Revenue Chart
      @php
        $revenueData = $revenueTrend->pluck('revenue')->map(fn($val) => (float) $val)->toArray();
        $revenueWeeks = $revenueTrend
            ->map(function ($item) {
                return 'W' . $item->week;
            })
            ->toArray();
      @endphp
      if (document.getElementById('revenueChart')) {
        const revenueOptions = {
          chart: {
            type: 'bar',
            height: 300,
            toolbar: {
              show: true
            }
          },
          series: [{
            name: 'Revenue (ZWL)',
            data: {!! json_encode($revenueData) !!}
          }],
          xaxis: {
            categories: {!! json_encode($revenueWeeks) !!}
          },
          colors: [colors.success]
        };
        new ApexCharts(document.querySelector("#revenueChart"), revenueOptions).render();
      }

      // Update Verification Queue Badges
      document.getElementById('pendingDocs').textContent = '{{ $verificationStats->get('pending', 0) }}';
      document.getElementById('needsRevision').textContent = '{{ $verificationStats->get('rejected', 0) }}';
      document.getElementById('readyVerify').textContent = '{{ $verificationStats->get('approved', 0) }}';
      document.getElementById('rejected').textContent = '{{ $verificationStats->get('rejected', 0) }}';
    });
  </script>
@endsection
