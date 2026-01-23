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
              <h5 class="mb-0 text-white">Identity Verification</h5>
              <small class="text-white-75">Complete your profile</small>
            </div>
          </div>
          <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <small class="text-white">Verification Progress</small>
              <small class="text-white fw-bold">100%</small>
            </div>
            <div class="progress" style="height: 6px; background-color: rgba(255,255,255,0.2);">
              <div class="progress-bar bg-white" role="progressbar" style="width: 100%" aria-valuenow="100"
                aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
          <div class="alert alert-light mb-0" role="alert">
            <div class="d-flex align-items-center">
              <i class="icon-base ri ri-check-circle-fill text-success me-2"></i>
              <span class="small fw-medium">Ready for verification</span>
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
              <p class="mb-0 small text-success"><i class="icon-base ri ri-check-line me-1"></i>Verified</p>
            </div>
          </div>
          <p class="text-muted small mb-3">Your national ID has been submitted and verified successfully. This information
            is securely stored.</p>
          <button type="button" class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="collapse"
            data-bs-target="#idDetails">
            <i class="icon-base ri ri-eye-line me-2"></i>View Details
          </button>
        </div>
      </div>

      <div class="card mt-4 border-0 shadow-sm bg-light">
        <div class="card-body text-center py-6">
          <div class="avatar avatar-lg bg-label-success mx-auto mb-3">
            <div class="avatar-initial"><i class="icon-base ri ri-checkbox-circle-fill"></i></div>
          </div>
          <h6 class="mb-2">All Set!</h6>
          <p class="text-muted small mb-0">Your identity verification is complete. You can now start earning.</p>
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

              <div class="row g-5 mb-6">
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
                    <input type="file" class="d-none" id="frontIdInput" accept="image/*" />
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
                    <input type="file" class="d-none" id="backIdInput" accept="image/*" />
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
                </div>
              </div>

              <!-- Requirements -->
              <div class="alert alert-light border border-2" role="alert" style="border-color: #667eea !important;">
                <h6 class="mb-3 text-primary"><i class="icon-base ri ri-shield-check-line me-2"></i>Quality Requirements
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
                <button type="button" class="btn btn-outline-secondary me-2" onclick="resetForm()">
                  <i class="icon-base ri ri-refresh-line me-2"></i>Reset
                </button>
                <button type="button" class="btn btn-primary" id="uploadBtn" onclick="submitIDVerification()"
                  disabled>
                  <i class="icon-base ri ri-upload-cloud-2-line me-2"></i>Process & Verify
                </button>
              </div>
            </div>
          </div>

          <!-- OCR Extracted Data Card -->
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="card-title m-0"><i
                  class="icon-base ri ri-checkbox-circle-line me-2 text-success"></i>Verification Result</h5>
            </div>
            <div class="card-body">
              <div id="ocrLoading" class="text-center py-8 d-none">
                <div class="mb-4">
                  <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Processing...</span>
                  </div>
                </div>
                <h6 class="mb-2">Processing Your Documents</h6>
                <p class="text-muted small mb-0">Our OCR technology is extracting information from your ID. This usually
                  takes 10-15 seconds.</p>
              </div>

              <div id="ocrResults" class="d-none">
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
                          <h6 class="mb-0 fw-medium" id="ocrName">-</h6>
                        </div>
                        <div class="mb-3">
                          <p class="mb-1 small text-muted">Date of Birth</p>
                          <h6 class="mb-0 fw-medium" id="ocrDob">-</h6>
                        </div>
                        <div class="mb-0">
                          <p class="mb-1 small text-muted">Gender</p>
                          <h6 class="mb-0 fw-medium" id="ocrGender">-</h6>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="card bg-light border-0">
                      <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                          <div class="avatar avatar-sm bg-label-warning me-3">
                            <div class="avatar-initial"><i class="icon-base ri ri-id-card-line"></i></div>
                          </div>
                          <h6 class="mb-0">Document Details</h6>
                        </div>
                        <div class="mb-3">
                          <p class="mb-1 small text-muted">ID Number</p>
                          <h6 class="mb-0 font-monospace fw-medium" id="ocrIdNumber">-</h6>
                        </div>
                        <div class="mb-3">
                          <p class="mb-1 small text-muted">Expires On</p>
                          <h6 class="mb-0 fw-medium" id="ocrExpiryDate">-</h6>
                        </div>
                        <div class="mb-0">
                          <p class="mb-1 small text-muted">Status</p>
                          <span class="badge bg-label-success">Valid</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

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

                <button type="button" class="btn btn-primary w-100" onclick="completeVerification()">
                  <i class="icon-base ri ri-arrow-right-line me-2"></i>Continue to Dashboard
                </button>
              </div>

              <div id="noOcrData" class="text-center py-8">
                <i class="icon-base ri ri-file-search-line icon-64px text-muted mb-4 d-block"></i>
                <h6 class="mb-2">No Data Yet</h6>
                <p class="text-muted small mb-0">Upload your ID documents above to see the extracted information</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- /Options-->
  </div>

  <!-- Edit OCR Data Modal -->
  <div class="modal fade" id="editDataModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-edit-line me-2 text-primary"></i>Update Information</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body py-5">
          <form id="editOcrForm">
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label fw-medium">Full Name</label>
                <input type="text" class="form-control" id="editName" value="John Mbewe" />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Date of Birth</label>
                <input type="date" class="form-control" id="editDob" value="1990-05-15" />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Gender</label>
                <select class="form-select" id="editGender">
                  <option value="Male" selected>Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">ID Number</label>
                <input type="text" class="form-control font-monospace" id="editIdNumber" value="AB123456" />
              </div>
              <div class="col-md-12">
                <label class="form-label fw-medium">Expiry Date</label>
                <input type="date" class="form-control" id="editExpiryDate" value="2030-01-15" />
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer border-top py-4">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="saveOcrCorrection()">
            <i class="icon-base ri ri-save-line me-2"></i>Save Changes
          </button>
        </div>
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
      clearFrontImage();
      clearBackImage();
      document.getElementById('noOcrData').classList.remove('d-none');
      document.getElementById('ocrResults').classList.add('d-none');
      document.getElementById('ocrLoading').classList.add('d-none');
    }

    function submitIDVerification() {
      // Show OCR processing
      document.getElementById('noOcrData').classList.add('d-none');
      document.getElementById('ocrResults').classList.add('d-none');
      document.getElementById('ocrLoading').classList.remove('d-none');

      // Simulate OCR processing
      setTimeout(() => {
        document.getElementById('ocrLoading').classList.add('d-none');
        document.getElementById('ocrResults').classList.remove('d-none');
        // Populate sample extracted data
        document.getElementById('ocrName').textContent = 'John Mbewe';
        document.getElementById('ocrDob').textContent = '15 May 1990';
        document.getElementById('ocrGender').textContent = 'Male';
        document.getElementById('ocrIdNumber').textContent = 'AB-123456';
        document.getElementById('ocrExpiryDate').textContent = '15 January 2030';
      }, 2500);
    }

    function completeVerification() {
      alert('🎉 Verification complete! Welcome to ArtisanConnect.');
      window.location.href = '/artisan-dashboard';
    }

    function saveOcrCorrection() {
      const modal = bootstrap.Modal.getInstance(document.getElementById('editDataModal'));
      modal.hide();
      alert('✓ Corrections saved and verified!');
    }
  </script>
