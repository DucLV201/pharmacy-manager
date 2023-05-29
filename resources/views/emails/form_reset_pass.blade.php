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

<div class="col-lg-4 col-sm-12 p-3" style="margin:auto;">
   <form 
      id="form-doimatkhau" 
      >
      <h5>Hãy đổi mật khẩu của bạn,&nbsp {{$user->fullname}}</h5>
      <div class="form-group">
         <label for="password" class="form-label">Mật khẩu</label>
         <input type="password" autocomplete="off" class="form-control" id="password" name="password">
         <p class="form-message"></p>
      </div>
      <div class="form-group">
         <label for="passwordcf" class="form-label">Nhập lại mật khẩu</label>
         <input type="password" autocomplete="off" class="form-control" id="passwordcf" name="passwordcf">
         <p class="form-message"></p>
      </div>
      <input type="hidden" value="{{$user->id}}" name="id_hidden" id="id_hidden">
      <button 
         class="btn btn-lg btn-block btn-signin text-uppercase text-white mt-3" 
         style="background: #F5A623"
         type="submit"
         id="btn-dmk"
         >Đổi mật khẩu
      </button>
      
   </form>
</div>
<script src="{{asset('frontend/js/validator.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
<script>
    Validator({
        form: '#form-doimatkhau',
        formGroup: '.form-group',
        message: '.form-message',
        rules: [
            Validator.isPassword('#password'),
            Validator.isConfirm('#passwordcf', function() {
                return document.querySelector('#form-doimatkhau #password').value;
            }, 'Nhập lại mật khẩu chưa đúng')
        ],
        onSubmit: function(data) {
            let userPassword = $('#password').val();
            let idUser = $('#id_hidden').val();
            $.ajax({
                url: "{{url('/password/reset1')}}",
                method: 'post',
                data: {
                    password: userPassword,
                    id: idUser
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if(data == 'fail')
                        $.notify('Đổi mật khẩu thất bại', 'error');
                    if(data == 'success') {
                        $.notify('Đổi mật khẩu thành công', 'success');
                        window.location.replace("/nhathuocbinhan/public/");
                    }
                }
            });
        }
    });
</script>
@endsection
