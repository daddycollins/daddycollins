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
              <h3 class="mb-2">ZWL 234,890</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i class="icon-base ri ri-arrow-up-s-line me-1"></i>+15%
                  YTD</span></p>
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
              <h3 class="mb-2">ZWL 45,230</h3>
              <p class="mb-0"><span class="badge bg-label-info"><i class="icon-base ri ri-bank-card-line me-1"></i>Ready
                  to withdraw</span></p>
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
              <h3 class="mb-2">ZWL 8,450</h3>
              <p class="mb-0"><span class="badge bg-label-warning"><i
                    class="icon-base ri ri-time-line me-1"></i>Processing</span></p>
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
              <h3 class="mb-2">15 Jan 2026</h3>
              <p class="mb-0"><span class="badge bg-label-primary">ZWL 12,000</span></p>
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
          <h5 class="card-title m-0"><i class="icon-base ri ri-line-chart-line me-2 text-primary"></i>Earnings Trend</h5>
        </div>
        <div class="card-body">
          <div id="earningsTrendChart" style="height: 350px;"></div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0"><i class="icon-base ri ri-pie-chart-line me-2 text-success"></i>Payment Methods</h5>
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
          <h5 class="card-title m-0"><i class="icon-base ri ri-bank-card-line me-2 text-primary"></i>Payment Methods</h5>
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
              <p class="mb-2"><small class="text-muted">ID:</small> <strong>8988...</strong></p>
              <p class="mb-3"><small class="text-muted">Account Name:</small> <strong>John Doe</strong></p>
              <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                  data-bs-target="#editPaynowModal">
                  <i class="icon-base ri ri-edit-line me-1"></i>Edit
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger">
                  <i class="icon-base ri ri-delete-bin-line me-1"></i>Remove
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Bank Account -->
        <div class="col-md-6">
          <div class="border rounded-3 p-4 bg-light">
            <div class="d-flex justify-content-between align-items-start mb-3">
              <div>
                <h6 class="mb-1 fw-medium"><i class="icon-base ri ri-bank-line text-info me-2"></i>Bank Transfer</h6>
                <p class="text-muted small mb-2">Secondary Method</p>
              </div>
              <span class="badge bg-label-info">Verified</span>
            </div>
            <div class="ps-4">
              <p class="mb-2"><small class="text-muted">Bank:</small> <strong>ZB Bank</strong></p>
              <p class="mb-3"><small class="text-muted">Account:</small> <strong>****2847</strong></p>
              <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-primary">
                  <i class="icon-base ri ri-edit-line me-1"></i>Edit
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger">
                  <i class="icon-base ri ri-delete-bin-line me-1"></i>Remove
                </button>
              </div>
            </div>
          </div>
        </div>
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
            <tr>
              <td><strong>#TXN-2026-5234</strong></td>
              <td>#ORD-2026-1234</td>
              <td><span class="badge bg-label-primary">Carpentry Work</span></td>
              <td>Sarah Mwangi</td>
              <td><strong>ZWL 3,500</strong></td>
              <td><span class="badge bg-label-success">Completed</span></td>
              <td>22 Jan 2026</td>
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

            <tr>
              <td><strong>#TXN-2026-5235</strong></td>
              <td>#ORD-2026-1235</td>
              <td><span class="badge bg-label-warning">Beadwork Design</span></td>
              <td>James Musarurwa</td>
              <td><strong>ZWL 2,800</strong></td>
              <td><span class="badge bg-label-success">Completed</span></td>
              <td>21 Jan 2026</td>
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

            <tr>
              <td><strong>#TXN-2026-5236</strong></td>
              <td>#ORD-2026-1236</td>
              <td><span class="badge bg-label-success">Painting Service</span></td>
              <td>Zinhle Dube</td>
              <td><strong>ZWL 4,200</strong></td>
              <td><span class="badge bg-label-info">In Review</span></td>
              <td>20 Jan 2026</td>
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

            <tr>
              <td><strong>#TXN-2026-5237</strong></td>
              <td>#ORD-2026-1237</td>
              <td><span class="badge bg-label-info">Custom Furniture</span></td>
              <td>Lindiwe Khumalo</td>
              <td><strong>ZWL 5,600</strong></td>
              <td><span class="badge bg-label-success">Completed</span></td>
              <td>19 Jan 2026</td>
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
          <form id="addPaynowForm">
            <div class="mb-4">
              <label class="form-label fw-medium">Account Holder Name *</label>
              <input type="text" class="form-control" placeholder="Enter your full name" required />
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium">Paynow ID *</label>
              <input type="text" class="form-control" placeholder="Enter your Paynow ID (e.g., +263..." required />
              <small class="text-muted">Your Paynow ID is used for receiving payments</small>
            </div>
            <div class="mb-0">
              <label class="form-label fw-medium">Paynow Key *</label>
              <input type="password" class="form-control" placeholder="Enter your Paynow Key" required />
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
          <form id="editPaynowForm">
            <div class="mb-4">
              <label class="form-label fw-medium">Account Holder Name *</label>
              <input type="text" class="form-control" value="John Doe" required />
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium">Paynow ID *</label>
              <input type="text" class="form-control" value="+263789998988" required />
            </div>
            <div class="mb-0">
              <label class="form-label fw-medium">Paynow Key *</label>
              <input type="password" class="form-control" value="••••••••••••••••" required />
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
          <form id="payoutForm">
            <div class="alert alert-info" role="alert">
              <small><strong>Available Balance:</strong> ZWL 45,230</small>
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium">Amount to Withdraw *</label>
              <div class="input-group">
                <span class="input-group-text">ZWL</span>
                <input type="number" class="form-control" placeholder="Enter amount" min="1000" max="45230"
                  required />
              </div>
              <small class="text-muted">Minimum: ZWL 1,000</small>
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium">Payment Method *</label>
              <select class="form-select" required>
                <option value="">Select payment method</option>
                <option value="paynow">Paynow</option>
                <option value="bank">Bank Transfer</option>
              </select>
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium">Processing Fee</label>
              <p class="mb-0 text-muted"><strong>ZWL 45</strong> (1% fee for Paynow)</p>
            </div>
            <div class="mb-0">
              <label class="form-label fw-medium">Notes (Optional)</label>
              <textarea class="form-control" rows="2" placeholder="Add any notes about this payout request..."></textarea>
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
    // Earnings Trend Chart
    const earningsTrendChart = new ApexCharts(document.querySelector("#earningsTrendChart"), {
      series: [{
        name: "Earnings",
        data: [18500, 22300, 19800, 28500, 35200, 42100, 38900]
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
      series: [65, 25, 10],
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
