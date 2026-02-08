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
  <!-- Flash Messages -->
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
      <i class="icon-base ri ri-check-double-line me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
      <i class="icon-base ri ri-error-warning-line me-2"></i>{{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
      <i class="icon-base ri ri-error-warning-line me-2"></i>
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

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
                  class="badge {{ $user->status === 'active' ? 'bg-label-success' : 'bg-label-danger' }}">
                  {{ ucfirst($user->status) }}
                </span>
              </td>
              <td class="py-3">
                @if ($user->artisanProfile?->verified)
                  <span class="badge bg-label-success"><i class="icon-base ri ri-check-line"></i>Verified</span>
                @elseif($user->role === 'artisan')
                  <span class="badge bg-label-warning"><i class="icon-base ri ri-time-line"></i>Pending</span>
                @else
                  <span class="badge bg-label-secondary">N/A</span>
                @endif
              </td>
              <td class="py-3">
                <div class="dropdown">
                  <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-line"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewUserModal-{{ $user->id }}">
                        <i class="icon-base ri ri-eye-line me-2"></i>View
                      </a>
                    </li>
                    @if ($user->status === 'active')
                      <li>
                        <a class="dropdown-item suspend-action" href="#" data-user-name="{{ $user->name }}" data-form-id="suspendForm-{{ $user->id }}">
                          <i class="icon-base ri ri-shield-close-line me-2"></i>Suspend
                        </a>
                        <form id="suspendForm-{{ $user->id }}" action="{{ route('admin-user-suspend', $user) }}" method="POST" class="d-none">
                          @csrf
                        </form>
                      </li>
                    @else
                      <li>
                        <a class="dropdown-item activate-action" href="#" data-user-name="{{ $user->name }}" data-form-id="activateForm-{{ $user->id }}">
                          <i class="icon-base ri ri-check-double-line me-2"></i>Activate
                        </a>
                        <form id="activateForm-{{ $user->id }}" action="{{ route('admin-user-activate', $user) }}" method="POST" class="d-none">
                          @csrf
                        </form>
                      </li>
                    @endif
                    <li>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}">
                        <i class="icon-base ri ri-edit-line me-2"></i>Edit
                      </a>
                    </li>
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

  <!-- View User Modals -->
  @foreach($users as $user)
    <div class="modal fade" id="viewUserModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header border-0 pb-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body pt-0">
            <!-- User Header -->
            <div class="text-center mb-4">
              <div class="avatar avatar-xl mx-auto mb-3 {{ $user->role === 'artisan' ? 'bg-label-warning' : ($user->role === 'admin' ? 'bg-label-danger' : 'bg-label-info') }}">
                <span class="avatar-initial rounded-circle fs-3">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
              </div>
              <h4 class="mb-1">{{ $user->name }}</h4>
              <div class="d-flex justify-content-center gap-2">
                <span class="badge {{ $user->role === 'artisan' ? 'bg-label-warning' : ($user->role === 'admin' ? 'bg-label-danger' : 'bg-label-info') }}">
                  {{ ucfirst($user->role) }}
                </span>
                <span class="badge {{ $user->status === 'active' ? 'bg-label-success' : 'bg-label-danger' }}">
                  {{ ucfirst($user->status) }}
                </span>
                @if ($user->artisanProfile?->verified)
                  <span class="badge bg-label-success"><i class="icon-base ri ri-verified-badge-line me-1"></i>Verified</span>
                @endif
              </div>
            </div>

            <div class="row g-4">
              <!-- User Details -->
              <div class="col-md-6">
                <div class="card bg-light border-0">
                  <div class="card-body">
                    <h6 class="text-uppercase text-muted small mb-3">User Information</h6>
                    <div class="mb-2">
                      <small class="text-muted d-block">Email</small>
                      <span>{{ $user->email }}</span>
                    </div>
                    <div class="mb-2">
                      <small class="text-muted d-block">User ID</small>
                      <span>{{ substr($user->role, 0, 1) }}#{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="mb-2">
                      <small class="text-muted d-block">Joined</small>
                      <span>{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                    @if ($user->artisanProfile)
                      <div class="mb-2">
                        <small class="text-muted d-block">Phone</small>
                        <span>{{ $user->artisanProfile->phone ?? 'N/A' }}</span>
                      </div>
                      <div class="mb-2">
                        <small class="text-muted d-block">Location</small>
                        <span>{{ $user->artisanProfile->location ?? 'N/A' }}</span>
                      </div>
                    @endif
                  </div>
                </div>
              </div>

              <!-- Stats / Artisan Details -->
              <div class="col-md-6">
                @if ($user->artisanProfile)
                  <div class="card bg-light border-0 mb-3">
                    <div class="card-body">
                      <h6 class="text-uppercase text-muted small mb-3">Artisan Profile</h6>
                      <div class="mb-2">
                        <small class="text-muted d-block">Business Name</small>
                        <span>{{ $user->artisanProfile->business_name ?? 'N/A' }}</span>
                      </div>
                      <div class="mb-2">
                        <small class="text-muted d-block">Category</small>
                        <span>{{ $user->artisanProfile->category ?? 'N/A' }}</span>
                      </div>
                      <div class="mb-2">
                        <small class="text-muted d-block">Experience</small>
                        <span>{{ $user->artisanProfile->years_of_experience ?? 'N/A' }} years</span>
                      </div>
                      <div class="mb-2">
                        <small class="text-muted d-block">Rating</small>
                        <span>
                          @if ($user->artisanProfile->average_rating)
                            <i class="icon-base ri ri-star-fill text-warning me-1"></i>{{ number_format($user->artisanProfile->average_rating, 1) }}
                          @else
                            No ratings yet
                          @endif
                        </span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="card bg-light border-0">
                  <div class="card-body">
                    <h6 class="text-uppercase text-muted small mb-3">Activity</h6>
                    <div class="d-flex justify-content-between mb-2">
                      <span class="text-muted">Total Orders</span>
                      <span class="fw-semibold">{{ $user->orders_count }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                      <span class="text-muted">Total Reviews</span>
                      <span class="fw-semibold">{{ $user->reviews_count }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer border-0 pt-0">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  <!-- Edit User Modals -->
  @foreach($users as $user)
    <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form action="{{ route('admin-user-update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header">
              <h5 class="modal-title">Edit User - {{ $user->name }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                  <option value="client" {{ $user->role === 'client' ? 'selected' : '' }}>Client</option>
                  <option value="artisan" {{ $user->role === 'artisan' ? 'selected' : '' }}>Artisan</option>
                  <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                  <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                  <option value="suspended" {{ $user->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endforeach
@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // User search
      document.getElementById('userSearch').addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(row => {
          const text = row.textContent.toLowerCase();
          row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
      });

      // Reset filters
      document.getElementById('resetFilters').addEventListener('click', function() {
        document.getElementById('filterType').value = '';
        document.getElementById('filterStatus').value = '';
        document.getElementById('filterVerified').value = '';
        document.querySelectorAll('tbody tr').forEach(row => row.style.display = '');
      });

      // Suspend confirmation
      document.querySelectorAll('.suspend-action').forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          const userName = this.getAttribute('data-user-name');
          const formId = this.getAttribute('data-form-id');
          Swal.fire({
            title: 'Suspend User?',
            text: 'Are you sure you want to suspend ' + userName + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Suspend',
            confirmButtonColor: '#ff6b6b',
            cancelButtonText: 'Cancel'
          }).then(function(result) {
            if (result.isConfirmed) {
              document.getElementById(formId).submit();
            }
          });
        });
      });

      // Activate confirmation
      document.querySelectorAll('.activate-action').forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          const userName = this.getAttribute('data-user-name');
          const formId = this.getAttribute('data-form-id');
          Swal.fire({
            title: 'Activate User?',
            text: 'Reactivate ' + userName + '\'s account?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Activate',
            confirmButtonColor: '#71dd5a',
            cancelButtonText: 'Cancel'
          }).then(function(result) {
            if (result.isConfirmed) {
              document.getElementById(formId).submit();
            }
          });
        });
      });
    });
  </script>
@endsection
