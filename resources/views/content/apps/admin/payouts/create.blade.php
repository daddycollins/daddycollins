@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Create Payout - ArtisanConnect')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-6">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="mb-0"><i class="ri-add-circle-line me-2 text-primary"></i>Create Payout Request</h4>
          <a href="{{ route('admin.payouts.index') }}" class="btn btn-outline-secondary">
            <i class="ri-arrow-left-line me-1"></i> Back
          </a>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.payouts.store') }}" method="POST">
              @csrf

              <div class="mb-4">
                <label class="form-label fw-bold">Artisan <span class="text-danger">*</span></label>
                <select name="artisan_id" class="form-select @error('artisan_id') is-invalid @enderror" required
                  id="artisanSelect">
                  <option value="">Select Artisan</option>
                  @foreach ($artisans as $artisan)
                    <option value="{{ $artisan->id }}" @if (old('artisan_id') == $artisan->id) selected @endif
                      data-email="{{ $artisan->user->email ?? '' }}" data-phone="{{ $artisan->user->phone ?? '' }}">
                      {{ $artisan->user->name ?? 'N/A' }} ({{ $artisan->user->email ?? '' }})
                    </option>
                  @endforeach
                </select>
                @error('artisan_id')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>

              <div class="row mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Amount (ZWL) <span class="text-danger">*</span></label>
                  <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" required
                    step="0.01" min="0.01" placeholder="0.00" value="{{ old('amount') }}">
                  @error('amount')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Payment Method <span class="text-danger">*</span></label>
                  <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror"
                    required>
                    <option value="">Select Payment Method</option>
                    <option value="bank_transfer" @if (old('payment_method') === 'bank_transfer') selected @endif>Bank Transfer</option>
                    <option value="mobile_money" @if (old('payment_method') === 'mobile_money') selected @endif>Mobile Money</option>
                    <option value="crypto" @if (old('payment_method') === 'crypto') selected @endif>Cryptocurrency</option>
                    <option value="check" @if (old('payment_method') === 'check') selected @endif>Check</option>
                  </select>
                  @error('payment_method')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-bold">Notes</label>
                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="4"
                  placeholder="Add any notes about this payout...">{{ old('notes') }}</textarea>
                @error('notes')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>

              <div class="row mt-6">
                <div class="col-12">
                  <button type="submit" class="btn btn-primary me-2">
                    <i class="ri-save-line me-1"></i> Create Payout
                  </button>
                  <a href="{{ route('admin.payouts.index') }}" class="btn btn-outline-secondary">
                    <i class="ri-close-line me-1"></i> Cancel
                  </a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card bg-light">
          <div class="card-body">
            <h6 class="card-title mb-3"><i class="ri-information-line me-2 text-info"></i>Payment Methods</h6>
            <small class="d-block text-muted mb-3">
              <strong>Bank Transfer:</strong> Direct deposit to artisan's bank account
            </small>
            <small class="d-block text-muted mb-3">
              <strong>Mobile Money:</strong> Payment via mobile money service
            </small>
            <small class="d-block text-muted mb-3">
              <strong>Cryptocurrency:</strong> Blockchain-based payment
            </small>
            <small class="d-block text-muted">
              <strong>Check:</strong> Traditional check payment
            </small>
          </div>
        </div>

        <div class="card mt-4">
          <div class="card-body" id="artisanInfo" style="display: none;">
            <h6 class="card-title mb-3"><i class="ri-user-line me-2"></i>Artisan Info</h6>
            <div class="mb-2">
              <small class="text-muted d-block">Email</small>
              <small id="artisanEmail">-</small>
            </div>
            <div>
              <small class="text-muted d-block">Phone</small>
              <small id="artisanPhone">-</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('artisanSelect').addEventListener('change', function() {
      const option = this.options[this.selectedIndex];
      const infoDiv = document.getElementById('artisanInfo');

      if (option.value) {
        document.getElementById('artisanEmail').textContent = option.dataset.email || '-';
        document.getElementById('artisanPhone').textContent = option.dataset.phone || '-';
        infoDiv.style.display = 'block';
      } else {
        infoDiv.style.display = 'none';
      }
    });
  </script>
@endsection
