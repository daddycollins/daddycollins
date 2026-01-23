@extends('layouts/layoutMaster')

@section('title', 'Dashboard - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection

@section('page-style')
  @vite(['resources/assets/vendor/scss/pages/app-ecommerce-dashboard.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/apex-charts/apexcharts.js'])
@endsection

@section('page-script')
  {{-- Add custom dashboard script if needed --}}
@endsection

@section('content')
  <!-- Page Title -->
  <div class="row mb-6">
    <div class="col-12">
      <div class="d-flex align-items-center gap-2">
        <h4 class="mb-0">Dashboard</h4>
        <span class="badge bg-label-primary">Stage 1</span>
      </div>
      <p class="text-muted mb-0">Welcome back! Here's an overview of your activity on ArtisanConnect.</p>
    </div>
  </div>

  <!-- Statistical Cards -->
  <div class="row g-6 mb-6">
    <!-- Total Orders -->
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="mb-1 text-muted">Total Orders</p>
              <h4 class="mb-2">24</h4>
              <p class="mb-0 text-success"><i class="icon-base ri ri-arrow-up-s-line"></i> +12.5%</p>
            </div>
            <div class="avatar bg-label-primary">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-shopping-bag-line icon-24px"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Orders -->
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="mb-1 text-muted">Pending Orders</p>
              <h4 class="mb-2">5</h4>
              <p class="mb-0 text-warning"><i class="icon-base ri ri-time-line"></i> Awaiting Processing</p>
            </div>
            <div class="avatar bg-label-warning">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-hourglass-line icon-24px"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Completed Orders -->
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="mb-1 text-muted">Completed Orders</p>
              <h4 class="mb-2">18</h4>
              <p class="mb-0 text-success"><i class="icon-base ri ri-check-double-line"></i> Successfully Done</p>
            </div>
            <div class="avatar bg-label-success">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-checkbox-circle-line icon-24px"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Active Artisans Hired -->
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="mb-1 text-muted">Artisans Hired</p>
              <h4 class="mb-2">8</h4>
              <p class="mb-0 text-info"><i class="icon-base ri ri-user-star-line"></i> This Month</p>
            </div>
            <div class="avatar bg-label-info">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-group-line icon-24px"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content Row -->
  <div class="row g-6 mb-6">
    <!-- Recent Orders -->
    <div class="col-lg-8">
      <div class="card h-100">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Recent Orders</h5>
            <a href="javascript:void(0);" class="text-primary small fw-medium">View All</a>
          </div>
        </div>
        <div class="table-responsive text-nowrap">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Artisan</th>
                <th>Service/Good</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              <tr>
                <td>
                  <span class="badge bg-label-primary">#ORD001</span>
                </td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2">
                      <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle" />
                    </div>
                    <span>John Mbewe</span>
                  </div>
                </td>
                <td>Plumbing Repair</td>
                <td><strong>$450</strong></td>
                <td><span class="badge bg-label-success">Completed</span></td>
                <td>Jan 20, 2026</td>
              </tr>
              <tr>
                <td>
                  <span class="badge bg-label-primary">#ORD002</span>
                </td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2">
                      <img src="{{ asset('assets/img/avatars/3.png') }}" alt="Avatar" class="rounded-circle" />
                    </div>
                    <span>Grace Muleya</span>
                  </div>
                </td>
                <td>Tailoring Services</td>
                <td><strong>$120</strong></td>
                <td><span class="badge bg-label-info">In Progress</span></td>
                <td>Jan 21, 2026</td>
              </tr>
              <tr>
                <td>
                  <span class="badge bg-label-primary">#ORD003</span>
                </td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2">
                      <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Avatar" class="rounded-circle" />
                    </div>
                    <span>Peter Nkomo</span>
                  </div>
                </td>
                <td>Carpentry Work</td>
                <td><strong>$800</strong></td>
                <td><span class="badge bg-label-warning">Pending</span></td>
                <td>Jan 21, 2026</td>
              </tr>
              <tr>
                <td>
                  <span class="badge bg-label-primary">#ORD004</span>
                </td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2">
                      <img src="{{ asset('assets/img/avatars/4.png') }}" alt="Avatar" class="rounded-circle" />
                    </div>
                    <span>Tendai Moyo</span>
                  </div>
                </td>
                <td>Electrical Installation</td>
                <td><strong>$350</strong></td>
                <td><span class="badge bg-label-success">Completed</span></td>
                <td>Jan 19, 2026</td>
              </tr>
              <tr>
                <td>
                  <span class="badge bg-label-primary">#ORD005</span>
                </td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2">
                      <img src="{{ asset('assets/img/avatars/5.png') }}" alt="Avatar" class="rounded-circle" />
                    </div>
                    <span>Chipo Mwale</span>
                  </div>
                </td>
                <td>Beadwork & Crafts</td>
                <td><strong>$95</strong></td>
                <td><span class="badge bg-label-success">Completed</span></td>
                <td>Jan 18, 2026</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Order Status Summary -->
    <div class="col-lg-4">
      <div class="card h-100">
        <div class="card-header">
          <h5 class="mb-0">Order Status Summary</h5>
        </div>
        <div class="card-body">
          <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="text-muted">Completed</span>
              <span class="badge bg-label-success">60%</span>
            </div>
            <div class="progress" style="height: 8px;">
              <div class="progress-bar bg-success" style="width: 60%"></div>
            </div>
            <small class="text-muted">18 orders</small>
          </div>

          <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="text-muted">In Progress</span>
              <span class="badge bg-label-info">25%</span>
            </div>
            <div class="progress" style="height: 8px;">
              <div class="progress-bar bg-info" style="width: 25%"></div>
            </div>
            <small class="text-muted">6 orders</small>
          </div>

          <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="text-muted">Pending</span>
              <span class="badge bg-label-warning">10%</span>
            </div>
            <div class="progress" style="height: 8px;">
              <div class="progress-bar bg-warning" style="width: 10%"></div>
            </div>
            <small class="text-muted">5 orders</small>
          </div>

          <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="text-muted">Cancelled</span>
              <span class="badge bg-label-danger">5%</span>
            </div>
            <div class="progress" style="height: 8px;">
              <div class="progress-bar bg-danger" style="width: 5%"></div>
            </div>
            <small class="text-muted">1 order</small>
          </div>

          <hr class="my-4" />

          <div class="text-center">
            <p class="text-muted small mb-0">Total Orders: <strong>24</strong></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Recommended Artisans Section -->
  <div class="row g-6">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Recommended Artisans</h5>
            <a href="javascript:void(0);" class="text-primary small fw-medium">View More</a>
          </div>
          <p class="card-subtitle mb-0">Top-rated artisans based on your preferences</p>
        </div>
        <div class="card-body">
          <div class="row g-6">
            <!-- Artisan Card 1 -->
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="text-center">
                <div class="mb-3">
                  <div class="avatar avatar-lg mx-auto mb-3">
                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Artisan" class="rounded-circle" />
                  </div>
                  <h6 class="mb-1">John Mbewe</h6>
                  <p class="text-muted small mb-2">Plumbing & Repairs</p>
                  <div class="mb-3">
                    <div class="text-warning">
                      <i class="icon-base ri ri-star-fill icon-14px"></i>
                      <i class="icon-base ri ri-star-fill icon-14px"></i>
                      <i class="icon-base ri ri-star-fill icon-14px"></i>
                      <i class="icon-base ri ri-star-fill icon-14px"></i>
                      <i class="icon-base ri ri-star-half-fill icon-14px"></i>
                    </div>
                    <small class="text-muted">4.5/5 (127 reviews)</small>
                  </div>
                  <button type="button" class="btn btn-sm btn-primary w-100">View Profile</button>
                </div>
              </div>
            </div>

            <!-- Artisan Card 2 -->
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="text-center">
                <div class="mb-3">
                  <div class="avatar avatar-lg mx-auto mb-3">
                    <img src="{{ asset('assets/img/avatars/3.png') }}" alt="Artisan" class="rounded-circle" />
                  </div>
                  <h6 class="mb-1">Grace Muleya</h6>
                  <p class="text-muted small mb-2">Tailoring & Fashion</p>
                  <div class="mb-3">
                    <div class="text-warning">
                      <i class="icon-base ri ri-star-fill icon-14px"></i>
                      <i class="icon-base ri ri-star-fill icon-14px"></i>
                      <i class="icon-base ri ri-star-fill icon-14px"></i>
                      <i class="icon-base ri ri-star-fill icon-14px"></i>
                      <i class="icon-base ri ri-star-fill icon-14px"></i>
                    </div>
                    <small class="text-muted">5.0/5 (98 reviews)</small>
                  </div>
                  <button type="button" class="btn btn-sm btn-primary w-100">View Profile</button>
                </div>
              </div>
            </div>

            <!-- Artisan Card 3 -->
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="text-center">
                <div class="mb-3">
                  <div class="avatar avatar-lg mx-auto mb-3">
                    <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Artisan" class="rounded-circle" />
                  </div>
                  <h6 class="mb-1">Peter Nkomo</h6>
                  <p class="text-muted small mb-2">Carpentry & Woodwork</p>
                  <div class="mb-3">
                    <div class="text-warning">
                      <i class="icon-base ri ri-star-fill icon-14px"></i>
                      <i class="icon-base ri ri-star-fill icon-14px"></i>
                      <i class="icon-base ri ri-star-fill icon-14px"></i>
                      <i class="icon-base ri ri-star-fill icon-14px"></i>
                      <i class="icon-base ri ri-star-line icon-14px"></i>
                    </div>
                    <small class="text-muted">4.0/5 (64 reviews)</small>
                  </div>
                  <button type="button" class="btn btn-sm btn-primary w-100">View Profile</button>
                </div>
              </div>
            </div>

            <!-- Artisan Card 4 -->
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="text-center">
                <div class="mb-3">
                  <div class="avatar avatar-lg mx-auto mb-3">
                    <img src="{{ asset('assets/img/avatars/4.png') }}" alt="Artisan" class="rounded-circle" />
                  </div>
                  <h6 class="mb-1">Tendai Moyo</h6>
                  <p class="text-muted small mb-2">Electrical Services</p>
                  <div class="mb-3">
                    <div class="text-warning">
                      <i class="icon-base ri ri-star-fill icon-14px"></i>
                      <i class="icon-base ri ri-star-fill icon-14px"></i>
                      <i class="icon-base ri ri-star-fill icon-14px"></i>
                      <i class="icon-base ri ri-star-fill icon-14px"></i>
                      <i class="icon-base ri ri-star-half-fill icon-14px"></i>
                    </div>
                    <small class="text-muted">4.5/5 (156 reviews)</small>
                  </div>
                  <button type="button" class="btn btn-sm btn-primary w-100">View Profile</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
