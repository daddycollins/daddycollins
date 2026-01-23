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
  <!-- Header -->
  <div class="row g-6 mb-6">
    <div class="col-sm-6 col-lg-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted small mb-1">Total Products</p>
              <h3 class="mb-2">24</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i class="icon-base ri ri-arrow-up-s-line me-1"></i>2
                  this month</span></p>
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
              <p class="text-muted small mb-1">Total Sales Value</p>
              <h3 class="mb-2">ZWL 45,230</h3>
              <p class="mb-0"><span class="badge bg-label-success"><i
                    class="icon-base ri ri-arrow-up-s-line me-1"></i>+18%</span></p>
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
              <p class="text-muted small mb-1">Low Stock Items</p>
              <h3 class="mb-2">3</h3>
              <p class="mb-0"><span class="badge bg-label-warning"><i class="icon-base ri ri-alert-line me-1"></i>Needs
                  action</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-warning">
              <div class="avatar-initial"><i class="icon-base ri ri-alert-fill"></i></div>
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
              <h3 class="mb-2">4.7 / 5</h3>
              <p class="mb-0"><span class="badge bg-label-info"><i class="icon-base ri ri-star-fill me-1"
                    style="color: #ffc107;"></i>12 reviews</span></p>
            </div>
            <div class="avatar avatar-lg bg-label-info">
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
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-md me-3 bg-light">
                    <img src="{{ asset('assets/img/products/product-1.png') }}" alt="Product" class="rounded" />
                  </div>
                  <div>
                    <h6 class="mb-0 fw-medium">Hand-Crafted Wooden Chair</h6>
                    <small class="text-muted">SKU: HC-2024-001</small>
                  </div>
                </div>
              </td>
              <td><code>HC-2024-001</code></td>
              <td><span class="badge bg-label-info">Furniture</span></td>
              <td><strong>ZWL 2,450</strong></td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <span class="fw-medium">45</span>
                  <small class="badge bg-label-success">✓</small>
                </div>
              </td>
              <td><span class="fw-medium text-success">128 sold</span></td>
              <td>
                <div class="d-flex align-items-center">
                  <i class="icon-base ri ri-star-fill" style="color: #ffc107;"></i>
                  <span class="ms-1">4.8</span>
                </div>
              </td>
              <td><span class="badge bg-label-success">Active</span></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                    data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-fill"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                      data-bs-target="#editProductModal">
                      <i class="icon-base ri ri-edit-line me-2"></i>Edit
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                      data-bs-target="#updateStockModal">
                      <i class="icon-base ri ri-refresh-line me-2"></i>Update Stock
                    </a>
                    <hr class="dropdown-divider" />
                    <a class="dropdown-item text-danger" href="javascript:void(0);" data-bs-toggle="modal"
                      data-bs-target="#deleteProductModal">
                      <i class="icon-base ri ri-delete-bin-line me-2"></i>Delete
                    </a>
                  </div>
                </div>
              </td>
            </tr>

            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-md me-3 bg-light">
                    <img src="{{ asset('assets/img/products/product-2.png') }}" alt="Product" class="rounded" />
                  </div>
                  <div>
                    <h6 class="mb-0 fw-medium">Woven Basket Set</h6>
                    <small class="text-muted">SKU: WB-2024-002</small>
                  </div>
                </div>
              </td>
              <td><code>WB-2024-002</code></td>
              <td><span class="badge bg-label-warning">Home Decor</span></td>
              <td><strong>ZWL 890</strong></td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <span class="fw-medium text-danger">8</span>
                  <small class="badge bg-label-warning">!</small>
                </div>
              </td>
              <td><span class="fw-medium text-success">342 sold</span></td>
              <td>
                <div class="d-flex align-items-center">
                  <i class="icon-base ri ri-star-fill" style="color: #ffc107;"></i>
                  <span class="ms-1">4.6</span>
                </div>
              </td>
              <td><span class="badge bg-label-success">Active</span></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                    data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-fill"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                      data-bs-target="#editProductModal">
                      <i class="icon-base ri ri-edit-line me-2"></i>Edit
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                      data-bs-target="#updateStockModal">
                      <i class="icon-base ri ri-refresh-line me-2"></i>Update Stock
                    </a>
                    <hr class="dropdown-divider" />
                    <a class="dropdown-item text-danger" href="javascript:void(0);" data-bs-toggle="modal"
                      data-bs-target="#deleteProductModal">
                      <i class="icon-base ri ri-delete-bin-line me-2"></i>Delete
                    </a>
                  </div>
                </div>
              </td>
            </tr>

            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <div class="avatar avatar-md me-3 bg-light">
                    <img src="{{ asset('assets/img/products/product-3.png') }}" alt="Product" class="rounded" />
                  </div>
                  <div>
                    <h6 class="mb-0 fw-medium">Leather Handbag</h6>
                    <small class="text-muted">SKU: LH-2024-003</small>
                  </div>
                </div>
              </td>
              <td><code>LH-2024-003</code></td>
              <td><span class="badge bg-label-danger">Accessories</span></td>
              <td><strong>ZWL 3,200</strong></td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <span class="fw-medium">62</span>
                  <small class="badge bg-label-success">✓</small>
                </div>
              </td>
              <td><span class="fw-medium text-success">95 sold</span></td>
              <td>
                <div class="d-flex align-items-center">
                  <i class="icon-base ri ri-star-fill" style="color: #ffc107;"></i>
                  <span class="ms-1">4.9</span>
                </div>
              </td>
              <td><span class="badge bg-label-success">Active</span></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                    data-bs-toggle="dropdown">
                    <i class="icon-base ri ri-more-2-fill"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                      data-bs-target="#editProductModal">
                      <i class="icon-base ri ri-edit-line me-2"></i>Edit
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                      data-bs-target="#updateStockModal">
                      <i class="icon-base ri ri-refresh-line me-2"></i>Update Stock
                    </a>
                    <hr class="dropdown-divider" />
                    <a class="dropdown-item text-danger" href="javascript:void(0);" data-bs-toggle="modal"
                      data-bs-target="#deleteProductModal">
                      <i class="icon-base ri ri-delete-bin-line me-2"></i>Delete
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

  <!-- Add Product Modal -->
  <div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-header border-bottom">
          <h5 class="modal-title"><i class="icon-base ri ri-add-circle-line me-2 text-primary"></i>Add New Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addProductForm">
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label fw-medium">Product Name *</label>
                <input type="text" class="form-control" placeholder="e.g., Hand-Crafted Wooden Chair" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">SKU *</label>
                <input type="text" class="form-control" placeholder="e.g., HC-2024-001" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Category *</label>
                <select class="form-select" required>
                  <option value="">Select category</option>
                  <option value="furniture">Furniture</option>
                  <option value="decor">Home Decor</option>
                  <option value="accessories">Accessories</option>
                  <option value="textiles">Textiles</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Price (ZWL) *</label>
                <input type="number" class="form-control" placeholder="e.g., 2,450" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Initial Stock *</label>
                <input type="number" class="form-control" placeholder="e.g., 50" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Low Stock Alert Level *</label>
                <input type="number" class="form-control" placeholder="e.g., 10" required />
              </div>
              <div class="col-12">
                <label class="form-label fw-medium">Description</label>
                <textarea class="form-control" rows="3" placeholder="Product description..."></textarea>
              </div>
              <div class="col-12">
                <label class="form-label fw-medium">Product Image</label>
                <div class="border-2 border-dashed rounded p-4 text-center" style="cursor: pointer;">
                  <i class="icon-base ri ri-image-add-line icon-48px text-primary mb-2 d-block"></i>
                  <p class="text-muted small mb-0">Click to upload or drag and drop</p>
                  <input type="file" class="d-none" accept="image/*" />
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" form="addProductForm">
            <i class="icon-base ri ri-save-line me-2"></i>Add Product
          </button>
        </div>
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
        <div class="modal-body">
          <form id="editProductForm">
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label fw-medium">Product Name *</label>
                <input type="text" class="form-control" value="Hand-Crafted Wooden Chair" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">SKU *</label>
                <input type="text" class="form-control" value="HC-2024-001" required />
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Category *</label>
                <select class="form-select" required>
                  <option value="furniture" selected>Furniture</option>
                  <option value="decor">Home Decor</option>
                  <option value="accessories">Accessories</option>
                  <option value="textiles">Textiles</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-medium">Price (ZWL) *</label>
                <input type="number" class="form-control" value="2450" required />
              </div>
              <div class="col-12">
                <label class="form-label fw-medium">Description</label>
                <textarea class="form-control" rows="3">Beautiful hand-crafted wooden chair made from sustainably sourced wood.</textarea>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" form="editProductForm">
            <i class="icon-base ri ri-save-line me-2"></i>Update Product
          </button>
        </div>
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
        <div class="modal-body">
          <form id="updateStockForm">
            <div class="mb-4">
              <label class="form-label fw-medium mb-3">Current Stock: <strong>45 units</strong></label>
              <div class="alert alert-light" role="alert">
                <small><strong>Product:</strong> Hand-Crafted Wooden Chair</small>
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
              <input type="number" class="form-control" placeholder="Enter quantity" required />
            </div>
            <div class="mb-0">
              <label class="form-label fw-medium">Reason (Optional)</label>
              <select class="form-select">
                <option value="">Select reason</option>
                <option value="purchase">Purchase</option>
                <option value="return">Customer Return</option>
                <option value="damage">Damaged</option>
                <option value="inventory">Inventory Adjustment</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" form="updateStockForm">
            <i class="icon-base ri ri-check-line me-2"></i>Update Stock
          </button>
        </div>
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
        <div class="modal-body">
          <p class="mb-0">Are you sure you want to delete <strong>Hand-Crafted Wooden Chair</strong>? This action
            cannot be undone.</p>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger">
            <i class="icon-base ri ri-delete-bin-line me-2"></i>Delete Product
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Sales Trend Chart
    const salesTrendChart = new ApexCharts(document.querySelector("#salesTrendChart"), {
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
    const categoryChart = new ApexCharts(document.querySelector("#categoryChart"), {
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
  </script>
@endsection
