@extends('layouts/layoutMaster')

@section('title', 'Reviews Monitor - ArtisanConnect Admin')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/animate-css/animate.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('content')
  <!-- Flash Messages -->
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
      <i class="icon-base ri ri-check-double-line me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
      <i class="icon-base ri ri-error-warning-line me-2"></i>{{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
      <i class="icon-base ri ri-error-warning-line me-2"></i>
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

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
              <h3 class="mb-2">{{ number_format($totalReviews) }}</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>All Time</span></p>
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
              <h3 class="mb-2">{{ $averageRating }}<span style="font-size: 0.7em;">&#9733;</span></h3>
              <p class="mb-0"><span
                  class="badge {{ $averageRating >= 4.5 ? 'bg-label-success' : ($averageRating >= 3.5 ? 'bg-label-warning' : 'bg-label-danger') }}">{{ $averageRating >= 4.5 ? 'Excellent' : ($averageRating >= 3.5 ? 'Good' : 'Fair') }}</span>
              </p>
            </div>
            <div
              class="avatar avatar-lg {{ $averageRating >= 4.5 ? 'bg-label-success' : ($averageRating >= 3.5 ? 'bg-label-warning' : 'bg-label-danger') }}">
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
              <p class="text-muted small mb-1">Awaiting Response</p>
              <h3 class="mb-2">{{ number_format($reviewsAwaitingResponse) }}</h3>
              <p class="mb-0"><span class="badge bg-label-warning">Need replies</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-warning">
              <div class="avatar-initial"><i class="icon-base ri ri-reply-line"></i></div>
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
              <p class="text-muted small mb-1">Response Rate</p>
              <h3 class="mb-2">{{ $responseRate }}%</h3>
              <p class="mb-0"><span
                  class="badge bg-label-{{ $responseRate >= 80 ? 'success' : ($responseRate >= 50 ? 'warning' : 'danger') }}">{{ $responseRate >= 80 ? 'Excellent' : ($responseRate >= 50 ? 'Good' : 'Low') }}</span>
              </p>
            </div>
            <div
              class="avatar avatar-lg bg-label-{{ $responseRate >= 80 ? 'success' : ($responseRate >= 50 ? 'warning' : 'danger') }}">
              <div class="avatar-initial"><i class="icon-base ri ri-check-double-line"></i></div>
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
              <div class="progress-bar bg-primary" role="progressbar"
                style="width: {{ $totalReviews > 0 ? ($fiveStarCount / $totalReviews) * 100 : 0 }}%"
                aria-valuenow="{{ $fiveStarCount }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="fw-medium">{{ number_format($fiveStarCount) }}</small>
          </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
          <div class="d-flex align-items-center gap-2 mb-2">
            <small class="fw-medium">4 Star</small>
            <div class="progress flex-grow-1 bg-label-primary" style="height:8px;">
              <div class="progress-bar bg-primary" role="progressbar"
                style="width: {{ $totalReviews > 0 ? ($fourStarCount / $totalReviews) * 100 : 0 }}%"
                aria-valuenow="{{ $fourStarCount }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="fw-medium">{{ number_format($fourStarCount) }}</small>
          </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
          <div class="d-flex align-items-center gap-2 mb-2">
            <small class="fw-medium">3 Star</small>
            <div class="progress flex-grow-1 bg-label-primary" style="height:8px;">
              <div class="progress-bar bg-primary" role="progressbar"
                style="width: {{ $totalReviews > 0 ? ($threeStarCount / $totalReviews) * 100 : 0 }}%"
                aria-valuenow="{{ $threeStarCount }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="fw-medium">{{ number_format($threeStarCount) }}</small>
          </div>
        </div>
        <div class="col-md-3">
          <div class="d-flex align-items-center gap-2 mb-2">
            <small class="fw-medium">Below 3</small>
            <div class="progress flex-grow-1 bg-label-primary" style="height:8px;">
              <div class="progress-bar bg-danger" role="progressbar"
                style="width: {{ $totalReviews > 0 ? ($belowThreeCount / $totalReviews) * 100 : 0 }}%"
                aria-valuenow="{{ $belowThreeCount }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="fw-medium">{{ number_format($belowThreeCount) }}</small>
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
          <div class="col-md-4">
            <label class="form-label">Rating</label>
            <select class="form-select form-select-sm" id="filterRating">
              <option value="">All Ratings</option>
              <option value="5">5 Stars</option>
              <option value="4">4 Stars</option>
              <option value="3">3 Stars</option>
              <option value="below3">Below 3 Stars</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Response</label>
            <select class="form-select form-select-sm" id="filterResponse">
              <option value="">All</option>
              <option value="responded">With Response</option>
              <option value="awaiting">Awaiting Response</option>
            </select>
          </div>
          <div class="col-md-4">
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
            <th class="py-3">Artisan</th>
            <th class="py-3">Rating</th>
            <th class="py-3">Review</th>
            <th class="py-3">Status</th>
            <th class="py-3">Date</th>
            <th class="py-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($reviews as $review)
            <tr
              @if ($review->is_hidden) style="opacity: 0.5; text-decoration: line-through;" @elseif($review->rating < 3) class="table-danger" style="opacity: 0.85;" @elseif($review->rating == 3) class="table-info" style="opacity: 0.9;" @endif>
              <td class="py-3">
                <div class="d-flex align-items-center gap-2">
                  <div class="avatar avatar-sm rounded-circle bg-label-primary">
                    <span class="avatar-initial">{{ substr($review->client?->name ?? 'N', 0, 1) }}</span>
                  </div>
                  <div>
                    <strong>{{ $review->client?->name ?? 'N/A' }}</strong>
                    <br><small class="text-muted">{{ $review->client?->email ?? '' }}</small>
                  </div>
                </div>
              </td>
              <td class="py-3">
                <strong>{{ $review->artisan?->user?->name ?? 'N/A' }}</strong>
                <br><small class="text-muted">{{ $review->artisan?->business_name ?? '' }}</small>
              </td>
              <td class="py-3">
                <span class="text-warning">
                  @for ($i = 0; $i < $review->rating; $i++)
                    &#9733;
                  @endfor
                  @for ($i = $review->rating; $i < 5; $i++)
                    &#9734;
                  @endfor
                </span>
                <strong>{{ $review->rating }}.0</strong>
              </td>
              <td class="py-3" style="max-width: 250px;">
                <small>"{{ Illuminate\Support\Str::limit($review->comment, 60) }}"</small>
              </td>
              <td class="py-3">
                @if ($review->is_hidden)
                  <span class="badge bg-label-danger">Hidden</span>
                @elseif ($review->is_featured)
                  <span class="badge bg-label-primary"><i class="icon-base ri ri-star-fill me-1"></i>Featured</span>
                @elseif ($review->has_response)
                  <span class="badge bg-label-success">Responded</span>
                @else
                  <span class="badge bg-label-warning">Awaiting Response</span>
                @endif
              </td>
              <td class="py-3">{{ $review->created_at->format('M d, Y') }}</td>
              <td class="py-3">
                <div class="dropdown">
                  <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-line"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal"
                        data-bs-target="#viewReviewModal-{{ $review->id }}">
                        <i class="icon-base ri ri-eye-line me-2"></i>View Full Review
                      </a>
                    </li>
                    @if (!$review->is_hidden)
                      <li>
                        <a class="dropdown-item feature-action" href="#"
                          data-reviewer="{{ $review->client?->name ?? 'Unknown' }}"
                          data-featured="{{ $review->is_featured ? '1' : '0' }}"
                          data-form-id="featureForm-{{ $review->id }}">
                          <i
                            class="icon-base ri ri-star-line me-2"></i>{{ $review->is_featured ? 'Unfeature Review' : 'Feature Review' }}
                        </a>
                        <form id="featureForm-{{ $review->id }}"
                          action="{{ route('admin-review-feature', $review) }}" method="POST" class="d-none">
                          @csrf
                        </form>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                          data-bs-target="#editReviewModal-{{ $review->id }}">
                          <i class="icon-base ri ri-edit-line me-2"></i>Edit
                        </a>
                      </li>
                      <li>
                        <hr class="dropdown-divider">
                      </li>
                      <li>
                        <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal"
                          data-bs-target="#removeReviewModal-{{ $review->id }}">
                          <i class="icon-base ri ri-close-circle-line me-2"></i>Remove Inappropriate
                        </a>
                      </li>
                    @else
                      <li>
                        <a class="dropdown-item restore-action text-success" href="#"
                          data-reviewer="{{ $review->client?->name ?? 'Unknown' }}"
                          data-form-id="restoreForm-{{ $review->id }}">
                          <i class="icon-base ri ri-arrow-go-back-line me-2"></i>Restore Review
                        </a>
                        <form id="restoreForm-{{ $review->id }}"
                          action="{{ route('admin-review-restore', $review) }}" method="POST" class="d-none">
                          @csrf
                        </form>
                      </li>
                    @endif
                  </ul>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-4">
                <p class="text-muted mb-0">No reviews found</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pagination -->
  <div class="d-flex justify-content-between align-items-center mt-4">
    <small class="text-muted">Showing {{ $reviews->firstItem() ?? 0 }} to {{ $reviews->lastItem() ?? 0 }} of
      {{ $reviews->total() }} reviews</small>
    {{ $reviews->links() }}
  </div>

  <!-- View Review Modals -->
  @foreach ($reviews as $review)
    <div class="modal fade" id="viewReviewModal-{{ $review->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header border-0 pb-0">
            <div>
              <h5 class="modal-title mb-1">Review Details</h5>
              <div class="d-flex gap-2">
                <span class="text-warning fs-5">
                  @for ($i = 0; $i < $review->rating; $i++)
                    &#9733;
                  @endfor
                  @for ($i = $review->rating; $i < 5; $i++)
                    &#9734;
                  @endfor
                </span>
                <span class="badge bg-label-primary align-self-center">{{ $review->rating }}.0</span>
                @if ($review->is_featured)
                  <span class="badge bg-label-warning align-self-center"><i
                      class="icon-base ri ri-star-fill me-1"></i>Featured</span>
                @endif
                @if ($review->is_hidden)
                  <span class="badge bg-label-danger align-self-center">Hidden</span>
                @endif
              </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="row g-4 mb-4">
              <!-- Reviewer -->
              <div class="col-md-6">
                <div class="card bg-light border-0">
                  <div class="card-body">
                    <h6 class="text-uppercase text-muted small mb-3">
                      <i class="icon-base ri ri-user-line me-1"></i>Reviewer
                    </h6>
                    <div class="d-flex align-items-center gap-3">
                      <div class="avatar avatar-md rounded-circle bg-label-primary">
                        <span
                          class="avatar-initial rounded-circle">{{ substr($review->client?->name ?? 'N', 0, 1) }}</span>
                      </div>
                      <div>
                        <h6 class="mb-0">{{ $review->client?->name ?? 'N/A' }}</h6>
                        <small class="text-muted">{{ $review->client?->email ?? 'N/A' }}</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Artisan -->
              <div class="col-md-6">
                <div class="card bg-light border-0">
                  <div class="card-body">
                    <h6 class="text-uppercase text-muted small mb-3">
                      <i class="icon-base ri ri-hammer-line me-1"></i>Artisan Reviewed
                    </h6>
                    <div class="d-flex align-items-center gap-3">
                      <div class="avatar avatar-md rounded-circle bg-label-warning">
                        <span
                          class="avatar-initial rounded-circle">{{ substr($review->artisan?->user?->name ?? 'N', 0, 1) }}</span>
                      </div>
                      <div>
                        <h6 class="mb-0">{{ $review->artisan?->user?->name ?? 'N/A' }}</h6>
                        <small class="text-muted">{{ $review->artisan?->business_name ?? 'N/A' }}</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Review Content -->
            <div class="card bg-light border-0 mb-4">
              <div class="card-body">
                <h6 class="text-uppercase text-muted small mb-3">
                  <i class="icon-base ri ri-chat-quote-line me-1"></i>Review Content
                </h6>
                <p class="mb-0" style="white-space: pre-wrap;">{{ $review->comment }}</p>
              </div>
            </div>

            <!-- Artisan Response -->
            @if ($review->has_response && $review->response_comment)
              <div class="card bg-light border-0 mb-4">
                <div class="card-body">
                  <h6 class="text-uppercase text-muted small mb-2">
                    <i class="icon-base ri ri-reply-line me-1"></i>Artisan Response
                  </h6>
                  <small class="text-muted d-block mb-2">{{ $review->response_date?->format('M d, Y h:i A') }}</small>
                  <p class="mb-0" style="white-space: pre-wrap;">{{ $review->response_comment }}</p>
                </div>
              </div>
            @endif

            @if ($review->is_hidden)
              <div class="alert alert-danger mb-4">
                <i class="icon-base ri ri-error-warning-line me-2"></i>
                <strong>This review has been hidden.</strong> Reason: {{ $review->hidden_reason }}
              </div>
            @endif

            <!-- Order & Date Info -->
            <div class="row g-4">
              <div class="col-md-6">
                <div class="card bg-light border-0">
                  <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                      <span class="text-muted">Order</span>
                      <span>#ORD-{{ $review->order?->created_at?->format('Y') }}-{{ str_pad($review->order_id, 3, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                      <span class="text-muted">Review Date</span>
                      <span>{{ $review->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card bg-light border-0">
                  <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                      <span class="text-muted">Has Response</span>
                      <span class="badge {{ $review->has_response ? 'bg-label-success' : 'bg-label-warning' }}">
                        {{ $review->has_response ? 'Yes' : 'No' }}
                      </span>
                    </div>
                    <div class="d-flex justify-content-between">
                      <span class="text-muted">Featured</span>
                      <span class="badge {{ $review->is_featured ? 'bg-label-primary' : 'bg-label-secondary' }}">
                        {{ $review->is_featured ? 'Yes' : 'No' }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer border-0 pt-0">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  <!-- Edit Review Modals -->
  @foreach ($reviews as $review)
    <div class="modal fade" id="editReviewModal-{{ $review->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form action="{{ route('admin-review-update', $review) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header">
              <h5 class="modal-title">Edit Review - {{ $review->client?->name ?? 'Unknown' }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Rating</label>
                <select name="rating" class="form-select" required>
                  @for ($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>
                      {{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                  @endfor
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Review Text</label>
                <textarea name="comment" class="form-control" rows="5" required minlength="3">{{ $review->comment }}</textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endforeach

  <!-- Remove Review Modals -->
  @foreach ($reviews as $review)
    @if (!$review->is_hidden)
      <div class="modal fade" id="removeReviewModal-{{ $review->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <form action="{{ route('admin-review-remove', $review) }}" method="POST">
              @csrf
              <div class="modal-header">
                <h5 class="modal-title text-danger"><i class="icon-base ri ri-error-warning-line me-2"></i>Remove
                  Inappropriate Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="alert alert-warning mb-3">
                  <small>This will hide the review from public view. You can restore it later if needed.</small>
                </div>
                <div class="mb-3">
                  <p class="mb-1 text-muted small">Review by <strong>{{ $review->client?->name ?? 'Unknown' }}</strong>
                  </p>
                  <div class="p-3 bg-light rounded">
                    <small>"{{ Illuminate\Support\Str::limit($review->comment, 120) }}"</small>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-semibold">Reason for Removal</label>
                  <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="hidden_reason"
                      id="reason-offensive-{{ $review->id }}" value="Offensive or abusive language" required>
                    <label class="form-check-label" for="reason-offensive-{{ $review->id }}">Offensive or abusive
                      language</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="hidden_reason"
                      id="reason-spam-{{ $review->id }}" value="Spam or promotional content">
                    <label class="form-check-label" for="reason-spam-{{ $review->id }}">Spam or promotional
                      content</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="hidden_reason"
                      id="reason-irrelevant-{{ $review->id }}" value="Irrelevant or off-topic">
                    <label class="form-check-label" for="reason-irrelevant-{{ $review->id }}">Irrelevant or
                      off-topic</label>
                  </div>
                  <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="hidden_reason"
                      id="reason-false-{{ $review->id }}" value="False or misleading information">
                    <label class="form-check-label" for="reason-false-{{ $review->id }}">False or misleading
                      information</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="hidden_reason"
                      id="reason-harassment-{{ $review->id }}" value="Personal attack or harassment">
                    <label class="form-check-label" for="reason-harassment-{{ $review->id }}">Personal attack or
                      harassment</label>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Remove Review</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    @endif
  @endforeach
@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Review search
      document.getElementById('reviewSearch').addEventListener('keyup', function(e) {
        var searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(function(row) {
          var text = row.textContent.toLowerCase();
          row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
      });

      // Reset filters
      document.getElementById('resetFilters').addEventListener('click', function() {
        document.getElementById('filterRating').value = '';
        document.getElementById('filterResponse').value = '';
        document.querySelectorAll('tbody tr').forEach(function(row) {
          row.style.display = '';
        });
      });

      // Feature/unfeature confirmation
      document.querySelectorAll('.feature-action').forEach(function(link) {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          var reviewer = this.getAttribute('data-reviewer');
          var isFeatured = this.getAttribute('data-featured') === '1';
          var formId = this.getAttribute('data-form-id');
          Swal.fire({
            title: isFeatured ? 'Unfeature Review?' : 'Feature Review?',
            text: isFeatured ?
              'Remove the featured status from ' + reviewer + '\'s review?' :
              'Feature ' + reviewer + '\'s review? This will highlight it on the artisan profile.',
            icon: isFeatured ? 'question' : 'info',
            showCancelButton: true,
            confirmButtonText: isFeatured ? 'Yes, Unfeature' : 'Yes, Feature Review',
            confirmButtonColor: '#696cff',
            cancelButtonText: 'Cancel'
          }).then(function(result) {
            if (result.isConfirmed) {
              document.getElementById(formId).submit();
            }
          });
        });
      });

      // Restore confirmation
      document.querySelectorAll('.restore-action').forEach(function(link) {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          var reviewer = this.getAttribute('data-reviewer');
          var formId = this.getAttribute('data-form-id');
          Swal.fire({
            title: 'Restore Review?',
            text: 'Restore ' + reviewer + '\'s review? It will be visible publicly again.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Restore',
            confirmButtonColor: '#71dd5a',
            cancelButtonText: 'Cancel'
          }).then(function(result) {
            if (result.isConfirmed) {
              document.getElementById(formId).submit();
            }
          });
        });
      });
    });
  </script>
@endsection
