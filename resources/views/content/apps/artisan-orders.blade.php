@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'My Orders - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('content')
  <!-- Flash Messages Alert Component -->
  <x-alert />

  <!-- Header Stats -->
  <div class="row g-6 mb-6">
    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Total Orders</p>
              <h3 class="mb-2">{{ $totalOrders }}</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>{{ $totalOrders > 0 ? '+' . $totalOrders : 'No orders' }}</span>
              </p>
            </div>
            <div class="avatar avatar-lg bg-label-primary">
              <div class="avatar-initial"><i class="icon-base ri ri-shopping-bag-line"></i></div>
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
              <p class="text-muted small mb-1">Pending Orders</p>
              <h3 class="mb-2">{{ $pendingOrders }}</h3>
              <p class="mb-0"><span class="badge bg-label-warning"><i
                    class="icon-base ri ri-alert-line me-1"></i>Awaiting action</span></p>
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
              <p class="text-muted small mb-1">Completed Orders</p>
              <h3 class="mb-2">{{ $completedOrders }}</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-check-line me-1"></i>{{ $completionRate }}%</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-success">
              <div class="avatar-initial"><i class="icon-base ri ri-check-double-line"></i></div>
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
              <p class="text-muted small mb-1">Total Revenue</p>
              <h3 class="mb-2">ZWL {{ number_format($totalRevenue, 0) }}</h3>
              <p class="mb-0"><span class="badge bg-label-info"><i class="icon-base ri ri-arrow-up-s-line me-1"></i>From
                  completed orders</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-info">
              <div class="avatar-initial"><i class="icon-base ri ri-money-dollar-circle-line"></i></div>
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
          <h5 class="card-title m-0"><i class="icon-base ri ri-line-chart-line me-2 text-primary"></i>Order Status Trend
          </h5>
        </div>
        <div class="card-body">
          <div id="orderTrendChart" style="height: 350px;"></div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0"><i class="icon-base ri ri-pie-chart-line me-2 text-success"></i>Order Status
            Distribution</h5>
        </div>
        <div class="card-body">
          <div id="statusDistributionChart" style="height: 350px;"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Orders Table -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
      <div class="row g-3 align-items-center">
        <div class="col-md-6">
          <h5 class="card-title m-0"><i class="icon-base ri ri-shopping-cart-line me-2 text-primary"></i>Recent Orders
          </h5>
        </div>
        <div class="col-md-6 text-end">
          <div class="btn-group" role="group">
            <input type="radio" class="btn-check" name="orderFilter" id="allOrders" value="all" checked />
            <label class="btn btn-outline-primary btn-sm" for="allOrders">All</label>
            <input type="radio" class="btn-check" name="orderFilter" id="pending" value="pending" />
            <label class="btn btn-outline-primary btn-sm" for="pending">Pending</label>
            <input type="radio" class="btn-check" name="orderFilter" id="completed" value="completed" />
            <label class="btn btn-outline-primary btn-sm" for="completed">Completed</label>
          </div>
        </div>
      </div>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>Order ID</th>
              <th>Client</th>
              <th>Service/Product</th>
              <th>Order Date</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Payment</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($orders as $order)
              <tr data-status="{{ $order->status }}">
                <td><strong>#ORD-{{ $order->id }}</strong></td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2">
                      <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Client" class="rounded-circle" />
                    </div>
                    <div>
                      <h6 class="mb-0 fw-medium">{{ $order->client->name ?? 'Unknown' }}</h6>
                      <small class="text-muted">Client</small>
                    </div>
                  </div>
                </td>
                <td><span
                    class="badge bg-label-{{ $order->order_type === 'service' ? 'primary' : 'info' }}">{{ ucfirst($order->order_type) }}</span>
                </td>
                <td>{{ $order->created_at->format('d M Y') }}</td>
                <td><strong>ZWL {{ number_format($order->total_amount, 2) }}</strong></td>
                <td>
                  <span
                    class="badge bg-label-{{ $order->status === 'completed'
                        ? 'success'
                        : ($order->status === 'paid'
                            ? 'info'
                            : ($order->status === 'pending'
                                ? 'warning'
                                : 'danger')) }}">
                    {{ ucfirst($order->status) }}
                  </span>
                </td>
                <td><span
                    class="badge bg-label-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($order->payment_status) }}</span>
                </td>
                <td>
                  <div class="dropdown">
                    <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                      data-bs-toggle="dropdown">
                      <i class="icon-base ri ri-more-2-fill"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{ route('artisan-order-details', $order->id) }}">
                        <i class="icon-base ri ri-eye-line me-2"></i>View Details
                      </a>
                      @if ($order->status !== 'completed' && $order->status !== 'cancelled')
                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                          data-bs-target="#updateOrderModal" data-order-id="{{ $order->id }}"
                          data-order-status="{{ $order->status }}">
                          <i class="icon-base ri ri-edit-line me-2"></i>Update Status
                        </a>
                      @endif
                      <hr class="dropdown-divider" />
                      <a class="dropdown-item invoice-download" href="javascript:void(0);"
                        data-order-id="{{ $order->id }}">
                        <i class="icon-base ri ri-file-download-line me-2"></i>Invoice
                      </a>
                    </div>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center py-4">
                  <p class="text-muted mb-0"><i class="icon-base ri ri-inbox-line me-2 fs-5"></i>No orders found</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Update Order Status Modal -->
  <div class="modal fade" id="updateOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-edit-line me-2 text-primary"></i>Update Order Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updateOrderForm" method="POST">
          @csrf
          <div class="modal-body">
            <div class="mb-4">
              <label class="form-label fw-medium mb-3">Current Status: <strong id="currentStatus"
                  class="text-warning">Pending</strong></label>
              <div class="alert alert-light" role="alert">
                <small><strong>Order:</strong> #<span id="orderNumber">2026-0000</span></small>
              </div>
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium">New Status *</label>
              <select class="form-select" name="status" required>
                <option value="">Select status</option>
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
              </select>
            </div>
          </div>
          <div class="modal-footer border-top">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <i class="icon-base ri ri-check-line me-2"></i>Update Status
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Filter Orders by Status
      const filterInputs = document.querySelectorAll('input[name="orderFilter"]');
      const tableRows = document.querySelectorAll('table tbody tr[data-status]');

      filterInputs.forEach(input => {
        input.addEventListener('change', function(e) {
          const selectedFilter = e.target.value;

          tableRows.forEach(row => {
            const rowStatus = row.getAttribute('data-status');

            if (selectedFilter === 'all') {
              row.style.display = '';
            } else if (selectedFilter === rowStatus) {
              row.style.display = '';
            } else {
              row.style.display = 'none';
            }
          });

          // Store filter preference in sessionStorage
          sessionStorage.setItem('orderFilter', selectedFilter);
        });
      });

      // Restore filter preference from sessionStorage
      const savedFilter = sessionStorage.getItem('orderFilter') || 'all';
      const filterRadio = document.querySelector(`input[name="orderFilter"][value="${savedFilter}"]`);
      if (filterRadio) {
        filterRadio.click();
      }

      // Update Order Modal - Set dynamic data
      const updateOrderModal = document.getElementById('updateOrderModal');
      updateOrderModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const orderId = button.getAttribute('data-order-id');
        const orderStatus = button.getAttribute('data-order-status');

        // Update modal content
        document.getElementById('orderNumber').textContent = orderId;
        document.getElementById('currentStatus').textContent = orderStatus.charAt(0).toUpperCase() + orderStatus
          .slice(1);

        // Update form action
        const form = document.getElementById('updateOrderForm');
        form.action = `/artisan/order/${orderId}/update-status`;
      });

      // Handle Update Order Form Submission
      const updateOrderForm = document.getElementById('updateOrderForm');
      updateOrderForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const statusSelect = this.querySelector('select[name="status"]');
        const action = this.action;

        // Validate status selection
        if (!statusSelect.value) {
          alert('Please select a status');
          return;
        }

        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="icon-base ri ri-loader-4-line me-2"></i>Updating...';

        // Get CSRF token from meta tag or form input
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ||
          this.querySelector('input[name="_token"]')?.value;

        fetch(action, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': csrfToken,
              'Accept': 'application/json',
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'status=' + encodeURIComponent(statusSelect.value) + '&_token=' + encodeURIComponent(
              csrfToken)
          })
          .then(response => {
            if (!response.ok) throw new Error('HTTP error ' + response.status);
            return response.json();
          })
          .then(data => {
            if (data.success || data.message) {
              // Close modal
              const modal = bootstrap.Modal.getInstance(updateOrderModal);
              modal.hide();

              // Show success message and reload
              setTimeout(() => location.reload(), 500);
            } else {
              throw new Error(data.message || 'Unknown error');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Failed to update order status: ' + error.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
          });
      });

      // Handle Invoice Download
      document.querySelectorAll('.invoice-download').forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          const orderId = this.getAttribute('data-order-id');

          // Redirect to invoice download endpoint
          window.location.href = `/artisan/order/${orderId}/invoice`;
        });
      });

      // Order Trend Chart
      const orderTrendChart = new ApexCharts(document.querySelector("#orderTrendChart"), {
        series: [{
            name: "Completed",
            data: {!! $completedTrendData !!}
          },
          {
            name: "In Progress",
            data: {!! $inProgressTrendData !!}
          },
          {
            name: "Pending",
            data: {!! $pendingTrendData !!}
          }
        ],
        chart: {
          type: "area",
          height: 350,
          sparkline: {
            enabled: false
          }
        },
        colors: ["#28a745", "#667eea", "#ffc107"],
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
          categories: {!! $ordersLabels !!}
        },
        yaxis: {
          title: {
            text: "Orders"
          }
        },
        tooltip: {
          shared: true,
          intersect: false
        }
      });
      orderTrendChart.render();

      // Status Distribution Chart
      const statusDistributionChart = new ApexCharts(document.querySelector("#statusDistributionChart"), {
        series: [{{ $completedOrders }}, {{ $pendingOrders }}, {{ $paidOrders }}],
        chart: {
          type: "donut",
          height: 350
        },
        labels: ["Completed", "Pending", "Paid"],
        colors: ["#28a745", "#ffc107", "#667eea"],
        legend: {
          position: "bottom"
        }
      });
      statusDistributionChart.render();
    });
  </script>
@endsection
