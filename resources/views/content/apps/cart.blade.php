@extends('layouts/layoutMaster')

@section('title', 'Shopping Cart')

@section('content')
  <!-- Flash Messages -->
  @if (session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="row">
    <div class="col-12">
      <h4 class="mb-4">
        <i class="ri-shopping-cart-line me-2"></i>Shopping Cart
      </h4>
    </div>
  </div>

  @forelse($carts as $cart)
    <div class="card mb-4">
      <!-- Cart Header - Artisan Info -->
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
          @if ($cart->artisan->profile_photo_path)
            <img src="{{ asset('storage/' . $cart->artisan->profile_photo_path) }}" alt="{{ $cart->artisan->user->name }}"
              class="rounded-circle" width="48" height="48" style="object-fit: cover;">
          @else
            <div class="avatar avatar-md rounded-circle bg-label-primary">
              <span class="avatar-initial">{{ substr($cart->artisan->user->name, 0, 1) }}</span>
            </div>
          @endif
          <div>
            <h6 class="mb-0">{{ $cart->artisan->user->name }}</h6>
            <small class="text-muted">{{ $cart->artisan->business_name }} | {{ $cart->artisan->city }}</small>
          </div>
        </div>
        <div>
          <form action="{{ route('cart.clear') }}" method="POST" class="d-inline clear-cart-form"
            data-artisan="{{ $cart->artisan->business_name }}">
            @csrf
            @method('DELETE')
            <input type="hidden" name="cart_id" value="{{ $cart->id }}">
            <button type="button" class="btn btn-sm btn-outline-danger clear-cart-btn">
              <i class="ri-delete-bin-line me-1"></i>Clear Cart
            </button>
          </form>
        </div>
      </div>

      <!-- Cart Items -->
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($cart->items as $item)
                @php
                  $itemDetails = $item->item_type === 'service' ? $item->artisanService : $item->artisanGood;
                @endphp
                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-3">
                      @if ($itemDetails && $itemDetails->image_path)
                        <img src="{{ asset('storage/' . $itemDetails->image_path) }}" alt="{{ $item->item_name }}"
                          class="rounded" width="60" height="60" style="object-fit: cover;">
                      @else
                        <div class="bg-label-secondary rounded d-flex align-items-center justify-content-center"
                          style="width: 60px; height: 60px;">
                          <i class="ri-{{ $item->item_type === 'service' ? 'tools' : 'shopping-bag' }}-line fs-4"></i>
                        </div>
                      @endif
                      <div>
                        <h6 class="mb-0">{{ $item->item_name }}</h6>
                        <small class="text-muted">
                          <span class="badge bg-label-{{ $item->item_type === 'service' ? 'info' : 'warning' }}">
                            {{ ucfirst($item->item_type) }}
                          </span>
                          @if ($itemDetails && $itemDetails->category)
                            | {{ $itemDetails->category }}
                          @endif
                        </small>
                      </div>
                    </div>
                  </td>
                  <td class="align-middle">
                    <strong>${{ number_format($item->price, 2) }}</strong>
                  </td>
                  <td class="align-middle">
                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('PUT')
                      <div class="input-group" style="width: 130px;">
                        <button type="button" class="btn btn-outline-secondary btn-sm quantity-decrease"
                          data-item-id="{{ $item->id }}">
                          <i class="ri-subtract-line"></i>
                        </button>
                        <input type="number" name="quantity" class="form-control form-control-sm text-center quantity-input"
                          value="{{ $item->quantity }}" min="1"
                          max="{{ $item->item_type === 'product' && $itemDetails ? $itemDetails->stock_quantity : 99 }}"
                          data-item-id="{{ $item->id }}" style="width: 60px;">
                        <button type="button" class="btn btn-outline-secondary btn-sm quantity-increase"
                          data-item-id="{{ $item->id }}">
                          <i class="ri-add-line"></i>
                        </button>
                      </div>
                    </form>
                    @if ($item->item_type === 'product' && $itemDetails)
                      <small class="text-muted d-block mt-1">Stock: {{ $itemDetails->stock_quantity }}</small>
                    @endif
                  </td>
                  <td class="align-middle">
                    <strong class="text-primary">${{ number_format($item->price * $item->quantity, 2) }}</strong>
                  </td>
                  <td class="align-middle">
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Remove">
                        <i class="ri-close-line"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- Cart Summary -->
        <div class="row mt-4">
          <div class="col-md-6">
            <a href="{{ route('user-browse-artisans') }}" class="btn btn-outline-secondary">
              <i class="ri-arrow-left-line me-1"></i>Continue Shopping
            </a>
          </div>
          <div class="col-md-6">
            <div class="card bg-light border-0">
              <div class="card-body">
                <h6 class="card-title">Order Summary</h6>
                <div class="d-flex justify-content-between mb-2">
                  <span>Subtotal:</span>
                  <strong>${{ number_format($cartTotals[$cart->id]['subtotal'], 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                  <span>Service Fee (10%):</span>
                  <strong>${{ number_format($cartTotals[$cart->id]['service_fee'], 2) }}</strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                  <strong>Total:</strong>
                  <strong class="text-primary fs-5">${{ number_format($cartTotals[$cart->id]['total'], 2) }}</strong>
                </div>

                @if ($cart->artisan->paynow)
                  <a href="{{ route('checkout.show', $cart->id) }}" class="btn btn-primary w-100">
                    <i class="ri-secure-payment-line me-2"></i>Proceed to Checkout
                  </a>
                @else
                  <div class="alert alert-warning mb-0 small">
                    <i class="ri-error-warning-line me-1"></i>
                    This artisan hasn't set up payment processing yet. Please contact them directly.
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @empty
    <!-- Empty Cart -->
    <div class="card">
      <div class="card-body text-center py-5">
        <i class="ri-shopping-cart-line text-muted mb-3" style="font-size: 5rem;"></i>
        <h4 class="mb-2">Your cart is empty</h4>
        <p class="text-muted mb-4">Browse artisans and add services or products to your cart.</p>
        <a href="{{ route('user-browse-artisans') }}" class="btn btn-primary">
          <i class="ri-search-line me-2"></i>Browse Artisans
        </a>
      </div>
    </div>
  @endforelse
@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Quantity increase/decrease
      document.querySelectorAll('.quantity-decrease, .quantity-increase').forEach(function(btn) {
        btn.addEventListener('click', function() {
          const itemId = this.getAttribute('data-item-id');
          const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
          const currentValue = parseInt(input.value);
          const min = parseInt(input.getAttribute('min'));
          const max = parseInt(input.getAttribute('max'));

          if (this.classList.contains('quantity-decrease')) {
            if (currentValue > min) {
              input.value = currentValue - 1;
              input.closest('form').submit();
            }
          } else {
            if (currentValue < max) {
              input.value = currentValue + 1;
              input.closest('form').submit();
            }
          }
        });
      });

      // Direct input change
      document.querySelectorAll('.quantity-input').forEach(function(input) {
        input.addEventListener('change', function() {
          const min = parseInt(this.getAttribute('min'));
          const max = parseInt(this.getAttribute('max'));
          let value = parseInt(this.value);

          if (value < min) value = min;
          if (value > max) value = max;

          this.value = value;
          this.closest('form').submit();
        });
      });

      // Clear cart confirmation
      document.querySelectorAll('.clear-cart-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
          e.preventDefault();
          const form = this.closest('.clear-cart-form');
          const artisan = form.getAttribute('data-artisan');

          Swal.fire({
            title: 'Clear Cart?',
            text: 'Are you sure you want to remove all items from ' + artisan + '\'s cart?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Clear Cart',
            confirmButtonColor: '#d33',
            cancelButtonText: 'Cancel'
          }).then(function(result) {
            if (result.isConfirmed) {
              form.submit();
            }
          });
        });
      });
    });
  </script>
@endsection
