@extends('layouts/layoutMaster')

@section('title', 'My Reviews - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/apex-charts/apexcharts.js'])
@endsection

@section('page-script')
  {{-- Custom review scripts --}}
@endsection

@section('content')
  <!-- Page Header -->
  <div class="row mb-6">
    <div class="col-12">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h4 class="mb-2">My Reviews</h4>
          <p class="text-muted mb-0">Manage and track all your artisan reviews</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createReviewModal">
          <i class="icon-base ri ri-add-line me-2"></i>Create Review
        </button>
      </div>
    </div>
  </div>

  <!-- Review Statistics -->
  <div class="row g-6 mb-6">
    <!-- Total Reviews -->
    <div class="col-lg-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="mb-1 text-muted">Total Reviews</p>
              <h4 class="mb-2">12</h4>
              <p class="mb-0 text-success"><i class="icon-base ri ri-arrow-up-s-line"></i> +2 this month</p>
            </div>
            <div class="avatar bg-label-primary">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-chat-3-line icon-24px"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Average Rating -->
    <div class="col-lg-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="mb-1 text-muted">Average Rating</p>
              <div class="d-flex align-items-center gap-2 mb-2">
                <h4 class="mb-0">4.6</h4>
                <div class="text-warning small">
                  <i class="icon-base ri ri-star-fill icon-16px"></i>
                  <i class="icon-base ri ri-star-fill icon-16px"></i>
                  <i class="icon-base ri ri-star-fill icon-16px"></i>
                  <i class="icon-base ri ri-star-fill icon-16px"></i>
                  <i class="icon-base ri ri-star-half-fill icon-16px"></i>
                </div>
              </div>
              <p class="mb-0 text-success">Excellent rating</p>
            </div>
            <div class="avatar bg-label-warning">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-star-line icon-24px"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 5-Star Reviews -->
    <div class="col-lg-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="mb-1 text-muted">5-Star Reviews</p>
              <h4 class="mb-2">8</h4>
              <p class="mb-0 text-info">67% of all reviews</p>
            </div>
            <div class="avatar bg-label-success">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-thumb-up-line icon-24px"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Reviews -->
    <div class="col-lg-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="mb-1 text-muted">Pending Reviews</p>
              <h4 class="mb-2">3</h4>
              <p class="mb-0 text-warning"><i class="icon-base ri ri-time-line me-1"></i>Awaiting submission</p>
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
  </div>

  <!-- Rating Distribution Chart -->
  <div class="row g-6 mb-6">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Rating Distribution</h5>
        </div>
        <div class="card-body">
          <div class="row g-6">
            <div class="col-md-8">
              <div id="ratingDistributionChart" style="height: 300px;"></div>
            </div>
            <div class="col-md-4">
              <div class="d-flex flex-column gap-3">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center gap-2">
                    <span class="text-warning">
                      <i class="icon-base ri ri-star-fill icon-16px"></i>
                      <i class="icon-base ri ri-star-fill icon-16px"></i>
                      <i class="icon-base ri ri-star-fill icon-16px"></i>
                      <i class="icon-base ri ri-star-fill icon-16px"></i>
                      <i class="icon-base ri ri-star-fill icon-16px"></i>
                    </span>
                    <span class="text-muted small">5 Stars</span>
                  </div>
                  <span class="badge bg-label-success">8</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center gap-2">
                    <span class="text-warning">
                      <i class="icon-base ri ri-star-fill icon-16px"></i>
                      <i class="icon-base ri ri-star-fill icon-16px"></i>
                      <i class="icon-base ri ri-star-fill icon-16px"></i>
                      <i class="icon-base ri ri-star-fill icon-16px"></i>
                      <i class="icon-base ri ri-star-line icon-16px"></i>
                    </span>
                    <span class="text-muted small">4 Stars</span>
                  </div>
                  <span class="badge bg-label-info">3</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center gap-2">
                    <span class="text-warning">
                      <i class="icon-base ri ri-star-fill icon-16px"></i>
                      <i class="icon-base ri ri-star-fill icon-16px"></i>
                      <i class="icon-base ri ri-star-fill icon-16px"></i>
                      <i class="icon-base ri ri-star-line icon-16px"></i>
                      <i class="icon-base ri ri-star-line icon-16px"></i>
                    </span>
                    <span class="text-muted small">3 Stars</span>
                  </div>
                  <span class="badge bg-label-warning">1</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center gap-2">
                    <span class="text-warning">
                      <i class="icon-base ri ri-star-fill icon-16px"></i>
                      <i class="icon-base ri ri-star-fill icon-16px"></i>
                      <i class="icon-base ri ri-star-line icon-16px"></i>
                      <i class="icon-base ri ri-star-line icon-16px"></i>
                      <i class="icon-base ri ri-star-line icon-16px"></i>
                    </span>
                    <span class="text-muted small">2 Stars</span>
                  </div>
                  <span class="badge bg-label-danger">0</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center gap-2">
                    <span class="text-warning">
                      <i class="icon-base ri ri-star-fill icon-16px"></i>
                      <i class="icon-base ri ri-star-line icon-16px"></i>
                      <i class="icon-base ri ri-star-line icon-16px"></i>
                      <i class="icon-base ri ri-star-line icon-16px"></i>
                      <i class="icon-base ri ri-star-line icon-16px"></i>
                    </span>
                    <span class="text-muted small">1 Star</span>
                  </div>
                  <span class="badge bg-label-danger">0</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Submitted Reviews -->
  <div class="row g-6 mb-6">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Submitted Reviews</h5>
            <div class="d-flex gap-2">
              <button class="btn btn-sm btn-outline-secondary">
                <i class="icon-base ri ri-filter-line me-1"></i>Filter
              </button>
              <button class="btn btn-sm btn-outline-secondary">
                <i class="icon-base ri ri-sort-desc icon-20px"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="review-list">
            <!-- Review Item 1 -->
            <div class="review-item border-bottom pb-4 mb-4">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="d-flex align-items-start gap-3 flex-grow-1">
                  <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Artisan" class="rounded-circle"
                    width="48" height="48" />
                  <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                      <div>
                        <h6 class="mb-1">John Mbewe</h6>
                        <p class="text-muted small mb-0">Plumbing & Repairs</p>
                      </div>
                      <div class="text-end">
                        <div class="text-warning small mb-2">
                          <i class="icon-base ri ri-star-fill icon-14px"></i>
                          <i class="icon-base ri ri-star-fill icon-14px"></i>
                          <i class="icon-base ri ri-star-fill icon-14px"></i>
                          <i class="icon-base ri ri-star-fill icon-14px"></i>
                          <i class="icon-base ri ri-star-fill icon-14px"></i>
                        </div>
                        <span class="badge bg-label-success">5/5 Stars</span>
                      </div>
                    </div>
                    <p class="mb-3">
                      "Excellent work! John was professional, punctual, and very knowledgeable. He fixed all our plumbing
                      issues with great attention to detail. Highly recommended!"
                    </p>
                    <div class="d-flex gap-2 flex-wrap">
                      <span class="badge bg-light text-dark">Professional</span>
                      <span class="badge bg-light text-dark">Reliable</span>
                      <span class="badge bg-light text-dark">Knowledgeable</span>
                    </div>
                  </div>
                </div>
                <div class="dropdown ms-3">
                  <button class="btn btn-icon btn-text-secondary rounded-pill p-0" type="button"
                    data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-line"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                      data-bs-target="#editReviewModal">
                      <i class="icon-base ri ri-edit-line me-2"></i>Edit Review
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-delete-bin-line me-2"></i>Delete Review
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-eye-line me-2"></i>View Public
                    </a>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Reviewed on Jan 20, 2026</small>
                <span class="badge bg-label-success">Published</span>
              </div>
            </div>

            <!-- Review Item 2 -->
            <div class="review-item border-bottom pb-4 mb-4">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="d-flex align-items-start gap-3 flex-grow-1">
                  <img src="{{ asset('assets/img/avatars/3.png') }}" alt="Artisan" class="rounded-circle"
                    width="48" height="48" />
                  <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                      <div>
                        <h6 class="mb-1">Grace Muleya</h6>
                        <p class="text-muted small mb-0">Tailoring & Fashion</p>
                      </div>
                      <div class="text-end">
                        <div class="text-warning small mb-2">
                          <i class="icon-base ri ri-star-fill icon-14px"></i>
                          <i class="icon-base ri ri-star-fill icon-14px"></i>
                          <i class="icon-base ri ri-star-fill icon-14px"></i>
                          <i class="icon-base ri ri-star-fill icon-14px"></i>
                          <i class="icon-base ri ri-star-half-fill icon-14px"></i>
                        </div>
                        <span class="badge bg-label-info">4.5/5 Stars</span>
                      </div>
                    </div>
                    <p class="mb-3">
                      "Grace did a fantastic job with my custom tailoring. The designs were beautiful and the fit was
                      perfect. The only small issue was it took a bit longer than expected, but the quality made up for
                      it."
                    </p>
                    <div class="d-flex gap-2 flex-wrap">
                      <span class="badge bg-light text-dark">Creative</span>
                      <span class="badge bg-light text-dark">Quality Work</span>
                    </div>
                  </div>
                </div>
                <div class="dropdown ms-3">
                  <button class="btn btn-icon btn-text-secondary rounded-pill p-0" type="button"
                    data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-line"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                      data-bs-target="#editReviewModal">
                      <i class="icon-base ri ri-edit-line me-2"></i>Edit Review
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-delete-bin-line me-2"></i>Delete Review
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-eye-line me-2"></i>View Public
                    </a>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Reviewed on Jan 15, 2026</small>
                <span class="badge bg-label-success">Published</span>
              </div>
            </div>

            <!-- Review Item 3 -->
            <div class="review-item border-bottom pb-4 mb-4">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="d-flex align-items-start gap-3 flex-grow-1">
                  <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Artisan" class="rounded-circle"
                    width="48" height="48" />
                  <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                      <div>
                        <h6 class="mb-1">Peter Nkomo</h6>
                        <p class="text-muted small mb-0">Carpentry & Woodwork</p>
                      </div>
                      <div class="text-end">
                        <div class="text-warning small mb-2">
                          <i class="icon-base ri ri-star-fill icon-14px"></i>
                          <i class="icon-base ri ri-star-fill icon-14px"></i>
                          <i class="icon-base ri ri-star-fill icon-14px"></i>
                          <i class="icon-base ri ri-star-fill icon-14px"></i>
                          <i class="icon-base ri ri-star-line icon-14px"></i>
                        </div>
                        <span class="badge bg-label-warning">4/5 Stars</span>
                      </div>
                    </div>
                    <p class="mb-3">
                      "Peter built beautiful custom furniture for our living room. The craftsmanship is outstanding and
                      the pieces look even better in person. Very satisfied with the results."
                    </p>
                    <div class="d-flex gap-2 flex-wrap">
                      <span class="badge bg-light text-dark">Expert Craftsmanship</span>
                      <span class="badge bg-light text-dark">Custom Design</span>
                    </div>
                  </div>
                </div>
                <div class="dropdown ms-3">
                  <button class="btn btn-icon btn-text-secondary rounded-pill p-0" type="button"
                    data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-line"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                      data-bs-target="#editReviewModal">
                      <i class="icon-base ri ri-edit-line me-2"></i>Edit Review
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-delete-bin-line me-2"></i>Delete Review
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-eye-line me-2"></i>View Public
                    </a>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Reviewed on Jan 10, 2026</small>
                <span class="badge bg-label-success">Published</span>
              </div>
            </div>

            <!-- Review Item 4 - Pending -->
            <div class="review-item">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="d-flex align-items-start gap-3 flex-grow-1">
                  <img src="{{ asset('assets/img/avatars/4.png') }}" alt="Artisan" class="rounded-circle"
                    width="48" height="48" />
                  <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                      <div>
                        <h6 class="mb-1">Tendai Moyo</h6>
                        <p class="text-muted small mb-0">Electrical Services</p>
                      </div>
                      <div class="text-end">
                        <div class="text-warning small mb-2">
                          <i class="icon-base ri ri-star-line icon-14px"></i>
                          <i class="icon-base ri ri-star-line icon-14px"></i>
                          <i class="icon-base ri ri-star-line icon-14px"></i>
                          <i class="icon-base ri ri-star-line icon-14px"></i>
                          <i class="icon-base ri ri-star-line icon-14px"></i>
                        </div>
                        <span class="badge bg-label-secondary">Draft</span>
                      </div>
                    </div>
                    <p class="mb-3 text-muted">
                      <em>Draft review - Not yet submitted</em>
                    </p>
                    <div class="d-flex gap-2">
                      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editReviewModal">
                        <i class="icon-base ri ri-edit-line me-1"></i>Continue Editing
                      </button>
                      <button class="btn btn-sm btn-outline-danger">
                        <i class="icon-base ri ri-delete-bin-line me-1"></i>Discard
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Create Review Modal -->
  <div class="modal fade" id="createReviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create New Review</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <!-- Select Artisan -->
            <div class="mb-4">
              <label class="form-label">Select Artisan</label>
              <select class="form-select">
                <option value="">Choose an artisan...</option>
                <option value="1">John Mbewe - Plumbing & Repairs</option>
                <option value="2">Grace Muleya - Tailoring & Fashion</option>
                <option value="3">Peter Nkomo - Carpentry & Woodwork</option>
                <option value="4">Tendai Moyo - Electrical Services</option>
              </select>
            </div>

            <!-- Star Rating -->
            <div class="mb-4">
              <label class="form-label">Your Rating</label>
              <div class="d-flex gap-3">
                <div class="rating-input">
                  <i class="icon-base ri ri-star-line icon-32px text-muted cursor-pointer" data-rating="1"></i>
                </div>
                <div class="rating-input">
                  <i class="icon-base ri ri-star-line icon-32px text-muted cursor-pointer" data-rating="2"></i>
                </div>
                <div class="rating-input">
                  <i class="icon-base ri ri-star-line icon-32px text-muted cursor-pointer" data-rating="3"></i>
                </div>
                <div class="rating-input">
                  <i class="icon-base ri ri-star-line icon-32px text-muted cursor-pointer" data-rating="4"></i>
                </div>
                <div class="rating-input">
                  <i class="icon-base ri ri-star-line icon-32px text-muted cursor-pointer" data-rating="5"></i>
                </div>
              </div>
            </div>

            <!-- Review Title -->
            <div class="mb-4">
              <label class="form-label">Review Title</label>
              <input type="text" class="form-control" placeholder="e.g., Excellent work and very professional" />
            </div>

            <!-- Review Text -->
            <div class="mb-4">
              <label class="form-label">Your Review</label>
              <textarea class="form-control" rows="5" placeholder="Share your experience with this artisan..."></textarea>
            </div>

            <!-- Highlight Tags -->
            <div class="mb-4">
              <label class="form-label">Highlight Tags</label>
              <div class="d-flex flex-wrap gap-2">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="tag1" />
                  <label class="form-check-label" for="tag1">Professional</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="tag2" />
                  <label class="form-check-label" for="tag2">Reliable</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="tag3" />
                  <label class="form-check-label" for="tag3">Quality Work</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="tag4" />
                  <label class="form-check-label" for="tag4">Good Communication</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="tag5" />
                  <label class="form-check-label" for="tag5">Affordable</label>
                </div>
              </div>
            </div>

            <!-- Would Recommend -->
            <div class="mb-4">
              <label class="form-label">Would you recommend this artisan?</label>
              <div class="d-flex gap-3">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="recommend" id="recommend-yes" value="yes"
                    checked />
                  <label class="form-check-label" for="recommend-yes">Yes, definitely</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="recommend" id="recommend-maybe"
                    value="maybe" />
                  <label class="form-check-label" for="recommend-maybe">Not sure</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="recommend" id="recommend-no" value="no" />
                  <label class="form-check-label" for="recommend-no">No</label>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Save as Draft</button>
          <button type="button" class="btn btn-primary">Publish Review</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Review Modal -->
  <div class="modal fade" id="editReviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Review</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <!-- Artisan Info (Read-only) -->
            <div class="mb-4 p-3 bg-light rounded">
              <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Artisan" class="rounded-circle"
                  width="48" height="48" />
                <div>
                  <h6 class="mb-0">John Mbewe</h6>
                  <p class="text-muted small mb-0">Plumbing & Repairs</p>
                </div>
              </div>
            </div>

            <!-- Star Rating -->
            <div class="mb-4">
              <label class="form-label">Your Rating</label>
              <div class="d-flex gap-3">
                <div class="rating-input">
                  <i class="icon-base ri ri-star-fill icon-32px text-warning cursor-pointer" data-rating="1"></i>
                </div>
                <div class="rating-input">
                  <i class="icon-base ri ri-star-fill icon-32px text-warning cursor-pointer" data-rating="2"></i>
                </div>
                <div class="rating-input">
                  <i class="icon-base ri ri-star-fill icon-32px text-warning cursor-pointer" data-rating="3"></i>
                </div>
                <div class="rating-input">
                  <i class="icon-base ri ri-star-fill icon-32px text-warning cursor-pointer" data-rating="4"></i>
                </div>
                <div class="rating-input">
                  <i class="icon-base ri ri-star-fill icon-32px text-warning cursor-pointer" data-rating="5"></i>
                </div>
              </div>
            </div>

            <!-- Review Title -->
            <div class="mb-4">
              <label class="form-label">Review Title</label>
              <input type="text" class="form-control"
                value="Excellent work! John was professional, punctual, and very knowledgeable." />
            </div>

            <!-- Review Text -->
            <div class="mb-4">
              <label class="form-label">Your Review</label>
              <textarea class="form-control" rows="5">Excellent work! John was professional, punctual, and very knowledgeable. He fixed all our plumbing issues with great attention to detail. Highly recommended!</textarea>
            </div>

            <!-- Highlight Tags -->
            <div class="mb-4">
              <label class="form-label">Highlight Tags</label>
              <div class="d-flex flex-wrap gap-2">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="edit-tag1" checked />
                  <label class="form-check-label" for="edit-tag1">Professional</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="edit-tag2" checked />
                  <label class="form-check-label" for="edit-tag2">Reliable</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="edit-tag3" />
                  <label class="form-check-label" for="edit-tag3">Quality Work</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="edit-tag4" checked />
                  <label class="form-check-label" for="edit-tag4">Good Communication</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="edit-tag5" />
                  <label class="form-check-label" for="edit-tag5">Affordable</label>
                </div>
              </div>
            </div>

            <!-- Would Recommend -->
            <div class="mb-4">
              <label class="form-label">Would you recommend this artisan?</label>
              <div class="d-flex gap-3">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="edit-recommend" id="edit-recommend-yes"
                    value="yes" checked />
                  <label class="form-check-label" for="edit-recommend-yes">Yes, definitely</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="edit-recommend" id="edit-recommend-maybe"
                    value="maybe" />
                  <label class="form-check-label" for="edit-recommend-maybe">Not sure</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="edit-recommend" id="edit-recommend-no"
                    value="no" />
                  <label class="form-check-label" for="edit-recommend-no">No</label>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Custom Script for Charts and Interactions -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Rating Distribution Chart
      const ratingDistributionChart = new ApexCharts(document.querySelector("#ratingDistributionChart"), {
        series: [8, 3, 1, 0, 0],
        chart: {
          type: 'donut',
          height: 300
        },
        colors: ['#28c76f', '#4099ff', '#ffb64d', '#ff6b6b', '#e0e0e0'],
        labels: ['5 Stars', '4 Stars', '3 Stars', '2 Stars', '1 Star'],
        legend: {
          position: 'bottom'
        },
        dataLabels: {
          enabled: true,
          formatter: function(val) {
            return Math.round(val) + '%'
          }
        }
      });
      ratingDistributionChart.render();

      // Star Rating Input Handler
      const ratingInputs = document.querySelectorAll('.rating-input i');
      ratingInputs.forEach((star, index) => {
        star.addEventListener('click', function() {
          const rating = this.getAttribute('data-rating');
          ratingInputs.forEach((s, i) => {
            if (i < rating) {
              s.classList.remove('ri-star-line');
              s.classList.add('ri-star-fill');
              s.classList.add('text-warning');
            } else {
              s.classList.add('ri-star-line');
              s.classList.remove('ri-star-fill');
              s.classList.remove('text-warning');
            }
          });
        });
      });
    });
  </script>

  <style>
    .cursor-pointer {
      cursor: pointer;
    }

    .review-item {
      transition: all 0.3s ease;
    }

    .review-item:hover {
      background-color: rgba(0, 0, 0, 0.02);
      border-radius: 8px;
      padding: 12px;
      margin: -12px;
    }

    .rating-input i {
      transition: all 0.2s ease;
    }

    .rating-input i:hover {
      transform: scale(1.2);
    }
  </style>
@endsection
