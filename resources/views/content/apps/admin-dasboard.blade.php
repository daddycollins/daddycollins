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
  <!-- Header Stats -->
  <div class="row g-6 mb-6">
    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Total Users</p>
              <h3 class="mb-2">1,248</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>+8.5% MTD</span></p>
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
              <h3 class="mb-2">342</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-check-double-line me-1"></i>27.4% of users</span></p>
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
              <h3 class="mb-2">48</h3>
              <p class="mb-0"><span class="badge bg-label-warning"><i
                    class="icon-base ri ri-time-line me-1"></i>Awaiting review</span></p>
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
              <h3 class="mb-2">6,543</h3>
              <p class="mb-0"><span class="badge bg-label-info"><i
                    class="icon-base ri ri-shopping-bag-line me-1"></i>ZWL 2.4M</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-info">
              <div class="avatar-initial"><i class="icon-base ri ri-shopping-cart-line"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Advanced Stats -->
  <div class="row g-6 mb-6">
    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Active Users (7 days)</p>
              <h3 class="mb-2">892</h3>
              <p class="mb-0"><span class="badge bg-label-primary">71.5% engagement</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-primary">
              <div class="avatar-initial"><i class="icon-base ri ri-login-circle-line"></i></div>
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
              <p class="text-muted small mb-1">Suspended Users</p>
              <h3 class="mb-2">12</h3>
              <p class="mb-0"><span class="badge bg-label-danger">0.96% of total</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-danger">
              <div class="avatar-initial"><i class="icon-base ri ri-shield-close-line"></i></div>
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
              <p class="text-muted small mb-1">Orders Completed</p>
              <h3 class="mb-2">5,987</h3>
              <p class="mb-0"><span class="badge bg-label-success">91.5% success rate</span></p>
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
              <p class="text-muted small mb-1">Support Tickets</p>
              <h3 class="mb-2">34</h3>
              <p class="mb-0"><span class="badge bg-label-warning">8 urgent</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-warning">
              <div class="avatar-initial"><i class="icon-base ri ri-mail-alert-line"></i></div>
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
            <h5 class="card-title m-0"><i class="icon-base ri ri-pie-chart-line me-2 text-success"></i>User Types</h5>
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
                <span class="badge bg-label-warning rounded-pill">23</span>
              </div>
              <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-0">
                <small>Needs Revision</small>
                <span class="badge bg-label-danger rounded-pill">8</span>
              </div>
              <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-0">
                <small>Ready to Verify</small>
                <span class="badge bg-label-success rounded-pill">17</span>
              </div>
              <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 border-0">
                <small>Rejected</small>
                <span class="badge bg-label-secondary rounded-pill">5</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div id="shipmentStatisticsChart"></div>
    </div>
  </div>
  </div>
  <!--/ Shipment statistics -->
  <!-- Delivery Performance -->
  <div class="col-lg-6 col-xxl-4 order-2 order-xxl-2">
    <div class="card h-100">
      <div class="card-header d-flex justify-content-between">
        <div>
          <h5 class="card-title mb-1">Delivery Performance</h5>
          <p class="card-subtitle mb-0">12% increase in this month</p>
        </div>
        <div class="dropdown">
          <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-1" type="button"
            id="deliveryPerformance" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="icon-base ri ri-more-2-line"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryPerformance">
            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
            <a class="dropdown-item" href="javascript:void(0);">Share</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <ul class="p-0 m-0">
          <li class="d-flex mb-6 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded-3 bg-label-primary"><i
                  class="icon-base ri ri-gift-line icon-24px"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0 fw-normal">Packages in transit</h6>
                <small class="text-success fw-normal d-block">
                  <i class="icon-base ri ri-arrow-up-s-line icon-24px"></i>
                  25.8%
                </small>
              </div>
              <div class="user-progress">
                <h6 class="mb-0">10k</h6>
              </div>
            </div>
          </li>
          <li class="d-flex mb-6 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded-3 bg-label-info"><i
                  class="icon-base ri ri-car-line icon-24px"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0 fw-normal">Packages out for delivery</h6>
                <small class="text-success fw-normal d-block">
                  <i class="icon-base ri ri-arrow-up-s-line icon-24px"></i>
                  4.3%
                </small>
              </div>
              <div class="user-progress">
                <h6 class="mb-0">5k</h6>
              </div>
            </div>
          </li>
          <li class="d-flex mb-6 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded-3 bg-label-success"><i
                  class="icon-base ri ri-check-line text-success icon-24px"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0 fw-normal">Packages delivered</h6>
                <small class="text-danger fw-normal d-block">
                  <i class="icon-base ri ri-arrow-down-s-line icon-24px"></i>
                  12.5
                </small>
              </div>
              <div class="user-progress">
                <h6 class="mb-0">15k</h6>
              </div>
            </div>
          </li>
          <li class="d-flex mb-6 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded-3 bg-label-warning"><i
                  class="icon-base ri ri-home-line icon-24px"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0 fw-normal">Delivery success rate</h6>
                <small class="text-success fw-normal d-block">
                  <i class="icon-base ri ri-arrow-up-s-line icon-24px"></i>
                  35.6%
                </small>
              </div>
              <div class="user-progress">
                <h6 class="mb-0">95%</h6>
              </div>
            </div>
          </li>
          <li class="d-flex mb-6 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded-3 bg-label-secondary"><i
                  class="icon-base ri ri-timer-line icon-24px"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0 fw-normal">Average delivery time</h6>
                <small class="text-danger fw-normal d-block">
                  <i class="icon-base ri ri-arrow-down-s-line icon-24px"></i>
                  2.15
                </small>
              </div>
              <div class="user-progress">
                <h6 class="mb-0">2.5 Days</h6>
              </div>
            </div>
          </li>
          <li class="d-flex">
            <div class="avatar flex-shrink-0 me-3">
              <span class="avatar-initial rounded-3 bg-label-danger"><i
                  class="icon-base ri ri-user-line icon-24px"></i></span>
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0 fw-normal">Customer satisfaction</h6>
                <small class="text-success fw-normal d-block">
                  <i class="icon-base ri ri-arrow-up-s-line icon-24px"></i>
                  5.7%
                </small>
              </div>
              <div class="user-progress">
                <h6 class="mb-0">4.5/5</h6>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!--/ Delivery Performance -->
  <!-- Reasons for delivery exceptions -->
  <div class="col-md-6 col-xxl-4 order-1 order-xxl-3">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="card-title mb-0">
          <h5 class="m-0 me-2">Reasons for delivery exceptions</h5>
        </div>
        <div class="dropdown">
          <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-1" type="button"
            id="deliveryExceptionsReasons" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="icon-base ri ri-more-2-line"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="deliveryExceptionsReasons">
            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
            <a class="dropdown-item" href="javascript:void(0);">Share</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div id="deliveryExceptionsChart"></div>
      </div>
    </div>
  </div>
  <!--/ Reasons for delivery exceptions -->
  <!-- Orders by Countries -->
  <div class="col-md-6 col-xxl-4 order-0 order-xxl-4">
    <div class="card h-100">
      <div class="card-header d-flex justify-content-between">
        <div class="card-title mb-0">
          <h5 class="m-0 me-2">Orders by Countries</h5>
          <span class="text-body mb-0">62 deliveries in progress</span>
        </div>
        <div class="dropdown">
          <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-1" type="button"
            id="ordersCountries" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="icon-base ri ri-more-2-line"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="ordersCountries">
            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
            <a class="dropdown-item" href="javascript:void(0);">Share</a>
          </div>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="nav-align-top">
          <ul class="nav nav-tabs nav-fill" role="tablist">
            <li class="nav-item">
              <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-justified-new" aria-controls="navs-justified-new"
                aria-selected="true">New</button>
            </li>
            <li class="nav-item">
              <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-justified-link-preparing" aria-controls="navs-justified-link-preparing"
                aria-selected="false">Preparing</button>
            </li>
            <li class="nav-item">
              <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-justified-link-shipping" aria-controls="navs-justified-link-shipping"
                aria-selected="false">Shipping</button>
            </li>
          </ul>
          <div class="tab-content border-0 pb-0 px-6 mx-1">
            <div class="tab-pane fade show active" id="navs-justified-new" role="tabpanel">
              <ul class="timeline mb-0">
                <li class="timeline-item ps-6 border-dashed">
                  <span class="timeline-indicator-advanced border-0 shadow-none">
                    <i class="icon-base ri ri-checkbox-circle-line text-success"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-success text-uppercase">sender</small>
                    </div>
                    <h6 class="my-50">Myrtle Ullrich</h6>
                    <p class="mb-0 small">101 Boulder, California(CA), 95959</p>
                  </div>
                </li>
                <li class="timeline-item ps-6 border-transparent">
                  <span class="timeline-indicator-advanced text-primary border-0 shadow-none">
                    <i class="icon-base ri ri-map-pin-line"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-primary text-uppercase">Receiver</small>
                    </div>
                    <h6 class="my-50">Barry Schowalter</h6>
                    <p class="mb-0 small">939 Orange, California(CA), 92118</p>
                  </div>
                </li>
              </ul>
              <div class="border-1 border-light border-dashed mb-2"></div>
              <ul class="timeline mb-0">
                <li class="timeline-item ps-6 border-dashed">
                  <span class="timeline-indicator-advanced border-0 shadow-none">
                    <i class="icon-base ri ri-checkbox-circle-line text-success"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-success text-uppercase">sender</small>
                    </div>
                    <h6 class="my-50">Veronica Herman</h6>
                    <p class="mb-0 small">162 Windsor, California(CA), 95492</p>
                  </div>
                </li>
                <li class="timeline-item ps-6 border-transparent">
                  <span class="timeline-indicator-advanced text-primary border-0 shadow-none">
                    <i class="icon-base ri ri-map-pin-line"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-primary text-uppercase">Receiver</small>
                    </div>
                    <h6 class="my-50">Helen Jacobs</h6>
                    <p class="mb-0 small">487 Sunset, California(CA), 94043</p>
                  </div>
                </li>
              </ul>
            </div>
            <div class="tab-pane fade" id="navs-justified-link-preparing" role="tabpanel">
              <ul class="timeline mb-0">
                <li class="timeline-item ps-6 border-dashed">
                  <span class="timeline-indicator-advanced border-0 shadow-none">
                    <i class="icon-base ri ri-checkbox-circle-line text-success"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-success text-uppercase">sender</small>
                    </div>
                    <h6 class="my-50">Barry Schowalter</h6>
                    <p class="mb-0 small">939 Orange, California(CA), 92118</p>
                  </div>
                </li>
                <li class="timeline-item ps-6 border-transparent border-dashed">
                  <span class="timeline-indicator-advanced text-primary border-0 shadow-none">
                    <i class="icon-base ri ri-map-pin-line"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-primary text-uppercase">Receiver</small>
                    </div>
                    <h6 class="my-50">Myrtle Ullrich</h6>
                    <p class="mb-0 small">101 Boulder, California(CA), 95959</p>
                  </div>
                </li>
              </ul>
              <div class="border-1 border-light border-dashed mb-2 "></div>
              <ul class="timeline mb-0">
                <li class="timeline-item ps-6 border-dashed">
                  <span class="timeline-indicator-advanced border-0 shadow-none">
                    <i class="icon-base ri ri-checkbox-circle-line text-success"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-success text-uppercase">sender</small>
                    </div>
                    <h6 class="my-50">Veronica Herman</h6>
                    <p class="mb-0 small">162 Windsor, California(CA), 95492</p>
                  </div>
                </li>
                <li class="timeline-item ps-6 border-transparent">
                  <span class="timeline-indicator-advanced text-primary border-0 shadow-none">
                    <i class="icon-base ri ri-map-pin-line"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-primary text-uppercase">Receiver</small>
                    </div>
                    <h6 class="my-50">Helen Jacobs</h6>
                    <p class="mb-0 small">487 Sunset, California(CA), 94043</p>
                  </div>
                </li>
              </ul>
            </div>
            <div class="tab-pane fade" id="navs-justified-link-shipping" role="tabpanel">
              <ul class="timeline mb-0">
                <li class="timeline-item ps-6 border-dashed">
                  <span class="timeline-indicator-advanced border-0 shadow-none">
                    <i class="icon-base ri ri-checkbox-circle-line text-success"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-success text-uppercase">sender</small>
                    </div>
                    <h6 class="my-50">Veronica Herman</h6>
                    <p class="mb-0 small">101 Boulder, California(CA), 95959</p>
                  </div>
                </li>
                <li class="timeline-item ps-6 border-transparent">
                  <span class="timeline-indicator-advanced text-primary border-0 shadow-none">
                    <i class="icon-base ri ri-map-pin-line"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-primary text-uppercase">Receiver</small>
                    </div>
                    <h6 class="my-50">Barry Schowalter</h6>
                    <p class="mb-0 small">939 Orange, California(CA), 92118</p>
                  </div>
                </li>
              </ul>
              <div class="border-1 border-light border-dashed mb-2 "></div>
              <ul class="timeline mb-0">
                <li class="timeline-item ps-6 border-dashed">
                  <span class="timeline-indicator-advanced border-0 shadow-none">
                    <i class="icon-base ri ri-checkbox-circle-line text-success"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-success text-uppercase">sender</small>
                    </div>
                    <h6 class="my-50">Myrtle Ullrich</h6>
                    <p class="mb-0 small">162 Windsor, California(CA), 95492</p>
                  </div>
                </li>
                <li class="timeline-item ps-6 border-transparent">
                  <span class="timeline-indicator-advanced text-primary border-0 shadow-none">
                    <i class="icon-base ri ri-map-pin-line"></i>
                  </span>
                  <div class="timeline-event ps-1">
                    <div class="timeline-header">
                      <small class="text-primary text-uppercase">Receiver</small>
                    </div>
                    <h6 class="my-50">Helen Jacobs</h6>
                    <p class="mb-0 small">487 Sunset, California(CA), 94043</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Orders by Countries -->
  <!-- On route vehicles Table -->
  <div class="col-12 order-5">
    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="card-title mb-0">
          <h5 class="m-0 me-2">On route vehicles</h5>
        </div>
        <div class="dropdown">
          <button class="btn btn-text-secondary rounded-pill text-body-secondary border-0 p-1" type="button"
            id="routeVehicles" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="icon-base ri ri-more-2-line"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="routeVehicles">
            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
            <a class="dropdown-item" href="javascript:void(0);">Share</a>
          </div>
        </div>
      </div>
      <div class="card-datatable table-responsive">
        <table class="dt-route-vehicles table">
          <thead>
            <tr>
              <th></th>
              <th></th>
              <th>location</th>
              <th>starting route</th>
              <th>ending route</th>
              <th>warnings</th>
              <th class="w-20">progress</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <!-- Recent Orders Table -->
  <div class="row g-6 mb-6">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
          <h5 class="card-title m-0"><i class="icon-base ri ri-shopping-cart-2-line me-2 text-primary"></i>Recent Orders
          </h5>
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
                <tr>
                  <td class="py-3 px-4"><strong>#ORD-2024-001</strong></td>
                  <td class="py-3 px-4">John Doe</td>
                  <td class="py-3 px-4">James Smith</td>
                  <td class="py-3 px-4">Plumbing Repair</td>
                  <td class="py-3 px-4">ZWL 450</td>
                  <td class="py-3 px-4"><span class="badge bg-label-success">Completed</span></td>
                  <td class="py-3 px-4">2024-01-15</td>
                </tr>
                <tr>
                  <td class="py-3 px-4"><strong>#ORD-2024-002</strong></td>
                  <td class="py-3 px-4">Sarah Johnson</td>
                  <td class="py-3 px-4">Maria Garcia</td>
                  <td class="py-3 px-4">Carpentry Work</td>
                  <td class="py-3 px-4">ZWL 800</td>
                  <td class="py-3 px-4"><span class="badge bg-label-info">In Progress</span></td>
                  <td class="py-3 px-4">2024-01-14</td>
                </tr>
                <tr>
                  <td class="py-3 px-4"><strong>#ORD-2024-003</strong></td>
                  <td class="py-3 px-4">Mike Wilson</td>
                  <td class="py-3 px-4">Robert Brown</td>
                  <td class="py-3 px-4">Electrical Installation</td>
                  <td class="py-3 px-4">ZWL 1,200</td>
                  <td class="py-3 px-4"><span class="badge bg-label-warning">Pending</span></td>
                  <td class="py-3 px-4">2024-01-13</td>
                </tr>
                <tr>
                  <td class="py-3 px-4"><strong>#ORD-2024-004</strong></td>
                  <td class="py-3 px-4">Emma Davis</td>
                  <td class="py-3 px-4">Lisa Martinez</td>
                  <td class="py-3 px-4">Home Cleaning</td>
                  <td class="py-3 px-4">ZWL 350</td>
                  <td class="py-3 px-4"><span class="badge bg-label-success">Completed</span></td>
                  <td class="py-3 px-4">2024-01-12</td>
                </tr>
                <tr>
                  <td class="py-3 px-4"><strong>#ORD-2024-005</strong></td>
                  <td class="py-3 px-4">David Anderson</td>
                  <td class="py-3 px-4">Christopher Lee</td>
                  <td class="py-3 px-4">Garden Design</td>
                  <td class="py-3 px-4">ZWL 950</td>
                  <td class="py-3 px-4"><span class="badge bg-label-danger">Cancelled</span></td>
                  <td class="py-3 px-4">2024-01-11</td>
                </tr>
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
            Verifications
          </h5>
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
                <tr>
                  <td class="py-3 px-4">
                    <div class="d-flex align-items-center">
                      <div class="avatar me-2">
                        <img src="/images/avatars/1.png" alt="avatar" class="rounded-circle"
                          style="width: 32px; height: 32px;">
                      </div>
                      <span>Alex Turner</span>
                    </div>
                  </td>
                  <td class="py-3 px-4">National ID</td>
                  <td class="py-3 px-4">2024-01-10</td>
                  <td class="py-3 px-4">5 days</td>
                  <td class="py-3 px-4"><span class="badge bg-label-success">Normal</span></td>
                  <td class="py-3 px-4">
                    <button class="btn btn-sm btn-icon btn-text-secondary" title="Review">
                      <i class="icon-base ri ri-eye-line"></i>
                    </button>
                    <button class="btn btn-sm btn-icon btn-text-success" title="Approve">
                      <i class="icon-base ri ri-check-line"></i>
                    </button>
                    <button class="btn btn-sm btn-icon btn-text-danger" title="Reject">
                      <i class="icon-base ri ri-close-line"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td class="py-3 px-4">
                    <div class="d-flex align-items-center">
                      <div class="avatar me-2">
                        <img src="/images/avatars/2.png" alt="avatar" class="rounded-circle"
                          style="width: 32px; height: 32px;">
                      </div>
                      <span>Emma Wilson</span>
                    </div>
                  </td>
                  <td class="py-3 px-4">Trade License</td>
                  <td class="py-3 px-4">2024-01-08</td>
                  <td class="py-3 px-4">7 days</td>
                  <td class="py-3 px-4"><span class="badge bg-label-warning">Urgent</span></td>
                  <td class="py-3 px-4">
                    <button class="btn btn-sm btn-icon btn-text-secondary" title="Review">
                      <i class="icon-base ri ri-eye-line"></i>
                    </button>
                    <button class="btn btn-sm btn-icon btn-text-success" title="Approve">
                      <i class="icon-base ri ri-check-line"></i>
                    </button>
                    <button class="btn btn-sm btn-icon btn-text-danger" title="Reject">
                      <i class="icon-base ri ri-close-line"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td class="py-3 px-4">
                    <div class="d-flex align-items-center">
                      <div class="avatar me-2">
                        <img src="/images/avatars/3.png" alt="avatar" class="rounded-circle"
                          style="width: 32px; height: 32px;">
                      </div>
                      <span>Marcus Johnson</span>
                    </div>
                  </td>
                  <td class="py-3 px-4">Insurance Document</td>
                  <td class="py-3 px-4">2024-01-09</td>
                  <td class="py-3 px-4">6 days</td>
                  <td class="py-3 px-4"><span class="badge bg-label-info">Needs Revision</span></td>
                  <td class="py-3 px-4">
                    <button class="btn btn-sm btn-icon btn-text-secondary" title="Review">
                      <i class="icon-base ri ri-eye-line"></i>
                    </button>
                    <button class="btn btn-sm btn-icon btn-text-success" title="Approve">
                      <i class="icon-base ri ri-check-line"></i>
                    </button>
                    <button class="btn btn-sm btn-icon btn-text-danger" title="Reject">
                      <i class="icon-base ri ri-close-line"></i>
                    </button>
                  </td>
                </tr>
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
                <p class="text-muted small mb-0">John Doe completed verification - 2 hours ago</p>
              </div>
            </li>
            <li class="timeline-item ps-3 pb-3 border-dashed">
              <span class="timeline-indicator border-0 shadow-none bg-label-warning">
                <i class="icon-base ri ri-time-line"></i>
              </span>
              <div class="timeline-event ps-3">
                <h6 class="mb-1">Order Submitted</h6>
                <p class="text-muted small mb-0">New order #ORD-2024-005 placed - 3 hours ago</p>
              </div>
            </li>
            <li class="timeline-item ps-3 pb-3 border-dashed">
              <span class="timeline-indicator border-0 shadow-none bg-label-danger">
                <i class="icon-base ri ri-close-line"></i>
              </span>
              <div class="timeline-event ps-3">
                <h6 class="mb-1">Order Cancelled</h6>
                <p class="text-muted small mb-0">Order #ORD-2024-003 cancelled by customer - 5 hours ago</p>
              </div>
            </li>
            <li class="timeline-item ps-3 pb-3 border-dashed">
              <span class="timeline-indicator border-0 shadow-none bg-label-primary">
                <i class="icon-base ri ri-user-add-line"></i>
              </span>
              <div class="timeline-event ps-3">
                <h6 class="mb-1">New User Registered</h6>
                <p class="text-muted small mb-0">Emma Wilson registered as artisan - 1 day ago</p>
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
          <div class="alert alert-label-warning alert-dismissible fade show mb-3" role="alert">
            <i class="icon-base ri ri-alert-line me-2"></i>
            <span>High number of pending verifications (23). Consider assigning reviewers.</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <div class="alert alert-label-info alert-dismissible fade show mb-3" role="alert">
            <i class="icon-base ri ri-information-line me-2"></i>
            <span>5 support tickets awaiting response. Average response time: 2.4 hours.</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <div class="alert alert-label-success alert-dismissible fade show" role="alert">
            <i class="icon-base ri ri-check-line me-2"></i>
            <span>System performance is optimal. Database size: 2.4GB. Cache efficiency: 98%.</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        </div>
      </div>
    </div>
  </div>



