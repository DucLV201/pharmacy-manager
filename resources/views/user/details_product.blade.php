@extends('welcome')
@section('content')

<link rel="stylesheet" href="{{asset('/frontend/css/categories.css')}}">
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

<section class="product-page mb-4">
  <div class="container">
     <!-- chi tiết 1 sản phẩm -->
     <div class="product-detail bg-white p-4">
        <div class="row">
           <!-- ảnh  -->
           @foreach($images as $value)
           <div class="col-md-5 khoianh">
              <div class="anhto mb-4">
                 <a class="active" href="{{asset('frontend/images/'.$value->url)}}" data-fancybox="thumb-img">
                 <img class="product-image" src="{{asset('frontend/images/'.$value->url)}}" style="width: 100%;">
                 </a>
                 <a href="{{asset('frontend/images/'.$value->url)}}" data-fancybox="thumb-img"></a>
              </div>
            @break
            @endforeach
              <div class="list-anhchitiet d-flex mb-4" style="margin-left: 2rem;">
                  @foreach($images as $key =>$value)
                  @if($key == 0)
                  <img class="thumb-img thumb1 mr-3 vienvang" src="{{asset('frontend/images/'.$value->url)}}">
                  @else
                  <img class="thumb-img thumb2 mr-3" src="{{asset('frontend/images/'.$value->url)}}">
                  @endif
                  @endforeach
              </div>
           </div>
           @foreach($product_details as $value)
           <!-- thông tin sản phẩm -->
           <div class="col-md-7 khoithongtin">
              <div class="row">
                 <div class="col-md-12 header">
                    <h4 class="ten">{{$value->name}}</h4>
                    <div class="masp">{{$value->id}}</div>
                 </div>
                 <div class="scrollable-content" style="height: 550px;">
                    <div class="col-md-12">
                       <div></div>
                       <?php 

                              $price = $value->price;
                              $num1 = $value->numberone;
                              $num2 = $value->numbertwo;
                              $price1 = $price * $num2;
                              $price2 = $price * $num1 * $num2;
                              $unit1 = "";
                              $unit2 = "";
                              $unit3 = "";
                              //dd($price);
                        ?>
                       <div class ="prices">
                          <div class="price"><span class="css-3caoa3" id="content">{{number_format($price2, 0, ',', '.')}} ₫</span>
                          
                          <span class="css-sa9vou">&nbsp;/&nbsp;</span>
                           @if($value->id_form == 1)
                           <span class="css-sa9vou" id="content1">Tuýp</span>                         
                           @elseif($value->id_form == 2)
                           <span class="css-sa9vou" id="content1">Chai</span>                                                             
                           @else
                           <span class="css-sa9vou" id="content1">Hộp</span>                                
                           @endif  
                        </div>
                       </div>
                       
                       
                       <div class="css-43fwwj">
                          <table class="content-list">
                             <tbody>
                                <tr class="nb">
                                   <td class="nb">
                                      <p class="text-1c4">Chọn đơn vị tính</p>
                                   </td>
                                   <td class="nb">
                                   @if($value->id_form == 6)
                                    <button class ="btn-type" id="button1">Hộp</button>
                                    <button class ="btn-type" id="button2">Vỉ</button>
                                    <button class ="btn-type" id="button3">Viên</button>
                                    <?php
                                    $unit1 = "Hộp";
                                    $unit2 = "Vỉ";
                                    $unit3 = "Viên"
                                    ?>                           
                                    @elseif($value->id_form == 5)
                                    <button class ="btn-type" id="button1">Hộp</button>
                                    <button class ="btn-type" id="button3">Ống</button> 
                                    <?php
                                    $unit1 = "Hộp";
                                    $unit3 = "Ống";
                                    ?>                            
                                    @elseif($value->id_form == 4)
                                    <button class ="btn-type" id="button1">Hộp</button>
                                    <button class ="btn-type" id="button3">Gói</button> 
                                    <?php
                                    $unit1 = "Hộp";
                                    $unit3 = "Gói";
                                    ?>                            
                                    @elseif($value->id_form == 3)
                                    <button class ="btn-type" id="button1">Hộp</button>
                                    <?php
                                    $unit1 = "Hộp";
                                    ?>                       
                                    @elseif($value->id_form == 2)
                                    <button class ="btn-type" id="button1">Chai</button>  
                                    <?php
                                    $unit1 = "Chai";
                                    ?>                             
                                    @else
                                    <button class ="btn-type" id="button1">Tuýp</button> 
                                    <?php
                                    $unit1 = "Tuýp";
                                    ?>                              
                                    @endif 
                                   </td>
                                   <td class="nb"></td>
                                </tr>
                                <tr class="nb">
                                   <td class="nb">
                                      <p class="text-1c4">Danh mục</p>
                                   </td>
                                   <td class="nb">
                                      <p class="text-1c5 c6">{{$value->name_cate}}</p>
                                   </td>
                                   <td class="nb"></td>
                                </tr>
                                <tr class="nb">
                                   <td class="nb">
                                      <p class="text-1c4">Dạng bào chế</p>
                                   </td>
                                   <td class="nb">
                                      <p class="text-1c5">{{$value->dosage_forms}}</p>
                                   </td>
                                   <td class="nb"></td>
                                </tr>
                                <tr class="nb">
                                   <td class="nb">
                                      <p class="text-1c4">Quy cách</p>
                                   </td>
                                   <td class="nb">
                                    @if($value->id_form == 6)
                                    <p class="text-1c5">Hộp {{$value->numberone}} vỉ x {{$value->numbertwo}} viên</p>                           
                                    @elseif($value->id_form == 5)
                                    <p class="text-1c5">Hộp {{$value->numberone}} ống</p>                            
                                    @elseif($value->id_form == 4)
                                    <p class="text-1c5">Hộp {{$value->numberone}} gói</p>                            
                                    @elseif($value->id_form == 3)
                                    <p class="text-1c5">Hộp </p>                       
                                    @elseif($value->id_form == 2)
                                    <p class="text-1c5">Chai </p>                             
                                    @else
                                    <p class="text-1c5">Tuýp </p>                             
                                    @endif 
                                   </td>
                                   <td class="nb"></td>
                                </tr>
                                <tr class="nb">
                                   <td class="nb">
                                      <p class="text-1c4">Xuất xú thương hiệu</p>
                                   </td>
                                   <td class="nb">
                                      <p class="text-1c5">{{$value->address}}</p>
                                   </td>
                                   <td class="nb"></td>
                                </tr>
                                <tr class="nb">
                                   <td class="nb">
                                      <p class="text-1c4">Nhà sản xuất</p>
                                   </td>
                                   <td class="nb">
                                      <p class="text-1c5 upercase">{{$value->name_supplier}}</p>
                                   </td>
                                   <td class="nb"></td>
                                </tr>
                                <tr class="nb">
                                   <td class="nb">
                                      <p class="text-1c4">Mô tả ngắn</p>
                                   </td>
                                   <td class="nb">
                                      <p class="text-1c5">{{$value->description}}</p>
                                   </td>
                                   <td class="nb"></td>
                                </tr>
                             </tbody>
                          </table>
                       </div>
                        @if($value->type_price==1)
                        <form action="{{URL::to('/save-cart')}}" method="POST">
                        {{csrf_field()}}
                          
                          <div class="soluong d-flex">
                             <label class="font-weight-bold">Số lượng: </label>
                             <div class="input-number input-group mb-3">
                                <!-- <div class="input-group-prepend">
                                   <span class="input-group-text btn-spin btn-dec">-</span>
                                   </div> -->
                                <input type="number" min="1" value="1" class="soluongsp  text-center" name="qty">
                                <input type="hidden" value="{{$value->id}}" name="product_id_hidden">
                                <input type="hidden" value="1" name="form_id_hidden" id="pd_form">
                                <!--<div class="input-group-append">
                                   <span class="input-group-text btn-spin btn-inc">+</span>
                                   </div> -->
                             </div>
                          </div>
                          <button class="nutmua btn w-100 text-uppercase" type="submit">
                          <i> Chọn mua </i>
                          </button>
                       </form>
                        @else
                           <h5 style="padding-left: 20px; color: #db4141;">Cần sự tư vấn từ dược sỹ</h5>
                        @endif
                    </div>
                 </div>
                 <!-- thông tin khác của sản phẩm:  tác giả, ngày xuất bản, kích thước ....  -->   
              </div>
           </div>
           <!-- decripstion của 1 sản phẩm: giới thiệu ...  -->
           <div class="product-description col-md-9">
              <!-- 2 tab ở trên  -->
              <nav>
                 <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link text-uppercase active" id="nav-congdung-tab" data-toggle="tab" href="#nav-congdung" role="tab" aria-controls="nav-congdung" aria-selected="true">Công dụng
                    </a>
                    <a class="nav-item nav-link text-uppercase" id="nav-lieudung-tab" data-toggle="tab" href="#nav-lieudung" role="tab" aria-controls="nav-lieudung" aria-selected="false">Liều dùng
                    </a>
                    <a class="nav-item nav-link text-uppercase" id="nav-tacdungphu-tab" data-toggle="tab" href="#nav-tacdungphu" role="tab" aria-controls="nav-tacdungphu" aria-selected="false">Tác dụng phụ
                    </a>
                    <a class="nav-item nav-link text-uppercase" id="nav-baoquan-tab" data-toggle="tab" href="#nav-baoquan" role="tab" aria-controls="nav-baoquan" aria-selected="false">Bảo quản
                    </a>
                    
                 </div>
              </nav>
              <!-- nội dung của từng tab  -->
              <div class="tab-content" id="nav-tabContent">
                 <div class="tab-pane fade ml-3 active show" id="nav-congdung" role="tabpanel" aria-labelledby="nav-congdung-tab">
                    <h6 class="tieude font-weight-bold">Công dụng của {{$value->name}}</h6>
                    @foreach($product_details as $key)
                    <?php
                     $data = $key->uses;
                     
                     // Giải mã các ký tự đặc biệt thành các thẻ HTML tương ứng
                     $content = html_entity_decode($data);
                     ?>
                      <!-- Xuất nội dung đúng định dạng trên trang -->
                     <div class="mtthuoc"><?php echo $content; ?></div>

                    @endforeach
                    
                 </div>
                 <!--nav-liều dùng-->
                 <div class="tab-pane fade ml-3" id="nav-lieudung" role="tabpanel" aria-labelledby="nav-lieudung-tab">
                    <h6 class="tieude font-weight-bold">Liều dùng của {{$value->name}}</h6>
                    @foreach($product_details as $key)
                    <?php
                     $data = $key->dosage;
                     
                     // Giải mã các ký tự đặc biệt thành các thẻ HTML tương ứng
                     $content = html_entity_decode($data);
                     
                     ?>
                      <!-- Xuất nội dung đúng định dạng trên trang -->
                     <div class="mtthuoc"><?php echo $content; ?></div>
                     <div></div>
                    @endforeach
                 </div>
                 <!-- nav-Tác dụng phụ -->
                 <div class="tab-pane fade" id="nav-tacdungphu" role="tabpanel" aria-labelledby="nav-tacdungphu-tab">
                     <h6 class="tieude font-weight-bold">Tác dụng phụ của {{$value->name}}</h6> 
                     @foreach($product_details as $key)
                    <?php
                     $data = $key->side_effects;
                     
                     // Giải mã các ký tự đặc biệt thành các thẻ HTML tương ứng
                     $content = html_entity_decode($data);
                     
                     ?>
                      <!-- Xuất nội dung đúng định dạng trên trang -->
                     <div class="mtthuoc"><?php echo $content; ?></div>
                     <div></div>
                    @endforeach  
                 </div>
                 <div class="tab-pane fade" id="nav-baoquan" role="tabpanel" aria-labelledby="nav-baoquan-tab">
                     <h6 class="tieude font-weight-bold">Bảo quản</h6>   
                     @foreach($product_details as $key)
                    <?php
                     $data = $key->preserve;
                     
                     // Giải mã các ký tự đặc biệt thành các thẻ HTML tương ứng
                     $content = html_entity_decode($data);
                     
                     // Xuất nội dung đúng định dạng trên trang
                     echo $content;
                     ?>
                     <div></div>
                    @endforeach
                 </div>
              </div>
              <!-- het tab-content  -->
           </div>
           @endforeach
           <!-- het product-description -->
        </div>
        <!-- het row  -->
     </div>
     <!-- het product-detail -->
  </div>
  <!-- het container  -->
<script>
   var price={{$price}};
   var price1={{$price1}};
   var price2={{$price2}};
   var unit1="{{$unit1}}";
   var unit2="{{$unit2}}";
   var unit3="{{$unit3}}";   

   

   // Lấy các button và div cần thay đổi giá trị
   var button1 = document.getElementById("button1");
   var button2 = document.getElementById("button2");
   var button3 = document.getElementById("button3");
   var content = document.getElementById("content");
   var pd_form = document.getElementById("pd_form");                     
   // Định nghĩa hàm thay đổi giá trị của div
   function changeContent(value,value1,form) {
      var formattedNumber = (value).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
      content.innerHTML = formattedNumber;
      content1.innerHTML = value1;
      pd_form.value = form;
   }
 

   // Đăng ký sự kiện click cho các button
   button1.addEventListener("click", function() {
   changeContent(price2,unit1,1);

   });
   button3.addEventListener("click", function() {
   changeContent(price,unit3,3);

   });
   button2.addEventListener("click", function() {
   changeContent(price1,unit2,2);

   });

   
</script>
</section>

@endsection