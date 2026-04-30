@extends('layouts/layoutMaster')

@section('content')
  <div class="container">
    <h1>Client Requirements</h1>
    <a href="{{ route('requirements.create') }}" class="btn btn-primary mb-3">Post New Requirement</a>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Title</th>
          <th>Category</th>
          <th>Budget</th>
          <th>Status</th>
          <th>Deadline</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($requirements as $requirement)
          <tr>
            <td>{{ $requirement->title }}</td>
            <td>{{ $requirement->category }}</td>
            <td>{{ $requirement->budget }}</td>
            <td>{{ ucfirst($requirement->status) }}</td>
            <td>
              @if ($requirement->deadline)
                {{ \Carbon\Carbon::parse($requirement->deadline)->format('Y-m-d') }}
              @else
                -
              @endif
            </td>
            <td>
              <a href="{{ route('requirements.show', $requirement) }}" class="btn btn-info btn-sm">View</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    {{ $requirements->links() }}
  </div>
@endsection
