<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    protected $cartCount;

    // public function __construct()
    // {
    //     $this->cartCount = 0;

    //     if (Auth::check()) {
    //         $this->cartCount = Cart::getCartCountForLoggedInUser();
    //     }

    //     view()->share('cartCount', $this->cartCount);
    // }
}
