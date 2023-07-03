$(document).ready(function() {
    // Delete product function
    function addCategory() {
      $.ajax({
        url: "/category/add",
        method: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            reloadCards(response);
            toastr.success('Category added successfully!');
        }
      });
    }

    // Reload the product cards by fetching the updated page content
    function reloadCards(response) {
      $.ajax({
        url: window.location.href,
        method: "GET",
        success: function(response) {
          var categoryContainer = $('.li');
          categoryContainer.html($(response).find('.li').html());
        }
      });
    }
  });
