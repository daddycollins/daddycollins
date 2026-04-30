@extends('layouts/layoutMaster')

@section('title', 'Orders Monitor - ArtisanConnect Admin')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/animate-css/animate.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('content')
  <!-- Flash Messages -->
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
      <i class="icon-base ri ri-check-double-line me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
      <i class="icon-base ri ri-error-warning-line me-2"></i>{{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
      <i class="icon-base ri ri-error-warning-line me-2"></i>
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

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
            <label class="form-label">Order Type</label>
            <select class="form-select form-select-sm" id="filterType">
              <option value="">All Types</option>
              <option value="service">Service</option>
              <option value="product">Product</option>
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
            <th class="py-3">Type</th>
            <th class="py-3">Amount</th>
            <th class="py-3">Order Status</th>
            <th class="py-3">Payment</th>
            <th class="py-3">Date</th>
            <th class="py-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($orders as $order)
            <tr @if ($order->status === 'cancelled') style="opacity: 0.6; text-decoration: line-through;" @elseif($order->status === 'held') style="opacity: 0.7; background-color: #fef3cd;" @elseif($order->status === 'pending') class="table-warning" @endif>
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
              <td class="py-3">{{ $order->artisan?->user?->name ?? $order->artisan?->business_name ?? 'N/A' }}</td>
              <td class="py-3">
                <span class="badge {{ $order->order_type === 'service' ? 'bg-label-info' : 'bg-label-primary' }}">
                  {{ ucfirst($order->order_type) }}
                </span>
              </td>
              <td class="py-3"><strong>ZWL {{ number_format($order->total_amount ?? $order->amount, 2) }}</strong></td>
              <td class="py-3">
                <span
                  class="badge {{ $order->status === 'completed' ? 'bg-label-success' : ($order->status === 'processing' ? 'bg-label-info' : ($order->status === 'pending' ? 'bg-label-warning' : ($order->status === 'held' ? 'bg-label-secondary' : ($order->status === 'paid' ? 'bg-label-success' : 'bg-label-danger')))) }}">
                  {{ $order->status === 'held' ? 'On Hold' : ucfirst($order->status) }}
                </span>
              </td>
              <td class="py-3">
                <span
                  class="badge {{ $order->payment_status === 'confirmed' || $order->payment_status === 'paid' ? 'bg-label-success' : ($order->payment_status === 'pending' || $order->payment_status === 'unpaid' ? 'bg-label-warning' : 'bg-label-danger') }}">
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
                    <li>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewOrderModal-{{ $order->id }}">
                        <i class="icon-base ri ri-eye-line me-2"></i>View Details
                      </a>
                    </li>
                    @if ($order->status !== 'completed' && $order->status !== 'cancelled')
                      <li><hr class="dropdown-divider"></li>
                      @if ($order->status === 'held')
                        <li>
                          <a class="dropdown-item resume-action" href="#"
                            data-order-label="#ORD-{{ $order->created_at->format('Y') }}-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}"
                            data-form-id="resumeForm-{{ $order->id }}">
                            <i class="icon-base ri ri-play-line me-2"></i>Resume Order
                          </a>
                          <form id="resumeForm-{{ $order->id }}" action="{{ route('admin-order-resume', $order) }}" method="POST" class="d-none">
                            @csrf
                          </form>
                        </li>
                      @else
                        <li>
                          <a class="dropdown-item hold-action" href="#"
                            data-order-label="#ORD-{{ $order->created_at->format('Y') }}-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}"
                            data-form-id="holdForm-{{ $order->id }}">
                            <i class="icon-base ri ri-pause-line me-2"></i>Hold Order
                          </a>
                          <form id="holdForm-{{ $order->id }}" action="{{ route('admin-order-hold', $order) }}" method="POST" class="d-none">
                            @csrf
                          </form>
                        </li>
                      @endif
                      <li>
                        <a class="dropdown-item text-danger cancel-action" href="#"
                          data-order-label="#ORD-{{ $order->created_at->format('Y') }}-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}"
                          data-form-id="cancelForm-{{ $order->id }}">
                          <i class="icon-base ri ri-close-circle-line me-2"></i>Cancel Order
                        </a>
                        <form id="cancelForm-{{ $order->id }}" action="{{ route('admin-order-cancel', $order) }}" method="POST" class="d-none">
                          @csrf
                          <input type="hidden" name="reason" id="cancelReason-{{ $order->id }}">
                        </form>
                      </li>
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

  <!-- View Order Modals -->
  @foreach($orders as $order)
    <div class="modal fade" id="viewOrderModal-{{ $order->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header border-0 pb-0">
            <div>
              <h5 class="modal-title mb-1">Order #ORD-{{ $order->created_at->format('Y') }}-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</h5>
              <div class="d-flex gap-2">
                <span class="badge {{ $order->status === 'completed' ? 'bg-label-success' : ($order->status === 'processing' ? 'bg-label-info' : ($order->status === 'pending' ? 'bg-label-warning' : ($order->status === 'held' ? 'bg-label-secondary' : ($order->status === 'paid' ? 'bg-label-success' : 'bg-label-danger')))) }}">
                  {{ $order->status === 'held' ? 'On Hold' : ucfirst($order->status) }}
                </span>
                <span class="badge {{ $order->payment_status === 'confirmed' || $order->payment_status === 'paid' ? 'bg-label-success' : ($order->payment_status === 'pending' || $order->payment_status === 'unpaid' ? 'bg-label-warning' : 'bg-label-danger') }}">
                  Payment: {{ ucfirst($order->payment_status ?? 'Pending') }}
                </span>
                <span class="badge {{ $order->order_type === 'service' ? 'bg-label-info' : 'bg-label-primary' }}">
                  {{ ucfirst($order->order_type) }}
                </span>
              </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="row g-4">
              <!-- Customer Info -->
              <div class="col-md-6">
                <div class="card bg-light border-0">
                  <div class="card-body">
                    <h6 class="text-uppercase text-muted small mb-3">
                      <i class="icon-base ri ri-user-line me-1"></i>Customer
                    </h6>
                    <div class="d-flex align-items-center gap-3 mb-3">
                      <div class="avatar avatar-md rounded-circle bg-label-primary">
                        <span class="avatar-initial rounded-circle">{{ substr($order->client?->name ?? 'N', 0, 1) }}</span>
                      </div>
                      <div>
                        <h6 class="mb-0">{{ $order->client?->name ?? 'N/A' }}</h6>
                        <small class="text-muted">{{ $order->client?->email ?? 'N/A' }}</small>
                      </div>
                    </div>
                    @if ($order->shipping_address)
                      <div class="mb-0">
                        <small class="text-muted d-block">Shipping Address</small>
                        <span class="small">{{ $order->shipping_address }}</span>
                      </div>
                    @endif
                  </div>
                </div>
              </div>

              <!-- Artisan Info -->
              <div class="col-md-6">
                <div class="card bg-light border-0">
                  <div class="card-body">
                    <h6 class="text-uppercase text-muted small mb-3">
                      <i class="icon-base ri ri-hammer-line me-1"></i>Artisan
                    </h6>
                    <div class="d-flex align-items-center gap-3 mb-3">
                      <div class="avatar avatar-md rounded-circle bg-label-warning">
                        <span class="avatar-initial rounded-circle">{{ substr($order->artisan?->user?->name ?? $order->artisan?->business_name ?? 'N', 0, 1) }}</span>
                      </div>
                      <div>
                        <h6 class="mb-0">{{ $order->artisan?->user?->name ?? 'N/A' }}</h6>
                        <small class="text-muted">{{ $order->artisan?->business_name ?? 'N/A' }}</small>
                      </div>
                    </div>
                    @if ($order->artisan?->location)
                      <div class="mb-0">
                        <small class="text-muted d-block">Location</small>
                        <span class="small">{{ $order->artisan->location }}</span>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>

            <!-- Order Items -->
            @if ($order->items->count() > 0)
              <div class="card bg-light border-0 mt-4">
                <div class="card-body">
                  <h6 class="text-uppercase text-muted small mb-3">
                    <i class="icon-base ri ri-file-list-3-line me-1"></i>Order Items
                  </h6>
                  <div class="table-responsive">
                    <table class="table table-sm mb-0">
                      <thead>
                        <tr>
                          <th>Item</th>
                          <th>Type</th>
                          <th class="text-center">Qty</th>
                          <th class="text-end">Price</th>
                          <th class="text-end">Subtotal</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($order->items as $item)
                          <tr>
                            <td>{{ $item->artisanService?->service_name ?? 'Item #' . $item->item_id }}</td>
                            <td><span class="badge bg-label-secondary">{{ ucfirst($item->item_type) }}</span></td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">ZWL {{ number_format($item->price, 2) }}</td>
                            <td class="text-end">ZWL {{ number_format($item->price * $item->quantity, 2) }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                      <tfoot class="border-top">
                        <tr>
                          <td colspan="4" class="text-end fw-semibold">Total</td>
                          <td class="text-end fw-bold">ZWL {{ number_format($order->total_amount ?? $order->amount, 2) }}</td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            @endif

            <!-- Payment & Order Details -->
            <div class="row g-4 mt-0">
              <div class="col-md-6">
                <div class="card bg-light border-0">
                  <div class="card-body">
                    <h6 class="text-uppercase text-muted small mb-3">
                      <i class="icon-base ri ri-bank-card-line me-1"></i>Payment Details
                    </h6>
                    <div class="d-flex justify-content-between mb-2">
                      <span class="text-muted">Amount</span>
                      <span class="fw-semibold">ZWL {{ number_format($order->total_amount ?? $order->amount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                      <span class="text-muted">Method</span>
                      <span>{{ ucfirst($order->payment_method ?? 'N/A') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                      <span class="text-muted">Status</span>
                      <span class="badge {{ $order->payment_status === 'confirmed' || $order->payment_status === 'paid' ? 'bg-success' : ($order->payment_status === 'pending' || $order->payment_status === 'unpaid' ? 'bg-warning' : 'bg-danger') }}">
                        {{ ucfirst($order->payment_status ?? 'Pending') }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card bg-light border-0">
                  <div class="card-body">
                    <h6 class="text-uppercase text-muted small mb-3">
                      <i class="icon-base ri ri-calendar-line me-1"></i>Timeline
                    </h6>
                    <div class="d-flex justify-content-between mb-2">
                      <span class="text-muted">Order Placed</span>
                      <span>{{ $order->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                      <span class="text-muted">Last Updated</span>
                      <span>{{ $order->updated_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                      <span class="text-muted">Order Type</span>
                      <span class="badge {{ $order->order_type === 'service' ? 'bg-label-info' : 'bg-label-primary' }}">{{ ucfirst($order->order_type) }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer border-0 pt-0">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  @endforeach
@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Order search
      document.getElementById('orderSearch').addEventListener('keyup', function(e) {
        var searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(function(row) {
          var text = row.textContent.toLowerCase();
          row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
      });

      // Reset filters
      document.getElementById('resetFilters').addEventListener('click', function() {
        document.getElementById('filterStatus').value = '';
        document.getElementById('filterPayment').value = '';
        document.getElementById('filterType').value = '';
        document.querySelectorAll('tbody tr').forEach(function(row) { row.style.display = ''; });
      });

      // Hold order confirmation
      document.querySelectorAll('.hold-action').forEach(function(link) {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          var orderLabel = this.getAttribute('data-order-label');
          var formId = this.getAttribute('data-form-id');
          Swal.fire({
            title: 'Hold Order?',
            text: 'Put ' + orderLabel + ' on hold? The customer will be notified.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Hold Order',
            confirmButtonColor: '#ffb64d',
            cancelButtonText: 'Cancel'
          }).then(function(result) {
            if (result.isConfirmed) {
              document.getElementById(formId).submit();
            }
          });
        });
      });

      // Resume order confirmation
      document.querySelectorAll('.resume-action').forEach(function(link) {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          var orderLabel = this.getAttribute('data-order-label');
          var formId = this.getAttribute('data-form-id');
          Swal.fire({
            title: 'Resume Order?',
            text: 'Resume processing ' + orderLabel + '? The artisan will be notified.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Resume',
            confirmButtonColor: '#71dd5a',
            cancelButtonText: 'Cancel'
          }).then(function(result) {
            if (result.isConfirmed) {
              document.getElementById(formId).submit();
            }
          });
        });
      });

      // Cancel order with reason
      document.querySelectorAll('.cancel-action').forEach(function(link) {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          var orderLabel = this.getAttribute('data-order-label');
          var formId = this.getAttribute('data-form-id');
          var orderId = formId.replace('cancelForm-', '');
          Swal.fire({
            title: 'Cancel Order?',
            text: 'Are you sure you want to cancel ' + orderLabel + '? This action cannot be undone.',
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: 'Yes, Cancel Order',
            confirmButtonColor: '#dc3545',
            cancelButtonText: 'Keep Order'
          }).then(function(result) {
            if (result.isConfirmed) {
              Swal.fire({
                title: 'Cancellation Reason',
                input: 'textarea',
                inputPlaceholder: 'Please provide a reason for cancellation (min 5 characters)...',
                showCancelButton: true,
                confirmButtonText: 'Confirm Cancellation',
                confirmButtonColor: '#dc3545',
                cancelButtonText: 'Go Back',
                inputValidator: function(value) {
                  if (!value || value.length < 5) {
                    return 'Please provide a reason (at least 5 characters).';
                  }
                }
              }).then(function(reasonResult) {
                if (reasonResult.isConfirmed) {
                  document.getElementById('cancelReason-' + orderId).value = reasonResult.value;
                  document.getElementById(formId).submit();
                }
              });
            }
          });
        });
      });
    });
  </script>
@endsection
