@extends('welcome')
@section('content')

<div class="features_items">
    <!--features_items-->
    @foreach($branch_name as $name)
    <h2 class="title text-center">{{$name->branch_name}}</h2>
    @endforeach
    @foreach($branch_by_id as $key => $pro)

    <div class="col-sm-4">
        <div class="product-image-wrapper">
            <div class="single-products">
                <div class="productinfo text-center">
                    <img src="{{URL::to('/public/upload/product/'.$pro->product_image)}}" alt="" />
                    <h2>{{number_format($pro->product_price).' VNĐ'}}</h2>
                    <p>{{$pro->product_name}}</p>
                    <!-- <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a> -->
                </div>
                <div class="product-overlay">
                    <div class="overlay-content">
                        <h2>{{number_format($pro->product_price).' VNĐ'}}</h2>
                        <p>{{$pro->product_name}}</p>

                        <a href=" {{URL::to('/chi-tiet-san-pham/'.$pro->product_id)}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Xem chi tiết</a>
                        <!-- <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a> -->
                    </div>
                </div>
            </div>
            <div class="choose">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
                    <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                </ul>
            </div>
        </div>
    </div>

    @endforeach
</div>
<!--  -->
@endsection