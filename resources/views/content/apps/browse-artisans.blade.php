@extends('layouts/layoutMaster')

@section('title', 'Browse Artisans - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js'])
@endsection

@section('page-script')
  {{-- Add custom browse artisans script if needed --}}
@endsection

@section('content')
  <!-- Page Header -->
  <div class="row mb-6">
    <div class="col-12">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h4 class="mb-2">Browse Artisans</h4>
          <p class="text-muted mb-0">Discover verified artisans & craftspeople in Zimbabwe</p>
        </div>
        <div class="d-flex gap-2">
          <span class="badge bg-label-success"><i class="icon-base ri ri-verified-badge-line"></i> Verified Only</span>
          <span class="badge bg-label-info">457 Artisans</span>
        </div>
      </div>

      <!-- Search & Filter Bar -->
      <div class="card mb-6">
        <div class="card-body">
          <div class="row g-3 align-items-end">
            <!-- Search Input -->
            <div class="col-md-5">
              <label class="form-label">Search Artisans</label>
              <div class="input-group">
                <span class="input-group-text">
                  <i class="icon-base ri ri-search-line"></i>
                </span>
                <input type="text" class="form-control" placeholder="Name, specialty, location..." />
              </div>
            </div>

            <!-- Category Filter -->
            <div class="col-md-3">
              <label class="form-label">Category</label>
              <select class="form-select" id="categoryFilter">
                <option value="">All Categories</option>
                <option value="plumbing">Plumbing & Repairs</option>
                <option value="carpentry">Carpentry & Woodwork</option>
                <option value="electrical">Electrical Services</option>
                <option value="tailoring">Tailoring & Fashion</option>
                <option value="painting">Painting & Decoration</option>
                <option value="masonry">Masonry & Construction</option>
                <option value="welding">Welding & Metalwork</option>
                <option value="crafts">Crafts & Beadwork</option>
                <option value="automotive">Automotive Repair</option>
                <option value="hairdressing">Hairdressing & Beauty</option>
              </select>
            </div>

            <!-- Location Filter -->
            <div class="col-md-3">
              <label class="form-label">Location</label>
              <select class="form-select" id="locationFilter">
                <option value="">All Locations</option>
                <option value="harare">Harare</option>
                <option value="bulawayo">Bulawayo</option>
                <option value="chitungwiza">Chitungwiza</option>
                <option value="mutare">Mutare</option>
                <option value="gweru">Gweru</option>
                <option value="victoria-falls">Victoria Falls</option>
                <option value="kwekwe">Kwekwe</option>
                <option value="kadoma">Kadoma</option>
              </select>
            </div>

            <!-- Action Buttons -->
            <div class="col-md-1">
              <div class="d-flex gap-2">
                <button class="btn btn-icon btn-primary" title="Search">
                  <i class="icon-base ri ri-search-line icon-20px"></i>
                </button>
                <button class="btn btn-icon btn-outline-secondary" title="Reset Filters">
                  <i class="icon-base ri ri-refresh-line icon-20px"></i>
                </button>
              </div>
            </div>
          </div>

          <!-- Additional Filters -->
          <div class="row g-3 mt-2">
            <div class="col-md-3">
              <label class="form-label">Rating</label>
              <select class="form-select">
                <option value="">Any Rating</option>
                <option value="5">5 Stars</option>
                <option value="4">4+ Stars</option>
                <option value="3">3+ Stars</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Experience</label>
              <select class="form-select">
                <option value="">Any Experience</option>
                <option value="0-2">0-2 Years</option>
                <option value="2-5">2-5 Years</option>
                <option value="5+">5+ Years</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Price Range</label>
              <select class="form-select">
                <option value="">Any Price</option>
                <option value="budget">Budget ($)</option>
                <option value="mid">Mid-range ($$$)</option>
                <option value="premium">Premium ($$$)</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Availability</label>
              <select class="form-select">
                <option value="">Any Availability</option>
                <option value="available">Available Now</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Artisans Grid -->
  <div class="row g-6 mb-6">
    <!-- Artisan Card 1 -->
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card artisan-card h-100 border-0 shadow-sm transition-hover">
        <!-- Artisan Image -->
        <div class="position-relative overflow-hidden" style="height: 240px;">
          <img src="{{ asset('assets/img/avatars/1.png') }}" class="card-img-top h-100 w-100 object-fit-cover"
            alt="Artisan" />
          <div class="position-absolute top-0 end-0 m-2">
            <span class="badge bg-label-success rounded-pill">
              <i class="icon-base ri ri-verified-badge-fill icon-14px me-1"></i>Verified
            </span>
          </div>
          <div class="position-absolute bottom-0 start-0 end-0 p-3"
            style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
            <div class="d-flex gap-2">
              <button class="btn btn-icon btn-sm btn-light" title="View Profile">
                <i class="icon-base ri ri-eye-line icon-16px"></i>
              </button>
              <button class="btn btn-icon btn-sm btn-light" title="Contact">
                <i class="icon-base ri ri-phone-line icon-16px"></i>
              </button>
              <button class="btn btn-icon btn-sm btn-light" title="Add to Favorites">
                <i class="icon-base ri ri-heart-line icon-16px"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Artisan Info -->
        <div class="card-body">
          <div class="mb-3">
            <h6 class="mb-1">John Mbewe</h6>
            <p class="text-muted small mb-2">Plumbing & Repairs</p>
            <div class="d-flex align-items-center gap-2 mb-2">
              <div class="text-warning small">
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-half-fill icon-12px"></i>
              </div>
              <small class="text-muted">(127)</small>
            </div>
            <p class="text-muted small mb-2">
              <i class="icon-base ri ri-map-pin-line icon-12px"></i> Harare
            </p>
          </div>

          <div class="row g-2 mb-3">
            <div class="col-6">
              <div class="text-center p-2 bg-light rounded">
                <small class="text-muted d-block mb-1">Experience</small>
                <span class="small fw-medium">8 Years</span>
              </div>
            </div>
            <div class="col-6">
              <div class="text-center p-2 bg-light rounded">
                <small class="text-muted d-block mb-1">Jobs Done</small>
                <span class="small fw-medium">245</span>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <small class="text-muted d-block mb-2">Services</small>
            <div class="d-flex flex-wrap gap-1">
              <span class="badge bg-label-primary">Repairs</span>
              <span class="badge bg-label-primary">Installation</span>
            </div>
          </div>

          <button class="btn btn-primary w-100 btn-sm">View Profile</button>
        </div>

        <!-- Bottom Stats -->
        <div class="card-footer bg-transparent border-top">
          <div class="d-flex justify-content-between text-center small">
            <div>
              <strong>$45</strong>
              <p class="text-muted mb-0 small">Per Hour</p>
            </div>
            <div class="border-start"></div>
            <div>
              <strong>98%</strong>
              <p class="text-muted mb-0 small">Completion</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Artisan Card 2 -->
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card artisan-card h-100 border-0 shadow-sm transition-hover">
        <div class="position-relative overflow-hidden" style="height: 240px;">
          <img src="{{ asset('assets/img/avatars/3.png') }}" class="card-img-top h-100 w-100 object-fit-cover"
            alt="Artisan" />
          <div class="position-absolute top-0 end-0 m-2">
            <span class="badge bg-label-success rounded-pill">
              <i class="icon-base ri ri-verified-badge-fill icon-14px me-1"></i>Verified
            </span>
          </div>
          <div class="position-absolute bottom-0 start-0 end-0 p-3"
            style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
            <div class="d-flex gap-2">
              <button class="btn btn-icon btn-sm btn-light" title="View Profile">
                <i class="icon-base ri ri-eye-line icon-16px"></i>
              </button>
              <button class="btn btn-icon btn-sm btn-light" title="Contact">
                <i class="icon-base ri ri-phone-line icon-16px"></i>
              </button>
              <button class="btn btn-icon btn-sm btn-light" title="Add to Favorites">
                <i class="icon-base ri ri-heart-line icon-16px"></i>
              </button>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="mb-3">
            <h6 class="mb-1">Grace Muleya</h6>
            <p class="text-muted small mb-2">Tailoring & Fashion</p>
            <div class="d-flex align-items-center gap-2 mb-2">
              <div class="text-warning small">
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
              </div>
              <small class="text-muted">(98)</small>
            </div>
            <p class="text-muted small mb-2">
              <i class="icon-base ri ri-map-pin-line icon-12px"></i> Harare
            </p>
          </div>

          <div class="row g-2 mb-3">
            <div class="col-6">
              <div class="text-center p-2 bg-light rounded">
                <small class="text-muted d-block mb-1">Experience</small>
                <span class="small fw-medium">6 Years</span>
              </div>
            </div>
            <div class="col-6">
              <div class="text-center p-2 bg-light rounded">
                <small class="text-muted d-block mb-1">Jobs Done</small>
                <span class="small fw-medium">189</span>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <small class="text-muted d-block mb-2">Services</small>
            <div class="d-flex flex-wrap gap-1">
              <span class="badge bg-label-success">Custom Designs</span>
              <span class="badge bg-label-success">Alterations</span>
            </div>
          </div>

          <button class="btn btn-primary w-100 btn-sm">View Profile</button>
        </div>

        <div class="card-footer bg-transparent border-top">
          <div class="d-flex justify-content-between text-center small">
            <div>
              <strong>$30</strong>
              <p class="text-muted mb-0 small">Per Hour</p>
            </div>
            <div class="border-start"></div>
            <div>
              <strong>100%</strong>
              <p class="text-muted mb-0 small">Completion</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Artisan Card 3 -->
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card artisan-card h-100 border-0 shadow-sm transition-hover">
        <div class="position-relative overflow-hidden" style="height: 240px;">
          <img src="{{ asset('assets/img/avatars/2.png') }}" class="card-img-top h-100 w-100 object-fit-cover"
            alt="Artisan" />
          <div class="position-absolute top-0 end-0 m-2">
            <span class="badge bg-label-success rounded-pill">
              <i class="icon-base ri ri-verified-badge-fill icon-14px me-1"></i>Verified
            </span>
          </div>
          <div class="position-absolute bottom-0 start-0 end-0 p-3"
            style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
            <div class="d-flex gap-2">
              <button class="btn btn-icon btn-sm btn-light" title="View Profile">
                <i class="icon-base ri ri-eye-line icon-16px"></i>
              </button>
              <button class="btn btn-icon btn-sm btn-light" title="Contact">
                <i class="icon-base ri ri-phone-line icon-16px"></i>
              </button>
              <button class="btn btn-icon btn-sm btn-light" title="Add to Favorites">
                <i class="icon-base ri ri-heart-line icon-16px"></i>
              </button>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="mb-3">
            <h6 class="mb-1">Peter Nkomo</h6>
            <p class="text-muted small mb-2">Carpentry & Woodwork</p>
            <div class="d-flex align-items-center gap-2 mb-2">
              <div class="text-warning small">
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-line icon-12px"></i>
              </div>
              <small class="text-muted">(64)</small>
            </div>
            <p class="text-muted small mb-2">
              <i class="icon-base ri ri-map-pin-line icon-12px"></i> Bulawayo
            </p>
          </div>

          <div class="row g-2 mb-3">
            <div class="col-6">
              <div class="text-center p-2 bg-light rounded">
                <small class="text-muted d-block mb-1">Experience</small>
                <span class="small fw-medium">12 Years</span>
              </div>
            </div>
            <div class="col-6">
              <div class="text-center p-2 bg-light rounded">
                <small class="text-muted d-block mb-1">Jobs Done</small>
                <span class="small fw-medium">312</span>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <small class="text-muted d-block mb-2">Services</small>
            <div class="d-flex flex-wrap gap-1">
              <span class="badge bg-label-warning">Furniture</span>
              <span class="badge bg-label-warning">Renovation</span>
            </div>
          </div>

          <button class="btn btn-primary w-100 btn-sm">View Profile</button>
        </div>

        <div class="card-footer bg-transparent border-top">
          <div class="d-flex justify-content-between text-center small">
            <div>
              <strong>$55</strong>
              <p class="text-muted mb-0 small">Per Hour</p>
            </div>
            <div class="border-start"></div>
            <div>
              <strong>96%</strong>
              <p class="text-muted mb-0 small">Completion</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Artisan Card 4 -->
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card artisan-card h-100 border-0 shadow-sm transition-hover">
        <div class="position-relative overflow-hidden" style="height: 240px;">
          <img src="{{ asset('assets/img/avatars/4.png') }}" class="card-img-top h-100 w-100 object-fit-cover"
            alt="Artisan" />
          <div class="position-absolute top-0 end-0 m-2">
            <span class="badge bg-label-success rounded-pill">
              <i class="icon-base ri ri-verified-badge-fill icon-14px me-1"></i>Verified
            </span>
          </div>
          <div class="position-absolute bottom-0 start-0 end-0 p-3"
            style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
            <div class="d-flex gap-2">
              <button class="btn btn-icon btn-sm btn-light" title="View Profile">
                <i class="icon-base ri ri-eye-line icon-16px"></i>
              </button>
              <button class="btn btn-icon btn-sm btn-light" title="Contact">
                <i class="icon-base ri ri-phone-line icon-16px"></i>
              </button>
              <button class="btn btn-icon btn-sm btn-light" title="Add to Favorites">
                <i class="icon-base ri ri-heart-line icon-16px"></i>
              </button>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="mb-3">
            <h6 class="mb-1">Tendai Moyo</h6>
            <p class="text-muted small mb-2">Electrical Services</p>
            <div class="d-flex align-items-center gap-2 mb-2">
              <div class="text-warning small">
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-half-fill icon-12px"></i>
              </div>
              <small class="text-muted">(156)</small>
            </div>
            <p class="text-muted small mb-2">
              <i class="icon-base ri ri-map-pin-line icon-12px"></i> Harare
            </p>
          </div>

          <div class="row g-2 mb-3">
            <div class="col-6">
              <div class="text-center p-2 bg-light rounded">
                <small class="text-muted d-block mb-1">Experience</small>
                <span class="small fw-medium">10 Years</span>
              </div>
            </div>
            <div class="col-6">
              <div class="text-center p-2 bg-light rounded">
                <small class="text-muted d-block mb-1">Jobs Done</small>
                <span class="small fw-medium">428</span>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <small class="text-muted d-block mb-2">Services</small>
            <div class="d-flex flex-wrap gap-1">
              <span class="badge bg-label-info">Wiring</span>
              <span class="badge bg-label-info">Maintenance</span>
            </div>
          </div>

          <button class="btn btn-primary w-100 btn-sm">View Profile</button>
        </div>

        <div class="card-footer bg-transparent border-top">
          <div class="d-flex justify-content-between text-center small">
            <div>
              <strong>$50</strong>
              <p class="text-muted mb-0 small">Per Hour</p>
            </div>
            <div class="border-start"></div>
            <div>
              <strong>99%</strong>
              <p class="text-muted mb-0 small">Completion</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Artisan Card 5 -->
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card artisan-card h-100 border-0 shadow-sm transition-hover">
        <div class="position-relative overflow-hidden" style="height: 240px;">
          <img src="{{ asset('assets/img/avatars/5.png') }}" class="card-img-top h-100 w-100 object-fit-cover"
            alt="Artisan" />
          <div class="position-absolute top-0 end-0 m-2">
            <span class="badge bg-label-success rounded-pill">
              <i class="icon-base ri ri-verified-badge-fill icon-14px me-1"></i>Verified
            </span>
          </div>
          <div class="position-absolute bottom-0 start-0 end-0 p-3"
            style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
            <div class="d-flex gap-2">
              <button class="btn btn-icon btn-sm btn-light" title="View Profile">
                <i class="icon-base ri ri-eye-line icon-16px"></i>
              </button>
              <button class="btn btn-icon btn-sm btn-light" title="Contact">
                <i class="icon-base ri ri-phone-line icon-16px"></i>
              </button>
              <button class="btn btn-icon btn-sm btn-light" title="Add to Favorites">
                <i class="icon-base ri ri-heart-line icon-16px"></i>
              </button>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="mb-3">
            <h6 class="mb-1">Chipo Mwale</h6>
            <p class="text-muted small mb-2">Crafts & Beadwork</p>
            <div class="d-flex align-items-center gap-2 mb-2">
              <div class="text-warning small">
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
              </div>
              <small class="text-muted">(203)</small>
            </div>
            <p class="text-muted small mb-2">
              <i class="icon-base ri ri-map-pin-line icon-12px"></i> Chitungwiza
            </p>
          </div>

          <div class="row g-2 mb-3">
            <div class="col-6">
              <div class="text-center p-2 bg-light rounded">
                <small class="text-muted d-block mb-1">Experience</small>
                <span class="small fw-medium">4 Years</span>
              </div>
            </div>
            <div class="col-6">
              <div class="text-center p-2 bg-light rounded">
                <small class="text-muted d-block mb-1">Jobs Done</small>
                <span class="small fw-medium">156</span>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <small class="text-muted d-block mb-2">Services</small>
            <div class="d-flex flex-wrap gap-1">
              <span class="badge bg-label-danger">Bead Art</span>
              <span class="badge bg-label-danger">Jewelry</span>
            </div>
          </div>

          <button class="btn btn-primary w-100 btn-sm">View Profile</button>
        </div>

        <div class="card-footer bg-transparent border-top">
          <div class="d-flex justify-content-between text-center small">
            <div>
              <strong>$35</strong>
              <p class="text-muted mb-0 small">Per Hour</p>
            </div>
            <div class="border-start"></div>
            <div>
              <strong>100%</strong>
              <p class="text-muted mb-0 small">Completion</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Artisan Card 6 -->
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card artisan-card h-100 border-0 shadow-sm transition-hover">
        <div class="position-relative overflow-hidden" style="height: 240px;">
          <img src="{{ asset('assets/img/avatars/6.png') }}" class="card-img-top h-100 w-100 object-fit-cover"
            alt="Artisan" />
          <div class="position-absolute top-0 end-0 m-2">
            <span class="badge bg-label-success rounded-pill">
              <i class="icon-base ri ri-verified-badge-fill icon-14px me-1"></i>Verified
            </span>
          </div>
          <div class="position-absolute bottom-0 start-0 end-0 p-3"
            style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
            <div class="d-flex gap-2">
              <button class="btn btn-icon btn-sm btn-light" title="View Profile">
                <i class="icon-base ri ri-eye-line icon-16px"></i>
              </button>
              <button class="btn btn-icon btn-sm btn-light" title="Contact">
                <i class="icon-base ri ri-phone-line icon-16px"></i>
              </button>
              <button class="btn btn-icon btn-sm btn-light" title="Add to Favorites">
                <i class="icon-base ri ri-heart-line icon-16px"></i>
              </button>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="mb-3">
            <h6 class="mb-1">Samuel Mbonjana</h6>
            <p class="text-muted small mb-2">Masonry & Construction</p>
            <div class="d-flex align-items-center gap-2 mb-2">
              <div class="text-warning small">
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-fill icon-12px"></i>
                <i class="icon-base ri ri-star-half-fill icon-12px"></i>
              </div>
              <small class="text-muted">(89)</small>
            </div>
            <p class="text-muted small mb-2">
              <i class="icon-base ri ri-map-pin-line icon-12px"></i> Gweru
            </p>
          </div>

          <div class="row g-2 mb-3">
            <div class="col-6">
              <div class="text-center p-2 bg-light rounded">
                <small class="text-muted d-block mb-1">Experience</small>
                <span class="small fw-medium">9 Years</span>
              </div>
            </div>
            <div class="col-6">
              <div class="text-center p-2 bg-light rounded">
                <small class="text-muted d-block mb-1">Jobs Done</small>
                <span class="small fw-medium">267</span>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <small class="text-muted d-block mb-2">Services</small>
            <div class="d-flex flex-wrap gap-1">
              <span class="badge bg-label-secondary">Brick Work</span>
              <span class="badge bg-label-secondary">Concrete</span>
            </div>
          </div>

          <button class="btn btn-primary w-100 btn-sm">View Profile</button>
        </div>

        <div class="card-footer bg-transparent border-top">
          <div class="d-flex justify-content-between text-center small">
            <div>
              <strong>$40</strong>
              <p class="text-muted mb-0 small">Per Hour</p>
            </div>
            <div class="border-start"></div>
            <div>
              <strong>94%</strong>
              <p class="text-muted mb-0 small">Completion</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pagination -->
  <div class="row">
    <div class="col-12">
      <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center mb-0">
          <li class="page-item disabled">
            <a class="page-link" href="javascript:void(0);">Previous</a>
          </li>
          <li class="page-item active">
            <a class="page-link" href="javascript:void(0);">1</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="javascript:void(0);">2</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="javascript:void(0);">3</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="javascript:void(0);">...</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="javascript:void(0);">Last</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="javascript:void(0);">Next</a>
          </li>
        </ul>
      </nav>
    </div>
  </div>

  <!-- Custom CSS -->
  <style>
    .artisan-card {
      transition: all 0.3s ease;
      border-radius: 12px;
    }

    .artisan-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15) !important;
    }

    .artisan-card .card-body {
      padding: 1.5rem;
    }

    .artisan-card .card-footer {
      padding: 1rem 1.5rem;
    }

    .transition-hover {
      transition: all 0.3s ease;
    }

    .object-fit-cover {
      object-fit: cover;
    }

    .badge-divider-bg {
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }
  </style>
@endsection
