@extends('layouts.default')

@section('content')

@php
    $carousels = App\Models\Carousel::all();
@endphp

<div style="height: 350px; overflow:hidden;">
<div id="carouselExampleIndicators" class="carousel slide" style="height:350px" data-bs-ride="true">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">

        <!-- @foreach ($carousels as $carousel)
            <div class="carousel-item active">
                <img src="{{URL::asset('carousel')}}/{{$carousel->image_url}}" class="d-block w-100" alt="...">
            </div>
        @endforeach -->
        <div class="carousel-item active">
            <img src="{{URL::asset('carousel')}}/{{$carousels[0]->image_url}}" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="{{URL::asset('carousel')}}/{{$carousels[1]->image_url}}" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="{{URL::asset('carousel')}}/{{$carousels[2]->image_url}}" class="d-block w-100" alt="...">
        </div>

    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
</div>
<div class="container mt-3">
    <div class="row row-cols-3 justify-content-start">
        @foreach (App\Models\Product::all() as $product)
        <div class="col mt-2">
            <div class="card mt-3" style="width:350px">

                <img src="{{URL::asset('product_upload')}}/{{$product->mockup}}" class="card-img-top" />
                <div class="card-body">
                    <span class="text-danger">
                        <center><strong>{{$product->name}}</strong></center>
                    </span>
                    <div>
                        {{$product->description}}
                    </div>
                </div>
                <div class="card-footer d-grid gap-2">
                    <a href="{{route('product.single',['id'=>$product->id])}}" class="btn btn-success">Customize & Buy</a>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>

@stop
