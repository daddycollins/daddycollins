@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Payout Summary - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-6">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="mb-0"><i class="ri-line-chart-line me-2 text-primary"></i>Payout Summary Report</h4>
          <a href="{{ route('admin.payouts.index') }}" class="btn btn-outline-secondary">
            <i class="ri-arrow-left-line me-1"></i> Back to Payouts
          </a>
        </div>
      </div>
    </div>

    <!-- Date Range Filter -->
    <div class="card mb-4">
      <div class="card-body pb-2">
        <form action="{{ route('admin.payouts.summary') }}" method="GET" class="row g-3">
          <div class="col-md-3">
            <label class="form-label">From Date</label>
            <input type="date" name="date_from" class="form-control" value="{{ $dateFrom->format('Y-m-d') }}">
          </div>
          <div class="col-md-3">
            <label class="form-label">To Date</label>
            <input type="date" name="date_to" class="form-control" value="{{ $dateTo->format('Y-m-d') }}">
          </div>
          <div class="col-md-3" style="padding-top: 32px;">
            <button type="submit" class="btn btn-primary w-100">
              <i class="ri-search-line me-1"></i> Generate Report
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Summary Stats -->
    <div class="row g-4 mb-6">
      <div class="col-md-3">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <p class="text-muted small mb-1">Total Payouts</p>
            <h5>{{ $summary['total_payouts'] ?? 0 }}</h5>
            <p class="mb-0 text-success"><i
                class="ri-arrow-up-s-line me-1"></i>{{ $summary['total_amount'] ? 'ZWL ' . number_format($summary['total_amount'], 2) : 'N/A' }}
            </p>
          </div>
        </div>
      </div>

      @foreach ($summary['by_status'] ?? [] as $status)
        @php
          $statusColors = [
              'pending' => ['bg-warning', 'Pending'],
              'processed' => ['bg-success', 'Processed'],
              'failed' => ['bg-danger', 'Failed'],
          ];
          $color = $statusColors[$status->status][0] ?? 'bg-secondary';
          $label = $statusColors[$status->status][1] ?? ucfirst($status->status);
        @endphp
        <div class="col-md-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <p class="text-muted small mb-1">{{ $label }}</p>
              <h5>{{ $status->count ?? 0 }}</h5>
              <p class="mb-0"><span class="badge {{ $color }}">ZWL
                  {{ number_format($status->total ?? 0, 2) }}</span></p>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- By Payment Method -->
    <div class="row g-6 mb-6">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-light">
            <h5 class="card-title m-0"><i class="ri-bank-card-line me-2"></i>By Payment Method</h5>
          </div>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th>Method</th>
                  <th class="text-end">Count</th>
                  <th class="text-end">Amount (ZWL)</th>
                </tr>
              </thead>
              <tbody>
                @forelse($summary['by_method'] ?? [] as $method)
                  <tr>
                    <td><span
                        class="badge bg-label-secondary">{{ ucfirst(str_replace('_', ' ', $method->payment_method)) }}</span>
                    </td>
                    <td class="text-end">{{ $method->count ?? 0 }}</td>
                    <td class="text-end fw-bold">{{ number_format($method->total ?? 0, 2) }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3" class="text-center text-muted">No data available</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Top Artisans -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-light">
            <h5 class="card-title m-0"><i class="ri-user-star-line me-2"></i>Top Artisans by Payouts</h5>
          </div>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th>Artisan</th>
                  <th class="text-end">Payouts</th>
                  <th class="text-end">Amount (ZWL)</th>
                </tr>
              </thead>
              <tbody>
                @forelse($summary['top_artisans'] ?? [] as $artisan)
                  <tr>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm bg-label-primary me-2">
                          <span class="avatar-initial">{{ substr($artisan->artisan?->user->name ?? 'A', 0, 1) }}</span>
                        </div>
                        <span>{{ $artisan->artisan?->user->name ?? 'N/A' }}</span>
                      </div>
                    </td>
                    <td class="text-end">{{ $artisan->count ?? 0 }}</td>
                    <td class="text-end fw-bold">{{ number_format($artisan->total ?? 0, 2) }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3" class="text-center text-muted">No data available</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
