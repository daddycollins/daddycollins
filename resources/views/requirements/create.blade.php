@extends('layouts/layoutMaster')


@section('title', 'Post New Requirement')

@section('content')
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <div class="card">
        <div class="card-header">
          <h4 class="mb-0">Post New Requirement</h4>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('requirements.store') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label">Title</label>
              <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Category</label>
              <select name="category" class="form-select select2" required>
                <option value="">Select a category</option>
                <option value="Plumbing">Plumbing</option>
                <option value="Electrical">Electrical</option>
                <option value="Carpentry">Carpentry</option>
                <option value="Painting">Painting</option>
                <option value="Cleaning">Cleaning</option>
                <option value="Masonry">Masonry</option>
                <option value="Landscaping">Landscaping</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Deadline</label>
              <input type="date" name="deadline" class="form-control">
            </div>
            <div class="mb-3">
              <label class="form-label">Budget</label>
              <input type="number" name="budget" class="form-control" step="0.01">
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

@section('page-script')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%'
      });
    });
  </script>
@endsection
