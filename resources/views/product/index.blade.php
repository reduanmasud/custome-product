@extends('layouts.default')

@section('content')

<div class="container mt-3">
    <div class="row row-cols-3 justify-content-start">

    @foreach (App\Models\Product::all() as $product)
        <div class="col mt-2">
            <div class="card mt-3" style="width:350px">
            
            <img src="{{URL::asset('product_upload')}}/{{$product->mockup}}" class="card-img-top"/>
                <div class="card-body">
                    <span class="text-danger"><center><strong>{{$product->name}}</strong></center></span>
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