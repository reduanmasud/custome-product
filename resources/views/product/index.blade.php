@extends('layouts.default')

@section('content')

@php
    $carousels = App\Models\Carousel::all();
    $products = App\Models\Product::all();
    $categories = App\Models\Category::all();
@endphp

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="mb-3">Express Your Style with Custom Prints</h1>
                <p class="mb-4">Personalize your products with our high-quality custom printing services. From t-shirts to mugs, we've got you covered.</p>
                <a href="{{ route('product.index') }}" class="btn btn-light btn-lg">Shop Now</a>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <img src="{{ asset('images/hero-image.jpg') }}" alt="Custom Print Hero" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>

<!-- Featured Categories -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Shop by Category</h2>
        <div class="row g-4">
            @foreach($categories->take(4) as $category)
            <div class="col-6 col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-{{ $category->id % 4 == 0 ? 'tshirt' : ($category->id % 3 == 0 ? 'mug-hot' : ($category->id % 2 == 0 ? 'hat-cowboy' : 'socks')) }} fa-3x mb-3 text-primary"></i>
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <a href="#" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Carousel Section -->
<section class="py-4 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Featured Collections</h2>
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @for($i = 0; $i < min(3, $carousels->count()); $i++)
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}" aria-current="{{ $i == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $i + 1 }}"></button>
                @endfor
            </div>

            @if ($carousels->count() > 0)
                <div class="carousel-inner">
                    @for($i = 0; $i < min(3, $carousels->count()); $i++)
                        <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                            <img src="{{ URL::asset('carousel') }}/{{ $carousels[$i]->image_url }}" class="d-block w-100" alt="Featured Collection {{ $i + 1 }}">
                        </div>
                    @endfor
                </div>
            @endif

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
</section>

<!-- Products Section -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Our Products</h2>
            <a href="{{ route('product.index') }}" class="btn btn-outline-primary">View All</a>
        </div>

        <div class="row g-4">
            @foreach ($products->take(8) as $product)
            <div class="col-6 col-md-3">
                <div class="product-card card h-100">
                    @php
                        $hasImage = false;
                        if($product->variations && $product->variations->isNotEmpty() && isset($product->variations[0]->image_url)) {
                            $hasImage = true;
                            $imageUrl = $product->variations[0]->image_url;
                        }
                    @endphp

                    <a href="{{ route('product.single', ['id' => $product->id]) }}">
                        @if($hasImage)
                            <img src="{{ URL::asset('product_upload') }}/{{ $imageUrl }}" class="card-img-top" alt="{{ $product->name }}">
                        @else
                            <img src="{{ URL::asset('product_upload') }}/placeholder.jpg" class="card-img-top" alt="{{ $product->name }}">
                        @endif
                    </a>

                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ Str::limit($product->description, 60) }}</p>
                        <div class="price">৳{{ $product->price }}</div>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <a href="{{ route('product.single', ['id' => $product->id]) }}" class="btn btn-primary w-100">Customize & Buy</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Why Choose Us</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <i class="fas fa-truck fa-3x text-primary mb-3"></i>
                    <h4>Fast Delivery</h4>
                    <p class="text-muted">Get your custom products delivered to your doorstep within 3-5 business days.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <i class="fas fa-medal fa-3x text-primary mb-3"></i>
                    <h4>Premium Quality</h4>
                    <p class="text-muted">We use only the highest quality materials and printing techniques for your products.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <i class="fas fa-undo fa-3x text-primary mb-3"></i>
                    <h4>Easy Returns</h4>
                    <p class="text-muted">Not satisfied with your purchase? Return it within 30 days for a full refund.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">What Our Customers Say</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="text-center">
                                <div class="mb-3">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <p class="lead mb-3">"I ordered a custom t-shirt for my brother's birthday and it turned out amazing! The quality is excellent and the print is vibrant. Will definitely order again."</p>
                                <h5 class="mb-0">Sarah Johnson</h5>
                                <small class="text-muted">Happy Customer</small>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="text-center">
                                <div class="mb-3">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <p class="lead mb-3">"The customer service was exceptional! They helped me design a custom mug for my mom and she absolutely loved it. Fast shipping too!"</p>
                                <h5 class="mb-0">Michael Brown</h5>
                                <small class="text-muted">Repeat Customer</small>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

@stop
