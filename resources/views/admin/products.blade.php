@extends('layouts.app')

@section('content')
    <div class="container ct">
        <ul class="category-list">
            @foreach ($categories as $category)
                <li class="category-item">
                    <div class="category-circle2">
                        <a href="{{ route('categories.show', ['id' => $category->id]) }}"><span
                                class="category-name2">{{ $category->name }}</span></a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="container">
        <div class="row">
            <!-- Item Cards -->
            @foreach ($products as $product)
                @component('components.product-card', ['product' => $product])
                @endcomponent
            @endforeach
        </div>
    </div>
@endsection
