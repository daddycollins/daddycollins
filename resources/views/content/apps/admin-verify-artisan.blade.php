@extends('layouts/layoutMaster')

@section('title', 'Artisan Verifications - Admin')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/select2/select2.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('content')
  <!-- Header -->
  <div
    class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-between mb-6 text-center text-sm-start gap-2">
    <button type="button" class="btn btn-outline-success" id="autoVerifyBtn" data-bs-toggle="tooltip"
      title="Enable system to auto-verify artisans meeting all criteria">
      <i class="icon-base ri ri-robot-2-line me-2"></i>Auto Verify
    </button>
  </div>

  <div class="row g-6">
    <!-- Artisans List Sidebar -->
    <div class="col-xl-4 col-lg-5 col-md-5">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0 mb-3">Pending Verifications</h5>
          <div class="input-group input-group-sm">
            <span class="input-group-text border-0"><i class="icon-base ri ri-search-line"></i></span>
            <input type="text" class="form-control form-control-sm border-0" placeholder="Search by name..."
              id="searchArtisan">
          </div>
        </div>
        <div class="card-body p-0" style="max-height: 700px; overflow-y: auto;">
          <div class="list-group list-group-flush" id="artisansList">
            @forelse($pendingVerifications as $index => $verification)
              <a href="#"
                class="list-group-item list-group-item-action artisan-item {{ $index === 0 ? 'active' : '' }}"
                data-id="{{ $verification->user->id }}" data-name="{{ $verification->user->name }}">
                <div class="d-flex w-100 align-items-center justify-content-between">
                  <div class="d-flex align-items-center gap-3 flex-grow-1">
                    <div class="avatar avatar-sm rounded-circle">
                      <span
                        class="avatar-initial rounded-circle bg-label-primary">{{ substr($verification->user->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-grow-1 min-width-0">
                      <h6 class="mb-1 text-truncate">{{ $verification->user->name }}</h6>
                      <small
                        class="text-muted d-block text-truncate">{{ $verification->user->artisanProfile?->category ?? 'N/A' }}</small>
                    </div>
                  </div>
                  <span class="badge bg-label-warning rounded-pill">Pending</span>
                </div>
              </a>
            @empty
              <div class="p-4 text-center text-muted">
                <i class="icon-base ri ri-checkbox-circle-line icon-48px mb-3 d-block"></i>
                <p class="mb-0">No pending verifications</p>
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>

    <!-- Artisan Details Preview -->
    <div class="col-xl-8 col-lg-7 col-md-7">
      <!-- Profile Card -->
      <div class="card border-0 shadow-sm mb-6">
        <div class="card-body">
          <div class="row">
            <div class="col-md-4 text-center">
              <div class="avatar avatar-xl rounded-3 mb-4 mx-auto bg-label-primary" style="width: 140px; height: 140px;">
                <span class="avatar-initial rounded-3"
                  style="font-size: 3rem;">{{ substr($selectedVerification?->user?->name ?? 'N', 0, 1) }}</span>
              </div>
              <h5 id="artisanName" class="mb-1">{{ $selectedVerification?->user?->name ?? 'No artisan selected' }}</h5>
              <p id="artisanTrade" class="text-muted small mb-4">
                {{ $selectedVerification?->user?->artisanProfile?->category ?? 'N/A' }}</p>
              <div class="d-grid gap-2">
                <div class="badge bg-label-info py-2"><i class="icon-base ri ri-verified-badge-line me-1"></i>Pending
                  Review
                </div>
              </div>
            </div>

            <div class="col-md-8">
              <div class="row mb-4">
                <div class="col-sm-6 mb-3">
                  <small class="text-muted d-block mb-1">Email</small>
                  <h6 id="artisanEmail" class="mb-0">{{ $selectedVerification?->user?->email ?? '-' }}</h6>
                </div>
                <div class="col-sm-6 mb-3">
                  <small class="text-muted d-block mb-1">Phone</small>
                  <h6 id="artisanPhone" class="mb-0">{{ $selectedVerification?->user?->artisanProfile?->phone ?? '-' }}
                  </h6>
                </div>
                <div class="col-sm-6 mb-3">
                  <small class="text-muted d-block mb-1">Registration Date</small>
                  <h6 id="artisanRegDate" class="mb-0">
                    {{ $selectedVerification?->user?->created_at?->format('M d, Y') ?? '-' }}</h6>
                </div>
                <div class="col-sm-6 mb-3">
                  <small class="text-muted d-block mb-1">Business Name</small>
                  <h6 id="artisanBusiness" class="mb-0">
                    {{ $selectedVerification?->user?->artisanProfile?->business_name ?? '-' }}</h6>
                </div>
                <div class="col-sm-6 mb-3">
                  <small class="text-muted d-block mb-1">Location</small>
                  <h6 id="artisanLocation" class="mb-0">
                    {{ $selectedVerification?->user?->artisanProfile?->location ?? '-' }}</h6>
                </div>
                <div class="col-sm-6 mb-3">
                  <small class="text-muted d-block mb-1">Verification Status</small>
                  <h6 class="mb-0"><span
                      class="badge bg-label-warning">{{ ucfirst($selectedVerification?->status ?? 'pending') }}</span>
                  </h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Documents Section -->
      <div class="card border-0 shadow-sm mb-6">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0"><i class="icon-base ri ri-file-text-line me-2 text-primary"></i>Uploaded Documents
          </h5>
        </div>
        <div class="card-body">
          <div class="row g-4">
            <!-- ID Document -->
            <div class="col-md-6">
              <div class="border-1 border rounded-3 p-4 text-center cursor-pointer document-preview" data-type="id"
                style="background: #f3f4f6;">
                <div class="mb-3">
                  <i class="icon-base ri ri-id-card-line" style="font-size: 2.5rem; color: #696cff;"></i>
                </div>
                <h6 class="mb-2">National ID Document</h6>
                <small class="text-muted d-block mb-3">Status: <span
                    class="badge {{ $selectedVerification?->nationalDocument ? 'bg-label-success' : 'bg-label-warning' }}">{{ $selectedVerification?->nationalDocument ? 'Verified' : 'Pending' }}</span></small>
                @if ($selectedVerification?->nationalDocument)
                  <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#idModal">
                    <i class="icon-base ri ri-eye-line me-1"></i>View
                  </button>
                @endif
              </div>
            </div>

            <!-- Trade License -->
            <div class="col-md-6">
              <div class="border-1 border rounded-3 p-4 text-center cursor-pointer document-preview" data-type="license"
                style="background: #f3f4f6;">
                <div class="mb-3">
                  <i class="icon-base ri ri-file-list-line" style="font-size: 2.5rem; color: #71dd5a;"></i>
                </div>
                <h6 class="mb-2">Trade License</h6>
                <small class="text-muted d-block mb-3">Status: <span
                    class="badge bg-label-warning">Pending</span></small>
                <p class="text-muted small mb-0">Awaiting upload</p>
              </div>
            </div>

            <!-- Insurance -->
            <div class="col-md-6">
              <div class="border-1 border rounded-3 p-4 text-center cursor-pointer document-preview"
                data-type="insurance" style="background: #f3f4f6;">
                <div class="mb-3">
                  <i class="icon-base ri ri-shield-check-line" style="font-size: 2.5rem; color: #ffb64d;"></i>
                </div>
                <h6 class="mb-2">Insurance Document</h6>
                <small class="text-muted d-block mb-3">Status: <span
                    class="badge bg-label-warning">Pending</span></small>
                <p class="text-muted small mb-0">Awaiting upload</p>
              </div>
            </div>

            <!-- Bank Details -->
            <div class="col-md-6">
              <div class="border-1 border rounded-3 p-4 text-center cursor-pointer document-preview" data-type="bank"
                style="background: #f3f4f6;">
                <div class="mb-3">
                  <i class="icon-base ri ri-bank-card-line" style="font-size: 2.5rem; color: #00d4ff;"></i>
                </div>
                <h6 class="mb-2">Bank Details</h6>
                <small class="text-muted d-block mb-3">Status: <span
                    class="badge {{ $selectedVerification?->user?->paynowAccount ? 'bg-label-success' : 'bg-label-warning' }}">{{ $selectedVerification?->user?->paynowAccount ? 'Verified' : 'Pending' }}</span></small>
                @if ($selectedVerification?->user?->paynowAccount)
                  <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bankModal">
                    <i class="icon-base ri ri-eye-line me-1"></i>View
                  </button>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- OCR Data Section -->
      <div class="card border-0 shadow-sm mb-6">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0"><i class="icon-base ri ri-scan-line me-2 text-success"></i>OCR Extracted Data</h5>
        </div>
        <div class="card-body">
          <div class="nav-align-top">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                  data-bs-target="#ocrId">ID Document</button>
              </li>
              <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                  data-bs-target="#ocrLicense">Trade
                  License</button>
              </li>
              <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                  data-bs-target="#ocrBank">Bank Details</button>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="ocrId" role="tabpanel">
                <div class="table-responsive mt-3">
                  <table class="table table-sm mb-0">
                    <tr>
                      <td><strong>Full Name</strong></td>
                      <td>{{ $selectedVerification?->nationalDocument?->full_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                      <td><strong>ID Number</strong></td>
                      <td>{{ $selectedVerification?->nationalDocument?->id_number ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Date of Birth</strong></td>
                      <td>
                        {{ $selectedVerification?->nationalDocument?->dob ? \Carbon\Carbon::parse($selectedVerification->nationalDocument->dob)->format('M d, Y') : 'N/A' }}
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Issue Date</strong></td>
                      <td>
                        {{ $selectedVerification?->nationalDocument?->issue_date ? \Carbon\Carbon::parse($selectedVerification->nationalDocument->issue_date)->format('M d, Y') : 'N/A' }}
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Expiry Date</strong></td>
                      <td>
                        {{ $selectedVerification?->nationalDocument?->expiry_date ? \Carbon\Carbon::parse($selectedVerification->nationalDocument->expiry_date)->format('M d, Y') : 'N/A' }}
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Status</strong></td>
                      <td><span
                          class="badge {{ $selectedVerification?->nationalDocument?->expiry_date && \Carbon\Carbon::parse($selectedVerification->nationalDocument->expiry_date)->isFuture() ? 'bg-label-success' : 'bg-label-danger' }}">{{ $selectedVerification?->nationalDocument?->expiry_date && \Carbon\Carbon::parse($selectedVerification->nationalDocument->expiry_date)->isFuture() ? 'Valid' : 'Expired' }}</span>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="ocrLicense" role="tabpanel">
                <div class="table-responsive mt-3">
                  <table class="table table-sm mb-0">
                    <tr>
                      <td><strong>Business Name</strong></td>
                      <td>{{ $selectedVerification?->user?->artisanProfile?->business_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Trade Category</strong></td>
                      <td>{{ $selectedVerification?->user?->artisanProfile?->category ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Location</strong></td>
                      <td>{{ $selectedVerification?->user?->artisanProfile?->location ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Bio</strong></td>
                      <td>{{ $selectedVerification?->user?->artisanProfile?->bio ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                      <td><strong>Status</strong></td>
                      <td><span class="badge bg-label-info">Pending Verification</span></td>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="ocrBank" role="tabpanel">
                <div class="table-responsive mt-3">
                  @if ($selectedVerification?->user?->paynowAccount)
                    <table class="table table-sm mb-0">
                      <tr>
                        <td><strong>Account Holder</strong></td>
                        <td>{{ $selectedVerification->user->name ?? 'N/A' }}</td>
                      </tr>
                      <tr>
                        <td><strong>Account Number</strong></td>
                        <td>
                          {{ substr($selectedVerification->user->paynowAccount->account_number, -4) ? '••••••••' . substr($selectedVerification->user->paynowAccount->account_number, -4) : 'N/A' }}
                        </td>
                      </tr>
                      <tr>
                        <td><strong>Account Status</strong></td>
                        <td><span class="badge bg-label-success">Active</span></td>
                      </tr>
                    </table>
                  @else
                    <div class="alert alert-warning" role="alert">
                      <i class="icon-base ri ri-alert-line me-2"></i>No bank account details on file yet
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Verification Actions -->
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0"><i class="icon-base ri ri-checkbox-circle-line me-2 text-info"></i>Verification
            Decision</h5>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label"><strong>Notes</strong></label>
              <textarea class="form-control" id="verificationNotes" rows="3"
                placeholder="Add any notes or reasons for your decision..."></textarea>
            </div>
            <div class="col-12 d-flex gap-2">
              <button class="btn btn-success flex-grow-1" id="approveBtn">
                <i class="icon-base ri ri-check-double-line me-2"></i>Approve Artisan
              </button>
              <button class="btn btn-warning flex-grow-1" id="requestChangesBtn">
                <i class="icon-base ri ri-edit-line me-2"></i>Request Changes
              </button>
              <button class="btn btn-danger flex-grow-1" id="rejectBtn">
                <i class="icon-base ri ri-close-circle-line me-2"></i>Reject
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modals for Document Preview -->
  <div class="modal fade" id="idModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">National ID Document</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <img src="/images/documents/id-sample.jpg" alt="ID Document" class="img-fluid rounded-2">
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="licenseModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Trade License</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <img src="/images/documents/license-sample.jpg" alt="License" class="img-fluid rounded-2">
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="insuranceModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Insurance Document</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <img src="/images/documents/insurance-sample.jpg" alt="Insurance" class="img-fluid rounded-2">
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="bankModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Bank Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <img src="/images/documents/bank-sample.jpg" alt="Bank Details" class="img-fluid rounded-2">
        </div>
      </div>
    </div>
  </div>

  <!-- Auto Verify Modal -->
  <div class="modal fade" id="autoVerifyModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Enable Auto Verification</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p class="mb-3">Enable the system to automatically verify artisans that meet all criteria:</p>
          <div class="alert alert-info">
            <ul class="mb-0 ps-3">
              <li>Valid government ID (not expired)</li>
              <li>Active trade license</li>
              <li>Valid insurance document</li>
              <li>Verified bank details</li>
            </ul>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="enableAutoVerify">
            <label class="form-check-label" for="enableAutoVerify">
              Enable automatic verification for eligible artisans
            </label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" id="confirmAutoVerify">Enable</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Sample artisan data
      const artisans = {
        1: {
          name: 'James Smith',
          trade: 'Plumber',
          email: 'james.smith@email.com',
          phone: '+263 78 123 4567',
          regDate: 'Jan 10, 2024',
          experience: '5 years',
          location: 'Harare, Zimbabwe',
          avatar: '/images/avatars/1.png'
        },
        2: {
          name: 'Maria Garcia',
          trade: 'Carpenter',
          email: 'maria.garcia@email.com',
          phone: '+263 77 654 3210',
          regDate: 'Dec 20, 2023',
          experience: '8 years',
          location: 'Bulawayo, Zimbabwe',
          avatar: '/images/avatars/2.png'
        },
        3: {
          name: 'Robert Brown',
          trade: 'Electrician',
          email: 'robert.brown@email.com',
          phone: '+263 78 987 6543',
          regDate: 'Jan 5, 2024',
          experience: '10 years',
          location: 'Harare, Zimbabwe',
          avatar: '/images/avatars/3.png'
        },
        4: {
          name: 'Lisa Martinez',
          trade: 'House Cleaner',
          email: 'lisa.martinez@email.com',
          phone: '+263 79 111 2222',
          regDate: 'Jan 12, 2024',
          experience: '3 years',
          location: 'Chitungwiza, Zimbabwe',
          avatar: '/images/avatars/4.png'
        },
        5: {
          name: 'Christopher Lee',
          trade: 'Landscaper',
          email: 'chris.lee@email.com',
          phone: '+263 78 333 4444',
          regDate: 'Jan 8, 2024',
          experience: '6 years',
          location: 'Norton, Zimbabwe',
          avatar: '/images/avatars/5.png'
        }
      };

      // Load artisan details on click
      document.querySelectorAll('.artisan-item').forEach(item => {
        item.addEventListener('click', function(e) {
          e.preventDefault();
          const id = this.getAttribute('data-id');
          const artisan = artisans[id];

          document.querySelectorAll('.artisan-item').forEach(i => i.classList.remove('active'));
          this.classList.add('active');

          document.getElementById('artisanName').textContent = artisan.name;
          document.getElementById('artisanTrade').textContent = artisan.trade;
          document.getElementById('artisanEmail').textContent = artisan.email;
          document.getElementById('artisanPhone').textContent = artisan.phone;
          document.getElementById('artisanRegDate').textContent = artisan.regDate;
          document.getElementById('artisanExperience').textContent = artisan.experience;
          document.getElementById('artisanLocation').textContent = artisan.location;
          document.querySelector('.col-md-4 img').src = artisan.avatar;
        });
      });

      // Auto Verify button
      document.getElementById('autoVerifyBtn').addEventListener('click', function() {
        const modal = new bootstrap.Modal(document.getElementById('autoVerifyModal'));
        modal.show();
      });

      // Verification action buttons
      document.getElementById('approveBtn').addEventListener('click', function() {
        const notes = document.getElementById('verificationNotes').value;
        const artisanName = document.getElementById('artisanName').textContent;
        Swal.fire({
          title: 'Approve Artisan?',
          text: `Approve ${artisanName} for the ArtisanConnect platform?`,
          icon: 'success',
          showCancelButton: true,
          confirmButtonText: 'Yes, Approve',
          cancelButtonText: 'Cancel'
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire('Approved!', `${artisanName} has been approved successfully.`, 'success');
            document.getElementById('verificationNotes').value = '';
          }
        });
      });

      document.getElementById('requestChangesBtn').addEventListener('click', function() {
        const notes = document.getElementById('verificationNotes').value;
        if (!notes) {
          Swal.fire('Note Required', 'Please add notes about the required changes.', 'warning');
          return;
        }
        Swal.fire({
          title: 'Request Changes?',
          text: 'Send a request to the artisan for document updates?',
          icon: 'info',
          showCancelButton: true,
          confirmButtonText: 'Yes, Send Request',
          cancelButtonText: 'Cancel'
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire('Request Sent!', 'The artisan will receive a notification to update their documents.',
              'success');
            document.getElementById('verificationNotes').value = '';
          }
        });
      });

      document.getElementById('rejectBtn').addEventListener('click', function() {
        const notes = document.getElementById('verificationNotes').value;
        if (!notes) {
          Swal.fire('Note Required', 'Please provide a reason for rejection.', 'warning');
          return;
        }
        Swal.fire({
          title: 'Reject Artisan?',
          text: 'This action cannot be undone. Are you sure?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, Reject',
          confirmButtonColor: '#dc3545',
          cancelButtonText: 'Cancel'
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire('Rejected!', 'The artisan has been rejected from the platform.', 'error');
            document.getElementById('verificationNotes').value = '';
          }
        });
      });

      // Search functionality
      document.getElementById('searchArtisan').addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('.artisan-item').forEach(item => {
          const name = item.getAttribute('data-name').toLowerCase();
          if (name.includes(searchTerm)) {
            item.style.display = 'flex';
          } else {
            item.style.display = 'none';
          }
        });
      });

      // Auto verify confirmation
      document.getElementById('confirmAutoVerify').addEventListener('click', function() {
        const isChecked = document.getElementById('enableAutoVerify').checked;
        if (!isChecked) {
          Swal.fire('Confirmation Required', 'Please check the box to confirm enabling auto-verification.',
            'warning');
          return;
        }
        Swal.fire('Enabled!', 'Automatic verification has been enabled. Eligible artisans will be auto-verified.',
          'success');
        bootstrap.Modal.getInstance(document.getElementById('autoVerifyModal')).hide();
        document.getElementById('enableAutoVerify').checked = false;
      });
    });
  </script>
@endsection
