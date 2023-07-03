$(document).ready(function() {
      // Delete product function
      function deleteProduct(productId, card) {
        $.ajax({
          url: "/products/" + productId,
          method: "DELETE",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(response) {
            console.log(response);
            toastr.success('Product Deleted successfully!');
            card.remove();
          }
        });
      }

      // Reload the product cards by fetching the updated page content
      function reloadCards() {
        $.ajax({
          url: window.location.href,
          method: "GET",
          success: function(response) {
            var cardContainer = $('.row');
            cardContainer.html($(response).find('.row').html());
          }
        });
      }

      // Attach click event to delete buttons
      $(document).on('click', '.delete-product', function(e) {
        e.preventDefault();
        var productId = $(this).data('product-id');
        var card = $(this).closest('.col-md-3');
        deleteProduct(productId, card);
        reloadCards();
      });
    });
