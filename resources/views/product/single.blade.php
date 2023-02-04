@extends('layouts.default')

@section('content')

<div class="container mt-4">
    <div class="row gx-2">
        <div class="col-md-7">
            <div class="card">
                <img src="" alt="" srcset="" />
                <div class="product-name px-4 pt-3">
                    <h1>{{$product->name}}</h1>
                </div>
                <div class="p-4">
                    <img src="{{URL::asset('product_upload')}}/{{$product->mockup}}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card p-3">
            <strong>Description: </strong>
            <p>{{$product->description}}</p>
            <strong>Product Price:</strong>
            <p>{{$product->price}} taka</p>
            </div>
            <div class="d-grid gap-2 mt-2">
            <a href="{{route('product.personalized',['id'=>$product->id])}}" class="btn btn-danger">Personalized</a>
            </div>
        </div>
    </div>
</div>

@stop