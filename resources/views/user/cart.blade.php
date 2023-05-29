@extends('welcome')
@section('content')
<link rel="stylesheet" href="./frontend/css/cart.css">
<?php
     use Gloudemans\Shoppingcart\Facades\Cart;
    $content =   Cart::content();
?>
<!-- thanh "danh muc sach" đã được ẩn bên trong + hotline + ho tro truc tuyen -->
<section class="duoinavbar">
        <div class="container text-white">
            <div class="row justify">
                <div class="col-lg-3 col-md-5">
                    <div class="categoryheader">
                        <div class="noidungheader text-white">
                            <i class="fa fa-bars"></i>
                            <span class="text-uppercase font-weight-bold ml-1">Danh mục</span>
                        </div>
                        <!-- CATEGORIES -->
                    <div class="categorycontent" >
                        <ul >
                            @foreach($categories as $cate)
                            @if($cate -> parent == 0)
                            <li> 
                                <!--<img style="padding-left:10px" src="./frontend/images/{{$cate->url_image}}"></img>-->
                                <a href="./danh-muc-san-pham/19">{{$cate->name}}</a><i class="fa fa-chevron-right float-right">
                                </i>
                                <ul>
                                    @foreach($categories as $categ)
                                    @if($categ->parent == $cate->id)
                                    <li class="liheader"><a href="{{URL::to('/danh-muc-san-pham/'.$categ->id)}}" class="header text-uppercase">{{$categ->name}}</a></li>
                                    @endif
                                    @endforeach
                                                                        
                                </ul>
                            </li>
                            @endif
                            @endforeach
                            <li> 
                                <!--<img style="padding-left:10px" src="./frontend/images/{{$cate->url_image}}"></img>-->
                                <a href="{{URL::to('/goc-suc-khoe')}}">Góc sức khỏe</a>
                            </li>
                        </ul>
                    </div>
                    </div>
                </div>
                <div class="col-md-5 ml-auto contact d-none d-md-block">
                    <div class="benphai float-right">
                        <div class="hotline">
                            <i class="fa fa-phone"></i>
                            <span>Hotline:<b>1900 1999</b> </span>
                        </div>
                        <i class="fas fa-comments-dollar"></i>
                        <a href="#">Hỗ trợ trực tuyến </a>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- giao diện giỏ hàng  -->
