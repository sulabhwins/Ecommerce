<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\AdminsRole;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
class ProductOrdersDetailsController extends Controller
{
    public function index()
    {
        $loggedInAdmin = Auth::guard('admin')->user();
        $productOrdersDetailsModuleCount = AdminsRole::where([
            'subadmin_id' => $loggedInAdmin->id,
            'module' => 'admin_orders'
        ])->count();
        if ($loggedInAdmin->type == "admin") {
            $orders = OrderDetail::whereHas('order')->with('order.address', 'product', 'order.user')->get();
        } else if ($productOrdersDetailsModuleCount == 0) {
            $message = "This feature is restricted for you";
            return redirect('admin/dashboard')->with('error_message', $message);
        } else {
            $orders = OrderDetail::with('order.address', 'product', 'order.user')->whereHas('product', function ($query) use ($loggedInAdmin) { $query->where('vender_id', $loggedInAdmin->id);})->get();
        }
        $pagesModule = [];
        if ($loggedInAdmin->type == "admin") {
            $pagesModule['view_access'] = 1;
            $pagesModule['edit_access'] = 1;
            $pagesModule['full_access'] = 1;
        } else if ($productOrdersDetailsModuleCount == 0) {
            $message = "This feature is restricted for you";
            return redirect('admin/dashboard')->with('error_message', $message);
        } else {
            $pagesModule = AdminsRole::where([
                'subadmin_id' => $loggedInAdmin->id,
                'module' => 'admin_orders'
            ])->first()->toArray();
        }
        return view('admin.order.order', compact('orders', 'pagesModule'));
    }
}