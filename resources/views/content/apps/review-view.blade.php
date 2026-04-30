@extends('layouts/layoutMaster')

@section('title', 'View Review - ArtisanConnect')

@section('content')
  <!-- Page Header -->
  <div class="row mb-6">
    <div class="col-12">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h4 class="mb-2">View Review</h4>
          <p class="text-muted mb-0">Review details</p>
        </div>
        <a href="{{ route('user-create-review') }}" class="btn btn-outline-primary">Back to Reviews</a>
      </div>
    </div>
  </div>

  <div class="row g-6">
    <!-- Review Card -->
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <!-- Artisan Info -->
          <div class="d-flex align-items-start gap-3 mb-4 pb-4 border-bottom">
            <div class="avatar avatar-lg">
              <img
                src="{{ $review->artisan->profile_photo_path ? asset('storage/' . $review->artisan->profile_photo_path) : asset('assets/img/avatars/1.png') }}"
                alt="Avatar" class="rounded-circle" />
            </div>
            <div class="flex-grow-1">
              <h5 class="mb-1">{{ $review->artisan->user->name ?? 'Unknown' }}</h5>
              <p class="text-muted small mb-2">{{ $review->artisan->business_name ?? 'Service Provider' }}</p>
              <span class="badge bg-label-primary">{{ $review->artisan->category ?? 'General' }}</span>
              @if ($review->artisan->verified)
                <span class="badge bg-label-success">
                  <i class="ri ri-check-line"></i> Verified
                </span>
              @endif
            </div>
          </div>

          <!-- Rating -->
          <div class="mb-4">
            <h6 class="mb-2">Your Rating</h6>
            <div class="d-flex gap-1">
              @for ($i = 1; $i <= 5; $i++)
                <i
                  class="icon-base ri {{ $i <= $review->rating ? 'ri-star-fill text-warning' : 'ri-star-line text-muted' }} icon-24px"></i>
              @endfor
            </div>
            <p class="text-muted small mt-2">{{ $review->rating }} out of 5 stars</p>
          </div>

          <!-- Review Text -->
          <div class="mb-4">
            <h6 class="mb-2">Your Review</h6>
            <p class="text-muted">{{ $review->comment }}</p>
          </div>

          <!-- Order Info -->
          <div class="mb-4 p-3 bg-light rounded">
            <h6 class="mb-2">Order Details</h6>
            <div class="row g-3">
              <div class="col-md-6">
                <small class="text-muted d-block">Order ID:</small>
                <strong>#{{ str_pad($review->order->id, 4, '0', STR_PAD_LEFT) }}</strong>
              </div>
              <div class="col-md-6">
                <small class="text-muted d-block">Order Date:</small>
                <strong>{{ $review->order->created_at->format('M d, Y') }}</strong>
              </div>
              <div class="col-md-6">
                <small class="text-muted d-block">Order Amount:</small>
                <strong>${{ number_format($review->order->total_amount ?? 0, 2) }}</strong>
              </div>
              <div class="col-md-6">
                <small class="text-muted d-block">Order Status:</small>
                <span class="badge bg-label-success">{{ ucfirst($review->order->status) }}</span>
              </div>
            </div>
          </div>

          <!-- Review Info -->
          <div class="pt-3 border-top">
            <small class="text-muted">
              Reviewed on {{ $review->created_at->format('M d, Y \a\t H:i A') }}
              @if ($review->updated_at && $review->updated_at->ne($review->created_at))
                • Edited on {{ $review->updated_at->format('M d, Y \a\t H:i A') }}
              @endif
            </small>
          </div>
        </div>
        <div class="card-footer">
          <a href="{{ route('user-edit-review', $review->id) }}" class="btn btn-primary">
            <i class="ri ri-edit-line me-2"></i>Edit Review
          </a>
          <form action="{{ route('user-delete-review', $review->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger"
              onclick="return confirm('Are you sure you want to delete this review?');">
              <i class="ri ri-delete-bin-line me-2"></i>Delete Review
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
      <!-- Quick Links -->
      <div class="card mb-4">
        <div class="card-body">
          <h6 class="card-title mb-3">Actions</h6>
          <div class="d-grid gap-2">
            <a href="{{ route('user-order-details', $review->order->id) }}" class="btn btn-outline-primary">
              <i class="ri ri-eye-line me-2"></i>View Order
            </a>
            <a href="{{ route('user-contact-artisan', $review->order->id) }}" class="btn btn-outline-secondary">
              <i class="ri ri-phone-line me-2"></i>Contact Artisan
            </a>
          </div>
        </div>
      </div>

      <!-- Artisan Rating Info -->
      @if ($review->artisan->average_rating)
        <div class="card">
          <div class="card-body text-center">
            <h6 class="card-title mb-3">Artisan's Average Rating</h6>
            <div class="mb-2">
              <div class="d-flex gap-1 justify-content-center mb-2">
                @for ($i = 1; $i <= 5; $i++)
                  <i
                    class="icon-base ri {{ $i <= round($review->artisan->average_rating) ? 'ri-star-fill text-warning' : 'ri-star-line text-muted' }} icon-24px"></i>
                @endfor
              </div>
            </div>
            <h3 class="mb-0">{{ number_format($review->artisan->average_rating, 1) }}/5</h3>
          </div>
        </div>
      @endif
    </div>
  </div>
@endsection
