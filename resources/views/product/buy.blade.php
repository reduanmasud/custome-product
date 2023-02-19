@extends('layouts.default')

@section('content')
    <style>
        #product-background {
            height: 800px;
            width: 600px;
            background-image: url("{{ URL::asset('product_upload') }}/{{ $product->variations->find($variation)->image_url }}");
            background-repeat: no-repeat;
            background-size: contain;
        }

        #product-design {
            height: 800px;
            width: 600px;
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
                        <h1>{{ $product->name }}</h1>
                    </div>
                    <!-- <div class="p-4">
                                <img src="{{ URL::asset('product_upload') }}/{{ $product->mockup }}" class="img-fluid" alt="">
                            </div> -->
                </div>
            </div>
            <div class="col-md-5">
                <div class="card p-3">
                    <strong>Description: </strong>
                    <p>{{ $product->description }}</p>
                    <strong>Product Price:</strong>
                    <p>{{ $product->price }} taka</p>
                </div>
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
                <form action="{{ route('confirm-buy') }}" method="post">
                    <div class="card p-3 mt-3">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Write Your Address</label>
                            <input type="text" value="{{old('address')}}" name="address" id="" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Quentity</label>
                            <input type="text" name="quantity" onkeyup="price()" id="quantity" class="form-control">
                        </div>
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="variation_id" value="{{ $variation }}">
                        <input type="hidden" name="image_editted" value="" id="edited_image">

                        <div class="mb-3 mt-3">
                            Total Price : <span id="price-show">0</span>
                        </div>
                        <div class="mb-3">
                            <small>100 taka added due to the delevary charge.</small>
                        </div>

                    </div>
                    <div class="card p-3 mt-3">
                        <p>Send money to this bkash number. 01749223456</p>
                        <div class="mb-3">
                            <label for="" class="form-label">Your Bkash Number</label>
                            <input type="text" value="{{old('bkash_number')}}" name="bkash_number" id="" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">TrxId</label>
                            <input type="text" value="{{old('trx_id')}}" name="trx_id" id="" class="form-control">
                        </div>
                    </div>
                    @auth
                    <div class="d-grid gap-2 mt-2">
                        <button type="submit" class="btn btn-success">Buy</button>
                    </div>
                    @else
                        <h2>You Must Login First to buy this item</h2>
                    @endauth

                </form>


            </div>
        </div>
    </div>
    <script>
        function price() {
            var quantity = document.getElementById('quantity').value;
            document.getElementById('price-show').innerHTML = {{ $product->price }} * quantity + 100;
        }
        (function() {
            let product = document.getElementById('product-design');
            let localData = JSON.parse(localStorage.getItem('image'));
            if (localData.productid != "{{ $product->id }}") {
                alert("You have not edit this image are you sure you want to buy this.");
            }
            product.style.backgroundImage = "url(" + localData.image + ")";
            document.getElementById('edited_image').value = localData.image;
            console.log(localData);
        })();
    </script>

@stop
