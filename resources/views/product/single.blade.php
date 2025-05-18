@extends('layouts.default')

@section('content')

@php
    if($variation == null) {
        $currentVariation = [
            'var_id' => $product->variations[0]->id,
            'color' => $product->variations[0]->color,
            'image_url' => $product->variations[0]->image_url
        ];
    } else {
        $currentVariation = [
            'var_id' => $variation,
            'color' => $product->variations->find($variation)->color,
            'image_url' => $product->variations->find($variation)->image_url
        ];
    }
@endphp

<!-- Breadcrumb -->
<div class="bg-light py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Product Images -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-0">
                        <img src="{{ URL::asset('product_upload') }}/{{ $currentVariation['image_url'] }}" class="product-detail-img img-fluid rounded" alt="{{ $product->name }}">
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="mb-3">Available Colors</h5>
                    <div class="d-flex flex-wrap">
                        @foreach ($product->variations as $var)
                            <a href="{{ route('product.single', ['id' => $product->id, 'var_id' => $var->id]) }}"
                               class="color-option me-2 mb-2 {{ $var->id == $currentVariation['var_id'] ? 'active' : '' }}"
                               style="background-color: {{ $var->color }}"
                               title="{{ $var->color }}"
                               data-bs-toggle="tooltip">
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-6">
                <h1 class="product-detail-title">{{ $product->name }}</h1>

                <div class="product-detail-price mb-4">৳{{ $product->price }}</div>

                <div class="product-detail-description mb-4">
                    <h5>Description</h5>
                    <p>{{ $product->description }}</p>
                </div>

                <div class="mb-4">
                    <h5>Features</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> High-quality materials</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Durable printing</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Multiple color options</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Customizable design</li>
                    </ul>
                </div>

                <div class="mb-4">
                    <h5>Quantity</h5>
                    <div class="input-group" style="width: 150px;">
                        <button class="btn btn-outline-secondary" type="button" id="decrementBtn">-</button>
                        <input type="number" class="form-control text-center" value="1" min="1" id="quantityInput">
                        <button class="btn btn-outline-secondary" type="button" id="incrementBtn">+</button>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('product.personalized', ['id' => $product->id, 'var_id' => $currentVariation['var_id']]) }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-palette me-2"></i> Personalize Now
                    </a>
                    <button class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                    </button>
                </div>

                <div class="mt-4">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-truck text-muted me-2"></i>
                        <span>Free shipping on orders over ৳1000</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-undo text-muted me-2"></i>
                        <span>30-day return policy</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-shield-alt text-muted me-2"></i>
                        <span>Secure payment</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-4">You May Also Like</h2>
        <div class="row g-4">
            @foreach (App\Models\Product::inRandomOrder()->where('id', '!=', $product->id)->take(4)->get() as $relatedProduct)
            <div class="col-6 col-md-3">
                <div class="product-card card h-100">
                    @php
                        $hasImage = false;
                        if($relatedProduct->variations && $relatedProduct->variations->isNotEmpty() && isset($relatedProduct->variations[0]->image_url)) {
                            $hasImage = true;
                            $imageUrl = $relatedProduct->variations[0]->image_url;
                        }
                    @endphp

                    <a href="{{ route('product.single', ['id' => $relatedProduct->id]) }}">
                        @if($hasImage)
                            <img src="{{ URL::asset('product_upload') }}/{{ $imageUrl }}" class="card-img-top" alt="{{ $relatedProduct->name }}">
                        @else
                            <img src="{{ URL::asset('product_upload') }}/placeholder.jpg" class="card-img-top" alt="{{ $relatedProduct->name }}">
                        @endif
                    </a>

                    <div class="card-body">
                        <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                        <p class="card-text">{{ Str::limit($relatedProduct->description, 60) }}</p>
                        <div class="price">৳{{ $relatedProduct->price }}</div>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <a href="{{ route('product.single', ['id' => $relatedProduct->id]) }}" class="btn btn-primary w-100">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@section('footer_content')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity increment/decrement
        const quantityInput = document.getElementById('quantityInput');
        const incrementBtn = document.getElementById('incrementBtn');
        const decrementBtn = document.getElementById('decrementBtn');

        incrementBtn.addEventListener('click', function() {
            quantityInput.value = parseInt(quantityInput.value) + 1;
        });

        decrementBtn.addEventListener('click', function() {
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        });
    });
</script>
@endsection

@stop
