@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'My Profile - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('content')
  <x-alert />

  <!-- Profile Header -->
  <div class="card border-0 shadow-sm mb-6">
    <div class="card-body">
      <div class="row align-items-center g-4">
        <div class="col-auto">
          <div class="position-relative">
            <img
              src="{{ $artisanProfile->profile_photo_path ? asset('storage/' . $artisanProfile->profile_photo_path) : asset('assets/img/avatars/1.png') }}"
              alt="Profile" class="rounded-circle" width="120" height="120" />
            <button type="button" class="btn btn-sm btn-primary rounded-circle position-absolute bottom-0 end-0"
              data-bs-toggle="modal" data-bs-target="#changePhotoModal">
              <i class="icon-base ri ri-camera-fill"></i>
            </button>
          </div>
        </div>
        <div class="col">
          <div>
            <h4 class="mb-1">{{ $user->name }}</h4>
            <p class="text-muted mb-3">{{ ucfirst($artisanProfile->category ?? 'Artisan') }} • Member since
              {{ $artisanProfile->created_at->format('M Y') }}</p>
            <div class="d-flex gap-2 flex-wrap">
              <span class="badge {{ $isVerified ? 'bg-label-success' : 'bg-label-warning' }}"><i
                  class="icon-base ri ri-{{ $isVerified ? 'check' : 'close' }}-line me-1"></i>{{ $isVerified ? 'Verified' : 'Unverified' }}</span>
              <span class="badge bg-label-primary"><i class="icon-base ri ri-star-line me-1"></i>{{ $averageRating }}/5
                Rating</span>
              <span class="badge bg-label-info"><i class="icon-base ri ri-thumb-up-line me-1"></i>{{ $completionRate }}%
                Completion</span>
            </div>
          </div>
        </div>
        <div class="col-md-auto">
          <div class="text-center">
            <h5 class="mb-1">{{ $totalReviews }}</h5>
            <small class="text-muted">Total Reviews</small>
          </div>
          <div class="text-center border-start border-end px-4">
            <h5 class="mb-1">{{ $completedOrders }}</h5>
            <small class="text-muted">Orders Completed</small>
          </div>
          <div class="text-center">
            <h5 class="mb-1">ZWL {{ number_format($totalEarnings, 2) }}</h5>
            <small class="text-muted">Total Earnings</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Profile Tabs -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <button class="nav-link active" id="businessTab" data-bs-toggle="tab" data-bs-target="#businessContent"
            role="tab" aria-controls="businessContent" aria-selected="true">
            <i class="icon-base ri ri-briefcase-line me-2"></i>Business Profile
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link" id="personalTab" data-bs-toggle="tab" data-bs-target="#personalContent" role="tab"
            aria-controls="personalContent" aria-selected="false">
            <i class="icon-base ri ri-user-line me-2"></i>Personal Details
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link" id="socialTab" data-bs-toggle="tab" data-bs-target="#socialContent" role="tab"
            aria-controls="socialContent" aria-selected="false">
            <i class="icon-base ri ri-share-line me-2"></i>Social Links
          </button>
        </li>
      </ul>
    </div>

    <div class="card-body">
      <div class="tab-content">
        <!-- Business Profile Tab -->
        <div class="tab-pane fade show active" id="businessContent" role="tabpanel" aria-labelledby="businessTab">
          <div class="row g-4">
            <div class="col-md-8">
              <div class="mb-4">
                <label class="form-label fw-medium">Business Name</label>
                <p class="text-muted">{{ $artisanProfile->business_name ?? 'Not provided' }}</p>
              </div>
              <div class="mb-4">
                <label class="form-label fw-medium">Business Category</label>
                <div class="d-flex gap-2 flex-wrap">
                  <span class="badge bg-label-primary">{{ $artisanProfile->category ?? 'General Services' }}</span>
                </div>
              </div>
              <div class="mb-4">
                <label class="form-label fw-medium">Business Description</label>
                <p class="text-muted">{{ $artisanProfile->bio ?? 'No description provided' }}</p>
              </div>
              <div class="row g-4">
                <div class="col-md-6">
                  <label class="form-label fw-medium">Years of Experience</label>
                  <p class="text-muted">{{ $artisanProfile->years_of_experience ?? 'Not specified' }}
                    {{ ($artisanProfile->years_of_experience ?? 0) > 0 ? 'years' : '' }}</p>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-medium">Service Areas</label>
                  <p class="text-muted">{{ $artisanProfile->service_areas ?? 'Not specified' }}</p>
                </div>
              </div>
              <div class="mb-4">
                <label class="form-label fw-medium">Business Hours</label>
                <div class="table-responsive">
                  <table class="table table-sm table-borderless">
                    <tr>
                      <td>Monday - Friday:</td>
                      <td><strong>08:00 - 17:00</strong></td>
                    </tr>
                    <tr>
                      <td>Saturday:</td>
                      <td><strong>09:00 - 15:00</strong></td>
                    </tr>
                    <tr>
                      <td>Sunday:</td>
                      <td><strong>Closed</strong></td>
                    </tr>
                  </table>
                </div>
              </div>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editBusinessModal">
                <i class="icon-base ri ri-edit-line me-2"></i>Edit Business Profile
              </button>
            </div>
            <div class="col-md-4">
              <div class="card bg-light border-0">
                <div class="card-body">
                  <h6 class="card-title mb-3"><i class="icon-base ri ri-information-line me-2"></i>Business Stats</h6>
                  <div class="mb-3">
                    <small class="text-muted d-block">Member Since</small>
                    <strong>{{ $artisanProfile->created_at->format('M d, Y') }}</strong>
                  </div>
                  <div class="mb-3">
                    <small class="text-muted d-block">Account Status</small>
                    <span class="badge bg-label-success">Active</span>
                  </div>
                  <div class="mb-3">
                    <small class="text-muted d-block">Verification Status</small>
                    <span
                      class="badge {{ $isVerified ? 'bg-label-success' : 'bg-label-warning' }}">{{ $isVerified ? 'Verified' : 'Pending' }}</span>
                  </div>
                  <div class="mb-0">
                    <small class="text-muted d-block">Response Time</small>
                    <strong>
                      < 2 hours</strong>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Personal Details Tab -->
        <div class="tab-pane fade" id="personalContent" role="tabpanel" aria-labelledby="personalTab">
          <div class="row g-4">
            <div class="col-md-6">
              <label class="form-label fw-medium">Name</label>
              <p class="text-muted">{{ $user->name }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium">Email Address</label>
              <p class="text-muted">{{ $user->email }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium">Phone Number</label>
              <p class="text-muted">{{ $artisanProfile->phone ?? 'Not provided' }}</p>
            </div>
          </div>
          <button type="button" class="btn btn-primary mt-4" data-bs-toggle="modal"
            data-bs-target="#editPersonalModal">
            <i class="icon-base ri ri-edit-line me-2"></i>Edit Personal Details
          </button>
        </div>

        <!-- Social Links Tab -->
        <div class="tab-pane fade" id="socialContent" role="tabpanel" aria-labelledby="socialTab">
          <div class="row g-4">
            <div class="col-md-6">
              <label class="form-label fw-medium"><i
                  class="icon-base ri ri-facebook-circle-fill text-primary me-2"></i>Facebook Profile</label>
              <p class="text-muted">{{ $artisanProfile->social_links['facebook'] ?? 'Not added' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium"><i
                  class="icon-base ri ri-instagram-fill text-danger me-2"></i>Instagram Profile</label>
              <p class="text-muted">{{ $artisanProfile->social_links['instagram'] ?? 'Not added' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium"><i
                  class="icon-base ri ri-whatsapp-line text-success me-2"></i>WhatsApp</label>
              <p class="text-muted">{{ $artisanProfile->social_links['whatsapp'] ?? 'Not added' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium"><i
                  class="icon-base ri ri-links-line text-secondary me-2"></i>Website</label>
              <p class="text-muted">{{ $artisanProfile->social_links['website'] ?? 'Not added' }}</p>
            </div>
            <div class="col-12">
              <label class="form-label fw-medium"><i class="icon-base ri ri-linkedin-fill text-info me-2"></i>LinkedIn
                Profile</label>
              <p class="text-muted">{{ $artisanProfile->social_links['linkedin'] ?? 'Not added' }}</p>
            </div>
          </div>
          <button type="button" class="btn btn-primary mt-4" data-bs-toggle="modal"
            data-bs-target="#editSocialModal">
            <i class="icon-base ri ri-edit-line me-2"></i>Edit Social Links
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Change Photo Modal -->
  <div class="modal fade" id="changePhotoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-camera-line me-2 text-primary"></i>Change Profile Photo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="photoForm" action="{{ route('artisan-profile-photo') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
              <label class="form-label fw-medium">Upload New Photo</label>
              <div class="border-2 border-dashed rounded-3 p-5 text-center cursor-pointer bg-light"
                onclick="document.getElementById('photoInput').click()">
                <i class="icon-base ri ri-upload-cloud-2-line text-primary" style="font-size: 2rem;"></i>
                <p class="mb-0 mt-3"><strong>Click to upload</strong> or drag and drop</p>
                <small class="text-muted">PNG, JPG, GIF up to 2MB</small>
                <input type="file" id="photoInput" name="profile_photo" class="d-none"
                  accept="image/jpeg,image/png,image/jpg,image/gif" />
              </div>
            </div>
            <div class="mb-0">
              <label class="form-label fw-medium">Preview</label>
              <div class="text-center">
                <img
                  src="{{ $artisanProfile->profile_photo_path ? asset('storage/' . $artisanProfile->profile_photo_path) : asset('assets/img/avatars/1.png') }}"
                  alt="Preview" class="rounded-circle" width="100" height="100" id="photoPreview" />
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" form="photoForm">
            <i class="icon-base ri ri-upload-line me-2"></i>Upload Photo
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Business Modal -->
  <div class="modal fade" id="editBusinessModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-briefcase-line me-2 text-primary"></i>Edit Business Profile
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('artisan-profile-business') }}" id="businessForm">
            @csrf
            @method('PUT')
            <div class="mb-4">
              <label class="form-label fw-medium">Business Name *</label>
              <input type="text" name="business_name" class="form-control"
                value="{{ old('business_name', $artisanProfile->business_name) }}" required />
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium">Business Category *</label>
              <select name="category" class="form-select" required>
                <option value="">Select Category</option>
                @php
                  $categories = ['Plumbing', 'Electrical', 'Carpentry', 'Tailoring & Fashion', 'Painting', 'Welding', 'Masonry', 'Roofing', 'Tiling', 'General'];
                  $currentCategory = old('category', $artisanProfile->category);
                @endphp
                @foreach ($categories as $cat)
                  <option value="{{ $cat }}" {{ $currentCategory == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium">Business Description</label>
              <textarea name="bio" class="form-control" rows="4">{{ old('bio', $artisanProfile->bio) }}</textarea>
            </div>
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label fw-medium">Years of Experience</label>
                <input type="number" name="years_of_experience" class="form-control"
                  value="{{ old('years_of_experience', $artisanProfile->years_of_experience ?? 0) }}" min="0"
                  max="70" />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Service Areas</label>
                <input type="text" name="service_areas" class="form-control"
                  value="{{ old('service_areas', $artisanProfile->service_areas) }}"
                  placeholder="e.g., Harare, Bulawayo, Chitungwiza" />
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" form="businessForm">
            <i class="icon-base ri ri-check-line me-2"></i>Save Changes
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Personal Modal -->
  <div class="modal fade" id="editPersonalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-user-line me-2 text-primary"></i>Edit Personal Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('artisan-profile-personal') }}" id="personalForm">
            @csrf
            @method('PUT')
            <div class="row g-4">
              <div class="col-12">
                <label class="form-label fw-medium">Full Name *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                  required />
              </div>
              <div class="col-12">
                <label class="form-label fw-medium">Email Address *</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"
                  required />
              </div>
              <div class="col-12">
                <label class="form-label fw-medium">Phone Number</label>
                <input type="tel" name="phone" class="form-control"
                  value="{{ old('phone', $artisanProfile->phone) }}" />
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" form="personalForm">
            <i class="icon-base ri ri-check-line me-2"></i>Save Changes
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Bank Modal -->
  <!-- Edit Social Modal -->
  <div class="modal fade" id="editSocialModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-share-line me-2 text-primary"></i>Edit Social Links</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('artisan-profile-social') }}" id="socialForm">
            @csrf
            @method('PUT')
            <div class="mb-4">
              <label class="form-label fw-medium"><i
                  class="icon-base ri ri-facebook-circle-fill text-primary me-2"></i>Facebook Profile</label>
              <input type="text" name="facebook" class="form-control"
                value="{{ $artisanProfile->social_links['facebook'] ?? '' }}" placeholder="https://facebook.com/..." />
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium"><i
                  class="icon-base ri ri-instagram-fill text-danger me-2"></i>Instagram Profile</label>
              <input type="text" name="instagram" class="form-control"
                value="{{ $artisanProfile->social_links['instagram'] ?? '' }}" placeholder="@username" />
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium"><i
                  class="icon-base ri ri-whatsapp-line text-success me-2"></i>WhatsApp</label>
              <input type="tel" name="whatsapp" class="form-control"
                value="{{ $artisanProfile->social_links['whatsapp'] ?? '' }}" placeholder="+263..." />
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium"><i
                  class="icon-base ri ri-links-line text-secondary me-2"></i>Website</label>
              <input type="url" name="website" class="form-control"
                value="{{ $artisanProfile->social_links['website'] ?? '' }}" placeholder="https://www.example.com" />
            </div>
            <div class="mb-0">
              <label class="form-label fw-medium"><i class="icon-base ri ri-linkedin-fill text-info me-2"></i>LinkedIn
                Profile</label>
              <input type="text" name="linkedin" class="form-control"
                value="{{ $artisanProfile->social_links['linkedin'] ?? '' }}"
                placeholder="https://linkedin.com/in/..." />
            </div>
          </form>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" form="socialForm">
            <i class="icon-base ri ri-check-line me-2"></i>Save Changes
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- User Profile Content -->
  <div class="row g-6">
    <!-- Quick Actions Section -->
    <div class="col-12">
      <div class="card mb-6">
        <div class="card-body">
          <small class="card-text text-uppercase text-body-secondary small fw-bold mb-3 d-block">Quick Actions</small>
          <div class="row g-3">
            <div class="col-md-6 col-lg-3">
              <a href="{{ route('artisan-dashboard') }}" class="btn btn-outline-primary w-100 py-3">
                <i class="icon-base ri ri-dashboard-line fs-5 text-primary d-block mb-2"></i>
                <strong class="d-block">My Dashboard</strong>
                <small class="text-muted d-block">View overview</small>
              </a>
            </div>
            <div class="col-md-6 col-lg-3">
              <a href="{{ route('artisan-my-orders') }}" class="btn btn-outline-primary w-100 py-3">
                <i class="icon-base ri ri-shopping-cart-line fs-5 text-primary d-block mb-2"></i>
                <strong class="d-block">My Orders</strong>
                <small class="text-muted d-block">Manage orders</small>
              </a>
            </div>
            <div class="col-md-6 col-lg-3">
              <a href="{{ route('artisan-my-reviews') }}" class="btn btn-outline-primary w-100 py-3">
                <i class="icon-base ri ri-chat-3-line fs-5 text-primary d-block mb-2"></i>
                <strong class="d-block">My Reviews</strong>
                <small class="text-muted d-block">View feedback</small>
              </a>
            </div>
            <div class="col-md-6 col-lg-3">
              <button type="button" class="btn btn-outline-primary w-100 py-3" data-bs-toggle="modal"
                data-bs-target="#changePasswordModal">
                <i class="icon-base ri ri-lock-line fs-5 text-primary d-block mb-2"></i>
                <strong class="d-block">Security</strong>
                <small class="text-muted d-block">Change password</small>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Account Information - Left Column -->
    <div class="col-lg-6">
      <div class="card mb-6">
        <div class="card-body">
          <small class="card-text text-uppercase text-body-secondary small fw-bold mb-4 d-block">Account
            Information</small>
          <ul class="list-unstyled my-0">
            <li class="d-flex align-items-center mb-4">
              <i class="icon-base ri ri-user-3-line icon-24px text-primary"></i>
              <div class="ms-3">
                <small class="text-muted d-block">Full Name</small>
                <span class="fw-medium">{{ $user->name }}</span>
              </div>
            </li>
            <li class="d-flex align-items-center mb-4">
              <i class="icon-base ri ri-mail-open-line icon-24px text-primary"></i>
              <div class="ms-3">
                <small class="text-muted d-block">Email Address</small>
                <span class="fw-medium">{{ $user->email }}</span>
              </div>
            </li>
            <li class="d-flex align-items-center mb-4">
              <i class="icon-base ri ri-phone-line icon-24px text-primary"></i>
              <div class="ms-3">
                <small class="text-muted d-block">Phone Number</small>
                <span class="fw-medium">{{ $artisanProfile->phone ?? 'Not provided' }}</span>
              </div>
            </li>
            <li class="d-flex align-items-center mb-4">
              <i class="icon-base ri ri-map-pin-line icon-24px text-primary"></i>
              <div class="ms-3">
                <small class="text-muted d-block">Location</small>
                <span class="fw-medium">{{ $artisanProfile->city }}, Zimbabwe</span>
              </div>
            </li>
            <li class="d-flex align-items-center">
              <i class="icon-base ri ri-calendar-line icon-24px text-primary"></i>
              <div class="ms-3">
                <small class="text-muted d-block">Join Date</small>
                <span class="fw-medium">{{ $artisanProfile->created_at->format('d M Y') }}</span>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Account Status - Right Column -->
    <div class="col-lg-6">
      <div class="card mb-6">
        <div class="card-body">
          <small class="card-text text-uppercase text-body-secondary small fw-bold mb-4 d-block">Account Status</small>
          <div class="row g-3 mb-4">
            <div class="col-6">
              <div class="bg-light rounded-3 p-3 text-center">
                <small class="text-muted d-block mb-2">Email Verified</small>
                <span
                  class="badge {{ $user->email_verified_at ? 'bg-success' : 'bg-warning' }}">{{ $user->email_verified_at ? 'Verified' : 'Pending' }}</span>
              </div>
            </div>
            <div class="col-6">
              <div class="bg-light rounded-3 p-3 text-center">
                <small class="text-muted d-block mb-2">Identity Verified</small>
                <span
                  class="badge {{ $isVerified ? 'bg-success' : 'bg-warning' }}">{{ $isVerified ? 'Verified' : 'Pending' }}</span>
              </div>
            </div>
            <div class="col-6">
              <div class="bg-light rounded-3 p-3 text-center">
                <small class="text-muted d-block mb-2">Phone Verified</small>
                <span class="badge bg-success">Verified</span>
              </div>
            </div>
            <div class="col-6">
              <div class="bg-light rounded-3 p-3 text-center">
                <small class="text-muted d-block mb-2">Payment Method</small>
                <span class="badge bg-info">Added</span>
              </div>
            </div>
          </div>
          <div class="alert alert-success mb-0" role="alert">
            <i class="icon-base ri ri-shield-check-line me-2"></i>
            <strong>Security Status:</strong> Your account is secure and all verifications are in place.
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Update Personal Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="editProfileForm">
              <div class="row g-4">
                <!-- Profile Picture -->
                <div class="col-12">
                  <div class="card bg-light p-4">
                    <div class="text-center">
                      <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Profile Picture"
                        class="rounded-circle mb-3" width="120" height="120" />
                      <h6 class="mb-3">John Doe</h6>
                      <input type="file" class="form-control" id="profilePictureInput" accept="image/*"
                        style="display: none;" />
                      <button type="button" class="btn btn-sm btn-primary"
                        onclick="document.getElementById('profilePictureInput').click()">
                        <i class="icon-base ri ri-camera-line me-1"></i>Change Picture
                      </button>
                    </div>
                  </div>
                </div>

                <!-- First Name -->
                <div class="col-md-6">
                  <label class="form-label">First Name</label>
                  <input type="text" class="form-control" placeholder="John" value="John" />
                </div>

                <!-- Last Name -->
                <div class="col-md-6">
                  <label class="form-label">Last Name</label>
                  <input type="text" class="form-control" placeholder="Doe" value="Doe" />
                </div>

                <!-- Email -->
                <div class="col-12">
                  <label class="form-label">Email Address</label>
                  <input type="email" class="form-control" placeholder="john.doe@example.com"
                    value="john.doe@example.com" />
                </div>

                <!-- Phone -->
                <div class="col-md-6">
                  <label class="form-label">Phone Number</label>
                  <input type="tel" class="form-control" placeholder="+263 78 123 4567"
                    value="+263 78 123 4567" />
                </div>

                <!-- Date of Birth -->
                <div class="col-md-6">
                  <label class="form-label">Date of Birth</label>
                  <input type="date" class="form-control" value="1990-01-15" />
                </div>

                <!-- Country -->
                <div class="col-md-6">
                  <label class="form-label">Country</label>
                  <select class="form-select">
                    <option value="">Select Country</option>
                    <option value="zimbabwe" selected>Zimbabwe</option>
                    <option value="south-africa">South Africa</option>
                    <option value="botswana">Botswana</option>
                    <option value="zambia">Zambia</option>
                    <option value="malawi">Malawi</option>
                  </select>
                </div>

                <!-- City -->
                <div class="col-md-6">
                  <label class="form-label">City</label>
                  <input type="text" class="form-control" placeholder="Harare" value="Harare" />
                </div>

                <!-- Bio -->
                <div class="col-12">
                  <label class="form-label">Bio / About Me</label>
                  <textarea class="form-control" rows="4" placeholder="Tell us about yourself...">I'm a busy professional looking for reliable artisans to help with home and office projects.</textarea>
                </div>

                <!-- Visibility Toggle -->
                <div class="col-12">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="publicProfileSwitch" checked />
                    <label class="form-check-label" for="publicProfileSwitch">
                      Make my profile public (Other users can see your rating and reviews)
                    </label>
                  </div>
                </div>

                <!-- Verification Badge -->
                <div class="col-12">
                  <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="icon-base ri ri-check-double-line me-2"></i>
                    <div>Your account has been verified. All details are secure.</div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="saveProfileChanges()">
              <i class="icon-base ri ri-save-line me-1"></i>Save Changes
            </button>
          </div>
        </div>
      </div>
    </div>
    <!--/ Edit Profile Modal -->

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Change Password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="changePasswordForm" method="POST" action="{{ route('artisan-profile-password') }}">
              @csrf
              <!-- Current Password -->
              <div class="mb-4">
                <label class="form-label">Current Password</label>
                <div class="input-group">
                  <input type="password" class="form-control" name="current_password" id="currentPassword"
                    placeholder="Enter current password" required />
                  <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                    <i class="icon-base ri ri-eye-line"></i>
                  </button>
                </div>
                <small class="text-muted d-block mt-2">Enter your current password for verification</small>
              </div>

              <!-- New Password -->
              <div class="mb-4">
                <label class="form-label">New Password</label>
                <div class="input-group">
                  <input type="password" class="form-control" name="new_password" id="newPassword"
                    placeholder="Enter new password" required />
                  <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                    <i class="icon-base ri ri-eye-line"></i>
                  </button>
                </div>
                <small class="text-muted d-block mt-2">Password must be at least 8 characters long</small>

                <!-- Password Strength Indicator -->
                <div class="mt-3">
                  <div class="d-flex justify-content-between mb-2">
                    <small>Password Strength</small>
                    <small id="strengthText" class="text-danger">Weak</small>
                  </div>
                  <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-danger" id="strengthBar" style="width: 0%;"></div>
                  </div>
                </div>
              </div>

              <!-- Confirm Password -->
              <div class="mb-4">
                <label class="form-label">Confirm New Password</label>
                <div class="input-group">
                  <input type="password" class="form-control" name="new_password_confirmation" id="confirmPassword"
                    placeholder="Confirm new password" required />
                  <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                    <i class="icon-base ri ri-eye-line"></i>
                  </button>
                </div>
                <small id="matchWarning" class="text-danger d-none d-block mt-2">Passwords do not match</small>
              </div>

              <!-- Password Requirements -->
              <div class="card bg-light p-3 mb-4">
                <h6 class="mb-2">Password Requirements</h6>
                <ul class="list-unstyled mb-0 small">
                  <li class="mb-2">
                    <span id="req-length" class="text-danger">
                      <i class="icon-base ri ri-close-line me-1"></i>At least 8 characters
                    </span>
                  </li>
                  <li class="mb-2">
                    <span id="req-uppercase" class="text-danger">
                      <i class="icon-base ri ri-close-line me-1"></i>One uppercase letter (A-Z)
                    </span>
                  </li>
                  <li class="mb-2">
                    <span id="req-lowercase" class="text-danger">
                      <i class="icon-base ri ri-close-line me-1"></i>One lowercase letter (a-z)
                    </span>
                  </li>
                  <li>
                    <span id="req-number" class="text-danger">
                      <i class="icon-base ri ri-close-line me-1"></i>One number (0-9)
                    </span>
                  </li>
                </ul>
              </div>

              <!-- Security Notice -->
              <div class="alert alert-warning d-flex align-items-start" role="alert">
                <i class="icon-base ri ri-alert-line me-2 mt-1"></i>
                <div>
                  <strong>Security Notice:</strong> Your password will be changed across all active sessions.
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="changePasswordBtn" form="changePasswordForm" disabled>
              <i class="icon-base ri ri-shield-check-line me-1"></i>Update Password
            </button>
          </div>
        </div>
      </div>
    </div>
    <!--/ Change Password Modal -->

    <!-- Password Changed Success Modal -->
    <div class="modal fade" id="passwordChangedModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body text-center py-5">
            <div class="mb-4">
              <i class="icon-base ri ri-checkbox-circle-line icon-64px text-success"></i>
            </div>
            <h5 class="mb-3">Password Changed Successfully!</h5>
            <p class="text-muted mb-4">Your password has been updated. For security purposes, you may need to log in
              again
              on other devices.</p>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Done</button>
          </div>
        </div>
      </div>
    </div>
    <!--/ Password Changed Success Modal -->
  @endsection

  @section('page-script')
    <script>
      // Photo upload preview
      document.getElementById('photoInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(event) {
            document.getElementById('photoPreview').src = event.target.result;
          };
          reader.readAsDataURL(file);
        }
      });

      // Password strength validation
      const newPasswordInput = document.getElementById('newPassword');
      const strengthBar = document.getElementById('strengthBar');
      const strengthText = document.getElementById('strengthText');
      const matchWarning = document.getElementById('matchWarning');
      const changePasswordBtn = document.getElementById('changePasswordBtn');

      function validatePassword() {
        const password = newPasswordInput.value;
        let strength = 0;
        let requirements = {
          length: password.length >= 8,
          uppercase: /[A-Z]/.test(password),
          lowercase: /[a-z]/.test(password),
          number: /[0-9]/.test(password)
        };

        // Update requirement indicators
        document.getElementById('req-length').className = requirements.length ? 'text-success' : 'text-danger';
        document.getElementById('req-uppercase').className = requirements.uppercase ? 'text-success' : 'text-danger';
        document.getElementById('req-lowercase').className = requirements.lowercase ? 'text-success' : 'text-danger';
        document.getElementById('req-number').className = requirements.number ? 'text-success' : 'text-danger';

        // Calculate strength
        strength += requirements.length ? 25 : 0;
        strength += requirements.uppercase ? 25 : 0;
        strength += requirements.lowercase ? 25 : 0;
        strength += requirements.number ? 25 : 0;

        // Update strength bar
        strengthBar.style.width = strength + '%';
        if (strength < 50) {
          strengthBar.className = 'progress-bar bg-danger';
          strengthText.textContent = 'Weak';
          strengthText.className = 'text-danger';
        } else if (strength < 75) {
          strengthBar.className = 'progress-bar bg-warning';
          strengthText.textContent = 'Fair';
          strengthText.className = 'text-warning';
        } else {
          strengthBar.className = 'progress-bar bg-success';
          strengthText.textContent = 'Strong';
          strengthText.className = 'text-success';
        }

        // Check password match
        const confirmPassword = document.getElementById('confirmPassword').value;
        if (confirmPassword && password !== confirmPassword) {
          matchWarning.classList.remove('d-none');
        } else {
          matchWarning.classList.add('d-none');
        }

        // Enable/disable button
        const currentPassword = document.getElementById('currentPassword').value;
        const isValid = currentPassword && strength >= 75 && password === confirmPassword;
        changePasswordBtn.disabled = !isValid;
      }

      newPasswordInput.addEventListener('input', validatePassword);
      document.getElementById('confirmPassword').addEventListener('input', validatePassword);
      document.getElementById('currentPassword').addEventListener('input', validatePassword);

      // Toggle password visibility
      function setupPasswordToggle(inputId, buttonId) {
        const input = document.getElementById(inputId);
        const button = document.getElementById(buttonId);
        button.addEventListener('click', function() {
          if (input.type === 'password') {
            input.type = 'text';
            button.innerHTML = '<i class="icon-base ri ri-eye-off-line"></i>';
          } else {
            input.type = 'password';
            button.innerHTML = '<i class="icon-base ri ri-eye-line"></i>';
          }
        });
      }

      setupPasswordToggle('currentPassword', 'toggleCurrentPassword');
      setupPasswordToggle('newPassword', 'toggleNewPassword');
      setupPasswordToggle('confirmPassword', 'toggleConfirmPassword');
    </script>
  @endsection
