$(function() {
    $('.add-to-cart-form').on('submit', function(event) {
        event.preventDefault();

        var form = $(this);
        var productId = form.find('input[name="product_id"]').val();
        var quantity = form.find('input[name="quantity"]').val();

        // Send an AJAX request to add the product to the cart
        $.ajax({
            url: '/cart/add',
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                toastr.success('Product added to cart successfully!');
            },
            error: function(response) {
                window.location.href = '/login';
            }
        });
    });
});
