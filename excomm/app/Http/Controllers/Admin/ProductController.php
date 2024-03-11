<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Models\AdminsRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\CategorieController;
use App\Models\Categorie;

class ProductController extends Controller
{
    public function products()
{
    Session::put('page', 'products');

    $loggedInAdmin = Auth::guard('admin')->user();
    $productsModuleCount = AdminsRole::where([
        'subadmin_id' => $loggedInAdmin->id,
        'module' => 'admin_product'
    ])->count();

    if ($loggedInAdmin->type == "admin") {
        // If admin type is admin, show all products
        $products = Product::all();
    } else if ($productsModuleCount == 0) {
        $message = "This feature is restricted for you";
        return redirect('admin/dashboard')->with('error_massage', $message);
    } else {
        // If admin type is subadmin, show only their own products
        $products = Product::where('vender_id', $loggedInAdmin->id)->get();
    }

    $pagesModule = [];

    if ($loggedInAdmin->type == "admin") {
        $pagesModule = [
            'view_access' => 1,
            'edit_access' => 1,
            'full_access' => 1
        ];
    } else {
        $pagesModule = AdminsRole::where([
            'subadmin_id' => $loggedInAdmin->id,
            'module' => 'admin_product'
        ])->first()->toArray();
    }

    return view('admin.products.products')->with(compact('products', 'pagesModule'));
}

    public function edit(Request $request, $id = null)
    {
        $product = $id ? Product::findOrFail($id) : new Product();
        $categories = Categorie::all(); 
        $selectedCategoryId = $product->subcategory_id ?? null; 
        // dd($selectedCategoryId);

        $title = $id ? "Edit Product" : "Add Product";

        if ($request->isMethod('post')) {
            $data = $request->all();
            $product->fill($data);

            if ($request->hasFile('product_image')) {
                $image = $request->file('product_image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('images', $imageName, 'public');
                $product->product_image = $imageName;
            }
            $product->save();
            return redirect('admin/products')->with('success_message');
        }

        return view('admin.products.add_edit_product', compact('title', 'product', 'categories', 'selectedCategoryId'));
    }

    public function updateProductStatus(Request $request, Product $product )
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Product::where('id', $data['product_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'product_id' => $data['product_id']]);
        }
    }


    public function destroy($id)
    {
        Product::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Product deleted successfully!');
    }

    public function deleteImage($productId, $imageName)
    {
        $product = Product::find($productId);
        // dd($productId);
    
        if ($product) {
            if ($product->product_image == $imageName) {
                $product->product_image = null; 
                $product->save();
    
                Storage::disk('public')->delete('images/' . $imageName);
                return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Image not found']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Product not found']);
        }
    }
    

    public function getSubcategories($id)
    {
        // Assuming you have a Category model with a subcategories relationship
        $category = Categorie::with('subcategories')->find($id);

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $subcategories = $category->subcategories;
        // dd($subcategories);

        return response()->json($subcategories);
    }
}
