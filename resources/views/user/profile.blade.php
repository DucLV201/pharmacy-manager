@extends('welcome')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<link rel="stylesheet" href="{{asset('/frontend/css/tai-khoan.css')}}">
<link rel="stylesheet" href="{{asset('/frontend/css/categories.css')}}">
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<style>
    .form-message {
        display: flex;
        margin: auto;
        margin-left: 10px;
    }
</style>
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
                                <!-- <img style="padding-left:10px" src="./frontend/images/tpcn_icon24.png"></img> -->
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

<!-- nội dung của trang  -->
<section class="account-page my-3">
        <div class="container">
            <div class="page-content bg-white">
                <div class="account-page-tab-content m-4">
                    <!-- 2 tab: thông tin tài khoản, danh sách đơn hàng  -->
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-donhang-tab" data-toggle="tab" href="#nav-donhang" role="tab" aria-controls="nav-profile" aria-selected="false">Danh sách đơn hàng</a>
                          <a class="nav-item nav-link" id="nav-taikhoan-tab" data-toggle="tab" href="#nav-taikhoan" role="tab" aria-controls="nav-home" aria-selected="true">Thông tin tài khoản</a>
                          <a class="nav-item nav-link" id="nav-doimk" data-toggle="tab" href="#nav-doimatkhau" role="tab" aria-controls="nav-profile" aria-selected="false">Đổi mật khẩu</a>
                          
                        </div>
                    </nav>

                    <!-- nội dung 2 tab -->
                    <div class="tab-content">

                        <!-- nội dung tab 1: thông tin tài khoản  -->
                        <div class="tab-pane fade py-3" id="nav-taikhoan" role="tabpanel" aria-labelledby="nav-taikhoan-tab">
                            <div class="offset-md-4 mt-3">
                                <h3 class="account-header">Thông tin tài khoản</h3>
                            </div>
                            <form method="post" action="{{URL::to('/cap-nhat-thong-tin')}}">
                            {{ csrf_field() }}
                                @foreach($in4_user as $key => $info)
                            <div class="hoten my-3">
                                <div class="email my-3">
                                    <div class="row">
                                        <label class="col-md-2 offset-md-2" for="account-email">Địa chỉ email</label>
                                        <input class="col-md-4" type="text" name="account-email" disabled="disabled" value="{{$info->email}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-2 offset-md-2" >Họ tên</label>
                                    <input class="col-md-4" type="text" name="hoten" value="{{$info->fullname}}">
                                </div>
                                </br>
                                <div class="row">
                                    <label class="col-md-2 offset-md-2" >Số điện thoại</label>
                                    <input class="col-md-4" type="text" name="phone" value="{{$info->phone}}">
                                </div>
                               
                                
                                </br>
                                <div class="row">
                                    <label class="col-md-2 offset-md-2" >Địa chỉ</label>
                                    <input class="col-md-4" type="text" name="address" value="{{$info->address}}">
                                </div>
                            </div>
                                @endforeach
                            <div class="capnhat my-3">
                                    <div class="row">
                                        <button type="submit" class="button-capnhat text-uppercase offset-md-4 btn btn-warning mb-4">Cập nhật</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- nội dung tab 2: đổi mật khẩu-->
                        <div class="tab-pane fade py-3" id="nav-doimatkhau" role="tabpanel" aria-labelledby="nav-donhang-tab">
                            <!-- <div class="donhang-table">
                                <table class="m-auto"> -->
                                    <form  id="form-change">
                                    {{ csrf_field() }} 
                                        <div class="row form-group">
                                            <label for="res-passwordd" class="col-md-2 offset-md-2 form-label">Mật khẩu</label>
                                            <input type="password" autocomplete="off" class="form-control col-md-4" id="res-passwordd" name="res-passwordd">
                                            <p class="form-message"></p>
                                        </div>
                                        <div class="row form-group">
                                            <label for="res-new_passwordd" class="col-md-2 offset-md-2 form-label">Mật khẩu mới</label>
                                            <input type="password" autocomplete="off" class="form-control col-md-4" id="res-new_passwordd" name="res-new_passwordd">
                                            <p class="form-message col-md-2 offset-md-2 form-label"></p>
                                        </div>
                                        <div class="row form-group">
                                            <label for="res-passworddcf" class="col-md-2 offset-md-2 form-label">Nhập lại mật khẩu</label>
                                            <input type="password" autocomplete="off" class="form-control col-md-4" id="res-passworddcf" name="res-passworddcf">
                                            <p class="form-message"></p>
                                        </div>
                                        <!-- <div class="capnhat my-3">
                                            <div class="row"> -->
                                                <button 
                                                    type="submit" 
                                                    id="submit-change" 
                                                    class="button-capnhat text-uppercase offset-md-4 btn btn-warning mb-4"
                                                    data-user_id="{{Session::get('user')->userid}}"
                                                    data-email="{{Session::get('user')->email}}"
                                                    >Cập nhật
                                                </button>
                                            <!-- </div>
                                        </div> -->
                                    </form>
                                <!-- </table>
                            </div> -->
                        </div>

                        <!-- nội dung tab 3: danh sách đơn hàng -->
                        <div class="tab-pane fade show active pl-4" id="nav-donhang" role="tabpanel" aria-labelledby="nav-donhang-tab">
                            <div class="donhang-table">
                                <table class="m-auto">
                                    <tr>
                                        <th>Mã đơn hàng</th>
                                        <th>Ngày mua</th>
                                        <th>Tổng tiền</th>
                                        <th style="width:200px">Trạng thái đơn hàng</th>
                                        <th style="width:150px">Chi tiết đơn hàng</th>
                                    </tr>
                                    @foreach($ordered as $row)
                                    <tr>
                                        <td>{{$row->orderid}}</td>
                                        <td>{{$row->timestamp}}</td>
                                        
                                        <td>{{$row->totalmoney}}</td>
                                        <td >
                                            <?php if( $row->orderstatus == 0) 
                                                        echo "Đang chờ phê duyệt" ;
                                                    elseif($row->orderstatus == 1) 
                                                        echo "Đã phê duyệt";
                                                    elseif($row->orderstatus == 2) 
                                                        echo "Đã giao";
                                                    else 
                                                        echo "Đã từ chối";
                                            ?>
                                        </td>
                                        <td>
                                       
                                    <a  href="{{URL::to('/show-details-ordered/'.$row->orderid)}}" data-target="#form"
                                        style="display:inline-block">Xem chi tiết</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <!-- form chi tiết -->
                        @if(isset($details))
                           
                        <div class="" id="form" data-backdrop="static" tabindex="-1" aria-labelledby="dangky_tieude"
                             aria-hidden="true" >
                            <div class="modal-dialog ">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <ul class="tabs d-flex justify-content-around list-unstyled mb-0">
                                                <li >
                                                
                                                   <h6>Danh sách sản phẩm</h6>
                                                    <hr>
                                                </li>
                                                
                                                
                                            </ul>
                                            <button  class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true"><a href="{{URL::to('/show-profile')}}"> &times; </a></span>
                                            </button>
                                        </div>
                                        <div class="cart-list-items">
                                        @foreach($details as $d)
                                       
                                    <div class="cart-item d-flex" style="margin-top:8px">
                                    
                                    <a href="{{URL::to('/chi-tiet-san-pham/'.$d->bookid)}}" class="img">
                                        <img src="{{URL::to('public/frontend/images/'.$d->bookimageurl)}}" class="img-fluid" alt="anhsp1" style="width:120px"  >
                                    </a>
                                    <div class="item-caption d-flex w-100">
                                        <div class="item-info ml-3">
                                            <a href="{{URL::to('/chi-tiet-san-pham/'.$d->bookid)}}" class="ten" style="color:black;text-decoration:none">
                                                <h6>{{$d->bookname}}</h6></a><p>Số lượng: {{$d->qtyordered}}</p>
                                        </div>
                                        
                                        <div class="item-price ml-auto d-flex flex-column align-items-end">
                                        <div class="giamoi" style="margin-top:20px">  {{number_format($d->price)}} đ</div>
                                            
                                        </div>
                                    </div>
                                   
                                    </div>

                                </br>
                                <hr>
                                        @endforeach  
                                        </div>
                                    </div>
                            </div>
                        </div> 
                         
                        @endif

                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{asset('public/frontend/js/validator.js')}}"></script>
    <script>
        $(document).ready(function() {
            Validator({
                form: '#form-change',
                formGroup: '.form-group',
                message: '.form-message',
                rules: [
                    Validator.isPassword('#res-new_passwordd'),
                    Validator.isConfirm('#res-passworddcf', function() {
                            return $('#res-new_passwordd').val();
                        }, 'Nhập lại mật khẩu chưa đúng')
                    ],
                onSubmit: function(data) {
                    let old_pass = $('#res-passwordd').val()
                    let new_pass = $('#res-new_passwordd').val()
                    console.log($('#res-new_passwordd').val())
                    let confirm_pass = $('#res-passworddcf').val()
                    let userid = $('#submit-change').data('user_id')
                    let email = $('#submit-change').data('email')
                    $.ajax({
                        url: "{{url('/doi-mat-khau')}}",
                        method: 'post',
                        data: 
                        {
                            newPassword: new_pass,
                            email: email,
                            password: old_pass,
                            userId: userid
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if(data =='Cập nhật thành công') {
                                window.location.replace("{{url('/')}}");
                                $.notify(data, 'success')
                            }else{
                                $.notify(data, 'error')
                            }
                            
                        }
                    })
                }
            })
        })
            
    </script>


@endsection