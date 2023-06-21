@extends('invoice.header')
@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"></script>
<style>
   .form{
   padding: 15px 15px 10px 0px;
    font-size: 14px;
    font-weight: 700;
   }
   .postcate-form {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: white;
      padding: 20px;
      /* width:60%; */
      z-index: 9999;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }
    .btnsua{
      display: none;
      position: static;
    }
    .btnthem{
      display: none;
      position: static;
    }
    .dong{
      float:right;
    }
</style>
<!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Danh mục bài viết</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="d-md-flex">
                            <ol class="breadcrumb ms-auto">
                                <li><a href="#" class="fw-normal">.</a></li>
                            </ol>
                            
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
<div class="container-fluid">
<button class="btn btn-info themmoi" style = "margin-bottom:15px;">Thêm mới </button>
   <table id="billSale" class="table table-striped table-bordered" style="width:100%">
      <thead>
         <tr>
            <th>Mã danh mục</th>
            <th>Tên danh mục</th>
            <th>Thao tác</th>
         </tr>
      </thead>
      <tbody>
         @foreach($post_cate as $infor)
         <tr>
            <td>{{$infor->id}}</td>
            <td>{{$infor->title}}</td>
            <td>
               <button class="btn btn-warning sua" data-id="{{$infor->id}}"  data-name="{{$infor->title}}">
               <a href="">Sửa</a>
               </button>
               <button data-id="{{$infor->id}}" class="btn btn-danger xoa">Xóa </button>
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
   <div class="postcate-form">
      <i class="fa fa-times-circle dong"></i>
      <div class="form-group">
         <form id="post_cate">
            <label class="form-label" for="category_name">Tên danh mục:</label><br>
            <input class="form-control" type="text" name="category_name" id="category_name"><br>
            <input class="form-control" type="hidden" name="category_id" id="category_id">
            <button class="btn btn-info mt-3 btnthem"  type="button">Thêm danh mục</button>
            <button class="btn btn-info mt-3 btnsua"  type="button">Cập nhật</button>
         </form>
      </div> 
   </div>  
</div>
<script src="{{asset('frontend/js/notify.js')}}"></script>
<script>
$(document).ready(function() {
   
      $('.themmoi').click(function() {
         $('.postcate-form').show();
         $('.btnthem').show();
      });
      $('.dong').click(function() {
            $('.postcate-form').hide();
            $('.btnthem').hide();
            $('.btnsua').hide();
      }); 
      $('.btnthem').click(function(e) {
         e.preventDefault();
         var name_cate = $('#category_name').val();
         $.ajax({
            url: '{{URL::to("/add-postcate")}}',
            method: 'POST',
            data: {
               name: name_cate,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
               $.notify('Thêm thành công', 'success')
               location.reload();

            },
            error: function(xhr, status, error) {
                console.log(error);
            }
         });   
      });
      $('.xoa').click(function(e) {
         e.preventDefault();
         var id_cate = $(this).data('id');
         $.ajax({
            url: '{{URL::to("/remove-postcate")}}',
            method: 'POST',
            data: {
               id: id_cate,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
               $.notify('Xóa thành công', 'success')
               location.reload();

            },
            error: function(xhr, status, error) {
                console.log(error);
            }
            
         });
      });
      $('.sua').click(function(e) {
         e.preventDefault();
         var name_cate = $(this).data('name');
         var id_cate = $(this).data('id');
         $('#category_name').val(name_cate);
         $('#category_id').val(id_cate);
         $('.btnsua').show();
         $('.postcate-form').show();
      });
      $('.btnsua').click(function(e) {
         e.preventDefault();
         var name_cate = $('#category_name').val();
         var id_cate = $('#category_id').val();
         $.ajax({
            url: '{{URL::to("/update-postcate")}}',
            method: 'POST',
            data: {
               name: name_cate,
               id: id_cate,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
               $.notify('Sửa thành công', 'success')
               location.reload();

            },
            error: function(xhr, status, error) {
                console.log(error);
            }
         });   
      });   
    } ); 
</script>        
            
@endsection