$(document).ready(function() {
    $('.add-to-cart-form').on('submit', function(event) {
        event.preventDefault();

        var form = $(this);

        // Send an AJAX request to add the product to the cart
        $.ajax({
          url: '/cart/add',
          method: 'POST',
          data: form.serialize(),
          success: function(response) {
            if (response.hasOwnProperty('error')) {
              toastr.error(response.error);
            } else {
              // Fetch the updated cart data
              $.ajax({
                url: '/cart/count',
                method: 'GET',
                success: function(cartData) {
                  // Update the cart view with the new data
                  updateCartView(cartData);
                  toastr.success('Product added to cart successfully!');
                },
                error: function() {
                  toastr.error('An error occurred while fetching the updated cart count.');
                }
              });
            }
          },
          error: function(xhr, status, error) {
            if (xhr.status === 401) {
              window.location.href = '/login';
            } else {
              toastr.error('An error occurred while adding the product to cart');
            }
          }
        });
      });



    function updateCartView(cartData) {
      // Update the cart count
      var cartCount = cartData.cartItemCount;
      $('#cart-notification-count').text(cartCount);
    }
  });
