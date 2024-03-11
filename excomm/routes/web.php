<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\User\UserCategoryController;
use App\Http\Controllers\User\AllProController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\ProductOrdersDetailsController;
use App\Http\Controllers\OrderDetailsController;

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    Route::match(['get', 'post'], 'login', [AdminController::class, 'login']);
    Route::group(['middleware' => ['admin']], function () {
        Route::get('dashboard', [AdminController::class, 'dashboard']);
        Route::get('update-password', [AdminController::class, 'updatePassword']);
        Route::post('processUpdatePassword', [AdminController::class, 'processUpdatePassword']);
        Route::post('check-current-password', [AdminController::class, 'checkCurrentPassword']);
        Route::get('update-admin-details', [AdminController::class, 'updateAdminDetails']);
        Route::post('process-update-details', [AdminController::class, 'processUpdateDetails'])->name('admin.processUpdateDetails');
        Route::get('logout', [AdminController::class, 'logout']);
        //CURD Cms
        Route::get('cms-pages', [CmsController::class, 'index']);
        Route::post('update-cms-page-status', [CmsController::class, 'update']);
        Route::match(['get', 'post'], 'add-edit-cms-page/{id?}', [CmsController::class, 'edit']);
        Route::get('delete-cms-page/{id?}', [CmsController::class, 'destroy']);
        //Sub Admins
        Route::get('subadmins', [AdminController::class, 'sabAdmins']);
        Route::post('update-subadmin-status', [AdminController::class, 'updateSubAdminStatus']);
        Route::match(['get', 'post'], 'add-edit-subadmin/{id?}', [AdminController::class, 'editSubAdmin']);
        Route::get('delete-subadmin/{id?}', [AdminController::class, 'destroySubAdmin']);
        Route::match(['get', 'post'], 'update-role/{id}', [AdminController::class, 'updateRole']);
        //Categories
        Route::get('categories', [CategorieController::class, 'categories']);
        Route::post('update-category-status', [CategorieController::class, 'update']);
        Route::match(['get', 'post'], 'add-edit-category/{id?}', [CategorieController::class, 'edit']);
        Route::get('delete-category/{id?}', [CategorieController::class, 'destroy']);
        Route::delete('add-edit-category/{categoryId}/delete-image/{imageName}', [CategorieController::class, 'deleteImage'])->name('category.deleteImage');
        //Products
        Route::get('products', [ProductController::class, 'products']);
        Route::post('update-product-status', [ProductController::class, 'updateProductStatus']);
        Route::match(['get', 'post'], 'add-edit-product/{id?}', [ProductController::class, 'edit']);
        Route::get('delete-product/{id?}', [ProductController::class, 'destroy']);
        Route::get('get-subcategories/{id}', [ProductController::class, 'getSubcategories']);
        Route::delete('add-edit-product/{productId}/delete-image/{imageName}', [ProductController::class, 'deleteImage'])->name('product.deleteImage');
        //Order Details
        Route::get('/orderdetails', [ProductOrdersDetailsController::class, 'index'])->name('order.detail.admin');
    });
});
Route::get('/', [UserCategoryController::class, 'index'])->name('home');
Route::get('/allpro', [AllProController::class, 'index'])->name('allpro');
Route::get('/shop', [AllProController::class, 'shop'])->name('shop');
Route::get('/product/{id}', [AllProController::class, 'single'])->name('users.single');
Route::get('/register', [LoginController::class, 'register'])->name('user-register');
Route::post('/register', [LoginController::class, 'store']);
Route::get('/login', [LoginController::class, 'index'])->name('user-login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/user-logout', [LoginController::class, 'logout'])->name('user-logout');

Route::middleware(['auth.check'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{productId}', [AllProController::class, 'addProductToCart'])->name('cart.add');
    Route::post('/add-cart', [CartController::class, 'store'])->name('add-cart');
    Route::delete('/delete-cart/{id}', [CartController::class, 'delete'])->name('delete-cart');
    Route::post('/update-cart', [CartController::class, 'updateCart'])->name('update-cart');
    Route::get('/stripe', [StripeController::class, 'stripe'])->name('stripe');
    Route::post('/stripe', [StripeController::class, 'stripePost'])->name('stripe.post');
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/addresses/{id}/edit', [AddressController::class, 'editAddress'])->name('addresses.edit');
    Route::put('/addresses/{id}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{id}', [AddressController::class, 'destroyAddress'])->name('addresses.destroy');
    Route::post('/process-addresses', [AddressController::class, 'processAddresses'])->name('process.addresses');
    Route::get('/orders', [OrderDetailsController::class, 'index'])->name('orders.index');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/order/{id}', [OrderDetailsController::class, 'show'])->name('order.detail');
});
