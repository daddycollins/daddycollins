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
              <h3 class="mb-2">{{ number_format($totalUsers) }}</h3>
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
              <h3 class="mb-2">{{ number_format($activeUsers) }}</h3>
              <p class="mb-0"><span class="badge bg-label-success">{{ $activePercentage }}% active</span></p>
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
              <h3 class="mb-2">{{ number_format($suspendedUsers) }}</h3>
              <p class="mb-0"><span class="badge bg-label-warning">{{ $suspendedPercentage }}% suspended</span></p>
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
              <h3 class="mb-2">{{ number_format($verifiedArtisans) }}</h3>
              <p class="mb-0"><span class="badge bg-label-info">{{ $verifiedPercentage }}% verified</span></p>
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
          @forelse($users as $user)
            <tr @if ($user->status === 'suspended') style="opacity: 0.7;" @endif>
              <td class="py-3">
                <div class="d-flex align-items-center gap-3">
                  <div class="avatar avatar-sm rounded-circle bg-label-primary">
                    <span class="avatar-initial rounded-circle">{{ substr($user->name, 0, 1) }}</span>
                  </div>
                  <div>
                    <h6 class="mb-0">{{ $user->name }}</h6>
                    <small class="text-muted">ID:
                      {{ substr($user->role, 0, 1) }}#{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</small>
                  </div>
                </div>
              </td>
              <td class="py-3">{{ $user->email }}</td>
              <td class="py-3">
                <span
                  class="badge {{ $user->role === 'artisan' ? 'bg-label-warning' : ($user->role === 'admin' ? 'bg-label-danger' : 'bg-label-info') }}">
                  {{ ucfirst($user->role) }}
                </span>
              </td>
              <td class="py-3">{{ $user->artisanProfile?->location ?? 'N/A' }}</td>
              <td class="py-3">{{ $user->created_at->format('M d, Y') }}</td>
              <td class="py-3">
                <span
                  class="badge {{ $user->status === 'active' ? 'bg-label-success' : ($user->status === 'suspended' ? 'bg-label-danger' : 'bg-label-warning') }}">
                  {{ ucfirst($user->status) }}
                </span>
              </td>
              <td class="py-3">
                @if ($user->artisanProfile?->verified)
                  <span class="badge bg-label-success"><i class="icon-base ri ri-check-line"></i>Verified</span>
                @elseif($user->role === 'artisan')
                  <span class="badge bg-label-warning"><i class="icon-base ri ri-time-line"></i>Pending</span>
                @else
                  <span class="badge bg-label-danger"><i class="icon-base ri ri-close-line"></i>Unverified</span>
                @endif
              </td>
              <td class="py-3">
                <div class="dropdown">
                  <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-line"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item user-action" href="#" data-action="view"
                        data-user-id="{{ $user->id }}"><i class="icon-base ri ri-eye-line me-2"></i>View</a></li>
                    @if ($user->status === 'active')
                      <li><a class="dropdown-item user-action" href="#" data-action="suspend"
                          data-user-id="{{ $user->id }}"><i
                            class="icon-base ri ri-shield-close-line me-2"></i>Suspend</a></li>
                    @else
                      <li><a class="dropdown-item user-action" href="#" data-action="activate"
                          data-user-id="{{ $user->id }}"><i
                            class="icon-base ri ri-check-double-line me-2"></i>Activate</a></li>
                    @endif
                    <li><a class="dropdown-item user-action" href="#" data-action="edit"
                        data-user-id="{{ $user->id }}"><i class="icon-base ri ri-edit-line me-2"></i>Edit</a></li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger user-action" href="#" data-action="delete"
                        data-user-id="{{ $user->id }}"><i
                          class="icon-base ri ri-delete-bin-line me-2"></i>Delete</a></li>
                  </ul>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-4">
                <p class="text-muted mb-0">No users found</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pagination -->
  <div class="d-flex justify-content-between align-items-center mt-4">
    <small class="text-muted">Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of
      {{ $users->total() }} users</small>
    {{ $users->links() }}
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