@endsection
<div class="card mb-6">
  <div class="card-header">
    <h5 class="card-title m-0">Upload National ID</h5>
  </div>
  <div class="card-body">
    <p class="text-muted mb-4">Upload clear images of your national ID document. Both front and back sides are
      required for verification.</p>

    <div class="row g-4 mb-5">
      <!-- Front Side Upload -->
      <div class="col-md-6">
        <div class="card border-2 border-dashed text-center p-5 mb-3" id="frontUploadZone"
          style="cursor: pointer; transition: all 0.3s ease;">
          <div class="mb-3">
            <i class="icon-base ri ri-image-add-line icon-48px text-primary"></i>
          </div>
          <h6 class="mb-1">ID Front Side</h6>
          <p class="text-muted small mb-0">Drag & drop or click to upload</p>
          <input type="file" class="d-none" id="frontIdInput" accept="image/*" />
        </div>
        <div id="frontPreview" class="d-none">
          <img id="frontImg" src="" alt="Front Side" class="img-fluid rounded mb-2"
            style="max-height: 250px; width: 100%; object-fit: cover;" />
          <button type="button" class="btn btn-sm btn-outline-danger w-100" onclick="clearFrontImage()">Remove
            Image</button>
        </div>
      </div>

      <!-- Back Side Upload -->
      <div class="col-md-6">
        <div class="card border-2 border-dashed text-center p-5 mb-3" id="backUploadZone"
          style="cursor: pointer; transition: all 0.3s ease;">
          <div class="mb-3">
            <i class="icon-base ri ri-image-add-line icon-48px text-primary"></i>
          </div>
          <h6 class="mb-1">ID Back Side</h6>
          <p class="text-muted small mb-0">Drag & drop or click to upload</p>
          <input type="file" class="d-none" id="backIdInput" accept="image/*" />
        </div>
        <div id="backPreview" class="d-none">
          <img id="backImg" src="" alt="Back Side" class="img-fluid rounded mb-2"
            style="max-height: 250px; width: 100%; object-fit: cover;" />
          <button type="button" class="btn btn-sm btn-outline-danger w-100" onclick="clearBackImage()">Remove
            Image</button>
        </div>
      </div>
    </div>

    <!-- Requirements -->
    <div class="alert alert-info" role="alert">
      <h6 class="mb-3"><i class="icon-base ri ri-information-line me-2"></i>Image Requirements</h6>
      <ul class="list-unstyled mb-0 small">
        <li class="mb-1"><i class="icon-base ri ri-check-line text-success me-2"></i>Clear and legible image
        </li>
        <li class="mb-1"><i class="icon-base ri ri-check-line text-success me-2"></i>Entire ID visible in
          frame</li>
        <li class="mb-1"><i class="icon-base ri ri-check-line text-success me-2"></i>JPG, PNG format (max
          5MB)</li>
        <li><i class="icon-base ri ri-check-line text-success me-2"></i>No glare or shadows</li>
      </ul>
    </div>

    <button type="button" class="btn btn-primary" id="uploadBtn" onclick="submitIDVerification()" disabled>
      <i class="icon-base ri ri-upload-cloud-2-line me-2"></i>Submit for Verification
    </button>
  </div>
