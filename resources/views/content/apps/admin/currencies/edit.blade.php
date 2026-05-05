@extends('layouts/layoutMaster')

@section('title', 'Edit Currency - ArtisanConnect')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-6">
      <div class="col-12">
        <h4 class="mb-4"><i class="ri-money-dollar-circle-line me-2 text-primary"></i>Edit Currency</h4>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">{{ $currency->name }}</h5>
          </div>
          <form action="{{ route('admin.currencies.update', $currency->id) }}" method="POST" class="card-body">
            @csrf
            @method('PUT')

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label" for="code">Currency Code <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                  name="code" value="{{ old('code', $currency->code) }}" maxlength="3" required>
                <small class="text-muted">ISO 4217 code (3 characters)</small>
                @error('code')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label" for="symbol">Currency Symbol <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('symbol') is-invalid @enderror" id="symbol"
                  name="symbol" value="{{ old('symbol', $currency->symbol) }}" required>
                @error('symbol')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label" for="name">Currency Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name', $currency->name) }}" required>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label class="form-label" for="exchange_rate">Exchange Rate <span class="text-danger">*</span></label>
              <input type="number" class="form-control @error('exchange_rate') is-invalid @enderror" id="exchange_rate"
                name="exchange_rate" value="{{ old('exchange_rate', $currency->exchange_rate) }}" step="0.0001" required>
              <small class="text-muted">Exchange rate relative to base currency</small>
              @error('exchange_rate')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label class="form-label" for="description">Description</label>
              <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                rows="3">{{ old('description', $currency->description) }}</textarea>
              @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                    {{ old('is_active', $currency->is_active) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_active">
                    Active
                  </label>
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1"
                    {{ old('is_default', $currency->is_default) ? 'checked' : '' }}>
                  <label class="form-check-label" for="is_default">
                    Set as Default Currency
                  </label>
                </div>
              </div>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="ri-save-line me-1"></i>Update Currency
              </button>
              <a href="{{ route('admin.currencies.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
