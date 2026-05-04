@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Add Payment Account - ArtisanConnect')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-6">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="mb-0"><i class="ri-add-circle-line me-2 text-primary"></i>Add Payment Account</h4>
          <a href="{{ route('admin.payment-accounts.index') }}" class="btn btn-outline-secondary">
            <i class="ri-arrow-left-line me-1"></i> Back
          </a>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.payment-accounts.store') }}" method="POST">
              @csrf

              <div class="mb-4">
                <label class="form-label fw-bold">Artisan <span class="text-danger">*</span></label>
                <select name="artisan_id" class="form-select @error('artisan_id') is-invalid @enderror" required>
                  <option value="">Select Artisan</option>
                  @foreach ($artisans as $artisan)
                    <option value="{{ $artisan->id }}" @if (old('artisan_id') == $artisan->id) selected @endif>
                      {{ $artisan->user->name ?? 'N/A' }}
                    </option>
                  @endforeach
                </select>
                @error('artisan_id')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>

              <!-- Paynow Integration Credentials -->
              <div class="row mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Paynow Integration ID <span class="text-danger">*</span></label>
                  <input type="text" name="paynow_integration_id"
                    class="form-control @error('paynow_integration_id') is-invalid @enderror" required
                    placeholder="Enter your Paynow Integration ID" value="{{ old('paynow_integration_id') }}">
                  <small class="form-text text-muted">Found in your Paynow merchant portal</small>
                  @error('paynow_integration_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold">Paynow Integration Key <span class="text-danger">*</span></label>
                  <input type="password" name="paynow_integration_key"
                    class="form-control @error('paynow_integration_key') is-invalid @enderror" required
                    placeholder="Enter your Paynow Integration Key" value="{{ old('paynow_integration_key') }}">
                  <small class="form-text text-muted">This will be encrypted and stored securely</small>
                  @error('paynow_integration_key')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <div class="row mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Account Holder <span class="text-danger">*</span></label>
                  <input type="text" name="account_holder"
                    class="form-control @error('account_holder') is-invalid @enderror" required
                    placeholder="Account holder name" value="{{ old('account_holder') }}">
                  @error('account_holder')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Account Type <span class="text-danger">*</span></label>
                  <select name="account_type" class="form-select @error('account_type') is-invalid @enderror" required
                    id="accountType">
                    <option value="">Select Account Type</option>
                    <option value="paynow" @if (old('account_type') === 'paynow') selected @endif>PayNow</option>
                    <option value="bank" @if (old('account_type') === 'bank') selected @endif>Bank Transfer</option>
                    <option value="mobile_money" @if (old('account_type') === 'mobile_money') selected @endif>Mobile Money</option>
                  </select>
                  @error('account_type')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <div class="row mb-4">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Account Number <span class="text-danger">*</span></label>
                  <input type="text" name="account_number"
                    class="form-control @error('account_number') is-invalid @enderror" required
                    placeholder="Account number" value="{{ old('account_number') }}">
                  @error('account_number')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Phone Number <span class="text-muted">(For Mobile
                      Money)</span></label>
                  <input type="text" name="phone_number"
                    class="form-control @error('phone_number') is-invalid @enderror" placeholder="+263..."
                    value="{{ old('phone_number') }}">
                  @error('phone_number')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <!-- Bank Fields -->
              <div id="bankFields">
                <div class="row mb-4">
                  <div class="col-md-6">
                    <label class="form-label">Bank Name</label>
                    <input type="text" name="bank_name" class="form-control" placeholder="Bank name"
                      value="{{ old('bank_name') }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Branch</label>
                    <input type="text" name="branch" class="form-control" placeholder="Branch"
                      value="{{ old('branch') }}">
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-md-6">
                    <label class="form-label">SWIFT Code</label>
                    <input type="text" name="swift_code" class="form-control" placeholder="SWIFT code"
                      value="{{ old('swift_code') }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">IBAN</label>
                    <input type="text" name="iban" class="form-control" placeholder="IBAN"
                      value="{{ old('iban') }}">
                  </div>
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-bold">Notes</label>
                <textarea name="notes" class="form-control" rows="3" placeholder="Add any notes...">{{ old('notes') }}</textarea>
              </div>

              <div class="mb-4">
                <div class="form-check">
                  <input type="checkbox" name="is_primary" value="1" class="form-check-input"
                    @if (old('is_primary')) checked @endif id="isPrimary">
                  <label class="form-check-label" for="isPrimary">
                    Set as Primary Account
                  </label>
                </div>
              </div>

              <div class="row mt-6">
                <div class="col-12">
                  <button type="submit" class="btn btn-primary me-2">
                    <i class="ri-save-line me-1"></i> Add Account
                  </button>
                  <a href="{{ route('admin.payment-accounts.index') }}" class="btn btn-outline-secondary">
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
            <h6 class="card-title mb-3"><i class="ri-information-line me-2 text-info"></i>Account Types</h6>
            <small class="d-block text-muted mb-3">
              <strong>Bank Transfer:</strong> Traditional bank account
            </small>
            <small class="d-block text-muted mb-3">
              <strong>Mobile Money:</strong> Digital payment service
            </small>
            <small class="d-block text-muted">
              <strong>Wallet:</strong> Digital wallet service
            </small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('accountType').addEventListener('change', function() {
      const bankFields = document.getElementById('bankFields');
      if (this.value === 'bank') {
        bankFields.style.display = 'block';
      } else {
        bankFields.style.display = 'none';
      }
    });

    // Initialize on page load
    const initialType = document.getElementById('accountType').value;
    if (initialType !== 'bank') {
      document.getElementById('bankFields').style.display = 'none';
    }
  </script>
@endsection
