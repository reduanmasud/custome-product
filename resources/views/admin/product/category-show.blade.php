@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="m-0">Category Details</h4>
                    <a href="{{ route('admin.product.category') }}" class="btn btn-light btn-sm">Back to Categories</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($category->image)
                            <div class="col-md-4">
                                <img src="{{ asset('category_images/' . $category->image) }}" alt="{{ $category->name }}" class="img-fluid rounded">
                            </div>
                        @endif
                        <div class="col-md-{{ $category->image ? '8' : '12' }}">
                            <h3>{{ $category->name }}</h3>
                            <p class="text-muted">ID: {{ $category->id }}</p>
                            
                            @if($category->description)
                                <div class="mb-4">
                                    <h5>Description</h5>
                                    <p>{{ $category->description }}</p>
                                </div>
                            @endif
                            
                            <div class="mb-4">
                                <h5>Products in this Category</h5>
                                @if($category->products && $category->products->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($category->products as $product)
                                                    <tr>
                                                        <td>{{ $product->id }}</td>
                                                        <td>{{ $product->name }}</td>
                                                        <td>${{ number_format($product->price, 2) }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.product.show', $product->id) }}" class="btn btn-sm btn-info">View</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">No products in this category.</p>
                                @endif
                            </div>
                            
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.product.category.edit', $category->id) }}" class="btn btn-primary">Edit Category</a>
                                <form action="{{ route('admin.product.category.destroy', $category->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete Category</button>
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
