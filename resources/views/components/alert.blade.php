{{-- Reusable Alert Component for Flash Messages --}}

@if (session('success'))
  <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    <div class="d-flex align-items-center">
      <i class="ri ri-check-circle-line me-2 fs-5"></i>
      <div>
        <h6 class="alert-heading mb-0">Success!</h6>
        <small>{{ session('success') }}</small>
      </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if (session('error'))
  <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
    <div class="d-flex align-items-center">
      <i class="ri ri-error-warning-line me-2 fs-5"></i>
      <div>
        <h6 class="alert-heading mb-0">Error!</h6>
        <small>{{ session('error') }}</small>
      </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if (session('warning'))
  <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
    <div class="d-flex align-items-center">
      <i class="ri ri-alert-line me-2 fs-5"></i>
      <div>
        <h6 class="alert-heading mb-0">Warning!</h6>
        <small>{{ session('warning') }}</small>
      </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if (session('info'))
  <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
    <div class="d-flex align-items-center">
      <i class="ri ri-information-line me-2 fs-5"></i>
      <div>
        <h6 class="alert-heading mb-0">Information</h6>
        <small>{{ session('info') }}</small>
      </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
