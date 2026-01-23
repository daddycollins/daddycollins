@extends('layouts/layoutMaster')

@section('title', 'Reviews Monitor - ArtisanConnect Admin')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/animate-css/animate.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('content')
  <!-- Header -->
  <div
    class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-between mb-6 text-center text-sm-start gap-2">
    <div class="mb-2 mb-sm-0">
      <h4 class="mb-1"><i class="icon-base ri ri-star-line me-2 text-primary"></i>Reviews Monitor</h4>
      <p class="mb-0">Monitor and manage all customer and artisan reviews on the platform</p>
    </div>
  </div>

  <!-- Statistics Cards -->
  <div class="row g-6 mb-6">
    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Total Reviews</p>
              <h3 class="mb-2">2,847</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>+24% MTD</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-primary">
              <div class="avatar-initial"><i class="icon-base ri ri-star-line"></i></div>
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
              <p class="text-muted small mb-1">Average Rating</p>
              <h3 class="mb-2">4.8<span style="font-size: 0.7em;">★</span></h3>
              <p class="mb-0"><span class="badge bg-label-success">Excellent</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-success">
              <div class="avatar-initial"><i class="icon-base ri ri-star-smile-line"></i></div>
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
              <p class="text-muted small mb-1">Pending Approval</p>
              <h3 class="mb-2">42</h3>
              <p class="mb-0"><span class="badge bg-label-warning">Awaiting review</span></p>
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
              <p class="text-muted small mb-1">Flagged Reviews</p>
              <h3 class="mb-2">18</h3>
              <p class="mb-0"><span class="badge bg-label-danger">Needs action</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-danger">
              <div class="avatar-initial"><i class="icon-base ri ri-alert-line"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Review Rating Distribution -->
  <div class="card border-0 shadow-sm mb-6">
    <div class="card-header bg-white border-bottom">
      <h5 class="card-title m-0"><i class="icon-base ri ri-bar-chart-line me-2"></i>Rating Distribution</h5>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-3 mb-3 mb-md-0">
          <div class="d-flex align-items-center gap-2 mb-2">
            <small class="fw-medium">5 Star</small>
            <div class="progress flex-grow-1 bg-label-primary" style="height:8px;">
              <div class="progress-bar bg-primary" role="progressbar" style="width: 62%" aria-valuenow="62"
                aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="fw-medium">1,765</small>
          </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
          <div class="d-flex align-items-center gap-2 mb-2">
            <small class="fw-medium">4 Star</small>
            <div class="progress flex-grow-1 bg-label-primary" style="height:8px;">
              <div class="progress-bar bg-primary" role="progressbar" style="width: 22%" aria-valuenow="22"
                aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="fw-medium">626</small>
          </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
          <div class="d-flex align-items-center gap-2 mb-2">
            <small class="fw-medium">3 Star</small>
            <div class="progress flex-grow-1 bg-label-primary" style="height:8px;">
              <div class="progress-bar bg-primary" role="progressbar" style="width: 10%" aria-valuenow="10"
                aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="fw-medium">284</small>
          </div>
        </div>
        <div class="col-md-3">
          <div class="d-flex align-items-center gap-2 mb-2">
            <small class="fw-medium">Below 3</small>
            <div class="progress flex-grow-1 bg-label-primary" style="height:8px;">
              <div class="progress-bar bg-danger" role="progressbar" style="width: 6%" aria-valuenow="6"
                aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="fw-medium">172</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Reviews Table -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
      <h5 class="card-title m-0"><i class="icon-base ri ri-list-check me-2"></i>All Reviews</h5>
      <div class="d-flex gap-2">
        <div class="input-group input-group-sm" style="width: 250px;">
          <span class="input-group-text border-0"><i class="icon-base ri ri-search-line"></i></span>
          <input type="text" class="form-control form-control-sm border-0" placeholder="Search reviews..."
            id="reviewSearch">
        </div>
        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#filterPanel">
          <i class="icon-base ri ri-filter-line me-1"></i>Filters
        </button>
      </div>
    </div>

    <!-- Filter Panel -->
    <div class="collapse" id="filterPanel">
      <div class="card-body border-bottom">
        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label">Review Type</label>
            <select class="form-select form-select-sm" id="filterType">
              <option value="">All Types</option>
              <option value="service">Service Review</option>
              <option value="artisan">Artisan Rating</option>
              <option value="product">Product Review</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Rating</label>
            <select class="form-select form-select-sm" id="filterRating">
              <option value="">All Ratings</option>
              <option value="5">5 Stars</option>
              <option value="4">4 Stars</option>
              <option value="3">3 Stars</option>
              <option value="below3">Below 3 Stars</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Status</label>
            <select class="form-select form-select-sm" id="filterStatus">
              <option value="">All Status</option>
              <option value="approved">Approved</option>
              <option value="pending">Pending</option>
              <option value="flagged">Flagged</option>
              <option value="hidden">Hidden</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">&nbsp;</label>
            <button class="btn btn-sm btn-outline-secondary w-100" id="resetFilters">Reset Filters</button>
          </div>
        </div>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="bg-light">
          <tr>
            <th class="py-3">Reviewer</th>
            <th class="py-3">Subject</th>
            <th class="py-3">Type</th>
            <th class="py-3">Rating</th>
            <th class="py-3">Review Text</th>
            <th class="py-3">Status</th>
            <th class="py-3">Date</th>
            <th class="py-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Review 1 - 5 Stars Service -->
          <tr>
            <td class="py-3">
              <div class="d-flex align-items-center gap-2">
                <img src="/images/avatars/1.png" alt="avatar" class="rounded-circle"
                  style="width: 32px; height: 32px;">
                <div>
                  <strong>John Doe</strong>
                  <br><small class="text-muted">Verified Customer</small>
                </div>
              </div>
            </td>
            <td class="py-3"><strong>Plumbing Service</strong><br><small class="text-muted">James Smith</small></td>
            <td class="py-3"><span class="badge bg-label-info">Service</span></td>
            <td class="py-3"><span class="text-warning">★★★★★</span> <strong>5.0</strong></td>
            <td class="py-3">
              <small>"Excellent work! James fixed the issue quickly and professionally. Highly recommend!"</small>
            </td>
            <td class="py-3"><span class="badge bg-label-success">Approved</span></td>
            <td class="py-3">Jan 20, 2024</td>
            <td class="py-3">
              <div class="dropdown">
                <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                  <i class="icon-base ri ri-more-2-line"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" data-action="view"><i
                        class="icon-base ri ri-eye-line me-2"></i>View Full Review</a></li>
                  <li><a class="dropdown-item" href="#" data-action="feature"><i
                        class="icon-base ri ri-star-line me-2"></i>Feature Review</a></li>
                  <li><a class="dropdown-item" href="#" data-action="edit"><i
                        class="icon-base ri ri-edit-line me-2"></i>Edit</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item text-danger" href="#" data-action="remove"><i
                        class="icon-base ri ri-close-circle-line me-2"></i>Remove Inappropriate</a></li>
                </ul>
              </div>
            </td>
          </tr>

          <!-- Review 2 - 4 Stars Artisan -->
          <tr>
            <td class="py-3">
              <div class="d-flex align-items-center gap-2">
                <img src="/images/avatars/2.png" alt="avatar" class="rounded-circle"
                  style="width: 32px; height: 32px;">
                <div>
                  <strong>Sarah Johnson</strong>
                  <br><small class="text-muted">Verified Customer</small>
                </div>
              </div>
            </td>
            <td class="py-3"><strong>Carpenter Rating</strong><br><small class="text-muted">Maria Garcia</small></td>
            <td class="py-3"><span class="badge bg-label-success">Artisan</span></td>
            <td class="py-3"><span class="text-warning">★★★★☆</span> <strong>4.0</strong></td>
            <td class="py-3">
              <small>"Great craftsmanship and attention to detail. Would rate higher if communication was faster."</small>
            </td>
            <td class="py-3"><span class="badge bg-label-success">Approved</span></td>
            <td class="py-3">Jan 19, 2024</td>
            <td class="py-3">
              <div class="dropdown">
                <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                  <i class="icon-base ri ri-more-2-line"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" data-action="view"><i
                        class="icon-base ri ri-eye-line me-2"></i>View Full Review</a></li>
                  <li><a class="dropdown-item" href="#" data-action="feature"><i
                        class="icon-base ri ri-star-line me-2"></i>Feature Review</a></li>
                  <li><a class="dropdown-item" href="#" data-action="edit"><i
                        class="icon-base ri ri-edit-line me-2"></i>Edit</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item text-danger" href="#" data-action="remove"><i
                        class="icon-base ri ri-close-circle-line me-2"></i>Remove Inappropriate</a></li>
                </ul>
              </div>
            </td>
          </tr>

          <!-- Review 3 - Pending Approval -->
          <tr class="table-info" style="opacity: 0.85;">
            <td class="py-3">
              <div class="d-flex align-items-center gap-2">
                <img src="/images/avatars/3.png" alt="avatar" class="rounded-circle"
                  style="width: 32px; height: 32px;">
                <div>
                  <strong>Mike Wilson</strong>
                  <br><small class="text-muted">Verified Customer</small>
                </div>
              </div>
            </td>
            <td class="py-3"><strong>Electrical Work</strong><br><small class="text-muted">Robert Brown</small></td>
            <td class="py-3"><span class="badge bg-label-info">Service</span></td>
            <td class="py-3"><span class="text-warning">★★★★★</span> <strong>5.0</strong></td>
            <td class="py-3">
              <small>"Perfect installation. Robert is very professional and knowledgeable. Would definitely hire
                again."</small>
            </td>
            <td class="py-3"><span class="badge bg-label-warning">Pending</span></td>
            <td class="py-3">Jan 18, 2024</td>
            <td class="py-3">
              <div class="dropdown">
                <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                  <i class="icon-base ri ri-more-2-line"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" data-action="view"><i
                        class="icon-base ri ri-eye-line me-2"></i>View Full Review</a></li>
                  <li><a class="dropdown-item" href="#" data-action="approve"><i
                        class="icon-base ri ri-check-line me-2"></i>Approve</a></li>
                  <li><a class="dropdown-item" href="#" data-action="edit"><i
                        class="icon-base ri ri-edit-line me-2"></i>Edit</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item text-danger" href="#" data-action="remove"><i
                        class="icon-base ri ri-close-circle-line me-2"></i>Remove Inappropriate</a></li>
                </ul>
              </div>
            </td>
          </tr>

          <!-- Review 4 - 2 Stars Flagged -->
          <tr class="table-danger" style="opacity: 0.8;">
            <td class="py-3">
              <div class="d-flex align-items-center gap-2">
                <img src="/images/avatars/4.png" alt="avatar" class="rounded-circle"
                  style="width: 32px; height: 32px;">
                <div>
                  <strong>Emma Davis</strong>
                  <br><small class="text-muted">Verified Customer</small>
                </div>
              </div>
            </td>
            <td class="py-3"><strong>Cleaning Service</strong><br><small class="text-muted">Lisa Martinez</small></td>
            <td class="py-3"><span class="badge bg-label-info">Service</span></td>
            <td class="py-3"><span class="text-warning">★★☆☆☆</span> <strong>2.0</strong></td>
            <td class="py-3">
              <small>"Service was not up to standard. Unprofessional behavior. Not satisfied with the work."</small>
            </td>
            <td class="py-3"><span class="badge bg-label-danger">Flagged</span></td>
            <td class="py-3">Jan 17, 2024</td>
            <td class="py-3">
              <div class="dropdown">
                <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                  <i class="icon-base ri ri-more-2-line"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" data-action="view"><i
                        class="icon-base ri ri-eye-line me-2"></i>View Full Review</a></li>
                  <li><a class="dropdown-item" href="#" data-action="approve"><i
                        class="icon-base ri ri-check-line me-2"></i>Approve as Legitimate</a></li>
                  <li><a class="dropdown-item" href="#" data-action="edit"><i
                        class="icon-base ri ri-edit-line me-2"></i>Edit</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item text-danger" href="#" data-action="remove"><i
                        class="icon-base ri ri-close-circle-line me-2"></i>Remove Inappropriate</a></li>
                </ul>
              </div>
            </td>
          </tr>

          <!-- Review 5 - 5 Stars Product -->
          <tr>
            <td class="py-3">
              <div class="d-flex align-items-center gap-2">
                <img src="/images/avatars/5.png" alt="avatar" class="rounded-circle"
                  style="width: 32px; height: 32px;">
                <div>
                  <strong>David Anderson</strong>
                  <br><small class="text-muted">Verified Customer</small>
                </div>
              </div>
            </td>
            <td class="py-3"><strong>Custom Furniture</strong><br><small class="text-muted">Christopher Lee</small>
            </td>
            <td class="py-3"><span class="badge bg-label-secondary">Product</span></td>
            <td class="py-3"><span class="text-warning">★★★★★</span> <strong>5.0</strong></td>
            <td class="py-3">
              <small>"Amazing quality! The furniture is exactly as described. Christopher's craftsmanship is
                outstanding."</small>
            </td>
            <td class="py-3"><span class="badge bg-label-success">Approved</span></td>
            <td class="py-3">Jan 16, 2024</td>
            <td class="py-3">
              <div class="dropdown">
                <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                  <i class="icon-base ri ri-more-2-line"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" data-action="view"><i
                        class="icon-base ri ri-eye-line me-2"></i>View Full Review</a></li>
                  <li><a class="dropdown-item" href="#" data-action="feature"><i
                        class="icon-base ri ri-star-line me-2"></i>Feature Review</a></li>
                  <li><a class="dropdown-item" href="#" data-action="edit"><i
                        class="icon-base ri ri-edit-line me-2"></i>Edit</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item text-danger" href="#" data-action="remove"><i
                        class="icon-base ri ri-close-circle-line me-2"></i>Remove Inappropriate</a></li>
                </ul>
              </div>
            </td>
          </tr>

          <!-- Review 6 - 3 Stars Pending -->
          <tr class="table-info" style="opacity: 0.85;">
            <td class="py-3">
              <div class="d-flex align-items-center gap-2">
                <img src="/images/avatars/6.png" alt="avatar" class="rounded-circle"
                  style="width: 32px; height: 32px;">
                <div>
                  <strong>Jessica White</strong>
                  <br><small class="text-muted">Verified Customer</small>
                </div>
              </div>
            </td>
            <td class="py-3"><strong>Door Installation</strong><br><small class="text-muted">James Smith</small></td>
            <td class="py-3"><span class="badge bg-label-info">Service</span></td>
            <td class="py-3"><span class="text-warning">★★★☆☆</span> <strong>3.0</strong></td>
            <td class="py-3">
              <small>"Good work but took longer than expected. Quality is acceptable but pricing seems a bit
                high."</small>
            </td>
            <td class="py-3"><span class="badge bg-label-warning">Pending</span></td>
            <td class="py-3">Jan 15, 2024</td>
            <td class="py-3">
              <div class="dropdown">
                <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                  <i class="icon-base ri ri-more-2-line"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" data-action="view"><i
                        class="icon-base ri ri-eye-line me-2"></i>View Full Review</a></li>
                  <li><a class="dropdown-item" href="#" data-action="approve"><i
                        class="icon-base ri ri-check-line me-2"></i>Approve</a></li>
                  <li><a class="dropdown-item" href="#" data-action="edit"><i
                        class="icon-base ri ri-edit-line me-2"></i>Edit</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item text-danger" href="#" data-action="remove"><i
                        class="icon-base ri ri-close-circle-line me-2"></i>Remove Inappropriate</a></li>
                </ul>
              </div>
            </td>
          </tr>

          <!-- Review 7 - 1 Star Flagged -->
          <tr class="table-danger" style="opacity: 0.8;">
            <td class="py-3">
              <div class="d-flex align-items-center gap-2">
                <img src="/images/avatars/7.png" alt="avatar" class="rounded-circle"
                  style="width: 32px; height: 32px;">
                <div>
                  <strong>Michelle Brown</strong>
                  <br><small class="text-muted">Unverified</small>
                </div>
              </div>
            </td>
            <td class="py-3"><strong>Painting Service</strong><br><small class="text-muted">Maria Garcia</small></td>
            <td class="py-3"><span class="badge bg-label-info">Service</span></td>
            <td class="py-3"><span class="text-warning">★☆☆☆☆</span> <strong>1.0</strong></td>
            <td class="py-3">
              <small>"Worst experience ever! Stay away from this artisan. Complete waste of money and time!"</small>
            </td>
            <td class="py-3"><span class="badge bg-label-danger">Flagged</span></td>
            <td class="py-3">Jan 14, 2024</td>
            <td class="py-3">
              <div class="dropdown">
                <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                  <i class="icon-base ri ri-more-2-line"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" data-action="view"><i
                        class="icon-base ri ri-eye-line me-2"></i>View Full Review</a></li>
                  <li><a class="dropdown-item" href="#" data-action="approve"><i
                        class="icon-base ri ri-check-line me-2"></i>Approve as Legitimate</a></li>
                  <li><a class="dropdown-item" href="#" data-action="edit"><i
                        class="icon-base ri ri-edit-line me-2"></i>Edit</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item text-danger" href="#" data-action="remove"><i
                        class="icon-base ri ri-close-circle-line me-2"></i>Remove Inappropriate</a></li>
                </ul>
              </div>
            </td>
          </tr>

          <!-- Review 8 - 4.5 Stars Service -->
          <tr>
            <td class="py-3">
              <div class="d-flex align-items-center gap-2">
                <img src="/images/avatars/8.png" alt="avatar" class="rounded-circle"
                  style="width: 32px; height: 32px;">
                <div>
                  <strong>Thomas Clark</strong>
                  <br><small class="text-muted">Verified Customer</small>
                </div>
              </div>
            </td>
            <td class="py-3"><strong>Roof Repair</strong><br><small class="text-muted">Robert Brown</small></td>
            <td class="py-3"><span class="badge bg-label-info">Service</span></td>
            <td class="py-3"><span class="text-warning">★★★★☆</span> <strong>4.5</strong></td>
            <td class="py-3">
              <small>"Professional and thorough work. Robert provided excellent guidance on maintenance. Very
                satisfied."</small>
            </td>
            <td class="py-3"><span class="badge bg-label-success">Approved</span></td>
            <td class="py-3">Jan 13, 2024</td>
            <td class="py-3">
              <div class="dropdown">
                <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                  <i class="icon-base ri ri-more-2-line"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" data-action="view"><i
                        class="icon-base ri ri-eye-line me-2"></i>View Full Review</a></li>
                  <li><a class="dropdown-item" href="#" data-action="feature"><i
                        class="icon-base ri ri-star-line me-2"></i>Feature Review</a></li>
                  <li><a class="dropdown-item" href="#" data-action="edit"><i
                        class="icon-base ri ri-edit-line me-2"></i>Edit</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item text-danger" href="#" data-action="remove"><i
                        class="icon-base ri ri-close-circle-line me-2"></i>Remove Inappropriate</a></li>
                </ul>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pagination -->
  <div class="d-flex justify-content-between align-items-center mt-4">
    <small class="text-muted">Showing 1 to 8 of 2,847 reviews</small>
    <nav aria-label="Page navigation">
      <ul class="pagination pagination-sm m-0">
        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
      </ul>
    </nav>
  </div>

