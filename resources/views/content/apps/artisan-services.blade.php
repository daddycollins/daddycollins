@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'My Services - ArtisanConnect')

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
              <p class="text-muted small mb-1">Active Services</p>
              <h3 class="mb-2">12</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i class="icon-base ri ri-check-line me-1"></i>All
                  Active</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-primary">
              <div class="avatar-initial"><i class="icon-base ri ri-tools-line"></i></div>
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
              <p class="text-muted small mb-1">Monthly Earnings</p>
              <h3 class="mb-2">ZWL 18,450</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>+25%</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-success">
              <div class="avatar-initial"><i class="icon-base ri ri-money-dollar-circle-line"></i></div>
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
              <p class="text-muted small mb-1">Service Orders</p>
              <h3 class="mb-2">156</h3>
              <p class="mb-0"><span class="badge bg-label-info"><i
                    class="icon-base ri ri-shopping-cart-line me-1"></i>This month</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-info">
              <div class="avatar-initial"><i class="icon-base ri ri-shopping-cart-line"></i></div>
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
              <p class="text-muted small mb-1">Avg Rating</p>
              <h3 class="mb-2">4.8 / 5</h3>
              <p class="mb-0"><span class="badge bg-label-warning"><i class="icon-base ri ri-star-fill me-1"
                    style="color: #ffc107;"></i>145 reviews</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-warning">
              <div class="avatar-initial"><i class="icon-base ri ri-star-line"></i></div>
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
          <h5 class="card-title m-0"><i class="icon-base ri ri-line-chart-line me-2 text-primary"></i>Service Bookings
            Trend</h5>
        </div>
        <div class="card-body">
          <div id="bookingsTrendChart" style="height: 350px;"></div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0"><i class="icon-base ri ri-bar-chart-line me-2 text-success"></i>Top Services</h5>
        </div>
        <div class="card-body">
          <div id="topServicesChart" style="height: 350px;"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Services Table -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
      <div class="row g-3 align-items-center">
        <div class="col-md-6">
          <h5 class="card-title m-0"><i class="icon-base ri ri-tools-line me-2 text-primary"></i>My Services</h5>
        </div>
        <div class="col-md-6 text-end">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
            <i class="icon-base ri ri-add-line me-2"></i>Add Service
          </button>
        </div>
      </div>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>Service</th>
              <th>Category</th>
              <th>Hourly Rate</th>
              <th>Bookings</th>
              <th>Revenue</th>
              <th>Rating</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-md me-3 bg-label-primary">
                    <div class="avatar-initial"><i class="icon-base ri ri-hammer-line"></i></div>
                  </div>
                  <div>
                    <h6 class="mb-0 fw-medium">Carpentry & Joinery</h6>
                    <small class="text-muted">Bespoke furniture & repairs</small>
                  </div>
                </div>
              </td>
              <td><span class="badge bg-label-primary">Furniture</span></td>
              <td><strong>ZWL 250/hr</strong></td>
              <td><span class="fw-medium text-primary">48</span></td>
              <td><span class="fw-medium text-success">ZWL 12,000</span></td>
              <td>
                <div class="d-flex align-items-center">
                  <i class="icon-base ri ri-star-fill" style="color: #ffc107;"></i>
                  <span class="ms-1">4.9</span>
                </div>
              </td>
              <td><span class="badge bg-label-success">Active</span></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                    data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-fill"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                      data-bs-target="#editServiceModal">
                      <i class="icon-base ri ri-edit-line me-2"></i>Edit
                    </a>
                    <hr class="dropdown-divider" />
                    <a class="dropdown-item text-danger" href="javascript:void(0);">
                      <i class="icon-base ri ri-delete-bin-line me-2"></i>Delete
                    </a>
                  </div>
                </div>
              </td>
            </tr>

            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-md me-3 bg-label-success">
                    <div class="avatar-initial"><i class="icon-base ri ri-paint-brush-line"></i></div>
                  </div>
                  <div>
                    <h6 class="mb-0 fw-medium">Painting & Finishing</h6>
                    <small class="text-muted">Interior & exterior painting</small>
                  </div>
                </div>
              </td>
              <td><span class="badge bg-label-success">Home Services</span></td>
              <td><strong>ZWL 150/hr</strong></td>
              <td><span class="fw-medium text-primary">62</span></td>
              <td><span class="fw-medium text-success">ZWL 9,300</span></td>
              <td>
                <div class="d-flex align-items-center">
                  <i class="icon-base ri ri-star-fill" style="color: #ffc107;"></i>
                  <span class="ms-1">4.7</span>
                </div>
              </td>
              <td><span class="badge bg-label-success">Active</span></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                    data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-fill"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                      data-bs-target="#editServiceModal">
                      <i class="icon-base ri ri-edit-line me-2"></i>Edit
                    </a>
                    <hr class="dropdown-divider" />
                    <a class="dropdown-item text-danger" href="javascript:void(0);">
                      <i class="icon-base ri ri-delete-bin-line me-2"></i>Delete
                    </a>
                  </div>
                </div>
              </td>
            </tr>

            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-md me-3 bg-label-warning">
                    <div class="avatar-initial"><i class="icon-base ri ri-layout-5-line"></i></div>
                  </div>
                  <div>
                    <h6 class="mb-0 fw-medium">Crafted Beadwork</h6>
                    <small class="text-muted">Traditional bead jewelry & art</small>
                  </div>
                </div>
              </td>
              <td><span class="badge bg-label-warning">Crafts</span></td>
              <td><strong>ZWL 180/hr</strong></td>
              <td><span class="fw-medium text-primary">46</span></td>
              <td><span class="fw-medium text-success">ZWL 8,280</span></td>
              <td>
                <div class="d-flex align-items-center">
                  <i class="icon-base ri ri-star-fill" style="color: #ffc107;"></i>
                  <span class="ms-1">4.8</span>
                </div>
              </td>
              <td><span class="badge bg-label-success">Active</span></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                    data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-fill"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                      data-bs-target="#editServiceModal">
                      <i class="icon-base ri ri-edit-line me-2"></i>Edit
                    </a>
                    <hr class="dropdown-divider" />
                    <a class="dropdown-item text-danger" href="javascript:void(0);">
                      <i class="icon-base ri ri-delete-bin-line me-2"></i>Delete
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

  <!-- Add Service Modal -->
  <div class="modal fade" id="addServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-add-circle-line me-2 text-primary"></i>Add New Service</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addServiceForm">
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label fw-medium">Service Name *</label>
                <input type="text" class="form-control" placeholder="e.g., Carpentry & Joinery" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Category *</label>
                <select class="form-select" required>
                  <option value="">Select category</option>
                  <option value="furniture">Furniture</option>
                  <option value="home">Home Services</option>
                  <option value="crafts">Crafts</option>
                  <option value="repairs">Repairs</option>
                  <option value="design">Design</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Hourly Rate (ZWL) *</label>
                <input type="number" class="form-control" placeholder="e.g., 250" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Experience Level *</label>
                <select class="form-select" required>
                  <option value="">Select level</option>
                  <option value="beginner">Beginner</option>
                  <option value="intermediate">Intermediate</option>
                  <option value="expert">Expert</option>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label fw-medium">Service Description *</label>
                <textarea class="form-control" rows="4"
                  placeholder="Describe your service, what it includes, and what clients can expect..." required></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Response Time (hours) *</label>
                <input type="number" class="form-control" placeholder="e.g., 24" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Service Status *</label>
                <select class="form-select" required>
                  <option value="active" selected>Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" form="addServiceForm">
            <i class="icon-base ri ri-save-line me-2"></i>Add Service
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Service Modal -->
  <div class="modal fade" id="editServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-edit-line me-2 text-primary"></i>Edit Service</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editServiceForm">
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label fw-medium">Service Name *</label>
                <input type="text" class="form-control" value="Carpentry & Joinery" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Category *</label>
                <select class="form-select" required>
                  <option value="furniture" selected>Furniture</option>
                  <option value="home">Home Services</option>
                  <option value="crafts">Crafts</option>
                  <option value="repairs">Repairs</option>
                  <option value="design">Design</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Hourly Rate (ZWL) *</label>
                <input type="number" class="form-control" value="250" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Experience Level *</label>
                <select class="form-select" required>
                  <option value="beginner">Beginner</option>
                  <option value="intermediate">Intermediate</option>
                  <option value="expert" selected>Expert</option>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label fw-medium">Service Description *</label>
                <textarea class="form-control" rows="4" required>Professional carpentry services specializing in bespoke furniture and high-quality repairs using sustainable materials.</textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Response Time (hours) *</label>
                <input type="number" class="form-control" value="24" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Service Status *</label>
                <select class="form-select" required>
                  <option value="active" selected>Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" form="editServiceForm">
            <i class="icon-base ri ri-save-line me-2"></i>Update Service
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Service Modal -->
  <div class="modal fade" id="deleteServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-alert-line me-2 text-danger"></i>Delete Service</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="mb-0">Are you sure you want to delete <strong>Carpentry & Joinery</strong>? This will remove the
            service from your profile and clients won't be able to book it.</p>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger">
            <i class="icon-base ri ri-delete-bin-line me-2"></i>Delete Service
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Bookings Trend Chart
    const bookingsTrendChart = new ApexCharts(document.querySelector("#bookingsTrendChart"), {
      series: [{
        name: "Bookings",
        data: [12, 18, 15, 22, 28, 26, 32]
      }],
      chart: {
        type: "area",
        height: 350,
        sparkline: {
          enabled: false
        }
      },
      colors: ["#667eea"],
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
          text: "Bookings"
        }
      },
      tooltip: {
        shared: true,
        intersect: false
      }
    });
    bookingsTrendChart.render();

    // Top Services Chart
    const topServicesChart = new ApexCharts(document.querySelector("#topServicesChart"), {
      series: [48, 62, 46],
      chart: {
        type: "bar",
        height: 350
      },
      colors: ["#667eea", "#764ba2", "#f093fb"],
      plotOptions: {
        bar: {
          horizontal: true
        }
      },
      xaxis: {
        categories: ["Carpentry", "Painting", "Beadwork"]
      },
      tooltip: {
        shared: true,
        intersect: false
      }
    });
    topServicesChart.render();
  </script>
@endsection
