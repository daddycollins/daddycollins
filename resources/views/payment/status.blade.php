@extends('layouts/layoutMaster')

@section('title', 'Payment Status - Order #' . $order->id)

@section('content')
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
              <i class="ri-bank-card-line me-2"></i>Payment Status
            </h5>
          </div>
          <div class="card-body">

            <!-- Status Indicator -->
            <div class="text-center mb-4 py-4">
              <div id="status-spinner" class="spinner-wrapper">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Processing...</span>
                </div>
                <p class="text-muted mt-3">Checking payment status...</p>
                <small class="text-muted d-block">This typically takes 5-10 seconds</small>
              </div>

              <div id="status-success" style="display: none;">
                <div style="font-size: 3rem; color: #28a745; margin-bottom: 1rem;">
                  <i class="ri-check-double-line"></i>
                </div>
                <h4 class="text-success mt-2">Payment Successful!</h4>
                <p class="text-muted">Your payment has been processed successfully.</p>
              </div>

              <div id="status-error" style="display: none;">
                <div style="font-size: 3rem; color: #dc3545; margin-bottom: 1rem;">
                  <i class="ri-close-circle-line"></i>
                </div>
                <h4 class="text-danger mt-2">Payment Failed</h4>
                <p class="text-muted" id="error-message">Payment could not be processed</p>
              </div>
            </div>

            <!-- Order Details -->
            <div class="card bg-light mb-4">
              <div class="card-body">
                <h6 class="card-title mb-3">Order Details</h6>
                <div class="row">
                  <div class="col-md-6">
                    <p class="mb-1"><strong>Order ID:</strong></p>
                    <p class="text-muted mb-3">#{{ $order->id }}</p>

                    <p class="mb-1"><strong>Reference:</strong></p>
                    <p class="text-muted font-monospace" style="font-size: 0.85rem;">
                      <span id="reference-text">{{ $order->paynow_reference ?? 'Pending...' }}</span>
                    </p>
                  </div>
                  <div class="col-md-6 text-end">
                    <p class="mb-1"><strong>Total Amount:</strong></p>
                    <p class="text-primary mb-3" style="font-size: 1.3rem;">
                      <strong>${{ number_format($order->total_amount, 2) }}</strong>
                    </p>

                    <p class="mb-1"><strong>Status:</strong></p>
                    <span class="badge bg-warning" id="status-badge">PENDING</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Items Ordered -->
            <div class="card mb-4">
              <div class="card-body">
                <h6 class="card-title mb-3">Items in Order</h6>
                @foreach ($order->items as $item)
                  <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <div>
                      <p class="mb-1">
                        <strong>
                          {{ $item->item_type === 'service' ? $item->artisanService->service_name : $item->artisanGood->product_name }}
                        </strong>
                      </p>
                      <small class="text-muted">Qty: {{ $item->quantity }}</small>
                    </div>
                    <h6 class="mb-0">${{ number_format($item->price * $item->quantity, 2) }}</h6>
                  </div>
                @endforeach
              </div>
            </div>

            <!-- Auto-Redirect Timer -->
            <div id="redirect-timer" style="display: none;" class="alert alert-success" role="alert">
              <i class="ri-redirect-2-line me-2"></i>
              <span>Redirecting in <strong id="timer-count">5</strong> seconds...</span>
            </div>

            <!-- Manual Actions -->
            <div class="d-grid gap-2" id="manual-actions">
              <button type="button" class="btn btn-outline-primary" onclick="checkStatus()">
                <i class="ri-refresh-line me-2"></i>Check Status Again
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const orderId = {{ $order->id }};
      const statusSpinner = document.getElementById('status-spinner');
      const statusSuccess = document.getElementById('status-success');
      const statusError = document.getElementById('status-error');
      const redirectTimer = document.getElementById('redirect-timer');
      const timerCount = document.getElementById('timer-count');
      const statusBadge = document.getElementById('status-badge');
      const manualActions = document.getElementById('manual-actions');
      let pollCount = 0;
      const maxPolls = 20; // Stop after 60 seconds (20 polls × 3 seconds)

      function checkStatus() {
        fetch(`/payment/api/status/{{ $order->id }}`)
          .then(response => response.json())
          .then(data => {
            pollCount++;

            if (data.status === 'paid' || data.paid) {
              statusSpinner.style.display = 'none';
              statusSuccess.style.display = 'block';
              statusBadge.textContent = 'PAID';
              statusBadge.className = 'badge bg-success';
              redirectTimer.style.display = 'block';
              manualActions.style.display = 'none';

              let count = 5;
              const interval = setInterval(() => {
                count--;
                timerCount.textContent = count;
                if (count === 0) {
                  clearInterval(interval);
                  window.location.href = data.redirect || `/payment/{{ $order->id }}/success`;
                }
              }, 1000);
            } else if (data.status === 'failed' || !data.success) {
              statusSpinner.style.display = 'none';
              statusError.style.display = 'block';
              statusBadge.textContent = 'FAILED';
              statusBadge.className = 'badge bg-danger';
              document.getElementById('error-message').textContent = data.message ||
                'Payment could not be processed. Please try again.';
              manualActions.innerHTML =
                '<a href="javascript:history.back()" class="btn btn-outline-danger"><i class="ri-arrow-left-line me-2"></i>Go Back</a>';
            } else if (pollCount < maxPolls) {
              // Continue polling
              setTimeout(checkStatus, 3000);
            } else {
              // Timeout - stop polling
              statusSpinner.style.display = 'none';
              statusError.style.display = 'block';
              statusBadge.textContent = 'TIMEOUT';
              statusBadge.className = 'badge bg-warning';
              document.getElementById('error-message').textContent =
                'Payment verification timed out. Please check your PayNow account.';
            }
          })
          .catch(error => {
            console.error('Error:', error);
            if (pollCount < maxPolls) {
              setTimeout(checkStatus, 3000);
            } else {
              statusSpinner.style.display = 'none';
              statusError.style.display = 'block';
              document.getElementById('error-message').textContent =
                'Network error. Please try again or contact support.';
            }
          });
      }

      // Check immediately
      checkStatus();
    });
  </script>

  <style>
    .spinner-wrapper {
      padding: 2rem 0;
    }

    .font-monospace {
      font-family: 'Courier New', monospace;
    }
  </style>
@endsection
