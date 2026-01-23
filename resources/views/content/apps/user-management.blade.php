@extends('layouts/layoutMaster')

@section('title', 'Users Management - ArtisanConnect Admin')

<!-- Vendor Styles -->
@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/animate-css/animate.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
  @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('content')
  <!-- Header -->
  <div
    class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-between mb-6 text-center text-sm-start gap-2">
    <div class="mb-2 mb-sm-0">
      <h4 class="mb-1"><i class="icon-base ri ri-team-line me-2 text-primary"></i>Users Management</h4>
      <p class="mb-0">Manage all users, artisans, and customers on the platform</p>
    </div>
  </div>

  <!-- Statistics Cards -->
  <div class="row g-6 mb-6">
    <div class="col-sm-6 col-xl-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Total Users</p>
              <h3 class="mb-2">1,248</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>+12.5% MTD</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-primary">
              <div class="avatar-initial"><i class="icon-base ri ri-user-3-line"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Active Users</p>
              <h3 class="mb-2">956</h3>
              <p class="mb-0"><span class="badge bg-label-success">76.6% active</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-success">
              <div class="avatar-initial"><i class="icon-base ri ri-login-circle-line"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Suspended</p>
              <h3 class="mb-2">48</h3>
              <p class="mb-0"><span class="badge bg-label-warning">3.8% suspended</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-warning">
              <div class="avatar-initial"><i class="icon-base ri ri-shield-close-line"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Verified</p>
              <h3 class="mb-2">342</h3>
              <p class="mb-0"><span class="badge bg-label-info">27.4% verified</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-info">
              <div class="avatar-initial"><i class="icon-base ri ri-verified-badge-line"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Users List Table -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
      <h5 class="card-title m-0"><i class="icon-base ri ri-list-check me-2"></i>All Users</h5>
      <div class="d-flex gap-2">
        <div class="input-group input-group-sm" style="width: 250px;">
          <span class="input-group-text border-0"><i class="icon-base ri ri-search-line"></i></span>
          <input type="text" class="form-control form-control-sm border-0" placeholder="Search users..."
            id="userSearch">
        </div>
        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#filterPanel">
          <i class="icon-base ri ri-filter-line me-1"></i>Filters
        </button>
      </div>
    </div>

    <!-- Filter Panel -->
    <div class="collapse" id="filterPanel">
      <div class="card-body border-bottom">
        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label">User Type</label>
            <select class="form-select form-select-sm" id="filterType">
              <option value="">All Types</option>
              <option value="customer">Customer</option>
              <option value="artisan">Artisan</option>
              <option value="admin">Admin</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Status</label>
            <select class="form-select form-select-sm" id="filterStatus">
              <option value="">All Status</option>
              <option value="active">Active</option>
              <option value="suspended">Suspended</option>
              <option value="pending">Pending</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Verification</label>
            <select class="form-select form-select-sm" id="filterVerified">
              <option value="">All</option>
              <option value="verified">Verified</option>
              <option value="unverified">Unverified</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">&nbsp;</label>
            <button class="btn btn-sm btn-outline-secondary w-100" id="resetFilters">Reset Filters</button>
          </div>
        </div>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="bg-light">
          <tr>
            <th class="py-3">User</th>
            <th class="py-3">Email</th>
            <th class="py-3">Type</th>
            <th class="py-3">Location</th>
            <th class="py-3">Join Date</th>
            <th class="py-3">Status</th>
            <th class="py-3">Verified</th>
            <th class="py-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- User 1 -->
          <tr>
            <td class="py-3">
              <div class="d-flex align-items-center gap-3">
                <img src="/images/avatars/1.png" alt="avatar" class="rounded-circle"
                  style="width: 40px; height: 40px;">
                <div>
                  <h6 class="mb-0">John Doe</h6>
                  <small class="text-muted">ID: U#001</small>
                </div>
              </div>
            </td>
            <td class="py-3">john.doe@email.com</td>
            <td class="py-3"><span class="badge bg-label-info">Customer</span></td>
            <td class="py-3">Harare, Zimbabwe</td>
            <td class="py-3">Jan 5, 2024</td>
            <td class="py-3">
              <span class="badge bg-label-success">Active</span>
            </td>
            <td class="py-3">
              <span class="badge bg-label-success"><i class="icon-base ri ri-check-line"></i>Verified</span>
            </td>
            <td class="py-3">
              <div class="dropdown">
                <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                  <i class="icon-base ri ri-more-2-line"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" data-action="view"><i
                        class="icon-base ri ri-eye-line me-2"></i>View</a></li>
                  <li><a class="dropdown-item" href="#" data-action="suspend"><i
                        class="icon-base ri ri-shield-close-line me-2"></i>Suspend</a></li>
                  <li><a class="dropdown-item" href="#" data-action="edit"><i
                        class="icon-base ri ri-edit-line me-2"></i>Edit</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item text-danger" href="#" data-action="delete"><i
                        class="icon-base ri ri-delete-bin-line me-2"></i>Delete</a></li>
                </ul>
              </div>
            </td>
          </tr>

          <!-- User 2 -->
          <tr>
            <td class="py-3">
              <div class="d-flex align-items-center gap-3">
                <img src="/images/avatars/2.png" alt="avatar" class="rounded-circle"
                  style="width: 40px; height: 40px;">
                <div>
                  <h6 class="mb-0">James Smith</h6>
                  <small class="text-muted">ID: A#001</small>
                </div>
              </div>
            </td>
            <td class="py-3">james.smith@email.com</td>
            <td class="py-3"><span class="badge bg-label-warning">Artisan</span></td>
            <td class="py-3">Bulawayo, Zimbabwe</td>
            <td class="py-3">Dec 20, 2023</td>
            <td class="py-3">
              <span class="badge bg-label-success">Active</span>
            </td>
            <td class="py-3">
              <span class="badge bg-label-success"><i class="icon-base ri ri-check-line"></i>Verified</span>
            </td>
            <td class="py-3">
              <div class="dropdown">
                <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                  <i class="icon-base ri ri-more-2-line"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" data-action="view"><i
                        class="icon-base ri ri-eye-line me-2"></i>View</a></li>
                  <li><a class="dropdown-item" href="#" data-action="suspend"><i
                        class="icon-base ri ri-shield-close-line me-2"></i>Suspend</a></li>
                  <li><a class="dropdown-item" href="#" data-action="edit"><i
                        class="icon-base ri ri-edit-line me-2"></i>Edit</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item text-danger" href="#" data-action="delete"><i
                        class="icon-base ri ri-delete-bin-line me-2"></i>Delete</a></li>
                </ul>
              </div>
            </td>
          </tr>

          <!-- User 3 - Suspended -->
          <tr style="opacity: 0.7;">
            <td class="py-3">
              <div class="d-flex align-items-center gap-3">
                <img src="/images/avatars/3.png" alt="avatar" class="rounded-circle"
                  style="width: 40px; height: 40px;">
                <div>
                  <h6 class="mb-0">Maria Garcia</h6>
                  <small class="text-muted">ID: C#002</small>
                </div>
              </div>
            </td>
            <td class="py-3">maria.garcia@email.com</td>
            <td class="py-3"><span class="badge bg-label-info">Customer</span></td>
            <td class="py-3">Chitungwiza, Zimbabwe</td>
            <td class="py-3">Jan 3, 2024</td>
            <td class="py-3">
              <span class="badge bg-label-danger">Suspended</span>
            </td>
            <td class="py-3">
              <span class="badge bg-label-warning"><i class="icon-base ri ri-time-line"></i>Pending</span>
            </td>
            <td class="py-3">
              <div class="dropdown">
                <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                  <i class="icon-base ri ri-more-2-line"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" data-action="view"><i
                        class="icon-base ri ri-eye-line me-2"></i>View</a></li>
                  <li><a class="dropdown-item" href="#" data-action="activate"><i
                        class="icon-base ri ri-check-double-line me-2"></i>Activate</a></li>
                  <li><a class="dropdown-item" href="#" data-action="edit"><i
                        class="icon-base ri ri-edit-line me-2"></i>Edit</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item text-danger" href="#" data-action="delete"><i
                        class="icon-base ri ri-delete-bin-line me-2"></i>Delete</a></li>
                </ul>
              </div>
            </td>
          </tr>

          <!-- User 4 -->
          <tr>
            <td class="py-3">
              <div class="d-flex align-items-center gap-3">
                <img src="/images/avatars/4.png" alt="avatar" class="rounded-circle"
                  style="width: 40px; height: 40px;">
                <div>
                  <h6 class="mb-0">Robert Brown</h6>
                  <small class="text-muted">ID: A#002</small>
                </div>
              </div>
            </td>
            <td class="py-3">robert.brown@email.com</td>
            <td class="py-3"><span class="badge bg-label-warning">Artisan</span></td>
            <td class="py-3">Harare, Zimbabwe</td>
            <td class="py-3">Jan 1, 2024</td>
            <td class="py-3">
              <span class="badge bg-label-success">Active</span>
            </td>
            <td class="py-3">
              <span class="badge bg-label-success"><i class="icon-base ri ri-check-line"></i>Verified</span>
            </td>
            <td class="py-3">
              <div class="dropdown">
                <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                  <i class="icon-base ri ri-more-2-line"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" data-action="view"><i
                        class="icon-base ri ri-eye-line me-2"></i>View</a></li>
                  <li><a class="dropdown-item" href="#" data-action="suspend"><i
                        class="icon-base ri ri-shield-close-line me-2"></i>Suspend</a></li>
                  <li><a class="dropdown-item" href="#" data-action="edit"><i
                        class="icon-base ri ri-edit-line me-2"></i>Edit</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item text-danger" href="#" data-action="delete"><i
                        class="icon-base ri ri-delete-bin-line me-2"></i>Delete</a></li>
                </ul>
              </div>
            </td>
          </tr>

          <!-- User 5 -->
          <tr>
            <td class="py-3">
              <div class="d-flex align-items-center gap-3">
                <img src="/images/avatars/5.png" alt="avatar" class="rounded-circle"
                  style="width: 40px; height: 40px;">
                <div>
                  <h6 class="mb-0">Lisa Martinez</h6>
                  <small class="text-muted">ID: C#003</small>
                </div>
              </div>
            </td>
            <td class="py-3">lisa.martinez@email.com</td>
            <td class="py-3"><span class="badge bg-label-info">Customer</span></td>
            <td class="py-3">Norton, Zimbabwe</td>
            <td class="py-3">Jan 10, 2024</td>
            <td class="py-3">
              <span class="badge bg-label-success">Active</span>
            </td>
            <td class="py-3">
              <span class="badge bg-label-danger"><i class="icon-base ri ri-close-line"></i>Unverified</span>
            </td>
            <td class="py-3">
              <div class="dropdown">
                <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                  <i class="icon-base ri ri-more-2-line"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" data-action="view"><i
                        class="icon-base ri ri-eye-line me-2"></i>View</a></li>
                  <li><a class="dropdown-item" href="#" data-action="suspend"><i
                        class="icon-base ri ri-shield-close-line me-2"></i>Suspend</a></li>
                  <li><a class="dropdown-item" href="#" data-action="edit"><i
                        class="icon-base ri ri-edit-line me-2"></i>Edit</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item text-danger" href="#" data-action="delete"><i
                        class="icon-base ri ri-delete-bin-line me-2"></i>Delete</a></li>
                </ul>
              </div>
            </td>
          </tr>

          <!-- User 6 -->
          <tr>
            <td class="py-3">
              <div class="d-flex align-items-center gap-3">
                <img src="/images/avatars/6.png" alt="avatar" class="rounded-circle"
                  style="width: 40px; height: 40px;">
                <div>
                  <h6 class="mb-0">Christopher Lee</h6>
                  <small class="text-muted">ID: A#003</small>
                </div>
              </div>
            </td>
            <td class="py-3">chris.lee@email.com</td>
            <td class="py-3"><span class="badge bg-label-warning">Artisan</span></td>
            <td class="py-3">Harare, Zimbabwe</td>
            <td class="py-3">Jan 8, 2024</td>
            <td class="py-3">
              <span class="badge bg-label-success">Active</span>
            </td>
            <td class="py-3">
              <span class="badge bg-label-success"><i class="icon-base ri ri-check-line"></i>Verified</span>
            </td>
            <td class="py-3">
              <div class="dropdown">
                <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                  <i class="icon-base ri ri-more-2-line"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" data-action="view"><i
                        class="icon-base ri ri-eye-line me-2"></i>View</a></li>
                  <li><a class="dropdown-item" href="#" data-action="suspend"><i
                        class="icon-base ri ri-shield-close-line me-2"></i>Suspend</a></li>
                  <li><a class="dropdown-item" href="#" data-action="edit"><i
                        class="icon-base ri ri-edit-line me-2"></i>Edit</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item text-danger" href="#" data-action="delete"><i
                        class="icon-base ri ri-delete-bin-line me-2"></i>Delete</a></li>
                </ul>
              </div>
            </td>
          </tr>

          <!-- User 7 - Suspended -->
          <tr style="opacity: 0.7;">
            <td class="py-3">
              <div class="d-flex align-items-center gap-3">
                <img src="/images/avatars/7.png" alt="avatar" class="rounded-circle"
                  style="width: 40px; height: 40px;">
                <div>
                  <h6 class="mb-0">Emma Davis</h6>
                  <small class="text-muted">ID: C#004</small>
                </div>
              </div>
            </td>
            <td class="py-3">emma.davis@email.com</td>
            <td class="py-3"><span class="badge bg-label-info">Customer</span></td>
            <td class="py-3">Bulawayo, Zimbabwe</td>
            <td class="py-3">Dec 28, 2023</td>
            <td class="py-3">
              <span class="badge bg-label-danger">Suspended</span>
            </td>
            <td class="py-3">
              <span class="badge bg-label-success"><i class="icon-base ri ri-check-line"></i>Verified</span>
            </td>
            <td class="py-3">
              <div class="dropdown">
                <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                  <i class="icon-base ri ri-more-2-line"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" data-action="view"><i
                        class="icon-base ri ri-eye-line me-2"></i>View</a></li>
                  <li><a class="dropdown-item" href="#" data-action="activate"><i
                        class="icon-base ri ri-check-double-line me-2"></i>Activate</a></li>
                  <li><a class="dropdown-item" href="#" data-action="edit"><i
                        class="icon-base ri ri-edit-line me-2"></i>Edit</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item text-danger" href="#" data-action="delete"><i
                        class="icon-base ri ri-delete-bin-line me-2"></i>Delete</a></li>
                </ul>
              </div>
            </td>
          </tr>

          <!-- User 8 -->
          <tr>
            <td class="py-3">
              <div class="d-flex align-items-center gap-3">
                <img src="/images/avatars/8.png" alt="avatar" class="rounded-circle"
                  style="width: 40px; height: 40px;">
                <div>
                  <h6 class="mb-0">Michael Johnson</h6>
                  <small class="text-muted">ID: A#004</small>
                </div>
              </div>
            </td>
            <td class="py-3">michael.johnson@email.com</td>
            <td class="py-3"><span class="badge bg-label-warning">Artisan</span></td>
            <td class="py-3">Harare, Zimbabwe</td>
            <td class="py-3">Jan 2, 2024</td>
            <td class="py-3">
              <span class="badge bg-label-success">Active</span>
            </td>
            <td class="py-3">
              <span class="badge bg-label-warning"><i class="icon-base ri ri-time-line"></i>Pending</span>
            </td>
            <td class="py-3">
              <div class="dropdown">
                <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                  <i class="icon-base ri ri-more-2-line"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" data-action="view"><i
                        class="icon-base ri ri-eye-line me-2"></i>View</a></li>
                  <li><a class="dropdown-item" href="#" data-action="suspend"><i
                        class="icon-base ri ri-shield-close-line me-2"></i>Suspend</a></li>
                  <li><a class="dropdown-item" href="#" data-action="edit"><i
                        class="icon-base ri ri-edit-line me-2"></i>Edit</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item text-danger" href="#" data-action="delete"><i
                        class="icon-base ri ri-delete-bin-line me-2"></i>Delete</a></li>
                </ul>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pagination -->
  <div class="d-flex justify-content-between align-items-center mt-4">
    <small class="text-muted">Showing 1 to 8 of 1,248 users</small>
    <nav aria-label="Page navigation">
      <ul class="pagination pagination-sm m-0">
        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
      </ul>
    </nav>
  </div>