</div>

<!-- OCR Extracted Data Card -->
<div class="card mb-6">
  <div class="card-header">
    <h5 class="card-title m-0">OCR Extracted Information</h5>
  </div>
  <div class="card-body">
    <div id="ocrLoading" class="text-center py-5 d-none">
      <div class="spinner-border text-primary mb-3" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="text-muted">Processing your documents with OCR technology...</p>
    </div>

    <div id="ocrResults" class="d-none">
      <div class="row g-4">
        <div class="col-md-6">
          <div class="card bg-light">
            <div class="card-body">
              <h6 class="mb-3">Personal Information</h6>
              <div class="mb-3">
                <p class="mb-1 small text-muted">Full Name</p>
                <h6 class="mb-0" id="ocrName">-</h6>
              </div>
              <div class="mb-3">
                <p class="mb-1 small text-muted">Date of Birth</p>
                <h6 class="mb-0" id="ocrDob">-</h6>
              </div>
              <div class="mb-3">
                <p class="mb-1 small text-muted">Gender</p>
                <h6 class="mb-0" id="ocrGender">-</h6>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card bg-light">
            <div class="card-body">
              <h6 class="mb-3">ID Information</h6>
              <div class="mb-3">
                <p class="mb-1 small text-muted">ID Number</p>
                <h6 class="mb-0 font-monospace" id="ocrIdNumber">-</h6>
              </div>
              <div class="mb-3">
                <p class="mb-1 small text-muted">Issue Date</p>
                <h6 class="mb-0" id="ocrIssueDate">-</h6>
              </div>
              <div class="mb-3">
                <p class="mb-1 small text-muted">Expiry Date</p>
                <h6 class="mb-0" id="ocrExpiryDate">-</h6>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="alert alert-warning mt-4 mb-0" role="alert">
        <h6 class="mb-2"><i class="icon-base ri ri-alert-line me-2"></i>Verification Matching</h6>
        <p class="mb-2 small">Please verify that the extracted information matches your profile data:</p>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-sm btn-success" onclick="confirmData()">
            <i class="icon-base ri ri-check-line me-1"></i>Data Matches
          </button>
          <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
            data-bs-target="#editDataModal">
            <i class="icon-base ri ri-edit-line me-1"></i>Correct Information
          </button>
        </div>
      </div>
    </div>

    <div id="noOcrData" class="text-center py-5">
      <i class="icon-base ri ri-file-search-line icon-48px text-muted mb-3 d-block"></i>
      <p class="text-muted">Upload your ID documents to see extracted information</p>
    </div>
  </div>
