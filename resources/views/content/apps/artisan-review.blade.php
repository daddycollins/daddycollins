@extends('layouts/layoutMaster')

@section('title', 'My Reviews - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/apex-charts/apexcharts.js'])
@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Rating Distribution Chart with dynamic data
      const chartData = [{{ $fiveStarCount }}, {{ $fourStarCount }}, {{ $threeStarCount }}, {{ $twoStarCount }},
        {{ $oneStarCount }}
      ];
      const hasData = chartData.some(val => val > 0);

      if (hasData) {
        const ratingDistributionChart = new ApexCharts(document.querySelector("#ratingDistributionChart"), {
          series: chartData,
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
          },
          plotOptions: {
            pie: {
              donut: {
                labels: {
                  show: true,
                  total: {
                    show: true,
                    label: 'Total',
                    formatter: function(w) {
                      return w.globals.seriesTotals.reduce((a, b) => a + b, 0) + ' Reviews'
                    }
                  }
                }
              }
            }
          }
        });
        ratingDistributionChart.render();
      } else {
        document.querySelector("#ratingDistributionChart").innerHTML =
          '<div class="text-center py-5 text-muted"><i class="ri-pie-chart-line" style="font-size: 48px;"></i><p class="mt-2">No review data yet</p></div>';
      }

      // Star Rating Input Handler for Create Review Modal
      const ratingStars = document.querySelectorAll('#ratingStars .rating-input i');
      const ratingInput = document.getElementById('ratingInput');

      ratingStars.forEach((star) => {
        star.addEventListener('click', function() {
          const rating = parseInt(this.getAttribute('data-rating'));
          ratingInput.value = rating;

          ratingStars.forEach((s, i) => {
            if (i < rating) {
              s.classList.remove('ri-star-line', 'text-muted');
              s.classList.add('ri-star-fill', 'text-warning');
            } else {
              s.classList.add('ri-star-line', 'text-muted');
              s.classList.remove('ri-star-fill', 'text-warning');
            }
          });
        });

        // Hover effect
        star.addEventListener('mouseenter', function() {
          const rating = parseInt(this.getAttribute('data-rating'));
          ratingStars.forEach((s, i) => {
            if (i < rating) {
              s.classList.add('text-warning');
            }
          });
        });

        star.addEventListener('mouseleave', function() {
          const currentRating = parseInt(ratingInput.value) || 0;
          ratingStars.forEach((s, i) => {
            if (i >= currentRating) {
              s.classList.remove('text-warning');
            }
          });
        });
      });

      // Order select change handler
      const orderSelect = document.getElementById('orderSelect');
      if (orderSelect) {
        orderSelect.addEventListener('change', function() {
          const selectedOption = this.options[this.selectedIndex];
          const artisanInfo = document.getElementById('selectedArtisanInfo');
          const artisanName = document.getElementById('selectedArtisanName');
          const artisanCategory = document.getElementById('selectedArtisanCategory');

          if (this.value) {
            artisanName.textContent = selectedOption.dataset.artisan;
            artisanCategory.textContent = selectedOption.dataset.category;
            artisanInfo.classList.remove('d-none');
          } else {
            artisanInfo.classList.add('d-none');
          }
        });
      }

      // Reset modal on close
      const createReviewModal = document.getElementById('createReviewModal');
      if (createReviewModal) {
        createReviewModal.addEventListener('hidden.bs.modal', function() {
          document.getElementById('createReviewForm').reset();
          document.getElementById('selectedArtisanInfo').classList.add('d-none');
          document.getElementById('selectOrderDiv').classList.remove('d-none');
          ratingStars.forEach((s) => {
            s.classList.add('ri-star-line', 'text-muted');
            s.classList.remove('ri-star-fill', 'text-warning');
          });
          ratingInput.value = '';
        });
      }
    });

    // Function to pre-select order from pending reviews table
    function setReviewOrder(orderId, artisanName, artisanCategory) {
      const orderSelect = document.getElementById('orderSelect');
      const artisanInfo = document.getElementById('selectedArtisanInfo');
      const artisanNameEl = document.getElementById('selectedArtisanName');
      const artisanCategoryEl = document.getElementById('selectedArtisanCategory');

      if (orderSelect) {
        orderSelect.value = orderId;
        artisanNameEl.textContent = artisanName;
        artisanCategoryEl.textContent = artisanCategory;
        artisanInfo.classList.remove('d-none');
      }
    }
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
              <h4 class="mb-2">{{ $totalReviews }}</h4>
              <p class="mb-0 text-success"><i class="icon-base ri ri-arrow-up-s-line"></i> +{{ $reviewsThisMonth }} this
                month</p>
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
                <h4 class="mb-0">{{ $averageRating }}</h4>
                @php
                  $fullStars = floor($averageRating);
                  $hasHalfStar = $averageRating - $fullStars >= 0.5;
                  $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                @endphp
                <div class="text-warning small">
                  @for ($i = 0; $i < $fullStars; $i++)
                    <i class="icon-base ri ri-star-fill icon-16px"></i>
                  @endfor
                  @if ($hasHalfStar)
                    <i class="icon-base ri ri-star-half-fill icon-16px"></i>
                  @endif
                  @for ($i = 0; $i < $emptyStars; $i++)
                    <i class="icon-base ri ri-star-line icon-16px"></i>
                  @endfor
                </div>
              </div>
              <p
                class="mb-0 {{ $averageRating >= 4 ? 'text-success' : ($averageRating >= 3 ? 'text-warning' : 'text-danger') }}">
                {{ $averageRating >= 4.5 ? 'Excellent rating' : ($averageRating >= 4 ? 'Great rating' : ($averageRating >= 3 ? 'Good rating' : 'Needs improvement')) }}
              </p>
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
              <h4 class="mb-2">{{ $fiveStarCount }}</h4>
              <p class="mb-0 text-info">{{ $fiveStarPercent }}% of all reviews</p>
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
              <h4 class="mb-2">{{ $pendingReviewsCount }}</h4>
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
                  <span class="badge bg-label-success">{{ $fiveStarCount }}</span>
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
                  <span class="badge bg-label-info">{{ $fourStarCount }}</span>
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
                  <span class="badge bg-label-warning">{{ $threeStarCount }}</span>
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
                  <span class="badge bg-label-danger">{{ $twoStarCount }}</span>
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
                  <span class="badge bg-label-danger">{{ $oneStarCount }}</span>
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
              <span class="badge bg-label-primary">{{ $totalReviews }} Reviews</span>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="review-list">
            @forelse($reviews as $review)
              @php
                $artisan = $review->artisan;
                $artisanName =
                    $artisan->first_name && $artisan->last_name
                        ? $artisan->first_name . ' ' . $artisan->last_name
                        : $artisan->user->name ?? ($artisan->business_name ?? 'Artisan');
                $rating = $review->rating;
                $ratingBadgeClass =
                    $rating >= 5
                        ? 'bg-label-success'
                        : ($rating >= 4
                            ? 'bg-label-info'
                            : ($rating >= 3
                                ? 'bg-label-warning'
                                : 'bg-label-danger'));
              @endphp
              <!-- Dynamic Review Item -->
              <div class="review-item {{ !$loop->last ? 'border-bottom pb-4 mb-4' : '' }}">
                <div class="d-flex justify-content-between align-items-start mb-3">
                  <div class="d-flex align-items-start gap-3 flex-grow-1">
                    <img
                      src="{{ $artisan->profile_photo_path ? asset('storage/' . $artisan->profile_photo_path) : asset('assets/img/avatars/1.png') }}"
                      alt="{{ $artisanName }}" class="rounded-circle" width="48" height="48" />
                    <div class="flex-grow-1">
                      <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                          <h6 class="mb-1">{{ $artisanName }}</h6>
                          <p class="text-muted small mb-0">{{ $artisan->category ?? 'General Services' }}</p>
                        </div>
                        <div class="text-end">
                          <div class="text-warning small mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                              @if ($i <= $rating)
                                <i class="icon-base ri ri-star-fill icon-14px"></i>
                              @else
                                <i class="icon-base ri ri-star-line icon-14px"></i>
                              @endif
                            @endfor
                          </div>
                          <span class="badge {{ $ratingBadgeClass }}">{{ $rating }}/5 Stars</span>
                        </div>
                      </div>
                      <p class="mb-3">
                        "{{ $review->comment ?? 'No comment provided.' }}"
                      </p>

                      {{-- Show artisan response if exists --}}
                      @if ($review->has_response && $review->response_comment)
                        <div class="bg-light p-3 rounded mb-3">
                          <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="icon-base ri ri-reply-line text-primary"></i>
                            <strong class="small">Artisan Response:</strong>
                            <small
                              class="text-muted">{{ $review->response_date ? \Carbon\Carbon::parse($review->response_date)->format('M d, Y') : '' }}</small>
                          </div>
                          <p class="mb-0 small text-muted">"{{ $review->response_comment }}"</p>
                        </div>
                      @endif
                    </div>
                  </div>
                  <div class="dropdown ms-3">
                    <button class="btn btn-icon btn-text-secondary rounded-pill p-0" type="button"
                      data-bs-toggle="dropdown">
                      <i class="icon-base ri ri-more-2-line"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                      <a class="dropdown-item" href="{{ route('user-view-review', $review->id) }}">
                        <i class="icon-base ri ri-eye-line me-2"></i>View Details
                      </a>
                      <a class="dropdown-item" href="{{ route('user-edit-review', $review->id) }}">
                        <i class="icon-base ri ri-edit-line me-2"></i>Edit Review
                      </a>
                      <form action="{{ route('user-delete-review', $review->id) }}" method="POST"
                        style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger"
                          onclick="return confirm('Are you sure you want to delete this review?');">
                          <i class="icon-base ri ri-delete-bin-line me-2"></i>Delete Review
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <small class="text-muted">Reviewed on {{ $review->created_at->format('M d, Y') }}</small>
                  <span class="badge bg-label-success">Published</span>
                </div>
              </div>
            @empty
              <!-- Empty State -->
              <div class="text-center py-5">
                <i class="icon-base ri ri-chat-3-line icon-64px text-muted mb-3" style="font-size: 64px;"></i>
                <h5 class="text-muted">No reviews yet</h5>
                <p class="text-muted mb-4">You haven't submitted any reviews yet. Complete an order to leave a review!
                </p>
                @if ($pendingReviewsCount > 0)
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createReviewModal">
                    <i class="icon-base ri ri-add-line me-1"></i> Write Your First Review
                  </button>
                @endif
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pending Reviews Section -->
  @if ($pendingReviewOrders->count() > 0)
    <div class="row g-6 mb-6">
      <div class="col-12">
        <div class="card border-warning">
          <div class="card-header bg-label-warning">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="card-title mb-0"><i class="icon-base ri ri-time-line me-2"></i>Orders Awaiting Review</h5>
              <span class="badge bg-warning">{{ $pendingReviewsCount }} Pending</span>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Artisan</th>
                    <th>Service</th>
                    <th>Order Date</th>
                    <th>Amount</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($pendingReviewOrders as $order)
                    @php
                      $artisan = $order->artisan;
                      $artisanName =
                          $artisan->first_name && $artisan->last_name
                              ? $artisan->first_name . ' ' . $artisan->last_name
                              : $artisan->user->name ?? ($artisan->business_name ?? 'Artisan');
                      $serviceName = $order->items->first()?->artisanService?->service_name ?? 'Service';
                    @endphp
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <img
                            src="{{ $artisan->profile_photo_path ? asset('storage/' . $artisan->profile_photo_path) : asset('assets/img/avatars/1.png') }}"
                            alt="{{ $artisanName }}" class="rounded-circle" width="32" height="32" />
                          <div>
                            <strong>{{ $artisanName }}</strong>
                            <small class="text-muted d-block">{{ $artisan->category ?? 'General' }}</small>
                          </div>
                        </div>
                      </td>
                      <td>{{ $serviceName }}</td>
                      <td>{{ $order->created_at->format('M d, Y') }}</td>
                      <td>${{ number_format($order->total_amount, 2) }}</td>
                      <td>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                          data-bs-target="#createReviewModal"
                          onclick="setReviewOrder({{ $order->id }}, '{{ $artisanName }}', '{{ $artisan->category ?? 'General' }}')">
                          <i class="icon-base ri ri-star-line me-1"></i> Review
                        </button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif

  <!-- Create Review Modal -->
  <div class="modal fade" id="createReviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create New Review</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('user-store-review') }}" method="POST" id="createReviewForm">
          @csrf
          <div class="modal-body">
            <!-- Selected Artisan Info (shown when pre-selected) -->
            <div class="mb-4 p-3 bg-light rounded d-none" id="selectedArtisanInfo">
              <div class="d-flex align-items-center gap-3">
                <div class="avatar bg-label-primary">
                  <div class="avatar-initial rounded">
                    <i class="icon-base ri ri-user-line icon-24px"></i>
                  </div>
                </div>
                <div>
                  <h6 class="mb-0" id="selectedArtisanName">Artisan Name</h6>
                  <p class="text-muted small mb-0" id="selectedArtisanCategory">Category</p>
                </div>
              </div>
            </div>

            <!-- Select Order (for pending reviews) -->
            <div class="mb-4" id="selectOrderDiv">
              <label class="form-label">Select Completed Order to Review</label>
              <select class="form-select" name="order_id" id="orderSelect" required>
                <option value="">Choose an order...</option>
                @forelse ($pendingReviewOrders as $order)
                  @php
                    $artisan = $order->artisan;
                    $artisanName =
                        $artisan->first_name && $artisan->last_name
                            ? $artisan->first_name . ' ' . $artisan->last_name
                            : $artisan->user->name ?? ($artisan->business_name ?? 'Artisan');
                    $serviceName =
                        $order->items->first()?->artisanService?->service_name ??
                        ($order->items->first()?->artisanGood?->good_name ?? 'Service');
                  @endphp
                  <option value="{{ $order->id }}" data-artisan="{{ $artisanName }}"
                    data-category="{{ $artisan->category ?? 'General' }}">
                    {{ $artisanName }} - {{ $serviceName }} ({{ $order->created_at->format('M d, Y') }})
                  </option>
                @empty
                  <option value="" disabled>No completed orders available</option>
                @endforelse
              </select>
              @if ($pendingReviewOrders->count() == 0)
                <small class="text-muted">No completed orders available for review.</small>
              @endif
            </div>

            <!-- Star Rating -->
            <div class="mb-4">
              <label class="form-label">Your Rating <span class="text-danger">*</span></label>
              <div class="d-flex gap-3" id="ratingStars">
                @for ($i = 1; $i <= 5; $i++)
                  <div class="rating-input">
                    <i class="icon-base ri ri-star-line icon-32px text-muted cursor-pointer"
                      data-rating="{{ $i }}"></i>
                  </div>
                @endfor
              </div>
              <input type="hidden" name="rating" id="ratingInput" required>
            </div>

            <!-- Review Text -->
            <div class="mb-4">
              <label class="form-label">Your Review <span class="text-danger">*</span></label>
              <textarea class="form-control" name="comment" rows="5"
                placeholder="Share your experience with this artisan..." required></textarea>
              <small class="text-muted">Minimum 10 characters</small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" {{ $pendingReviewOrders->count() == 0 ? 'disabled' : '' }}>
              <i class="icon-base ri ri-send-plane-line me-1"></i> Submit Review
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Custom Script for Charts and Interactions -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Rating Distribution Chart with dynamic data
      const chartData = [{{ $fiveStarCount }}, {{ $fourStarCount }}, {{ $threeStarCount }}, {{ $twoStarCount }},
        {{ $oneStarCount }}
      ];
      const hasData = chartData.some(val => val > 0);

      if (hasData) {
        const ratingDistributionChart = new ApexCharts(document.querySelector("#ratingDistributionChart"), {
          series: chartData,
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
          },
          plotOptions: {
            pie: {
              donut: {
                labels: {
                  show: true,
                  total: {
                    show: true,
                    label: 'Total',
                    formatter: function(w) {
                      return w.globals.seriesTotals.reduce((a, b) => a + b, 0) + ' Reviews'
                    }
                  }
                }
              }
            }
          }
        });
        ratingDistributionChart.render();
      } else {
        document.querySelector("#ratingDistributionChart").innerHTML =
          '<div class="text-center py-5 text-muted"><i class="ri-pie-chart-line" style="font-size: 48px;"></i><p class="mt-2">No review data yet</p></div>';
      }

      // Star Rating Input Handler for Create Review Modal
      const ratingStars = document.querySelectorAll('#ratingStars .rating-input i');
      const ratingInput = document.getElementById('ratingInput');

      ratingStars.forEach((star) => {
        star.addEventListener('click', function() {
          const rating = parseInt(this.getAttribute('data-rating'));
          ratingInput.value = rating;

          ratingStars.forEach((s, i) => {
            if (i < rating) {
              s.classList.remove('ri-star-line', 'text-muted');
              s.classList.add('ri-star-fill', 'text-warning');
            } else {
              s.classList.add('ri-star-line', 'text-muted');
              s.classList.remove('ri-star-fill', 'text-warning');
            }
          });
        });

        // Hover effect
        star.addEventListener('mouseenter', function() {
          const rating = parseInt(this.getAttribute('data-rating'));
          ratingStars.forEach((s, i) => {
            if (i < rating) {
              s.classList.add('text-warning');
            }
          });
        });

        star.addEventListener('mouseleave', function() {
          const currentRating = parseInt(ratingInput.value) || 0;
          ratingStars.forEach((s, i) => {
            if (i >= currentRating) {
              s.classList.remove('text-warning');
            }
          });
        });
      });

      // Order select change handler
      const orderSelect = document.getElementById('orderSelect');
      if (orderSelect) {
        orderSelect.addEventListener('change', function() {
          const selectedOption = this.options[this.selectedIndex];
          const artisanInfo = document.getElementById('selectedArtisanInfo');
          const artisanName = document.getElementById('selectedArtisanName');
          const artisanCategory = document.getElementById('selectedArtisanCategory');

          if (this.value) {
            artisanName.textContent = selectedOption.dataset.artisan;
            artisanCategory.textContent = selectedOption.dataset.category;
            artisanInfo.classList.remove('d-none');
          } else {
            artisanInfo.classList.add('d-none');
          }
        });
      }

      // Reset modal on close
      const createReviewModal = document.getElementById('createReviewModal');
      if (createReviewModal) {
        createReviewModal.addEventListener('hidden.bs.modal', function() {
          document.getElementById('createReviewForm').reset();
          document.getElementById('selectedArtisanInfo').classList.add('d-none');
          document.getElementById('selectOrderDiv').classList.remove('d-none');
          ratingStars.forEach((s) => {
            s.classList.add('ri-star-line', 'text-muted');
            s.classList.remove('ri-star-fill', 'text-warning');
          });
          ratingInput.value = '';
        });
      }
    });

    // Function to pre-select order from pending reviews table
    function setReviewOrder(orderId, artisanName, artisanCategory) {
      const orderSelect = document.getElementById('orderSelect');
      const artisanInfo = document.getElementById('selectedArtisanInfo');
      const artisanNameEl = document.getElementById('selectedArtisanName');
      const artisanCategoryEl = document.getElementById('selectedArtisanCategory');

      if (orderSelect) {
        orderSelect.value = orderId;
        artisanNameEl.textContent = artisanName;
        artisanCategoryEl.textContent = artisanCategory;
        artisanInfo.classList.remove('d-none');
      }
    }
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
