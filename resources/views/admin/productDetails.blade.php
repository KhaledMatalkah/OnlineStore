@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div id="product-slider" class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        @php $active = true; @endphp
                        @foreach ($images as $image)
                            <div class="carousel-item @if ($active) active @endif">
                                <img src="{{ asset('public/images/' . $image->name) }}" alt="Product Image"
                                    class="card-image">
                            </div>
                            @php $active = false; @endphp
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-details">
                    <h1 class="product-name">{{ $products->name }}</h1>
                    <p class="product-description">Description: {{ $products->description }}</p>
                    <p class="product-quantity">Quantity: {{ $products->quantity }}</p>
                    <p class="product-price">Price: ${{ $products->price }}</p>

                    <form class="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $products->id }}">
                        <input class="n" style="background-color: rgba(255, 255, 255, 0.3); width: 40px; border: none;"
                            type="hidden" name="quantity" value="1">
                        <button style="height: 30px; font-weight: bold; font-size: 14px;" class="button-cart add-to-cart"
                            data-product-id="{{ $products->id }}">
                            Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .product-details {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.3);
        }

        .product-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #006185;
        }

        .product-description {
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: bold;
            color: #006185;
        }

        .product-quantity,
        .product-price {
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: bold;
            color: #006185;
        }

        #myCarousel {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .carousel-item img {
            max-height: 400px;
            width: 100%;
            object-fit: contain;
        }
    </style>
@endsection
