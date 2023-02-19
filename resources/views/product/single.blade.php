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
                    @php
                        if($variation == null)
                        {
                            $currentVariation = [
                                'var_id' => $product->variations[0]->id,
                                'color' => $product->variations[0]->color,
                                'image_url' => $product->variations[0]->image_url
                            ];
                        }
                        else
                        {
                            $currentVariation = [
                                'var_id' => $variation,
                                'color' => $product->variations->find($variation)->color,
                                'image_url' => $product->variations->find($variation)->image_url
                            ];
                        }
                    @endphp

                    @php
                        // dd($product->variations->find(1)->color);
                    @endphp
                    <img src="{{URL::asset('product_upload')}}/{{$currentVariation['image_url']}}" class="img-fluid" alt="">
                </div>
            </div>
            <div class="mb-2">
                <h3>Try other veriations</h3>
                @foreach ($product->variations as $variation)
                    <a href="{{ route('product.single',['id'=>$product->id, 'var_id'=>$variation->id]) }}" class="btn" style="background-color:{{ $variation->color }}">---</a>
                @endforeach
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
            <a href="{{route('product.personalized',['id'=>$product->id, 'var_id'=>$currentVariation['var_id']])}}" class="btn btn-danger">Personalized</a>
            </div>
        </div>
    </div>
</div>

@stop
