@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Service Management - ArtisanConnect')

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
          <h4 class="mb-0"><i class="ri-briefcase-line me-2 text-primary"></i>Artisan Services Management</h4>
          <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
            <i class="ri-add-line me-1"></i> Add New Service
          </a>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
      <div class="card-body pb-2">
        <form action="{{ route('admin.services.index') }}" method="GET" class="row g-3">
          <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by service name..."
              value="{{ request('search') }}">
          </div>
          <div class="col-md-3">
            <select name="category" class="form-select">
              <option value="">All Categories</option>
              @foreach ($categories as $category)
                <option value="{{ $category }}" @if (request('category') === $category) selected @endif>{{ $category }}
                </option>
              @endforeach
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
            <button type="submit" class="btn btn-outline-primary w-100">
              <i class="ri-search-line me-1"></i> Filter
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Services Table -->
    <div class="card">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="table-light">
            <tr>
              <th><i class="ri-hashtag-line"></i> ID</th>
              <th><i class="ri-user-line"></i> Artisan</th>
              <th><i class="ri-briefcase-line"></i> Service</th>
              <th><i class="ri-tag-line"></i> Category</th>
              <th><i class="ri-money-dollar-circle-line"></i> Price</th>
              <th><i class="ri-checkbox-circle-line"></i> Availability</th>
              <th><i class="ri-calendar-line"></i> Created</th>
              <th class="text-center"><i class="ri-tools-line"></i> Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($services as $service)
              <tr>
                <td><span class="badge bg-label-info">{{ $service->id }}</span></td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm bg-label-primary me-2">
                      <span class="avatar-initial">{{ substr($service->artisan->user->name ?? 'A', 0, 1) }}</span>
                    </div>
                    <span>{{ $service->artisan->user->name ?? 'N/A' }}</span>
                  </div>
                </td>
                <td><strong>{{ $service->service_name }}</strong></td>
                <td><span class="badge bg-label-secondary">{{ $service->category }}</span></td>
                <td><strong class="text-success">ZWL {{ number_format($service->price_estimate, 2) }}</strong></td>
                <td>
                  @if ($service->availability)
                    <span class="badge bg-label-success"><i
                        class="ri-check-line me-1"></i>{{ $service->availability }}</span>
                  @else
                    <span class="badge bg-label-secondary">Not Set</span>
                  @endif
                </td>
                <td><small class="text-muted">{{ $service->created_at->format('M d, Y') }}</small></td>
                <td class="text-center">
                  <div class="dropdown">
                    <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill" type="button"
                      data-bs-toggle="dropdown">
                      <i class="ri-more-2-line"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{ route('admin.services.edit', $service->id) }}">
                        <i class="ri-edit-line me-2"></i> Edit
                      </a>
                      <hr class="dropdown-divider">
                      <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST"
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
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center text-muted py-4">
                  <i class="ri-inbox-line" style="font-size: 2rem;"></i><br>
                  No services found
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    @if ($services->hasPages())
      <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
          Showing {{ $services->firstItem() }} to {{ $services->lastItem() }} of {{ $services->total() }} services
        </div>
        {{ $services->links() }}
      </div>
    @endif
  </div>
@endsection
