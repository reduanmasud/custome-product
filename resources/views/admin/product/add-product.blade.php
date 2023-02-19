@extends('layouts.admin')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add Printable Product</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar" class="align-text-bottom"></span>
                This week
            </button>
        </div>
    </div>
    <div class="row">
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
        <form action="{{ route('admin.product.add') }}" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Product Name</label>
                <input type="text" value="{{ old('name') }}" name="name" class="form-control"
                    id="exampleFormControlInput1" placeholder="Product Name">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Product Description</label>
                <textarea class="form-control" value="{{ old('description') }}" name="description" id="exampleFormControlTextarea1"
                    rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Product Price</label>
                <input type="text" name="price" value="{{ old('price') }}" class="form-control"
                    id="exampleFormControlInput1" placeholder="Product Price">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Quantity</label>
                <input type="text" value="{{ old('available') }}" name="available" class="form-control"
                    id="exampleFormControlInput1" placeholder="Product Quantity">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Select Category</label>
                <select class="form-select" aria-label="Default select example" name="category_id">
                    <option value="1" selected>Select a Category</option>
                    @php
                        $categories = App\Models\Category::all();
                    @endphp

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach

                </select>
            </div>



            <div id="variation"></div>



            <div class="col-md-12 mb-3">
                <button type="button" id="add_variation" class="btn btn-primary"> + Add Variation</button>
                <button type="submit" class="btn btn-success">Add Product</button>
            </div>
            @csrf
        </form>

    </div>

    <script>
        $('#add_variation').click(() => {
            var count_var = $('#variation').children().length;
            var html = `
            <div class="mb-3">
                <label for="basic-url" class="form-label">Variation ${count_var+1}</label>
                <div class="input-group">
                    <label class="input-group-text" for="inputGroupFile01">Color</label>
                    <input type="color" name="color[]" />
                    <input type="file" class="form-control" name="product_image[]" id="inputGroupFile01">
                </div>
            </div>
            `;
            $('#variation').append(html);
        });
    </script>
@endsection
