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
          <input type="date" class="form-control form-control-sm" id="endDate" value="2026-01-23">
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
      <button class="nav-link active" id="artisan-tab" data-bs-toggle="tab" data-bs-target="#artisanReport" type="button"
        role="tab" aria-controls="artisanReport" aria-selected="true">
        <i class="icon-base ri ri-user-star-line me-2"></i>Artisan Performance
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="platform-tab" data-bs-toggle="tab" data-bs-target="#platformReport" type="button"
        role="tab" aria-controls="platformReport" aria-selected="false">
        <i class="icon-base ri ri-bar-chart-line me-2"></i>Platform Usage
      </button>
    </li>
  </ul>

  <!-- Report Content -->
  <div class="tab-content">
    <!-- Artisan Performance Report -->
    <div class="tab-pane fade show active" id="artisanReport" role="tabpanel" aria-labelledby="artisan-tab">

      <!-- Summary Cards -->
      <div class="row g-6 mb-6">
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Total Artisans</p>
              <h3 class="mb-2">342</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>+12 this month</span></p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Active Artisans</p>
              <h3 class="mb-2">298</h3>
              <p class="mb-0"><span class="badge bg-label-info">87.1% active</span></p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Avg Rating</p>
              <h3 class="mb-2">4.7<span style="font-size: 0.7em;">★</span></h3>
              <p class="mb-0"><span class="badge bg-label-success">Based on 2,847 reviews</span></p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Avg Services</p>
              <h3 class="mb-2">6.2</h3>
              <p class="mb-0"><span class="badge bg-label-info">per artisan</span></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Charts Row -->
      <div class="row g-6 mb-6">
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
              <h5 class="card-title m-0">Top Performing Artisans</h5>
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
                    <th class="py-3">Revenue (MTD)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="py-3"><strong>James Smith</strong><br><small class="text-muted">Plumbing</small></td>
                    <td class="py-3">87</td>
                    <td class="py-3"><span class="text-warning">★★★★★</span> 4.95</td>
                    <td class="py-3"><strong>ZWL 18,240</strong></td>
                  </tr>
                  <tr>
                    <td class="py-3"><strong>Maria Garcia</strong><br><small class="text-muted">Carpentry</small></td>
                    <td class="py-3">76</td>
                    <td class="py-3"><span class="text-warning">★★★★☆</span> 4.82</td>
                    <td class="py-3"><strong>ZWL 16,150</strong></td>
                  </tr>
                  <tr>
                    <td class="py-3"><strong>Robert Brown</strong><br><small class="text-muted">Electrical</small>
                    </td>
                    <td class="py-3">64</td>
                    <td class="py-3"><span class="text-warning">★★★★★</span> 4.88</td>
                    <td class="py-3"><strong>ZWL 14,500</strong></td>
                  </tr>
                  <tr>
                    <td class="py-3"><strong>Lisa Martinez</strong><br><small class="text-muted">Cleaning</small></td>
                    <td class="py-3">92</td>
                    <td class="py-3"><span class="text-warning">★★★★☆</span> 4.76</td>
                    <td class="py-3"><strong>ZWL 12,800</strong></td>
                  </tr>
                  <tr>
                    <td class="py-3"><strong>Christopher Lee</strong><br><small class="text-muted">Furniture</small>
                    </td>
                    <td class="py-3">45</td>
                    <td class="py-3"><span class="text-warning">★★★★★</span> 4.91</td>
                    <td class="py-3"><strong>ZWL 11,250</strong></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title m-0">Artisans by Category</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-sm mb-0">
                  <thead class="bg-light">
                    <tr>
                      <th class="py-3">Category</th>
                      <th class="py-3">Total Artisans</th>
                      <th class="py-3">Active</th>
                      <th class="py-3">Avg Rating</th>
                      <th class="py-3">Total Orders</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="py-3"><strong>Plumbing</strong></td>
                      <td class="py-3">48</td>
                      <td class="py-3">42</td>
                      <td class="py-3"><span class="badge bg-label-success">4.8★</span></td>
                      <td class="py-3">1,240</td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Carpentry</strong></td>
                      <td class="py-3">52</td>
                      <td class="py-3">47</td>
                      <td class="py-3"><span class="badge bg-label-success">4.7★</span></td>
                      <td class="py-3">980</td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Electrical</strong></td>
                      <td class="py-3">38</td>
                      <td class="py-3">35</td>
                      <td class="py-3"><span class="badge bg-label-success">4.9★</span></td>
                      <td class="py-3">850</td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Cleaning</strong></td>
                      <td class="py-3">72</td>
                      <td class="py-3">68</td>
                      <td class="py-3"><span class="badge bg-label-success">4.6★</span></td>
                      <td class="py-3">1,560</td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Painting</strong></td>
                      <td class="py-3">45</td>
                      <td class="py-3">38</td>
                      <td class="py-3"><span class="badge bg-label-success">4.5★</span></td>
                      <td class="py-3">640</td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Furniture</strong></td>
                      <td class="py-3">34</td>
                      <td class="py-3">29</td>
                      <td class="py-3"><span class="badge bg-label-success">4.8★</span></td>
                      <td class="py-3">520</td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Other Services</strong></td>
                      <td class="py-3">53</td>
                      <td class="py-3">39</td>
                      <td class="py-3"><span class="badge bg-label-warning">4.3★</span></td>
                      <td class="py-3">612</td>
                    </tr>
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
              <h5 class="card-title m-0">Artisan Performance Metrics</h5>
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
                      <th class="py-3">Current Month</th>
                      <th class="py-3">Previous Month</th>
                      <th class="py-3">Change</th>
                      <th class="py-3">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="py-3"><strong>Total Services Completed</strong></td>
                      <td class="py-3">4,402</td>
                      <td class="py-3">3,850</td>
                      <td class="py-3"><span class="badge bg-label-success">+14.4%</span></td>
                      <td class="py-3"><span class="badge bg-label-success">Improving</span></td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Average Completion Time</strong></td>
                      <td class="py-3">2.3 days</td>
                      <td class="py-3">2.8 days</td>
                      <td class="py-3"><span class="badge bg-label-success">-17.9%</span></td>
                      <td class="py-3"><span class="badge bg-label-success">Improving</span></td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Platform Avg Rating</strong></td>
                      <td class="py-3">4.72</td>
                      <td class="py-3">4.68</td>
                      <td class="py-3"><span class="badge bg-label-success">+0.86%</span></td>
                      <td class="py-3"><span class="badge bg-label-success">Stable</span></td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Customer Satisfaction Rate</strong></td>
                      <td class="py-3">94.2%</td>
                      <td class="py-3">91.8%</td>
                      <td class="py-3"><span class="badge bg-label-success">+2.4%</span></td>
                      <td class="py-3"><span class="badge bg-label-success">Improving</span></td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Artisan Retention Rate</strong></td>
                      <td class="py-3">87.1%</td>
                      <td class="py-3">85.3%</td>
                      <td class="py-3"><span class="badge bg-label-success">+2.1%</span></td>
                      <td class="py-3"><span class="badge bg-label-success">Improving</span></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Platform Usage Report -->
    <div class="tab-pane fade" id="platformReport" role="tabpanel" aria-labelledby="platform-tab">

      <!-- Summary Cards -->
      <div class="row g-6 mb-6">
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Total Users</p>
              <h3 class="mb-2">1,248</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>+3.2% this month</span></p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Total Orders</p>
              <h3 class="mb-2">8,542</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>+18% this month</span></p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Platform Revenue</p>
              <h3 class="mb-2">ZWL 152.4K</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>+24% this month</span></p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">Monthly Growth</p>
              <h3 class="mb-2">12.8%</h3>
              <p class="mb-0"><span class="badge bg-label-info">Quarter-over-quarter</span></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Usage Metrics -->
      <div class="row g-6 mb-6">
        <div class="col-lg-6">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title m-0">User Activity</h5>
            </div>
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="bg-light">
                  <tr>
                    <th class="py-3">Metric</th>
                    <th class="py-3">Current Month</th>
                    <th class="py-3">Avg Daily</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="py-3"><strong>New User Registrations</strong></td>
                    <td class="py-3">38</td>
                    <td class="py-3">1.3</td>
                  </tr>
                  <tr>
                    <td class="py-3"><strong>Active Daily Users</strong></td>
                    <td class="py-3">587</td>
                    <td class="py-3">587</td>
                  </tr>
                  <tr>
                    <td class="py-3"><strong>Active Monthly Users</strong></td>
                    <td class="py-3">1,120</td>
                    <td class="py-3">—</td>
                  </tr>
                  <tr>
                    <td class="py-3"><strong>Average Session Duration</strong></td>
                    <td class="py-3">14.2 min</td>
                    <td class="py-3">14.2 min</td>
                  </tr>
                  <tr>
                    <td class="py-3"><strong>User Churn Rate</strong></td>
                    <td class="py-3">2.4%</td>
                    <td class="py-3">—</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
              <h5 class="card-title m-0">Order Statistics</h5>
              <button class="btn btn-sm btn-outline-primary" data-action="download-platform-report">
                <i class="icon-base ri ri-download-cloud-line me-1"></i>Download PDF
              </button>
            </div>
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="bg-light">
                  <tr>
                    <th class="py-3">Metric</th>
                    <th class="py-3">Count</th>
                    <th class="py-3">% of Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="py-3"><strong>Orders Completed</strong></td>
                    <td class="py-3">7,248</td>
                    <td class="py-3">84.8%</td>
                  </tr>
                  <tr>
                    <td class="py-3"><strong>Orders In Progress</strong></td>
                    <td class="py-3">324</td>
                    <td class="py-3">3.8%</td>
                  </tr>
                  <tr>
                    <td class="py-3"><strong>Orders Cancelled</strong></td>
                    <td class="py-3">612</td>
                    <td class="py-3">7.2%</td>
                  </tr>
                  <tr>
                    <td class="py-3"><strong>Orders Failed/Refunded</strong></td>
                    <td class="py-3">358</td>
                    <td class="py-3">4.2%</td>
                  </tr>
                  <tr>
                    <td class="py-3"><strong>Avg Order Value</strong></td>
                    <td class="py-3">ZWL 612</td>
                    <td class="py-3">—</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Revenue & Growth -->
      <div class="row g-6">
        <div class="col-lg-12">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
              <h5 class="card-title m-0">Revenue & Financial Metrics</h5>
              <button class="btn btn-sm btn-outline-primary" data-action="download-revenue-report">
                <i class="icon-base ri ri-download-cloud-line me-1"></i>Download PDF
              </button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover mb-0">
                  <thead class="bg-light">
                    <tr>
                      <th class="py-3">Metric</th>
                      <th class="py-3">Current Month</th>
                      <th class="py-3">Previous Month</th>
                      <th class="py-3">Change</th>
                      <th class="py-3">YTD Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="py-3"><strong>Total Platform Revenue</strong></td>
                      <td class="py-3">ZWL 152,400</td>
                      <td class="py-3">ZWL 125,600</td>
                      <td class="py-3"><span class="badge bg-label-success">+21.3%</span></td>
                      <td class="py-3">ZWL 278,000</td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Commission Revenue (10%)</strong></td>
                      <td class="py-3">ZWL 15,240</td>
                      <td class="py-3">ZWL 12,560</td>
                      <td class="py-3"><span class="badge bg-label-success">+21.3%</span></td>
                      <td class="py-3">ZWL 27,800</td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Artisan Payouts</strong></td>
                      <td class="py-3">ZWL 137,160</td>
                      <td class="py-3">ZWL 113,040</td>
                      <td class="py-3"><span class="badge bg-label-success">+21.3%</span></td>
                      <td class="py-3">ZWL 250,200</td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Operating Costs</strong></td>
                      <td class="py-3">ZWL 8,500</td>
                      <td class="py-3">ZWL 8,200</td>
                      <td class="py-3"><span class="badge bg-label-warning">+3.7%</span></td>
                      <td class="py-3">ZWL 16,700</td>
                    </tr>
                    <tr>
                      <td class="py-3"><strong>Net Profit</strong></td>
                      <td class="py-3">ZWL 6,740</td>
                      <td class="py-3">ZWL 4,360</td>
                      <td class="py-3"><span class="badge bg-label-success">+54.6%</span></td>
                      <td class="py-3">ZWL 11,100</td>
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
  <div class="row g-6">
    <!-- Gamification Card -->
    <div class="col-md-12 col-xxl-8">
      <div class="card">
        <div class="d-flex align-items-end row">
          <div class="col-md-6 order-2 order-md-1">
            <div class="card-body">
              <h4 class="card-title mb-4">Congratulations <span class="fw-bold">John!</span> 🎉</h4>
              <p class="mb-0">You have done 68% 😎 more sales today.</p>
              <p>Check your new badge in your profile.</p>
              <a href="javascript:;" class="btn btn-primary">View Profile</a>
            </div>
          </div>
          <div class="col-md-6 text-center text-md-end order-1 order-md-2">
            <div class="card-body pb-0 px-0 pt-2">
              <img src="{{ asset('assets/img/illustrations/illustration-john-' . $configData['theme'] . '.png') }}"
                height="186" class="scaleX-n1-rtl" alt="View Profile"
                data-app-light-img="illustrations/illustration-john-light.png"
                data-app-dark-img="illustrations/illustration-john-dark.png" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Gamification Card -->

    <!-- Statistics Total Order -->
    <div class="col-xxl-2 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
            <div class="avatar">
              <div class="avatar-initial bg-label-primary rounded-3">
                <i class="icon-base ri ri-shopping-cart-2-line icon-24px"></i>
              </div>
            </div>
            <div class="d-flex align-items-center">
              <p class="mb-0 text-success me-1">+22%</p>
              <i class="icon-base ri ri-arrow-up-s-line text-success"></i>
            </div>
          </div>
          <div class="card-info mt-5">
            <h5 class="mb-1">155k</h5>
            <p>Total Orders</p>
            <div class="badge bg-label-secondary rounded-pill">Last 4 Month</div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Statistics Total Order -->

    <!-- Sessions line chart -->
    <div class="col-xxl-2 col-sm-6">
      <div class="card h-100">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center mb-1 flex-wrap">
            <h5 class="mb-0 me-1">$38.5k</h5>
            <p class="mb-0 text-success">+62%</p>
          </div>
          <span class="d-block card-subtitle">Sessions</span>
        </div>
        <div class="card-body">
          <div id="sessions"></div>
        </div>
      </div>
    </div>
    <!--/ Sessions line chart -->

    <!-- Total Transactions & Report Chart -->
    <div class="col-12 col-xxl-8">
      <div class="card h-100">
        <div class="row row-bordered g-0 h-100">
          <div class="col-md-7 col-12 order-2 order-md-0">
            <div class="card-header">
              <h5 class="mb-0">Total Transactions</h5>
            </div>
            <div class="card-body">
              <div id="totalTransactionChart"></div>
            </div>
          </div>
          <div class="col-md-5 col-12">
            <div class="card-header">
              <div class="d-flex justify-content-between">
                <h5 class="mb-1">Report</h5>
                <div class="dropdown">
                  <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-1" type="button"
                    id="totalTransaction" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-base ri ri-more-2-line"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalTransaction">
                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                    <a class="dropdown-item" href="javascript:void(0);">Share</a>
                    <a class="dropdown-item" href="javascript:void(0);">Update</a>
                  </div>
                </div>
              </div>
              <p class="mb-0 card-subtitle">Last month transactions $234.40k</p>
            </div>
            <div class="card-body pt-6">
              <div class="row">
                <div class="col-6 border-end">
                  <div class="d-flex flex-column align-items-center">
                    <div class="avatar">
                      <div class="avatar-initial bg-label-success rounded-3">
                        <div class="icon-base ri ri-pie-chart-2-line icon-24px"></div>
                      </div>
                    </div>
                    <p class="mt-3 mb-1">This Week</p>
                    <h6 class="mb-0">+82.45%</h6>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex flex-column align-items-center">
                    <div class="avatar">
                      <div class="avatar-initial bg-label-primary rounded-3">
                        <div class="icon-base ri ri-money-dollar-circle-line icon-24px"></div>
                      </div>
                    </div>
                    <p class="mt-3 mb-1">This Week</p>
                    <h6 class="mb-0">-24.86%</h6>
                  </div>
                </div>
              </div>
              <hr class="my-5" />
              <div class="d-flex justify-content-around align-items-center flex-wrap gap-2">
                <div>
                  <p class="mb-1">Performance</p>
                  <h6 class="mb-0">+94.15%</h6>
                </div>
                <div>
                  <button class="btn btn-primary" type="button">view report</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Total Transactions & Report Chart -->

    <!-- Performance Chart -->
    <div class="col-12 col-xxl-4 col-md-6">
      <div class="card h-100">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <h5 class="mb-1">Performance</h5>
            <div class="dropdown">
              <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-1" type="button"
                id="performanceDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-base ri ri-more-2-line"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="performanceDropdown">
                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div id="performanceChart"></div>
        </div>
      </div>
    </div>
    <!--/ Performance Chart -->

    <!-- Project Statistics -->
    <div class="col-md-6 col-xxl-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0 me-2">Project Statistics</h5>
          <div class="dropdown">
            <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-1" type="button"
              id="projectStatus" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-base ri ri-more-2-line"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectStatus">
              <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
              <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
              <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-between p-4 border-bottom">
          <p class="mb-0 fs-xsmall">NAME</p>
          <p class="mb-0 fs-xsmall">BUDGET</p>
        </div>
        <div class="card-body">
          <ul class="p-0 m-0">
            <li class="d-flex align-items-center mb-6">
              <div class="avatar avatar-md flex-shrink-0 me-4">
                <div class="avatar-initial bg-lightest rounded-3">
                  <div>
                    <img src="{{ asset('assets/img/icons/misc/3d-illustration.png') }}" alt="User"
                      class="h-25" />
                  </div>
                </div>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-1">3D Illustration</h6>
                  <small>Blender Illustration</small>
                </div>
                <div class="badge bg-label-primary rounded-pill">$6,500</div>
              </div>
            </li>
            <li class="d-flex align-items-center mb-6">
              <div class="avatar avatar-md flex-shrink-0 me-4">
                <div class="avatar-initial bg-lightest rounded-3">
                  <div>
                    <img src="{{ asset('assets/img/icons/misc/finance-app-design.png') }}" alt="User"
                      class="h-25" />
                  </div>
                </div>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-1">Finance App Design</h6>
                  <small>Figma UI Kit</small>
                </div>
                <div class="badge bg-label-primary rounded-pill">$4,290</div>
              </div>
            </li>
            <li class="d-flex align-items-center mb-6">
              <div class="avatar avatar-md flex-shrink-0 me-4">
                <div class="avatar-initial bg-lightest rounded-3">
                  <div>
                    <img src="{{ asset('assets/img/icons/misc/4-square.png') }}" alt="User" class="h-25" />
                  </div>
                </div>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-1">4 Square</h6>
                  <small>Android Application</small>
                </div>
                <div class="badge bg-label-primary rounded-pill">$44,500</div>
              </div>
            </li>
            <li class="d-flex align-items-center mb-6">
              <div class="avatar avatar-md flex-shrink-0 me-4">
                <div class="avatar-initial bg-lightest rounded-3">
                  <div>
                    <img src="{{ asset('assets/img/icons/misc/delta-web-app.png') }}" alt="User" class="h-25" />
                  </div>
                </div>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-1">Delta Web App</h6>
                  <small>React Dashboard</small>
                </div>
                <div class="badge bg-label-primary rounded-pill">$12,690</div>
              </div>
            </li>
            <li class="d-flex align-items-center">
              <div class="avatar avatar-md flex-shrink-0 me-4">
                <div class="avatar-initial bg-lightest rounded-3">
                  <div>
                    <img src="{{ asset('assets/img/icons/misc/ecommerce-website.png') }}" alt="User"
                      class="h-25" />
                  </div>
                </div>
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                <div class="me-2">
                  <h6 class="mb-1">eCommerce Website</h6>
                  <small>Vue + Laravel</small>
                </div>
                <div class="badge bg-label-primary rounded-pill">$10,850</div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!--/ Project Statistics -->

    <!-- Multiple widgets -->
    <div class="col-md-6 col-xxl-4">
      <div class="row g-4">
        <!-- Total Revenue chart -->
        <div class="col-md-6 col-sm-6">
          <div class="card h-100">
            <div class="card-header pb-xl-8">
              <div class="d-flex align-items-center mb-1 flex-wrap">
                <h5 class="mb-0 me-1">$42.5k</h5>
                <p class="mb-0 text-danger">-22%</p>
              </div>
              <span class="d-block card-subtitle">Total Revenue</span>
            </div>
            <div class="card-body">
              <div id="totalRevenue"></div>
            </div>
          </div>
        </div>
        <!--/ Total Revenue chart -->

        <div class="col-md-6 col-sm-6">
          <div class="card h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                <div class="avatar">
                  <div class="avatar-initial bg-label-success rounded-3">
                    <i class="icon-base ri ri-handbag-line icon-24px"></i>
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <p class="mb-0 text-success me-1">+38%</p>
                  <i class="icon-base ri ri-arrow-up-s-line text-success"></i>
                </div>
              </div>
              <div class="card-info mt-5 mt-xl-8">
                <h5 class="mb-1">$13.4k</h5>
                <p>Total Sales</p>
                <div class="badge bg-label-secondary rounded-pill">Last Six Month</div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-sm-6">
          <div class="card h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                <div class="avatar">
                  <div class="avatar-initial bg-label-info rounded-3">
                    <i class="icon-base ri ri-links-line icon-24px"></i>
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <p class="mb-0 text-success me-1">+62%</p>
                  <i class="icon-base ri ri-arrow-up-s-line text-success"></i>
                </div>
              </div>
              <div class="card-info mt-5 mt-xl-8">
                <h5 class="mb-1">142.8k</h5>
                <p>Total Impression</p>
                <div class="badge bg-label-secondary rounded-pill">Last One Year</div>
              </div>
            </div>
          </div>
        </div>
        <!-- overview Radial chart -->
        <div class="col-md-6 col-sm-6">
          <div class="card h-100">
            <div class="card-header pb-xl-7">
              <div class="d-flex align-items-center mb-1 flex-wrap">
                <h5 class="mb-0 me-1">$67.1k</h5>
                <p class="mb-0 text-success">+49%</p>
              </div>
              <span class="d-block card-subtitle">Overview</span>
            </div>
            <div class="card-body pb-xl-8">
              <div id="overviewChart" class="d-flex align-items-center"></div>
            </div>
          </div>
        </div>
        <!--/ overview Radial chart -->
      </div>
    </div>
    <!--/ Multiple widgets -->

    <!-- Sales Country Chart -->
    <div class="col-12 col-xxl-4 col-md-6">
      <div class="card h-100">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <h5 class="mb-1">Sales Country</h5>
            <div class="dropdown">
              <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-1" type="button"
                id="salesCountryDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-base ri ri-more-2-line"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesCountryDropdown">
                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
              </div>
            </div>
          </div>
          <p class="mb-0 card-subtitle">Total $42,580 Sales</p>
        </div>
        <div class="card-body pb-1 px-0">
          <div id="salesCountryChart"></div>
        </div>
      </div>
    </div>
    <!--/ Sales Country Chart -->

    <!-- Top Referral Source  -->
    <div class="col-12 col-xxl-8">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between">
          <div>
            <h5 class="card-title mb-1">Top Referral Sources</h5>
            <p class="card-subtitle mb-0">Number of Sales</p>
          </div>
          <div class="dropdown">
            <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-1" type="button"
              id="earningReportsTabsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-base ri ri-more-2-line"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsTabsId">
              <a class="dropdown-item" href="javascript:void(0);">View More</a>
              <a class="dropdown-item" href="javascript:void(0);">Delete</a>
            </div>
          </div>
        </div>
        <div class="card-body pb-0">
          <ul class="nav nav-tabs nav-tabs-widget pb-6 gap-4 mx-1 d-flex flex-nowrap" role="tablist">
            <li class="nav-item">
              <a href="javascript:void(0);"
                class="nav-link btn active d-flex flex-column align-items-center justify-content-center" role="tab"
                data-bs-toggle="tab" data-bs-target="#navs-orders-id" aria-controls="navs-orders-id"
                aria-selected="true">
                <div class="avatar avatar-sm">
                  <img src="{{ asset('assets/img/icons/brands/google.png') }}" alt="User" />
                </div>
              </a>
            </li>
            <li class="nav-item">
              <a href="javascript:void(0);"
                class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab"
                data-bs-toggle="tab" data-bs-target="#navs-sales-id" aria-controls="navs-sales-id"
                aria-selected="false">
                <div class="avatar avatar-sm">
                  <img src="{{ asset('assets/img/icons/brands/facebook-rounded.png') }}" alt="User" />
                </div>
              </a>
            </li>
            <li class="nav-item">
              <a href="javascript:void(0);"
                class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab"
                data-bs-toggle="tab" data-bs-target="#navs-profit-id" aria-controls="navs-profit-id"
                aria-selected="false">
                <div class="avatar avatar-sm">
                  <img src="{{ asset('assets/img/icons/brands/instagram-rounded.png') }}" alt="User" />
                </div>
              </a>
            </li>
            <li class="nav-item">
              <a href="javascript:void(0);"
                class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab"
                data-bs-toggle="tab" data-bs-target="#navs-income-id" aria-controls="navs-income-id"
                aria-selected="false">
                <div class="avatar avatar-sm">
                  <img src="{{ asset('assets/img/icons/brands/reddit-rounded.png') }}" alt="User" />
                </div>
              </a>
            </li>
            <li class="nav-item">
              <a href="javascript:void(0);"
                class="nav-link btn d-flex align-items-center justify-content-center disabled" role="tab"
                data-bs-toggle="tab" aria-selected="false">
                <div class="avatar avatar-sm">
                  <div class="avatar-initial bg-label-secondary text-body rounded">
                    <i class="icon-base ri ri-add-line icon-22px"></i>
                  </div>
                </div>
              </a>
            </li>
          </ul>
        </div>
        <div class="tab-content p-0">
          <div class="tab-pane fade show active" id="navs-orders-id" role="tabpanel">
            <div class="table-responsive text-nowrap">
              <table class="table border-top">
                <thead>
                  <tr>
                    <th class="bg-transparent border-bottom">Product Name</th>
                    <th class="bg-transparent border-bottom">STATUS</th>
                    <th class="text-end bg-transparent border-bottom">Profit</th>
                    <th class="text-end bg-transparent border-bottom">REVENUE</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  <tr>
                    <td>Email Marketing Campaign</td>
                    <td>
                      <div class="badge bg-label-primary rounded-pill">Active</div>
                    </td>
                    <td class="text-success fw-medium text-end">+24%</td>
                    <td class="text-end fw-medium">$42,857</td>
                  </tr>
                  <tr>
                    <td>Google Workspace</td>
                    <td>
                      <div class="badge bg-label-success rounded-pill">Completed</div>
                    </td>
                    <td class="text-danger fw-medium text-end">-12%</td>
                    <td class="text-end fw-medium">$850</td>
                  </tr>
                  <tr>
                    <td>Affiliation Program</td>
                    <td>
                      <div class="badge bg-label-primary rounded-pill">Active</div>
                    </td>
                    <td class="text-success fw-medium text-end">+24%</td>
                    <td class="text-end fw-medium">$5,576</td>
                  </tr>
                  <tr>
                    <td>Google Adsense</td>
                    <td>
                      <div class="badge bg-label-info rounded-pill">In Draft</div>
                    </td>
                    <td class="text-success fw-medium text-end">+0%</td>
                    <td class="text-end fw-medium">0</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="navs-sales-id" role="tabpanel">
            <div class="table-responsive text-nowrap">
              <table class="table border-top">
                <thead>
                  <tr>
                    <th class="bg-transparent border-bottom">Product Name</th>
                    <th class="bg-transparent border-bottom">STATUS</th>
                    <th class="text-end bg-transparent border-bottom">Profit</th>
                    <th class="text-end bg-transparent border-bottom">REVENUE</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  <tr>
                    <td>facebook Adsense</td>
                    <td>
                      <div class="badge bg-label-info rounded-pill">In Draft</div>
                    </td>
                    <td class="text-success fw-medium text-end">+5%</td>
                    <td class="text-end fw-medium">$5</td>
                  </tr>
                  <tr>
                    <td>Affiliation Program</td>
                    <td>
                      <div class="badge bg-label-primary rounded-pill">Active</div>
                    </td>
                    <td class="text-danger fw-medium text-end">-24%</td>
                    <td class="text-end fw-medium">$5,576</td>
                  </tr>
                  <tr>
                    <td>Email Marketing Campaign</td>
                    <td>
                      <div class="badge bg-label-warning rounded-pill">warning</div>
                    </td>
                    <td class="text-success fw-medium text-end">+5%</td>
                    <td class="text-end fw-medium">$2,857</td>
                  </tr>
                  <tr>
                    <td>facebook Workspace</td>
                    <td>
                      <div class="badge bg-label-success rounded-pill">Completed</div>
                    </td>
                    <td class="text-danger fw-medium text-end">-12%</td>
                    <td class="text-end fw-medium">$850</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="navs-profit-id" role="tabpanel">
            <div class="table-responsive text-nowrap">
              <table class="table border-top">
                <thead>
                  <tr>
                    <th class="bg-transparent border-bottom">Product Name</th>
                    <th class="bg-transparent border-bottom">STATUS</th>
                    <th class="text-end bg-transparent border-bottom">Profit</th>
                    <th class="text-end bg-transparent border-bottom">REVENUE</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  <tr>
                    <td>Affiliation Program</td>
                    <td>
                      <div class="badge bg-label-primary rounded-pill">Active</div>
                    </td>
                    <td class="text-danger fw-medium text-end">-24%</td>
                    <td class="text-end fw-medium">$5,576</td>
                  </tr>
                  <tr>
                    <td>instagram Adsense</td>
                    <td>
                      <div class="badge bg-label-info rounded-pill">In Draft</div>
                    </td>
                    <td class="text-success fw-medium text-end">+5%</td>
                    <td class="text-end fw-medium">$5</td>
                  </tr>
                  <tr>
                    <td>instagram Workspace</td>
                    <td>
                      <div class="badge bg-label-success rounded-pill">Completed</div>
                    </td>
                    <td class="text-danger fw-medium text-end">-12%</td>
                    <td class="text-end fw-medium">$850</td>
                  </tr>
                  <tr>
                    <td>Email Marketing Campaign</td>
                    <td>
                      <div class="badge bg-label-danger rounded-pill">warning</div>
                    </td>
                    <td class="text-danger fw-medium text-end">-5%</td>
                    <td class="text-end fw-medium">$857</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="navs-income-id" role="tabpanel">
            <div class="table-responsive text-nowrap">
              <table class="table border-top">
                <thead>
                  <tr>
                    <th class="bg-transparent border-bottom">Product Name</th>
                    <th class="bg-transparent border-bottom">STATUS</th>
                    <th class="text-end bg-transparent border-bottom">Profit</th>
                    <th class="text-end bg-transparent border-bottom">REVENUE</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  <tr>
                    <td>reddit Workspace</td>
                    <td>
                      <div class="badge bg-label-warning rounded-pill">process</div>
                    </td>
                    <td class="text-danger fw-medium text-end">-12%</td>
                    <td class="text-end fw-medium">$850</td>
                  </tr>
                  <tr>
                    <td>Affiliation Program</td>
                    <td>
                      <div class="badge bg-label-primary rounded-pill">Active</div>
                    </td>
                    <td class="text-danger fw-medium text-end">-24%</td>
                    <td class="text-end fw-medium">$5,576</td>
                  </tr>
                  <tr>
                    <td>reddit Adsense</td>
                    <td>
                      <div class="badge bg-label-info rounded-pill">In Draft</div>
                    </td>
                    <td class="text-success fw-medium text-end">+5%</td>
                    <td class="text-end fw-medium">$5</td>
                  </tr>
                  <tr>
                    <td>Email Marketing Campaign</td>
                    <td>
                      <div class="badge bg-label-success rounded-pill">Completed</div>
                    </td>
                    <td class="text-success fw-medium text-end">+50%</td>
                    <td class="text-end fw-medium">$857</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Top Referral Source  -->

    <!-- Weekly Sales Chart-->
    <div class="col-12 col-xxl-4 col-md-6">
      <div class="card h-100">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <h5 class="mb-1">Weekly Sales</h5>
            <div class="dropdown">
              <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-1" type="button"
                id="weeklySalesDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-base ri ri-more-2-line"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="weeklySalesDropdown">
                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                <a class="dropdown-item" href="javascript:void(0);">Update</a>
                <a class="dropdown-item" href="javascript:void(0);">Share</a>
              </div>
            </div>
          </div>
          <p class="mb-0 card-subtitle">Total 85.4k Sales</p>
        </div>
        <div class="card-body">
          <div class="row mb-7 mb-xl-12">
            <div class="col-6 d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-label-primary rounded">
                  <i class="icon-base ri ri-funds-line icon-24px"></i>
                </div>
              </div>
              <div class="ms-3 d-flex flex-column">
                <p class="mb-0">Net Income</p>
                <h6 class="mb-0">$438.5K</h6>
              </div>
            </div>
            <div class="col-6 d-flex align-items-center">
              <div class="avatar">
                <div class="avatar-initial bg-label-warning rounded">
                  <i class="icon-base ri ri-money-dollar-circle-line icon-24px"></i>
                </div>
              </div>
              <div class="ms-3 d-flex flex-column">
                <p class="mb-0">Expense</p>
                <h6 class="mb-0">$22.4K</h6>
              </div>
            </div>
          </div>
          <div id="weeklySalesChart"></div>
        </div>
      </div>
    </div>
    <!--/ Weekly Sales Chart-->

    <!-- visits By Day Chart-->
    <div class="col-12 col-xxl-4 col-md-6">
      <div class="card h-100">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <h5 class="mb-1">Visits by Day</h5>
            <div class="dropdown">
              <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-1" type="button"
                id="visitsByDayDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-base ri ri-more-2-line"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="visitsByDayDropdown">
                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                <a class="dropdown-item" href="javascript:void(0);">Update</a>
                <a class="dropdown-item" href="javascript:void(0);">Share</a>
              </div>
            </div>
          </div>
          <p class="mb-0 card-subtitle">Total 248.5k Visits</p>
        </div>
        <div class="card-body pt-xl-5">
          <div id="visitsByDayChart"></div>
          <div class="d-flex justify-content-between mt-6">
            <div>
              <h6 class="mb-0">Most Visited Day</h6>
              <p class="mb-0 small">Total 62.4k Visits on Thursday</p>
            </div>
            <div class="avatar">
              <div class="avatar-initial bg-label-warning rounded">
                <i class="icon-base ri ri-arrow-right-s-line icon-24px scaleX-n1-rtl"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ visits By Day Chart-->

    <!-- Activity Timeline -->
    <div class="col-12 col-xxl-8">
      <div class="card h-100">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <h5 class="mb-0">Activity Timeline</h5>
          </div>
        </div>
        <div class="card-body pt-4">
          <ul class="timeline card-timeline mb-0">
            <li class="timeline-item timeline-item-transparent">
              <span class="timeline-point timeline-point-primary"></span>
              <div class="timeline-event">
                <div class="timeline-header mb-3">
                  <h6 class="mb-0">12 Invoices have been paid</h6>
                  <small class="text-body-secondary">12 min ago</small>
                </div>
                <p class="mb-2">Invoices have been paid to the company</p>
                <div class="d-flex align-items-center mb-1">
                  <div class="badge bg-lighter rounded-3">
                    <img src="{{ asset('assets//img/icons/misc/pdf.png') }}" alt="img" width="20"
                      class="me-2" />
                    <span class="h6 mb-0">invoices.pdf</span>
                  </div>
                </div>
              </div>
            </li>
            <li class="timeline-item timeline-item-transparent">
              <span class="timeline-point timeline-point-success"></span>
              <div class="timeline-event">
                <div class="timeline-header mb-3">
                  <h6 class="mb-0">Client Meeting</h6>
                  <small class="text-body-secondary">45 min ago</small>
                </div>
                <p class="mb-2">Project meeting with john @10:15am</p>
                <div class="d-flex justify-content-between flex-wrap gap-2">
                  <div class="d-flex flex-wrap align-items-center">
                    <div class="avatar avatar-sm me-2">
                      <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle" />
                    </div>
                    <div>
                      <p class="mb-0 small fw-medium">Lester McCarthy (Client)</p>
                      <small>CEO of ThemeSelection</small>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li class="timeline-item timeline-item-transparent">
              <span class="timeline-point timeline-point-info"></span>
              <div class="timeline-event">
                <div class="timeline-header mb-3">
                  <h6 class="mb-0">Create a new project for client</h6>
                  <small class="text-body-secondary">2 Day Ago</small>
                </div>
                <p class="mb-2">6 team members in a project</p>
                <ul class="list-group list-group-flush">
                  <li
                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap border-top-0 p-0">
                    <div class="d-flex flex-wrap align-items-center">
                      <ul class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">
                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                          title="Vinnie Mostowy" class="avatar pull-up">
                          <img class="rounded-circle" src="{{ asset('assets/img/avatars/5.png') }}" alt="Avatar" />
                        </li>
                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                          title="Allen Rieske" class="avatar pull-up">
                          <img class="rounded-circle" src="{{ asset('assets/img/avatars/12.png') }}" alt="Avatar" />
                        </li>
                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" </div>
                          <!-- Activity Timeline -->
                    </div>

                  @endsection

                  @section('page-script')
                    <script>
                      document.addEventListener('DOMContentLoaded', function() {
                        // Date range change handler
                        document.getElementById('dateRange').addEventListener('change', function(e) {
                          if (e.target.value === 'custom') {
                            // Show custom date inputs
                            document.getElementById('startDate').style.display = 'block';
                            document.getElementById('endDate').style.display = 'block';
                          }
                        });

                        // Generate reports button
                        document.getElementById('generateReports').addEventListener('click', function() {
                          const dateRange = document.getElementById('dateRange').value;
                          const startDate = document.getElementById('startDate').value;
                          const endDate = document.getElementById('endDate').value;

                          Swal.fire({
                            title: 'Generating Reports...',
                            html: 'Please wait while we compile the reports from the database.',
                            didOpen: () => {
                              Swal.showLoading();
                            },
                            timer: 2000,
                            timerProgressBar: true
                          }).then(() => {
                            Swal.fire({
                              title: 'Reports Generated!',
                              text: `Reports generated for ${dateRange} (${startDate} to ${endDate})`,
                              icon: 'success'
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
                                // Simulate PDF generation and download
                                const link = document.createElement('a');
                                link.href = '#';
                                link.download =
                                  `${reportName.replace(/\s+/g, '_')}_${new Date().toISOString().split('T')[0]}.pdf`;

                                Swal.fire({
                                  title: 'PDF Generated!',
                                  text: `${reportName} has been generated and is ready for download.`,
                                  icon: 'success',
                                  confirmButtonText: 'OK',
                                  confirmButtonColor: '#71dd5a'
                                });
                              }
                            });
                          });
                        });
                      });
                    </script>
                  @endsection
