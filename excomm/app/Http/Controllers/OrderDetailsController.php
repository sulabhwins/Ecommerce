<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderDetailsController extends Controller
{
    public function index()
    {
        $orders = OrderDetail::whereHas('order' , function($q){
            $q->where('user_id',Auth::user()->id);
        })->with('order.address','product')->get();
        return view('users.order', compact('orders'));
    }
    public function show($id)
    {
        $order = OrderDetail::findOrFail($id);
        $product = $order->product; // Assuming you have a relationship named 'product' in your Order model
    
        return view('users.detail', compact('order', 'product'));
    }
    
}
