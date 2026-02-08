@extends('layouts/layoutMaster')

@section('title', 'Browse Artisans - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js'])
@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const filterForm = document.getElementById('filterForm');
      if (!filterForm) return;

      // Auto-submit form on filter dropdown change
      const filterSelects = filterForm.querySelectorAll('select');
      filterSelects.forEach(function(select) {
        select.addEventListener('change', function() {
          filterForm.submit();
        });
      });

      // Debounce search input - submit after 500ms of no typing
      let searchTimeout;
      const searchInput = filterForm.querySelector('input[name="search"]');
      if (searchInput) {
        searchInput.addEventListener('input', function() {
          clearTimeout(searchTimeout);
          searchTimeout = setTimeout(function() {
            filterForm.submit();
          }, 500);
        });
      }
    });
  </script>
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
          <span class="badge bg-label-success"><i class="icon-base ri ri-verified-badge-line"></i> {{ $verifiedCount }}
            Verified</span>
          <span class="badge bg-label-info">{{ $totalArtisans }} Artisans</span>
        </div>
      </div>

      <!-- Search & Filter Bar -->
      <div class="card mb-6">
        <div class="card-body">
          <form method="GET" action="{{ route('user-browse-artisans') }}" id="filterForm">
            <div class="row g-3 align-items-end">
              <!-- Search Input -->
              <div class="col-md-5">
                <label class="form-label">Search Artisans</label>
                <div class="input-group">
                  <span class="input-group-text">
                    <i class="icon-base ri ri-search-line"></i>
                  </span>
                  <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                    placeholder="Name, specialty, location..." />
                </div>
              </div>

              <!-- Category Filter -->
              <div class="col-md-3">
                <label class="form-label">Category</label>
                <select class="form-select" name="category" id="categoryFilter">
                  <option value="">All Categories</option>
                  @foreach ($categoryOptions as $value => $label)
                    <option value="{{ $value }}" {{ request('category') == $value ? 'selected' : '' }}>
                      {{ $label }}</option>
                  @endforeach
                </select>
              </div>

              <!-- Location Filter -->
              <div class="col-md-3">
                <label class="form-label">Location</label>
                <select class="form-select" name="location" id="locationFilter">
                  <option value="">All Locations</option>
                  @foreach ($locationOptions as $value => $label)
                    <option value="{{ $value }}" {{ request('location') == $value ? 'selected' : '' }}>
                      {{ $label }}</option>
                  @endforeach
                </select>
              </div>

              <!-- Action Buttons -->
              <div class="col-md-1">
                <div class="d-flex gap-2">
                  <button type="submit" class="btn btn-icon btn-primary" title="Search">
                    <i class="icon-base ri ri-search-line icon-20px"></i>
                  </button>
                  <a href="{{ route('user-browse-artisans') }}" class="btn btn-icon btn-outline-secondary"
                    title="Reset Filters">
                    <i class="icon-base ri ri-refresh-line icon-20px"></i>
                  </a>
                </div>
              </div>
            </div>

            <!-- Additional Filters -->
            <div class="row g-3 mt-2">
              <div class="col-md-3">
                <label class="form-label">Rating</label>
                <select class="form-select" name="rating">
                  <option value="">Any Rating</option>
                  <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                  <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4+ Stars</option>
                  <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3+ Stars</option>
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">Experience</label>
                <select class="form-select" name="experience">
                  <option value="">Any Experience</option>
                  <option value="0-2" {{ request('experience') == '0-2' ? 'selected' : '' }}>0-2 Years</option>
                  <option value="2-5" {{ request('experience') == '2-5' ? 'selected' : '' }}>2-5 Years</option>
                  <option value="5+" {{ request('experience') == '5+' ? 'selected' : '' }}>5+ Years</option>
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">Price Range</label>
                <select class="form-select" name="price_range">
                  <option value="">Any Price</option>
                  <option value="budget" {{ request('price_range') == 'budget' ? 'selected' : '' }}>Budget ($)</option>
                  <option value="mid" {{ request('price_range') == 'mid' ? 'selected' : '' }}>Mid-range ($$)</option>
                  <option value="premium" {{ request('price_range') == 'premium' ? 'selected' : '' }}>Premium ($$$)
                  </option>
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">Availability</label>
                <select class="form-select" name="availability">
                  <option value="">Any Availability</option>
                  <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Available Now
                  </option>
                  <option value="week" {{ request('availability') == 'week' ? 'selected' : '' }}>This Week</option>
                  <option value="month" {{ request('availability') == 'month' ? 'selected' : '' }}>This Month</option>
                </select>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Artisans Grid -->
  <div class="row g-6 mb-6">
    @forelse($artisans as $artisan)
      @php
        // Calculate rating stars
        $rating = $artisan->average_rating ?? 0;
        $fullStars = floor($rating);
        $hasHalfStar = $rating - $fullStars >= 0.5;
        $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);

        // Calculate completion rate
        $totalOrders = $artisan->total_orders_count ?? 0;
        $completedOrders = $artisan->completed_jobs_count ?? 0;
        $completionRate = $totalOrders > 0 ? round(($completedOrders / $totalOrders) * 100) : 100;

        // Get average service price
        $avgPrice = $artisan->services->avg('price_estimate') ?? 0;

        // Get artisan name
        $artisanName =
            $artisan->first_name && $artisan->last_name
                ? $artisan->first_name . ' ' . $artisan->last_name
                : $artisan->user->name ?? ($artisan->business_name ?? 'Artisan');
      @endphp

      <!-- Dynamic Artisan Card -->
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card artisan-card h-100 border-0 shadow-sm transition-hover">
          <!-- Artisan Image -->
          <div class="position-relative overflow-hidden" style="height: 240px;">
            <img
              src="{{ $artisan->profile_photo_path ? asset('storage/' . $artisan->profile_photo_path) : asset('assets/img/avatars/1.png') }}"
              class="card-img-top h-100 w-100 object-fit-cover" alt="{{ $artisanName }}" />

            {{-- Verification Badge --}}
            <div class="position-absolute top-0 end-0 m-2">
              @if ($artisan->verified)
                <span class="badge bg-label-success rounded-pill">
                  <i class="icon-base ri ri-verified-badge-fill icon-14px me-1"></i>Verified
                </span>
              @else
                <span class="badge bg-label-warning rounded-pill">
                  <i class="icon-base ri ri-time-line icon-14px me-1"></i>Pending
                </span>
              @endif
            </div>

            {{-- Action Buttons Overlay --}}
            <div class="position-absolute bottom-0 start-0 end-0 p-3"
              style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
              <div class="d-flex gap-2">
                <a href="{{ route('artisan-public-profile', $artisan->id) }}" class="btn btn-icon btn-sm btn-light"
                  title="View Profile">
                  <i class="icon-base ri ri-eye-line icon-16px"></i>
                </a>
                @if ($artisan->phone)
                  <a href="tel:{{ $artisan->phone }}" class="btn btn-icon btn-sm btn-light" title="Contact">
                    <i class="icon-base ri ri-phone-line icon-16px"></i>
                  </a>
                @else
                  <button class="btn btn-icon btn-sm btn-light" title="Contact">
                    <i class="icon-base ri ri-phone-line icon-16px"></i>
                  </button>
                @endif
                <button class="btn btn-icon btn-sm btn-light" title="Add to Favorites">
                  <i class="icon-base ri ri-heart-line icon-16px"></i>
                </button>
              </div>
            </div>
          </div>

          <!-- Artisan Info -->
          <div class="card-body">
            <div class="mb-3">
              {{-- Name --}}
              <h6 class="mb-1">{{ $artisanName }}</h6>

              {{-- Category --}}
              <p class="text-muted small mb-2">{{ $artisan->category ?? 'General Services' }}</p>

              {{-- Rating Stars --}}
              <div class="d-flex align-items-center gap-2 mb-2">
                <div class="text-warning small">
                  @for ($i = 0; $i < $fullStars; $i++)
                    <i class="icon-base ri ri-star-fill icon-12px"></i>
                  @endfor
                  @if ($hasHalfStar)
                    <i class="icon-base ri ri-star-half-fill icon-12px"></i>
                  @endif
                  @for ($i = 0; $i < $emptyStars; $i++)
                    <i class="icon-base ri ri-star-line icon-12px"></i>
                  @endfor
                </div>
                <small class="text-muted">({{ $artisan->reviews_count ?? 0 }})</small>
              </div>

              {{-- Location --}}
              <p class="text-muted small mb-2">
                <i class="icon-base ri ri-map-pin-line icon-12px"></i>
                {{ $artisan->city ?? ($artisan->location ?? 'Zimbabwe') }}
              </p>
            </div>

            {{-- Experience & Jobs Stats --}}
            <div class="row g-2 mb-3">
              <div class="col-6">
                <div class="text-center p-2 bg-light rounded">
                  <small class="text-muted d-block mb-1">Experience</small>
                  <span class="small fw-medium">{{ $artisan->years_of_experience ?? 0 }} Years</span>
                </div>
              </div>
              <div class="col-6">
                <div class="text-center p-2 bg-light rounded">
                  <small class="text-muted d-block mb-1">Jobs Done</small>
                  <span class="small fw-medium">{{ $artisan->completed_jobs_count ?? 0 }}</span>
                </div>
              </div>
            </div>

            {{-- Services Tags --}}
            <div class="mb-3">
              <small class="text-muted d-block mb-2">Services</small>
              <div class="d-flex flex-wrap gap-1">
                @forelse($artisan->services->take(2) as $service)
                  <span
                    class="badge bg-label-primary">{{ Illuminate\Support\Str::limit($service->service_name, 15) }}</span>
                @empty
                  <span class="badge bg-label-secondary">No services listed</span>
                @endforelse
                @if ($artisan->services->count() > 2)
                  <span class="badge bg-label-secondary">+{{ $artisan->services->count() - 2 }}</span>
                @endif
              </div>
            </div>

            <a href="{{ route('artisan-public-profile', $artisan->id) }}" class="btn btn-primary w-100 btn-sm">View
              Profile</a>
          </div>

          <!-- Bottom Stats -->
          <div class="card-footer bg-transparent border-top">
            <div class="d-flex justify-content-between text-center small">
              <div>
                <strong>${{ number_format($avgPrice, 0) }}</strong>
                <p class="text-muted mb-0 small">Avg Price</p>
              </div>
              <div class="border-start"></div>
              <div>
                <strong>{{ $completionRate }}%</strong>
                <p class="text-muted mb-0 small">Completion</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    @empty
      {{-- No Results State --}}
      <div class="col-12">
        <div class="card">
          <div class="card-body text-center py-5">
            <i class="icon-base ri ri-search-line icon-64px text-muted mb-3" style="font-size: 64px;"></i>
            <h5 class="text-muted">No artisans found</h5>
            <p class="text-muted mb-4">Try adjusting your filters or search criteria</p>
            <a href="{{ route('user-browse-artisans') }}" class="btn btn-primary">
              <i class="icon-base ri ri-refresh-line me-1"></i> Reset Filters
            </a>
          </div>
        </div>
      </div>
    @endforelse
  </div>

  <!-- Pagination -->
  @if ($artisans->hasPages())
    <div class="row">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
          {{-- Results Count --}}
          <p class="text-muted mb-0">
            Showing {{ $artisans->firstItem() ?? 0 }} to {{ $artisans->lastItem() ?? 0 }}
            of {{ $artisans->total() }} artisans
          </p>

          {{-- Pagination Links --}}
          {{ $artisans->links('pagination::bootstrap-5') }}
        </div>
      </div>
    </div>
  @endif

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
