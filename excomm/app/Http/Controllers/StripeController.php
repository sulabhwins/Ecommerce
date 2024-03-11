<?php
   
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;
use Session;
use Stripe;
   
class StripeController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        $savedAddresses = Auth::user()->addresses;
        return view('users.chackout',compact('savedAddresses',));
    }
  
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // Perform the Stripe payment
        Stripe\Charge::create([
            "amount" => FacadesSession::get('totalAmount') * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Test payment from tutsmake.com."
        ]);


        $user = Auth::user();
        $order = Order::create([
            'user_id' => $user->id,
            'address_id' => $user->address->id,
        ]);

        // Move cart items to order details
        $carts = Cart::where('user_id', $user->id)->with('product')->get();
        
// dd($carts->toArray());
        foreach ($carts as $cart) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'product_name' => $cart->product->name,
                'price' => $cart->product->saling_price,
                'quantity' => $cart->quantity,
            ]);
        }

        // Clear the cart
        Cart::where('user_id', $user->id)->delete();

        // Flash success message
        FacadesSession::flash('success', 'Payment successful! Order placed.');
        return redirect()->route('home');
    }
}