<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Bình An-Nhà thuốc tận tâm</title>
    <meta name="description"
        content="Mua thuốc online, giá tốt nhất, cập nhật tin tức sức khỏe và các loại bệnh phổ biến để phòng tránh.">
    <meta name="keywords" content="nhà thuốc online, mua thuốc, thuốc tốt, thuốc bán chạy, thuốc giảm giá nhiều">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="{{asset('frontend/css/home.css')}}">
    <script type="text/javascript" src="{{asset('frontend/js/main.js')}}"></script>
    <link rel="stylesheet" href="{{asset('frontend/fontawesome_free_5.13.0/css/all.css')}}">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/slick/slick.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/slick/slick-theme.css')}}" />
    <script type="text/javascript" src="{{asset('frontend/slick/slick.min.js')}}"></script>
    <script type="text/javascript"
        src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
        
    <link rel="canonical" href="http://nhathuocba.xyz/">
    <meta name="google-site-verification" content="urDZLDaX8wQZ_-x8ztGIyHqwUQh2KRHvH9FhfoGtiEw" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('frontend/favicon_io/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('frontend/favicon_io/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('frontend/favicon_io/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('frontend/favicon_io/site.webmanifest')}}">
    <style>
        img[alt="www.000webhost.com"]{display: none;}

        .form-message {
            font-size: .8rem;
            color: red;
        }
        /* Search */
.input-search {
    position: relative;
}

.input-search:focus {
    outline: none;
    box-shadow: none;
}

.input-result {
    width: 520px;
    margin-top: 5px;
    box-shadow: 5px 5px 10px -3px #ccc;
    border: 1px solid #ccc;
    border-radius: 10px;
    list-style: none;
    position: absolute;
    top: 43px;
    z-index: 1;
    display: none;
}

.input-resultlist:first-child > a {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.input-resultlist:last-child > a{
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
}

.input-result__item {
    width: 100%;
    height: 80px;
    padding: 10px 0;
    background-color: #fff;
    margin: 0;
    cursor: pointer;
    text-decoration: none;
}



.input-result__item:hover {
    background-color: #f5f5f5;
    text-decoration: none;
}

.input-result__item > img {
    width: 100%;
    height: 60px;
    margin-right: 5px;
}

.input-result__item > .info {
    box-sizing: border-box;
    padding: 5px 0;
}

.input-result__item > .info > h4 {
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
    padding: 0;
    color: #000;
}

.input-result__item > .info > h5 {
    font-size: .9rem;
    font-weight: 600;
    margin: 0;
    padding: 0;
    color: #aa1318;
}
    </style>
<!-- ajax comment -->
<!-- <script type="text/javascript">
    $(document).ready(function(){
       load_comment();
        
        // alert(product_id);
        function load_comment(){
            var product_id = $('.comment_product_id').val();
            var _token = $('input[name="_token"]').val(); 
            $.ajax({
                url:"./load-comment",
                method :"POST",
                data:{product_id:product_id,_token:_token},
                success:function(data){
                   
                    $('#comment_show').html(data);
                }
            });
        }
        $('.send-comment').click(function(){
            var product_id = $('.comment_product_id').val();
            var comment_name = $('.comment_name').val();
            var comment_email = $('.comment_email').val();
            var comment_content = $('.comment_content').val();
            var _token = $('input[name="_token"]').val(); 
            
            $.ajax({
                url:"./send-comment",
                method :"POST",
                data:{product_id:product_id,comment_name:comment_name,comment_email:comment_email,comment_content:comment_content,_token:_token},
                success:function(data){
                    $('#notify_comment').html('<p class="text text-succes">Thêm bình luận thành công</p>')
                    load_comment();
                    $('#notify_comment').fadeOut(2000);
                    $('.comment_name').val('');
                    $('.comment_email').val('');
                    $('.comment_content').val('');
                }
            });
        });
    });

</script> -->
    
</head>



<body>
    <!-- code cho nut like share facebook  -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v6.0"></script>

    <!-- header -->
    <nav class="navbar navbar-expand-md bg-white navbar-light">
        <div class="container">
            <!-- logo  -->
            <a class="navbar-brand" href="{{URL::to('/')}}" style="width: 200px height = 70px"><img src="{{asset('frontend/images/logo.png')}}" alt=""></a>

            <!-- navbar-toggler  -->
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse"
                data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <!-- form tìm kiếm  -->
                <form 
                    class="form-inline ml-auto my-2 my-lg-0 mr-3"
                    method="get"
                    action="./search">
                    <input type="hidden" name="_token" value="LAfo1u8NA1REx3Wc9FWVZQQc81pWseqbZqHCxhJ6">
                    <div class="input-group" style="width: 520px;">
                        <input 
                            type="text" 
                            name="search_key"
                            class="input-search form-control" 
                            aria-label="Small"
                            autocomplete="off"
                            placeholder="Nhập thuốc cần tìm kiếm..."
                        >
                        <div class="input-group-append">
                            <button type="submit" class="btn" style="background-color: #0b9446; color: white;">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>

                        <ul class="input-result">
                            
                        </ul>
                    </div>
                </form>
                
                @if(isset(Session::get('user')->userid))
                <!-- ô đăng xuất khi đăng nhập thành công -->
                <ul class="navbar-nav mb-1 ml-auto">
                    <div class="dropdown">
                        <li class="nav-item account" type="button" class="btn dropdown" data-toggle="dropdown">
                            <a href="#" class="btn btn-secondary rounded-circle">
                                <i class="fa fa-user"></i>
                            </a>
                            <a class="nav-link text-dark text-uppercase" href="#" style="display:inline-block">
                                {{Session::get('user')->fullname}}
                            </a>
                        </li>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item nutdangky text-center mb-2" href="{{URL::to('/dangxuat')}}">Đăng xuất</a>
                            @if(Session::get('user')->isadmin == 1)
                                <a class="dropdown-item nutdangky text-center mb-2" href="{{URL::to('/show_dashboard')}}">Trang quản trị</a>
                            @endif
                            <a class="dropdown-item nutdangky text-center mb-2" href="{{URL::to('/thong-tin-ca-nhan')}}">Tài khoản của bạn</a>
                        </div>
                    </div>
                    <li class="nav-item giohang">
                        <a href="{{URL::to('/gio-hang')}}" class="btn btn-secondary rounded-circle">
                            <i class="fa fa-shopping-cart"></i>
                           
                            <div style="height: 18px;
                                width: 18px;
                                border-radius: 50%;
                                background: #F5A623;
                                font-size: 12px;
                                position: relative;
                                left: 19px;
                                bottom: 32px;
                                transition: 0.2s;">{{Cart::count()}}</div>
                           
                        </a>
                        <a class="nav-link text-dark giohang text-uppercase" href="{{URL::to('/gio-hang')}}"
                            style="display:inline-block">Giỏ Hàng</a>
                    </li>
                </ul>

                @else
                <!-- ô đăng nhập đăng ký giỏ hàng trên header  -->
                <ul class="navbar-nav mb-1 ml-auto">
                    <div class="dropdown">
                        <li class="nav-item account" type="button" class="btn dropdown" data-toggle="dropdown">
                            <a href="#" class="btn btn-secondary rounded-circle">
                                <i class="fa fa-user"></i>
                            </a>
                            <a class="nav-link text-dark text-uppercase" href="#" style="display:inline-block">Tài
                                khoản</a>
                        </li>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item nutdangky text-center mb-2" href="#" data-toggle="modal"
                                data-target="#formdangky">Đăng ký</a>
                            <a class="dropdown-item nutdangnhap text-center" href="#" data-toggle="modal"
                                data-target="#formdangnhap">Đăng nhập </a>
                        </div>
                    </div>
                   
                    <li class="nav-item giohang">
                        <a href="{{URL::to('/gio-hang')}}" class="btn btn-secondary rounded-circle">
                            <i class="fa fa-shopping-cart"></i>
                           
                            <div style="height: 18px;
                                width: 18px;
                                border-radius: 50%;
                                background: #F5A623;
                                font-size: 12px;
                                position: relative;
                                left: 19px;
                                bottom: 32px;
                                transition: 0.2s;">{{Cart::count()}}</div>
                           
                        </a>
                        <a class="nav-link text-dark giohang text-uppercase" href="{{URL::to('/gio-hang')}}"
                            style="display:inline-block">Giỏ Hàng</a>
                    </li>
                </ul>
                @endif
            </div>
        </div>
    </nav>
    

    <!-- form dang ky khi click vao button tren header-->
    <div class="modal fade mt-5" id="formdangky" data-backdrop="static" tabindex="-1" aria-labelledby="dangky_tieude"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <ul class="tabs d-flex justify-content-around list-unstyled mb-0">
                        <li class="tab tab-dangnhap text-center">
                            <a class=" text-decoration-none">Đăng nhập</a>
                            <hr>
                        </li>
                        <li class="tab tab-dangky text-center">
                            <a class="text-decoration-none">Đăng ký</a>
                            <hr>
                        </li>
                    </ul>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form 
                        id="form-signup" 
                    >
                    {{ csrf_field() }} 
                    <input type="hidden" name="_token" value="LAfo1u8NA1REx3Wc9FWVZQQc81pWseqbZqHCxhJ6"> 
                    <div class="form-group">
                        <label for="res-fullname" class="form-label">Tài khoản</label>
                        <input type="text" autocomplete="off" class="form-control" id="res-fullname" name="res-fullname">
                        <p class="form-message"></p>
                    </div>

                    <div class="form-group">
                        <label for="res-phone" class="form-label">Số điện thoại</label>
                        <input type="text" autocomplete="off" class="form-control" id="res-phone" name="res-phone">
                        <p class="form-message"></p>
                    </div>

                    <div class="form-group">
                        <label for="res-email" class="form-label">Email</label>
                        <input type="text" autocomplete="off" class="form-control" id="res-email" name="res-email">
                        <p class="form-message"></p>
                    </div>

                    <div class="form-group">
                        <label for="res-password" class="form-label">Mật khẩu</label>
                        <input type="password" autocomplete="off" class="form-control" id="res-password" name="res-password">
                        <p class="form-message"></p>
                    </div>

                    <div class="form-group">
                        <label for="res-passwordcf" class="form-label">Nhập lại mật khẩu</label>
                        <input type="password" autocomplete="off" class="form-control" id="res-passwordcf" name="res-passwordcf">
                        <p class="form-message"></p>
                    </div>
                    
                        <button 
                            class="btn btn-lg btn-block btn-signin text-uppercase text-white mt-3" 
                            style="background: #F5A623"
                            type="submit"
                            id="btn-register"
                            >Đăng ký
                        </button>
                        <hr class="mt-3 mb-2">
                        <div class="custom-control custom-checkbox">
                            <p class="text-center">Bằng việc đăng ký, bạn đã đồng ý với DealBook về</p>
                            <a href="#" class="text-decoration-none text-center" style="color: #F5A623">Điều khoản dịch
                                vụ & Chính sách bảo mật</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- form dang nhap khi click vao button tren header-->
    <div class="modal fade mt-5" id="formdangnhap" data-backdrop="static" tabindex="-1"
        aria-labelledby="dangnhap_tieude" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <ul class="tabs d-flex justify-content-around list-unstyled mb-0">
                        <li class="tab tab-dangnhap text-center">
                            <a class=" text-decoration-none">Đăng nhập</a>
                            <hr>
                        </li>
                        <li class="tab tab-dangky text-center">
                            <a class="text-decoration-none">Đăng ký</a>
                            <hr>
                        </li>
                    </ul>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form 
                        id="form-signin" 
                    >
                    <input type="hidden" name="_token" value="LAfo1u8NA1REx3Wc9FWVZQQc81pWseqbZqHCxhJ6"> 
                        <div class="form-group">
                            <label for="login-email" class="form-label">Email</label>
                            <input type="text" autocomplete="off" class="form-control" id="login-email" name="login-email">
                            <p class="form-message"></p>
                        </div>

                        <div class="form-group">
                            <label for="login-password" class="form-label">Mật khẩu</label>
                            <input type="password" autocomplete="off" class="form-control" id="login-password" name="login-password">
                            <p class="form-message"></p>
                        </div>

                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label"  for="customCheck1">Nhớ mật khẩu</label>
                            <a href="#" class="float-right text-decoration-none" id="forgot"  style="color: #F5A623">Quên mật
                                khẩu</a>
                        </div>

                        <button class="btn btn-lg btn-block btn-signin text-uppercase text-white" type="submit"
                            style="background: #F5A623">Đăng nhập</button>
                        <hr class="my-4">
                        <button class="btn btn-lg btn-google btn-block text-uppercase" type="submit"><i
                                class="fab fa-google mr-2"></i> Đăng nhập bằng Google</button>
                        <button class="btn btn-lg btn-facebook btn-block text-uppercase" type="submit"><i
                                class="fab fa-facebook-f mr-2"></i> Đăng nhập bằng Facebook</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

    
<!-- start body ........ -->
    @yield('content')
<!--end body ........ -->
    <!-- thanh cac dich vu :mien phi giao hang, qua tang mien phi ........ -->
    <section class="abovefooter text-white" style="background-color: #23a054;">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="dichvu d-flex align-items-center">
                        <img src="{{asset('frontend/images/icon-books.png')}}" alt="icon-books">
                        <div class="noidung">
                            <h3 class="tieude font-weight-bold">Cam kết 100% thuốc chính hãng</h3>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="dichvu d-flex align-items-center">
                        <img src="{{asset('frontend/images/icon-ship.png')}}" alt="icon-ship">
                        <div class="noidung">
                            <h3 class="tieude font-weight-bold">Miễn phí vận chuyển theo chính sách giao hàng</h3>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="dichvu d-flex align-items-center">
                        <img src="{{asset('frontend/images/icon-gift.png')}}" alt="icon-gift">
                        <div class="noidung">
                            <h3 class="tieude font-weight-bold">Hỗ trợ nhiều ưu đãi</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="dichvu d-flex align-items-center">
                        <img src="{{asset('frontend/images/icon-return.png')}}" alt="icon-return">
                        <div class="noidung">
                            <h3 class="tieude font-weight-bold">Đổi trả trong 30 ngày kể từ ngày mua hàng</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- footer  -->
    <footer>
        <div class="container py-4">
            <div class="row">
                <div class="col-md-3 col-xs-6">
                    <div class="gioithieu">
                        <h3 class="header text-uppercase font-weight-bold">Về Bình An</h3>
                        <a href="#">Giới thiệu về Bình An</a>
                        <a href="#">Tuyển dụng</a>
                        <div class="fb-like" data-href=""
                            data-width="300px" data-layout="button" data-action="like" data-size="small"
                            data-share="true"></div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-6">
                    <div class="hotrokh">
                        <h3 class="header text-uppercase font-weight-bold">HỖ TRỢ KHÁCH HÀNG</h3>
                        <a href="#">Hướng dẫn đặt hàng</a>
                        <a href="#">Phương thức thanh toán</a>
                        <a href="#">Phương thức vận chuyển</a>
                        <a href="#">Chính sách đổi trả</a>
                    </div>
                </div>
                <div class="col-md-3 col-xs-6">
                    <div class="lienket">
                        <h3 class="header text-uppercase font-weight-bold">CHỨNG NHẬN BỞI</h3>
                        <img src="{{asset('frontend/images/dang-ky-bo-cong-thuong.png')}}" alt="dang-ky-bo-cong-thuong">
                    </div>
                </div>
                <div class="col-md-3 col-xs-6">
                    <div class="ptthanhtoan">
                        <h3 class="header text-uppercase font-weight-bold">Phương thức thanh toán</h3>
                        <img src="{{asset('frontend/images/visa-payment.jpg')}}" alt="visa-payment">
                        <img src="{{asset('frontend/images/master-card-payment.jpg')}}" alt="master-card-payment">
                        <img src="{{asset('frontend/images/jcb-payment.jpg')}}" alt="jcb-payment">
                        <img src="{{asset('frontend/images/atm-payment.jpg')}}" alt="atm-payment">
                        <img src="{{asset('frontend/images/cod-payment.jpg')}}" alt="cod-payment">
                        <img src="{{asset('frontend/images/payoo-payment.jpg')}}" alt="payoo-payment">
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- nut cuon len dau trang -->
    <div class="fixed-bottom">
        <div class="btn btn-warning float-right rounded-circle nutcuonlen" id="backtotop" href="#"
            style="background:#CF111A;"><i class="fa fa-chevron-up text-white"></i></div>
    </div>
    <script src="{{asset('frontend/js/validator.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
    <script>
        Validator({
            form: '#form-signup',
            formGroup: '.form-group',
            message: '.form-message',
            rules: [
                Validator.isRequire('#res-fullname'),
                //Validator.isPhoneNumber('#res-phone'),
                Validator.isEmail('#res-email'),
                Validator.isPassword('#res-password'),
                Validator.isConfirm('#res-passwordcf', function() {
                    return document.querySelector('#form-signup #res-password').value;
                }, 'Nhập lại mật khẩu chưa đúng')
            ],
                onSubmit: function(data) {
                    let userName = $('#res-fullname').val()
                    let userEmail = $('#res-email').val()
                    let userPhone = $('#res-phone').val()
                    let userPassword = $('#res-password').val()
                    $.ajax({
                        url: "{{url('/dangky')}}",
                        method: 'post',
                        data: 
                        {
                            fullname: userName,
                            email: userEmail,
                            phone: userPhone,
                            password: userPassword

                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if(data == 'fail')
                                $.notify(`Email đăng ký đã tồn tại`, 'error')
                            if(data == 'success') {
                                $.notify(`Đăng ký thành công`, 'success')
                                window.location.replace(".")
                            }
                        }
                    })
                }
        });

        $('#form-signin').submit(function(e) {
            e.preventDefault();
            let userEmail = $('#login-email').val()
            let userPassword = $('#login-password').val()
            $.ajax({
                url: "{{url('/dangnhap')}}",
                method: 'post',
                data: 
                {
                    email: userEmail,
                    password: userPassword
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if(data == 'fail') {
                        $.notify(`Đăng nhập thất bại`, 'error')
                    }
                    if(data == 'success') {
                        $.notify(`Đăng nhập thành công`, 'success')
                        window.location.replace(".");
                    }
                    if(data == 'disabled')
                        $.notify(`Rất tiếc, tài khoản của bạn đã bị khóa!`, 'error')
                }
            })
        })

        $(document).on('keyup', '.input-search', function(e) {
            let searchKey = $(this).val();
            if(searchKey) {
                $.ajax({
                    url: "/NhaThuoc/get_suggestion",
                    method: 'post',
                    data: {
                        searchKey: searchKey
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if(data) {
                            $('.input-result').css('display', 'block')
                            $('.input-result').html(data)
                        } else {
                            $('.input-result').css('display', 'none')
                        }
                    }
                })
            }  else {
                $('.input-result').css('display', 'none')
            }   

        })

        
    </script>
</body>

</html>