@extends('layouts/layoutMaster')

@section('title', $requirement->title . ' - Requirement')

@section('content')
  <div class="container-xxl py-5">
    <!-- Header Section -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-start mb-4">
          <div>
            <h2 class="mb-2 fw-bold">{{ $requirement->title }}</h2>
            <p class="text-muted mb-0">
              <i class="ri-calendar-line me-2"></i>Posted {{ $requirement->created_at->diffForHumans() }}
            </p>
          </div>
          <span class="badge bg-label-{{ $requirement->status === 'open' ? 'primary' : ($requirement->status === 'awarded' ? 'success' : 'secondary') }}">
            <i class="ri-{{ $requirement->status === 'open' ? 'inbox-line' : ($requirement->status === 'awarded' ? 'check-double-line' : 'lock-line') }} me-1"></i>
            {{ ucfirst($requirement->status) }}
          </span>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3">
          <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-body text-center">
                <i class="ri-price-tag-3-line text-primary" style="font-size: 2rem;"></i>
                <h6 class="text-muted small mt-3 mb-1">Budget</h6>
                <h4 class="mb-0 fw-bold text-primary">${{ number_format($requirement->budget, 2) }}</h4>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-body text-center">
                <i class="ri-folder-line text-info" style="font-size: 2rem;"></i>
                <h6 class="text-muted small mt-3 mb-1">Category</h6>
                <p class="mb-0 fw-semibold">{{ $requirement->category ?? 'General' }}</p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-body text-center">
                <i class="ri-calendar-deadline-line text-warning" style="font-size: 2rem;"></i>
                <h6 class="text-muted small mt-3 mb-1">Deadline</h6>
                <p class="mb-0 fw-semibold">
                  @if ($requirement->deadline)
                    {{ \Carbon\Carbon::parse($requirement->deadline)->format('M d, Y') }}
                  @else
                    <span class="text-muted">No deadline</span>
                  @endif
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-body text-center">
                <i class="ri-auction-line text-danger" style="font-size: 2rem;"></i>
                <h6 class="text-muted small mt-3 mb-1">Bids</h6>
                <h4 class="mb-0 fw-bold text-danger">{{ $requirement->bids->count() }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
      <!-- Left: Description -->
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-light border-0 d-flex align-items-center">
            <i class="ri-file-text-line me-2 text-primary"></i>
            <h5 class="mb-0">Requirement Details</h5>
          </div>
          <div class="card-body">
            <p class="text-dark mb-0" style="line-height: 1.8;">{{ $requirement->description }}</p>
          </div>
        </div>

        <!-- Bids Section -->
        @if (auth()->id() === $requirement->user_id)
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0 d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <i class="ri-auction-line me-2 text-primary"></i>
                <h5 class="mb-0">Bids Received
                  @if ($requirement->bids->count() > 0)
                    <span class="badge bg-primary ms-2">{{ $requirement->bids->count() }}</span>
                  @endif
                </h5>
              </div>
              <small class="text-muted">
                <i class="ri-refresh-line me-1"></i>Real-time updates every 5 seconds
              </small>
            </div>
            <div class="card-body">
              <div id="bids-table-container">
                @if ($requirement->bids->isEmpty())
                  <div class="text-center py-5">
                    <i class="ri-inbox-2-line" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mt-3 mb-0">No bids yet. Share this requirement to attract artisans!</p>
                  </div>
                @else
                  <div class="row g-3">
                    @foreach ($requirement->bids as $bid)
                      <div class="col-12">
                        <div class="card border-0 bg-light p-3">
                          <div class="row align-items-center">
                            <!-- Artisan Info -->
                            <div class="col-md-4">
                              <div class="d-flex align-items-center">
                                @if (optional($bid->artisan->artisanProfile)->profile_photo_path)
                                  <img src="{{ asset('storage/' . $bid->artisan->artisanProfile->profile_photo_path) }}"
                                    alt="Profile" width="48" height="48" class="rounded-circle me-3">
                                @else
                                  <div class="avatar-initial rounded-circle bg-primary text-white me-3"
                                    style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                    {{ substr($bid->artisan->name, 0, 1) }}
                                  </div>
                                @endif
                                <div>
                                  <h6 class="mb-1 fw-semibold">{{ $bid->artisan->name }}</h6>
                                  @php
                                    $profile = $bid->artisan->artisanProfile;
                                    $ordersCount = $bid->artisan->orders->where('artisan_id', optional($profile)->id)->count();
                                    $reviews = $bid->artisan->reviews->where('artisan_id', optional($profile)->id);
                                    $avgRating = $reviews->count() ? number_format($reviews->avg('rating'), 1) : 0;
                                  @endphp
                                  <div class="small text-muted">
                                    <i class="ri-star-fill text-warning"></i> {{ $avgRating }}
                                    <span class="ms-2">{{ $ordersCount }} {{ $ordersCount === 1 ? 'order' : 'orders' }}</span>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Bid Amount & Status -->
                            <div class="col-md-3">
                              <div class="mb-2 mb-md-0">
                                <p class="text-muted small mb-1">Bid Amount</p>
                                <h5 class="mb-2 text-primary fw-bold">${{ number_format($bid->amount, 2) }}</h5>
                                <span class="badge bg-label-{{ $bid->status === 'pending' ? 'warning' : ($bid->status === 'accepted' ? 'success' : 'danger') }}">
                                  {{ ucfirst($bid->status) }}
                                </span>
                              </div>
                            </div>

                            <!-- Proposal Preview -->
                            <div class="col-md-3">
                              <p class="text-muted small mb-1">Proposal</p>
                              <p class="mb-0 text-truncate" style="max-height: 40px;">
                            {{ $bid->proposal ? str($bid->proposal)->limit(50) : 'No proposal' }}
                              </p>
                            </div>

                            <!-- Actions -->
                            <div class="col-md-2 text-md-end">
                              <div class="btn-group" role="group">
                                @if ($bid->status === 'pending' && $requirement->status === 'open')
                                  <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#bidModal{{ $bid->id }}">
                                    <i class="ri-eye-line me-1"></i>View
                                  </button>
                                  <form method="POST" action="{{ route('bids.accept', $bid) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary" title="Accept this bid">
                                      <i class="ri-check-line me-1"></i>Accept
                                    </button>
                                  </form>
                                @elseif ($bid->status === 'accepted' && $requirement->status === 'awarded')
                                  <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                    data-bs-target="#bidModal{{ $bid->id }}">
                                    <i class="ri-eye-line me-1"></i>View
                                  </button>
                                  <a href="{{ route('bids.checkout', $bid) }}" class="btn btn-sm btn-success">
                                    <i class="ri-secure-payment-line me-1"></i>Pay Now
                                  </a>
                                @else
                                  <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                    data-bs-target="#bidModal{{ $bid->id }}">
                                    <i class="ri-eye-line me-1"></i>View
                                  </button>
                                @endif
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Bid Details Modal -->
                      <div class="modal fade" id="bidModal{{ $bid->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header border-0">
                              <h5 class="modal-title">Bid Details - {{ $bid->artisan->name }}</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                              <div class="row mb-3">
                                <div class="col-md-6">
                                  <p class="text-muted small mb-1">Bid Amount</p>
                                  <h5 class="text-primary fw-bold">${{ number_format($bid->amount, 2) }}</h5>
                                </div>
                                <div class="col-md-6">
                                  <p class="text-muted small mb-1">Status</p>
                                  <span class="badge bg-label-{{ $bid->status === 'pending' ? 'warning' : ($bid->status === 'accepted' ? 'success' : 'danger') }}">
                                    {{ ucfirst($bid->status) }}
                                  </span>
                                </div>
                              </div>

                              <div class="mb-3">
                                <p class="text-muted small mb-1">Artisan Details</p>
                                <div class="d-flex align-items-center">
                                  @if (optional($bid->artisan->artisanProfile)->profile_photo_path)
                                    <img src="{{ asset('storage/' . $bid->artisan->artisanProfile->profile_photo_path) }}"
                                      alt="Profile" width="64" height="64" class="rounded-circle me-3">
                                  @else
                                    <div class="avatar-initial rounded-circle bg-primary text-white me-3"
                                      style="width: 64px; height: 64px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                                      {{ substr($bid->artisan->name, 0, 1) }}
                                    </div>
                                  @endif
                                  <div>
                                    <h6 class="mb-0">{{ $bid->artisan->name }}</h6>
                                    <p class="text-muted small mb-0">{{ optional($bid->artisan->artisanProfile)->business_name ?? 'Service Provider' }}</p>
                                    <p class="text-muted small mb-0">
                                      <i class="ri-star-fill text-warning"></i> {{ $avgRating }}/5 •
                                      {{ $ordersCount }} {{ $ordersCount === 1 ? 'order' : 'orders' }}
                                    </p>
                                  </div>
                                </div>
                              </div>

                              <div class="mb-3">
                                <p class="text-muted small mb-1">Proposal</p>
                                <p class="card-text">{{ $bid->proposal ?? '<em class="text-muted">No proposal provided</em>' }}</p>
                              </div>

                              <div class="row text-muted small">
                                <div class="col-md-6">
                                  <p class="mb-1"><strong>Category:</strong> {{ optional($bid->artisan->artisanProfile)->category ?? '-' }}</p>
                                  <p class="mb-1"><strong>Location:</strong> {{ optional($bid->artisan->artisanProfile)->location ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                  <p class="mb-1"><strong>Submitted:</strong> {{ $bid->created_at->format('M d, Y') }}</p>
                                  <p class="mb-0"><strong>Updated:</strong> {{ $bid->updated_at->format('M d, Y') }}</p>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer border-0">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              @if ($bid->status === 'pending' && $requirement->status === 'open')
                                <form method="POST" action="{{ route('bids.accept', $bid) }}" class="d-inline">
                                  @csrf
                                  <button type="submit" class="btn btn-primary">
                                    <i class="ri-check-line me-1"></i>Accept Bid
                                  </button>
                                </form>
                              @elseif ($bid->status === 'accepted' && $requirement->status === 'awarded')
                                <a href="{{ route('bids.checkout', $bid) }}" class="btn btn-success">
                                  <i class="ri-secure-payment-line me-1"></i>Proceed to Payment
                                </a>
                              @endif
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                @endif
              </div>

              <script>
                // Simple polling for real-time updates
                setInterval(function() {
                  fetch(window.location.href + '?bids_partial=1')
                    .then(res => res.text())
                    .then(html => {
                      const parser = new DOMParser();
                      const doc = parser.parseFromString(html, 'text/html');
                      const newTable = doc.querySelector('#bids-table-container');
                      if (newTable) {
                        document.querySelector('#bids-table-container').innerHTML = newTable.innerHTML;
                      }
                    })
                    .catch(err => console.log('Update check skipped'));
                }, 5000);
              </script>
            </div>
          </div>
        @elseif(auth()->user() && auth()->user()->id !== $requirement->user_id && $requirement->status === 'open')
          <!-- Submit Bid Section -->
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white border-0 d-flex align-items-center">
              <i class="ri-auction-line me-2"></i>
              <h5 class="mb-0">Place Your Bid</h5>
            </div>
            <div class="card-body">
              <form method="POST" action="{{ route('bids.store', $requirement) }}">
                @csrf

                <div class="mb-4">
                  <label class="form-label fw-semibold">
                    <i class="ri-price-tag-line me-2 text-primary"></i>Your Bid Amount
                    <span class="text-danger">*</span>
                  </label>
                  <div class="input-group input-group-lg">
                    <span class="input-group-text">$</span>
                    <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                      placeholder="Enter your bid amount" step="0.01" min="0" required value="{{ old('amount') }}">
                    @error('amount')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                  </div>
                  <small class="text-muted d-block mt-2">Budget for this requirement: <strong>${{ number_format($requirement->budget, 2) }}</strong></small>
                </div>

                <div class="mb-4">
                  <label class="form-label fw-semibold">
                    <i class="ri-file-text-line me-2 text-primary"></i>Your Proposal
                    <span class="text-muted">(Optional)</span>
                  </label>
                  <textarea name="proposal" class="form-control @error('proposal') is-invalid @enderror"
                    rows="5" placeholder="Describe how you'll complete this requirement, your approach, timeline, and any other relevant details..."
                    maxlength="1000">{{ old('proposal') }}</textarea>
                  <small class="text-muted d-block mt-2">
                    <i class="ri-information-line me-1"></i>A detailed proposal increases your chances of winning the bid
                  </small>
                  @error('proposal')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                  <a href="{{ route('requirements.index') }}" class="btn btn-outline-secondary">
                    <i class="ri-arrow-left-line me-2"></i>Back
                  </a>
                  <button type="submit" class="btn btn-primary btn-lg">
                    <i class="ri-send-plane-2-line me-2"></i>Submit Bid
                  </button>
                </div>
              </form>
            </div>
          </div>
        @else
          <!-- Read-only View for Others -->
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-light border-0">
              <h5 class="mb-0">
                <i class="ri-auction-line me-2 text-primary"></i>Bids on This Requirement
              </h5>
            </div>
            <div class="card-body">
              <div class="text-center py-5">
                <i class="ri-lock-line" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3 mb-0">This requirement has been awarded. Bidding is closed.</p>
              </div>
            </div>
          </div>
        @endif
      </div>

      <!-- Right: Sidebar -->
      <div class="col-lg-4">
        <!-- Posted By Card -->
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-light border-0">
            <h6 class="mb-0">
              <i class="ri-user-line me-2 text-primary"></i>Posted By
            </h6>
          </div>
          <div class="card-body text-center">
            @if ($requirement->user->profile_photo_path)
              <img src="{{ asset('storage/' . $requirement->user->profile_photo_path) }}" alt="Profile"
                width="80" height="80" class="rounded-circle mb-3">
            @else
              <div class="avatar-initial rounded-circle bg-primary text-white mx-auto mb-3"
                style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                {{ substr($requirement->user->name, 0, 1) }}
              </div>
            @endif
            <h6 class="mb-1">{{ $requirement->user->name }}</h6>
            <p class="text-muted small mb-3">{{ $requirement->user->email }}</p>
            <button type="button" class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="modal"
              data-bs-target="#contactModal">
              <i class="ri-chat-3-line me-1"></i>Contact Client
            </button>
          </div>
        </div>

        <!-- Quick Stats Card -->
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-light border-0">
            <h6 class="mb-0">
              <i class="ri-bar-chart-line me-2 text-primary"></i>Quick Stats
            </h6>
          </div>
          <div class="card-body">
            <div class="mb-3 pb-3 border-bottom">
              <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small">Total Bids</span>
                <h5 class="mb-0 text-primary fw-bold">{{ $requirement->bids->count() }}</h5>
              </div>
            </div>
            <div class="mb-3 pb-3 border-bottom">
              <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small">Avg Bid Amount</span>
                @if ($requirement->bids->count() > 0)
                  <h5 class="mb-0 text-info fw-bold">${{ number_format($requirement->bids->avg('amount'), 2) }}</h5>
                @else
                  <span class="text-muted">N/A</span>
                @endif
              </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <span class="text-muted small">Highest Bid</span>
              @if ($requirement->bids->count() > 0)
                <h5 class="mb-0 text-success fw-bold">${{ number_format($requirement->bids->max('amount'), 2) }}</h5>
              @else
                <span class="text-muted">N/A</span>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Contact Modal -->
  <div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header border-0">
          <h5 class="modal-title">Contact {{ $requirement->user->name }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p class="text-muted">You can reach the client at:</p>
          <div class="card bg-light border-0">
            <div class="card-body">
              <p class="mb-2">
                <i class="ri-mail-line me-2 text-primary"></i>
                <strong>Email:</strong> {{ $requirement->user->email }}
              </p>
              @if ($requirement->user->phone)
                <p class="mb-0">
                  <i class="ri-phone-line me-2 text-primary"></i>
                  <strong>Phone:</strong> {{ $requirement->user->phone }}
                </p>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
