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
  <!-- Profile Header -->
  <div class="card border-0 shadow-sm mb-6">
    <div class="card-body">
      <div class="row align-items-center g-4">
        <div class="col-auto">
          <div class="position-relative">
            <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Profile" class="rounded-circle" width="120"
              height="120" />
            <button type="button" class="btn btn-sm btn-primary rounded-circle position-absolute bottom-0 end-0"
              data-bs-toggle="modal" data-bs-target="#changePhotoModal">
              <i class="icon-base ri ri-camera-fill"></i>
            </button>
          </div>
        </div>
        <div class="col">
          <div>
            <h4 class="mb-1">John Doe</h4>
            <p class="text-muted mb-3">Elite Craftsman • Member since Jan 2024</p>
            <div class="d-flex gap-2 flex-wrap">
              <span class="badge bg-label-success"><i class="icon-base ri ri-check-line me-1"></i>Verified</span>
              <span class="badge bg-label-primary"><i class="icon-base ri ri-star-line me-1"></i>4.8/5 Rating</span>
              <span class="badge bg-label-info"><i class="icon-base ri ri-thumb-up-line me-1"></i>98% Completion</span>
            </div>
          </div>
        </div>
        <div class="col-md-auto">
          <div class="text-center">
            <h5 class="mb-1">267</h5>
            <small class="text-muted">Total Reviews</small>
          </div>
          <div class="text-center border-start border-end px-4">
            <h5 class="mb-1">486</h5>
            <small class="text-muted">Orders Completed</small>
          </div>
          <div class="text-center">
            <h5 class="mb-1">ZWL 234K</h5>
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
          <button class="nav-link" id="bankTab" data-bs-toggle="tab" data-bs-target="#bankContent" role="tab"
            aria-controls="bankContent" aria-selected="false">
            <i class="icon-base ri ri-bank-line me-2"></i>Bank Details
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
                <p class="text-muted">John's Premium Carpentry Services</p>
              </div>
              <div class="mb-4">
                <label class="form-label fw-medium">Business Category</label>
                <div class="d-flex gap-2 flex-wrap">
                  <span class="badge bg-label-primary">Furniture Making</span>
                  <span class="badge bg-label-primary">Home Repairs</span>
                  <span class="badge bg-label-primary">Custom Design</span>
                </div>
              </div>
              <div class="mb-4">
                <label class="form-label fw-medium">Business Description</label>
                <p class="text-muted">Over 15 years of experience in creating high-quality furniture and providing
                  exceptional carpentry services. Specializing in custom designs, home renovations, and wooden furniture
                  restoration.</p>
              </div>
              <div class="row g-4">
                <div class="col-md-6">
                  <label class="form-label fw-medium">Years of Experience</label>
                  <p class="text-muted">15 years</p>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-medium">Service Areas</label>
                  <p class="text-muted">Harare, Chitungwiza, Epworth</p>
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
              <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#editBusinessModal">
                <i class="icon-base ri ri-edit-line me-2"></i>Edit Business Profile
              </button>
            </div>
            <div class="col-md-4">
              <div class="card bg-light border-0">
                <div class="card-body">
                  <h6 class="card-title mb-3"><i class="icon-base ri ri-information-line me-2"></i>Business Stats</h6>
                  <div class="mb-3">
                    <small class="text-muted d-block">Member Since</small>
                    <strong>January 15, 2024</strong>
                  </div>
                  <div class="mb-3">
                    <small class="text-muted d-block">Account Status</small>
                    <span class="badge bg-label-success">Active</span>
                  </div>
                  <div class="mb-3">
                    <small class="text-muted d-block">Verification Status</small>
                    <span class="badge bg-label-success">Verified</span>
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
              <label class="form-label fw-medium">First Name</label>
              <p class="text-muted">John</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium">Last Name</label>
              <p class="text-muted">Doe</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium">Email Address</label>
              <p class="text-muted">john.doe@example.com</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium">Phone Number</label>
              <p class="text-muted">+263 789 998 988</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium">Date of Birth</label>
              <p class="text-muted">January 15, 1985</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium">Gender</label>
              <p class="text-muted">Male</p>
            </div>
            <div class="col-12">
              <label class="form-label fw-medium">Address</label>
              <p class="text-muted">123 Carpentry Lane, Harare</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium">City / Town</label>
              <p class="text-muted">Harare</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium">Province / State</label>
              <p class="text-muted">Harare Metropolitan</p>
            </div>
          </div>
          <button type="button" class="btn btn-primary mt-4" data-bs-toggle="modal"
            data-bs-target="#editPersonalModal">
            <i class="icon-base ri ri-edit-line me-2"></i>Edit Personal Details
          </button>
        </div>

        <!-- Bank Details Tab -->
        <div class="tab-pane fade" id="bankContent" role="tabpanel" aria-labelledby="bankTab">
          <div class="row g-4">
            <div class="col-md-6">
              <label class="form-label fw-medium">Bank Name</label>
              <p class="text-muted">ZB Bank</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium">Branch Code</label>
              <p class="text-muted">125400</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium">Account Number</label>
              <p class="text-muted">****2847</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium">Account Holder Name</label>
              <p class="text-muted">John Doe</p>
            </div>
            <div class="col-12">
              <label class="form-label fw-medium">Account Type</label>
              <p class="text-muted">Savings Account</p>
            </div>
            <div class="col-12">
              <div class="alert alert-info" role="alert">
                <i class="icon-base ri ri-shield-check-line me-2"></i>
                <small>Your bank details are securely encrypted and only used for payment transfers.</small>
              </div>
            </div>
          </div>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editBankModal">
            <i class="icon-base ri ri-edit-line me-2"></i>Edit Bank Details
          </button>
        </div>

        <!-- Social Links Tab -->
        <div class="tab-pane fade" id="socialContent" role="tabpanel" aria-labelledby="socialTab">
          <div class="row g-4">
            <div class="col-md-6">
              <label class="form-label fw-medium"><i
                  class="icon-base ri ri-facebook-circle-fill text-primary me-2"></i>Facebook Profile</label>
              <p class="text-muted">facebook.com/johndoecarpentry</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium"><i
                  class="icon-base ri ri-instagram-fill text-danger me-2"></i>Instagram Profile</label>
              <p class="text-muted">@johndoecarpentry</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium"><i
                  class="icon-base ri ri-whatsapp-line text-success me-2"></i>WhatsApp</label>
              <p class="text-muted">+263 789 998 988</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-medium"><i
                  class="icon-base ri ri-links-line text-secondary me-2"></i>Website</label>
              <p class="text-muted">www.johndoecarpentry.co.zw</p>
            </div>
            <div class="col-12">
              <label class="form-label fw-medium"><i class="icon-base ri ri-linkedin-fill text-info me-2"></i>LinkedIn
                Profile</label>
              <p class="text-muted">linkedin.com/in/johndoe</p>
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
          <form id="photoForm">
            <div class="mb-4">
              <label class="form-label fw-medium">Upload New Photo</label>
              <div class="border-2 border-dashed rounded-3 p-5 text-center cursor-pointer bg-light"
                onclick="document.getElementById('photoInput').click()">
                <i class="icon-base ri ri-upload-cloud-2-line text-primary" style="font-size: 2rem;"></i>
                <p class="mb-0 mt-3"><strong>Click to upload</strong> or drag and drop</p>
                <small class="text-muted">PNG, JPG, GIF up to 5MB</small>
                <input type="file" id="photoInput" class="d-none" accept="image/*" />
              </div>
            </div>
            <div class="mb-0">
              <label class="form-label fw-medium">Preview</label>
              <div class="text-center">
                <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Preview" class="rounded-circle"
                  width="100" height="100" />
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
          <form id="businessForm">
            <div class="mb-4">
              <label class="form-label fw-medium">Business Name *</label>
              <input type="text" class="form-control" value="John's Premium Carpentry Services" required />
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium">Business Categories *</label>
              <div class="d-flex gap-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="cat1" checked />
                  <label class="form-check-label" for="cat1">Furniture Making</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="cat2" checked />
                  <label class="form-check-label" for="cat2">Home Repairs</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="cat3" checked />
                  <label class="form-check-label" for="cat3">Custom Design</label>
                </div>
              </div>
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium">Business Description *</label>
              <textarea class="form-control" rows="4" required>Over 15 years of experience in creating high-quality furniture and providing exceptional carpentry services. Specializing in custom designs, home renovations, and wooden furniture restoration.</textarea>
            </div>
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label fw-medium">Years of Experience *</label>
                <input type="number" class="form-control" value="15" min="1" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Service Areas *</label>
                <input type="text" class="form-control" value="Harare, Chitungwiza, Epworth" required />
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
    <div class="modal-dialog modal-lg">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-user-line me-2 text-primary"></i>Edit Personal Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="personalForm">
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label fw-medium">First Name *</label>
                <input type="text" class="form-control" value="John" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Last Name *</label>
                <input type="text" class="form-control" value="Doe" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Email Address *</label>
                <input type="email" class="form-control" value="john.doe@example.com" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Phone Number *</label>
                <input type="tel" class="form-control" value="+263 789 998 988" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Date of Birth</label>
                <input type="date" class="form-control" value="1985-01-15" />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Gender</label>
                <select class="form-select">
                  <option value="male" selected>Male</option>
                  <option value="female">Female</option>
                  <option value="other">Other</option>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label fw-medium">Address</label>
                <input type="text" class="form-control" value="123 Carpentry Lane, Harare" />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">City / Town</label>
                <input type="text" class="form-control" value="Harare" />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Province / State</label>
                <input type="text" class="form-control" value="Harare Metropolitan" />
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
  <div class="modal fade" id="editBankModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-bank-line me-2 text-primary"></i>Edit Bank Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="bankForm">
            <div class="mb-4">
              <label class="form-label fw-medium">Bank Name *</label>
              <select class="form-select" required>
                <option value="zb" selected>ZB Bank</option>
                <option value="cbz">CBZ Bank</option>
                <option value="ecocash">EcoCash</option>
                <option value="telecash">TeleCash</option>
              </select>
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium">Branch Code *</label>
              <input type="text" class="form-control" value="125400" required />
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium">Account Number *</label>
              <input type="text" class="form-control" value="2847" required />
              <small class="text-muted">Last 4 digits of your account</small>
            </div>
            <div class="mb-0">
              <label class="form-label fw-medium">Account Holder Name *</label>
              <input type="text" class="form-control" value="John Doe" required />
            </div>
          </form>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" form="bankForm">
            <i class="icon-base ri ri-check-line me-2"></i>Save Changes
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Social Modal -->
  <div class="modal fade" id="editSocialModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-share-line me-2 text-primary"></i>Edit Social Links</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="socialForm">
            <div class="mb-4">
              <label class="form-label fw-medium"><i
                  class="icon-base ri ri-facebook-circle-fill text-primary me-2"></i>Facebook Profile</label>
              <input type="text" class="form-control" value="facebook.com/johndoecarpentry"
                placeholder="https://facebook.com/..." />
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium"><i
                  class="icon-base ri ri-instagram-fill text-danger me-2"></i>Instagram Profile</label>
              <input type="text" class="form-control" value="@johndoecarpentry" placeholder="@username" />
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium"><i
                  class="icon-base ri ri-whatsapp-line text-success me-2"></i>WhatsApp</label>
              <input type="tel" class="form-control" value="+263 789 998 988" placeholder="+263..." />
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium"><i
                  class="icon-base ri ri-links-line text-secondary me-2"></i>Website</label>
              <input type="url" class="form-control" value="www.johndoecarpentry.co.zw"
                placeholder="https://www.example.com" />
            </div>
            <div class="mb-0">
              <label class="form-label fw-medium"><i class="icon-base ri ri-linkedin-fill text-info me-2"></i>LinkedIn
                Profile</label>
              <input type="text" class="form-control" value="linkedin.com/in/johndoe"
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

  <script>
    // Photo upload preview
    document.getElementById('photoInput')?.addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
          document.querySelector('#changePhotoModal .rounded-circle').src = event.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
  </script>
@endsection
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
