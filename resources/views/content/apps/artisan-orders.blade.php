@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'My Orders - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('content')
  <!-- Header Stats -->
  <div class="row g-6 mb-6">
    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Total Orders</p>
              <h3 class="mb-2">486</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i class="icon-base ri ri-arrow-up-s-line me-1"></i>+12
                  today</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-primary">
              <div class="avatar-initial"><i class="icon-base ri ri-shopping-bag-line"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Pending Orders</p>
              <h3 class="mb-2">24</h3>
              <p class="mb-0"><span class="badge bg-label-warning"><i
                    class="icon-base ri ri-alert-line me-1"></i>Awaiting action</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-warning">
              <div class="avatar-initial"><i class="icon-base ri ri-time-line"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Completed Orders</p>
              <h3 class="mb-2">438</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-check-line me-1"></i>90%</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-success">
              <div class="avatar-initial"><i class="icon-base ri ri-check-double-line"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Total Revenue</p>
              <h3 class="mb-2">ZWL 145,620</h3>
              <p class="mb-0"><span class="badge bg-label-info"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>+8.5%</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-info">
              <div class="avatar-initial"><i class="icon-base ri ri-money-dollar-circle-line"></i></div>
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
          <h5 class="card-title m-0"><i class="icon-base ri ri-line-chart-line me-2 text-primary"></i>Order Status Trend
          </h5>
        </div>
        <div class="card-body">
          <div id="orderTrendChart" style="height: 350px;"></div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0"><i class="icon-base ri ri-pie-chart-line me-2 text-success"></i>Order Status
            Distribution</h5>
        </div>
        <div class="card-body">
          <div id="statusDistributionChart" style="height: 350px;"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Orders Table -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
      <div class="row g-3 align-items-center">
        <div class="col-md-6">
          <h5 class="card-title m-0"><i class="icon-base ri ri-shopping-cart-line me-2 text-primary"></i>Recent Orders
          </h5>
        </div>
        <div class="col-md-6 text-end">
          <div class="btn-group" role="group">
            <input type="radio" class="btn-check" name="orderFilter" id="allOrders" value="all" checked />
            <label class="btn btn-outline-primary btn-sm" for="allOrders">All</label>
            <input type="radio" class="btn-check" name="orderFilter" id="pending" value="pending" />
            <label class="btn btn-outline-primary btn-sm" for="pending">Pending</label>
            <input type="radio" class="btn-check" name="orderFilter" id="completed" value="completed" />
            <label class="btn btn-outline-primary btn-sm" for="completed">Completed</label>
          </div>
        </div>
      </div>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>Order ID</th>
              <th>Client</th>
              <th>Service/Product</th>
              <th>Order Date</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Payment</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>#ORD-2026-1234</strong></td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-sm me-2">
                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Client" class="rounded-circle" />
                  </div>
                  <div>
                    <h6 class="mb-0 fw-medium">Sarah Mwangi</h6>
                    <small class="text-muted">Harare</small>
                  </div>
                </div>
              </td>
              <td><span class="badge bg-label-primary">Carpentry Work</span></td>
              <td>22 Jan 2026</td>
              <td><strong>ZWL 3,500</strong></td>
              <td><span class="badge bg-label-success">Completed</span></td>
              <td><span class="badge bg-label-success">Paid</span></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                    data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-fill"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-eye-line me-2"></i>View Details
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-message-2-line me-2"></i>Message Client
                    </a>
                    <hr class="dropdown-divider" />
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-file-download-line me-2"></i>Invoice
                    </a>
                  </div>
                </div>
              </td>
            </tr>

            <tr>
              <td><strong>#ORD-2026-1235</strong></td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-sm me-2">
                    <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Client" class="rounded-circle" />
                  </div>
                  <div>
                    <h6 class="mb-0 fw-medium">James Musarurwa</h6>
                    <small class="text-muted">Bulawayo</small>
                  </div>
                </div>
              </td>
              <td><span class="badge bg-label-warning">Beadwork Design</span></td>
              <td>21 Jan 2026</td>
              <td><strong>ZWL 2,800</strong></td>
              <td><span class="badge bg-label-info">In Progress</span></td>
              <td><span class="badge bg-label-success">Paid</span></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                    data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-fill"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-eye-line me-2"></i>View Details
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-message-2-line me-2"></i>Message Client
                    </a>
                    <hr class="dropdown-divider" />
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-file-download-line me-2"></i>Invoice
                    </a>
                  </div>
                </div>
              </td>
            </tr>

            <tr>
              <td><strong>#ORD-2026-1236</strong></td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-sm me-2">
                    <img src="{{ asset('assets/img/avatars/3.png') }}" alt="Client" class="rounded-circle" />
                  </div>
                  <div>
                    <h6 class="mb-0 fw-medium">Zinhle Dube</h6>
                    <small class="text-muted">Chitungwiza</small>
                  </div>
                </div>
              </td>
              <td><span class="badge bg-label-success">Painting Service</span></td>
              <td>20 Jan 2026</td>
              <td><strong>ZWL 4,200</strong></td>
              <td><span class="badge bg-label-warning">Pending</span></td>
              <td><span class="badge bg-label-warning">Awaiting</span></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                    data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-fill"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                      data-bs-target="#updateOrderModal">
                      <i class="icon-base ri ri-edit-line me-2"></i>Update Status
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-message-2-line me-2"></i>Message Client
                    </a>
                    <hr class="dropdown-divider" />
                    <a class="dropdown-item text-danger" href="javascript:void(0);">
                      <i class="icon-base ri ri-close-line me-2"></i>Cancel Order
                    </a>
                  </div>
                </div>
              </td>
            </tr>

            <tr>
              <td><strong>#ORD-2026-1237</strong></td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-sm me-2">
                    <img src="{{ asset('assets/img/avatars/4.png') }}" alt="Client" class="rounded-circle" />
                  </div>
                  <div>
                    <h6 class="mb-0 fw-medium">Lindiwe Khumalo</h6>
                    <small class="text-muted">Mutare</small>
                  </div>
                </div>
              </td>
              <td><span class="badge bg-label-info">Custom Furniture</span></td>
              <td>19 Jan 2026</td>
              <td><strong>ZWL 5,600</strong></td>
              <td><span class="badge bg-label-success">Completed</span></td>
              <td><span class="badge bg-label-success">Paid</span></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                    data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-fill"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-eye-line me-2"></i>View Details
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-message-2-line me-2"></i>Message Client
                    </a>
                    <hr class="dropdown-divider" />
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-file-download-line me-2"></i>Invoice
                    </a>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Update Order Status Modal -->
  <div class="modal fade" id="updateOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-edit-line me-2 text-primary"></i>Update Order Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="updateOrderForm">
            <div class="mb-4">
              <label class="form-label fw-medium mb-3">Current Status: <strong
                  class="text-warning">Pending</strong></label>
              <div class="alert alert-light" role="alert">
                <small><strong>Order:</strong> #ORD-2026-1236</small>
              </div>
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium">New Status *</label>
              <select class="form-select" required>
                <option value="">Select status</option>
                <option value="confirmed">Confirmed</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
              </select>
            </div>
            <div class="mb-0">
              <label class="form-label fw-medium">Status Notes (Optional)</label>
              <textarea class="form-control" rows="3" placeholder="Add notes about this status update..."></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" form="updateOrderForm">
            <i class="icon-base ri ri-check-line me-2"></i>Update Status
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Order Trend Chart
    const orderTrendChart = new ApexCharts(document.querySelector("#orderTrendChart"), {
      series: [{
          name: "Completed",
          data: [35, 41, 35, 51, 49, 62, 69]
        },
        {
          name: "In Progress",
          data: [8, 12, 10, 15, 14, 18, 16]
        },
        {
          name: "Pending",
          data: [2, 4, 3, 5, 4, 6, 5]
        }
      ],
      chart: {
        type: "area",
        height: 350,
        sparkline: {
          enabled: false
        }
      },
      colors: ["#28a745", "#667eea", "#ffc107"],
      stroke: {
        curve: "smooth",
        width: 2
      },
      fill: {
        type: "gradient",
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.45,
          opacityTo: 0.05
        }
      },
      xaxis: {
        categories: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"]
      },
      yaxis: {
        title: {
          text: "Orders"
        }
      },
      tooltip: {
        shared: true,
        intersect: false
      }
    });
    orderTrendChart.render();

    // Status Distribution Chart
    const statusDistributionChart = new ApexCharts(document.querySelector("#statusDistributionChart"), {
      series: [438, 24, 24],
      chart: {
        type: "donut",
        height: 350
      },
      labels: ["Completed", "In Progress", "Pending"],
      colors: ["#28a745", "#667eea", "#ffc107"],
      legend: {
        position: "bottom"
      }
    });
    statusDistributionChart.render();
  </script>
@endsection
