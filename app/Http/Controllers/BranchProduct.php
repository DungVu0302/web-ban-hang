<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Session;
use Illuminate\Support\Facades\Redirect;

session_start();
class BranchProduct extends Controller
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
    public function add_branch_product()
    {
        $this->AuthLogin();
        return view('admin.add_branch_product');
    }
    public function all_branch_product()
    {
        $this->AuthLogin();
        $all_branch_product = DB::table('tbl_branch')->orderby('branch_id', 'desc')->get();
        $manager_branch_product = view('admin.all_branch_product')->with('all_branch_product', $all_branch_product);
        return view('admin_layout')->with('admin.all_branch_product', $manager_branch_product);
    }
    public function save_branch_product(Request $request)
    {
        $this->AuthLogin();
        $data = array();
        $data['branch_name'] = $request->branch_product_name;
        $data['branch_desc'] = $request->branch_product_desc;
        $data['branch_status'] = $request->branch_product_status;

        DB::table('tbl_branch')->insert($data);
        Session::put('message', 'Thêm thương hiệu thành công');
        return Redirect::to('add-branch-product');
    }
    public function unactive_branch_product($branch_product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_branch')->where('branch_id', $branch_product_id)->update(['branch_status' => 1]);
        return Redirect::to('all-branch-product');
    }
    public function active_branch_product($branch_product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_branch')->where('branch_id', $branch_product_id)->update(['branch_status' => 0]);
        return Redirect::to('all-branch-product');
    }
    public function edit_branch_product($branch_product_id)
    {
        $this->AuthLogin();
        $edit_branch_product = DB::table('tbl_branch')->where('branch_id', $branch_product_id)->get();
        $manager_branch_product = view('admin.edit_branch_product')->with('edit_branch_product', $edit_branch_product);
        return view('admin_layout')->with('admin.edit_branch_product', $manager_branch_product);
    }
    public function update_branch_product(Request $request, $branch_product_id)
    {
        $this->AuthLogin();
        $data = array();
        $data['branch_name'] = $request->branch_product_name;
        $data['branch_desc'] = $request->branch_product_desc;
        DB::table('tbl_branch')->where('branch_id', $branch_product_id)->update($data);
        return Redirect::to('all-branch-product');
    }
    public function delete_branch_product($branch_product_id)
    {
        $this->AuthLogin();
        DB::table('tbl_branch')->where('branch_id', $branch_product_id)->delete();
        return Redirect::to('all-branch-product');
    }
    public function show_branch_home($branch_id)
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status', 1)->orderby('category_id', 'desc')->get();
        $branch_product = DB::table('tbl_branch')->where('branch_status', 1)->orderby('branch_id', 'desc')->get();

        $branch_name = DB::table('tbl_branch')->where('tbl_branch.branch_id', $branch_id)->limit(1)->get();
        $branch_by_id = DB::table('tbl_product')
            ->join('tbl_branch', 'tbl_branch.branch_id', '=', 'tbl_product.branch_id')->where('tbl_product.branch_id', $branch_id)
            ->orderby('tbl_product.product_id', 'desc')->get();
        return view('pages.branch.show_branch')->with('category', $cate_product)->with('branch', $branch_product)->with('branch_by_id', $branch_by_id)->with('branch_name', $branch_name);
    }
}