@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const colors = {
        primary: '#696cff',
        success: '#71dd5a',
        warning: '#ffb64d',
        danger: '#ff6b6b',
        info: '#00d4ff',
        secondary: '#82868b'
      };

      // User Growth Chart
      if (document.getElementById('userGrowthChart')) {
        const userGrowthOptions = {
          chart: {
            type: 'line',
            height: 350,
            toolbar: {
              show: true
            }
          },
          series: [{
            name: 'Total Users',
            data: [250, 320, 410, 480, 560, 680, 780, 892, 1050, 1150, 1248]
          }, {
            name: 'Active Users',
            data: [180, 240, 310, 380, 450, 550, 640, 720, 810, 892, 950]
          }],
          xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov']
          },
          colors: [colors.primary, colors.success],
          stroke: {
            width: 2
          }
        };
        new ApexCharts(document.querySelector("#userGrowthChart"), userGrowthOptions).render();
      }

      // User Types Pie Chart
      if (document.getElementById('userTypeChart')) {
        const userTypeOptions = {
          chart: {
            type: 'pie',
            height: 350
          },
          series: [342, 906, 247],
          labels: ['Verified Artisans', 'Regular Users', 'Suspended'],
          colors: [colors.success, colors.primary, colors.danger],
          legend: {
            position: 'bottom'
          }
        };
        new ApexCharts(document.querySelector("#userTypeChart"), userTypeOptions).render();
      }

      // Order Status Chart
      if (document.getElementById('orderStatusChart')) {
        const orderStatusOptions = {
          chart: {
            type: 'donut',
            height: 300
          },
          series: [5987, 400, 156],
          labels: ['Completed', 'Cancelled', 'Pending'],
          colors: [colors.success, colors.danger, colors.warning],
          legend: {
            position: 'bottom'
          }
        };
        new ApexCharts(document.querySelector("#orderStatusChart"), orderStatusOptions).render();
      }

      // Revenue Chart
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
            data: [45000, 52000, 61000, 58000, 75000, 88000, 102000]
          }],
          xaxis: {
            categories: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7']
          },
          colors: [colors.success]
        };
        new ApexCharts(document.querySelector("#revenueChart"), revenueOptions).render();
      }

      // Delivery Exceptions Chart
      if (document.getElementById('deliveryExceptionsChart')) {
        const deliveryExceptionsOptions = {
          chart: {
            type: 'bar',
            height: 400
          },
          series: [{
            name: 'Count',
            data: [45, 32, 28, 18, 12]
          }],
          xaxis: {
            categories: ['Address Issues', 'Contact Failed', 'Refused', 'Unreachable', 'Other']
          },
          colors: [colors.warning],
          plotOptions: {
            bar: {
              dataLabels: {
                position: 'top'
              }
            }
          }
        };
        new ApexCharts(document.querySelector("#deliveryExceptionsChart"), deliveryExceptionsOptions).render();
      }
    });
  </script>
@endsection
