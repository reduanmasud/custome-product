@extends('layouts.default')

@section('content')
<style>
    #product-background{
        height: 800px;
        width:600px;
        background-image: url("{{URL::asset('product_upload')}}/{{$product->mockup}}");
        background-repeat: no-repeat;
        background-size: contain;
    }
    #product-design{
        height: 800px;
        width:600px;
        background-repeat: no-repeat;
        background-size: contain;
    }
</style>
<div class="container mt-4">
    <div class="row gx-2">
        <div class="col-md-7">
            <div class="card">
                <div id="product-background">
                    <div id="product-design">

                    </div>
                </div>
                <div class="product-name px-4 pt-3">
                    <h1>{{$product->name}}</h1>
                </div>
                <!-- <div class="p-4">
                    <img src="{{URL::asset('product_upload')}}/{{$product->mockup}}" class="img-fluid" alt="">
                </div> -->
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
            <a href="{{route('product.personalized',['id'=>$product->id])}}" class="btn btn-success">Buy</a>
            </div>
        </div>
    </div>
</div>
<script>
    (function(){
        let product = document.getElementById('product-design');
        let localData = JSON.parse(localStorage.getItem('image'));
        if(localData.productid != "{{$product->id}}"){
            alert("You have not edit this image are you sure you want to buy this.");
        }
        product.style.backgroundImage = "url("+localData.image+")";
    })();
    
</script>

@stop