@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Payout Management - ArtisanConnect')

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
          <h4 class="mb-0"><i class="ri-bank-card-line me-2 text-primary"></i>Payout Management</h4>
          <div>
            <a href="{{ route('admin.payouts.summary') }}" class="btn btn-outline-info me-2">
              <i class="ri-bar-chart-line me-1"></i> Summary Report
            </a>
            <a href="{{ route('admin.payouts.create') }}" class="btn btn-primary">
              <i class="ri-add-line me-1"></i> Create Payout
            </a>
          </div>
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
                <p class="text-muted small mb-1">Pending Payouts</p>
                <h4 class="text-warning">ZWL {{ number_format($stats['total_pending'] ?? 0, 2) }}</h4>
              </div>
              <i class="ri-time-line" style="font-size: 2rem; color: #ffc107;"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <p class="text-muted small mb-1">Processed Payouts</p>
                <h4 class="text-success">ZWL {{ number_format($stats['total_processed'] ?? 0, 2) }}</h4>
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
                <p class="text-muted small mb-1">Failed Payouts</p>
                <h4 class="text-danger">ZWL {{ number_format($stats['total_failed'] ?? 0, 2) }}</h4>
              </div>
              <i class="ri-close-circle-line" style="font-size: 2rem; color: #dc3545;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
      <div class="card-body pb-2">
        <form action="{{ route('admin.payouts.index') }}" method="GET" class="row g-3">
          <div class="col-md-3">
            <select name="status" class="form-select">
              <option value="">All Status</option>
              <option value="pending" @if (request('status') === 'pending') selected @endif>Pending</option>
              <option value="processed" @if (request('status') === 'processed') selected @endif>Processed</option>
              <option value="failed" @if (request('status') === 'failed') selected @endif>Failed</option>
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
          <div class="col-md-2">
            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
          </div>
          <div class="col-md-2">
            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary w-100">
              <i class="ri-search-line me-1"></i> Filter
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Payouts Table -->
    <div class="card">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="table-light">
            <tr>
              <th><i class="ri-hashtag-line"></i> ID</th>
              <th><i class="ri-user-line"></i> Artisan</th>
              <th><i class="ri-money-dollar-circle-line"></i> Amount (ZWL)</th>
              <th><i class="ri-bank-card-line"></i> Payment Method</th>
              <th><i class="ri-flag-line"></i> Status</th>
              <th><i class="ri-calendar-line"></i> Created</th>
              <th><i class="ri-eye-line"></i> Transaction ID</th>
              <th class="text-center"><i class="ri-tools-line"></i> Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($payouts as $payout)
              <tr>
                <td><span class="badge bg-label-info">{{ $payout->id }}</span></td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm bg-label-primary me-2">
                      <span class="avatar-initial">{{ substr($payout->artisan->user->name ?? 'A', 0, 1) }}</span>
                    </div>
                    <span>{{ $payout->artisan->user->name ?? 'N/A' }}</span>
                  </div>
                </td>
                <td><strong class="text-success">ZWL {{ number_format($payout->amount, 2) }}</strong></td>
                <td>
                  <span class="badge bg-label-secondary">
                    @if ($payout->payment_method === 'bank_transfer')
                      Bank Transfer
                    @elseif($payout->payment_method === 'mobile_money')
                      Mobile Money
                    @elseif($payout->payment_method === 'crypto')
                      Cryptocurrency
                    @else
                      Check
                    @endif
                  </span>
                </td>
                <td>
                  @if ($payout->status === 'pending')
                    <span class="badge bg-label-warning">Pending</span>
                  @elseif($payout->status === 'processed')
                    <span class="badge bg-label-success">Processed</span>
                  @else
                    <span class="badge bg-label-danger">Failed</span>
                  @endif
                </td>
                <td><small class="text-muted">{{ $payout->created_at->format('M d, Y') }}</small></td>
                <td><small class="font-monospace">{{ $payout->transaction_id ?? '-' }}</small></td>
                <td class="text-center">
                  @if ($payout->status === 'pending')
                    <div class="dropdown">
                      <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill" type="button"
                        data-bs-toggle="dropdown">
                        <i class="ri-more-2-line"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                          data-bs-target="#approvePayout{{ $payout->id }}">
                          <i class="ri-check-line me-2 text-success"></i> Approve
                        </a>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                          data-bs-target="#failPayout{{ $payout->id }}">
                          <i class="ri-close-line me-2 text-danger"></i> Mark Failed
                        </a>
                        <hr class="dropdown-divider">
                        <form action="{{ route('admin.payouts.destroy', $payout->id) }}" method="POST"
                          style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="dropdown-item text-danger"
                            onclick="return confirm('Are you sure?')">
                            <i class="ri-delete-bin-line me-2"></i> Delete
                          </button>
                        </form>
                      </div>
                    </div>
                  @else
                    <span class="badge bg-label-success">{{ ucfirst($payout->status) }}</span>
                  @endif
                </td>
              </tr>

              <!-- Approve Modal -->
              <div class="modal fade" id="approvePayout{{ $payout->id }}" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Approve Payout</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.payouts.approve', $payout->id) }}" method="POST">
                      @csrf
                      <div class="modal-body">
                        <div class="mb-3">
                          <label class="form-label">Transaction ID</label>
                          <input type="text" name="transaction_id" class="form-control"
                            placeholder="Enter transaction ID">
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Notes</label>
                          <textarea name="notes" class="form-control" rows="3" placeholder="Add notes..."></textarea>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary"
                          data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Approve Payout</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <!-- Failed Modal -->
              <div class="modal fade" id="failPayout{{ $payout->id }}" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Mark as Failed</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.payouts.failed', $payout->id) }}" method="POST">
                      @csrf
                      <div class="modal-body">
                        <div class="mb-3">
                          <label class="form-label">Reason <span class="text-danger">*</span></label>
                          <textarea name="notes" class="form-control" rows="4" required placeholder="Why did this payout fail?"></textarea>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary"
                          data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Mark as Failed</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            @empty
              <tr>
                <td colspan="8" class="text-center text-muted py-4">
                  <i class="ri-inbox-line" style="font-size: 2rem;"></i><br>
                  No payouts found
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    @if ($payouts->hasPages())
      <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
          Showing {{ $payouts->firstItem() }} to {{ $payouts->lastItem() }} of {{ $payouts->total() }} payouts
        </div>
        {{ $payouts->links() }}
      </div>
    @endif
  </div>
@endsection
