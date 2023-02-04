@extends('layouts.default')

@section('content')
<div class="container">
<h2 class="mt-2">Add Product</h2>
    <div class="row">
        <div class="col-md-6 p-3">
        @if ($errors->any())
            <div class="alert alert-danger alert-close">
            <button class="alert-btn-close">
                <i class="fad fa-times"></i>
            </button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul> 
            </div>
        @endif

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <strong>{{ $message }}</strong>
            </div>
        @endif
        
        <form method="post" action="{{route('product.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="productName" class="form-label">Name</label>
            <input type="text" class="form-control" id="productName" name="product_name">
        </div>
        <div class="mb-3">
            <label for="productDescription" class="form-label">Description</label>
            <input type="text" class="form-control" id="productDescription" name="product_description">
        </div>
        <div class="mb-3">
            <label for="product_price" class="form-label">Price</label>
            <input type="text" class="form-control" id="product_price" name="product_price">
        </div>
        <div class="mb-3">
            <label for="product_category" class="form-label">Product Category</label>
            <select class="form-select" name="product_category" aria-label="Default select example">
                <option selected value="0">Open this select menu</option>
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="productImage" class="form-label">Upload Mockup File</label>
            <input class="form-control" name="product_mockup" type="file" id="productImage">
        </div>
        <button type="submit" class="btn btn-danger">Add Product</button>
        </form>

        </div>
        <div class="col-md-6">

        </div>
    </div>
</div>

@stop