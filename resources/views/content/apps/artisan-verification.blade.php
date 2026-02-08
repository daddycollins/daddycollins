@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Identity Verification - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection

@section('page-script')
  @vite('resources/assets/js/app-ecommerce-settings.js')
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js'])
@endsection

@section('content')
  <div class="row g-6">
    <!-- Navigation -->
    <div class="col-12 col-lg-4">
      <div class="card bg-gradient border-0 shadow-sm"
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card-body p-6">
          <div class="d-flex align-items-center mb-4">
            <div class="avatar avatar-lg bg-white me-3">
              <div class="avatar-initial" style="color: #667eea;">
                <i class="icon-base ri ri-shield-check-line"></i>
              </div>
            </div>
            <div>
              <h5 class="mb-0 text-dark">Identity Verification</h5>
              <small class="text-muted">Complete your profile</small>
            </div>
          </div>
          <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <small class="text-dark">Verification Progress</small>
              <small class="text-dark fw-bold">{{ $isVerified ? '100%' : ($nationalDocument ? '50%' : '0%') }}</small>
            </div>
            <div class="progress" style="height: 6px; background-color: rgba(255,255,255,0.2);">
              <div class="progress-bar bg-white" role="progressbar"
                style="width: {{ $isVerified ? '100%' : ($nationalDocument ? '50%' : '0%') }}"
                aria-valuenow="{{ $isVerified ? '100' : ($nationalDocument ? '50' : '0') }}" aria-valuemin="0"
                aria-valuemax="100"></div>
            </div>
          </div>
          <div class="alert {{ $isVerified ? 'alert-success' : ($verification && $verification->status === 'rejected' ? 'alert-danger' : 'alert-warning') }} mb-0" role="alert">
            <div class="d-flex align-items-center">
              <i class="icon-base ri {{ $isVerified ? 'ri-check-circle-fill' : ($verification && $verification->status === 'rejected' ? 'ri-close-circle-fill' : 'ri-alert-circle-fill') }} me-2"></i>
              <span class="small fw-medium">
                @if ($isVerified)
                  Verified and approved
                @elseif ($verification && $verification->status === 'rejected')
                  Verification rejected - please resubmit
                @elseif ($nationalDocument)
                  Awaiting verification
                @else
                  Ready to upload
                @endif
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="card mt-4 border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center mb-4 pb-4 border-bottom">
            <div class="avatar avatar-md bg-label-primary me-3">
              <div class="avatar-initial"><i class="icon-base ri ri-id-card-line"></i></div>
            </div>
            <div>
              <h6 class="mb-1">National ID</h6>
              <p class="mb-0 small {{ $isVerified ? 'text-success' : 'text-warning' }}">
                <i class="icon-base ri {{ $isVerified ? 'ri-check-line' : 'ri-error-warning-line' }} me-1"></i>
                {{ $isVerified ? 'Verified' : ($nationalDocument ? 'Pending Review' : 'Not Uploaded') }}
              </p>
            </div>
          </div>
          <p class="text-muted small mb-3">
            @if ($nationalDocument)
              Your national ID has been submitted
              {{ $isVerified ? 'and verified successfully' : 'and is being reviewed' }}. This information is securely
              stored.
            @else
              Upload your national ID document to get started with verification.
            @endif
          </p>
          @if ($nationalDocument)
            <button type="button" class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="collapse"
              data-bs-target="#idDetails">
              <i class="icon-base ri ri-eye-line me-2"></i>View Details
            </button>
          @endif
        </div>
      </div>

      <div class="card mt-4 border-0 shadow-sm {{ $isVerified ? 'bg-light' : '' }}">
        <div class="card-body text-center py-6">
          <div class="avatar avatar-lg {{ $isVerified ? 'bg-label-success' : 'bg-label-warning' }} mx-auto mb-3">
            <div class="avatar-initial"><i
                class="icon-base ri {{ $isVerified ? 'ri-checkbox-circle-fill' : 'ri-time-line' }}"></i></div>
          </div>
          <h6 class="mb-2">{{ $isVerified ? 'All Set!' : 'In Progress' }}</h6>
          <p class="text-muted small mb-0">
            @if ($isVerified)
              Your identity verification is complete. You can now start earning.
            @else
              {{ $nationalDocument ? 'Your documents are being reviewed by our team.' : 'Upload your documents to begin the verification process.' }}
            @endif
          </p>
        </div>
      </div>
    </div>
    <!--/ Navigation -->
    <!-- Options -->
    <div class="col-12 col-lg-8 pt-lg-0">
      <div class="tab-content p-0">
        <!-- National ID Verification Tab -->
        <div class="tab-pane fade show active" id="national-id" role="tabpanel">

          <!-- Hero Section -->
          <div class="card mb-6 bg-gradient border-0 shadow-sm"
            style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);">
            <div class="card-body">
              <div class="row g-5 align-items-center">
                <div class="col-md-8">
                  <h4 class="mb-2">Secure Identity Verification</h4>
                  <p class="text-muted mb-0">Upload your national ID document. Our advanced OCR technology will extract
                    and verify your information automatically.</p>
                </div>
                <div class="col-md-4 text-center">
                  <div class="avatar avatar-2xl bg-label-primary mx-auto">
                    <div class="avatar-initial"><i class="icon-base ri ri-id-card-2-line"></i></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- ID Upload Card -->
          <div class="card mb-6 border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title m-0"><i class="icon-base ri ri-upload-cloud-2-line me-2 text-primary"></i>Upload Your
                ID</h5>
            </div>
            <div class="card-body">
              <p class="text-muted mb-5">Upload clear, high-quality images of both sides of your national ID. Make sure
                the entire document is visible and readable.</p>

              <form action="{{ route('artisan-document-upload') }}" method="POST" enctype="multipart/form-data"
                id="uploadForm">
                @csrf
                <div class="row g-5 mb-6">
                  <!-- ID Number -->
                  <div class="col-12">
                    <label class="form-label fw-medium">ID Number</label>
                    <input type="text" class="form-control" name="id_number"
                      value="{{ $nationalDocument->id_number ?? '' }}" placeholder="Enter your national ID number"
                      required />
                    @error('id_number')
                      <span class="text-danger small">{{ $message }}</span>
                    @enderror
                  </div>

                  <!-- Full Name -->
                  <div class="col-12">
                    <label class="form-label fw-medium">Full Name</label>
                    <input type="text" class="form-control" name="full_name"
                      value="{{ $nationalDocument->full_name ?? '' }}" placeholder="Enter your full name as on ID"
                      required />
                    @error('full_name')
                      <span class="text-danger small">{{ $message }}</span>
                    @enderror
                  </div>

                  <!-- Front Side Upload -->
                  <div class="col-md-6">
                    <label class="mb-3 d-block fw-medium">Front Side</label>
                    <div class="card border-2 border-dashed text-center p-6 mb-3 position-relative" id="frontUploadZone"
                      style="cursor: pointer; transition: all 0.3s ease; background-color: rgba(102, 126, 234, 0.02);"
                      onmouseover="this.style.backgroundColor='rgba(102, 126, 234, 0.08)'"
                      onmouseout="this.style.backgroundColor='rgba(102, 126, 234, 0.02)'">
                      <div id="frontUploadContent">
                        <div class="mb-3">
                          <i class="icon-base ri ri-image-add-line icon-56px text-primary"></i>
                        </div>
                        <h6 class="mb-1">Upload Front Image</h6>
                        <p class="text-muted small mb-0">Drag & drop or click to browse</p>
                      </div>
                      <input type="file" class="d-none" name="front_image" id="frontIdInput" accept="image/*" />
                    </div>
                    <div id="frontPreview" class="d-none">
                      <img id="frontImg" src="" alt="Front Side" class="img-fluid rounded mb-3"
                        style="max-height: 280px; width: 100%; object-fit: cover; border: 2px solid #667eea;" />
                      <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-danger flex-grow-1"
                          onclick="clearFrontImage()">
                          <i class="icon-base ri ri-delete-bin-line me-1"></i>Remove
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary flex-grow-1"
                          onclick="triggerFrontUpload()">
                          <i class="icon-base ri ri-refresh-line me-1"></i>Change
                        </button>
                      </div>
                    </div>
                    @error('front_image')
                      <span class="text-danger small d-block mt-2">{{ $message }}</span>
                    @enderror
                  </div>

                  <!-- Back Side Upload -->
                  <div class="col-md-6">
                    <label class="mb-3 d-block fw-medium">Back Side</label>
                    <div class="card border-2 border-dashed text-center p-6 mb-3 position-relative" id="backUploadZone"
                      style="cursor: pointer; transition: all 0.3s ease; background-color: rgba(102, 126, 234, 0.02);"
                      onmouseover="this.style.backgroundColor='rgba(102, 126, 234, 0.08)'"
                      onmouseout="this.style.backgroundColor='rgba(102, 126, 234, 0.02)'">
                      <div id="backUploadContent">
                        <div class="mb-3">
                          <i class="icon-base ri ri-image-add-line icon-56px text-primary"></i>
                        </div>
                        <h6 class="mb-1">Upload Back Image</h6>
                        <p class="text-muted small mb-0">Drag & drop or click to browse</p>
                      </div>
                      <input type="file" class="d-none" name="back_image" id="backIdInput" accept="image/*" />
                    </div>
                    <div id="backPreview" class="d-none">
                      <img id="backImg" src="" alt="Back Side" class="img-fluid rounded mb-3"
                        style="max-height: 280px; width: 100%; object-fit: cover; border: 2px solid #667eea;" />
                      <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-danger flex-grow-1"
                          onclick="clearBackImage()">
                          <i class="icon-base ri ri-delete-bin-line me-1"></i>Remove
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary flex-grow-1"
                          onclick="triggerBackUpload()">
                          <i class="icon-base ri ri-refresh-line me-1"></i>Change
                        </button>
                      </div>
                    </div>
                    @error('back_image')
                      <span class="text-danger small d-block mt-2">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <!-- Requirements -->
                <div class="alert alert-light border border-2" role="alert"
                  style="border-color: #667eea !important;">
                  <h6 class="mb-3 text-primary"><i class="icon-base ri ri-shield-check-line me-2"></i>Quality
                    Requirements
                  </h6>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <ul class="list-unstyled mb-0 small">
                        <li class="mb-2"><i class="icon-base ri ri-check-line text-success me-2"></i><strong>Clear &
                            Legible</strong> - No blurriness</li>
                        <li class="mb-2"><i class="icon-base ri ri-check-line text-success me-2"></i><strong>Full
                            View</strong> - Entire ID visible</li>
                        <li><i class="icon-base ri ri-check-line text-success me-2"></i><strong>No Shadows</strong> -
                          Bright lighting</li>
                      </ul>
                    </div>
                    <div class="col-md-6">
                      <ul class="list-unstyled mb-0 small">
                        <li class="mb-2"><i class="icon-base ri ri-check-line text-success me-2"></i><strong>Supported
                            Formats</strong> - JPG, PNG</li>
                        <li class="mb-2"><i class="icon-base ri ri-check-line text-success me-2"></i><strong>Max File
                            Size</strong> - 5MB per image</li>
                        <li><i class="icon-base ri ri-check-line text-success me-2"></i><strong>No Glare</strong> -
                          Readable text</li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="text-end mt-5">
                  <button type="reset" class="btn btn-outline-secondary me-2" onclick="resetForm()">
                    <i class="icon-base ri ri-refresh-line me-2"></i>Reset
                  </button>
                  <button type="submit" class="btn btn-primary" id="uploadBtn" disabled>
                    <i class="icon-base ri ri-upload-cloud-2-line me-2"></i>Upload & Verify
                  </button>
                </div>
              </form>
            </div>
          </div>

          <!-- OCR Extracted Data Card -->
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
              <h5 class="card-title m-0"><i
                  class="icon-base ri {{ $isVerified ? 'ri-checkbox-circle-line' : 'ri-file-search-line' }} me-2 {{ $isVerified ? 'text-success' : 'text-muted' }}"></i>{{ $isVerified ? 'Verification Complete' : 'Verification Result' }}
              </h5>
              @if ($nationalDocument && $nationalDocument->ocr_confidence)
                <span
                  class="badge {{ $nationalDocument->ocr_confidence >= 70 ? 'bg-success' : ($nationalDocument->ocr_confidence >= 40 ? 'bg-warning' : 'bg-danger') }} rounded-pill">
                  OCR Confidence: {{ number_format($nationalDocument->ocr_confidence, 1) }}%
                </span>
              @endif
            </div>
            <div class="card-body">
              @if ($nationalDocument)
                <div class="row g-5 mb-6">
                  <div class="col-md-6">
                    <div class="card bg-light border-0">
                      <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                          <div class="avatar avatar-sm bg-label-info me-3">
                            <div class="avatar-initial"><i class="icon-base ri ri-user-line"></i></div>
                          </div>
                          <h6 class="mb-0">Personal Information</h6>
                        </div>
                        <div class="mb-3">
                          <p class="mb-1 small text-muted">Full Name</p>
                          <h6 class="mb-0 fw-medium">{{ $nationalDocument->full_name }}</h6>
                        </div>
                        <div class="mb-3">
                          <p class="mb-1 small text-muted">ID Number</p>
                          <h6 class="mb-0 font-monospace fw-medium">{{ $nationalDocument->id_number }}</h6>
                        </div>
                        <div class="mb-0">
                          <p class="mb-1 small text-muted">Status</p>
                          <span class="badge bg-label-{{ $isVerified ? 'success' : ($verification && $verification->status === 'rejected' ? 'danger' : 'warning') }}">
                            {{ $isVerified ? 'Verified' : ($verification && $verification->status === 'rejected' ? 'Rejected' : 'Pending Review') }}
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="card bg-light border-0">
                      <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                          <div class="avatar avatar-sm bg-label-warning me-3">
                            <div class="avatar-initial"><i class="icon-base ri ri-scan-line"></i></div>
                          </div>
                          <h6 class="mb-0">OCR Extracted Data</h6>
                        </div>
                        @if ($nationalDocument->date_of_birth)
                          <div class="mb-3">
                            <p class="mb-1 small text-muted">Date of Birth</p>
                            <h6 class="mb-0 fw-medium">{{ $nationalDocument->date_of_birth->format('M d, Y') }}</h6>
                          </div>
                        @endif
                        @if ($nationalDocument->issue_date)
                          <div class="mb-3">
                            <p class="mb-1 small text-muted">Issue Date</p>
                            <h6 class="mb-0 fw-medium">{{ $nationalDocument->issue_date->format('M d, Y') }}</h6>
                          </div>
                        @endif
                        @if ($nationalDocument->expiry_date)
                          <div class="mb-3">
                            <p class="mb-1 small text-muted">Expiry Date</p>
                            <h6 class="mb-0 fw-medium">
                              {{ $nationalDocument->expiry_date->format('M d, Y') }}
                              @if ($nationalDocument->expiry_date->isFuture())
                                <span class="badge bg-label-success ms-1">Valid</span>
                              @else
                                <span class="badge bg-label-danger ms-1">Expired</span>
                              @endif
                            </h6>
                          </div>
                        @endif
                        @if (!$nationalDocument->date_of_birth && !$nationalDocument->issue_date && !$nationalDocument->expiry_date)
                          <p class="text-muted small mb-0">No additional data extracted by OCR.</p>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>

                @if ($verification && $verification->remarks)
                  <div class="alert alert-{{ $verification->status === 'approved' ? 'success' : ($verification->status === 'rejected' ? 'danger' : 'info') }} mb-4">
                    <div class="d-flex align-items-start">
                      <i class="icon-base ri ri-information-line me-2" style="font-size: 1.1rem;"></i>
                      <div>
                        <strong>Verification Note:</strong>
                        <p class="mb-0 small mt-1">{{ $verification->remarks }}</p>
                      </div>
                    </div>
                  </div>
                @endif

                @if ($isVerified)
                  <div class="alert alert-success border-2" role="alert" style="border-color: #28a745 !important;">
                    <div class="d-flex align-items-start">
                      <i class="icon-base ri ri-check-circle-fill me-3 text-success" style="font-size: 1.25rem;"></i>
                      <div>
                        <h6 class="mb-2">Identity Verified Successfully!</h6>
                        <p class="mb-0 small">Your national ID has been verified and matched with our system. You can now
                          start offering services on ArtisanConnect.</p>
                      </div>
                    </div>
                  </div>

                  <a href="{{ route('artisan-dashboard') }}" class="btn btn-primary w-100">
                    <i class="icon-base ri ri-arrow-right-line me-2"></i>Continue to Dashboard
                  </a>
                @elseif ($verification && $verification->status === 'rejected')
                  <div class="alert alert-danger border-2" role="alert" style="border-color: #dc3545 !important;">
                    <div class="d-flex align-items-start">
                      <i class="icon-base ri ri-close-circle-fill me-3 text-danger" style="font-size: 1.25rem;"></i>
                      <div>
                        <h6 class="mb-2">Verification Rejected</h6>
                        <p class="mb-0 small">Your verification was not approved. Please review the notes above and
                          re-upload your documents with the necessary corrections.</p>
                      </div>
                    </div>
                  </div>

                  <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal"
                    data-bs-target="#editDataModal">
                    <i class="icon-base ri ri-edit-line me-2"></i>Edit & Resubmit
                  </button>
                @else
                  <div class="alert alert-info border-2" role="alert" style="border-color: #0dcaf0 !important;">
                    <div class="d-flex align-items-start">
                      <i class="icon-base ri ri-information-line me-3 text-info" style="font-size: 1.25rem;"></i>
                      <div>
                        <h6 class="mb-2">Verification Pending</h6>
                        <p class="mb-0 small">Your documents have been submitted and processed by OCR.
                          @if ($nationalDocument->ocr_confidence && $nationalDocument->ocr_confidence >= 70)
                            The confidence score is high — verification may happen automatically.
                          @else
                            An admin will review your submission shortly. This usually takes 1-2 business days.
                          @endif
                        </p>
                      </div>
                    </div>
                  </div>

                  <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal"
                    data-bs-target="#editDataModal">
                    <i class="icon-base ri ri-edit-line me-2"></i>Edit Information
                  </button>
                @endif
              @else
                <div class="text-center py-8">
                  <i class="icon-base ri ri-file-search-line icon-64px text-muted mb-4 d-block"></i>
                  <h6 class="mb-2">No Documents Uploaded</h6>
                  <p class="text-muted small mb-0">Upload your national ID documents above to begin the verification
                    process</p>
                </div>
              @endif
            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- /Options-->
  </div>

  <!-- Edit Document Data Modal -->
  <div class="modal fade" id="editDataModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-edit-line me-2 text-primary"></i>Update Document Information
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('artisan-document-update') }}" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-body py-5">
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label fw-medium">Full Name</label>
                <input type="text" class="form-control" name="full_name"
                  value="{{ $nationalDocument->full_name ?? '' }}" required />
                @error('full_name')
                  <span class="text-danger small">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">ID Number</label>
                <input type="text" class="form-control font-monospace" name="id_number"
                  value="{{ $nationalDocument->id_number ?? '' }}" required />
                @error('id_number')
                  <span class="text-danger small">{{ $message }}</span>
                @enderror
              </div>
            </div>
          </div>
          <div class="modal-footer border-top py-4">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <i class="icon-base ri ri-save-line me-2"></i>Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    // File upload handlers
    document.getElementById('frontUploadZone').addEventListener('click', () => document.getElementById('frontIdInput')
      .click());
    document.getElementById('backUploadZone').addEventListener('click', () => document.getElementById('backIdInput')
      .click());

    function triggerFrontUpload() {
      document.getElementById('frontIdInput').click();
    }

    function triggerBackUpload() {
      document.getElementById('backIdInput').click();
    }

    document.getElementById('frontIdInput').addEventListener('change', function(e) {
      handleImageUpload(e, 'frontPreview', 'frontImg', 'frontUploadContent');
      checkUploadComplete();
    });

    document.getElementById('backIdInput').addEventListener('change', function(e) {
      handleImageUpload(e, 'backPreview', 'backImg', 'backUploadContent');
      checkUploadComplete();
    });

    function handleImageUpload(event, previewId, imgId, uploadContentId) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById(imgId).src = e.target.result;
          document.getElementById(previewId).classList.remove('d-none');
          if (uploadContentId) {
            document.getElementById(uploadContentId).classList.add('d-none');
          }
        };
        reader.readAsDataURL(file);
      }
    }

    function clearFrontImage() {
      document.getElementById('frontIdInput').value = '';
      document.getElementById('frontPreview').classList.add('d-none');
      document.getElementById('frontUploadContent').classList.remove('d-none');
      checkUploadComplete();
    }

    function clearBackImage() {
      document.getElementById('backIdInput').value = '';
      document.getElementById('backPreview').classList.add('d-none');
      document.getElementById('backUploadContent').classList.remove('d-none');
      checkUploadComplete();
    }

    function checkUploadComplete() {
      const frontLoaded = document.getElementById('frontIdInput').files.length > 0;
      const backLoaded = document.getElementById('backIdInput').files.length > 0;
      document.getElementById('uploadBtn').disabled = !(frontLoaded && backLoaded);
    }

    function resetForm() {
      document.getElementById('uploadForm').reset();
      clearFrontImage();
      clearBackImage();
    }
  </script>
@endsection
