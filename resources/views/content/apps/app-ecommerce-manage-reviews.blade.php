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
              <h3 class="mb-2">{{ $averageRating }}<span style="font-size: 0.7em;">★</span></h3>
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
              <p class="text-muted small mb-1">Pending Approval</p>
              <h3 class="mb-2">{{ number_format($pendingApprovalReviews) }}</h3>
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
              <h3 class="mb-2">{{ number_format($flaggedReviews) }}</h3>
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
          @forelse($reviews as $review)
            <tr
              @if ($review->rating >= 4) class="table-success" style="opacity: 0.9;" @elseif($review->rating < 3) class="table-danger" style="opacity: 0.8;" @elseif($review->rating == 3) class="table-info" style="opacity: 0.85;" @endif>
              <td class="py-3">
                <div class="d-flex align-items-center gap-2">
                  <div class="avatar avatar-sm rounded-circle bg-label-primary">
                    <span class="avatar-initial">{{ substr($review->client?->name ?? 'N', 0, 1) }}</span>
                  </div>
                  <div>
                    <strong>{{ $review->client?->name ?? 'N/A' }}</strong>
                    <br><small class="text-muted">Verified Customer</small>
                  </div>
                </div>
              </td>
              <td class="py-3">
                <strong>Service</strong><br>
                <small class="text-muted">{{ $review->artisan?->user?->name ?? 'N/A' }}</small>
              </td>
              <td class="py-3"><span class="badge bg-label-info">Service</span></td>
              <td class="py-3">
                <span class="text-warning">
                  @for ($i = 0; $i < $review->rating; $i++)
                    ★
                  @endfor
                  @for ($i = $review->rating; $i < 5; $i++)
                    ☆
                  @endfor
                </span>
                <strong>{{ $review->rating }}.0</strong>
              </td>
              <td class="py-3">
                <small>"{{ substr($review->comment, 0, 60) }}{{ strlen($review->comment) > 60 ? '...' : '' }}"</small>
              </td>
              <td class="py-3"><span class="badge bg-label-success">Approved</span></td>
              <td class="py-3">{{ $review->created_at->format('M d, Y') }}</td>
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
          @empty
            <tr>
              <td colspan="8" class="text-center py-4">
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
