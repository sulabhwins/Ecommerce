<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Address;

class CartController extends Controller
{
    public function index()
    {
        $savedAddresses = Auth::user()->addresses;
        $cartCount = Cart::getCartCountForLoggedInUser();
    
        $cart = Cart::where('user_id', Auth::user()->id)->with('product')->get();
        $totalAmount = $this->calculateTotalAmount($cart);
    
        return view('users.cart', compact('cart', 'totalAmount', 'savedAddresses', 'cartCount'));
        // return view('users.cart', compact('cart', 'totalAmount', 'savedAddresses'));
    }
    
    public function store(Request $request)
    {
        Cart::create([
            'product_id' => $request->product_id,
            'user_id' => Auth::user()->id,
            'quantity' => $request->quantity
        ]);

        return redirect()->route('shop')->with('add', 'Add to cart successfully');
    }

    public function delete($id)
    {
        $cart = Cart::where('id', $id)->first();

        if ($cart) {
            $cart->delete();
            return redirect()->back()->with('delete', 'Cart item deleted successfully');
        } else {
            return redirect()->back()->with('delete', 'Cart item not found');
        }
    }

    public function updateCart(Request $request)
    {
        try {
            $product_id = $request->input('product_id');
            $newQuantity = $request->input('quantity');

            $cartProduct = Cart::find($product_id);

            if ($cartProduct) {
                $cartProduct->quantity = $newQuantity;
                $cartProduct->save();

                return response()->json(['success' => true, 'message' => 'Cart updated successfully']);
            } else {
                return response()->json(['success' => false, 'message' => "Cart product with ID $product_id not found"]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function calculateTotalAmount($cart)
    {
        $totalAmount = 0;

        foreach ($cart as $cartProduct) {
            $totalAmount += $cartProduct->product->saling_price * $cartProduct->quantity;
        }

        return $totalAmount;
    }

}
