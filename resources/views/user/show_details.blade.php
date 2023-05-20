@extends('welcome')
@section('content') 
<link rel="stylesheet" href="{{asset('frontend/css/categories.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
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
                                <a href="#">{{$cate->name}}</a><i class="fa fa-chevron-right float-right">
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

<div class="container ">
    <div class="row">
      <div class="col-12">
        @foreach($product_cate as $value)
        <?php 
            $id=$value->id
        ?>
        <h5 style = "margin:10px">{{$value->name}}</h5>
        @endforeach
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 d-none d-md-block " id="filter-sidebar">
        <div class="filter vienb">
            
            <h6><i class="fas fa-sort"></i>&nbsp&nbsp&nbsp Bộ lọc nâng cao</h6>
            
            
            <form >
                <div class="form-group">
                <label for="price">Đối tượng:</label>
                <select class="form-control" id="object" onchange="redirectToPage(this)">
                    <?php
                    $name_dt="Tất cả"
                    ?>
                    @foreach($product_cate as $value)
                    <option value="{{URL::to('/danh-muc-san-pham/'.$value->id)}}">Tất cả</option>
                    @endforeach

                    @foreach($product_cate as $value)
                    @foreach($object as $value1)
                    
                    @if($check_object==$value1->name)
                    <option value="{{URL::to('/doi-tuong/'.$value->id.'/'.$value1->name)}}" selected>{{$value1->name}}</option>
                    <?php
                    $name_dt=$value1->name
                    ?>
                    @else
                    <option value="{{URL::to('/doi-tuong/'.$value->id.'/'.$value1->name)}}" >{{$value1->name}}</option>
                    @endif
                    @endforeach
                    @endforeach
                </select>
                </div>
                <div class="form-group">
                <label for="category">Thương hiệu:</label>
                <select class="form-control" id="object" onchange="redirectToPage(this)">
                    @foreach($product_cate as $value)
                    @if($name_dt=="Tất cả")
                    <option value="{{URL::to('/danh-muc-san-pham/'.$value->id)}}">Tất cả</option>
                    @else
                    <option value="{{URL::to('/doi-tuong/'.$value->id.'/'.$name_dt)}}">Tất cả</option>
                    @endif
                    @endforeach
                    
                    @foreach($product_cate as $value)
                    @foreach($trademark as $value1)
                    
                    <option value="{{URL::to('/thuong-hieu/'.$value->id.'/'.$name_dt.'/'.$value1->name_supplier)}}" @if($check_trade==$value1->name_supplier) selected @endif >{{$value1->name_supplier}}</option>
                    @endforeach
                    @endforeach
                </select>
                </div>
                
                
            </form>
            <div class="form-group">
                <label for="price"><strong>Giá:</strong></label>
                <div class="col">
                    <div class="row nom">
                        <input class="form-check-input" type="radio" name="price" id="price1" value="1" onclick="redirectToPage1('{{URL::to('/gia/'.$id.'/1')}}')" @if($price==1) checked @endif>
                        <label class="form-check-label" for="price1">
                        Dưới 100.000đ
                        </label>
                    </div>
                    <div class="row nom">
                        <input class="form-check-input" type="radio" name="price" id="price2" value="2" onclick="redirectToPage1('{{URL::to('/gia/'.$id.'/2')}}')" @if($price==2) checked @endif>
                        <label class="form-check-label" for="price2">
                        100.000đ đến 300.000đ
                        </label>
                    </div>
                    <div class="row nom">
                        <input class="form-check-input" type="radio" name="price" id="price3" value="3" onclick="redirectToPage1('{{URL::to('/gia/'.$id.'/3')}}')" @if($price==3) checked @endif>
                        <label class="form-check-label" for="price3">
                        300.000đ đến 500.000đ
                        </label>
                    </div>
                    <div class="row nom">
                        <input class="form-check-input" type="radio" name="price" id="price4" value="4" onclick="redirectToPage1('{{URL::to('/gia/'.$id.'/4')}}')" @if($price==4) checked @endif>
                        <label class="form-check-label" for="price4">
                        Trên 500.000đ
                        </label>
                    </div>
                    
                </div>
                </div>
            </div>
        </div>
      <div class="col-md-9 col-12">
        <div class="product-list">
          <h6>Danh sách sản phẩm</h6>
          <button id="toggle-filter-btn" class="btn btn-primary d-block d-md-none">Bộ lọc</button>
            <div class="scrollable-content" style="height: 650px;">
                <div class="row">
                @foreach($all_product as $prod)
                <div class="col-md-3 col-6">
                
                    
                        <div class="card1">
                            <a href="{{URL::to('/chi-tiet-san-pham/'.$prod->id)}}" class="motsanpham"
                                style="text-decoration: none; color: black;" data-toggle="tooltip" data-placement="bottom"
                                title="{{$prod->name}}">
                                <div class="wrap-img">
                                    <?php 
                                    $image_url = explode(',', $prod->url)[0]; // lấy giá trị đầu tiên
                                    ?>
                                    <img class="card-img-top anh" src="{{asset('frontend/images/'.$image_url)}}"
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
                    
                        
                </div>
                @endforeach
                </div>
            </div>
        </div> 
        </div>
        </div> 
</div>
<script>
  const filterSidebar = document.getElementById('filter-sidebar');
  const toggleFilterBtn = document.getElementById('toggle-filter-btn');
  const productListRow = document.getElementById('product-list-row');
  
  toggleFilterBtn.addEventListener('click', function() {
    filterSidebar.classList.toggle('d-none');
    productListRow.classList.toggle('col-md-9');
    productListRow.classList.toggle('col-12');
  });
</script>
<script>
  function redirectToPage(selectElement) {
    var selectedOption = selectElement.options[selectElement.selectedIndex].value;
    if (selectedOption !== '') {
      window.location.href = selectedOption;
    }
  }
</script>
<script>
    function redirectToPage1(url) {
        window.location.href = url;
    }
</script>
@endsection