@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Review search functionality
      document.getElementById('reviewSearch').addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(row => {
          const text = row.textContent.toLowerCase();
          row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
      });

      // Reset filters
      document.getElementById('resetFilters').addEventListener('click', function() {
        document.getElementById('filterType').value = '';
        document.getElementById('filterRating').value = '';
        document.getElementById('filterStatus').value = '';
        document.querySelectorAll('tbody tr').forEach(row => row.style.display = '');
      });

      // Action handlers
      document.querySelectorAll('[data-action]').forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          const action = this.getAttribute('data-action');
          const row = this.closest('tr');
          const reviewer = row.querySelector('td:nth-child(1) strong').textContent;
          const subject = row.querySelector('td:nth-child(2) strong').textContent;
          const rating = row.querySelector('td:nth-child(4)').textContent.trim();
          const reviewText = row.querySelector('td:nth-child(5) small').textContent;

          switch (action) {
            case 'view':
              Swal.fire({
                title: 'Review Details',
                html: `
                <div class="text-start">
                  <div class="mb-3">
                    <strong>Reviewer:</strong> ${reviewer}
                  </div>
                  <div class="mb-3">
                    <strong>Subject:</strong> ${subject}
                  </div>
                  <div class="mb-3">
                    <strong>Rating:</strong> ${rating}
                  </div>
                  <div class="mb-3">
                    <strong>Review:</strong>
                    <p class="mt-2 p-3 bg-light rounded">"${reviewText}"</p>
                  </div>
                  <div class="alert alert-info">
                    <strong>Status:</strong> ${row.querySelector('td:nth-child(6)').textContent.trim()}
                  </div>
                </div>
              `,
                confirmButtonText: 'Close',
                width: 500
              });
              break;

            case 'approve':
              Swal.fire({
                title: 'Approve Review?',
                text: `Approve the review from ${reviewer}? This will make the review public.`,
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Yes, Approve',
                confirmButtonColor: '#71dd5a',
                cancelButtonText: 'Cancel'
              }).then((result) => {
                if (result.isConfirmed) {
                  const statusCell = row.querySelector('td:nth-child(6)');
                  statusCell.innerHTML = '<span class="badge bg-label-success">Approved</span>';
                  row.style.opacity = '1';
                  row.classList.remove('table-info');
                  Swal.fire('Approved!', `Review from ${reviewer} has been approved.`, 'success');
                }
              });
              break;

            case 'feature':
              Swal.fire({
                title: 'Feature Review?',
                text: `Feature this review on the artisan/service profile? This will highlight it as a top review.`,
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Yes, Feature Review',
                confirmButtonColor: '#696cff',
                cancelButtonText: 'Cancel'
              }).then((result) => {
                if (result.isConfirmed) {
                  Swal.fire('Featured!', `Review from ${reviewer} is now featured.`, 'success');
                }
              });
              break;

            case 'edit':
              Swal.fire({
                title: 'Edit Review',
                html: `
                <div class="text-start">
                  <div class="mb-3">
                    <label class="form-label"><strong>Review Text</strong></label>
                    <textarea class="form-control" id="reviewText" rows="4">"${reviewText}"</textarea>
                  </div>
                  <div class="mb-3">
                    <label class="form-label"><strong>Status</strong></label>
                    <select class="form-select" id="reviewStatus">
                      <option>Approved</option>
                      <option>Pending</option>
                      <option>Flagged</option>
                      <option>Hidden</option>
                    </select>
                  </div>
                </div>
              `,
                showCancelButton: true,
                confirmButtonText: 'Save Changes',
                cancelButtonText: 'Cancel'
              }).then((result) => {
                if (result.isConfirmed) {
                  const newStatus = document.getElementById('reviewStatus').value;
                  const statusCell = row.querySelector('td:nth-child(6)');

                  let badgeColor = 'bg-label-success';
                  if (newStatus === 'Pending') badgeColor = 'bg-label-warning';
                  else if (newStatus === 'Flagged') badgeColor = 'bg-label-danger';
                  else if (newStatus === 'Hidden') badgeColor = 'bg-label-secondary';

                  statusCell.innerHTML = `<span class="badge ${badgeColor}">${newStatus}</span>`;
                  Swal.fire('Updated!', 'Review has been updated successfully.', 'success');
                }
              });
              break;

            case 'remove':
              Swal.fire({
                title: 'Remove Review?',
                text: 'Are you sure this review is inappropriate and should be removed?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Continue',
                confirmButtonColor: '#ff6b6b',
                cancelButtonText: 'Cancel'
              }).then((result) => {
                if (result.isConfirmed) {
                  Swal.fire({
                    title: 'Reason for Removal',
                    html: `
                    <div class="text-start">
                      <p class="mb-3">Please select the reason for removing this review:</p>
                      <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="removalReason" id="reason1" value="offensive" checked>
                        <label class="form-check-label" for="reason1">
                          Offensive or abusive language
                        </label>
                      </div>
                      <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="removalReason" id="reason2" value="spam">
                        <label class="form-check-label" for="reason2">
                          Spam or promotional content
                        </label>
                      </div>
                      <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="removalReason" id="reason3" value="irrelevant">
                        <label class="form-check-label" for="reason3">
                          Irrelevant or off-topic
                        </label>
                      </div>
                      <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="removalReason" id="reason4" value="false">
                        <label class="form-check-label" for="reason4">
                          False or misleading information
                        </label>
                      </div>
                      <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="removalReason" id="reason5" value="personal">
                        <label class="form-check-label" for="reason5">
                          Personal attack or harassment
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="removalReason" id="reason6" value="other">
                        <label class="form-check-label" for="reason6">
                          Other
                        </label>
                      </div>
                    </div>
                  `,
                    showCancelButton: true,
                    confirmButtonText: 'Remove Review',
                    confirmButtonColor: '#dc3545',
                    cancelButtonText: 'Cancel',
                    didOpen: () => {
                      document.getElementById('reason1').checked = true;
                    }
                  }).then((reasonResult) => {
                    if (reasonResult.isConfirmed) {
                      const selectedReason = document.querySelector(
                        'input[name="removalReason"]:checked').value;
                      const statusCell = row.querySelector('td:nth-child(6)');
                      statusCell.innerHTML = '<span class="badge bg-label-secondary">Hidden</span>';
                      row.style.opacity = '0.5';
                      row.style.textDecoration = 'line-through';
                      Swal.fire({
                        title: 'Removed!',
                        text: `Review has been removed.\nReason: ${selectedReason.toUpperCase()}`,
                        icon: 'success'
                      });
                    }
                  });
                }
              });
              break;
          }
        });
      });
    });
  </script>
@endsection
