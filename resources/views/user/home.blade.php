@extends('welcome')
@section('content')
        
    <!-- thanh tieu de "danh muc sach" + hotline + ho tro truc tuyen -->
    <section class="duoinavbar">
        <div class="container text-white">
            <div class="row justify">
                <div class="col-md-3">
                    <div class="categoryheader">
                        <div class="noidungheader text-white">
                            <i class="fa fa-bars"></i>
                            <span class="text-uppercase font-weight-bold ml-1">Danh mục</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
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
     <!-- noi dung danh muc (categories) + banner slider -->
     <section class="header bg-light">
        <div class="container">
        
            <div class="row">
                <div class="col-md-3" style="margin-right: -15px;">
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
                <!-- banner slider  -->
                <div class="col-md-9 px-0">
                    <div id="carouselId" class="carousel slide" data-ride="carousel">
                        <ol class="nutcarousel carousel-indicators rounded-circle">
                            <li data-target="#carouselId" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselId" data-slide-to="1"></li>
                            <li data-target="#carouselId" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <a href="#"><img src="./frontend/images/banner-thuoc1.png" class="img-fluid"
                                        style="height: 386px;" width="900px" alt="First slide"></a>
                            </div>
                            <div class="carousel-item">
                                <a href="#"><img src="./frontend/images/banner-thuoc2.jpg" class="img-fluid"
                                        style="height: 386px;" width="900px" alt="Second slide"></a>
                            </div>
                            <div class="carousel-item">
                                <a href="#"><img src="./frontend/images/banner-thuoc3.png" class="img-fluid"
                                        style="height: 386px;" alt="Third slide"></a>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselId" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselId" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- khoi noi bat  -->
    <section class="_1khoi sachmoi bg-green">
        <div class="container">
            <div class="noidung" style=" width: 100%;">
                <div class="row">
                    <!--header-->
                    <div class="col-12 d-flex justify-content-between align-items-center pb-2 bg-transparent pt-4">
                        <h1 class="header text-uppercase" style="font-weight: 600;">Sản phẩm nổi bật hôm nay</h1>
                        <!-- <a href="{{URL::to('/danh-muc-noi-bat/100')}}" class="btn btn-warning btn-sm text-white">Xem tất cả</a> -->
                    </div>
                </div>
                <div class="khoisanpham" style="padding-bottom: 2rem;">
                    <!-- 1 san pham -->
                    @foreach($all_product as $prod)
                    @if($prod->class == 1)
                    <div class="card">
                        <a href="{{URL::to('/chi-tiet-san-pham/'.$prod->id)}}" class="motsanpham"
                            style="text-decoration: none; color: black;" data-toggle="tooltip" data-placement="bottom"
                            title="{{$prod->name}}">
                            <div class="wrap-img">
                            <?php 
                            $image_url = explode(',', $prod->url)[0]; // lấy giá trị đầu tiên
                            ?>
                            <img class="card-img-top anh" src="./frontend/images/{{$image_url}}"
                                alt="{{$prod->name}}">
                            </div>
                            <div class="card-body noidungsp mt-3">
                                <h3 class="card-title ten">{{$prod->name}}</h3>
                                <small class="tacgia text-muted"></small>
                                @if($prod->id_form == 6)
                                <div class="gia d-flex align-items-baseline"> 
                                    <div class="giamoi">{{number_format($prod->price)}}đ /Viên</div>
                                    <div class="giacu text-muted"></div>
                                </div>
                                <div class="kieusp">
                                    <span >
                                        <p class="kieusp1">Hộp {{$prod->numberone}} vỉ x {{$prod->numbertwo}} viên</p>
                                    </span>
                                </div>
                                @elseif($prod->id_form == 5)
                                <div class="gia d-flex align-items-baseline"> 
                                    <div class="giamoi">{{number_format($prod->price)}}đ /Ống</div>
                                    <div class="giacu text-muted"></div>
                                </div>
                                <div class="kieusp">
                                    <span >
                                        <p class="kieusp1">Hộp {{$prod->numberone}} Ống </p>
                                    </span>
                                </div>
                                @elseif($prod->id_form == 4)
                                <div class="gia d-flex align-items-baseline"> 
                                    <div class="giamoi">{{number_format($prod->price)}}đ /Gói</div>
                                    <div class="giacu text-muted"></div>
                                </div>
                                <div class="kieusp">
                                    <span >
                                        <p class="kieusp1">Hộp {{$prod->numberone}} Gói </p>
                                    </span>
                                </div>
                                @elseif($prod->id_form == 3)
                                <div class="gia d-flex align-items-baseline"> 
                                    <div class="giamoi">{{number_format($prod->price)}}đ /Hộp</div>
                                    <div class="giacu text-muted"></div>
                                </div>
                                <div class="kieusp">
                                    <span >
                                        <p class="kieusp1">Hộp</p>
                                    </span>
                                </div>
                                @elseif($prod->id_form == 2)
                                <div class="gia d-flex align-items-baseline"> 
                                    <div class="giamoi">{{number_format($prod->price)}}đ /Chai</div>
                                    <div class="giacu text-muted"></div>
                                </div>
                                <div class="kieusp">
                                    <span >
                                        <p class="kieusp1">Chai</p>
                                    </span>
                                </div>
                                @else
                                <div class="gia d-flex align-items-baseline"> 
                                    <div class="giamoi">{{number_format($prod->price)}}đ /Tuýp</div>
                                    <div class="giacu text-muted"></div>
                                </div>
                                <div class="kieusp">
                                    <span >
                                        <p class="kieusp1">Tuýp</p>
                                    </span>
                                </div>
                                @endif
                            </div>
                        </a>
                    </div>
                    @endif
                    @endforeach
                </div>
        </div>
    </section>

    <!-- khoi bán chạy  -->
    <section class="_1khoi combohot mt-4">
        <div class="container">
            <div class="noidung bg-white" style=" width: 100%;">
                <div class="row">
                    <!--header -->
                    <div class="col-12 d-flex justify-content-between align-items-center pb-2 bg-light">
                        <h2 class="header text-uppercase" style="font-weight: 600;">Bán chạy nhất</h2>
                        <!-- <a href="{{URL::to('/danh-muc-noi-bat/200')}}" class="btn btn-warning btn-sm text-white">Xem tất cả</a> -->
                    </div>
                </div>
                <div class="khoisanpham">
                    @foreach($all_product as $prod)
                    @if($prod->class == 2)
                    <div class="card">
                        <a href="{{URL::to('/chi-tiet-san-pham/'.$prod->id)}}" class="motsanpham"
                            style="text-decoration: none; color: black;" data-toggle="tooltip" data-placement="bottom"
                            title="{{$prod ->name}}">
                            <div class="wrap-img">
                            <?php 
                            $image_url = explode(',', $prod->url)[0]; // lấy giá trị đầu tiên
                            ?>
                            <img class="card-img-top anh" src="./frontend/images/{{$image_url}}"
                                alt="{{$prod->name}}">
                            </div>
                            <div class="card-body noidungsp mt-3">
                                <h3 class="card-title ten">{{$prod ->name}}</h3>
                                <small class="tacgia text-muted"></small>
                                @if($prod->id_form == 6)
                                <div class="gia d-flex align-items-baseline"> 
                                    <div class="giamoi">{{number_format($prod->price)}}đ /Viên</div>
                                    <div class="giacu text-muted"></div>
                                </div>
                                <div class="kieusp">
                                    <span >
                                        <p class="kieusp1">Hộp {{$prod->numberone}} vỉ x {{$prod->numbertwo}} viên</p>
                                    </span>
                                </div>
                                @elseif($prod->id_form == 5)
                                <div class="gia d-flex align-items-baseline"> 
                                    <div class="giamoi">{{number_format($prod->price)}}đ /Ống</div>
                                    <div class="giacu text-muted"></div>
                                </div>
                                <div class="kieusp">
                                    <span >
                                        <p class="kieusp1">Hộp {{$prod->numberone}} Ống </p>
                                    </span>
                                </div>
                                @elseif($prod->id_form == 4)
                                <div class="gia d-flex align-items-baseline"> 
                                    <div class="giamoi">{{number_format($prod->price/$prod->numberone)}}đ /Gói</div>
                                    <div class="giacu text-muted"></div>
                                </div>
                                <div class="kieusp">
                                    <span >
                                        <p class="kieusp1">Hộp {{$prod->numberone}} Gói </p>
                                    </span>
                                </div>
                                @elseif($prod->id_form == 3)
                                <div class="gia d-flex align-items-baseline"> 
                                    <div class="giamoi">{{number_format($prod->price)}}đ /Hộp</div>
                                    <div class="giacu text-muted"></div>
                                </div>
                                <div class="kieusp">
                                    <span >
                                        <p class="kieusp1">Hộp</p>
                                    </span>
                                </div>
                                @elseif($prod->id_form == 2)
                                <div class="gia d-flex align-items-baseline"> 
                                    <div class="giamoi">{{number_format($prod->price)}}đ /Chai</div>
                                    <div class="giacu text-muted"></div>
                                </div>
                                <div class="kieusp">
                                    <span >
                                        <p class="kieusp1">Chai</p>
                                    </span>
                                </div>
                                @else
                                <div class="gia d-flex align-items-baseline"> 
                                    <div class="giamoi">{{number_format($prod->price)}}đ /Tuýp</div>
                                    <div class="giacu text-muted"></div>
                                </div>
                                <div class="kieusp">
                                    <span >
                                        <p class="kieusp1">Tuýp</p>
                                    </span>
                                </div>
                                @endif
                            </div>
                        </a>
                    </div> 
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- khoi suc khoe  -->
    <section class="_1khoi sapphathanh mt-4">
        <div class="container">
            <div class="noidung bg-white" style=" width: 100%;">
                <div class="row">
                    <!--header-->
                    <div class="col-12 d-flex justify-content-between align-items-center pb-2 bg-light">
                        <h2 class="header text-uppercase" style="font-weight: 600;">Góc sức khỏe</h2>
                        <a href="{{URL::to('/goc-suc-khoe')}}" class="btn btn-warning btn-sm text-white">Xem tất cả</a>
                    </div>
                </div>
                
                <div class="row row-1">
                @foreach($postcates as $cate)    
                    <div class="block">
                        <a href="{{URL::to('/goc-suc-khoe/'.$cate->id)}}">
                        <span class ="btn-loaisk">{{$cate->title}}</span>
                        </a>
                    </div>
                @endforeach
                </div>
                
                
                <div class="row row-1">
                    @foreach($all_post1 as $post)
                    <div class="col-1ds">
                        <a href="{{URL::to('/bai-viet/'.$post->id)}}"><img src="./frontend/images/{{$post->img_title}}" alt="Image"></a>
                        <div class="block" style ="margin-top: 10px">
                            <a href="#">
                            <span class ="btn-loaisk1">{{$post->cate_name}} </span>
                            </a>
                        </div>
                        <a href="{{URL::to('/bai-viet/'.$post->id)}}"><h4>{{$post->title}}</h4></a>
                    </div>
                    @endforeach
                    <div class="col-2ds">
                    @foreach($all_post5 as $post)    
                    
                        <div class="row">
                            <div class="col-4">
                            <a href="{{URL::to('/bai-viet/'.$post->id)}}"><img src="./frontend/images/{{$post->img_title}}" alt="Image"></a>
                            </div>
                            <div class="col-8">
                                <div class="block">
                                    <a href="#">
                                    <span class ="btn-loaisk1">{{$post->cate_name}}</span>
                                    </a>
                                </div>
                                <a href="{{URL::to('/bai-viet/'.$post->id)}}"><h6>{{$post->title}}</h6></a>
                            </div>
                        </div>
                    
                    @endforeach
                    </div>
                      
                </div>
                
            </div>
        </div>
    </section>


    <!-- div _1khoi -- khoi goi y -->
    <section class="_1khoi sachnendoc bg-white mt-4">
        <div class="container">
            <div class="noidung" style=" width: 100%;">
                <div class="row">
                    <!--header-->
                    <div class="col-12 d-flex justify-content-between align-items-center pb-2 bg-transparent pt-4">
                        <h2 class="header text-uppercase" style="font-weight: 600;">Gợi ý hôm nay</h2>
                        
                    </div>
                    <!-- 1 san pham -->
                    @foreach($suggested_product as $prod)
                    <div class="col-lg col-sm-4">
                        <div class="card">
                            <a href="{{URL::to('/chi-tiet-san-pham/'.$prod->id)}}" class="motsanpham" style="text-decoration: none; color: black;"
                                data-toggle="tooltip" data-placement="bottom"
                                title="{{$prod ->name}}">
                                <div class="wrap-img">
                                <?php 
                                $image_url = explode(',', $prod->url)[0]; // lấy giá trị đầu tiên
                                ?>
                                <img class="card-img-top anh" src="./frontend/images/{{$image_url}}"
                                    alt="{{$prod->name}}">
                                </div>
                                <div class="card-body noidungsp mt-3">
                                    <h3 class="card-title ten">{{$prod ->name}}</h3>
                                    <!-- gia sanp pham -->
                                    @if($prod->id_form == 6)
                                    <div class="gia d-flex align-items-baseline"> 
                                        <div class="giamoi">{{number_format($prod->price)}}đ /Viên</div>
                                        <div class="giacu text-muted"></div>
                                    </div>
                                    @elseif($prod->id_form == 5)
                                    <div class="gia d-flex align-items-baseline"> 
                                        <div class="giamoi">{{number_format($prod->price)}}đ /Ống</div>
                                        <div class="giacu text-muted"></div>
                                    </div>
                                    @elseif($prod->id_form == 4)
                                    <div class="gia d-flex align-items-baseline"> 
                                        <div class="giamoi">{{number_format($prod->price)}}đ /Gói</div>
                                        <div class="giacu text-muted"></div>
                                    </div>
                                    @elseif($prod->id_form == 3)
                                    <div class="gia d-flex align-items-baseline"> 
                                        <div class="giamoi">{{number_format($prod->price)}}đ /Hộp</div>
                                        <div class="giacu text-muted"></div>
                                    </div>
                                    @elseif($prod->id_form == 2)
                                    <div class="gia d-flex align-items-baseline"> 
                                        <div class="giamoi">{{number_format($prod->price)}}đ /Chai</div>
                                        <div class="giacu text-muted"></div>
                                    </div>
                                    @else
                                    <div class="gia d-flex align-items-baseline"> 
                                        <div class="giamoi">{{number_format($prod->price)}}đ /Tuýp</div>
                                        <div class="giacu text-muted"></div>
                                    </div>
                                    @endif
                                    <!-- end gia san pham -->
                                    <div><a class="detail" href="{{URL::to('/chi-tiet-san-pham/'.$prod->id)}}">Xem chi tiết</a></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                  
                    
                
                </div>
            </div>
            <hr>
        </div>
    </section>

    @endsection
     