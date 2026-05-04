@extends('layouts/layoutMaster')

@section('content')
  <div class="container">
    <h1>{{ $requirement->title }}</h1>
    <div class="mb-3">
      <strong>Description:</strong>
      <p>{{ $requirement->description }}</p>
    </div>
    <div class="mb-3">
      <strong>Category:</strong> {{ $requirement->category ?? '-' }}<br>
      <strong>Budget:US$</strong> {{ $requirement->budget ?? '-' }}<br>
      <strong>Deadline:</strong>
      @if ($requirement->deadline)
        {{ \Carbon\Carbon::parse($requirement->deadline)->format('Y-m-d') }}
      @else
        -
      @endif
      <br>
      <strong>Status:</strong> {{ ucfirst($requirement->status) }}
    </div>

    @if (auth()->id() === $requirement->user_id)
      <h3>Bids <span class="badge bg-label-info">Real-time</span></h3>
      <div id="bids-table-container">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Artisan</th>
              <th>Bidder Info</th>
              <th>(US$)Amount</th>
              <th>Proposal</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($requirement->bids as $bid)
              <tr>
                <td>
                  {{ $bid->artisan->name ?? 'N/A' }}
                  @if (optional($bid->artisan->artisanProfile)->profile_photo_path)
                    <img src="{{ asset('storage/' . $bid->artisan->artisanProfile->profile_photo_path) }}" alt="Profile"
                      width="32" height="32" class="rounded-circle ms-1">
                  @endif
                </td>
                <td>
                  @php
                    $profile = $bid->artisan->artisanProfile;
                    $ordersCount = $bid->artisan->orders->where('artisan_id', optional($profile)->id)->count();
                    $reviews = $bid->artisan->reviews->where('artisan_id', optional($profile)->id);
                    $avgRating = $reviews->count() ? number_format($reviews->avg('rating'), 1) : '-';
                  @endphp
                  <div>
                    <strong>Category:</strong> {{ $profile->category ?? '-' }}<br>
                    <strong>Location:</strong> {{ $profile->location ?? '-' }}<br>
                    <strong>Total Orders:</strong> {{ $ordersCount }}<br>
                    <strong>Avg. Rating:</strong> {{ $avgRating }}
                  </div>
                </td>
                <td>{{ $bid->amount }}</td>
                <td>{{ $bid->proposal }}</td>
                <td>{{ ucfirst($bid->status) }}</td>
                <td>
                  @if ($bid->status === 'pending' && $requirement->status === 'open')
                    <form method="POST" action="{{ route('bids.accept', $bid) }}">
                      @csrf
                      <button type="submit" class="btn btn-success btn-sm">Accept</button>
                    </form>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <script>
        // Simple polling for real-time updates (replace with Echo/Pusher for production)
        setInterval(function() {
          fetch(window.location.href + '?bids_partial=1')
            .then(res => res.text())
            .then(html => {
              const parser = new DOMParser();
              const doc = parser.parseFromString(html, 'text/html');
              const newTable = doc.querySelector('#bids-table-container');
              if (newTable) {
                document.querySelector('#bids-table-container').innerHTML = newTable.innerHTML;
              }
            });
        }, 5000);
      </script>
    @elseif(auth()->user() && auth()->user()->id !== $requirement->user_id && $requirement->status === 'open')
      <h3>Submit a Bid</h3>
      <form method="POST" action="{{ route('bids.store', $requirement) }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Amount</label>
          <input type="number" name="amount" class="form-control" step="0.01" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Proposal</label>
          <textarea name="proposal" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Bid</button>
      </form>
    @endif
  </div>
@endsection
