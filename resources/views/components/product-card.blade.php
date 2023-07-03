<div class="col-md-3">
    <div class="card">
        @if ($product)
        <img src="{{ asset('public/images/' . $product->image->name) }}" class="card-img" alt="">
        @endif
        <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text">{{ $product->description }}</p>
            <p class="card-price">Quantity {{ $product->quantity }}</p>
            <p class="card-price">${{ $product->price }}</p>
            <div class="text-center card-buttons">
                <button class="product-button button view-details" action="{{ route('products.show', $product->id) }}" data-product-id="{{ $product->id }}">
                    <a style="text-decoration: none; color: white;" href="{{ route('products.show', $product->id) }}">
                        <span>View Details</span>
                    </a>
                </button>
                <form class="add-to-cart-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input class="n" style="background-color: rgba(255, 255, 255, 0.3); width: 40px; border: none;" type="hidden" name="quantity" value="1">
                    <button class="product-button button-cart add-to-cart" data-product-id="{{ $product->id }}">Add to Cart</button>
                </form>
                @auth
                @if (auth()->user()->hasRole('admin'))
                <form id="delete-form-{{ $product->id }}" action="{{ route('products.delete', $product->id) }}" method="POST" class="d-inline delete-product-form">
                    @csrf
                    @method('DELETE')
                    <button class="product-button delete-product button-delete" data-product-id="{{ $product->id }}">Delete</button>
                </form>
                @endif
                @endauth
                @auth
                @if (auth()->user()->hasRole('admin'))
                <button class="product-button edit-product button-edit" data-product-id="{{ $product->id }}">
                    <a href="{{ route('products.edit', $product->id) }}">Edit</a>
                </button>
                @endif
                @endauth
            </div>
        </div>
    </div>
</div>
