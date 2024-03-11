<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Product;
class UserCategoryController extends Controller
{

    public function index()
    {
        
        $categories = Categorie::all();

        return view('users.dashboard', compact('categories'));
    }

    // public function showProducts($categoryId)
    // {
    //     $products = Product::where('category_id', $categoryId)->get();

    //     return view('your.products.view', compact('products'));
    // }
}
