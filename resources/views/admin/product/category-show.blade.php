@extends('layouts.admin')
@section('content')
<!-- Add Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin./') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.product.category.index') }}">Categories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>{{ session('error') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="m-0">Category Details</h4>
                    <a href="{{ route('admin.product.category.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to Categories
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($category->image)
                            <div class="col-md-4">
                                <img src="{{ asset('category_images/' . $category->image) }}" alt="{{ $category->name }}" class="img-fluid rounded mb-3">
                            </div>
                        @endif
                        <div class="col-md-{{ $category->image ? '8' : '12' }}">
                            <h3>{{ $category->name }}</h3>
                            <p class="text-muted">
                                <strong>ID:</strong> {{ $category->id }} |
                                <strong>Created:</strong> {{ $category->created_at->format('M d, Y') }} |
                                <strong>Last Updated:</strong> {{ $category->updated_at->format('M d, Y') }}
                            </p>

                            @if($category->description)
                                <div class="mb-4">
                                    <h5><i class="fas fa-info-circle"></i> Description</h5>
                                    <p>{{ $category->description }}</p>
                                </div>
                            @endif

                            <div class="mb-4">
                                <h5><i class="fas fa-box"></i> Products in this Category</h5>
                                @if($category->products && $category->products->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Price</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($category->products as $product)
                                                    <tr>
                                                        <td>{{ $product->id }}</td>
                                                        <td>{{ $product->name }}</td>
                                                        <td>${{ number_format($product->price, 2) }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('admin.product.show', $product->id) }}" class="btn btn-sm btn-info">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                                <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                                                    <i class="fas fa-edit"></i> Edit
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="text-muted mt-2">
                                        <i class="fas fa-info-circle"></i> Total products: {{ $category->products->count() }}
                                    </p>
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> No products in this category.
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <a href="{{ route('admin.product.category.edit', $category->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Edit Category
                                </a>
                                <form action="{{ route('admin.product.category.destroy', $category->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                                        <i class="fas fa-trash-alt"></i> Delete Category
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
