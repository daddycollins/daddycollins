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
    <div>
      <h4 class="mb-1">Artisan Verifications</h4>
      <p class="text-muted mb-0">{{ $totalPending }} pending verification{{ $totalPending !== 1 ? 's' : '' }}</p>
    </div>
  </div>

  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
      <i class="icon-base ri ri-checkbox-circle-line me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
      <i class="icon-base ri ri-error-warning-line me-2"></i>{{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

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
                data-verification-id="{{ $verification->id }}"
                data-name="{{ $verification->artisan->user->name ?? 'Unknown' }}">
                <div class="d-flex w-100 align-items-center justify-content-between">
                  <div class="d-flex align-items-center gap-3 flex-grow-1">
                    <div class="avatar avatar-sm rounded-circle">
                      <span
                        class="avatar-initial rounded-circle bg-label-primary">{{ substr($verification->artisan->user->name ?? 'N', 0, 1) }}</span>
                    </div>
                    <div class="flex-grow-1 min-width-0">
                      <h6 class="mb-1 text-truncate">{{ $verification->artisan->user->name ?? 'Unknown' }}</h6>
                      <small
                        class="text-muted d-block text-truncate">{{ $verification->artisan->category ?? 'N/A' }}</small>
                    </div>
                  </div>
                  <div class="text-end">
                    <span class="badge bg-label-warning rounded-pill">Pending</span>
                    @if ($verification->nationalDocument && $verification->nationalDocument->ocr_confidence)
                      <small class="d-block text-muted mt-1">OCR:
                        {{ number_format($verification->nationalDocument->ocr_confidence, 0) }}%</small>
                    @endif
                  </div>
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
      @if ($selectedVerification)
        <!-- Profile Card -->
        <div class="card border-0 shadow-sm mb-6">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4 text-center">
                <div class="avatar avatar-xl rounded-3 mb-4 mx-auto bg-label-primary"
                  style="width: 140px; height: 140px;">
                  <span class="avatar-initial rounded-3" id="artisanInitial"
                    style="font-size: 3rem;">{{ substr($selectedVerification->artisan->user->name ?? 'N', 0, 1) }}</span>
                </div>
                <h5 id="artisanName" class="mb-1">
                  {{ $selectedVerification->artisan->user->name ?? 'No artisan selected' }}</h5>
                <p id="artisanTrade" class="text-muted small mb-4">
                  {{ $selectedVerification->artisan->category ?? 'N/A' }}</p>
                <div class="d-grid gap-2">
                  <div class="badge bg-label-info py-2"><i class="icon-base ri ri-verified-badge-line me-1"></i>Pending
                    Review
                  </div>
                  @if ($selectedVerification->nationalDocument && $selectedVerification->nationalDocument->ocr_confidence)
                    <div
                      class="badge {{ $selectedVerification->nationalDocument->ocr_confidence >= 70 ? 'bg-label-success' : 'bg-label-warning' }} py-2">
                      <i class="icon-base ri ri-scan-line me-1"></i>OCR Confidence:
                      {{ number_format($selectedVerification->nationalDocument->ocr_confidence, 1) }}%
                    </div>
                  @endif
                </div>
              </div>

              <div class="col-md-8">
                <div class="row mb-4">
                  <div class="col-sm-6 mb-3">
                    <small class="text-muted d-block mb-1">Email</small>
                    <h6 id="artisanEmail" class="mb-0">
                      {{ $selectedVerification->artisan->user->email ?? '-' }}</h6>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <small class="text-muted d-block mb-1">Phone</small>
                    <h6 id="artisanPhone" class="mb-0">{{ $selectedVerification->artisan->phone ?? '-' }}</h6>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <small class="text-muted d-block mb-1">Registration Date</small>
                    <h6 id="artisanRegDate" class="mb-0">
                      {{ $selectedVerification->artisan->user->created_at?->format('M d, Y') ?? '-' }}</h6>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <small class="text-muted d-block mb-1">Business Name</small>
                    <h6 id="artisanBusiness" class="mb-0">
                      {{ $selectedVerification->artisan->business_name ?? '-' }}</h6>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <small class="text-muted d-block mb-1">Location</small>
                    <h6 id="artisanLocation" class="mb-0">
                      {{ $selectedVerification->artisan->location ?? '-' }}</h6>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <small class="text-muted d-block mb-1">Verification Method</small>
                    <h6 class="mb-0"><span
                        class="badge bg-label-primary">{{ ucfirst($selectedVerification->verification_method ?? 'N/A') }}</span>
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
            <h5 class="card-title m-0"><i class="icon-base ri ri-file-text-line me-2 text-primary"></i>Uploaded
              Documents</h5>
          </div>
          <div class="card-body">
            <div class="row g-4">
              <!-- ID Document Front -->
              <div class="col-md-6">
                <div class="border-1 border rounded-3 p-4 text-center" style="background: #f3f4f6;">
                  <div class="mb-3">
                    <i class="icon-base ri ri-id-card-line" style="font-size: 2.5rem; color: #696cff;"></i>
                  </div>
                  <h6 class="mb-2">National ID - Front</h6>
                  <small class="text-muted d-block mb-3">Status: <span
                      class="badge {{ $selectedVerification->nationalDocument ? 'bg-label-success' : 'bg-label-warning' }}">{{ $selectedVerification->nationalDocument ? 'Uploaded' : 'Pending' }}</span></small>
                  @if ($selectedVerification->nationalDocument && $selectedVerification->nationalDocument->front_image_path)
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                      data-bs-target="#idFrontModal">
                      <i class="icon-base ri ri-eye-line me-1"></i>View
                    </button>
                  @endif
                </div>
              </div>

              <!-- ID Document Back -->
              <div class="col-md-6">
                <div class="border-1 border rounded-3 p-4 text-center" style="background: #f3f4f6;">
                  <div class="mb-3">
                    <i class="icon-base ri ri-id-card-line" style="font-size: 2.5rem; color: #71dd5a;"></i>
                  </div>
                  <h6 class="mb-2">National ID - Back</h6>
                  <small class="text-muted d-block mb-3">Status: <span
                      class="badge {{ $selectedVerification->nationalDocument && $selectedVerification->nationalDocument->back_image_path ? 'bg-label-success' : 'bg-label-warning' }}">{{ $selectedVerification->nationalDocument && $selectedVerification->nationalDocument->back_image_path ? 'Uploaded' : 'Pending' }}</span></small>
                  @if ($selectedVerification->nationalDocument && $selectedVerification->nationalDocument->back_image_path)
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                      data-bs-target="#idBackModal">
                      <i class="icon-base ri ri-eye-line me-1"></i>View
                    </button>
                  @endif
                </div>
              </div>

              <!-- Bank Details -->
              <div class="col-md-6">
                <div class="border-1 border rounded-3 p-4 text-center" style="background: #f3f4f6;">
                  <div class="mb-3">
                    <i class="icon-base ri ri-bank-card-line" style="font-size: 2.5rem; color: #00d4ff;"></i>
                  </div>
                  <h6 class="mb-2">Bank / Paynow Details</h6>
                  <small class="text-muted d-block mb-3">Status: <span
                      class="badge {{ $selectedVerification->artisan->paynow ? 'bg-label-success' : 'bg-label-warning' }}">{{ $selectedVerification->artisan->paynow ? 'On File' : 'Not Provided' }}</span></small>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- OCR Data Section -->
        <div class="card border-0 shadow-sm mb-6">
          <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0"><i class="icon-base ri ri-scan-line me-2 text-success"></i>OCR Extracted Data
            </h5>
            @if ($selectedVerification->nationalDocument && $selectedVerification->nationalDocument->ocr_confidence)
              <span
                class="badge {{ $selectedVerification->nationalDocument->ocr_confidence >= 70 ? 'bg-success' : ($selectedVerification->nationalDocument->ocr_confidence >= 40 ? 'bg-warning' : 'bg-danger') }} rounded-pill">
                Confidence: {{ number_format($selectedVerification->nationalDocument->ocr_confidence, 1) }}%
              </span>
            @endif
          </div>
          <div class="card-body">
            @if ($selectedVerification->nationalDocument)
              <div class="table-responsive">
                <table class="table table-sm mb-0">
                  <tr>
                    <td width="200"><strong>Full Name (User Provided)</strong></td>
                    <td>{{ $selectedVerification->nationalDocument->full_name ?? 'N/A' }}</td>
                  </tr>
                  <tr>
                    <td><strong>Full Name (OCR Extracted)</strong></td>
                    <td>
                      @php
                        $ocrData = $selectedVerification->nationalDocument->ocr_extracted_data;
                      @endphp
                      {{ $ocrData['full_name'] ?? 'Not extracted' }}
                      @if (!empty($ocrData['full_name']) && $selectedVerification->nationalDocument->full_name)
                        @if (strtolower(trim($ocrData['full_name'])) === strtolower(trim($selectedVerification->nationalDocument->full_name)))
                          <i class="icon-base ri ri-checkbox-circle-fill text-success ms-1"></i>
                        @else
                          <i class="icon-base ri ri-close-circle-fill text-warning ms-1"
                            title="Mismatch with user-provided name"></i>
                        @endif
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td><strong>ID Number (User Provided)</strong></td>
                    <td>{{ $selectedVerification->nationalDocument->id_number ?? 'N/A' }}</td>
                  </tr>
                  <tr>
                    <td><strong>ID Number (OCR Extracted)</strong></td>
                    <td>
                      {{ $ocrData['id_number'] ?? 'Not extracted' }}
                      @if (!empty($ocrData['id_number']) && $selectedVerification->nationalDocument->id_number)
                        @php
                          $ocrIdClean = preg_replace('/[\s\-]/', '', $ocrData['id_number']);
                          $userIdClean = preg_replace('/[\s\-]/', '', $selectedVerification->nationalDocument->id_number);
                        @endphp
                        @if ($ocrIdClean === $userIdClean)
                          <i class="icon-base ri ri-checkbox-circle-fill text-success ms-1"></i>
                        @else
                          <i class="icon-base ri ri-close-circle-fill text-warning ms-1"
                            title="Mismatch with user-provided ID"></i>
                        @endif
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Date of Birth</strong></td>
                    <td>
                      {{ $selectedVerification->nationalDocument->date_of_birth ? $selectedVerification->nationalDocument->date_of_birth->format('M d, Y') : 'Not extracted' }}
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Issue Date</strong></td>
                    <td>
                      {{ $selectedVerification->nationalDocument->issue_date ? $selectedVerification->nationalDocument->issue_date->format('M d, Y') : 'Not extracted' }}
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Expiry Date</strong></td>
                    <td>
                      {{ $selectedVerification->nationalDocument->expiry_date ? $selectedVerification->nationalDocument->expiry_date->format('M d, Y') : 'Not extracted' }}
                      @if ($selectedVerification->nationalDocument->expiry_date)
                        @if ($selectedVerification->nationalDocument->expiry_date->isFuture())
                          <span class="badge bg-label-success ms-1">Valid</span>
                        @else
                          <span class="badge bg-label-danger ms-1">Expired</span>
                        @endif
                      @endif
                    </td>
                  </tr>
                </table>
              </div>

              @if ($selectedVerification->nationalDocument->ocr_raw_text)
                <div class="mt-4">
                  <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse"
                    data-bs-target="#ocrRawText">
                    <i class="icon-base ri ri-code-line me-1"></i>View Raw OCR Text
                  </button>
                  <div class="collapse mt-2" id="ocrRawText">
                    <pre
                      class="bg-light p-3 rounded-3 small"
                      style="max-height: 200px; overflow-y: auto;">{{ $selectedVerification->nationalDocument->ocr_raw_text }}</pre>
                  </div>
                </div>
              @endif
            @else
              <div class="alert alert-warning mb-0">
                <i class="icon-base ri ri-alert-line me-2"></i>No document has been uploaded yet.
              </div>
            @endif
          </div>
        </div>

        <!-- Verification Actions -->
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white border-bottom">
            <h5 class="card-title m-0"><i class="icon-base ri ri-checkbox-circle-line me-2 text-info"></i>Verification
              Decision</h5>
          </div>
          <div class="card-body">
            @if ($selectedVerification->remarks)
              <div class="alert alert-info mb-3">
                <strong>Current Remarks:</strong> {{ $selectedVerification->remarks }}
              </div>
            @endif

            <div class="row g-3">
              <div class="col-12">
                <label class="form-label"><strong>Notes / Remarks</strong></label>
                <textarea class="form-control" id="verificationNotes" rows="3"
                  placeholder="Add any notes or reasons for your decision..."></textarea>
              </div>
              <div class="col-12 d-flex gap-2">
                <!-- Approve Form -->
                <form action="{{ route('admin-verification-approve', $selectedVerification->id) }}" method="POST"
                  id="approveForm" class="flex-grow-1">
                  @csrf
                  <input type="hidden" name="remarks" id="approveRemarks">
                  <button type="button" class="btn btn-success w-100" id="approveBtn">
                    <i class="icon-base ri ri-check-double-line me-2"></i>Approve
                  </button>
                </form>

                <!-- Request Changes Form -->
                <form action="{{ route('admin-verification-request-changes', $selectedVerification->id) }}"
                  method="POST" id="requestChangesForm" class="flex-grow-1">
                  @csrf
                  <input type="hidden" name="remarks" id="requestChangesRemarks">
                  <button type="button" class="btn btn-warning w-100" id="requestChangesBtn">
                    <i class="icon-base ri ri-edit-line me-2"></i>Request Changes
                  </button>
                </form>

                <!-- Reject Form -->
                <form action="{{ route('admin-verification-reject', $selectedVerification->id) }}" method="POST"
                  id="rejectForm" class="flex-grow-1">
                  @csrf
                  <input type="hidden" name="remarks" id="rejectRemarks">
                  <button type="button" class="btn btn-danger w-100" id="rejectBtn">
                    <i class="icon-base ri ri-close-circle-line me-2"></i>Reject
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      @else
        <!-- No verifications -->
        <div class="card border-0 shadow-sm">
          <div class="card-body text-center py-5">
            <i class="icon-base ri ri-checkbox-circle-line text-success" style="font-size: 4rem;"></i>
            <h4 class="mt-3">All Clear!</h4>
            <p class="text-muted">No pending verifications to review.</p>
          </div>
        </div>
      @endif
    </div>
  </div>

  @if ($selectedVerification && $selectedVerification->nationalDocument)
    <!-- ID Front Modal -->
    <div class="modal fade" id="idFrontModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">National ID - Front</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-center">
            <img src="{{ asset('storage/' . $selectedVerification->nationalDocument->front_image_path) }}"
              alt="ID Front" class="img-fluid rounded-2">
          </div>
        </div>
      </div>
    </div>

    <!-- ID Back Modal -->
    @if ($selectedVerification->nationalDocument->back_image_path)
      <div class="modal fade" id="idBackModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">National ID - Back</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
              <img src="{{ asset('storage/' . $selectedVerification->nationalDocument->back_image_path) }}"
                alt="ID Back" class="img-fluid rounded-2">
            </div>
          </div>
        </div>
      </div>
    @endif
  @endif
@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Approve button
      const approveBtn = document.getElementById('approveBtn');
      if (approveBtn) {
        approveBtn.addEventListener('click', function() {
          const notes = document.getElementById('verificationNotes').value;
          document.getElementById('approveRemarks').value = notes || 'Approved by admin';

          Swal.fire({
            title: 'Approve Artisan?',
            text: 'This will verify the artisan and allow them to operate on the platform.',
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Yes, Approve',
            cancelButtonText: 'Cancel'
          }).then((result) => {
            if (result.isConfirmed) {
              document.getElementById('approveForm').submit();
            }
          });
        });
      }

      // Request Changes button
      const requestChangesBtn = document.getElementById('requestChangesBtn');
      if (requestChangesBtn) {
        requestChangesBtn.addEventListener('click', function() {
          const notes = document.getElementById('verificationNotes').value;
          if (!notes || notes.length < 10) {
            Swal.fire('Notes Required',
              'Please add detailed notes (at least 10 characters) about the required changes.', 'warning');
            return;
          }
          document.getElementById('requestChangesRemarks').value = notes;

          Swal.fire({
            title: 'Request Changes?',
            text: 'The artisan will be notified to update their documents.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Yes, Send Request',
            cancelButtonText: 'Cancel'
          }).then((result) => {
            if (result.isConfirmed) {
              document.getElementById('requestChangesForm').submit();
            }
          });
        });
      }

      // Reject button
      const rejectBtn = document.getElementById('rejectBtn');
      if (rejectBtn) {
        rejectBtn.addEventListener('click', function() {
          const notes = document.getElementById('verificationNotes').value;
          if (!notes || notes.length < 10) {
            Swal.fire('Notes Required',
              'Please provide a reason for rejection (at least 10 characters).', 'warning');
            return;
          }
          document.getElementById('rejectRemarks').value = notes;

          Swal.fire({
            title: 'Reject Artisan?',
            text: 'The artisan will be notified of the rejection.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Reject',
            confirmButtonColor: '#dc3545',
            cancelButtonText: 'Cancel'
          }).then((result) => {
            if (result.isConfirmed) {
              document.getElementById('rejectForm').submit();
            }
          });
        });
      }

      // Search functionality
      const searchInput = document.getElementById('searchArtisan');
      if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
          const searchTerm = e.target.value.toLowerCase();
          document.querySelectorAll('.artisan-item').forEach(item => {
            const name = item.getAttribute('data-name').toLowerCase();
            item.style.display = name.includes(searchTerm) ? 'flex' : 'none';
          });
        });
      }

      // Sidebar click - load artisan details via AJAX
      document.querySelectorAll('.artisan-item').forEach(item => {
        item.addEventListener('click', function(e) {
          e.preventDefault();
          const verificationId = this.getAttribute('data-verification-id');

          // Update active state
          document.querySelectorAll('.artisan-item').forEach(i => i.classList.remove('active'));
          this.classList.add('active');

          // Fetch verification details
          fetch(`/admin/verification/${verificationId}`)
            .then(response => response.json())
            .then(data => {
              // Update profile section
              document.getElementById('artisanName').textContent = data.artisan.name;
              document.getElementById('artisanTrade').textContent = data.artisan.category;
              document.getElementById('artisanEmail').textContent = data.artisan.email;
              document.getElementById('artisanPhone').textContent = data.artisan.phone;
              document.getElementById('artisanRegDate').textContent = data.artisan.reg_date;
              document.getElementById('artisanBusiness').textContent = data.artisan.business_name;
              document.getElementById('artisanLocation').textContent = data.artisan.location;
              document.getElementById('artisanInitial').textContent = data.artisan.initial;

              // Update form actions
              const baseUrl = '/admin/verification/' + verificationId;
              document.getElementById('approveForm').action = baseUrl + '/approve';
              document.getElementById('requestChangesForm').action = baseUrl + '/request-changes';
              document.getElementById('rejectForm').action = baseUrl + '/reject';

              // Update document images in modals
              if (data.document) {
                const frontModal = document.querySelector('#idFrontModal .modal-body img');
                if (frontModal) frontModal.src = data.document.front_image_url;

                const backModal = document.querySelector('#idBackModal .modal-body img');
                if (backModal && data.document.back_image_url) {
                  backModal.src = data.document.back_image_url;
                }
              }
            })
            .catch(error => console.error('Error loading verification:', error));
        });
      });
    });
  </script>
@endsection
