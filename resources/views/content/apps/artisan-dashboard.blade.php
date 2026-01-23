@extends('layouts/layoutMaster')

@section('title', 'Artisan Dashboard - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss'])
@endsection

@section('page-style')
  @vite(['resources/assets/vendor/scss/pages/page-profile.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('page-script')
  @vite('resources/assets/js/app-ecommerce-dashboard.js')
@endsection

@section('content')
  <!-- Header -->
  <div class="row mb-6">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h4 class="mb-1">Welcome Back, John Mbewe!</h4>
          <p class="text-muted mb-0">Here's your performance overview for today</p>
        </div>
        <div class="d-flex gap-2">
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
            <i class="icon-base ri ri-add-line me-1"></i>Add Service
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Verification & Status Section -->
  <div class="row g-6 mb-6">
    <!-- Verification Status -->
    <div class="col-lg-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
              <h6 class="text-muted mb-1">Verification Status</h6>
              <h4 class="mb-0">
                <span class="badge bg-success">
                  <i class="icon-base ri ri-check-double-line me-1"></i>Verified
                </span>
              </h4>
            </div>
            <div class="avatar bg-label-success">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-verified-badge-line icon-24px"></i>
              </div>
            </div>
          </div>
          <small class="text-muted">All requirements completed. Your profile is trusted.</small>
        </div>
      </div>
    </div>

    <!-- Average Rating -->
    <div class="col-lg-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
              <h6 class="text-muted mb-1">Average Rating</h6>
              <h4 class="mb-0">4.8/5</h4>
            </div>
            <div class="avatar bg-label-warning">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-star-fill icon-24px"></i>
              </div>
            </div>
          </div>
          <div class="text-warning small">
            <i class="icon-base ri ri-star-fill"></i>
            <i class="icon-base ri ri-star-fill"></i>
            <i class="icon-base ri ri-star-fill"></i>
            <i class="icon-base ri ri-star-fill"></i>
            <i class="icon-base ri ri-star-half-fill"></i>
            <span class="text-muted">(126 reviews)</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Orders -->
    <div class="col-lg-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
              <h6 class="text-muted mb-1">Total Orders</h6>
              <h4 class="mb-0">148</h4>
            </div>
            <div class="avatar bg-label-primary">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-shopping-bag-line icon-24px"></i>
              </div>
            </div>
          </div>
          <small class="text-success"><i class="icon-base ri ri-arrow-up-s-line me-1"></i>+12% this month</small>
        </div>
      </div>
    </div>

    <!-- Total Earnings -->
    <div class="col-lg-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
              <h6 class="text-muted mb-1">Total Earnings</h6>
              <h4 class="mb-0">ZWL 42,580</h4>
            </div>
            <div class="avatar bg-label-success">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-money-dollar-circle-line icon-24px"></i>
              </div>
            </div>
          </div>
          <small class="text-success"><i class="icon-base ri ri-arrow-up-s-line me-1"></i>+8% vs last month</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Performance Charts -->
  <div class="row g-6 mb-6">
    <!-- Orders Trend -->
    <div class="col-lg-8">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">Orders Trend</h5>
          <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-secondary active">Weekly</button>
            <button type="button" class="btn btn-outline-secondary">Monthly</button>
          </div>
        </div>
        <div class="card-body">
          <div id="ordersTrendChart" style="height: 300px;"></div>
        </div>
      </div>
    </div>

    <!-- Completion Rate -->
    <div class="col-lg-4">
      <div class="card h-100">
        <div class="card-header">
          <h5 class="card-title mb-0">Order Completion Rate</h5>
        </div>
        <div class="card-body">
          <div class="text-center mb-4">
            <div id="completionRateChart" style="height: 200px;"></div>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="small">Completed</span>
            <span class="badge bg-success">142</span>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="small">In Progress</span>
            <span class="badge bg-info">4</span>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="small">Pending</span>
            <span class="badge bg-warning">2</span>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <span class="small">Cancelled</span>
            <span class="badge bg-danger">0</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Services & Recent Orders -->
  <div class="row g-6">
    <!-- Active Services -->
    <div class="col-lg-6">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">My Services</h5>
          <a href="javascript:void(0);" class="btn btn-sm btn-primary">View All</a>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>Service Name</th>
                <th>Hourly Rate</th>
                <th>Orders</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2">
                      <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Service" class="rounded" />
                    </div>
                    <span>Pipe Installation & Repair</span>
                  </div>
                </td>
                <td>ZWL 250</td>
                <td><span class="badge bg-label-primary">48</span></td>
                <td><span class="badge bg-label-success">Active</span></td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2">
                      <img src="{{ asset('assets/img/avatars/3.png') }}" alt="Service" class="rounded" />
                    </div>
                    <span>Bathroom Fixtures</span>
                  </div>
                </td>
                <td>ZWL 350</td>
                <td><span class="badge bg-label-primary">35</span></td>
                <td><span class="badge bg-label-success">Active</span></td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2">
                      <img src="{{ asset('assets/img/avatars/4.png') }}" alt="Service" class="rounded" />
                    </div>
                    <span>Water Leakage Detection</span>
                  </div>
                </td>
                <td>ZWL 150</td>
                <td><span class="badge bg-label-primary">65</span></td>
                <td><span class="badge bg-label-success">Active</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Recent Orders -->
    <div class="col-lg-6">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">Recent Orders</h5>
          <a href="javascript:void(0);" class="btn btn-sm btn-primary">View All</a>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>Order ID</th>
                <th>Client</th>
                <th>Amount</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="badge bg-label-primary">#ORD-148</span></td>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Client" class="rounded-circle me-2"
                      width="32" height="32" />
                    <span>Jane Smith</span>
                  </div>
                </td>
                <td>ZWL 450</td>
                <td><span class="badge bg-label-success">Completed</span></td>
              </tr>
              <tr>
                <td><span class="badge bg-label-primary">#ORD-147</span></td>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/img/avatars/5.png') }}" alt="Client" class="rounded-circle me-2"
                      width="32" height="32" />
                    <span>Michael Brown</span>
                  </div>
                </td>
                <td>ZWL 800</td>
                <td><span class="badge bg-label-success">Completed</span></td>
              </tr>
              <tr>
                <td><span class="badge bg-label-primary">#ORD-146</span></td>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/img/avatars/6.png') }}" alt="Client" class="rounded-circle me-2"
                      width="32" height="32" />
                    <span>Sarah Johnson</span>
                  </div>
                </td>
                <td>ZWL 350</td>
                <td><span class="badge bg-label-info">In Progress</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Service Modal -->
  <div class="modal fade" id="addServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New Service</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addServiceForm">
            <div class="row g-4">
              <!-- Service Name -->
              <div class="col-12">
                <label class="form-label">Service Name</label>
                <input type="text" class="form-control" placeholder="e.g., Pipe Installation & Repair" />
              </div>

              <!-- Category -->
              <div class="col-md-6">
                <label class="form-label">Category</label>
                <select class="form-select">
                  <option value="">Select Category</option>
                  <option value="plumbing">Plumbing</option>
                  <option value="electrical">Electrical</option>
                  <option value="carpentry">Carpentry</option>
                  <option value="tailoring">Tailoring & Fashion</option>
                  <option value="other">Other</option>
                </select>
              </div>

              <!-- Hourly Rate -->
              <div class="col-md-6">
                <label class="form-label">Hourly Rate (ZWL)</label>
                <input type="number" class="form-control" placeholder="250" />
              </div>

              <!-- Description -->
              <div class="col-12">
                <label class="form-label">Description</label>
                <textarea class="form-control" rows="4" placeholder="Describe your service in detail..."></textarea>
              </div>

              <!-- Service Image -->
              <div class="col-12">
                <label class="form-label">Service Image</label>
                <input type="file" class="form-control" accept="image/*" />
              </div>

              <!-- Availability -->
              <div class="col-12">
                <label class="form-label">Availability Status</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="availability" id="available" value="available"
                    checked />
                  <label class="form-check-label" for="available">Available</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="availability" id="unavailable"
                    value="unavailable" />
                  <label class="form-check-label" for="unavailable">Unavailable</label>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary">Add Service</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Orders Trend Chart
      const ordersTrendOptions = {
        series: [{
            name: 'Completed',
            data: [28, 35, 32, 40, 38, 42, 35]
          },
          {
            name: 'In Progress',
            data: [1, 2, 1, 3, 2, 2, 1]
          },
          {
            name: 'Pending',
            data: [0, 1, 0, 1, 1, 0, 0]
          }
        ],
        chart: {
          type: 'area',
          stacked: false,
          height: 300,
          toolbar: {
            show: false
          }
        },
        colors: ['#28c76f', '#4099ff', '#ffb64d'],
        xaxis: {
          categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
        },
        legend: {
          position: 'top'
        },
        dataLabels: {
          enabled: false
        }
      };
      new ApexCharts(document.querySelector("#ordersTrendChart"), ordersTrendOptions).render();

      // Completion Rate Chart
      const completionRateOptions = {
        series: [96],
        chart: {
          type: 'radialBar',
          height: 200,
          sparkline: {
            enabled: false
          }
        },
        colors: ['#28c76f'],
        plotOptions: {
          radialBar: {
            startAngle: -90,
            endAngle: 90,
            track: {
              background: '#e0e0e0',
              strokeWidth: '97%'
            },
            dataLabels: {
              name: {
                show: false
              },
              value: {
                offset: 0,
                fontSize: '24px',
                color: '#000'
              }
            }
          }
        }
      };
      new ApexCharts(document.querySelector("#completionRateChart"), completionRateOptions).render();
    });
  </script>
@endsection
