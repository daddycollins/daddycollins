@extends('layouts/layoutMaster')

@section('title', 'Order Details - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/tagify/tagify.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/cleave-zen/cleave-zen.js', 'resources/assets/vendor/libs/tagify/tagify.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/apex-charts/apexcharts.js'])
@endsection

@section('page-script')
  @vite(['resources/assets/js/app-ecommerce-order-details.js', 'resources/assets/js/modal-add-new-address.js', 'resources/assets/js/modal-edit-user.js'])
@endsection

@section('content')
  <!-- Order Header -->
  <div class="row mb-6">
    <div class="col-12">
      <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
          <div class="d-flex align-items-center mb-2">
            <h4 class="mb-0 me-3">Order #ORD001</h4>
            <span class="badge bg-label-success rounded-pill"><i
                class="icon-base ri ri-check-line me-1"></i>Completed</span>
            <span class="badge bg-label-info rounded-pill ms-2"><i
                class="icon-base ri ri-bank-card-line me-1"></i>Paid</span>
          </div>
          <p class="text-muted mb-0">Placed on Jan 20, 2026 at 3:45 PM</p>
        </div>
        <div class="d-flex gap-2">
          <button class="btn btn-outline-primary">
            <i class="icon-base ri ri-download-line me-2"></i>Download Invoice
          </button>
          <button class="btn btn-outline-secondary">
            <i class="icon-base ri ri-printer-line me-2"></i>Print
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-6">
    <!-- Main Content -->
    <div class="col-12 col-lg-8">
      <!-- Order Items Card -->
      <div class="card mb-6">
        <div class="card-header">
          <h5 class="card-title mb-0">Order Items</h5>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead>
              <tr>
                <th>Service/Good</th>
                <th>Artisan</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <div>
                    <h6 class="mb-1">Plumbing Repair</h6>
                    <p class="text-muted small mb-0">Pipe replacement & fixture installation</p>
                  </div>
                </td>
                <td>John Mbewe</td>
                <td>$45/hr</td>
                <td>10 hrs</td>
                <td><strong>$450</strong></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-body bg-light border-top">
          <div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-4">
              <div class="d-flex justify-content-between mb-3">
                <span>Subtotal:</span>
                <strong>$450.00</strong>
              </div>
              <div class="d-flex justify-content-between mb-3">
                <span>Service Fee:</span>
                <strong>$22.50</strong>
              </div>
              <div class="d-flex justify-content-between mb-3">
                <span>Tax (5%):</span>
                <strong>$23.63</strong>
              </div>
              <hr class="my-3" />
              <div class="d-flex justify-content-between">
                <h6 class="mb-0">Total Amount:</h6>
                <h6 class="mb-0 text-primary">$496.13</h6>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Order Timeline -->
      <div class="card mb-6">
        <div class="card-header">
          <h5 class="card-title mb-0">Order Progress</h5>
        </div>
        <div class="card-body">
          <ul class="timeline pb-0 mb-0">
            <li class="timeline-item timeline-item-transparent border-primary">
              <span class="timeline-point timeline-point-primary"></span>
              <div class="timeline-event">
                <div class="timeline-header mb-2">
                  <h6 class="mb-0">Order Confirmed</h6>
                  <small class="text-body-secondary">Jan 20, 2026 - 3:45 PM</small>
                </div>
                <p class="mt-1 mb-0">Your order has been successfully placed and confirmed</p>
              </div>
            </li>
            <li class="timeline-item timeline-item-transparent border-primary">
              <span class="timeline-point timeline-point-primary"></span>
              <div class="timeline-event">
                <div class="timeline-header mb-2">
                  <h6 class="mb-0">Payment Received</h6>
                  <small class="text-body-secondary">Jan 20, 2026 - 4:10 PM</small>
                </div>
                <p class="mt-1 mb-0">Payment of $496.13 has been received and processed</p>
              </div>
            </li>
            <li class="timeline-item timeline-item-transparent border-primary">
              <span class="timeline-point timeline-point-primary"></span>
              <div class="timeline-event">
                <div class="timeline-header mb-2">
                  <h6 class="mb-0">Work Started</h6>
                  <small class="text-body-secondary">Jan 20, 2026 - 5:00 PM</small>
                </div>
                <p class="mt-1 mb-0">Artisan has started working on your project</p>
              </div>
            </li>
            <li class="timeline-item timeline-item-transparent border-primary">
              <span class="timeline-point timeline-point-primary"></span>
              <div class="timeline-event">
                <div class="timeline-header mb-2">
                  <h6 class="mb-0">Work Completed</h6>
                  <small class="text-body-secondary">Jan 20, 2026 - 8:30 PM</small>
                </div>
                <p class="mt-1 mb-0">All work has been completed successfully</p>
              </div>
            </li>
            <li class="timeline-item timeline-item-transparent border-primary pb-0">
              <span class="timeline-point timeline-point-primary"></span>
              <div class="timeline-event pb-0">
                <div class="timeline-header mb-2">
                  <h6 class="mb-0">Order Delivered</h6>
                  <small class="text-body-secondary">Jan 20, 2026 - 9:00 PM</small>
                </div>
                <p class="mt-1 mb-0">Order has been marked as completed</p>
              </div>
            </li>
          </ul>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Actions</h5>
        </div>
        <div class="card-body">
          <div class="d-flex flex-wrap gap-2">
            <button class="btn btn-primary">
              <i class="icon-base ri ri-chat-3-line me-2"></i>Message Artisan
            </button>
            <button class="btn btn-outline-primary">
              <i class="icon-base ri ri-phone-line me-2"></i>Call Artisan
            </button>
            <button class="btn btn-outline-secondary">
              <i class="icon-base ri ri-star-line me-2"></i>Leave Review
            </button>
            <button class="btn btn-outline-danger">
              <i class="icon-base ri ri-delete-bin-line me-2"></i>Cancel Order
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="col-12 col-lg-4">
      <!-- Artisan Card -->
      <div class="card mb-6">
        <div class="card-header">
          <h5 class="card-title mb-0">Artisan Information</h5>
        </div>
        <div class="card-body">
          <div class="d-flex align-items-center mb-4">
            <div class="avatar avatar-lg me-3">
              <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Artisan" class="rounded-circle" />
            </div>
            <div>
              <h6 class="mb-0">John Mbewe</h6>
              <p class="text-muted small mb-0">Plumbing & Repairs</p>
            </div>
          </div>

          <div class="mb-4">
            <div class="d-flex align-items-center gap-2 mb-2">
              <div class="text-warning">
                <i class="icon-base ri ri-star-fill icon-16px"></i>
                <i class="icon-base ri ri-star-fill icon-16px"></i>
                <i class="icon-base ri ri-star-fill icon-16px"></i>
                <i class="icon-base ri ri-star-fill icon-16px"></i>
                <i class="icon-base ri ri-star-half-fill icon-16px"></i>
              </div>
              <small class="text-muted">(127 reviews)</small>
            </div>
            <p class="text-muted small mb-0">4.5/5 Average Rating</p>
          </div>

          <div class="row g-3 mb-4">
            <div class="col-6">
              <div class="text-center p-2 bg-light rounded">
                <small class="text-muted d-block mb-1">Experience</small>
                <span class="small fw-medium">8 Years</span>
              </div>
            </div>
            <div class="col-6">
              <div class="text-center p-2 bg-light rounded">
                <small class="text-muted d-block mb-1">Jobs Done</small>
                <span class="small fw-medium">245</span>
              </div>
            </div>
          </div>

          <div class="d-flex gap-2">
            <button class="btn btn-outline-primary w-100 btn-sm">
              <i class="icon-base ri ri-phone-line me-1"></i>Call
            </button>
            <button class="btn btn-primary w-100 btn-sm">
              <i class="icon-base ri ri-chat-3-line me-1"></i>Chat
            </button>
          </div>
        </div>
        </card>

        <!-- Payment Status Card -->
        <div class="card mb-6">
          <div class="card-header">
            <h5 class="card-title mb-0">Payment Status</h5>
          </div>
          <div class="card-body">
            <div class="mb-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span>Status</span>
                <span class="badge bg-label-success rounded-pill">Paid</span>
              </div>
              <p class="text-muted small mb-0">Payment received on Jan 20, 2026</p>
            </div>

            <div class="mb-4">
              <small class="text-muted d-block mb-2">Payment Method</small>
              <div class="d-flex align-items-center">
                <i class="icon-base ri ri-bank-card-line me-2 text-primary"></i>
                <span>Mastercard ****4291</span>
              </div>
            </div>

            <div>
              <small class="text-muted d-block mb-2">Amount Paid</small>
              <h6 class="mb-0 text-success">$496.13</h6>
            </div>
          </div>
        </div>

        <!-- Delivery Address Card -->
        <div class="card mb-6">
          <div class="card-header d-flex justify-content-between">
            <h5 class="card-title mb-0">Delivery Address</h5>
            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editAddress">Edit</a>
          </div>
          <div class="card-body">
            <p class="mb-0">
              <strong>John Doe</strong><br />
              123 Main Street<br />
              Harare, Zimbabwe 00000<br />
              +263 712 345 678
            </p>
          </div>
        </div>

        <!-- Stats Card -->
        <div class="card">
          <div class="card-body">
            <div class="row g-3 text-center">
              <div class="col-6">
                <div>
                  <h5 class="mb-1">1</h5>
                  <p class="text-muted small mb-0">Items</p>
                </div>
              </div>
              <div class="col-6">
                <div>
                  <h5 class="mb-1">10 hrs</h5>
                  <p class="text-muted small mb-0">Duration</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endsection
  <div class="order-calculations">
    <div class="d-flex justify-content-start gap-4">
      <span class="w-px-100 text-heading">Subtotal:</span>
      <h6 class="mb-0">$5000.25</h6>
    </div>
    <div class="d-flex justify-content-start gap-4">
      <span class="w-px-100 text-heading">Discount:</span>
      <h6 class="mb-0">$00.00</h6>
    </div>
    <div class="d-flex justify-content-start gap-4">
      <span class="w-px-100 text-heading">Tax:</span>
      <h6 class="mb-0">$100.00</h6>
    </div>
    <div class="d-flex justify-content-start gap-4">
      <h6 class="w-px-100 mb-0">Total:</h6>
      <h6 class="mb-0">$5100.25</h6>
    </div>
  </div>
