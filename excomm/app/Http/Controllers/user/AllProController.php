<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class AllProController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->query('category');
        $products = Product::where('category_id', $categoryId)->get();
        return view('users.allpro', ['products' => $products]);
    }
    public function single($id)
    {
        $product = Product::find($id);
        return view('users.single', ['product' => $product]);
    }
    public function addProductToCart(Request $request, $productId)
    {
        return redirect()->route('product.details', ['id' => $productId])->with('success', 'Product added to cart successfully');
    }
    public function shop(){
        $products = Product::all();
        return view('users.shop', ['products' => $products]);
    }
    
}
