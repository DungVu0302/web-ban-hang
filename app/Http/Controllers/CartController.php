<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Session;
use Illuminate\Support\Facades\Redirect;
use Cart;

class CartController extends Controller
{
    public function save_cart(Request $request)
    {

        $product_id = $request->productid_hidden;
        $quantity = $request->qty;


        $product_info = DB::table('tbl_product')->where('product_id', $product_id)->first();

        $data['id'] = $product_info->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] = '0';
        $data['options']['image'] = $product_info->product_image;
        Cart::add($data);

        return Redirect::to('/show-cart');
    }
    public function show_cart()
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status', 1)->orderby('category_id', 'desc')->get();
        $branch_product = DB::table('tbl_branch')->where('branch_status', 1)->orderby('branch_id', 'desc')->get();
        return view('pages.cart.show_cart')->with('category', $cate_product)->with('branch', $branch_product);
    }
    public function delete_to_cart($rowId)
    {
        Cart::update($rowId, 0);
        return Redirect::to('/show-cart');
    }
    public function update_cart_qty(Request $request)
    {
        $rowId = $request->rowId_cart;
        $qty = $request->quantity;
        Cart::update($rowId, $qty);
        return Redirect::to('/show-cart');
    }
}
