<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Session;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    //
    public function index()
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status', 1)->orderby('category_id', 'desc')->get();
        $branch_product = DB::table('tbl_branch')->where('branch_status', 1)->orderby('branch_id', 'desc')->get();

        $all_product = DB::table('tbl_product')->where('product_status', 1)->orderby('product_id', 'desc')->limit(4)->get();

        return view('pages.home')->with('category', $cate_product)->with('branch', $branch_product)->with('all_product', $all_product);
    }
    public function search(Request $request)
    {

        $keywords = $request->keywords_submit;
        $cate_product = DB::table('tbl_category_product')->where('category_status', 1)->orderby('category_id', 'desc')->get();
        $branch_product = DB::table('tbl_branch')->where('branch_status', 1)->orderby('branch_id', 'desc')->get();

        $search_product = DB::table('tbl_product')->where('product_name', 'like', '%' . $keywords . '%')->get();

        return view('pages.product.search')->with('category', $cate_product)->with('branch', $branch_product)->with('search_product', $search_product);
    }
}
