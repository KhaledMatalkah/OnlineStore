<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\CartItem;
use Illuminate\Support\Facades\View;

class ViewComposersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('app', function ($view) {
            // Retrieve the cart item count for the authenticated user
            $cartItemCount = 0;
            if (Auth::check()) {
                $userId = Auth::id();
                $cartItemCount = CartItem::where('user_id', $userId)->count();
            }

            // Share the cart item count with the view
            $view->with('cartItemCount', $cartItemCount);
        });
    }
}
