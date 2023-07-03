@extends('layouts.app')

@section('content')
    <table class="table" id="cart-table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="cart-table tbody">
            @if (isset($carts) && !$carts->isEmpty())
                @foreach ($carts as $cart)
                    <tr>
                        <td>{{ $cart->product->name }}</td>
                        <td>
                            <form action="{{ route('cart.updateQuantity', $cart->id) }}" method="POST" class="d-inline">
                                <button class="decrease-quantity" data-cart-id="{{ $cart->id }}">-</button>
                                <input type="" class="quantity-input" name="quantity" value="{{ $cart->quantity }}"
                                    readonly>
                                <button class="increase-quantity" data-cart-id="{{ $cart->id }}">+</button>
                            </form>
                            <input type="hidden" name="max_quantity[]" id="max_quantity_{{ $cart->id }}"
                                value="{{ $cart->product->quantity }}">
                        </td>
                        <td>
                            <form action="{{ route('cart.destroy', $cart->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="delete-cart" id="action"
                                    data-cart-id="{{ $cart->id }}">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>
                        <td>
                            <td>
                                <h1>{{ $message }}</h1>
                            </td>
                        </td>
                    </td>
                </tr>

            @endif
        </tbody>
    </table>
    <form action="{{ route('placeOrder') }}" method="POST">
        @csrf
        <div class="placeOrder">
            <label class="address" for="address">Enter Your Address</label>
            <input class="input" type="text" id="address" name="address" required>
            <button type="submit" class="PlaceOrder-Button">Place Order</button>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.decrease-quantity', function(e) {
                e.preventDefault();
                var quantityInput = $(this).closest('td').find('.quantity-input');
                var quantity = parseInt(quantityInput.val());

                if (quantity > 1) {
                    quantity -= 1;
                    quantityInput.val(quantity);
                    updateCartQuantity($(this).data('cart-id'), quantity);
                } else {
                    toastr.error('You have reached the minimum limit of the product quantity!', 'Error');
                }
            });

            $(document).on('click', '.increase-quantity', function(e) {
                e.preventDefault();

                var quantityInput = $(this).closest('td').find('.quantity-input');
                var quantity = parseInt(quantityInput.val());
                var cartId = $(this).data('cart-id');
                var maxQuantity = parseInt($('#max_quantity_' + cartId).val()); // Get the maxQuantity value

                if (quantity < maxQuantity) {
                    quantity += 1;
                    quantityInput.val(quantity);
                    updateCartQuantity(cartId, quantity); // Use cartId instead of $(this).data('cart-id')
                } else {
                    toastr.error('You have reached the maximum limit of the product quantity!', 'Error');
                }
            });





            function updateCartQuantity(cartId, quantity) {
                $.ajax({
                    url: "/cart/" + cartId,
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.error) {
                            toastr.error(response.error, 'Error');
                            // Reset the quantity input
                            reloadTable();
                        } else {
                            // Update the quantity in the cartItems table
                            // Show the success message
                            toastr.success(response.success, 'Success');
                            reloadTable();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }






            // Delete Cart function
            function deleteItem(cartId, quantity) {
                $.ajax({
                    url: "/cart/" + cartId,
                    method: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        quantity: quantity // Pass the quantity to be deleted
                    },
                    success: function(response) {
                        if (response.error) {
                            toastr.error(response.error, 'Error');
                        } else {
                            reloadTable();
                            toastr.success(response.success, 'success');
                        }
                        // Reload the table after successful deletion
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }

            // Reload the table by fetching the updated cart data
            function reloadTable() {
                $.ajax({
                    url: "{{ route('cart.index') }}",
                    method: "GET",
                    success: function(response) {
                        var tableBody = $(response).find('#cart-table tbody');
                        $('#cart-table tbody').html(tableBody.html());

                        var cartCount = $(response).find('#cart-notification-count').text();
                        $('#cart-notification-count').text(cartCount);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }

            // Attach click event to delete buttons
            $(document).on('click', '.delete-cart', function(e) {
                e.preventDefault();
                var cartId = $(this).data('cart-id');
                var quantity = $(this).closest('tr').find('input[name="quantity"]').val()
                deleteItem(cartId, quantity);
            });

            function placeOrder(address) {
                $.ajax({
                    url: "/placeOrder",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        address: address
                    },
                    success: function(response) {
                        if (response.hasOwnProperty('error')) {
                            toastr.error(response.error, 'Error');
                        } else {
                            reloadTable();
                            toastr.success(response.success, 'Success');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }

            $(document).on('click', '.PlaceOrder-Button', function(e) {
                e.preventDefault();
                var address = $('#address').val();
                placeOrder(address);
            });
        });
    </script>

@endsection