<section class="content my-3">
        <div class="container">
            <div class="cart-page bg-white">
                <div class="row">
                    
                    @if(Cart::count() == 0)
                    <!-- giao diện giỏ hàng khi không có item   -->
                    <div class="col-md-8 cart" style="margin-left:170px">
                        <div class="py-3 pl-3">
                            <h6 class="header-gio-hang" style="margin-left:-170px">GIỎ HÀNG CỦA BẠN <span>(0 sản phẩm)</span></h6>
                            <div class="cart-empty-content w-100 text-center justify-content-center">
                                <img src="{{asset('frontend/images/no_items_found.jpg')}}" alt="shopping-cart-not-product" width="200px">
                                <p>Chưa có sản phẩm nào trong giỏ hàng của bạn</p>
                                <a href="{{URL::to('/')}}" class="btn nutmuathem mb-3">Mua thêm</a>
                            </div>
                        </div>
                    </div>
                    @else
                    <!-- giao diện giỏ hàng khi có hàng  -->
                    
                    <div class="col-md-8 cart">
                        <div class="cart-content py-3 pl-3">
                             <h6 class="header-gio-hang">GIỎ HÀNG CỦA BẠN <span>({{Cart::count()}} sản phẩm) </span></h6>
                                </br>
                             <hr>
                             <div class="group d-flex justify-content-between">
                                            <p class="label">Sản phẩm</p>
                                            <p class="label" style="margin-left:300px">Giá</p>
                                            <p class="">Thành tiền</p>
                                        </div>
                                        <br>
                                        <hr>
                             
                            <div class="cart-list-items">
                            @foreach($content as $v_content)
                                <div class="cart-item d-flex">
                                
                                    <a href="{{URL::to('/chi-tiet-san-pham/'.$v_content->id)}}" class="img">
                                        <img src="{{URL::to('frontend/images/'.$v_content->options->image)}}" class="img-fluid" alt="anhsp1">
                                    </a>
                                    <div class="item-caption d-flex w-100">
                                        <div class="item-info ml-3" style="max-width: 60%;">
                                            <a href="{{URL::to('/chi-tiet-san-pham/'.$v_content->id)}}" class="ten">{{$v_content->name}}</a>
                                            <div class="soluong d-flex">

                                            <form id="update-form-{{$v_content->rowId}}">
                                                {{csrf_field()}}
                                                <div class="" style=" width:220px; height:30px ;float:left">  
                                                    <span style="font-weight:500">Số lượng:&nbsp; </span>
                                                   <input type="number" min="1" value="{{$v_content->qty}}" class="soluongsp text-center cart-quantity" name="cart_quantity" data-rowid="{{$v_content->rowId}}" style="width:28px;height:25px">                      
                                                   <span><span style="font-weight:500">Phân loại:</span>&nbsp; {{$v_content->options->form}}</span>
                                                   <!-- <select>
                                                      <option value="option1">Option 1</option>
                                                      <option value="option2">Option 2</option>
                                                      <option value="option3">Option 3</option>
                                                   </select> -->
                                                </div>
                                            </form>    

                                            </div>
                                        </div>
                                        
                                        <div class="item-price ml-auto d-flex flex-column align-items-end">
                                        <div class="giamoi" style="margin-right:150px"> {{number_format($v_content->price, 0, ',', '.') }} đ</div> 
                                            <div class="giamoi" data-rowid="{{$v_content->rowId}}" style="margin-top:-20px">
                                                <?php  $subtotal = $v_content->price * $v_content->qty;
                                                    echo number_format($subtotal, 0, ',', '.') ;
                                                ?>&nbspđ
                                            </div> 
                                            <span class="remove mt-auto" >
                                                <a href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="far fa-trash-alt" ></i></a>
                                            </span>
                                        </div>
                                    </div>
                                   
                                </div>
                                </br>
                                <hr>
                            @endforeach 

                                
                            </div> 
                            
                             <div class="row">
                                <div class="col-md-3">
                                    <a href="{{URL::to('/')}}" class="btn nutmuathem mb-3">Mua thêm</a>
                                </div>
                                <div class="col-md-5 offset-md-4">
                                    <div class="tonggiatien">
                                        <div class="group d-flex justify-content-between">
                                            <p class="label">Tạm tính:</p>
                                            <p class="tamtinh">{{number_format(floatval(str_replace(',', '', Cart::subtotal())), 0, ',', '.')}} ₫</p>
                                        </div>
                                        <div class="group d-flex justify-content-between">
                                            <p class="label">Giảm giá:</p>
                                            <p class="giamgia">0 ₫</p>
                                        </div>
                                        <div class="group d-flex justify-content-between">
                                            <p class="label">Phí vận chuyển:</p>
                                            <p class="phivanchuyen">0 ₫</p>
                                        </div>
                                        
                                        <div class="group d-flex justify-content-between align-items-center">
                                            <strong class="text-uppercase">Tổng cộng:</strong>
                                            <p class="tongcong">0đ</p>
                                        </div>
                                        <small class="note d-flex justify-content-end text-muted">
                                            (Giá đã bao gồm VAT)
                                        </small>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                   
                    <div class="col-md-4 cart-steps pl-0">
                        <div id="cart-steps-accordion" role="tablist" aria-multiselectable="true">
                        <!-- @if(Cart::count()>0) -->
                        @if(isset(Session::get('user')->id )&& Cart::count()>0)

                            <!-- bước số 2: nhập địa chỉ giao hàng  -->
                            <div class="card">
                                <div class="card-header" role="tab" id="step2header">
                                    <h5 class="mb-0">
                                        <a data-toggle="collapse" data-parent="#cart-steps-accordion"
                                            href="#step2contentid" aria-expanded="true" aria-controls="step2contentid"
                                            class="text-uppercase header"><span class="steps">ĐẶT HÀNG</span>
                                            <span class="label">Thông tin khách hàng</span>
                                            <i class="fa fa-chevron-right float-right"></i>
                                        </a>
                                    </h5>
                                </div>
                                <div id="step2contentid" class="collapse in" role="tabpanel"
                                    aria-labelledby="step2header" class="stepscontent">
                                    <div class="card-body">
                                        <form id="form-checkout" class="form-diachigiaohang" >
                                            {{csrf_field()}}
                                            <div class="form-label-group">
                                                <input type="text" id="inputName" class="form-control"
                                                    placeholder="Nhập họ và tên" name="name" required autofocus value="{{Session::get('user')->fullname}}">
                                            </div>
                                            <div class="form-label-group">
                                                <input type="text" id="inputPhone" class="form-control"
                                                    placeholder="Nhập số điện thoại" name="phone" required value="{{Session::get('user')->phone}}">
                                            </div>

                                            <div class="form-label-group">
                                                <select id="province" class="form-control" name="province">
                                                @if(Session::get('user')->province_id!=0 || Session::get('user')->province_id!=null )
                                                    @foreach ($provinces as $province)
                                                        @if($province->id == Session::get('user')->province_id)
                                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                        @break
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <option value="">Chọn Tỉnh/Thành phố</option>
                                                @endif
                                                @foreach ($provinces as $province)
                                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                @endforeach
                                                </select>
                                            </div>

                                            <div class="form-label-group">
                                                <select id="district" class="form-control" name="district">
                                                    @if(Session::get('user')->district_id!=0 || Session::get('user')->district_id!=null)
                                                        @foreach ($districts as $district)
                                                            @if($district->id == Session::get('user')->district_id)
                                                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                                                            @break
                                                            @endif
                                                        @endforeach
                                                        <option value="">Chọn Quận/Huyện</option>
                                                        @foreach ($districts as $district)
                                                            @if($district->province_id == Session::get('user')->province_id)
                                                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <option value="">Chọn Quận/Huyện</option>
                                                    @endif
                                                    
                                                </select>
                                            </div>

                                            <div class="form-label-group">
                                                <select id="ward" class="form-control" name="ward" data-district-id="">
                                                @if(Session::get('user')->ward_id!=0 || Session::get('user')->ward_id!=null)
                                                        @foreach ($wards as $ward)
                                                            @if($ward->id == Session::get('user')->ward_id)
                                                            <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                                                            @break
                                                            @endif
                                                        @endforeach
                                                        <option value="">Chọn Phường/Xã</option>
                                                        @foreach ($wards as $ward)
                                                            @if($ward->district_id == Session::get('user')->district_id)
                                                                <option value="{{ $ward->id }}" data-district-id="{{$ward->district_id}}">{{ $ward->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <option value="">Chọn Phường/Xã</option>
                                                    @endif
                                                    
                                                </select>
                                            </div>
                                            
                                            <div class="form-label-group">
                                                <input type="text" id="inputAddress" class="form-control"
                                                    placeholder="Nhập Địa chỉ giao hàng" name="address" required value="{{Session::get('user')->address}}">
                                            </div>
                                            
                                            <div class="form-label-group">
                                                <textarea type="text" id="inputNote" class="form-control"
                                                    placeholder="Nhập ghi chú (Nếu có)" name="note" ></textarea>
                                            </div>
                                        
                                            <div class="form-label-group">
                                                <select id="payment" class="form-control" name="payment">
                                                    <option value="">Phương thức thanh toán</option>
                                                    <option value="1">Thanh toán khi nhận hàng</option>
                                                    <option value="2">Thanh toán online</option>
                                                </select>
                                            </div>
                                            <button class="btn btn-lg btn-block btn-signin text-uppercase text-white dathang" name="redirect" 
                                                style="background: #F5A623">Đặt mua</button>
                                        </form>
                                    </div>
                                </div>
                        @else    
                            <div class="card">
                                <div class="card-header cardheader" role="tab" id="step1header">
                                    <h5 class="mb-0">
                                        <a data-toggle="collapse" data-parent="#cart-steps-accordion"
                                            href="#step1contentid" aria-expanded="true" aria-controls="step1contentid"
                                            class="text-uppercase header"><span class="steps">1</span>
                                            <span class="label">VUI LÒNG ĐĂNG NHẬP ĐỂ MUA HÀNG</span>
                                            <i class="fa fa-chevron-right float-right"></i>
                                        </a>
                                    </h5>
                                </div>
                                <div id="step1contentid" class="collapse in" role="tabpanel"
                                    aria-labelledby="step1header" class="stepscontent">
                                    <div class="card-body p-0">
                                        <nav>
                                            <div class="nav nav-tabs dangnhap-dangky" id="nav-tab" role="tablist">
                                                <a class="nav-item nav-link active text-center text-uppercase"
                                                    id="nav-dangnhap-tab" data-toggle="tab" href="#nav-dangnhap"
                                                    role="tab" aria-controls="nav-dangnhap" aria-selected="true">Đăng
                                                    nhập</a>
                                                <a class="nav-item nav-link text-center text-uppercase"
                                                    id="nav-dangky-tab" data-toggle="tab" href="#nav-dangky" role="tab"
                                                    aria-controls="nav-dangky" aria-selected="false">Đăng ký</a>
                                            </div>
                                        </nav>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-dangnhap" role="tabpanel"
                                                aria-labelledby="nav-dangnhap-tab">
                                                <!-- Xử lí đăng nhập -->
                                                <form id="form-signin-cart" class="form-signin mt-2" 
                                                        method="POST" action="{{URL::to('/login-cart')}}" >
                                                        {{ csrf_field() }}
                                                    <div class="form-label-group">
                                                        <input type="email" id="inputEmail" class="form-control"
                                                            placeholder="Nhập địa chỉ email" name="email" required
                                                            autofocus>
                                                    </div>
                                                    <div class="form-label-group">
                                                        <input type="password" id="inputPassword" class="form-control"
                                                            placeholder="Mật khẩu" name="password" required>
                                                    </div>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <a href="#" class="float-right text-decoration-none"
                                                            style="color: #F5A623">Quên mật khẩu</a>
                                                    </div>
                                                    <button
                                                        class="btn btn-lg btn-block btn-signin text-uppercase text-white"
                                                        type="submit" style="background: #F5A623">Đăng nhập</button>

                                                    
                                                 
                                                </form>
                                                
                                            </div>
                                            <div class="tab-pane fade" id="nav-dangky" role="tabpanel"
                                                aria-labelledby="nav-dangky-tab">
                                                        <!-- đăng kí -->
                                                <form id="form-signup-cart" class="form-signin mt-2" 
                                                    method="POST" action="{{URL::to('/signin-cart')}}" >
                                                    {{ csrf_field() }}
                                                    <div class="form-label-group">
                                                        <input type="text" id="inputName" class="form-control"
                                                            placeholder="Nhập họ và tên" name="fullname" required autofocus>
                                                    </div>
                                                    <div class="form-label-group">
                                                        <input type="text" id="inputPhone" class="form-control"
                                                            placeholder="Nhập số điện thoại" name="phone" required>
                                                    </div>
                                                    <div class="form-label-group">
                                                        <input type="email" id="inputEmail" class="form-control"
                                                            placeholder="Nhập địa chỉ email" name="email" required>
                                                    </div>

                                                    <div class="form-label-group">
                                                        <input type="password" id="inputPassword" class="form-control"
                                                            placeholder="Nhập mật khẩu" name="password" required>
                                                    </div>
                                                    <!-- <div class="form-label-group mb-3">
                                                        <input type="password" id="inputConfirmPassword"
                                                            class="form-control" name="confirm_password"
                                                            placeholder="Nhập lại mật khẩu" required>
                                                    </div> -->
                                                   
                                                    
                                                    <button
                                                        class="btn btn-lg btn-block btn-signin text-uppercase text-white mt-3"
                                                        type="submit" style="background: #F5A623">Đăng ký</button>

                                                </form>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif   
                        <!-- @endif  -->
                            </div>    
                        </div>
                    </div>
                  
                </div>
                @endif   
                <!-- het row  -->
            </div>
            <!-- het cart-page  -->
        </div>
        <!-- het container  -->
</section>
<!--end body ........ -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
<script>
  $(document).ready(function() {
    // var subtotalText = $('.tongcong').text();
    // var subtotalValue = parseInt(subtotalText);
            var wardId = $('#ward').val();
            var districtId = $('#district').val();
            //var total = parseInt($('.tongcong').text().replace(/[^0-9]/g, ''));lấy số trong chuỗi
            if (wardId) {
                $.ajax({
                    url: '{{URL::to("/get-fee")}}',
                    method: 'POST',
                    data: {
                    wardid: wardId,
                    districtid: districtId,
                    _token: '{{csrf_token()}}'
                    },
                    success: function (data) {

                        var formattedNumber = (data.fee).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                        $('.phivanchuyen').text(formattedNumber);
                        var formattedNumber1 = (data.total).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                        $('.tongcong').text(formattedNumber1);
                        var formattedNumber2 = (data.coupon).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                        $('.giamgia').text(formattedNumber2);
                    }
                });
            } else {
                $('#ward').html('<option value="">Chọn Phường/Xã</option>');
            }
    $('.cart-quantity').change(function(e) {
        e.preventDefault();
        var rowId = $(this).data('rowid');
        var quantity = $(this).val();
        var feeText = $('.phivanchuyen').text();
        var Fee = parseInt(feeText.replace(/[^0-9]/g, ''));//loại bỏ ký tự ko phải số và dấu thập phân
        $.ajax({
            url: '{{URL::to("/update-cart-quantity")}}',
            method: 'POST',
            data: {
            rowid: rowId,
            cart_quantity: quantity,
            fee : Fee,
            _token: '{{csrf_token()}}'
            },
            success: function(response) {
                $('.tamtinh').text(response.total+ ' ₫');
                $('.tongcong').text(response.subtotal+ ' ₫');
                $('.giamgia').text(response.coupon+ ' ₫');
                $('.giamoi[data-rowid="' + rowId + '"]').text(response.price + ' ₫');
            },
            error: function(xhr, status, error) {
            console.log(error);
            }
        });
    });
        $('#province').change(function () {
            var provinceId = $(this).val();
            if (provinceId) {
                $.ajax({
                    url: "{{url('/get-districts')}}/" + provinceId,
                    type: 'GET',
                    success: function (data) {
                        $('#district').html('<option value="">Chọn Quận/Huyện</option>');
                        $.each(data, function (key, value) {
                            $('#district').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#district').html('<option value="">Chọn Quận/Huyện</option>');
                $('#ward').html('<option value="">Chọn Phường/Xã</option>');
            }
        });

        $('#district').change(function () {
            var districtId = $(this).val();
            if (districtId) {
                $.ajax({
                    url: "{{url('/get-wards')}}/" + districtId,
                    type: 'GET',
                    success: function (data) {
                        $('#ward').attr('data-district-id', districtId);
                        $('#ward').html('<option value="">Chọn Phường/Xã</option>');
                        $.each(data, function (key, value) {
                            $('#ward').append('<option value="' + value.id + '"'+'data-district-id="'+districtId+'">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#ward').html('<option value="">Chọn Phường/Xã</option>');
            }
        });
        $('#ward').change(function () {
            var wardId = $(this).val();
            var districtId = $(this).find(':selected').data('district-id');
            
            if (wardId) {
                $.ajax({
                    url: '{{URL::to("/get-fee")}}',
                    method: 'POST',
                    data: {
                    wardid: wardId,
                    districtid: districtId,
                    _token: '{{csrf_token()}}'
                    },
                    success: function (data) {

                        var formattedNumber = (data.fee).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                        $('.phivanchuyen').text(formattedNumber);
                        var formattedNumber1 = (data.total).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                        $('.tongcong').text(formattedNumber1);
                        var formattedNumber2 = (data.coupon).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                        $('.giamgia').text(formattedNumber2);
                    }
                });
            } else {
                $('#ward').html('<option value="">Chọn Phường/Xã</option>');
            }
        });
        $('.dathang').click(function (e) {
            e.preventDefault();
            var payment = $('#payment').val();
            var username =$('#inputName').val();
            var phone = $('#inputPhone').val();
            var province = $('#province').find(':selected').text();
            var district = $('#district').find(':selected').text();
            var ward = $('#ward').find(':selected').text();
            var address = $('#inputAddress').val();
            var coupon =parseInt($('.giamgia').text().replace(/[^0-9]/g, ''));
            var fee =parseInt($('.phivanchuyen').text().replace(/[^0-9]/g, ''));
            var total =  parseInt($('.tongcong').text().replace(/[^0-9]/g, ''));

            if (payment==1 && ward!="Chọn Phường/Xã") {
                $.ajax({
                    url: '{{URL::to("/order-off")}}',
                    method: 'POST',
                    data: {
                        payment: payment,
                        username: username,
                        phone: phone,
                        province: province,
                        district: district,
                        ward: ward,
                        address: address,
                        coupon: coupon,
                        fee: fee,
                        total: total,
                    
                    _token: '{{csrf_token()}}'
                    },
                    success: function (data) {
                        if(data.check == 'ok')
                                window.location.href = "{{url('/checkout_complete')}}/";
                        
                    }
                });
            }
            else if(payment==2 && ward!="Chọn Phường/Xã") {
                $.ajax({
                    url: '{{URL::to("/vnpay_payment")}}',
                    method: 'POST',
                    data: {
                        payment: payment,
                        username: username,
                        phone: phone,
                        province: province,
                        district: district,
                        ward: ward,
                        address: address,
                        coupon: coupon,
                        fee: fee,
                        total: total,
                    
                    _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.code === '00') {
                            window.location.href = response.data;
                        } else {
                            console.log(response.message);
                        }
                        
                    }
                });
            }else{
                $.notify(`Vui lòng kiểm tra lại thông tin`, 'error')
            }
        });
  });
</script>

@endsection