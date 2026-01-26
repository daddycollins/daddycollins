@extends('layouts/layoutMaster')

@section('title', 'My Profile - ArtisanConnect')

<!-- Vendor Styles -->
@section('vendor-style')
  @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection

<!-- Page Styles -->
@section('page-style')
  @vite(['resources/assets/vendor/scss/pages/page-profile.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
  @vite(['resources/assets/vendor/libs/select2/select2.js'])
@endsection

@section('content')
  <!-- Header -->
  <div class="row">
    <div class="col-12">
      <div class="card mb-6">
        <div class="user-profile-header-banner">
          <img src="{{ asset('assets/img/pages/profile-banner.png') }}" alt="Banner image" class="rounded-top" />
        </div>
        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-5">
          <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
            <img src="{{ asset('assets/img/avatars/1.png') }}" alt="user image"
              class="d-block h-auto ms-0 ms-sm-5 rounded-4 user-profile-img" />
          </div>
          <div class="flex-grow-1 mt-4 mt-sm-12">
            <div
              class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-6">
              <div class="user-profile-info">
                <h4 class="mb-2">{{ $user->name }}</h4>
                <ul
                  class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4">
                  <li class="list-inline-item">
                    <i class="icon-base ri ri-mail-line me-2 icon-24px"></i>
                    <span class="fw-medium">{{ $user->email }}</span>
                  </li>
                  <li class="list-inline-item">
                    <i class="icon-base ri ri-calendar-line me-2 icon-24px"></i>
                    <span class="fw-medium">Member since {{ $user->created_at->format('M Y') }}</span>
                  </li>
                  @if ($user->email_verified_at)
                    <li class="list-inline-item">
                      <i class="icon-base ri ri-check-double-line me-2 icon-24px text-success"></i>
                      <span class="fw-medium">Verified</span>
                    </li>
                  @endif
                </ul>
              </div>
              <div class="d-flex gap-2">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                  <i class="icon-base ri ri-edit-line icon-16px me-2"></i>Edit Profile
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Header -->

  <!-- User Profile Content -->
  <div class="row g-6">
    <!-- Sidebar -->
    <div class="col-xl-4 col-lg-5 col-md-5">
      <!-- About User -->
      <div class="card mb-6">
        <div class="card-body">
          <small class="card-text text-uppercase text-body-secondary small fw-bold mb-3 d-block">Account
            Information</small>
          <ul class="list-unstyled my-0">
            <li class="d-flex align-items-center mb-4">
              <i class="icon-base ri ri-user-3-line icon-24px"></i>
              <span class="fw-medium mx-2">Full Name:</span>
              <span>{{ $user->name }}</span>
            </li>
            <li class="d-flex align-items-center mb-4">
              <i class="icon-base ri ri-mail-open-line icon-24px"></i>
              <span class="fw-medium mx-2">Email:</span>
              <span>{{ $user->email }}</span>
            </li>
            <li class="d-flex align-items-center mb-4">
              <i class="icon-base ri ri-phone-line icon-24px"></i>
              <span class="fw-medium mx-2">Phone:</span>
              <span>{{ $user->phone ?? 'Not provided' }}</span>
            </li>
            <li class="d-flex align-items-center mb-4">
              <i class="icon-base ri ri-shield-user-line icon-24px"></i>
              <span class="fw-medium mx-2">Role:</span>
              <span class="badge bg-label-primary">{{ ucfirst($user->role) }}</span>
            </li>
            <li class="d-flex align-items-center">
              <i class="icon-base ri ri-calendar-line icon-24px"></i>
              <span class="fw-medium mx-2">Join Date:</span>
              <span>{{ $user->created_at->format('d M Y') }}</span>
            </li>
          </ul>
        </div>
      </div>
      <!--/ About User -->

      <!-- Account Status -->
      <div class="card mb-6">
        <div class="card-body">
          <small class="card-text text-uppercase text-body-secondary small fw-bold mb-3 d-block">Account Status</small>
          <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="small">Email Verified</span>
              @if ($user->email_verified_at)
                <span class="badge bg-success">Verified</span>
              @else
                <span class="badge bg-warning">Pending</span>
              @endif
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="small">Account Status</span>
              @if ($user->status === 'active')
                <span class="badge bg-success">Active</span>
              @else
                <span class="badge bg-danger">{{ ucfirst($user->status ?? 'Inactive') }}</span>
              @endif
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <span class="small">Phone Number</span>
              @if ($user->phone)
                <span class="badge bg-success">Added</span>
              @else
                <span class="badge bg-secondary">Not Added</span>
              @endif
            </div>
          </div>
          <button class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="modal"
            data-bs-target="#changePasswordModal">
            <i class="icon-base ri ri-lock-line me-1"></i>Change Password
          </button>
        </div>
      </div>
      <!--/ Account Status -->

      <!-- Quick Actions -->
      <div class="card">
        <div class="card-body">
          <small class="card-text text-uppercase text-body-secondary small fw-bold mb-3 d-block">Quick Actions</small>
          <div class="d-grid gap-2">
            <a href="{{ route('user-dashboard') }}" class="btn btn-outline-primary btn-sm">
              <i class="icon-base ri ri-dashboard-line me-1"></i>My Dashboard
            </a>
            <a href="{{ route('user-my-orders') }}" class="btn btn-outline-primary btn-sm">
              <i class="icon-base ri ri-shopping-cart-line me-1"></i>My Orders
            </a>
            <a href="{{ route('user-create-review') }}" class="btn btn-outline-primary btn-sm">
              <i class="icon-base ri ri-chat-3-line me-1"></i>My Reviews
            </a>
            <a href="{{ route('user-browse-artisans') }}" class="btn btn-outline-primary btn-sm">
              <i class="icon-base ri ri-search-line me-1"></i>Browse Artisans
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="col-xl-8 col-lg-7 col-md-7">
      <!-- Account Settings Card -->
      <div class="card mb-6">
        <div class="card-header">
          <h5 class="card-title mb-0">Account Settings</h5>
        </div>
        <div class="card-body">
          <div class="row g-4">
            <!-- Personal Information -->
            <div class="col-12">
              <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded">
                <div class="d-flex align-items-center gap-3">
                  <div class="avatar bg-label-primary">
                    <div class="avatar-initial rounded"><i class="icon-base ri ri-user-settings-line icon-24px"></i>
                    </div>
                  </div>
                  <div>
                    <h6 class="mb-1">Personal Information</h6>
                    <small class="text-muted">Update your name, email, and phone number</small>
                  </div>
                </div>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                  Edit
                </button>
              </div>
            </div>

            <!-- Security Settings -->
            <div class="col-12">
              <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded">
                <div class="d-flex align-items-center gap-3">
                  <div class="avatar bg-label-warning">
                    <div class="avatar-initial rounded"><i class="icon-base ri ri-lock-password-line icon-24px"></i>
                    </div>
                  </div>
                  <div>
                    <h6 class="mb-1">Password & Security</h6>
                    <small class="text-muted">Change your password and secure your account</small>
                  </div>
                </div>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                  Update
                </button>
              </div>
            </div>

            <!-- Email Verification -->
            <div class="col-12">
              <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded">
                <div class="d-flex align-items-center gap-3">
                  <div class="avatar {{ $user->email_verified_at ? 'bg-label-success' : 'bg-label-danger' }}">
                    <div class="avatar-initial rounded"><i class="icon-base ri ri-mail-check-line icon-24px"></i></div>
                  </div>
                  <div>
                    <h6 class="mb-1">Email Verification</h6>
                    @if ($user->email_verified_at)
                      <small class="text-success">Your email has been verified on
                        {{ $user->email_verified_at->format('M d, Y') }}</small>
                    @else
                      <small class="text-danger">Your email is not verified yet</small>
                    @endif
                  </div>
                </div>
                @if (!$user->email_verified_at)
                  <button class="btn btn-sm btn-warning">
                    Verify Now
                  </button>
                @else
                  <span class="badge bg-success">Verified</span>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Account Activity -->
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Account Details</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td class="text-muted" style="width: 200px;">Account ID</td>
                  <td><strong>#{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}</strong></td>
                </tr>
                <tr>
                  <td class="text-muted">Full Name</td>
                  <td>{{ $user->name }}</td>
                </tr>
                <tr>
                  <td class="text-muted">Email Address</td>
                  <td>{{ $user->email }}</td>
                </tr>
                <tr>
                  <td class="text-muted">Phone Number</td>
                  <td>{{ $user->phone ?? 'Not provided' }}</td>
                </tr>
                <tr>
                  <td class="text-muted">Account Type</td>
                  <td><span class="badge bg-label-primary">{{ ucfirst($user->role) }}</span></td>
                </tr>
                <tr>
                  <td class="text-muted">Account Status</td>
                  <td>
                    @if ($user->status === 'active')
                      <span class="badge bg-success">Active</span>
                    @else
                      <span class="badge bg-danger">{{ ucfirst($user->status ?? 'Inactive') }}</span>
                    @endif
                  </td>
                </tr>
                <tr>
                  <td class="text-muted">Member Since</td>
                  <td>{{ $user->created_at->format('F d, Y') }}</td>
                </tr>
                <tr>
                  <td class="text-muted">Last Updated</td>
                  <td>{{ $user->updated_at->format('F d, Y \a\t h:i A') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ User Profile Content -->

  <!-- Edit Profile Modal -->
  <div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Update Personal Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('user-profile-update') }}" method="POST" id="editProfileForm">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="row g-4">
              <!-- First Name -->
              <div class="col-md-6">
                <label class="form-label">First Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="first_name" value="{{ $firstName }}" required />
              </div>

              <!-- Last Name -->
              <div class="col-md-6">
                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="last_name" value="{{ $lastName }}" required />
              </div>

              <!-- Email -->
              <div class="col-12">
                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email" value="{{ $user->email }}" required />
                <small class="text-muted">Changing your email will require re-verification</small>
              </div>

              <!-- Phone -->
              <div class="col-12">
                <label class="form-label">Phone Number</label>
                <input type="tel" class="form-control" name="phone" value="{{ $user->phone }}"
                  placeholder="+263 78 123 4567" />
              </div>

              <!-- Current Info -->
              <div class="col-12">
                <div class="alert alert-info d-flex align-items-center mb-0" role="alert">
                  <i class="icon-base ri ri-information-line me-2"></i>
                  <div>
                    <strong>Account ID:</strong> #{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }} |
                    <strong>Role:</strong> {{ ucfirst($user->role) }} |
                    <strong>Status:</strong> {{ ucfirst($user->status ?? 'Active') }}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <i class="icon-base ri ri-save-line me-1"></i>Save Changes
            </button>
          </div>
        </form>
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
        <form action="{{ route('user-password-change') }}" method="POST" id="changePasswordForm">
          @csrf
          <div class="modal-body">
            <!-- Current Password -->
            <div class="mb-4">
              <label class="form-label">Current Password <span class="text-danger">*</span></label>
              <div class="input-group">
                <input type="password" class="form-control" name="current_password" id="currentPassword"
                  placeholder="Enter current password" required />
                <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                  <i class="icon-base ri ri-eye-line"></i>
                </button>
              </div>
            </div>

            <!-- New Password -->
            <div class="mb-4">
              <label class="form-label">New Password <span class="text-danger">*</span></label>
              <div class="input-group">
                <input type="password" class="form-control" name="password" id="newPassword"
                  placeholder="Enter new password" required />
                <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                  <i class="icon-base ri ri-eye-line"></i>
                </button>
              </div>
              <small class="text-muted d-block mt-2">Password must be at least 8 characters</small>

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
              <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>
              <div class="input-group">
                <input type="password" class="form-control" name="password_confirmation" id="confirmPassword"
                  placeholder="Confirm new password" required />
                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                  <i class="icon-base ri ri-eye-line"></i>
                </button>
              </div>
              <small id="matchWarning" class="text-danger d-none d-block mt-2">Passwords do not match</small>
            </div>

            <!-- Password Requirements -->
            <div class="card bg-light p-3">
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
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="changePasswordBtn" disabled>
              <i class="icon-base ri ri-shield-check-line me-1"></i>Update Password
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--/ Change Password Modal -->

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Password strength validation
      const newPasswordInput = document.getElementById('newPassword');
      const confirmPasswordInput = document.getElementById('confirmPassword');
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
        updateRequirement('req-length', requirements.length);
        updateRequirement('req-uppercase', requirements.uppercase);
        updateRequirement('req-lowercase', requirements.lowercase);
        updateRequirement('req-number', requirements.number);

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
        const confirmPassword = confirmPasswordInput.value;
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

      function updateRequirement(id, met) {
        const el = document.getElementById(id);
        if (met) {
          el.className = 'text-success';
          el.innerHTML = '<i class="icon-base ri ri-check-line me-1"></i>' + el.textContent.replace(/^[^\w]*/, '');
        } else {
          el.className = 'text-danger';
          el.innerHTML = '<i class="icon-base ri ri-close-line me-1"></i>' + el.textContent.replace(/^[^\w]*/, '');
        }
      }

      newPasswordInput.addEventListener('input', validatePassword);
      confirmPasswordInput.addEventListener('input', validatePassword);
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
    });
  </script>
@endsection
