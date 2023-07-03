<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{-- <link rel="stylesheet" href="resources/css/btn.css"> --}}
    <link href="{{ asset('css/btn.css') }}" rel="stylesheet">

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/css/app-blade.css', 'resources/css/cart.css', 'resources/js/app.js', 'resources/js/Plus-Minus.js', 'resources/css/btn.css', 'resources/css/btn-add.css', 'resources/css/btn-edit.css', 'resources/css/btn-delete.css', 'resources/js/deleteButton.js', 'resources/js/slider.js', 'resources/js/cartCount.js', 'resources/js/addCategory.js', 'resources/js/PlaceOrder.js', 'resources/css/products.css', 'resources/css/category.css'])
</head>

<body style="background-color: #93cae873;">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background-color: #173459">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('logo/logo.png') }}" alt="Logo" height="70" style="float: left;" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            @auth
                                @if (auth()->user()->hasRole('admin'))
                                    <a class="nav-link" href="{{ route('products.create') }}">Add Product</a>
                                @endif
                            @endauth
                        </li>
                        <li class="nav-item">
                            @auth
                                @if (auth()->user()->hasRole('admin'))
                                    <a class="nav-link" href="{{ route('category.add') }}">Add Category</a>
                                @endif
                            @endauth
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.admin') }}">All Products</a>
                        </li>
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <li id="cart-notification" style="color: gold;">
                            <div id="toast" class="toast-top-right">
                                <a href="{{ route('cart.index') }}" style="color: gold;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-cart-check-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M0.5 1a0.5 0.5 0 0 1 0 1H1.11l0.401 1.607 1.498 7.985A0.5 0.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a0.5 0.5 0 0 0 .491-0.408l1.5-8A0.5 0.5 0 0 0 14.5 3H2.89l-0.405-1.621A0.5 0.5 0 0 0 2 1H0.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1.646-7.646-3 3a0.5 0.5 0 0 1-.708 0l-1.5-1.5a0.5 0.5 0 1 1 .708-0.708L8 8.293l2.646-2.647a0.5 0.5 0 0 1 .708 0.708z" />
                                    </svg>
                                </a>
                                <span id="cart-notification-count" class="cart-count">@auth
                                        {{ $cartItemCount }}
                                    @endauth
                                </span>
                            </div>
                        </li>
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4" style="font-size: 16px;">
            @yield('content')
        </main>
    </div>
    <footer class="footer">
        <div class="container">
            <p>&copy; 2023 Your Company. All rights reserved.</p>
            <p>
                <a href="#">Terms of Service</a> |
                <a href="#">Privacy Policy</a>
            </p>
        </div>
    </footer>
    <script>
        // Listen for the change event on the category dropdown
        document.getElementById('category').addEventListener('change', function() {
            var categoryId = this.value; // Get the selected category ID
            filterProductsByCategoryId(categoryId); // Call the filtering function with the selected category ID
        });

        function filterProductsByCategoryId(categoryId) {
            // Make an AJAX request or perform any desired action here,
            // such as submitting the form with the selected category ID.
            // You can use frameworks like Axios or jQuery for AJAX requests.

            // Example AJAX request using Axios:
            axios.post('/filter-products', {
                    categoryId: categoryId
                })
                .then(function(response) {
                    console.log(response.data); // Process the received data or update the UI accordingly
                })
                .catch(function(error) {
                    console.error(error);
                });
        }
    </script>
</body>

</html>
