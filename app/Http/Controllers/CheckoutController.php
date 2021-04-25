<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Session;
use Illuminate\Support\Facades\Redirect;
use Cart;

class CheckoutController extends Controller
{
    public function AuthLogin()
    {
        $admin_id = Session::get('admin_id');
        if ($admin_id) {
            return Redirect::to('dashboar');
        } else {
            return Redirect::to('Admin')->send();
        }
    }
    public function login_checkout()
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status', 1)->orderby('category_id', 'desc')->get();
        $branch_product = DB::table('tbl_branch')->where('branch_status', 1)->orderby('branch_id', 'desc')->get();
        return view('pages.checkout.login_checkout')->with('category', $cate_product)->with('branch', $branch_product);
    }
    public function add_customer(Request $request)
    {
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_pass);
        $data['customer_phone'] = $request->customer_phone;


        $customer_id = DB::table('tbl_customer')->insertGetId($data);

        Session::put('customer_id', $customer_id);
        Session::put('customer_name', $request->customer_name);
        return Redirect('/checkout');
    }
    public function checkout()
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status', 1)->orderby('category_id', 'desc')->get();
        $branch_product = DB::table('tbl_branch')->where('branch_status', 1)->orderby('branch_id', 'desc')->get();
        return view('pages.checkout.show_checkout')->with('category', $cate_product)->with('branch', $branch_product);
    }
    public function save_checkout_customer(Request $request)
    {
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_notes'] =  $request->shipping_notes;

        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

        Session::put('shipping_id',  $shipping_id);

        return Redirect('/payment');
    }
    public function payment()
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status', 1)->orderby('category_id', 'desc')->get();
        $branch_product = DB::table('tbl_branch')->where('branch_status', 1)->orderby('branch_id', 'desc')->get();
        return view('pages.checkout.payment')->with('category', $cate_product)->with('branch', $branch_product);
    }
    public function logout_checkout()
    {
        Session::flush();
        return Redirect('/login-checkout');
    }
    public function login_customer(Request $request)
    {
        $email = $request->email;
        $pass = md5($request->password);
        $result = DB::table('tbl_customer')->where('customer_email', $email)->where('customer_password', $pass)->first();
        if ($result) {
            Session::put('customer_id', $result->customer_id);
            return Redirect::to('/checkout');
        } else {
            return Redirect::to('/login-checkout');
        }
    }
    public function order_place(Request $request)
    {
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lý';

        $payment_id = DB::table('tbl_payment')->insertGetId($data);

        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] =  $payment_id;
        $order_data['order_total'] =  Cart::total();
        $order_data['order_status'] =  'Đabg chờ xử lý';

        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        $content = Cart::content();
        foreach ($content as $v_content) {
            $order_d_data = array();
            $order_d_data['order_id'] =  $order_id;
            $order_d_data['product_id'] = $v_content->id;
            $order_d_data['product_name'] = $v_content->name;
            $order_d_data['product_price'] =  Cart::total();
            $order_d_data['product_sales_quantity'] = $v_content->qty;

            $rusult = DB::table('tbl_order_details')->insert($order_d_data);
        }
        if ($data['payment_method'] == 1) {
            echo 'ATM';
        } else {
            Cart::destroy();
            $cate_product = DB::table('tbl_category_product')->where('category_status', 1)->orderby('category_id', 'desc')->get();
            $branch_product = DB::table('tbl_branch')->where('branch_status', 1)->orderby('branch_id', 'desc')->get();
            return view('pages.checkout.handcash')->with('category', $cate_product)->with('branch', $branch_product);
        }
    }
    public function manager_order()
    {
        $this->AuthLogin();

        $all_order = DB::table('tbl_order')
            ->join('tbl_customer', 'tbl_order.customer_id', '=', 'tbl_customer.customer_id')
            ->select('tbl_order.*', 'tbl_customer.customer_name')
            ->orderby('tbl_order.order_id', 'desc')->get();
        $manager_order = view('admin.manager_order')->with('all_order', $all_order);

        return view('admin_layout')->with('admin.manager_order', $manager_order);
    }
    public function view_order($orderId)
    {
        $this->AuthLogin();
        $order_by_id = DB::table('tbl_order')
            ->join('tbl_customer', 'tbl_order.customer_id', '=', 'tbl_customer.customer_id')
            ->join('tbl_shipping', 'tbl_order.shipping_id', '=', 'tbl_shipping.shipping_id')
            ->join('tbl_order_details', 'tbl_order.order_id', '=', 'tbl_order_details.order_id')
            ->select('tbl_order.*', 'tbl_customer.*', 'tbl_shipping.*', 'tbl_order_details.*')
            ->first();


        $manager_order_by_id = view('admin.view_order')->with('order_by_id', $order_by_id);
        return view('admin_layout')->with('admin.view_order', $manager_order_by_id);
    }
}