@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // User search functionality
      document.getElementById('userSearch').addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(row => {
          const text = row.textContent.toLowerCase();
          row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
      });

      // Filter buttons
      document.getElementById('resetFilters').addEventListener('click', function() {
        document.getElementById('filterType').value = '';
        document.getElementById('filterStatus').value = '';
        document.getElementById('filterVerified').value = '';
        document.querySelectorAll('tbody tr').forEach(row => row.style.display = '');
      });

      // Action handlers
      document.querySelectorAll('[data-action]').forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          const action = this.getAttribute('data-action');
          const row = this.closest('tr');
          const userName = row.querySelector('h6').textContent;

          switch (action) {
            case 'suspend':
              Swal.fire({
                title: 'Suspend User?',
                text: `Are you sure you want to suspend ${userName}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Suspend',
                confirmButtonColor: '#ff6b6b',
                cancelButtonText: 'Cancel'
              }).then((result) => {
                if (result.isConfirmed) {
                  row.style.opacity = '0.7';
                  const statusBadge = row.querySelector('td:nth-child(6)');
                  statusBadge.innerHTML = '<span class="badge bg-label-danger">Suspended</span>';
                  Swal.fire('Suspended!', `${userName} has been suspended.`, 'success');
                }
              });
              break;

            case 'activate':
              Swal.fire({
                title: 'Activate User?',
                text: `Reactivate ${userName}'s account?`,
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Yes, Activate',
                confirmButtonColor: '#71dd5a',
                cancelButtonText: 'Cancel'
              }).then((result) => {
                if (result.isConfirmed) {
                  row.style.opacity = '1';
                  const statusBadge = row.querySelector('td:nth-child(6)');
                  statusBadge.innerHTML = '<span class="badge bg-label-success">Active</span>';
                  Swal.fire('Activated!', `${userName} has been reactivated.`, 'success');
                }
              });
              break;

            case 'view':
              Swal.fire({
                title: 'User Details',
                html: `
                <div class="text-start">
                  <p><strong>Name:</strong> ${userName}</p>
                  <p><strong>Email:</strong> ${row.querySelector('td:nth-child(2)').textContent}</p>
                  <p><strong>Type:</strong> ${row.querySelector('td:nth-child(3)').textContent}</p>
                  <p><strong>Location:</strong> ${row.querySelector('td:nth-child(4)').textContent}</p>
                  <p><strong>Join Date:</strong> ${row.querySelector('td:nth-child(5)').textContent}</p>
                </div>
              `,
                icon: 'info',
                confirmButtonText: 'Close'
              });
              break;

            case 'delete':
              Swal.fire({
                title: 'Delete User?',
                text: `This will permanently delete ${userName}. This cannot be undone!`,
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                confirmButtonColor: '#dc3545',
                cancelButtonText: 'Cancel'
              }).then((result) => {
                if (result.isConfirmed) {
                  row.remove();
                  Swal.fire('Deleted!', `${userName} has been permanently deleted.`, 'success');
                }
              });
              break;

            case 'edit':
              Swal.fire({
                title: 'Edit User',
                html: `
                <input type="text" class="form-control mb-3" placeholder="Name" value="${userName}">
                <input type="email" class="form-control" placeholder="Email" value="${row.querySelector('td:nth-child(2)').textContent}">
              `,
                showCancelButton: true,
                confirmButtonText: 'Save Changes',
                cancelButtonText: 'Cancel'
              }).then((result) => {
                if (result.isConfirmed) {
                  Swal.fire('Updated!', `${userName}'s details have been updated.`, 'success');
                }
              });
              break;
          }
        });
      });
    });
  </script>
@endsection
