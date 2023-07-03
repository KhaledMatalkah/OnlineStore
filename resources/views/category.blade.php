@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $category->name }}</h1>
        <div class="container">
            <div class="row">
                @foreach ($category->products as $product)
                    @component('components.product-card', ['product' => $product])
                    @endcomponent
                @endforeach
            </div>
        </div>
    </div>
@endsection
