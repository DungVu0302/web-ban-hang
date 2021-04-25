@extends('welcome')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
                <li class="active">Thanh toán giỏ hàng</li>
            </ol>
        </div>

        <div class="review-payment">
            <h2>Xem lại giỏ hàng</h2>
        </div>
        <div class="table-responsive cart_info">
            <?php
            $content = Cart::content();

            ?>
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td class="description">Mô tả</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Tổng tiền</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($content as $v_content)
                    <tr>
                        <td class="cart_product">
                            <img src="{{{'public/upload/product/'.$v_content->options->image}}}" alt="" width="50" />
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$v_content->name}}</a></h4>
                            <p>ID: {{$v_content->id}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($v_content->price).' VNĐ'}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <form action="{{URL::to('/update-cart-qty')}}" method="post">
                                    {{csrf_field()}}
                                    <input class="cart_quantity_input" type="number" min="1" name="quantity" value="{{$v_content->qty}}" autocomplete="off" size="2">
                                    <input type="hidden" value="{{$v_content->rowId}}" name="rowId_cart" class="btn btn-default btn-sm">
                                    <input type="submit" value="Cập nhật" name="update_qty" class="btn btn-default btn-sm">
                                </form>

                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">
                                <?php
                                $subtotal = $v_content->price * $v_content->qty;
                                echo number_format($subtotal) . ' VNĐ';

                                ?>
                            </p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <h4 style="margin:40px 0;font-size:20px">Chọn hình thức thanh toán</h4>
        <form action="{{URL::to('/order-place')}}" method="post">
            {{csrf_field()}}
            <div class="payment-options">
                <span>
                    <label><input name="payment_option" value="1" type="checkbox"> Trả thẻ ATM </label>
                </span>
                <span>
                    <label><input name="payment_option" value="2" type="checkbox"> Tiền mặt </label>
                </span>
                <input type="submit" value="Đặt hàng" name="send_order_place" class="btn btn-primary btn-sm">
                <!-- <span>
                <label><input type="checkbox"> Paypal</label>
            </span> -->
            </div>
        </form>

    </div>
</section>
<!--/#cart_items-->

@endsection