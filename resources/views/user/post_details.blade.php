@extends('welcome')
@section('content')

<link rel="stylesheet" href="{{asset('/frontend/css/categories.css')}}">



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
                                 <!--<img style="padding-left:10px" src="{{asset('frontend/images/'.$cate->url_image)}}"></img>-->
                                <a href="{{asset('danh-muc-san-pham/19')}}">{{$cate->name}}</a><i class="fa fa-chevron-right float-right">
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

<div  >
    <div class="noidung bg-white" style=" width: 100%; padding:20px 12px">
            
        @foreach($all_post as $post)    
        <div class="row">
            <div class="col-lg-6 col-sm-12 mx-auto">
            <h3>{{$post->title}}</h3>
            </div>
        </div>
        @endforeach
        @foreach($all_post as $post) 
        <div class="row">
             <div class="col-lg-6 col-sm-12 mx-auto">
            <?php
                $data = $post->description;
                 // Giải mã các ký tự đặc biệt thành các thẻ HTML tương ứng
                 $content = html_entity_decode($data);
            ?>
            <!-- Xuất nội dung đúng định dạng trên trang -->
            <div class="mtthuoc"><?php echo $content; ?></div>
</div>
        </div>
        @endforeach

    </div>
</div>

@endsection
