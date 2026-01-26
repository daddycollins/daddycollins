@extends('layouts/layoutMaster')

@section('title', 'Dashboard - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection

@section('page-style')
  @vite(['resources/assets/vendor/scss/pages/app-ecommerce-dashboard.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/apex-charts/apexcharts.js'])
@endsection

@section('page-script')
  {{-- Add custom dashboard script if needed --}}
@endsection

@section('content')
  <!-- Page Title -->
  <div class="row mb-6">
    <div class="col-12">
      <div class="d-flex align-items-center gap-2">
        <h4 class="mb-0">Dashboard</h4>
      </div>
    </div>
  </div>

  <!-- Statistical Cards -->
  <div class="row g-6 mb-6">
    <!-- Total Orders -->
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="mb-1 text-muted">Total Orders</p>
              <h4 class="mb-2">{{ $totalOrders }}</h4>
              <p class="mb-0 text-muted"><i class="icon-base ri ri-arrow-up-s-line"></i> All time</p>
            </div>
            <div class="avatar bg-label-primary">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-shopping-bag-line icon-24px"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Orders -->
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="mb-1 text-muted">Pending Orders</p>
              <h4 class="mb-2">{{ $pendingOrders }}</h4>
              <p class="mb-0 text-warning"><i class="icon-base ri ri-time-line"></i> Awaiting Processing</p>
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

    <!-- Completed Orders -->
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="mb-1 text-muted">Completed Orders</p>
              <h4 class="mb-2">{{ $completedOrders }}</h4>
              <p class="mb-0 text-success"><i class="icon-base ri ri-check-double-line"></i> Successfully Done</p>
            </div>
            <div class="avatar bg-label-success">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-checkbox-circle-line icon-24px"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Active Artisans Hired -->
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <p class="mb-1 text-muted">Artisans Hired</p>
              <h4 class="mb-2">{{ $artisansHired }}</h4>
              <p class="mb-0 text-info"><i class="icon-base ri ri-user-star-line"></i> Total</p>
            </div>
            <div class="avatar bg-label-info">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-group-line icon-24px"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content Row -->
  <div class="row g-6 mb-6">
    <!-- Recent Orders -->
    <div class="col-lg-8">
      <div class="card h-100">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Recent Orders</h5>
            <a href="{{ route('user-my-orders') }}" class="text-primary small fw-medium">View All</a>
          </div>
        </div>
        <div class="table-responsive text-nowrap">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Artisan</th>
                <th>Service/Good</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @forelse($recentOrders as $order)
                <tr>
                  <td>
                    <span class="badge bg-label-primary">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="avatar avatar-sm me-2">
                        <img
                          src="{{ $order->artisan->profile_photo_path ? asset('storage/' . $order->artisan->profile_photo_path) : asset('assets/img/avatars/default.png') }}"
                          alt="Avatar" class="rounded-circle" />
                      </div>
                      <span>{{ $order->artisan->user->name }}</span>
                    </div>
                  </td>
                  <td>
                    @if ($order->items->count() > 0)
                      {{ $order->items->first()->artisanService->service_name ?? 'Service' }}
                    @else
                      Service
                    @endif
                  </td>
                  <td><strong>${{ number_format($order->total_amount ?? 0, 2) }}</strong></td>
                  <td>
                    @php
                      $statusBadgeClass = match ($order->status) {
                          'completed' => 'bg-label-success',
                          'processing', 'paid' => 'bg-label-info',
                          'pending' => 'bg-label-warning',
                          'cancelled' => 'bg-label-danger',
                          default => 'bg-label-secondary',
                      };
                    @endphp
                    <span class="badge {{ $statusBadgeClass }}">{{ ucfirst($order->status) }}</span>
                  </td>
                  <td>{{ $order->created_at->format('M d, Y') }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center py-4">
                    <p class="text-muted mb-0">No orders yet. <a href="{{ route('user-browse-artisans') }}"
                        class="text-primary">Browse artisans</a> to place your first order.</p>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Order Status Summary -->
    <div class="col-lg-4">
      <div class="card h-100">
        <div class="card-header">
          <h5 class="mb-0">Order Status Summary</h5>
        </div>
        <div class="card-body">
          @if ($totalStatusCount > 0)
            <div class="mb-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted">Completed</span>
                <span class="badge bg-label-success">{{ $completedPercent }}%</span>
              </div>
              <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-success" style="width: {{ $completedPercent }}%"></div>
              </div>
              <small class="text-muted">{{ $completedCount }} {{ $completedCount === 1 ? 'order' : 'orders' }}</small>
            </div>

            <div class="mb-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted">In Progress</span>
                <span class="badge bg-label-info">{{ $inProgressPercent }}%</span>
              </div>
              <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-info" style="width: {{ $inProgressPercent }}%"></div>
              </div>
              <small class="text-muted">{{ $inProgressCount }} {{ $inProgressCount === 1 ? 'order' : 'orders' }}</small>
            </div>

            <div class="mb-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted">Pending</span>
                <span class="badge bg-label-warning">{{ $pendingPercent }}%</span>
              </div>
              <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-warning" style="width: {{ $pendingPercent }}%"></div>
              </div>
              <small class="text-muted">{{ $pendingCount }} {{ $pendingCount === 1 ? 'order' : 'orders' }}</small>
            </div>

            <div class="mb-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted">Cancelled</span>
                <span class="badge bg-label-danger">{{ $cancelledPercent }}%</span>
              </div>
              <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-danger" style="width: {{ $cancelledPercent }}%"></div>
              </div>
              <small class="text-muted">{{ $cancelledCount }} {{ $cancelledCount === 1 ? 'order' : 'orders' }}</small>
            </div>

            <hr class="my-4" />

            <div class="text-center">
              <p class="text-muted small mb-0">Total Orders: <strong>{{ $totalStatusCount }}</strong></p>
            </div>
          @else
            <div class="text-center py-6">
              <i class="icon-base ri ri-inbox-line icon-56px text-muted mb-3 d-block"></i>
              <p class="text-muted small mb-0">No orders yet. Place an order to see summary.</p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Recommended Artisans Section -->
  <div class="row g-6">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Recommended Artisans</h5>
            <a href="{{ route('user-browse-artisans') }}" class="text-primary small fw-medium">View More</a>
          </div>
          <p class="card-subtitle mb-0">Top-rated artisans based on your preferences</p>
        </div>
        <div class="card-body">
          @if ($recommendedArtisans->count() > 0)
            <div class="row g-6">
              @foreach ($recommendedArtisans as $artisan)
                <!-- Artisan Card -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="text-center">
                    <div class="mb-3">
                      <div class="avatar avatar-lg mx-auto mb-3">
                        <img
                          src="{{ $artisan->profile_photo_path ? asset('storage/' . $artisan->profile_photo_path) : asset('assets/img/avatars/default.png') }}"
                          alt="{{ $artisan->user->name }}" class="rounded-circle" />
                      </div>
                      <h6 class="mb-1">{{ $artisan->user->name }}</h6>
                      <p class="text-muted small mb-2">{{ $artisan->category ?? 'Artisan Services' }}</p>
                      <div class="mb-3">
                        <div class="text-warning">
                          @php
                            $rating = $artisan->average_rating ?? 0;
                            $fullStars = floor($rating);
                            $hasHalfStar = $rating - $fullStars >= 0.5;
                          @endphp
                          @for ($i = 0; $i < $fullStars; $i++)
                            <i class="icon-base ri ri-star-fill icon-14px"></i>
                          @endfor
                          @if ($hasHalfStar)
                            <i class="icon-base ri ri-star-half-fill icon-14px"></i>
                            @php $i++ @endphp
                          @endif
                          @for ($j = $i; $j < 5; $j++)
                            <i class="icon-base ri ri-star-line icon-14px"></i>
                          @endfor
                        </div>
                        <small class="text-muted">{{ number_format($artisan->average_rating, 1) }}/5
                          ({{ $artisan->reviews_count }}
                          {{ $artisan->reviews_count === 1 ? 'review' : 'reviews' }})
                        </small>
                      </div>
                      <a href="{{ route('user-browse-artisans') }}" class="btn btn-sm btn-primary w-100">View
                        Profile</a>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @else
            <div class="text-center py-8">
              <i class="icon-base ri ri-search-line icon-56px text-muted mb-3 d-block"></i>
              <p class="text-muted small mb-2">No recommended artisans available at this time.</p>
              <a href="{{ route('user-browse-artisans') }}" class="btn btn-sm btn-primary">Browse All Artisans</a>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
