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
              <h3 class="mb-2">4.8 <small class="text-warning"><i class="icon-base ri ri-star-fill"></i></small></h3>
              <p class="mb-0"><span class="badge bg-label-success">Excellent</span></p>
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
              <h3 class="mb-2">267</h3>
              <p class="mb-0"><span class="badge bg-label-primary"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>+32 this month</span></p>
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
              <h3 class="mb-2">189 <small class="text-warning">(71%)</small></h3>
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
              <h3 class="mb-2">95%</h3>
              <p class="mb-0"><span class="badge bg-label-info">Quick Response</span></p>
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
            <input type="radio" class="btn-check" name="reviewFilter" id="allReviews" value="all" checked />
            <label class="btn btn-outline-primary btn-sm" for="allReviews">All</label>
            <input type="radio" class="btn-check" name="reviewFilter" id="noResponse" value="no-response" />
            <label class="btn btn-outline-primary btn-sm" for="noResponse">No Response</label>
            <input type="radio" class="btn-check" name="reviewFilter" id="positive" value="positive" />
            <label class="btn btn-outline-primary btn-sm" for="positive">Positive</label>
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
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-sm me-2">
                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Client" class="rounded-circle" />
                  </div>
                  <div>
                    <h6 class="mb-0 fw-medium">Sarah Mwangi</h6>
                  </div>
                </div>
              </td>
              <td><span class="badge bg-label-primary">Carpentry Work</span></td>
              <td>
                <div class="text-warning">
                  <i class="icon-base ri ri-star-fill"></i>
                  <i class="icon-base ri ri-star-fill"></i>
                  <i class="icon-base ri ri-star-fill"></i>
                  <i class="icon-base ri ri-star-fill"></i>
                  <i class="icon-base ri ri-star-fill"></i>
                  <strong class="ms-2">5.0</strong>
                </div>
              </td>
              <td>
                <small>"Excellent workmanship! Very professional and on time."</small>
              </td>
              <td>22 Jan 2026</td>
              <td><span class="badge bg-label-success">Responded</span></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                    data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-fill"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                      data-bs-target="#viewReviewModal">
                      <i class="icon-base ri ri-eye-line me-2"></i>View Full
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-message-reply-line me-2"></i>View Reply
                    </a>
                  </div>
                </div>
              </td>
            </tr>

            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-sm me-2">
                    <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Client" class="rounded-circle" />
                  </div>
                  <div>
                    <h6 class="mb-0 fw-medium">James Musarurwa</h6>
                  </div>
                </div>
              </td>
              <td><span class="badge bg-label-warning">Beadwork Design</span></td>
              <td>
                <div class="text-warning">
                  <i class="icon-base ri ri-star-fill"></i>
                  <i class="icon-base ri ri-star-fill"></i>
                  <i class="icon-base ri ri-star-fill"></i>
                  <i class="icon-base ri ri-star-line"></i>
                  <i class="icon-base ri ri-star-line"></i>
                  <strong class="ms-2">4.0</strong>
                </div>
              </td>
              <td>
                <small>"Good quality, but took longer than expected."</small>
              </td>
              <td>20 Jan 2026</td>
              <td><span class="badge bg-label-warning">No Response</span></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                    data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-fill"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                      data-bs-target="#replyReviewModal">
                      <i class="icon-base ri ri-message-reply-line me-2"></i>Reply
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-eye-line me-2"></i>View Full
                    </a>
                  </div>
                </div>
              </td>
            </tr>

            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-sm me-2">
                    <img src="{{ asset('assets/img/avatars/3.png') }}" alt="Client" class="rounded-circle" />
                  </div>
                  <div>
                    <h6 class="mb-0 fw-medium">Zinhle Dube</h6>
                  </div>
                </div>
              </td>
              <td><span class="badge bg-label-success">Painting Service</span></td>
              <td>
                <div class="text-warning">
                  <i class="icon-base ri ri-star-fill"></i>
                  <i class="icon-base ri ri-star-fill"></i>
                  <i class="icon-base ri ri-star-fill"></i>
                  <i class="icon-base ri ri-star-fill"></i>
                  <i class="icon-base ri ri-star-fill"></i>
                  <strong class="ms-2">5.0</strong>
                </div>
              </td>
              <td>
                <small>"Best painter in the city! Highly recommended!"</small>
              </td>
              <td>19 Jan 2026</td>
              <td><span class="badge bg-label-success">Responded</span></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                    data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-fill"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-eye-line me-2"></i>View Full
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-message-reply-line me-2"></i>View Reply
                    </a>
                  </div>
                </div>
              </td>
            </tr>

            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-sm me-2">
                    <img src="{{ asset('assets/img/avatars/4.png') }}" alt="Client" class="rounded-circle" />
                  </div>
                  <div>
                    <h6 class="mb-0 fw-medium">Lindiwe Khumalo</h6>
                  </div>
                </div>
              </td>
              <td><span class="badge bg-label-info">Custom Furniture</span></td>
              <td>
                <div class="text-warning">
                  <i class="icon-base ri ri-star-fill"></i>
                  <i class="icon-base ri ri-star-fill"></i>
                  <i class="icon-base ri ri-star-fill"></i>
                  <i class="icon-base ri ri-star-line"></i>
                  <i class="icon-base ri ri-star-line"></i>
                  <strong class="ms-2">3.0</strong>
                </div>
              </td>
              <td>
                <small>"Average work. Could have paid more attention to detail."</small>
              </td>
              <td>18 Jan 2026</td>
              <td><span class="badge bg-label-warning">No Response</span></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                    data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-fill"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                      data-bs-target="#replyReviewModal">
                      <i class="icon-base ri ri-message-reply-line me-2"></i>Reply
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);">
                      <i class="icon-base ri ri-eye-line me-2"></i>View Full
                    </a>
                  </div>
                </div>
              </td>
            </tr>
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
                    <h6 class="mb-0 fw-medium">Sarah Mwangi</h6>
                    <small class="text-muted">Carpentry Work • 22 Jan 2026</small>
                  </div>
                </div>
                <div class="text-warning">
                  <i class="icon-base ri ri-star-fill"></i>
                  <i class="icon-base ri ri-star-fill"></i>
                  <i class="icon-base ri ri-star-fill"></i>
                  <i class="icon-base ri ri-star-fill"></i>
                  <i class="icon-base ri ri-star-fill"></i>
                  <strong class="ms-2">5.0</strong>
                </div>
              </div>
              <p class="mb-0 lh-lg">"Excellent workmanship! Very professional and on time. John delivered exactly what I
                wanted. The quality of the furniture is outstanding and I would definitely recommend him to friends and
                family. He was very communicative throughout the process and handled all my concerns immediately."</p>
            </div>
          </div>

          <h6 class="mb-3">Your Response:</h6>
          <div class="alert alert-success" role="alert">
            <small><strong>Replied on 23 Jan 2026:</strong> "Thank you so much Sarah! It was a pleasure working with you.
              I'm glad you're satisfied with the furniture. Looking forward to our next project!"</small>
          </div>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

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
                    <h6 class="mb-0 fw-medium">James Musarurwa</h6>
                    <small class="text-muted">Beadwork Design • 20 Jan 2026</small>
                  </div>
                </div>
              </div>
              <div class="text-warning mb-3">
                <i class="icon-base ri ri-star-fill"></i>
                <i class="icon-base ri ri-star-fill"></i>
                <i class="icon-base ri ri-star-fill"></i>
                <i class="icon-base ri ri-star-line"></i>
                <i class="icon-base ri ri-star-line"></i>
                <strong class="ms-2">4.0</strong>
              </div>
              <p class="mb-0 text-muted">"Good quality, but took longer than expected."</p>
            </div>
          </div>

          <form id="replyForm">
            <label class="form-label fw-medium mb-3">Your Response</label>
            <textarea class="form-control" rows="5"
              placeholder="Write a professional and friendly response to the review..." required></textarea>
            <small class="text-muted d-block mt-2">Tip: Thank them for the feedback and address their concerns
              professionally.</small>
          </form>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" form="replyForm">
            <i class="icon-base ri ri-send-plane-line me-2"></i>Send Reply
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Reviews Timeline Chart
    const reviewsTimelineChart = new ApexCharts(document.querySelector("#reviewsTimelineChart"), {
      series: [{
        name: "Reviews",
        data: [12, 18, 15, 22, 28, 32, 25]
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
      series: [189, 56, 15, 5, 2],
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
