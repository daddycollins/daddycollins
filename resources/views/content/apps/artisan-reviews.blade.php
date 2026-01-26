@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Reviews - ArtisanConnect')

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
              <p class="text-muted small mb-1">Average Rating</p>
              <h3 class="mb-2">{{ $averageRating }} <small class="text-warning"><i
                    class="icon-base ri ri-star-fill"></i></small></h3>
              <p class="mb-0"><span
                  class="badge {{ $averageRating >= 4.5 ? 'bg-label-success' : ($averageRating >= 3 ? 'bg-label-warning' : 'bg-label-danger') }}">{{ $averageRating >= 4.5 ? 'Excellent' : ($averageRating >= 3 ? 'Good' : 'Needs Improvement') }}</span>
              </p>
            </div>
            <div class="avatar avatar-lg bg-label-success">
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
              <p class="text-muted small mb-1">Total Reviews</p>
              <h3 class="mb-2">{{ $totalReviews }}</h3>
              <p class="mb-0"><span class="badge bg-label-primary"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>+{{ $thisMonthReviews }} this month</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-primary">
              <div class="avatar-initial"><i class="icon-base ri ri-message-2-line"></i></div>
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
              <p class="text-muted small mb-1">5-Star Reviews</p>
              <h3 class="mb-2">{{ $fiveStarReviews }} <small class="text-warning">({{ $fiveStarPercentage }}%)</small>
              </h3>
              <p class="mb-0"><span class="badge bg-label-warning">Outstanding</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-warning">
              <div class="avatar-initial"><i class="icon-base ri ri-medal-line"></i></div>
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
                  class="badge {{ $responseRate >= 90 ? 'bg-label-info' : ($responseRate >= 70 ? 'bg-label-warning' : 'bg-label-danger') }}">{{ $responseRate >= 90 ? 'Quick Response' : ($responseRate >= 70 ? 'Good Response' : 'Needs Attention') }}</span>
              </p>
            </div>
            <div class="avatar avatar-lg bg-label-info">
              <div class="avatar-initial"><i class="icon-base ri ri-mail-check-line"></i></div>
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
          <h5 class="card-title m-0"><i class="icon-base ri ri-line-chart-line me-2 text-primary"></i>Reviews Over Time
          </h5>
        </div>
        <div class="card-body">
          <div id="reviewsTimelineChart" style="height: 350px;"></div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0"><i class="icon-base ri ri-pie-chart-line me-2 text-success"></i>Rating Distribution
          </h5>
        </div>
        <div class="card-body">
          <div id="ratingDistributionChart" style="height: 350px;"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Reviews Table -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
      <div class="row g-3 align-items-center">
        <div class="col-md-6">
          <h5 class="card-title m-0"><i class="icon-base ri ri-message-2-line me-2 text-primary"></i>Client Reviews</h5>
        </div>
        <div class="col-md-6 text-end">
          <div class="btn-group" role="group">
            <a href="{{ route('artisan-my-reviews', ['filter' => 'all']) }}"
              class="btn btn-outline-primary btn-sm {{ $currentFilter === 'all' ? 'active' : '' }}">All</a>
            <a href="{{ route('artisan-my-reviews', ['filter' => 'no-response']) }}"
              class="btn btn-outline-primary btn-sm {{ $currentFilter === 'no-response' ? 'active' : '' }}">No
              Response</a>
            <a href="{{ route('artisan-my-reviews', ['filter' => 'positive']) }}"
              class="btn btn-outline-primary btn-sm {{ $currentFilter === 'positive' ? 'active' : '' }}">Positive</a>
          </div>
        </div>
      </div>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>Client</th>
              <th>Service</th>
              <th>Rating</th>
              <th>Review</th>
              <th>Date</th>
              <th>Response</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($reviews as $review)
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2">
                      <img src="{{ asset('assets/img/avatars/' . (($loop->index % 4) + 1) . '.png') }}" alt="Client"
                        class="rounded-circle" />
                    </div>
                    <div>
                      <h6 class="mb-0 fw-medium">{{ $review->client->name }}</h6>
                    </div>
                  </div>
                </td>
                <td><span class="badge bg-label-primary">{{ $review->order->service_name ?? 'Service' }}</span></td>
                <td>
                  <div class="text-warning">
                    @for ($i = 1; $i <= 5; $i++)
                      @if ($i <= $review->rating)
                        <i class="icon-base ri ri-star-fill"></i>
                      @else
                        <i class="icon-base ri ri-star-line"></i>
                      @endif
                    @endfor
                    <strong class="ms-2">{{ $review->rating }}.0</strong>
                  </div>
                </td>
                <td>
                  <small>"{{ Str::limit($review->comment, 50) }}"</small>
                </td>
                <td>{{ $review->created_at->format('d M Y') }}</td>
                <td><span
                    class="badge {{ $review->has_response ? 'bg-label-success' : 'bg-label-warning' }}">{{ $review->has_response ? 'Responded' : 'No Response' }}</span>
                </td>
                <td>
                  <div class="dropdown">
                    <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                      data-bs-toggle="dropdown">
                      <i class="icon-base ri ri-more-2-fill"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item view-review-btn" href="javascript:void(0);"
                        data-review-id="{{ $review->id }}" data-client-name="{{ $review->client->name }}"
                        data-service-name="{{ $review->order->service_name ?? 'Service' }}"
                        data-rating="{{ $review->rating }}" data-comment="{{ $review->comment }}"
                        data-date="{{ $review->created_at->format('d M Y') }}"
                        data-response="{{ $review->response_comment }}"
                        data-response-date="{{ $review->response_date?->format('d M Y') }}" data-bs-toggle="modal"
                        data-bs-target="#viewReviewModal">
                        <i class="icon-base ri ri-eye-line me-2"></i>View Full
                      </a>
                      @if ($review->has_response)
                        <a class="dropdown-item" href="javascript:void(0);">
                          <i class="icon-base ri ri-message-reply-line me-2"></i>View Reply
                        </a>
                      @else
                        <a class="dropdown-item reply-review-btn" href="javascript:void(0);"
                          data-review-id="{{ $review->id }}" data-client-name="{{ $review->client->name }}"
                          data-service-name="{{ $review->order->service_name ?? 'Service' }}"
                          data-rating="{{ $review->rating }}" data-comment="{{ $review->comment }}"
                          data-bs-toggle="modal" data-bs-target="#replyReviewModal">
                          <i class="icon-base ri ri-message-reply-line me-2"></i>Reply
                        </a>
                      @endif
                    </div>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center py-4">
                  <p class="text-muted mb-2">No reviews found.</p>
                  <p class="text-muted small">Encourage your clients to leave reviews by providing excellent service!</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- View Review Modal -->
  <div class="modal fade" id="viewReviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-eye-line me-2 text-primary"></i>Full Review</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="card border-0 bg-light mb-4">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-md me-3">
                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Client" class="rounded-circle" />
                  </div>
                  <div>
                    <h6 class="mb-0 fw-medium" id="viewClientName">Client Name</h6>
                    <small class="text-muted"><span id="viewServiceName">Service</span> • <span
                        id="viewDate">Date</span></small>
                  </div>
                </div>
                <div class="text-warning" id="viewRating">
                  <!-- Stars will be populated by JS -->
                </div>
              </div>
              <p class="mb-0 lh-lg" id="viewComment">"Review comment will appear here"</p>
            </div>
          </div>

          <div id="responseSection" style="display: none;">
            <h6 class="mb-3">Your Response:</h6>
            <div class="alert alert-success" role="alert">
              <small><strong>Replied on <span id="viewResponseDate">Date</span>:</strong> "<span
                  id="viewResponse">Response text</span>"</small>
            </div>
          </div>
          <div id="noResponseSection">
            <p class="text-muted text-center">No response to this review yet.</p>
          </div>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Reply Review Modal -->
  <!-- Reply Review Modal -->
  <div class="modal fade" id="replyReviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-message-reply-line me-2 text-primary"></i>Reply to Review
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="card border-0 bg-light mb-4">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-md me-3">
                    <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Client" class="rounded-circle" />
                  </div>
                  <div>
                    <h6 class="mb-0 fw-medium" id="replyClientName">Client Name</h6>
                    <small class="text-muted"><span id="replyServiceName">Service</span> • <span
                        id="replyDate">Date</span></small>
                  </div>
                </div>
              </div>
              <div class="text-warning mb-3" id="replyRating">
                <!-- Stars will be populated by JS -->
              </div>
              <p class="mb-0 text-muted" id="replyComment">"Review comment will appear here"</p>
            </div>
          </div>

          <form id="replyForm">
            @csrf
            <input type="hidden" id="replyReviewId" name="review_id" value="">
            <label class="form-label fw-medium mb-3">Your Response</label>
            <textarea class="form-control" name="response_comment" rows="5"
              placeholder="Write a professional and friendly response to the review..." required></textarea>
            <small class="text-muted d-block mt-2">Tip: Thank them for the feedback and address their concerns
              professionally.</small>
          </form>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="submitReplyBtn">
            <i class="icon-base ri ri-send-plane-line me-2"></i>Send Reply
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Generate star rating HTML
    function generateStars(rating) {
      let html = '';
      for (let i = 1; i <= 5; i++) {
        if (i <= rating) {
          html += '<i class="icon-base ri ri-star-fill"></i>';
        } else {
          html += '<i class="icon-base ri ri-star-line"></i>';
        }
      }
      html += '<strong class="ms-2">' + rating + '.0</strong>';
      return html;
    }

    // View Review Modal - Populate with data
    document.querySelectorAll('.view-review-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const clientName = this.getAttribute('data-client-name');
        const serviceName = this.getAttribute('data-service-name');
        const rating = this.getAttribute('data-rating');
        const comment = this.getAttribute('data-comment');
        const date = this.getAttribute('data-date');
        const response = this.getAttribute('data-response');
        const responseDate = this.getAttribute('data-response-date');

        // Populate modal fields
        document.getElementById('viewClientName').textContent = clientName;
        document.getElementById('viewServiceName').textContent = serviceName;
        document.getElementById('viewDate').textContent = date;
        document.getElementById('viewRating').innerHTML = generateStars(parseInt(rating));
        document.getElementById('viewComment').textContent = '"' + comment + '"';

        // Show/hide response section
        if (response) {
          document.getElementById('responseSection').style.display = 'block';
          document.getElementById('noResponseSection').style.display = 'none';
          document.getElementById('viewResponse').textContent = response;
          document.getElementById('viewResponseDate').textContent = responseDate;
        } else {
          document.getElementById('responseSection').style.display = 'none';
          document.getElementById('noResponseSection').style.display = 'block';
        }
      });
    });

    // Reply Review Modal - Populate with data
    document.querySelectorAll('.reply-review-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const reviewId = this.getAttribute('data-review-id');
        const clientName = this.getAttribute('data-client-name');
        const serviceName = this.getAttribute('data-service-name');
        const rating = this.getAttribute('data-rating');
        const comment = this.getAttribute('data-comment');
        const date = this.getAttribute('data-date');

        // Populate modal fields
        document.getElementById('replyReviewId').value = reviewId;
        document.getElementById('replyClientName').textContent = clientName;
        document.getElementById('replyServiceName').textContent = serviceName;
        document.getElementById('replyDate').textContent = date;
        document.getElementById('replyRating').innerHTML = generateStars(parseInt(rating));
        document.getElementById('replyComment').textContent = '"' + comment + '"';
      });
    });

    // Submit reply form
    document.getElementById('submitReplyBtn').addEventListener('click', function(e) {
      e.preventDefault();
      const reviewId = document.getElementById('replyReviewId').value;
      const form = document.getElementById('replyForm');
      const formData = new FormData(form);

      fetch(`/artisan/reviews/${reviewId}/reply`, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      }).then(response => {
        if (response.ok) {
          location.reload();
        } else {
          alert('Failed to submit reply. Please try again.');
        }
      }).catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
      });
    });

    // Reviews Timeline Chart
    const reviewsTimelineChart = new ApexCharts(document.querySelector("#reviewsTimelineChart"), {
      series: [{
        name: "Reviews",
        data: @json($reviewTimeline)
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
          text: "Number of Reviews"
        }
      },
      tooltip: {
        shared: true,
        intersect: false
      }
    });
    reviewsTimelineChart.render();

    // Rating Distribution Chart
    const ratingDistributionChart = new ApexCharts(document.querySelector("#ratingDistributionChart"), {
      series: [{{ $ratingDistribution[5] }}, {{ $ratingDistribution[4] }}, {{ $ratingDistribution[3] }},
        {{ $ratingDistribution[2] }}, {{ $ratingDistribution[1] }}
      ],
      chart: {
        type: "donut",
        height: 350
      },
      labels: ["5 Stars", "4 Stars", "3 Stars", "2 Stars", "1 Star"],
      colors: ["#ffc107", "#28a745", "#667eea", "#ffc107", "#dc3545"],
      legend: {
        position: "bottom"
      }
    });
    ratingDistributionChart.render();
  </script>
@endsection
