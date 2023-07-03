@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 100px;">
    <div id="product-slider" class="carousel slide" data-ride="carousel">
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            @php $active = true; @endphp
            @foreach ($products as $product)
                <div class="carousel-item @if ($active) active @endif">
                    <img src="{{ asset('public/images/' . $product->image->name) }}" alt="Product Image" class="card-image">
                </div>
                @php $active = false; @endphp
            @endforeach
        </div>
    </div>
</div>
<div class="line"></div>

<div class="container">
    <div class="container">
        <div class="row">
            @foreach ($products as $product)
                @component('components.product-card', ['product' => $product])
                @endcomponent
            @endforeach
        </div>
    </div>
</div>
@endsection
