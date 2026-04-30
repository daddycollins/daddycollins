@extends('layouts/layoutMaster')

@section('title', $artisan->user->name . ' - Artisan Profile')

@section('vendor-style')
  @vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('page-style')
  @vite('resources/assets/vendor/scss/pages/cards-statistics.scss')
@endsection

@section('vendor-script')
  @vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('content')
  <!-- Flash Messages -->
  @if (session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <!-- Hero Section -->
  <div class="card mb-4">
    <div class="card-body">
      <div class="row">
        <div class="col-md-8">
          <div class="d-flex align-items-start gap-4">
            <!-- Profile Photo -->
            <div class="flex-shrink-0">
              @if ($artisan->profile_photo_path)
                <img src="{{ asset('storage/' . $artisan->profile_photo_path) }}" alt="{{ $artisan->user->name }}"
                  class="rounded-circle" width="120" height="120" style="object-fit: cover;">
              @else
                <div class="avatar avatar-xl rounded-circle bg-label-primary">
                  <span class="avatar-initial rounded-circle fs-2">{{ substr($artisan->user->name, 0, 1) }}</span>
                </div>
              @endif
            </div>

            <!-- Profile Info -->
            <div class="flex-grow-1">
              <div class="d-flex align-items-center gap-2 mb-2">
                <h3 class="mb-0">{{ $artisan->user->name }}</h3>
                @if ($artisan->verified)
                  <span class="badge bg-label-success"><i class="ri-verified-badge-line me-1"></i>Verified</span>
                @endif
              </div>

              <p class="text-muted mb-2">
                <i class="ri-briefcase-line me-1"></i>{{ $artisan->business_name }} |
                <i class="ri-map-pin-line me-1"></i>{{ $artisan->city }}
              </p>

              <div class="d-flex align-items-center gap-3 mb-3">
                <div>
                  <span class="text-warning fs-5">
                    @for ($i = 0; $i < floor($stats['averageRating']); $i++)
                      &#9733;
                    @endfor
                    @for ($i = floor($stats['averageRating']); $i < 5; $i++)
                      &#9734;
                    @endfor
                  </span>
                  <span class="fw-semibold ms-2">{{ number_format($stats['averageRating'], 1) }}</span>
                  <span class="text-muted">({{ $stats['totalReviews'] }}
                    {{ Illuminate\Support\Str::plural('review', $stats['totalReviews']) }})</span>
                </div>
              </div>

              <div class="d-flex gap-2 flex-wrap">
                <span class="badge bg-label-info">
                  <i class="ri-hammer-line me-1"></i>{{ $artisan->category }}
                </span>
                <span class="badge bg-label-secondary">
                  <i class="ri-time-line me-1"></i>{{ $artisan->years_of_experience }} Years Experience
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-md-4">
          <div class="row g-3">
            <div class="col-6">
              <div class="card border shadow-none">
                <div class="card-body text-center p-3">
                  <h4 class="mb-1 text-primary">{{ $stats['completedOrders'] }}</h4>
                  <small class="text-muted">Jobs Completed</small>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card border shadow-none">
                <div class="card-body text-center p-3">
                  <h4 class="mb-1 text-success">{{ $stats['responseRate'] }}%</h4>
                  <small class="text-muted">Response Rate</small>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card border shadow-none">
                <div class="card-body text-center p-3">
                  <h4 class="mb-1 text-info">{{ $stats['completionRate'] }}%</h4>
                  <small class="text-muted">Completion Rate</small>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card border shadow-none">
                <div class="card-body text-center p-3">
                  <h4 class="mb-1 text-warning">{{ $stats['totalServices'] + $stats['totalProducts'] }}</h4>
                  <small class="text-muted">Offerings</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="row">
    <!-- Left Column - Tabs Content -->
    <div class="col-lg-8 mb-4">
      <!-- Nav Tabs -->
      <ul class="nav nav-pills mb-4" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#services" type="button" role="tab">
            <i class="ri-tools-line me-2"></i>Services ({{ $stats['totalServices'] }})
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab">
            <i class="ri-shopping-bag-line me-2"></i>Products ({{ $stats['totalProducts'] }})
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
            <i class="ri-star-line me-2"></i>Reviews ({{ $stats['totalReviews'] }})
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#about" type="button" role="tab">
            <i class="ri-information-line me-2"></i>About
          </button>
        </li>
      </ul>

      <!-- Tab Content -->
      <div class="tab-content">
        <!-- Services Tab -->
        <div class="tab-pane fade show active" id="services" role="tabpanel">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4">Available Services</h5>
              @forelse($artisan->services as $service)
                <div class="card mb-3 border">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-md-2">
                        @if ($service->image_path)
                          <img src="{{ asset('storage/' . $service->image_path) }}" alt="{{ $service->service_name }}"
                            class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;">
                        @else
                          <div class="bg-label-primary rounded text-center p-3">
                            <i class="ri-tools-line" style="font-size: 2rem;"></i>
                          </div>
                        @endif
                      </div>
                      <div class="col-md-7">
                        <h6 class="mb-1">{{ $service->service_name }}</h6>
                        @if ($service->category)
                          <span class="badge bg-label-info mb-2">{{ $service->category }}</span>
                        @endif
                        <p class="text-muted small mb-0">{{ Illuminate\Support\Str::limit($service->description, 100) }}
                        </p>
                      </div>
                      <div class="col-md-3 text-end">
                        <h5 class="mb-2 text-primary">${{ number_format($service->price_estimate, 2) }}</h5>
                        <form action="{{ route('cart.add') }}" method="POST">
                          @csrf
                          <input type="hidden" name="artisan_id" value="{{ $artisan->id }}">
                          <input type="hidden" name="item_type" value="service">
                          <input type="hidden" name="item_id" value="{{ $service->id }}">
                          <input type="hidden" name="quantity" value="1">
                          <button type="submit" class="btn btn-sm btn-primary w-100">
                            <i class="ri-shopping-cart-line me-1"></i>Add to Cart
                          </button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @empty
                <div class="text-center py-5">
                  <i class="ri-tools-line text-muted" style="font-size: 3rem;"></i>
                  <p class="text-muted mt-2">No services available at the moment</p>
                </div>
              @endforelse
            </div>
          </div>
        </div>

        <!-- Products Tab -->
        <div class="tab-pane fade" id="products" role="tabpanel">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4">Available Products</h5>
              <div class="row g-3">
                @forelse($artisan->goods as $product)
                  <div class="col-md-6">
                    <div class="card border h-100">
                      <div class="card-body">
                        @if ($product->image_path)
                          <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->product_name }}"
                            class="img-fluid rounded mb-3" style="height: 150px; width: 100%; object-fit: cover;">
                        @else
                          <div class="bg-label-warning rounded text-center mb-3 p-4">
                            <i class="ri-shopping-bag-line" style="font-size: 3rem;"></i>
                          </div>
                        @endif
                        <h6 class="mb-2">{{ $product->product_name }}</h6>
                        @if ($product->category)
                          <span class="badge bg-label-secondary mb-2">{{ $product->category }}</span>
                        @endif
                        <p class="text-muted small mb-2">{{ Illuminate\Support\Str::limit($product->description, 80) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                          <h5 class="mb-0 text-success">${{ number_format($product->price, 2) }}</h5>
                          <span class="badge bg-label-info">{{ $product->stock_quantity }} in stock</span>
                        </div>
                        <form action="{{ route('cart.add') }}" method="POST">
                          @csrf
                          <input type="hidden" name="artisan_id" value="{{ $artisan->id }}">
                          <input type="hidden" name="item_type" value="product">
                          <input type="hidden" name="item_id" value="{{ $product->id }}">
                          <div class="input-group mb-2">
                            <input type="number" name="quantity" class="form-control" value="1" min="1"
                              max="{{ $product->stock_quantity }}">
                            <button type="submit" class="btn btn-primary">
                              <i class="ri-shopping-cart-line"></i>
                            </button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                @empty
                  <div class="col-12">
                    <div class="text-center py-5">
                      <i class="ri-shopping-bag-line text-muted" style="font-size: 3rem;"></i>
                      <p class="text-muted mt-2">No products available at the moment</p>
                    </div>
                  </div>
                @endforelse
              </div>
            </div>
          </div>
        </div>

        <!-- Reviews Tab -->
        <div class="tab-pane fade" id="reviews" role="tabpanel">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4">Customer Reviews</h5>

              <!-- Rating Summary -->
              @if ($stats['totalReviews'] > 0)
                <div class="card bg-light border-0 mb-4">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-md-4 text-center border-end">
                        <h1 class="display-4 mb-0">{{ number_format($stats['averageRating'], 1) }}</h1>
                        <div class="text-warning fs-5">
                          @for ($i = 0; $i < floor($stats['averageRating']); $i++)
                            &#9733;
                          @endfor
                          @for ($i = floor($stats['averageRating']); $i < 5; $i++)
                            &#9734;
                          @endfor
                        </div>
                        <p class="text-muted small mb-0">{{ $stats['totalReviews'] }}
                          {{ Illuminate\Support\Str::plural('review', $stats['totalReviews']) }}</p>
                      </div>
                      <div class="col-md-8">
                        @foreach ($ratingBreakdown as $rating => $data)
                          <div class="d-flex align-items-center mb-2">
                            <span class="me-2" style="width: 60px;">{{ $rating }}
                              star{{ $rating > 1 ? 's' : '' }}</span>
                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                              <div class="progress-bar bg-warning" role="progressbar"
                                style="width: {{ $data['percentage'] }}%" aria-valuenow="{{ $data['percentage'] }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span style="width: 40px;">{{ $data['count'] }}</span>
                          </div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>
              @endif

              <!-- Reviews List -->
              @forelse($artisan->reviews as $review)
                <div class="card mb-3 border">
                  <div class="card-body">
                    <div class="d-flex align-items-start gap-3">
                      <div class="avatar avatar-md rounded-circle bg-label-primary flex-shrink-0">
                        <span class="avatar-initial">{{ substr($review->client->name, 0, 1) }}</span>
                      </div>
                      <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                          <div>
                            <h6 class="mb-0">{{ $review->client->name }}</h6>
                            <div class="text-warning small">
                              @for ($i = 0; $i < $review->rating; $i++)
                                &#9733;
                              @endfor
                              @for ($i = $review->rating; $i < 5; $i++)
                                &#9734;
                              @endfor
                            </div>
                          </div>
                          <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-2">{{ $review->comment }}</p>

                        @if ($review->has_response)
                          <div class="card bg-light mt-3">
                            <div class="card-body p-3">
                              <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="ri-reply-line text-primary"></i>
                                <strong class="small">Response from {{ $artisan->business_name }}</strong>
                                <small class="text-muted ms-auto">{{ $review->response_date->diffForHumans() }}</small>
                              </div>
                              <p class="small mb-0">{{ $review->response_comment }}</p>
                            </div>
                          </div>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              @empty
                <div class="text-center py-5">
                  <i class="ri-star-line text-muted" style="font-size: 3rem;"></i>
                  <p class="text-muted mt-2">No reviews yet</p>
                </div>
              @endforelse
            </div>
          </div>
        </div>

        <!-- About Tab -->
        <div class="tab-pane fade" id="about" role="tabpanel">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4">About {{ $artisan->business_name }}</h5>

              @if ($artisan->bio)
                <div class="mb-4">
                  <h6 class="text-muted small text-uppercase mb-2">Bio</h6>
                  <p>{{ $artisan->bio }}</p>
                </div>
              @endif

              <div class="row g-4">
                <div class="col-md-6">
                  <h6 class="text-muted small text-uppercase mb-2">Business Information</h6>
                  <ul class="list-unstyled">
                    <li class="mb-2"><i class="ri-briefcase-line me-2 text-primary"></i>{{ $artisan->business_name }}
                    </li>
                    <li class="mb-2"><i class="ri-tools-line me-2 text-primary"></i>{{ $artisan->category }}</li>
                    <li class="mb-2"><i
                        class="ri-time-line me-2 text-primary"></i>{{ $artisan->years_of_experience }} years
                      experience</li>
                  </ul>
                </div>
                <div class="col-md-6">
                  <h6 class="text-muted small text-uppercase mb-2">Location</h6>
                  <ul class="list-unstyled">
                    <li class="mb-2"><i class="ri-map-pin-line me-2 text-primary"></i>{{ $artisan->city }}, Zimbabwe
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column - Contact Card -->
    <div class="col-lg-4 mb-4">
      <div class="card sticky-top" style="top: 90px;">
        <div class="card-body">
          <h5 class="card-title mb-4">Contact Information</h5>

          @if ($artisan->phone)
            <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom">
              <div class="avatar avatar-sm bg-label-primary flex-shrink-0">
                <i class="ri-phone-line"></i>
              </div>
              <div>
                <p class="text-muted small mb-0">Phone</p>
                <a href="tel:{{ $artisan->phone }}" class="fw-semibold">{{ $artisan->phone }}</a>
              </div>
            </div>
          @endif

          @if ($artisan->user->email)
            <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom">
              <div class="avatar avatar-sm bg-label-success flex-shrink-0">
                <i class="ri-mail-line"></i>
              </div>
              <div>
                <p class="text-muted small mb-0">Email</p>
                <a href="mailto:{{ $artisan->user->email }}" class="fw-semibold">{{ $artisan->user->email }}</a>
              </div>
            </div>
          @endif

          <div class="d-flex align-items-center gap-3 mb-4">
            <div class="avatar avatar-sm bg-label-info flex-shrink-0">
              <i class="ri-map-pin-line"></i>
            </div>
            <div>
              <p class="text-muted small mb-0">Location</p>
              <span class="fw-semibold">{{ $artisan->city }}, Zimbabwe</span>
            </div>
          </div>

          <a href="{{ route('user-browse-artisans') }}" class="btn btn-outline-secondary w-100">
            <i class="ri-arrow-left-line me-2"></i>Back to Browse
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection
