@extends('layouts/layoutMaster')

@section('title', 'Artisan Dashboard - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss'])
@endsection

@section('page-style')
  @vite(['resources/assets/vendor/scss/pages/page-profile.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('content')
  <!-- Flash Messages Alert Component -->
  <x-alert />

  <!-- Header -->
  <div class="row mb-6">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h4 class="mb-1">Welcome Back, {{ $user->name }}!</h4>
          <p class="text-muted mb-0">Here's your performance overview</p>
        </div>
        <div class="d-flex gap-2">
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
            <i class="icon-base ri ri-add-line me-1"></i>Add Service
          </button>
          <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="icon-base ri ri-add-line me-1"></i>Add Product
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Verification & Status Section -->
  <div class="row g-6 mb-6">
    <!-- Verification Status -->
    <div class="col-lg-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
              <h6 class="text-muted mb-1">Verification Status</h6>
              <h4 class="mb-0">
                <span class="badge bg-{{ $verificationBadgeColor }}">
                  <i
                    class="icon-base ri ri-{{ $verificationStatus === 'Verified' ? 'check-double-line' : 'time-line' }} me-1"></i>{{ $verificationStatus }}
                </span>
              </h4>
            </div>
            <div class="avatar bg-label-success">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-verified-badge-line icon-24px"></i>
              </div>
            </div>
          </div>
          <small class="text-muted">All requirements completed. Your profile is trusted.</small>
        </div>
      </div>
    </div>

    <!-- Average Rating -->
    <div class="col-lg-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
              <h6 class="text-muted mb-1">Average Rating</h6>
              <h4 class="mb-0">{{ $averageRating }}/5</h4>
            </div>
            <div class="avatar bg-label-warning">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-star-fill icon-24px"></i>
              </div>
            </div>
          </div>
          <div class="text-warning small">
            @for ($i = 1; $i <= 5; $i++)
              @if ($i <= floor($averageRating))
                <i class="icon-base ri ri-star-fill"></i>
              @elseif ($i - $averageRating < 1)
                <i class="icon-base ri ri-star-half-fill"></i>
              @else
                <i class="icon-base ri ri-star-line"></i>
              @endif
            @endfor
            <span class="text-muted">({{ $reviewCount }} reviews)</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Orders -->
    <div class="col-lg-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
              <h6 class="text-muted mb-1">Total Orders</h6>
              <h4 class="mb-0">{{ $totalOrders }}</h4>
            </div>
            <div class="avatar bg-label-primary">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-shopping-bag-line icon-24px"></i>
              </div>
            </div>
          </div>
          <small class="text-{{ $ordersGrowth >= 0 ? 'success' : 'danger' }}"><i
              class="icon-base ri ri-arrow-{{ $ordersGrowth >= 0 ? 'up' : 'down' }}-s-line me-1"></i>{{ $ordersGrowth >= 0 ? '+' : '' }}{{ $ordersGrowth }}%
            this month</small>
        </div>
      </div>
    </div>

    <!-- Total Earnings -->
    <div class="col-lg-3 col-sm-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
              <h6 class="text-muted mb-1">Total Earnings</h6>
              <h4 class="mb-0">ZWL {{ number_format($totalEarnings, 2) }}</h4>
            </div>
            <div class="avatar bg-label-success">
              <div class="avatar-initial rounded">
                <i class="icon-base ri ri-money-dollar-circle-line icon-24px"></i>
              </div>
            </div>
          </div>
          <small class="text-{{ $earningsGrowth >= 0 ? 'success' : 'danger' }}"><i
              class="icon-base ri ri-arrow-{{ $earningsGrowth >= 0 ? 'up' : 'down' }}-s-line me-1"></i>{{ $earningsGrowth >= 0 ? '+' : '' }}{{ $earningsGrowth }}%
            vs last month</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Performance Charts -->
  <div class="row g-6 mb-6">
    <!-- Orders Trend -->
    <div class="col-lg-8">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">Orders Trend</h5>
          <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-secondary active">Weekly</button>
            <button type="button" class="btn btn-outline-secondary">Monthly</button>
          </div>
        </div>
        <div class="card-body">
          <div id="ordersTrendChart" style="height: 300px;"></div>
        </div>
      </div>
    </div>

    <!-- Completion Rate -->
    <div class="col-lg-4">
      <div class="card h-100">
        <div class="card-header">
          <h5 class="card-title mb-0">Order Completion Rate</h5>
        </div>
        <div class="card-body">
          <div class="text-center mb-4">
            <div id="completionRateChart" style="height: 200px;"></div>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="small">Completed</span>
            <span class="badge bg-success">{{ $completedOrders }}</span>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="small">In Progress</span>
            <span class="badge bg-info">{{ $paidOrders }}</span>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="small">Pending</span>
            <span class="badge bg-warning">{{ $pendingOrders }}</span>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <span class="small">Cancelled</span>
            <span class="badge bg-danger">{{ $cancelledOrders }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Services & Recent Orders -->
  <div class="row g-6">
    <!-- Active Services -->
    <div class="col-lg-6">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">My Services</h5>
          <a href="{{ route('artisan-my-services') }}" class="btn btn-sm btn-primary">View All</a>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>Service Name</th>
                <th>Hourly Rate</th>
                <th>Orders</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($artisanServices as $service)
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="avatar avatar-sm me-2">
                        <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Service" class="rounded" />
                      </div>
                      <span>{{ $service->service_name }}</span>
                    </div>
                  </td>
                  <td>ZWL {{ number_format($service->price_estimate, 2) }}</td>
                  <td><span class="badge bg-label-primary">{{ $service->orders_count ?? 0 }}</span></td>
                  <td><span class="badge bg-label-success">Active</span></td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center text-muted py-4">No services found. <a
                      href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addServiceModal">Add one
                      now</a></td>
                </tr>
              @endforelse
            </tbody>

          </table>
        </div>
      </div>
    </div>

    <!-- Recent Orders -->
    <div class="col-lg-6">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">Recent Orders</h5>
          <a href="{{ route('artisan-my-orders') }}" class="btn btn-sm btn-primary">View All</a>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>Order ID</th>
                <th>Client</th>
                <th>Amount</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentOrders as $order)
                <tr>
                  <td><span class="badge bg-label-primary">#ORD-{{ $order->id }}</span></td>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Client" class="rounded-circle me-2"
                        width="32" height="32" />
                      <span>{{ $order->client->name ?? 'Unknown' }}</span>
                    </div>
                  </td>
                  <td>ZWL {{ number_format($order->total_amount, 2) }}</td>
                  <td>
                    <span
                      class="badge bg-label-{{ $order->status === 'completed' ? 'success' : ($order->status === 'paid' ? 'info' : ($order->status === 'pending' ? 'warning' : 'danger')) }}">
                      {{ ucfirst($order->status) }}
                    </span>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center text-muted py-4">No orders found yet</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Service Modal -->
  <div class="modal fade" id="addServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New Service</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('artisan-service-store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="row g-4">
              <!-- Service Name -->
              <div class="col-12">
                <label class="form-label">Service Name</label>
                <input type="text" name="service_name" value="{{ old('service_name') }}"
                  class="form-control @error('service_name') is-invalid @enderror"
                  placeholder="e.g., Pipe Installation & Repair" required />
                @error('service_name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Category -->
              <div class="col-md-6">
                <label class="form-label">Category</label>
                <select name="category" class="form-select @error('category') is-invalid @enderror">
                  <option value="">Select Category</option>
                  <option value="plumbing" {{ old('category') == 'plumbing' ? 'selected' : '' }}>Plumbing</option>
                  <option value="electrical" {{ old('category') == 'electrical' ? 'selected' : '' }}>Electrical</option>
                  <option value="carpentry" {{ old('category') == 'carpentry' ? 'selected' : '' }}>Carpentry</option>
                  <option value="tailoring" {{ old('category') == 'tailoring' ? 'selected' : '' }}>Tailoring & Fashion</option>
                  <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('category')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Price Estimate -->
              <div class="col-md-6">
                <label class="form-label">Price Estimate (ZWL)</label>
                <input type="number" name="price_estimate" step="0.01" value="{{ old('price_estimate') }}"
                  class="form-control @error('price_estimate') is-invalid @enderror" placeholder="250" required />
                @error('price_estimate')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Description -->
              <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                  placeholder="Describe your service in detail...">{{ old('description') }}</textarea>
                @error('description')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Service Image -->
              <div class="col-12">
                <label class="form-label">Service Image</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                  accept="image/*" />
                <small class="text-muted">Max file size: 2MB (JPG, PNG, GIF)</small>
                @error('image')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Availability -->
              <div class="col-12">
                <label class="form-label">Availability Status</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="availability" id="available" value="available"
                    {{ old('availability', 'available') == 'available' ? 'checked' : '' }} />
                  <label class="form-check-label" for="available">Available</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="availability" id="unavailable"
                    value="unavailable" {{ old('availability') == 'unavailable' ? 'checked' : '' }} />
                  <label class="form-check-label" for="unavailable">Unavailable</label>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Add Service</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Add Product Modal -->
  <div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('artisan-product-store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="row g-4">
              <!-- Product Name -->
              <div class="col-12">
                <label class="form-label">Product Name</label>
                <input type="text" name="product_name"
                  class="form-control @error('product_name') is-invalid @enderror" placeholder="e.g., Copper Pipes"
                  required />
                @error('product_name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Category -->
              <div class="col-md-6">
                <label class="form-label">Category</label>
                <select name="category" class="form-select @error('category') is-invalid @enderror">
                  <option value="">Select Category</option>
                  <option value="plumbing">Plumbing Supplies</option>
                  <option value="electrical">Electrical Supplies</option>
                  <option value="building">Building Materials</option>
                  <option value="tools">Tools & Equipment</option>
                  <option value="other">Other</option>
                </select>
                @error('category')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Price -->
              <div class="col-md-6">
                <label class="form-label">Price (ZWL)</label>
                <input type="number" name="price" step="0.01"
                  class="form-control @error('price') is-invalid @enderror" placeholder="100" required />
                @error('price')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Quantity -->
              <div class="col-md-6">
                <label class="form-label">Quantity Available</label>
                <input type="number" name="stock_quantity"
                  class="form-control @error('stock_quantity') is-invalid @enderror" placeholder="10" required />
                @error('stock_quantity')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Unit -->
              <div class="col-md-6">
                <label class="form-label">Unit (e.g., pieces, meters, kg)</label>
                <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror"
                  placeholder="pieces" />
                @error('unit')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Description -->
              <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                  placeholder="Describe your product in detail..."></textarea>
                @error('description')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Product Image -->
              <div class="col-12">
                <label class="form-label">Product Image</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                  accept="image/*" />
                <small class="text-muted">Max file size: 2MB (JPG, PNG, GIF)</small>
                @error('image')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Availability -->
              <div class="col-12">
                <label class="form-label">Availability Status</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="availability" id="productAvailable"
                    value="available" checked />
                  <label class="form-check-label" for="productAvailable">Available</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="availability" id="productUnavailable"
                    value="unavailable" />
                  <label class="form-check-label" for="productUnavailable">Unavailable</label>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Add Product</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('page-script')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Orders Trend Chart
      const ordersTrendOptions = {
        series: [{
          name: 'Orders',
          data: {!! $ordersTrendData !!}
        }],
        chart: {
          type: 'area',
          stacked: false,
          height: 300,
          toolbar: {
            show: false
          }
        },
        colors: ['#696cff'],
        xaxis: {
          categories: {!! $ordersLabels !!}
        },
        legend: {
          position: 'top'
        },
        dataLabels: {
          enabled: false
        }
      };
      new ApexCharts(document.querySelector("#ordersTrendChart"), ordersTrendOptions).render();

      // Completion Rate Chart
      const completionRateOptions = {
        series: [{{ $completionRate }}],
        chart: {
          type: 'radialBar',
          height: 200,
          sparkline: {
            enabled: false
          }
        },
        colors: ['#28c76f'],
        plotOptions: {
          radialBar: {
            startAngle: -90,
            endAngle: 90,
            track: {
              background: '#e0e0e0',
              strokeWidth: '97%'
            },
            dataLabels: {
              name: {
                show: false
              },
              value: {
                offset: 0,
                fontSize: '24px',
                color: '#000'
              }
            }
          }
        }
      };
      new ApexCharts(document.querySelector("#completionRateChart"), completionRateOptions).render();

      // Reopen modal if there are validation errors
      @if ($errors->any())
        var addServiceModal = new bootstrap.Modal(document.getElementById('addServiceModal'));
        addServiceModal.show();
      @endif
    });
  </script>
@endsection