</div>
</div>
</div>
<div class="card mb-6">
  <div class="card-header">
    <h5 class="card-title m-0">Shipping activity</h5>
  </div>
  <div class="card-body mt-3">
    <ul class="timeline pb-0 mb-0">
      <li class="timeline-item timeline-item-transparent border-primary">
        <span class="timeline-point timeline-point-primary"></span>
        <div class="timeline-event">
          <div class="timeline-header mb-2">
            <h6 class="mb-0">Order was placed (Order ID: #32543)</h6>
            <small class="text-body-secondary">Tuesday 11:29 AM</small>
          </div>
          <p class="mt-1 mb-2">Your order has been placed successfully</p>
        </div>
      </li>
      <li class="timeline-item timeline-item-transparent border-primary">
        <span class="timeline-point timeline-point-primary"></span>
        <div class="timeline-event">
          <div class="timeline-header mb-2">
            <h6 class="mb-0">Pick-up</h6>
            <small class="text-body-secondary">Wednesday 11:29 AM</small>
          </div>
          <p class="mt-1 mb-2">Pick-up scheduled with courier</p>
        </div>
      </li>
      <li class="timeline-item timeline-item-transparent border-primary">
        <span class="timeline-point timeline-point-primary"></span>
        <div class="timeline-event">
          <div class="timeline-header mb-2">
            <h6 class="mb-0">Dispatched</h6>
            <small class="text-body-secondary">Thursday 11:29 AM</small>
          </div>
          <p class="mt-1 mb-2">Item has been picked up by courier</p>
        </div>
      </li>
      <li class="timeline-item timeline-item-transparent border-primary">
        <span class="timeline-point timeline-point-primary"></span>
        <div class="timeline-event">
          <div class="timeline-header mb-2">
            <h6 class="mb-0">Package arrived</h6>
            <small class="text-body-secondary">Saturday 15:20 AM</small>
          </div>
          <p class="mt-1 mb-2">Package arrived at an Amazon facility, NY</p>
        </div>
      </li>
      <li class="timeline-item timeline-item-transparent border-dashed">
        <span class="timeline-point timeline-point-primary"></span>
        <div class="timeline-event">
          <div class="timeline-header mb-2">
            <h6 class="mb-0">Dispatched for delivery</h6>
            <small class="text-body-secondary">Today 14:12 PM</small>
          </div>
          <p class="mt-1 mb-2">Package has left an Amazon facility, NY</p>
        </div>
      </li>
      <li class="timeline-item timeline-item-transparent border-transparent pb-0">
        <span class="timeline-point timeline-point-primary"></span>
        <div class="timeline-event pb-0">
          <div class="timeline-header mb-2">
            <h6 class="mb-0">Delivery</h6>
          </div>
          <p class="mt-1 mb-2">Package will be delivered by tomorrow</p>
        </div>
      </li>
    </ul>
  </div>
</div>
</div>
<div class="col-12 col-lg-4">
  <div class="card mb-6">
    <div class="card-body">
      <h5 class="card-title mb-6">Customer details</h5>
      <div class="d-flex justify-content-start align-items-center mb-6">
        <div class="avatar me-3">
          <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle" />
        </div>
        <div class="d-flex flex-column">
          <a href="{{ url('app/user/view/account') }}">
            <h6 class="mb-0">Shamus Tuttle</h6>
          </a>
          <span>Customer ID: #58909</span>
        </div>
      </div>
      <div class="d-flex justify-content-start align-items-center mb-6">
        <span class="avatar rounded-circle bg-label-success me-3 d-flex align-items-center justify-content-center"><i
            class="icon-base ri ri-shopping-cart-line icon-24px"></i></span>
        <h6 class="text-nowrap mb-0">12 Orders</h6>
      </div>
      <div class="d-flex justify-content-between">
        <h6 class="mb-1">Contact info</h6>
        <h6 class="mb-1"><a href=" javascript:;" data-bs-toggle="modal" data-bs-target="#editUser">Edit</a></h6>
      </div>
      <p class="mb-1">Email: Shamus889@yahoo.com</p>
      <p class="mb-0">Mobile: +1 (609) 972-22-22</p>
    </div>
  </div>

  <div class="card mb-6">
    <div class="card-header d-flex justify-content-between">
      <h5 class="card-title mb-1">Shipping address</h5>
      <h6 class="m-0"><a href=" javascript:void(0)" data-bs-toggle="modal"
          data-bs-target="#addNewAddress">Edit</a>
      </h6>
    </div>
    <div class="card-body">
      <p class="mb-0">45 Roker Terrace <br />Latheronwheel <br />KW5 8NW,London <br />UK</p>
    </div>
  </div>
  <div class="card mb-6">
    <div class="card-header d-flex justify-content-between pb-0">
      <h5 class="card-title mb-1">Billing address</h5>
      <h6 class="m-0"><a href=" javascript:void(0)" data-bs-toggle="modal"
          data-bs-target="#addNewAddress">Edit</a>
      </h6>
    </div>
    <div class="card-body">
      <p class="mb-6">45 Roker Terrace <br />Latheronwheel <br />KW5 8NW,London <br />UK</p>
      <h5 class="mb-1">Mastercard</h5>
      <p class="mb-0">Card Number: ******4291</p>
    </div>
  </div>
</div>
</div>

<!-- Modals -->
@include('_partials/_modals/modal-edit-user')
@include('_partials/_modals/modal-add-new-address')


@endsection
