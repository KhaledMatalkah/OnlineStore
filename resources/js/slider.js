    $(document).ready(function() {
        // Initialize the carousel
        $('#product-slider').carousel();

        // Pause the carousel on hover
        $('#product-slider').hover(function() {
            $(this).carousel('pause');
        }, function() {
            $(this).carousel('cycle');
        });
        setInterval(function() {
            $('#product-slider').carousel('next');
        }, 3000);
    });