</div>

<!-- Action Buttons -->
<div class="d-flex justify-content-end gap-4">
  <button type="reset" class="btn btn-outline-secondary">Reset</button>
  <button type="button" class="btn btn-primary" onclick="saveVerification()">Save & Continue</button>
</div>

</div>
</div>
</div>
<!-- /Options-->
</div>

<!-- Edit OCR Data Modal -->
<div class="modal fade" id="editDataModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Correct OCR Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editOcrForm">
          <div class="row g-4">
            <div class="col-md-6">
              <label class="form-label">Full Name</label>
              <input type="text" class="form-control" id="editName" value="John Mbewe" />
            </div>
            <div class="col-md-6">
              <label class="form-label">Date of Birth</label>
              <input type="date" class="form-control" id="editDob" value="1990-05-15" />
            </div>
            <div class="col-md-6">
              <label class="form-label">Gender</label>
              <select class="form-select" id="editGender">
                <option value="Male" selected>Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">ID Number</label>
              <input type="text" class="form-control font-monospace" id="editIdNumber" value="AB123456" />
            </div>
            <div class="col-md-6">
              <label class="form-label">Issue Date</label>
              <input type="date" class="form-control" id="editIssueDate" value="2020-01-15" />
            </div>
            <div class="col-md-6">
              <label class="form-label">Expiry Date</label>
              <input type="date" class="form-control" id="editExpiryDate" value="2030-01-15" />
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="saveOcrCorrection()">Save Changes</button>
      </div>
    </div>
  </div>
</div>

<script>
  // File upload handlers
  document.getElementById('frontUploadZone').addEventListener('click', () => document.getElementById('frontIdInput')
    .click());
  document.getElementById('backUploadZone').addEventListener('click', () => document.getElementById('backIdInput')
    .click());

  document.getElementById('frontIdInput').addEventListener('change', function(e) {
    handleImageUpload(e, 'frontPreview', 'frontImg');
    checkUploadComplete();
  });

  document.getElementById('backIdInput').addEventListener('change', function(e) {
    handleImageUpload(e, 'backPreview', 'backImg');
    checkUploadComplete();
  });

  function handleImageUpload(event, previewId, imgId) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById(imgId).src = e.target.result;
        document.getElementById(previewId).classList.remove('d-none');
      };
      reader.readAsDataURL(file);
    }
  }

  function clearFrontImage() {
    document.getElementById('frontIdInput').value = '';
    document.getElementById('frontPreview').classList.add('d-none');
    checkUploadComplete();
  }

  function clearBackImage() {
    document.getElementById('backIdInput').value = '';
    document.getElementById('backPreview').classList.add('d-none');
    checkUploadComplete();
  }

  function checkUploadComplete() {
    const frontLoaded = document.getElementById('frontIdInput').files.length > 0;
    const backLoaded = document.getElementById('backIdInput').files.length > 0;
    document.getElementById('uploadBtn').disabled = !(frontLoaded && backLoaded);
  }

  function submitIDVerification() {
    // Show OCR processing
    document.getElementById('noOcrData').classList.add('d-none');
    document.getElementById('ocrLoading').classList.remove('d-none');

    // Simulate OCR processing
    setTimeout(() => {
      document.getElementById('ocrLoading').classList.add('d-none');
      document.getElementById('ocrResults').classList.remove('d-none');
      // Populate sample extracted data
      document.getElementById('ocrName').textContent = 'John Mbewe';
      document.getElementById('ocrDob').textContent = '15/05/1990';
      document.getElementById('ocrGender').textContent = 'Male';
      document.getElementById('ocrIdNumber').textContent = 'AB123456';
      document.getElementById('ocrIssueDate').textContent = '15/01/2020';
      document.getElementById('ocrExpiryDate').textContent = '15/01/2030';
    }, 2000);
  }

  function confirmData() {
    alert('Data confirmed and saved!');
  }

  function saveOcrCorrection() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('editDataModal'));
    modal.hide();
    alert('Corrections saved successfully!');
  }

  function saveVerification() {
    alert('Verification data submitted for processing!');
  }
</script>
@endsection
