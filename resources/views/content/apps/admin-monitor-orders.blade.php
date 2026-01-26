@extends('layouts/layoutMaster')

@section('title', 'Orders Monitor - ArtisanConnect Admin')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/animate-css/animate.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('content')
  <!-- Header -->
  <div
    class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-between mb-6 text-center text-sm-start gap-2">
    <div class="mb-2 mb-sm-0">
      <h4 class="mb-1"><i class="icon-base ri ri-shopping-cart-2-line me-2 text-primary"></i>Orders Monitor</h4>
      <p class="mb-0">Monitor, manage, and process all platform orders</p>
    </div>
  </div>

  <!-- Statistics Cards -->
  <div class="row g-6 mb-6">
    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Total Orders</p>
              <h3 class="mb-2">{{ number_format($totalOrders) }}</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>+18% MTD</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-primary">
              <div class="avatar-initial"><i class="icon-base ri ri-shopping-cart-line"></i></div>
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
              <p class="text-muted small mb-1">Pending Payment</p>
              <h3 class="mb-2">{{ number_format($pendingPaymentOrders) }}</h3>
              <p class="mb-0"><span class="badge bg-label-warning">Action needed</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-warning">
              <div class="avatar-initial"><i class="icon-base ri ri-time-line"></i></div>
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
              <p class="text-muted small mb-1">In Progress</p>
              <h3 class="mb-2">{{ number_format($inProgressOrders) }}</h3>
              <p class="mb-0"><span class="badge bg-label-info">Being processed</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-info">
              <div class="avatar-initial"><i class="icon-base ri ri-loader-4-line"></i></div>
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
              <p class="text-muted small mb-1">Revenue (Today)</p>
              <h3 class="mb-2">ZWL {{ number_format($todayRevenue, 2) }}</h3>
              <p class="mb-0"><span class="badge bg-label-success">+12.5%</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-success">
              <div class="avatar-initial"><i class="icon-base ri ri-money-dollar-circle-line"></i></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Orders Table -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
      <h5 class="card-title m-0"><i class="icon-base ri ri-list-check me-2"></i>All Orders</h5>
      <div class="d-flex gap-2">
        <div class="input-group input-group-sm" style="width: 250px;">
          <span class="input-group-text border-0"><i class="icon-base ri ri-search-line"></i></span>
          <input type="text" class="form-control form-control-sm border-0" placeholder="Search orders..."
            id="orderSearch">
        </div>
        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#filterPanel">
          <i class="icon-base ri ri-filter-line me-1"></i>Filters
        </button>
      </div>
    </div>

    <!-- Filter Panel -->
    <div class="collapse" id="filterPanel">
      <div class="card-body border-bottom">
        <div class="row g-3">
          <div class="col-md-3">
            <label class="form-label">Order Status</label>
            <select class="form-select form-select-sm" id="filterStatus">
              <option value="">All Status</option>
              <option value="pending">Pending Payment</option>
              <option value="processing">Processing</option>
              <option value="completed">Completed</option>
              <option value="held">On Hold</option>
              <option value="cancelled">Cancelled</option>
              <option value="failed">Failed</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Payment Status</label>
            <select class="form-select form-select-sm" id="filterPayment">
              <option value="">All Payment</option>
              <option value="pending">Pending</option>
              <option value="confirmed">Confirmed</option>
              <option value="failed">Failed</option>
              <option value="refunded">Refunded</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Date Range</label>
            <select class="form-select form-select-sm" id="filterDate">
              <option value="">All Time</option>
              <option value="today">Today</option>
              <option value="week">This Week</option>
              <option value="month">This Month</option>
              <option value="year">This Year</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">&nbsp;</label>
            <button class="btn btn-sm btn-outline-secondary w-100" id="resetFilters">Reset Filters</button>
          </div>
        </div>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="bg-light">
          <tr>
            <th class="py-3">Order ID</th>
            <th class="py-3">Customer</th>
            <th class="py-3">Artisan</th>
            <th class="py-3">Service</th>
            <th class="py-3">Amount</th>
            <th class="py-3">Order Status</th>
            <th class="py-3">Payment</th>
            <th class="py-3">Date</th>
            <th class="py-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Order 1 -->
          @forelse($orders as $order)
            <tr
              @if ($order->status === 'pending') class="table-warning" @elseif($order->status === 'cancelled') style="opacity: 0.6; text-decoration: line-through;" @endif>
              <td class="py-3">
                <strong>#ORD-{{ $order->created_at->format('Y') }}-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</strong>
              </td>
              <td class="py-3">
                <div class="d-flex align-items-center gap-2">
                  <div class="avatar avatar-sm rounded-circle bg-label-primary">
                    <span class="avatar-initial rounded-circle">{{ substr($order->client?->name ?? 'N', 0, 1) }}</span>
                  </div>
                  <span>{{ $order->client?->name ?? 'N/A' }}</span>
                </div>
              </td>
              <td class="py-3">{{ $order->artisan?->name ?? 'N/A' }}</td>
              <td class="py-3">{{ $order->artisanService?->service_name ?? 'N/A' }}</td>
              <td class="py-3"><strong>ZWL {{ number_format($order->amount, 2) }}</strong></td>
              <td class="py-3">
                <span
                  class="badge {{ $order->status === 'completed' ? 'bg-label-success' : ($order->status === 'processing' ? 'bg-label-info' : ($order->status === 'pending' ? 'bg-label-warning' : ($order->status === 'held' ? 'bg-label-secondary' : 'bg-label-danger'))) }}">
                  {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                </span>
              </td>
              <td class="py-3">
                <span
                  class="badge {{ $order->payment_status === 'confirmed' ? 'bg-label-success' : ($order->payment_status === 'pending' ? 'bg-label-warning' : 'bg-label-danger') }}">
                  {{ ucfirst($order->payment_status ?? 'Pending') }}
                </span>
              </td>
              <td class="py-3">{{ $order->created_at->format('M d, Y') }}</td>
              <td class="py-3">
                <div class="dropdown">
                  <button class="btn btn-icon btn-text-secondary" data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-line"></i>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item order-action" href="#" data-action="view"
                        data-order-id="{{ $order->id }}"><i class="icon-base ri ri-eye-line me-2"></i>View
                        Details</a></li>
                    <li><a class="dropdown-item order-action" href="#" data-action="review-payment"
                        data-order-id="{{ $order->id }}"><i class="icon-base ri ri-bank-card-line me-2"></i>Review
                        Payment</a></li>
                    @if ($order->status !== 'completed' && $order->status !== 'cancelled')
                      <li>
                        <hr class="dropdown-divider">
                      </li>
                      @if ($order->status === 'held')
                        <li><a class="dropdown-item order-action" href="#" data-action="resume"
                            data-order-id="{{ $order->id }}"><i class="icon-base ri ri-play-line me-2"></i>Resume
                            Order</a></li>
                      @else
                        <li><a class="dropdown-item order-action" href="#" data-action="hold"
                            data-order-id="{{ $order->id }}"><i class="icon-base ri ri-pause-line me-2"></i>Hold
                            Order</a></li>
                      @endif
                      <li><a class="dropdown-item text-danger order-action" href="#" data-action="cancel"
                          data-order-id="{{ $order->id }}"><i
                            class="icon-base ri ri-close-circle-line me-2"></i>Cancel Order</a></li>
                    @endif
                  </ul>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="text-center py-4">
                <p class="text-muted mb-0">No orders found</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pagination -->
  <div class="d-flex justify-content-between align-items-center mt-4">
    <small class="text-muted">Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of
      {{ $orders->total() }} orders</small>
    {{ $orders->links() }}
  </div>

@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Order search functionality
      document.getElementById('orderSearch').addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(row => {
          const text = row.textContent.toLowerCase();
          row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
      });

      // Reset filters
      document.getElementById('resetFilters').addEventListener('click', function() {
        document.getElementById('filterStatus').value = '';
        document.getElementById('filterPayment').value = '';
        document.getElementById('filterDate').value = '';
        document.querySelectorAll('tbody tr').forEach(row => row.style.display = '');
      });

      // Action handlers
      document.querySelectorAll('[data-action]').forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          const action = this.getAttribute('data-action');
          const row = this.closest('tr');
          const orderId = row.querySelector('strong').textContent;
          const customer = row.querySelector('td:nth-child(2)').textContent.trim();
          const amount = row.querySelector('td:nth-child(5)').textContent.trim();

          switch (action) {
            case 'hold':
              Swal.fire({
                title: 'Hold Order?',
                text: `Put ${orderId} on hold? The customer will be notified.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Hold Order',
                confirmButtonColor: '#ffb64d',
                cancelButtonText: 'Cancel'
              }).then((result) => {
                if (result.isConfirmed) {
                  const statusCell = row.querySelector('td:nth-child(6)');
                  statusCell.innerHTML = '<span class="badge bg-label-secondary">On Hold</span>';
                  row.style.opacity = '0.7';
                  row.style.backgroundColor = '#fef3cd';
                  Swal.fire('Held!', `${orderId} has been placed on hold.`, 'success');
                }
              });
              break;

            case 'resume':
              Swal.fire({
                title: 'Resume Order?',
                text: `Resume processing ${orderId}? The artisan will be notified.`,
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Yes, Resume',
                confirmButtonColor: '#71dd5a',
                cancelButtonText: 'Cancel'
              }).then((result) => {
                if (result.isConfirmed) {
                  const statusCell = row.querySelector('td:nth-child(6)');
                  statusCell.innerHTML = '<span class="badge bg-label-info">In Progress</span>';
                  row.style.opacity = '1';
                  row.style.backgroundColor = 'transparent';
                  Swal.fire('Resumed!', `${orderId} has been resumed.`, 'success');
                }
              });
              break;

            case 'cancel':
              Swal.fire({
                title: 'Cancel Order?',
                text: `Are you sure you want to cancel ${orderId}? This action cannot be undone.`,
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Yes, Cancel Order',
                confirmButtonColor: '#dc3545',
                cancelButtonText: 'Keep Order'
              }).then((result) => {
                if (result.isConfirmed) {
                  Swal.fire({
                    title: 'Cancellation Reason',
                    input: 'textarea',
                    inputPlaceholder: 'Please provide a reason for cancellation...',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm Cancellation',
                    confirmButtonColor: '#dc3545',
                    cancelButtonText: 'Cancel'
                  }).then((reasonResult) => {
                    if (reasonResult.isConfirmed) {
                      const statusCell = row.querySelector('td:nth-child(6)');
                      statusCell.innerHTML = '<span class="badge bg-label-danger">Cancelled</span>';
                      const paymentCell = row.querySelector('td:nth-child(7)');
                      paymentCell.innerHTML = '<span class="badge bg-label-danger">Cancelled</span>';
                      row.style.opacity = '0.6';
                      row.style.textDecoration = 'line-through';
                      Swal.fire('Cancelled!',
                        `${orderId} has been cancelled.\nReason: ${reasonResult.value}`, 'success');
                    }
                  });
                }
              });
              break;

            case 'review-payment':
              Swal.fire({
                title: 'Payment Review - ' + orderId,
                html: `
                <div class="text-start">
                  <div class="mb-3">
                    <label class="form-label"><strong>Customer:</strong></label>
                    <p>${customer}</p>
                  </div>
                  <div class="mb-3">
                    <label class="form-label"><strong>Amount:</strong></label>
                    <p>${amount}</p>
                  </div>
                  <div class="mb-3">
                    <label class="form-label"><strong>Payment Method:</strong></label>
                    <select class="form-select form-select-sm" id="paymentMethod">
                      <option selected>Paynow Transfer</option>
                      <option>Cash Payment</option>
                      <option>Ecocash</option>
                      <option>Other</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label class="form-label"><strong>Status:</strong></label>
                    <select class="form-select form-select-sm" id="paymentStatus">
                      <option>Pending</option>
                      <option selected>Confirmed</option>
                      <option>Failed</option>
                      <option>Refunded</option>
                    </select>
                  </div>
                  <div class="mb-0">
                    <label class="form-label"><strong>Reference:</strong></label>
                    <input type="text" class="form-control form-control-sm" value="TXN-2024-001548" readonly>
                  </div>
                </div>
              `,
                showCancelButton: true,
                confirmButtonText: 'Update Payment',
                cancelButtonText: 'Close'
              }).then((result) => {
                if (result.isConfirmed) {
                  const paymentStatus = document.getElementById('paymentStatus').value;
                  const paymentCell = row.querySelector('td:nth-child(7)');

                  let badgeColor = 'bg-label-success';
                  if (paymentStatus === 'Failed') badgeColor = 'bg-label-danger';
                  else if (paymentStatus === 'Pending') badgeColor = 'bg-label-warning';
                  else if (paymentStatus === 'Refunded') badgeColor = 'bg-label-secondary';

                  paymentCell.innerHTML = `<span class="badge ${badgeColor}">${paymentStatus}</span>`;
                  Swal.fire('Updated!', 'Payment information has been updated.', 'success');
                }
              });
              break;

            case 'view':
              Swal.fire({
                title: 'Order Details - ' + orderId,
                html: `
                <div class="text-start" style="max-height: 400px; overflow-y: auto;">
                  <div class="row mb-3">
                    <div class="col-6"><strong>Order ID:</strong> ${orderId}</div>
                    <div class="col-6"><strong>Date:</strong> ${row.querySelector('td:nth-child(8)').textContent}</div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-6"><strong>Customer:</strong> ${customer}</div>
                    <div class="col-6"><strong>Artisan:</strong> ${row.querySelector('td:nth-child(3)').textContent}</div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-6"><strong>Service:</strong> ${row.querySelector('td:nth-child(4)').textContent}</div>
                    <div class="col-6"><strong>Amount:</strong> ${amount}</div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-6"><strong>Order Status:</strong> ${row.querySelector('td:nth-child(6)').textContent}</div>
                    <div class="col-6"><strong>Payment:</strong> ${row.querySelector('td:nth-child(7)').textContent}</div>
                  </div>
                  <div class="alert alert-info mt-3 mb-0">
                    <strong>Timeline:</strong>
                    <ul class="mb-0 mt-2">
                      <li>Order Placed: Jan 15, 2024 10:30 AM</li>
                      <li>Artisan Accepted: Jan 15, 2024 10:45 AM</li>
                      <li>Work In Progress: Jan 15, 2024 02:00 PM</li>
                      <li>Pending Payment: Jan 16, 2024 04:30 PM</li>
                    </ul>
                  </div>
                </div>
              `,
                confirmButtonText: 'Close'
              });
              break;
          }
        });
      });
    });
  </script>
@endsection
