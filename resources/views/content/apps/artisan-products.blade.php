@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'My Products - ArtisanConnect')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('content')
  <!-- Flash Messages Alert Component -->
  <x-alert />

  <!-- Header -->
  <div class="row g-6 mb-6">
    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Total Products</p>
              <h3 class="mb-2">{{ $totalProducts }}</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>{{ $availableProducts }} available</span></p>
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
              <p class="text-muted small mb-1">Total Earnings</p>
              <h3 class="mb-2">ZWL {{ number_format($totalEarnings, 0) }}</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>From sales</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-success">
              <div class="avatar-initial"><i class="icon-base ri ri-money-dollar-circle-line"></i></div>
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
              <p class="text-muted small mb-1">Stock Value</p>
              <h3 class="mb-2">ZWL {{ number_format($totalStockValue, 0) }}</h3>
              <p class="mb-0"><span class="badge bg-label-info"><i
                    class="icon-base ri ri-inbox-line me-1"></i>Inventory</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-info">
              <div class="avatar-initial"><i class="icon-base ri ri-inbox-line"></i></div>
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
              <p class="text-muted small mb-1">Avg Rating</p>
              <h3 class="mb-2">{{ number_format($avgRating, 1) }} / 5</h3>
              <p class="mb-0"><span class="badge bg-label-warning"><i class="icon-base ri ri-star-fill me-1"
                    style="color: #ffc107;"></i>{{ $reviewCount }} reviews</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-warning">
              <div class="avatar-initial"><i class="icon-base ri ri-star-line"></i></div>
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
          <h5 class="card-title m-0"><i class="icon-base ri ri-line-chart-line me-2 text-primary"></i>Sales Trend</h5>
        </div>
        <div class="card-body">
          <div id="salesTrendChart" style="height: 350px;"></div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
          <h5 class="card-title m-0"><i class="icon-base ri ri-pie-chart-line me-2 text-success"></i>Category Distribution
          </h5>
        </div>
        <div class="card-body">
          <div id="categoryChart" style="height: 350px;"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Products Table -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom">
      <div class="row g-3 align-items-center">
        <div class="col-md-6">
          <h5 class="card-title m-0"><i class="icon-base ri ri-shopping-bag-line me-2 text-primary"></i>Product Inventory
          </h5>
        </div>
        <div class="col-md-6 text-end">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="icon-base ri ri-add-line me-2"></i>Add Product
          </button>
        </div>
      </div>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>Product</th>
              <th>SKU</th>
              <th>Category</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Sales</th>
              <th>Rating</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($products as $product)
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-md me-3 bg-light">
                      @if ($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->product_name }}" class="rounded" />
                      @else
                        <i class="icon-base ri ri-shopping-bag-line" style="font-size: 24px; color: #ccc;"></i>
                      @endif
                    </div>
                    <div>
                      <h6 class="mb-0 fw-medium">{{ $product->product_name }}</h6>
                      <small class="text-muted">{{ Illuminate\Support\Str::limit($product->description, 25) }}</small>
                    </div>
                  </div>
                </td>
                <td><code>PROD-{{ $product->id }}</code></td>
                <td><span
                    class="badge bg-label-{{ $product->category ? 'primary' : 'secondary' }}">{{ $product->category ?? 'General' }}</span>
                </td>
                <td><strong>ZWL {{ number_format($product->price, 2) }}</strong></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <span class="fw-medium">{{ $product->stock_quantity }}</span>
                    <small
                      class="badge bg-label-{{ $product->stock_quantity > 20 ? 'success' : ($product->stock_quantity > 10 ? 'warning' : 'danger') }}">
                      {{ $product->stock_quantity > 20 ? '✓' : '!' }}
                    </small>
                  </div>
                </td>
                <td><span class="fw-medium text-success">0 sold</span></td>
                <td>
                  <div class="d-flex align-items-center">
                    <i class="icon-base ri ri-star-fill" style="color: #ffc107;"></i>
                    <span class="ms-1">{{ number_format($avgRating, 1) }}</span>
                  </div>
                </td>
                <td>
                  <span class="badge bg-label-{{ $product->availability ? 'success' : 'warning' }}">
                    {{ $product->availability ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td>
                  <div class="dropdown">
                    <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                      data-bs-toggle="dropdown">
                      <i class="icon-base ri ri-more-2-fill"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item edit-product-btn" href="javascript:void(0);" data-bs-toggle="modal"
                        data-bs-target="#editProductModal"
                        data-product-id="{{ $product->id }}"
                        data-product-name="{{ $product->product_name }}"
                        data-category="{{ $product->category }}"
                        data-price="{{ $product->price }}"
                        data-stock="{{ $product->stock_quantity }}"
                        data-unit="{{ $product->unit }}"
                        data-description="{{ $product->description }}"
                        data-availability="{{ $product->availability }}">
                        <i class="icon-base ri ri-edit-line me-2"></i>Edit
                      </a>
                      <a class="dropdown-item stock-btn" href="javascript:void(0);" data-bs-toggle="modal"
                        data-bs-target="#updateStockModal"
                        data-product-id="{{ $product->id }}"
                        data-product-name="{{ $product->product_name }}"
                        data-stock="{{ $product->stock_quantity }}">
                        <i class="icon-base ri ri-refresh-line me-2"></i>Update Stock
                      </a>
                      <hr class="dropdown-divider" />
                      <a class="dropdown-item text-danger delete-product-btn" href="javascript:void(0);" data-bs-toggle="modal"
                        data-bs-target="#deleteProductModal"
                        data-product-id="{{ $product->id }}"
                        data-product-name="{{ $product->product_name }}">
                        <i class="icon-base ri ri-delete-bin-line me-2"></i>Delete
                      </a>
                    </div>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-center py-4">
                  <p class="text-muted mb-0"><i class="icon-base ri ri-inbox-line me-2"></i>No products found. <a
                      href="{{ route('artisan-dashboard') }}" class="text-primary">Add your first product</a></p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Add Product Modal -->
  <div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-add-circle-line me-2 text-primary"></i>Add New Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addProductForm" action="{{ route('artisan-product-store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label fw-medium">Product Name *</label>
                <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror"
                  value="{{ old('product_name') }}" placeholder="e.g., Hand-Crafted Wooden Chair" required />
                @error('product_name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Category</label>
                <select name="category" class="form-select @error('category') is-invalid @enderror">
                  <option value="">Select Category</option>
                  <option value="Furniture" {{ old('category') == 'Furniture' ? 'selected' : '' }}>Furniture</option>
                  <option value="Home Decor" {{ old('category') == 'Home Decor' ? 'selected' : '' }}>Home Decor</option>
                  <option value="Accessories" {{ old('category') == 'Accessories' ? 'selected' : '' }}>Accessories</option>
                  <option value="Textiles" {{ old('category') == 'Textiles' ? 'selected' : '' }}>Textiles</option>
                  <option value="Building Materials" {{ old('category') == 'Building Materials' ? 'selected' : '' }}>Building Materials</option>
                  <option value="Tools & Equipment" {{ old('category') == 'Tools & Equipment' ? 'selected' : '' }}>Tools & Equipment</option>
                  <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('category')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Price (ZWL) *</label>
                <input type="number" name="price" step="0.01" class="form-control @error('price') is-invalid @enderror"
                  value="{{ old('price') }}" placeholder="e.g., 2450" required />
                @error('price')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Stock Quantity *</label>
                <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror"
                  value="{{ old('stock_quantity') }}" placeholder="e.g., 50" required />
                @error('stock_quantity')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Unit</label>
                <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror"
                  value="{{ old('unit') }}" placeholder="e.g., pieces, meters, kg" />
                @error('unit')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Availability</label>
                <select name="availability" class="form-select">
                  <option value="available" {{ old('availability', 'available') == 'available' ? 'selected' : '' }}>Available</option>
                  <option value="unavailable" {{ old('availability') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label fw-medium">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3"
                  placeholder="Describe your product in detail...">{{ old('description') }}</textarea>
                @error('description')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-12">
                <label class="form-label fw-medium">Product Image</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" />
                <small class="text-muted">Max file size: 2MB (JPG, PNG, GIF)</small>
                @error('image')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="modal-footer border-top">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <i class="icon-base ri ri-save-line me-2"></i>Add Product
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Product Modal -->
  <div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-edit-line me-2 text-primary"></i>Edit Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editProductForm" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label fw-medium">Product Name *</label>
                <input type="text" name="product_name" id="editProductName" class="form-control" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Category</label>
                <select name="category" id="editProductCategory" class="form-select">
                  <option value="">Select Category</option>
                  <option value="Furniture">Furniture</option>
                  <option value="Home Decor">Home Decor</option>
                  <option value="Accessories">Accessories</option>
                  <option value="Textiles">Textiles</option>
                  <option value="Building Materials">Building Materials</option>
                  <option value="Tools & Equipment">Tools & Equipment</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Price (ZWL) *</label>
                <input type="number" name="price" id="editProductPrice" class="form-control" step="0.01" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Stock Quantity *</label>
                <input type="number" name="stock_quantity" id="editProductStock" class="form-control" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Unit</label>
                <input type="text" name="unit" id="editProductUnit" class="form-control" placeholder="e.g., pieces, meters, kg" />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Availability</label>
                <select name="availability" id="editProductAvailability" class="form-select">
                  <option value="available">Available</option>
                  <option value="unavailable">Unavailable</option>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label fw-medium">Description</label>
                <textarea name="description" id="editProductDescription" class="form-control" rows="3"></textarea>
              </div>
              <div class="col-12">
                <label class="form-label fw-medium">Product Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" />
                <small class="text-muted">Leave empty to keep current image</small>
              </div>
            </div>
          </div>
          <div class="modal-footer border-top">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <i class="icon-base ri ri-save-line me-2"></i>Update Product
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Update Stock Modal -->
  <div class="modal fade" id="updateStockModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-refresh-line me-2 text-primary"></i>Update Stock</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updateStockForm" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="mb-4">
              <label class="form-label fw-medium mb-3">Current Stock: <strong id="stockCurrentQty">0</strong> units</label>
              <div class="alert alert-light" role="alert">
                <small><strong>Product:</strong> <span id="stockProductName">-</span></small>
              </div>
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium">Stock Action *</label>
              <div class="btn-group w-100" role="group">
                <input type="radio" class="btn-check" name="action" id="addStock" value="add" checked />
                <label class="btn btn-outline-primary" for="addStock">
                  <i class="icon-base ri ri-add-line me-2"></i>Add Stock
                </label>
                <input type="radio" class="btn-check" name="action" id="reduceStock" value="reduce" />
                <label class="btn btn-outline-primary" for="reduceStock">
                  <i class="icon-base ri ri-subtract-line me-2"></i>Reduce Stock
                </label>
              </div>
            </div>
            <div class="mb-4">
              <label class="form-label fw-medium">Quantity *</label>
              <input type="number" name="quantity" class="form-control" placeholder="Enter quantity" min="1" required />
            </div>
          </div>
          <div class="modal-footer border-top">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <i class="icon-base ri ri-check-line me-2"></i>Update Stock
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-alert-line me-2 text-danger"></i>Delete Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="deleteProductForm" method="POST">
          @csrf
          @method('DELETE')
          <div class="modal-body">
            <p class="mb-0">Are you sure you want to delete <strong id="deleteProductName">this product</strong>? This action
              cannot be undone.</p>
          </div>
          <div class="modal-footer border-top">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">
              <i class="icon-base ri ri-delete-bin-line me-2"></i>Delete Product
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
      // Edit Product Modal - Populate with data
      document.querySelectorAll('.edit-product-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
          document.getElementById('editProductName').value = this.getAttribute('data-product-name');
          document.getElementById('editProductCategory').value = this.getAttribute('data-category') || '';
          document.getElementById('editProductPrice').value = this.getAttribute('data-price');
          document.getElementById('editProductStock').value = this.getAttribute('data-stock');
          document.getElementById('editProductUnit').value = this.getAttribute('data-unit') || '';
          document.getElementById('editProductDescription').value = this.getAttribute('data-description') || '';

          var availability = this.getAttribute('data-availability');
          document.getElementById('editProductAvailability').value = (availability === '1' || availability === 'available') ? 'available' : 'unavailable';

          var productId = this.getAttribute('data-product-id');
          document.getElementById('editProductForm').action = '/artisan/products/' + productId + '/update';
        });
      });

      // Update Stock Modal - Populate with data
      document.querySelectorAll('.stock-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
          document.getElementById('stockProductName').textContent = this.getAttribute('data-product-name');
          document.getElementById('stockCurrentQty').textContent = this.getAttribute('data-stock');

          var productId = this.getAttribute('data-product-id');
          document.getElementById('updateStockForm').action = '/artisan/products/' + productId + '/stock';
        });
      });

      // Delete Product Modal - Populate with data
      document.querySelectorAll('.delete-product-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
          document.getElementById('deleteProductName').textContent = this.getAttribute('data-product-name');

          var productId = this.getAttribute('data-product-id');
          document.getElementById('deleteProductForm').action = '/artisan/products/' + productId;
        });
      });

      // Reopen Add Product modal if there are validation errors
      @if ($errors->any())
        var addProductModal = new bootstrap.Modal(document.getElementById('addProductModal'));
        addProductModal.show();
      @endif

      // Sales Trend Chart
      var salesTrendChart = new ApexCharts(document.querySelector("#salesTrendChart"), {
        series: [{
          name: "Sales",
          data: [2100, 1500, 3200, 2800, 4100, 3900, 4500]
        }],
        chart: {
          type: "area",
          height: 350,
          sparkline: {
            enabled: false
          }
        },
        colors: ["#667eea"],
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
            text: "Sales (ZWL)"
          }
        },
        tooltip: {
          shared: true,
          intersect: false
        }
      });
      salesTrendChart.render();

      // Category Distribution Chart
      var categoryChart = new ApexCharts(document.querySelector("#categoryChart"), {
        series: [35, 25, 20, 20],
        chart: {
          type: "donut",
          height: 350
        },
        labels: ["Furniture", "Decor", "Accessories", "Textiles"],
        colors: ["#667eea", "#764ba2", "#f093fb", "#4facfe"],
        legend: {
          position: "bottom"
        }
      });
      categoryChart.render();
    });
  </script>
@endsection
