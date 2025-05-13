@extends('layouts.admin')
@section('content')
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">All Products</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="{{ route('admin.product.add') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus-circle"></i> Add New Product
                            </a>
                        </div>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-1"></i>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Search and Filter Form -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-filter me-1"></i>
                            Search & Filter Products
                        </div>
                        <button class="btn btn-sm btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="true" aria-controls="filterCollapse">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="filterCollapse">
                        <div class="card-body">
                            <form action="{{ route('admin.product.all') }}" method="GET" class="row g-3">
                                <!-- Basic Search -->
                                <div class="col-md-6">
                                    <label for="search" class="form-label">Search</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        <input type="text" class="form-control" id="search" name="search"
                                            placeholder="Search by name or description" value="{{ request('search') }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for="sku" class="form-label">SKU</label>
                                    <input type="text" class="form-control" id="sku" name="sku"
                                        placeholder="Enter SKU" value="{{ request('sku') }}">
                                </div>

                                <div class="col-md-3">
                                    <label for="sort" class="form-label">Sort By</label>
                                    <select class="form-select" id="sort" name="sort">
                                        <option value="">Default</option>
                                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                    </select>
                                </div>

                                <!-- Category Filter -->
                                <div class="col-md-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select class="form-select" id="category_id" name="category_id">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Price Range -->
                                <div class="col-md-2">
                                    <label for="price_min" class="form-label">Min Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="price_min" name="price_min"
                                            placeholder="Min" value="{{ request('price_min') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="price_max" class="form-label">Max Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="price_max" name="price_max"
                                            placeholder="Max" value="{{ request('price_max') }}">
                                    </div>
                                </div>

                                <!-- Inventory Status -->
                                <div class="col-md-3">
                                    <label for="inventory_status" class="form-label">Inventory Status</label>
                                    <select class="form-select" id="inventory_status" name="inventory_status">
                                        <option value="">All</option>
                                        <option value="in_stock" {{ request('inventory_status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                        <option value="out_of_stock" {{ request('inventory_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                        <option value="low_stock" {{ request('inventory_status') == 'low_stock' ? 'selected' : '' }}>Low Stock (≤ 5)</option>
                                    </select>
                                </div>

                                <!-- Availability -->
                                <div class="col-md-2">
                                    <label for="available" class="form-label">Availability</label>
                                    <select class="form-select" id="available" name="available">
                                        <option value="">All</option>
                                        <option value="1" {{ request('available') == '1' ? 'selected' : '' }}>Available</option>
                                        <option value="0" {{ request('available') == '0' ? 'selected' : '' }}>Unavailable</option>
                                    </select>
                                </div>

                                <!-- Per Page -->
                                <div class="col-md-2">
                                    <label for="per_page" class="form-label">Per Page</label>
                                    <select class="form-select" id="per_page" name="per_page">
                                        @foreach([15, 25, 50, 100] as $value)
                                            <option value="{{ $value }}" {{ $perPage == $value ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Action Buttons -->
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter me-1"></i> Apply Filters
                                    </button>
                                    <a href="{{ route('admin.product.all') }}" class="btn btn-secondary">
                                        <i class="fas fa-undo me-1"></i> Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @if ($products->isEmpty())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> No products found matching your criteria.
                    </div>
                @else
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Products ({{ $products->total() }} total)
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($products as $product)


                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td><span class="badge bg-info">{{ $product->category->name }}</span></td>
                                        <td>{{ number_format($product->price, 2) }}</td>
                                        <td>
                                            @if($product->available)
                                                <span class="badge bg-success">Available</span>
                                            @else
                                                <span class="badge bg-danger">Unavailable</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.product.show', $product->id) }}" class="btn btn-sm btn-info" title="View Product">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-sm btn-primary" title="Edit Product">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.product.variations', $product->id) }}" class="btn btn-sm btn-success" title="Manage Variations">
                                                    <i class="fas fa-images"></i>
                                                    <span class="badge bg-light text-dark">{{ $product->variations->count() }}</span>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}" title="Delete Product">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title" id="deleteModalLabel{{ $product->id }}">Confirm Delete</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete the product <strong>{{ $product->name }}</strong>?</p>
                                                            <p class="text-danger"><i class="fas fa-exclamation-triangle"></i> This action cannot be undone and will remove all product variations and images.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete Product</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                            </div>
                            <div>
                                {{ $products->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
@endsection
