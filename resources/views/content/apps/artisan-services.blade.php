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
  <!-- Flash Messages Alert Component -->
  <x-alert />

  <!-- Header Stats -->
  <div class="row g-6 mb-6">
    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Total Services</p>
              <h3 class="mb-2">{{ $totalServices }}</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-check-line me-1"></i>{{ $activeServices }} Active</span></p>
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
              <p class="text-muted small mb-1">Total Earnings</p>
              <h3 class="mb-2">ZWL {{ number_format($totalEarnings, 0) }}</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>From completed orders</span></p>
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
              <p class="text-muted small mb-1">Active Listings</p>
              <h3 class="mb-2">{{ $activeServices }}</h3>
              <p class="mb-0"><span class="badge bg-label-info"><i
                    class="icon-base ri ri-checkbox-circle-line me-1"></i>Ready to book</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-info">
              <div class="avatar-initial"><i class="icon-base ri ri-checkbox-circle-line"></i></div>
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
              <h3 class="mb-2">{{ number_format($avgRating, 1) }} / 5</h3>
              <p class="mb-0"><span class="badge bg-label-warning"><i class="icon-base ri ri-star-fill me-1"
                    style="color: #ffc107;"></i>{{ $reviewCount }} reviews</span></p>
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
            @forelse($services as $service)
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-md me-3 bg-label-primary">
                      @if ($service->image_path)
                        <img src="{{ asset('storage/' . $service->image_path) }}" alt="{{ $service->service_name }}" class="rounded" />
                      @else
                        <div class="avatar-initial"><i class="icon-base ri ri-hammer-line"></i></div>
                      @endif
                    </div>
                    <div>
                      <h6 class="mb-0 fw-medium">{{ $service->service_name }}</h6>
                      <small class="text-muted">{{ Illuminate\Support\Str::limit($service->description, 30) }}</small>
                    </div>
                  </div>
                </td>
                <td><span class="badge bg-label-primary">{{ $service->category ?? 'General' }}</span></td>
                <td><strong>ZWL {{ number_format($service->price_estimate, 2) }}</strong></td>
                <td><span class="fw-medium text-primary">0</span></td>
                <td><span class="fw-medium text-success">ZWL 0</span></td>
                <td>
                  <div class="d-flex align-items-center">
                    <i class="icon-base ri ri-star-fill" style="color: #ffc107;"></i>
                    <span class="ms-1">{{ number_format($avgRating, 1) }}</span>
                  </div>
                </td>
                <td>
                  <span class="badge bg-label-{{ $service->availability ? 'success' : 'warning' }}">
                    {{ $service->availability ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td>
                  <div class="dropdown">
                    <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                      data-bs-toggle="dropdown">
                      <i class="icon-base ri ri-more-2-fill"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item edit-service-btn" href="javascript:void(0);" data-bs-toggle="modal"
                        data-bs-target="#editServiceModal" data-service-id="{{ $service->id }}"
                        data-service-name="{{ $service->service_name }}" data-category="{{ $service->category }}"
                        data-price="{{ $service->price_estimate }}" data-description="{{ $service->description }}"
                        data-availability="{{ $service->availability }}">
                        <i class="icon-base ri ri-edit-line me-2"></i>Edit
                      </a>
                      <hr class="dropdown-divider" />
                      <a class="dropdown-item text-danger delete-service-btn" href="javascript:void(0);"
                        data-bs-toggle="modal" data-bs-target="#deleteServiceModal"
                        data-service-id="{{ $service->id }}" data-service-name="{{ $service->service_name }}">
                        <i class="icon-base ri ri-delete-bin-line me-2"></i>Delete
                      </a>
                    </div>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center py-4">
                  <p class="text-muted mb-0"><i class="icon-base ri ri-inbox-line me-2"></i>No services found. <a
                      href="{{ route('artisan-dashboard') }}" class="text-primary">Add your first service</a></p>
                </td>
              </tr>
            @endforelse
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
        <form method="POST" action="{{ route('artisan-service-store') }}" enctype="multipart/form-data"
          id="addServiceForm">
          @csrf
          <div class="modal-body">
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label fw-medium">Service Name *</label>
                <input type="text" name="service_name"
                  class="form-control @error('service_name') is-invalid @enderror"
                  placeholder="e.g., Carpentry & Joinery" required />
                @error('service_name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Category *</label>
                <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                  <option value="">Select category</option>
                  <option value="Furniture">Furniture</option>
                  <option value="Home Services">Home Services</option>
                  <option value="Crafts">Crafts</option>
                  <option value="Repairs">Repairs</option>
                  <option value="Design">Design</option>
                </select>
                @error('category')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Hourly Rate (ZWL) *</label>
                <input type="number" name="price_estimate"
                  class="form-control @error('price_estimate') is-invalid @enderror" placeholder="e.g., 250"
                  step="0.01" required />
                @error('price_estimate')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Service Image</label>
                <input type="file" name="image_path" class="form-control @error('image_path') is-invalid @enderror"
                  accept="image/*" />
                @error('image_path')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-12">
                <label class="form-label fw-medium">Service Description *</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                  placeholder="Describe your service, what it includes, and what clients can expect..." required></textarea>
                @error('description')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Service Status *</label>
                <select name="availability" class="form-select @error('availability') is-invalid @enderror" required>
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                </select>
                @error('availability')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="modal-footer border-top">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <i class="icon-base ri ri-save-line me-2"></i>Add Service
            </button>
          </div>
        </form>
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
        <form method="POST" action="" enctype="multipart/form-data" id="editServiceForm">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label fw-medium">Service Name *</label>
                <input type="text" name="service_name" id="editServiceName" class="form-control" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Category *</label>
                <select name="category" id="editCategory" class="form-select" required>
                  <option value="">Select category</option>
                  <option value="Furniture">Furniture</option>
                  <option value="Home Services">Home Services</option>
                  <option value="Crafts">Crafts</option>
                  <option value="Repairs">Repairs</option>
                  <option value="Design">Design</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Hourly Rate (ZWL) *</label>
                <input type="number" name="price_estimate" id="editPrice" class="form-control" step="0.01"
                  required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Service Image</label>
                <input type="file" name="image_path" class="form-control" accept="image/*" />
              </div>
              <div class="col-12">
                <label class="form-label fw-medium">Service Description *</label>
                <textarea name="description" id="editDescription" class="form-control" rows="4" required></textarea>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Service Status *</label>
                <select name="availability" id="editAvailability" class="form-select" required>
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer border-top">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <i class="icon-base ri ri-save-line me-2"></i>Update Service
            </button>
          </div>
        </form>
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
        <form method="POST" action="" id="deleteServiceForm">
          @csrf
          @method('DELETE')
          <div class="modal-body">
            <p class="mb-0">Are you sure you want to delete <strong id="deleteServiceName">this service</strong>? This
              will remove the service from your profile and clients won't be able to book it.</p>
          </div>
          <div class="modal-footer border-top">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">
              <i class="icon-base ri ri-delete-bin-line me-2"></i>Delete Service
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Edit Service Modal - Populate with data
      document.querySelectorAll('.edit-service-btn').forEach(btn => {
        btn.addEventListener('click', function() {
          const serviceId = this.getAttribute('data-service-id');
          const serviceName = this.getAttribute('data-service-name');
          const category = this.getAttribute('data-category');
          const price = this.getAttribute('data-price');
          const description = this.getAttribute('data-description');
          const availability = this.getAttribute('data-availability');

          // Populate form fields
          document.getElementById('editServiceName').value = serviceName;
          document.getElementById('editCategory').value = category;
          document.getElementById('editPrice').value = price;
          document.getElementById('editDescription').value = description;
          document.getElementById('editAvailability').value = availability;

          // Set form action
          const form = document.getElementById('editServiceForm');
          form.action = `/artisan/services/${serviceId}/update`;
        });
      });

      // Delete Service Modal - Populate with data
      document.querySelectorAll('.delete-service-btn').forEach(btn => {
        btn.addEventListener('click', function() {
          const serviceId = this.getAttribute('data-service-id');
          const serviceName = this.getAttribute('data-service-name');

          // Update modal content
          document.getElementById('deleteServiceName').textContent = serviceName;

          // Set form action
          const form = document.getElementById('deleteServiceForm');
          form.action = `/artisan/services/${serviceId}`;
        });
      });

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
        series: [{
          name: "Bookings",
          data: [48, 62, 46]
        }],
        chart: {
          type: "bar",
          height: 350
        },
        colors: ["#667eea"],
        plotOptions: {
          bar: {
            horizontal: true,
            borderRadius: 4
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
    });
  </script>
@endsection
