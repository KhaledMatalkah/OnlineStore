// $(document).on('click', '.decrease-quantity', function(e) {
//     e.preventDefault();
//     var quantityInput = $(this).closest('td').find('.quantity-input');
//     var quantity = parseInt(quantityInput.val());

//     if (quantity > 1) {
//         quantity -= 1;
//         quantityInput.val(quantity);
//         updateCartQuantity($(this).data('cart-id'), quantity);
//     } else {
//         toastr.error('You have reached the minimum limit of the product quantity!', 'Error');
//     }
// });

// $(document).on('click', '.increase-quantity', function(e) {
//     e.preventDefault();

//     var quantityInput = $(this).closest('td').find('.quantity-input');
//     var quantity = parseInt(quantityInput.val());
//     var cartId = $(this).data('cart-id');
//     var maxQuantity = parseInt($('#max_quantity_' + cartId).val()); // Get the maxQuantity value

//     if (quantity < maxQuantity) {
//         quantity += 1;
//         quantityInput.val(quantity);
//         updateCartQuantity(cartId, quantity); // Use cartId instead of $(this).data('cart-id')
//     } else {
//         toastr.error('You have reached the maximum limit of the product quantity!', 'Error');
//     }
// });





// function updateCartQuantity(cartId, quantity) {
//     $.ajax({
//         url: "/cart/" + cartId,
//         method: "POST",
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         data: {
//             quantity: quantity
//         },
//         success: function(response) {
//             if (response.error) {
//                 toastr.error(response.error, 'Error');
//                 // Reset the quantity input
//                 reloadTable();
//             } else {
//                 // Update the quantity in the cartItems table
//                 // Show the success message
//                 toastr.success(response.success, 'Success');
//                 reloadTable();
//             }
//         },
//         error: function(xhr, status, error) {
//             console.log(error);
//         }
//     });
// }






// // Delete Cart function
// function deleteItem(cartId, quantity) {
//     $.ajax({
//         url: "/cart/" + cartId,
//         method: "DELETE",
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         data: {
//             quantity: quantity // Pass the quantity to be deleted
//         },
//         success: function(response) {
//             if (response.error) {
//                 toastr.error(response.error, 'Error');
//             } else {
//                 reloadTable();
//                 toastr.success(response.success, 'success');
//             }
//             // Reload the table after successful deletion
//         },
//         error: function(xhr, status, error) {
//             console.log(error);
//         }
//     });
// }

// // Reload the table by fetching the updated cart data
// function reloadTable() {
//     $.ajax({
//         url: "{{ route('cart.index') }}",
//         method: "GET",
//         success: function(response) {
//             var tableBody = $(response).find('#cart-table tbody');
//             $('#cart-table tbody').html(tableBody.html());

//             var cartCount = $(response).find('#cart-notification-count').text();
//             $('#cart-notification-count').text(cartCount);
//         },
//         error: function(xhr, status, error) {
//             console.log(error);
//         }
//     });
// }

// // Attach click event to delete buttons
// $(document).on('click', '.delete-cart', function(e) {
//     e.preventDefault();
//     var cartId = $(this).data('cart-id');
//     var quantity = $(this).closest('tr').find('input[name="quantity"]').val()
//     deleteItem(cartId, quantity);
// });

// function placeOrder(address) {
//     $.ajax({
//         url: "/placeOrder",
//         method: "POST",
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         data: {
//             address: address
//         },
//         success: function(response) {
//             if (response.hasOwnProperty('error')) {
//                 toastr.error(response.error, 'Error');
//             } else {
//                 reloadTable();
//                 toastr.success(response.success, 'Success');
//             }
//         },
//         error: function(xhr, status, error) {
//             console.log(error);
//         }
//     });
// }

// $(document).on('click', '.PlaceOrder-Button', function(e) {
//     e.preventDefault();
//     var address = $('#address').val();
//     placeOrder(address);
// });
