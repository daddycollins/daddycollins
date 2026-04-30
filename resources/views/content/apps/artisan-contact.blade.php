@extends('layouts/layoutMaster')

@section('title', 'Contact Artisan - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('content')
  <!-- Page Header -->
  <div class="row mb-6">
    <div class="col-12">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h4 class="mb-2">Contact Artisan</h4>
          <p class="text-muted mb-0">Reach out to your service provider</p>
        </div>
        <a href="{{ route('user-my-orders') }}" class="btn btn-outline-primary">Back to Orders</a>
      </div>
    </div>
  </div>

  <div class="row g-6">
    <!-- Artisan Card -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-body text-center">
          <div class="mb-3">
            <div class="avatar avatar-xl mx-auto mb-3">
              <img
                src="{{ $artisan->profile_photo_path ? asset('storage/' . $artisan->profile_photo_path) : asset('assets/img/avatars/1.png') }}"
                alt="Avatar" class="rounded-circle" />
            </div>
          </div>
          <h5 class="mb-1">{{ $artisan->user->name ?? 'Unknown' }}</h5>
          <p class="text-muted mb-3">{{ $artisan->business_name ?? 'Service Provider' }}</p>

          <div class="mb-3">
            <span class="badge bg-label-primary">{{ $artisan->category ?? 'General' }}</span>
            @if ($artisan->verified)
              <span class="badge bg-label-success">
                <i class="ri ri-check-line"></i> Verified
              </span>
            @endif
          </div>

          <div class="mb-3">
            <div class="d-flex justify-content-center gap-2 mb-2">
              <span class="badge bg-label-info">⭐ {{ number_format($artisan->average_rating ?? 0, 1) }} Rating</span>
            </div>
          </div>

          @if ($artisan->phone)
            <div class="mb-2">
              <small class="text-muted">Phone:</small>
              <p class="mb-0">
                <a href="tel:{{ $artisan->phone }}" class="fw-medium">{{ $artisan->phone }}</a>
              </p>
            </div>
          @endif

          @if ($artisan->bio)
            <div class="mb-3">
              <small class="text-muted d-block mb-2">About</small>
              <p class="text-muted small mb-0">{{ $artisan->bio }}</p>
            </div>
          @endif

          <div class="d-grid gap-2">
            @if ($artisan->phone)
              <a href="tel:{{ $artisan->phone }}" class="btn btn-primary">
                <i class="ri ri-phone-line me-2"></i>Call Now
              </a>
            @endif
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#messageModal">
              <i class="ri ri-mail-line me-2"></i>Send Message
            </button>
          </div>
        </div>
      </div>

      <!-- Business Hours -->
      @if ($artisan->business_hours)
        <div class="card mt-3">
          <div class="card-body">
            <h6 class="card-title mb-3">Business Hours</h6>
            @php
              $hours = is_array($artisan->business_hours)
                  ? $artisan->business_hours
                  : json_decode($artisan->business_hours, true);
            @endphp
            @if ($hours)
              <div class="small">
                @foreach ($hours as $day => $time)
                  <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">{{ ucfirst($day) }}:</span>
                    <span class="fw-medium">{{ $time['open'] ?? 'Closed' }} - {{ $time['close'] ?? 'Closed' }}</span>
                  </div>
                @endforeach
              </div>
            @endif
          </div>
        </div>
      @endif
    </div>

    <!-- Contact Information -->
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Related Order</h5>
        </div>
        <div class="card-body">
          <div class="row g-4">
            <div class="col-md-6">
              <div class="mb-3">
                <span class="text-muted small">Order ID:</span>
                <p class="mb-0"><strong>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong></p>
              </div>
              <div class="mb-3">
                <span class="text-muted small">Order Date:</span>
                <p class="mb-0"><strong>{{ $order->created_at->format('M d, Y H:i A') }}</strong></p>
              </div>
              <div class="mb-3">
                <span class="text-muted small">Order Status:</span>
                <p class="mb-0">
                  @php
                    $statusColors = [
                        'completed' => 'success',
                        'processing' => 'info',
                        'paid' => 'success',
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                    ];
                    $statusColor = $statusColors[$order->status] ?? 'secondary';
                  @endphp
                  <span
                    class="badge bg-label-{{ $statusColor }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                </p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <span class="text-muted small">Payment Status:</span>
                <p class="mb-0">
                  @if ($order->payment_status === 'paid')
                    <span class="badge bg-label-success">Paid</span>
                  @elseif($order->payment_status === 'unpaid')
                    <span class="badge bg-label-warning">Pending</span>
                  @else
                    <span class="badge bg-label-secondary">{{ ucfirst($order->payment_status) }}</span>
                  @endif
                </p>
              </div>
              <div class="mb-3">
                <span class="text-muted small">Order Total:</span>
                <p class="mb-0"><strong>${{ number_format($order->total_amount ?? 0, 2) }}</strong></p>
              </div>
              <div class="mb-3">
                <a href="{{ route('user-order-details', $order->id) }}" class="btn btn-sm btn-outline-primary">
                  View Order Details
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Service Details -->
      <div class="card mt-3">
        <div class="card-header">
          <h5 class="card-title mb-0">Service/Good Details</h5>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead>
              <tr>
                <th>Item</th>
                <th>Type</th>
                <th>Price</th>
              </tr>
            </thead>
            <tbody>
              @forelse($order->items as $item)
                <tr>
                  <td>
                    <span class="fw-medium">
                      {{ $item->artisanService?->service_name ?? ($item->artisanGood?->good_name ?? 'N/A') }}
                    </span>
                    @if ($item->artisanService?->description)
                      <br>
                      <small class="text-muted">{{ $item->artisanService->description }}</small>
                    @endif
                  </td>
                  <td>
                    <span class="badge bg-label-primary">
                      {{ $item->artisanService ? 'Service' : 'Good' }}
                    </span>
                  </td>
                  <td>
                    <strong>${{ number_format($item->price ?? 0, 2) }}</strong>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="3" class="text-center text-muted py-3">
                    No items found
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Message Modal -->
  <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="messageModalLabel">Send Message to {{ $artisan->user->name ?? 'Artisan' }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form>
          <div class="modal-body">
            <div class="form-group mb-3">
              <label class="form-label">Subject</label>
              <input type="text" class="form-control" placeholder="Message subject" required>
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Message</label>
              <textarea class="form-control" rows="5" placeholder="Type your message here..." required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Send Message</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
