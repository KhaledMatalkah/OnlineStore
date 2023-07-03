// $(document).ready(function() {
//     // Delete Cart function
//     function deleteItem(cartId ,quantity) {
//         $.ajax({
//             url: "/cart/" + cartId,
//             method: "DELETE",
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//             data: {
//             quantity: quantity // Pass the quantity to be deleted
//         },
//             success: function(response) {
//                 if (response.error) {
//                     toastr.error(response.error, 'Error');
//                 } else {
//                     reloadTable();
//                     toastr.success('Product deleted from the cart successfully!');
//                 }
//                 // Reload the table after successful deletion
//             },
//             error: function(xhr, status, error) {
//             console.log(error);
//         }
//         });
//     }


//     function addItem(cartId ,quantity) {
//         $.ajax({
//             url: "/cart/" + cartId,
//             method: "POST",
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//             data: {
//             quantity: quantity // Pass the quantity to be deleted
//         },
//         success: function(response) {
//             if (response.error) {
//                 // Handle the error case
//                 toastr.error(response.error, 'Error');
//             } else {
//                 // Reload the table after successful addition
//                 reloadTable();
//                 // Show the success message
//                 toastr.success('Product added to the cart successfully!', 'Success');
//             }
//         },
//         error: function(xhr, status, error) {
//             console.log(error);
//         }
//     });
//     }

//     // Reload the table by fetching the updated cart data
//     function reloadTable() {
//         $.ajax({
//             url: "{{ route('cart.index') }}",
//             method: "GET",
//             success: function(response) {
//                 var tableBody = $(response).find('#cart-table tbody');
//                 $('#cart-table tbody').html(tableBody.html());

//                 var cartCount = $(response).find('#cart-notification-count').text();
//                 $('#cart-notification-count').text(cartCount);
//             },
//             error: function(xhr, status, error) {
//                 console.log(error);
//             }
//         });
//     }

//     // Attach click event to delete buttons
//     $(document).on('click', '.delete-cart', function(e) {
//         e.preventDefault();
//         var cartId = $(this).data('cart-id');
//         var quantity = $(this).closest('tr').find('input[name="quantity"]').val()
//         deleteItem(cartId, quantity);
//     });


//     $(document).on('click', '.add-to-cart', function(e) {
//         e.preventDefault();
//         var cartId = $(this).data('cart-id');
//         var quantity = $(this).closest('tr').find('input[name="quantity"]').val()
//         addItem(cartId, quantity);
//     });


//     function placeOrder(address){
//         $.ajax({
//             url: "/placeOrder",
//             method: "POST",
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//             data: {
//             address: address
//             },
//             success: function(response) {
//                 if (response.hasOwnProperty('error')) {
//                     toastr.error(response.error, 'Error');
//                 } else {
//                     reloadTable();
//                     toastr.success('Order has been placed successfully');
//                 }
//             },
//             error: function(xhr, status, error) {
//             console.log(error);
//         }
//         });
//     }

//     $(document).on('click', '.button-cart', function(e) {
//         e.preventDefault();
//         var address = $('#address').val();
//         placeOrder(address);
//     });
// });
