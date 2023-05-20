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

<!-- khoi suc khoe  -->
<section class="_1khoi sapphathanh mt-4">
        <div class="container">
            <div class="noidung bg-white" style=" width: 100%;">
                <div class="row">
                    <!--header-->
                    <div class="col-12 d-flex justify-content-between align-items-center pb-2 bg-light">
                        <h2 class="header text-uppercase" style="font-weight: 600;">Góc sức khỏe</h2>
                        
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
        <div class="container" style="margin-bottom:10px" >
            <div class="noidung bg-white" style=" width: 100%;">
            
                    @foreach($all_post as $post)    
                    <div class="row">
                        <div class="col-4">
                            <a href="{{URL::to('/bai-viet/'.$post->id)}}"><img src="./frontend/images/{{$post->img_title}}" alt="Image" style="padding: 20px; border-radius: 28px;"></a>
                        </div>
                        <div class="col-8">
                        <div style="padding:20px">
                            <div class="block">
                                <a href="{{URL::to('/bai-viet/'.$post->id)}}">
                                <span class ="btn-loaisk1">{{$post->cate_name}}</span>
                                </a>
                            </div>
                            <a href="#" class="a_post">
                                <h6>{{$post->title}}</h6>
                            </a>
                            <?php
                                $data = $post->description;
                                $plainText = strip_tags($data);
                                echo $plainText; 
                            ?>...
                        </div>
                        </div>
                    </div>
                    @endforeach

            </div>
        </div>
    </section>
@endsection