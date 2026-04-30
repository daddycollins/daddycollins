@extends('layouts/layoutMaster')

@section('title', 'Open Requirements - ArtisanConnect')

@section('content')
  <div class="container">
    <h4 class="mb-4">Open Client Requirements</h4>
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Budget</th>
                <th>Deadline</th>
                <th>Client</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($requirements as $requirement)
                <tr>
                  <td>{{ $requirement->title }}</td>
                  <td>{{ $requirement->category }}</td>
                  <td>{{ $requirement->budget }}</td>
                  <td>{{ $requirement->deadline ? \Carbon\Carbon::parse($requirement->deadline)->format('Y-m-d') : '-' }}
                  </td>
                  <td>{{ $requirement->user->name ?? '-' }}</td>
                  <td>
                    @php $alreadyBid = $requirement->bids->where('artisan_id', auth()->id())->count() > 0; @endphp
                    @if (!$alreadyBid)
                      <a href="{{ route('requirements.show', $requirement) }}" class="btn btn-primary btn-sm">Bid</a>
                    @else
                      <span class="badge bg-label-success">Bid Submitted</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center">No open requirements found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
