@extends('layouts/layoutMaster')

@section('title', 'Edit Review - ArtisanConnect')

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Star Rating Input Handler
      const ratingStars = document.querySelectorAll('#ratingStars .rating-input i');
      const ratingInput = document.getElementById('ratingInput');

      // Set initial rating
      const currentRating = parseInt(ratingInput.value) || 0;
      ratingStars.forEach((star, i) => {
        if (i < currentRating) {
          star.classList.remove('ri-star-line', 'text-muted');
          star.classList.add('ri-star-fill', 'text-warning');
        }
      });

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
    });
  </script>
@endsection

@section('content')
  <!-- Page Header -->
  <div class="row mb-6">
    <div class="col-12">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
          <h4 class="mb-2">Edit Review</h4>
          <p class="text-muted mb-0">Update your review for {{ $review->artisan->user->name ?? 'this artisan' }}</p>
        </div>
        <a href="{{ route('user-view-review', $review->id) }}" class="btn btn-outline-primary">Back</a>
      </div>
    </div>
  </div>

  <div class="row g-6">
    <!-- Edit Form -->
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
            </div>
          </div>

          <!-- Edit Form -->
          <form action="{{ route('user-update-review', $review->id) }}" method="POST">
            @csrf
            @method('PUT')

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
              <input type="hidden" name="rating" id="ratingInput" value="{{ $review->rating }}" required>
              @error('rating')
                <span class="text-danger small">{{ $message }}</span>
              @enderror
            </div>

            <!-- Review Text -->
            <div class="mb-4">
              <label class="form-label">Your Review <span class="text-danger">*</span></label>
              <textarea class="form-control" name="comment" rows="6" placeholder="Share your experience with this artisan..."
                required>{{ $review->comment }}</textarea>
              <small class="text-muted">Minimum 10 characters</small>
              @error('comment')
                <span class="text-danger small d-block">{{ $message }}</span>
              @enderror
            </div>

            <!-- Order Info (Read-only) -->
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
              </div>
            </div>

            <!-- Submit Button -->
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="ri ri-save-line me-2"></i>Save Changes
              </button>
              <a href="{{ route('user-view-review', $review->id) }}" class="btn btn-outline-secondary">
                Cancel
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
      <!-- Review Info -->
      <div class="card">
        <div class="card-body">
          <h6 class="card-title mb-3">Review Information</h6>
          <div class="mb-3">
            <small class="text-muted d-block">Original Review Date:</small>
            <p class="mb-0">{{ $review->created_at->format('M d, Y H:i A') }}</p>
          </div>
          @if ($review->updated_at && $review->updated_at->ne($review->created_at))
            <div class="mb-3">
              <small class="text-muted d-block">Last Modified:</small>
              <p class="mb-0">{{ $review->updated_at->format('M d, Y H:i A') }}</p>
            </div>
          @endif
          <div class="alert alert-info small" role="alert">
            <i class="ri ri-information-line me-2"></i>
            Your review will be updated immediately. The artisan will be notified of the changes.
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
