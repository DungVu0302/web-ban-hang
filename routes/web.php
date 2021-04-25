<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'App\Http\Controllers\HomeController@index');
Route::get('/trang-chu', 'App\Http\Controllers\HomeController@index');
Route::post('/tim-kiem', 'App\Http\Controllers\HomeController@search');

Route::get('/danh-muc-san-pham/{category_id}', 'App\Http\Controllers\CategoryProduct@show_category_home');
Route::get('/thuong-hieu-san-pham/{branch_id}', 'App\Http\Controllers\BranchProduct@show_branch_home');
Route::get('/chi-tiet-san-pham/{product_id}', 'App\Http\Controllers\ProductController@details_product');

//admin
Route::get('/Admin', 'App\Http\Controllers\AdminController@index');
Route::get('/dashboard', 'App\Http\Controllers\AdminController@show_dashboard');
Route::post('/admin-dashboard', 'App\Http\Controllers\AdminController@dashboard');
Route::get('/logout', 'App\Http\Controllers\AdminController@logout');

//Category product
Route::get('/add-category-product', 'App\Http\Controllers\CategoryProduct@add_category_product');
Route::get('/all-category-product', 'App\Http\Controllers\CategoryProduct@all_category_product');
Route::post('/save-category-product', 'App\Http\Controllers\CategoryProduct@save_category_product');
Route::get('/active-category-product/{category_product_id}', 'App\Http\Controllers\CategoryProduct@active_category_product');
Route::get('/unactive-category-product/{category_product_id}', 'App\Http\Controllers\CategoryProduct@unactive_category_product');
Route::get('/edit-category-product/{category_product_id}', 'App\Http\Controllers\CategoryProduct@edit_category_product');
Route::get('/delete-category-product/{category_product_id}', 'App\Http\Controllers\CategoryProduct@delete_category_product');
Route::post('/update-category-product/{category_product_id}', 'App\Http\Controllers\CategoryProduct@update_category_product');
//Branch product
Route::get('/add-branch-product', 'App\Http\Controllers\BranchProduct@add_branch_product');
Route::get('/all-branch-product', 'App\Http\Controllers\BranchProduct@all_branch_product');
Route::post('/save-branch-product', 'App\Http\Controllers\BranchProduct@save_branch_product');
Route::get('/active-branch-product/{branch_product_id}', 'App\Http\Controllers\BranchProduct@active_branch_product');
Route::get('/unactive-branch-product/{branch_product_id}', 'App\Http\Controllers\BranchProduct@unactive_branch_product');
Route::get('/edit-branch-product/{branch_product_id}', 'App\Http\Controllers\BranchProduct@edit_branch_product');
Route::get('/delete-branch-product/{branch_product_id}', 'App\Http\Controllers\BranchProduct@delete_branch_product');
Route::post('/update-branch-product/{branch_product_id}', 'App\Http\Controllers\BranchProduct@update_branch_product');
//Product
Route::get('/add-product', 'App\Http\Controllers\ProductController@add_product');
Route::get('/all-product', 'App\Http\Controllers\ProductController@all_product');
Route::post('/save-product', 'App\Http\Controllers\ProductController@save_product');
Route::get('/active-product/{product_id}', 'App\Http\Controllers\ProductController@active_product');
Route::get('/unactive-product/{product_id}', 'App\Http\Controllers\ProductController@unactive_product');
Route::get('/edit-product/{product_id}', 'App\Http\Controllers\ProductController@edit_product');
Route::get('/delete-product/{product_id}', 'App\Http\Controllers\ProductController@delete_product');
Route::post('/update-product/{product_id}', 'App\Http\Controllers\ProductController@update_product');
//cart
Route::post('/save-cart', 'App\Http\Controllers\CartController@save_cart');
Route::get('/show-cart', 'App\Http\Controllers\CartController@show_cart');
Route::get('/delete-to-cart/{rowId}', 'App\Http\Controllers\CartController@delete_to_cart');
Route::post('/update-cart-qty', 'App\Http\Controllers\CartController@update_cart_qty');
//chechout
Route::get('/login-checkout', 'App\Http\Controllers\CheckoutController@login_checkout');
Route::post('/add-customer', 'App\Http\Controllers\CheckoutController@add_customer');
Route::get('/checkout', 'App\Http\Controllers\CheckoutController@checkout');
Route::post('/save-checkout-customer', 'App\Http\Controllers\CheckoutController@save_checkout_customer');
Route::get('/payment', 'App\Http\Controllers\CheckoutController@payment');
Route::get('/logout-checkout', 'App\Http\Controllers\CheckoutController@logout_checkout');
Route::post('/login-customer', 'App\Http\Controllers\CheckoutController@login_customer');
Route::post('/order-place', 'App\Http\Controllers\CheckoutController@order_place');
//Order
Route::get('/manager-order', 'App\Http\Controllers\CheckoutController@manager_order');
Route::get('/view-order/{orderId}', 'App\Http\Controllers\CheckoutController@view_order');
Route::get('/manager-order', 'App\Http\Controllers\CheckoutController@manager_order');
