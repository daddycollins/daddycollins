@extends('layouts/layoutMaster')

@section('title', 'My Profile - ArtisanConnect')

<!-- Vendor Styles -->
@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection

<!-- Page Styles -->
@section('page-style')
  @vite(['resources/assets/vendor/scss/pages/page-profile.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/apex-charts/apexcharts.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
  @vite(['resources/assets/js/pages-profile-user.js'])
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
                <h4 class="mb-2">John Doe</h4>
                <ul
                  class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4">
                  <li class="list-inline-item"><i class="icon-base ri ri-map-pin-line me-2 icon-24px"></i><span
                      class="fw-medium">Harare, Zimbabwe</span></li>
                  <li class="list-inline-item"><i class="icon-base ri ri-calendar-line me-2 icon-24px"></i><span
                      class="fw-medium">Member since Jan 2024</span></li>
                  <li class="list-inline-item"><i
                      class="icon-base ri ri-check-double-line me-2 icon-24px text-success"></i><span
                      class="fw-medium">Verified</span></li>
                </ul>
              </div>
              <div class="d-flex gap-2">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal"> <i
                    class="icon-base ri ri-edit-line icon-16px me-2"></i>Edit Profile </button>
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
            <li class="d-flex align-items-center mb-4"><i class="icon-base ri ri-user-3-line icon-24px"></i><span
                class="fw-medium mx-2">Full Name:</span> <span>John Doe</span></li>
            <li class="d-flex align-items-center mb-4"><i class="icon-base ri ri-mail-open-line icon-24px"></i><span
                class="fw-medium mx-2">Email:</span> <span>john.doe@example.com</span></li>
            <li class="d-flex align-items-center mb-4"><i class="icon-base ri ri-phone-line icon-24px"></i><span
                class="fw-medium mx-2">Phone:</span> <span>+263 78 123 4567</span></li>
            <li class="d-flex align-items-center mb-4"><i class="icon-base ri ri-map-pin-line icon-24px"></i><span
                class="fw-medium mx-2">Location:</span> <span>Harare, Zimbabwe</span></li>
            <li class="d-flex align-items-center"><i class="icon-base ri ri-calendar-line icon-24px"></i><span
                class="fw-medium mx-2">Join Date:</span> <span>15 Jan 2024</span></li>
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
              <span class="badge bg-success">Verified</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="small">Identity Verified</span>
              <span class="badge bg-success">Verified</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="small">Phone Verified</span>
              <span class="badge bg-success">Verified</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <span class="small">Payment Method</span>
              <span class="badge bg-info">Added</span>
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
            <a href="{{ url('apps/client-dashboard') }}" class="btn btn-outline-primary btn-sm">
              <i class="icon-base ri ri-dashboard-line me-1"></i>My Dashboard
            </a>
            <a href="{{ url('apps/my-orders') }}" class="btn btn-outline-primary btn-sm">
              <i class="icon-base ri ri-shopping-cart-line me-1"></i>My Orders
            </a>
            <a href="{{ url('apps/artisan-review') }}" class="btn btn-outline-primary btn-sm">
              <i class="icon-base ri ri-chat-3-line me-1"></i>My Reviews
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="col-xl-8 col-lg-7 col-md-7">
      <!-- Statistics Cards -->
      <div class="row g-4 mb-6">
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between">
                <div>
                  <h6 class="mb-2 text-muted">Total Orders</h6>
                  <h4 class="mb-0">24</h4>
                </div>
                <div class="avatar bg-label-primary">
                  <div class="avatar-initial rounded"><i class="icon-base ri ri-shopping-bag-line icon-24px"></i></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between">
                <div>
                  <h6 class="mb-2 text-muted">Total Spent</h6>
                  <h4 class="mb-0">ZWL 15,240</h4>
                </div>
                <div class="avatar bg-label-success">
                  <div class="avatar-initial rounded"><i class="icon-base ri ri-money-dollar-circle-line icon-24px"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between">
                <div>
                  <h6 class="mb-2 text-muted">Favorite Artisans</h6>
                  <h4 class="mb-0">8</h4>
                </div>
                <div class="avatar bg-label-warning">
                  <div class="avatar-initial rounded"><i class="icon-base ri ri-star-line icon-24px"></i></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between">
                <div>
                  <h6 class="mb-2 text-muted">Average Rating Given</h6>
                  <h4 class="mb-0">4.6/5</h4>
                </div>
                <div class="avatar bg-label-info">
                  <div class="avatar-initial rounded"><i class="icon-base ri ri-feedback-line icon-24px"></i></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Orders -->
      <div class="card mb-6">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">Recent Orders</h5>
          <a href="{{ url('apps/my-orders') }}" class="btn btn-sm btn-primary">View All</a>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>Order ID</th>
                <th>Artisan</th>
                <th>Service</th>
                <th>Amount</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="badge bg-label-primary">#ORD-001</span></td>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Avatar" class="rounded-circle me-2"
                      width="32" height="32" />
                    <span>John Mbewe</span>
                  </div>
                </td>
                <td>Plumbing Repair</td>
                <td>ZWL 450</td>
                <td><span class="badge bg-label-success">Completed</span></td>
              </tr>
              <tr>
                <td><span class="badge bg-label-primary">#ORD-002</span></td>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/img/avatars/3.png') }}" alt="Avatar" class="rounded-circle me-2"
                      width="32" height="32" />
                    <span>Grace Muleya</span>
                  </div>
                </td>
                <td>Custom Tailoring</td>
                <td>ZWL 800</td>
                <td><span class="badge bg-label-success">Completed</span></td>
              </tr>
              <tr>
                <td><span class="badge bg-label-primary">#ORD-003</span></td>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/img/avatars/4.png') }}" alt="Avatar" class="rounded-circle me-2"
                      width="32" height="32" />
                    <span>Peter Nkomo</span>
                  </div>
                </td>
                <td>Furniture Making</td>
                <td>ZWL 2,500</td>
                <td><span class="badge bg-label-warning">In Progress</span></td>
              </tr>
              <tr>
                <td><span class="badge bg-label-primary">#ORD-004</span></td>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/img/avatars/5.png') }}" alt="Avatar" class="rounded-circle me-2"
                      width="32" height="32" />
                    <span>Tendai Moyo</span>
                  </div>
                </td>
                <td>Electrical Installation</td>
                <td>ZWL 1,200</td>
                <td><span class="badge bg-label-info">Pending</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Favorite Artisans -->
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">Favorite Artisans</h5>
          <a href="{{ url('apps/browse-artisans') }}" class="btn btn-sm btn-primary">Browse More</a>
        </div>
        <div class="card-body">
          <div class="row g-4">
            <div class="col-md-6">
              <div class="d-flex align-items-center">
                <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Artisan" class="rounded-circle me-3"
                  width="48" height="48" />
                <div class="flex-grow-1">
                  <h6 class="mb-1">John Mbewe</h6>
                  <p class="text-muted small mb-1">Plumbing & Repairs</p>
                  <small class="text-warning">
                    <i class="icon-base ri ri-star-fill icon-14px"></i>
                    <i class="icon-base ri ri-star-fill icon-14px"></i>
                    <i class="icon-base ri ri-star-fill icon-14px"></i>
                    <i class="icon-base ri ri-star-fill icon-14px"></i>
                    <i class="icon-base ri ri-star-half-fill icon-14px"></i>
                    4.8
                  </small>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex align-items-center">
                <img src="{{ asset('assets/img/avatars/3.png') }}" alt="Artisan" class="rounded-circle me-3"
                  width="48" height="48" />
                <div class="flex-grow-1">
                  <h6 class="mb-1">Grace Muleya</h6>
                  <p class="text-muted small mb-1">Tailoring & Fashion</p>
                  <small class="text-warning">
                    <i class="icon-base ri ri-star-fill icon-14px"></i>
                    <i class="icon-base ri ri-star-fill icon-14px"></i>
                    <i class="icon-base ri ri-star-fill icon-14px"></i>
                    <i class="icon-base ri ri-star-fill icon-14px"></i>
                    <i class="icon-base ri ri-star-fill icon-14px"></i>
                    5.0
                  </small>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex align-items-center">
                <img src="{{ asset('assets/img/avatars/4.png') }}" alt="Artisan" class="rounded-circle me-3"
                  width="48" height="48" />
                <div class="flex-grow-1">
                  <h6 class="mb-1">Peter Nkomo</h6>
                  <p class="text-muted small mb-1">Carpentry & Woodwork</p>
                  <small class="text-warning">
                    <i class="icon-base ri ri-star-fill icon-14px"></i>
                    <i class="icon-base ri ri-star-fill icon-14px"></i>
                    <i class="icon-base ri ri-star-fill icon-14px"></i>
                    <i class="icon-base ri ri-star-fill icon-14px"></i>
                    <i class="icon-base ri ri-star-line icon-14px"></i>
                    4.3
                  </small>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex align-items-center">
                <img src="{{ asset('assets/img/avatars/5.png') }}" alt="Artisan" class="rounded-circle me-3"
                  width="48" height="48" />
                <div class="flex-grow-1">
                  <h6 class="mb-1">Tendai Moyo</h6>
                  <p class="text-muted small mb-1">Electrical Services</p>
                  <small class="text-warning">
                    <i class="icon-base ri ri-star-fill icon-14px"></i>
                    <i class="icon-base ri ri-star-fill icon-14px"></i>
                    <i class="icon-base ri ri-star-fill icon-14px"></i>
                    <i class="icon-base ri ri-star-fill icon-14px"></i>
                    <i class="icon-base ri ri-star-half-fill icon-14px"></i>
                    4.7
                  </small>
                </div>
              </div>
            </div>
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
                <input type="tel" class="form-control" placeholder="+263 78 123 4567" value="+263 78 123 4567" />
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
          <form id="changePasswordForm">
            <!-- Current Password -->
            <div class="mb-4">
              <label class="form-label">Current Password</label>
              <div class="input-group">
                <input type="password" class="form-control" id="currentPassword"
                  placeholder="Enter current password" />
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
                <input type="password" class="form-control" id="newPassword" placeholder="Enter new password" />
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
                <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password" />
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
          <button type="button" class="btn btn-primary" id="changePasswordBtn" onclick="changePassword()" disabled>
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
          <p class="text-muted mb-4">Your password has been updated. For security purposes, you may need to log in again
            on other devices.</p>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Done</button>
        </div>
      </div>
    </div>
  </div>
  <!--/ Password Changed Success Modal -->

  <script>
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

    // Functions for modal actions
    function saveProfileChanges() {
      const form = document.getElementById('editProfileForm');
      console.log('Saving profile changes...');
      const editModal = bootstrap.Modal.getInstance(document.getElementById('editProfileModal'));
      editModal.hide();
      alert('Profile updated successfully!');
    }

    function changePassword() {
      const currentPassword = document.getElementById('currentPassword').value;
      const newPassword = document.getElementById('newPassword').value;
      console.log('Changing password...');
      const changeModal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
      changeModal.hide();

      // Show success modal
      const successModal = new bootstrap.Modal(document.getElementById('passwordChangedModal'));
      successModal.show();
    }
  </script>
@endsection
