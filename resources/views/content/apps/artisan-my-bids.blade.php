@extends('layouts/layoutMaster')

@section('title', 'My Bids - ArtisanConnect')

@section('content')
  <div class="container">
    <h4 class="mb-4">My Bids</h4>
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th>Requirement</th>
                <th>Amount</th>
                <th>Proposal</th>
                <th>Status</th>
                <th>Client</th>
                <th>Requirement Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($bids as $bid)
                <tr>
                  <td>{{ $bid->requirement->title ?? '-' }}</td>
                  <td>{{ $bid->amount }}</td>
                  <td>{{ $bid->proposal }}</td>
                  <td>
                    @if ($bid->status === 'accepted')
                      <span class="badge bg-label-success">Accepted</span>
                    @elseif($bid->status === 'rejected')
                      <span class="badge bg-label-danger">Rejected</span>
                    @else
                      <span class="badge bg-label-warning">Pending</span>
                    @endif
                  </td>
                  <td>{{ $bid->requirement->user->name ?? '-' }}</td>
                  <td>{{ ucfirst($bid->requirement->status ?? '-') }}</td>
                  <td>
                    <a href="{{ route('requirements.show', $bid->requirement) }}" class="btn btn-info btn-sm">View</a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center">No bids yet.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
