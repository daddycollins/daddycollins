@extends('layouts/layoutMaster')

@section('title', 'Product Categories - ArtisanConnect')

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
          <h4 class="mb-0"><i class="ri-folder-2-line me-2 text-primary"></i>Product Categories</h4>
          <a href="{{ route('admin.product-categories.create') }}" class="btn btn-primary">
            <i class="ri-add-line me-1"></i>Add Category
          </a>
        </div>
      </div>
    </div>

    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ri-check-line me-2"></i>{{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <!-- Filter Card -->
    <div class="card mb-4">
      <div class="card-body">
        <form method="GET" action="{{ route('admin.product-categories.index') }}" class="row g-3">
          <div class="col-md-6">
            <input type="text" name="search" class="form-control" placeholder="Search categories..."
              value="{{ request('search') }}">
          </div>
          <div class="col-md-4">
            <select name="status" class="form-select">
              <option value="">All Status</option>
              <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
              <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Categories Table -->
    <div class="card">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Description</th>
              <th>Status</th>
              <th>Created</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categories as $category)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td><strong>{{ $category->name }}</strong></td>
                <td>
                  <span class="text-muted">{{ Str::limit($category->description, 50) }}</span>
                </td>
                <td>
                  @if ($category->is_active)
                    <span class="badge bg-label-success">Active</span>
                  @else
                    <span class="badge bg-label-danger">Inactive</span>
                  @endif
                </td>
                <td>{{ $category->created_at->format('M d, Y') }}</td>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-icon btn-text-secondary rounded-pill" type="button" data-bs-toggle="dropdown">
                      <i class="ri-more-2-line"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                      <a class="dropdown-item" href="{{ route('admin.product-categories.edit', $category->id) }}">
                        <i class="ri-edit-line me-2"></i>Edit
                      </a>
                      <form action="{{ route('admin.product-categories.destroy', $category->id) }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger"
                          onclick="return confirm('Delete this category?')">
                          <i class="ri-delete-bin-line me-2"></i>Delete
                        </button>
                      </form>
                    </div>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center py-4">
                  <p class="text-muted mb-0">No categories found</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        {{ $categories->links() }}
      </div>
    </div>
  </div>
@endsection
