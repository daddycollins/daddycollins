@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Payments - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('content')
  <!-- Header Stats -->
  <div class="row g-6 mb-6">
    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Total Earnings</p>
              <h3 class="mb-2">ZWL {{ number_format($totalEarnings, 2) }}</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>{{ $completedOrdersCount }} completed orders</span>
              </p>
            </div>
            <div class="avatar avatar-lg bg-label-success">
              <div class="avatar-initial"><i class="icon-base ri ri-wallet-2-line"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Available Balance</p>
              <h3 class="mb-2">ZWL {{ number_format($availableBalance, 2) }}</h3>
              <p class="mb-0"><span class="badge {{ $availableBalance > 0 ? 'bg-label-info' : 'bg-label-warning' }}"><i
                    class="icon-base ri ri-bank-card-line me-1"></i>{{ $availableBalance > 0 ? 'Ready to withdraw' : 'No balance' }}</span>
              </p>
            </div>
            <div class="avatar avatar-lg bg-label-info">
              <div class="avatar-initial"><i class="icon-base ri ri-money-pound-circle-line"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Pending Payouts</p>
              <h3 class="mb-2">ZWL {{ number_format($pendingPayouts, 2) }}</h3>
              <p class="mb-0"><span class="badge {{ $pendingPayouts > 0 ? 'bg-label-warning' : 'bg-label-success' }}"><i
                    class="icon-base ri ri-time-line me-1"></i>{{ $pendingPayouts > 0 ? 'Processing' : 'None' }}</span>
              </p>
            </div>
            <div class="avatar avatar-lg bg-label-warning">
              <div class="avatar-initial"><i class="icon-base ri ri-hourglass-2-line"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Last Payment</p>
              <h3 class="mb-2">{{ $lastPayout ? $lastPayout->processed_at->format('d M Y') : 'No payment yet' }}</h3>
              <p class="mb-0"><span
                  class="badge bg-label-primary">{{ $lastPayout ? 'ZWL ' . number_format($lastPayout->amount, 2) : 'N/A' }}</span>
              </p>
            </div>
            <div class="avatar avatar-lg bg-label-primary">
              <div class="avatar-initial"><i class="icon-base ri ri-calendar-event-line"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts Section -->
  <div class="row g-6 mb-6">
    <div class="col-md-8">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0"><i class="icon-base ri ri-line-chart-line me-2 text-primary"></i>Earnings Trend
          </h5>
        </div>
        <div class="card-body">
          <div id="earningsTrendChart" style="height: 350px;"></div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0"><i class="icon-base ri ri-pie-chart-line me-2 text-success"></i>Payment Methods
          </h5>
        </div>
        <div class="card-body">
          <div id="paymentMethodChart" style="height: 350px;"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Paynow Account Info Card -->
  <div class="card border-0 shadow-sm mb-6">
    <div class="card-header bg-white border-bottom">
      <div class="row g-3 align-items-center">
        <div class="col-md-6">
          <h5 class="card-title m-0"><i class="icon-base ri ri-bank-card-line me-2 text-primary"></i>Payment Methods
          </h5>
        </div>
        <div class="col-md-6 text-end">
          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPaynowModal">
            <i class="icon-base ri ri-add-line me-2"></i>Add Paynow Account
          </button>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row g-4">
        <!-- Active Paynow Account -->
        @if ($paynowAccount)
          <div class="col-md-6">
            <div class="border rounded-3 p-4 bg-light">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                  <h6 class="mb-1 fw-medium"><i class="icon-base ri ri-bank-card-2-line text-primary me-2"></i>Paynow
                    Account</h6>
                  <p class="text-muted small mb-2">Primary Payment Method</p>
                </div>
                <span class="badge bg-label-success">Active</span>
              </div>
              <div class="ps-4">
                <p class="mb-2"><small class="text-muted">ID:</small>
                  <strong>{{ Str::limit($paynowAccount->paynow_integration_id, 5) }}...</strong>
                </p>
                <p class="mb-3"><small class="text-muted">Status:</small> <strong>Connected</strong></p>
                <div class="d-flex gap-2">
                  <button type="button" class="btn btn-sm btn-outline-primary edit-paynow-btn"
                    data-paynow-id="{{ $paynowAccount->id }}"
                    data-paynow-integration-id="{{ $paynowAccount->paynow_integration_id }}"
                    data-paynow-integration-key="{{ $paynowAccount->paynow_integration_key }}" data-bs-toggle="modal"
                    data-bs-target="#editPaynowModal">
                    <i class="icon-base ri ri-edit-line me-1"></i>Edit
                  </button>
                  <form method="POST" action="{{ route('artisan-paynow-delete', $paynowAccount->id) }}"
                    style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger"
                      onclick="return confirm('Are you sure?')">
                      <i class="icon-base ri ri-delete-bin-line me-1"></i>Remove
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @else
          <div class="col-12">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              <i class="icon-base ri ri-information-line me-2"></i>No Paynow account connected. Add one to receive
              payments.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Payment Transactions Table -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
      <div class="row g-3 align-items-center">
        <div class="col-md-6">
          <h5 class="card-title m-0"><i class="icon-base ri ri-file-list-line me-2 text-primary"></i>Payment
            Transactions</h5>
        </div>
        <div class="col-md-6 text-end">
          <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
            data-bs-target="#requestPayoutModal">
            <i class="icon-base ri ri-send-plane-line me-2"></i>Request Payout
          </button>
        </div>
      </div>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>Transaction ID</th>
              <th>Order</th>
              <th>Service/Product</th>
              <th>Client</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Payment Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($transactions as $transaction)
              <tr>
                <td><strong>#TXN-{{ $transaction->id }}</strong></td>
                <td>#ORD-{{ $transaction->id }}</td>
                <td><span
                    class="badge bg-label-primary">{{ $transaction->items->first()?->service_name ?? 'Service/Product' }}</span>
                </td>
                <td>{{ $transaction->client->name }}</td>
                <td><strong>ZWL {{ number_format($transaction->total_amount ?? 0, 2) }}</strong></td>
                <td><span
                    class="badge {{ $transaction->status === 'completed' ? 'bg-label-success' : ($transaction->status === 'pending' ? 'bg-label-warning' : 'bg-label-info') }}">{{ ucfirst($transaction->status) }}</span>
                </td>
                <td>{{ $transaction->created_at->format('d M Y') }}</td>
                <td>
                  <div class="dropdown">
                    <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                      data-bs-toggle="dropdown">
                      <i class="icon-base ri ri-more-2-fill"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="javascript:void(0);">
                        <i class="icon-base ri ri-receipt-line me-2"></i>View Receipt
                      </a>
                      <a class="dropdown-item" href="javascript:void(0);">
                        <i class="icon-base ri ri-download-cloud-line me-2"></i>Download Invoice
                      </a>
                    </div>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center py-4">
                  <p class="text-muted mb-2">No transactions found.</p>
                  <p class="text-muted small">Complete orders to see transactions here.</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Add Paynow Modal -->
  <div class="modal fade" id="addPaynowModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-bank-card-line me-2 text-primary"></i>Add Paynow Account
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addPaynowForm" method="POST" action="{{ route('artisan-paynow-add') }}">
            @csrf
            <div class="mb-4">
              <label class="form-label fw-medium">Paynow ID *</label>
              <input type="text" class="form-control" name="paynow_integration_id"
                placeholder="Enter your Paynow ID (e.g., +263...)" required />
              <small class="text-muted">Your Paynow ID is used for receiving payments</small>
            </div>
            <div class="mb-0">
              <label class="form-label fw-medium">Paynow Integration Key *</label>
              <input type="text" class="form-control" name="paynow_integration_key"
                placeholder="Enter your Paynow Integration Key" required />
              <small class="text-muted">Keep this secure. We'll encrypt it for you.</small>
            </div>
          </form>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" form="addPaynowForm">
            <i class="icon-base ri ri-check-line me-2"></i>Add Account
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Paynow Modal -->
  <div class="modal fade" id="editPaynowModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-edit-line me-2 text-primary"></i>Edit Paynow Account</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editPaynowForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
              <label class="form-label fw-medium">Paynow ID *</label>
              <input type="text" class="form-control" id="editPaynowId" name="paynow_integration_id" required />
            </div>
            <div class="mb-0">
              <label class="form-label fw-medium">Paynow Integration Key *</label>
              <input type="text" class="form-control" id="editPaynowKey" name="paynow_integration_key" required />
            </div>
          </form>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" form="editPaynowForm">
            <i class="icon-base ri ri-check-line me-2"></i>Save Changes
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Request Payout Modal -->
  <div class="modal fade" id="requestPayoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-send-plane-line me-2 text-success"></i>Request Payout</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="payoutForm" method="POST" action="{{ route('artisan-payout-request') }}">
            @csrf
            <div class="alert alert-info" role="alert">
              <small><strong>Available Balance:</strong> ZWL {{ number_format($availableBalance, 2) }}</small>
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium">Amount to Withdraw *</label>
              <div class="input-group">
                <span class="input-group-text">ZWL</span>
                <input type="number" class="form-control" name="amount" placeholder="Enter amount" min="1000"
                  max="{{ $availableBalance }}" required />
              </div>
              <small class="text-muted">Minimum: ZWL 1,000 | Maximum: ZWL
                {{ number_format($availableBalance, 2) }}</small>
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium">Payment Method *</label>
              <select class="form-select" name="payment_method" required>
                <option value="">Select payment method</option>
                <option value="paynow">Paynow</option>
                <option value="bank_transfer">Bank Transfer</option>
              </select>
            </div>
            <div class="mb-0">
              <label class="form-label fw-medium">Notes (Optional)</label>
              <textarea class="form-control" name="notes" rows="2"
                placeholder="Add any notes about this payout request..."></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success" form="payoutForm">
            <i class="icon-base ri ri-check-line me-2"></i>Request Payout
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Edit Paynow Modal - Populate form
    document.querySelectorAll('.edit-paynow-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const paynowId = this.getAttribute('data-paynow-id');
        const integrationId = this.getAttribute('data-paynow-integration-id');
        const integrationKey = this.getAttribute('data-paynow-integration-key');

        document.getElementById('editPaynowId').value = integrationId;
        document.getElementById('editPaynowKey').value = integrationKey;

        const form = document.getElementById('editPaynowForm');
        form.action = `/artisan/paynow/${paynowId}/update`;
      });
    });

    // Earnings Trend Chart
    const earningsTrendChart = new ApexCharts(document.querySelector("#earningsTrendChart"), {
      series: [{
        name: "Earnings",
        data: [{{ implode(',', $earningsTrend) }}]
      }],
      chart: {
        type: "area",
        height: 350,
        sparkline: {
          enabled: false
        }
      },
      colors: ["#28a745"],
      stroke: {
        curve: "smooth",
        width: 2
      },
      fill: {
        type: "gradient",
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.45,
          opacityTo: 0.05
        }
      },
      xaxis: {
        categories: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"]
      },
      yaxis: {
        title: {
          text: "Earnings (ZWL)"
        }
      },
      tooltip: {
        shared: true,
        intersect: false
      }
    });
    earningsTrendChart.render();

    // Payment Methods Chart
    const paymentMethodChart = new ApexCharts(document.querySelector("#paymentMethodChart"), {
      series: [{{ $paynowAccount ? '100, 0, 0' : '0, 0, 100' }}],
      chart: {
        type: "donut",
        height: 350
      },
      labels: ["Paynow", "Bank Transfer", "Other"],
      colors: ["#667eea", "#28a745", "#ffc107"],
      legend: {
        position: "bottom"
      }
    });
    paymentMethodChart.render();
  </script>
@endsection
