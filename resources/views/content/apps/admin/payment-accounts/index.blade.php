@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Payment Account Management - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-6">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="mb-0"><i class="ri-bank-card-line me-2 text-primary"></i>Payment Account Management</h4>
          <a href="{{ route('admin.payment-accounts.create') }}" class="btn btn-primary">
            <i class="ri-add-line me-1"></i> Add Account
          </a>
        </div>
      </div>
    </div>

    <!-- Summary Stats -->
    <div class="row g-4 mb-6">
      <div class="col-md-4">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <p class="text-muted small mb-1">Total Accounts</p>
                <h4>{{ $stats['total_accounts'] ?? 0 }}</h4>
              </div>
              <i class="ri-bank-card-line" style="font-size: 2rem; color: #0d6efd;"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <p class="text-muted small mb-1">Active Accounts</p>
                <h4 class="text-success">{{ $stats['active_accounts'] ?? 0 }}</h4>
              </div>
              <i class="ri-check-double-line" style="font-size: 2rem; color: #28a745;"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <p class="text-muted small mb-1">Inactive Accounts</p>
                <h4 class="text-secondary">{{ $stats['inactive_accounts'] ?? 0 }}</h4>
              </div>
              <i class="ri-close-circle-line" style="font-size: 2rem; color: #6c757d;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
      <div class="card-body pb-2">
        <form action="{{ route('admin.payment-accounts.index') }}" method="GET" class="row g-3">
          <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search by account number or holder..."
              value="{{ request('search') }}">
          </div>
          <div class="col-md-2">
            <select name="status" class="form-select">
              <option value="">All Status</option>
              <option value="active" @if (request('status') === 'active') selected @endif>Active</option>
              <option value="inactive" @if (request('status') === 'inactive') selected @endif>Inactive</option>
              <option value="suspended" @if (request('status') === 'suspended') selected @endif>Suspended</option>
            </select>
          </div>
          <div class="col-md-3">
            <select name="artisan_id" class="form-select">
              <option value="">All Artisans</option>
              @foreach ($artisans as $artisan)
                <option value="{{ $artisan->id }}" @if (request('artisan_id') == $artisan->id) selected @endif>
                  {{ $artisan->user->name ?? 'N/A' }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <button type="submit" class="btn btn-outline-primary w-100">
              <i class="ri-search-line me-1"></i> Filter
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Accounts Table -->
    <div class="card">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="table-light">
            <tr>
              <th><i class="ri-hashtag-line"></i> ID</th>
              <th><i class="ri-user-line"></i> Artisan</th>
              <th><i class="ri-user-fill"></i> Account Holder</th>
              <th><i class="ri-bank-card-line"></i> Account Type</th>
              <th><i class="ri-shield-confidential-line"></i> Account Number</th>
              <th><i class="ri-flag-line"></i> Status</th>
              <th><i class="ri-star-line"></i> Primary</th>
              <th class="text-center"><i class="ri-tools-line"></i> Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($accounts as $account)
              <tr>
                <td><span class="badge bg-label-info">{{ $account->id }}</span></td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm bg-label-primary me-2">
                      <span class="avatar-initial">{{ substr($account->artisan->user->name ?? 'A', 0, 1) }}</span>
                    </div>
                    <span>{{ $account->artisan->user->name ?? 'N/A' }}</span>
                  </div>
                </td>
                <td>{{ $account->account_holder }}</td>
                <td><span
                    class="badge bg-label-secondary">{{ ucfirst(str_replace('_', ' ', $account->account_type)) }}</span>
                </td>
                <td>
                  <small class="font-monospace">
                    {{ substr($account->account_number, -4) ? '••••' . substr($account->account_number, -4) : 'N/A' }}
                  </small>
                </td>
                <td>
                  @if ($account->status === 'active')
                    <span class="badge bg-label-success">Active</span>
                  @elseif($account->status === 'inactive')
                    <span class="badge bg-label-secondary">Inactive</span>
                  @else
                    <span class="badge bg-label-danger">Suspended</span>
                  @endif
                </td>
                <td>
                  @if ($account->is_primary)
                    <span class="badge bg-label-warning"><i class="ri-star-fill me-1"></i>Primary</span>
                  @else
                    <span class="badge bg-label-light">Secondary</span>
                  @endif
                </td>
                <td class="text-center">
                  <div class="dropdown">
                    <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill" type="button"
                      data-bs-toggle="dropdown">
                      <i class="ri-more-2-line"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{ route('admin.payment-accounts.edit', $account->id) }}">
                        <i class="ri-edit-line me-2"></i> Edit
                      </a>
                      @if (!$account->is_primary)
                        <form action="{{ route('admin.payment-accounts.set-primary', $account->id) }}" method="POST"
                          style="display:inline;">
                          @csrf
                          <button type="submit" class="dropdown-item">
                            <i class="ri-star-line me-2"></i> Set as Primary
                          </button>
                        </form>
                      @endif
                      <form action="{{ route('admin.payment-accounts.toggle-status', $account->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        <button type="submit" class="dropdown-item">
                          <i class="ri-toggle-{{ $account->status === 'active' ? 'off' : 'on' }}-line me-2"></i>
                          {{ $account->status === 'active' ? 'Disable' : 'Enable' }}
                        </button>
                      </form>
                      <hr class="dropdown-divider">
                      @if (!$account->is_primary)
                        <form action="{{ route('admin.payment-accounts.destroy', $account->id) }}" method="POST"
                          style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="dropdown-item text-danger"
                            onclick="return confirm('Are you sure?')">
                            <i class="ri-delete-bin-line me-2"></i> Delete
                          </button>
                        </form>
                      @else
                        <span class="dropdown-item text-muted" style="cursor: not-allowed;">
                          <i class="ri-lock-line me-2"></i> Cannot delete primary
                        </span>
                      @endif
                    </div>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center text-muted py-4">
                  <i class="ri-inbox-line" style="font-size: 2rem;"></i><br>
                  No payment accounts found
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    @if ($accounts->hasPages())
      <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
          Showing {{ $accounts->firstItem() }} to {{ $accounts->lastItem() }} of {{ $accounts->total() }} accounts
        </div>
        {{ $accounts->links() }}
      </div>
    @endif
  </div>
@endsection
