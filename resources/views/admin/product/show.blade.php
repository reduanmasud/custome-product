@extends('layouts.admin')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Product Details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('admin.product.all') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Products
                </a>
                <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-edit"></i> Edit Product
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Product Information
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Product Name:</div>
                        <div class="col-md-9">{{ $product->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">SKU:</div>
                        <div class="col-md-9">{{ $product->sku ?? 'Not set' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Category:</div>
                        <div class="col-md-9">
                            <span class="badge bg-info">{{ $product->category->name }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Price:</div>
                        <div class="col-md-9">${{ number_format($product->price, 2) }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Inventory:</div>
                        <div class="col-md-9">{{ $product->inventory ?? 'Not set' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Status:</div>
                        <div class="col-md-9">
                            @if($product->available)
                                <span class="badge bg-success">Available</span>
                            @else
                                <span class="badge bg-danger">Unavailable</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Created:</div>
                        <div class="col-md-9">{{ $product->created_at->format('F j, Y, g:i a') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Last Updated:</div>
                        <div class="col-md-9">{{ $product->updated_at->format('F j, Y, g:i a') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 fw-bold">Description:</div>
                        <div class="col-md-9">{{ $product->description }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-cogs me-1"></i>
                    Actions
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Product
                        </a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash"></i> Delete Product
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-images me-1"></i>
            Product Variations
        </div>
        <div class="card-body">
            @if($product->variations->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No variations found for this product.
                </div>
            @else
                <div class="row">
                    @foreach($product->variations as $variation)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    Variation {{ $loop->iteration }}
                                </div>
                                @if($variation->image_url)
                                    <img src="{{ asset('product_upload/' . $variation->image_url) }}" 
                                        class="card-img-top" alt="Product Variation">
                                @endif
                                <div class="card-body">
                                    @if($variation->color)
                                        <div class="mb-2">
                                            <strong>Color:</strong>
                                            <div class="d-flex align-items-center">
                                                <div style="width: 20px; height: 20px; background-color: {{ $variation->color }}; 
                                                    border: 1px solid #ddd; margin-right: 10px;"></div>
                                                {{ $variation->color }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
