@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Chỉnh sửa thương hiệu sản phẩm
            </header>
            <div class="panel-body">
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo $message;
                    Session::put('message', null);
                }
                ?>
                @foreach($edit_branch_product as $key => $edit_value)
                <div class="position-center">
                    <form role="form" action="{{URL::to('/update-branch-product/'.$edit_value->branch_id)}}" method="post">
                        {{ csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên thương hiệu</label>
                            <input type="text" value="{{$edit_value->branch_name}}" name="branch_product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên thương hiệu">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả thương hiệu</label>
                            <textarea style="resize: none;" rows="8" class="form-control" name="branch_product_desc" id="exampleInputPassword1">{{$edit_value->branch_desc}}</textarea>
                        </div>


                        <button type="submit" name="update_branch_product" class="btn btn-info">Cập nhật</button>
                    </form>
                </div>
                @endforeach
            </div>
        </section>
    </div>
    @endsection