<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $cartCount = 0;

            if (Auth::check()) {
                $userId = Auth::id();
                $cartCount = Cart::where('user_id', $userId)->count();
            }

            $view->with('cartCount', $cartCount);
        });
    }
}
