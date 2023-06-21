@extends('warehouse.header')
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
   .posts-form {
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
                        <h4 class="page-title">Danh mục sản phẩm</h4>
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
<button class="btn btn-info mb-2 themmoi">Thêm mới </button>
   <table id="billSale" class="table table-striped table-bordered" style="width:100%">
      <thead>
         <tr>
            <th>Mã danh mục</th>
            <th>Danh mục cha</th>
            <th>Tên danh mục</th>
            <th>Thao tác</th>
         </tr>
      </thead>
      <tbody>
         @foreach($prod_cate as $infor)
         @if($infor->parent !=0)
         <tr>
            <td>{{$infor->id}}</td>
            @foreach($prod_cate as $infor1)
               @if($infor1->id == $infor->parent)
                  <td style="color:#8e7272;" data-id="{{$infor1->id}}">{{$infor1->name}}</td>
                  @break
               @endif
            @endforeach
            <td>{{$infor->name}}</td>
            <td>
               <button class="btn btn-warning sua" data-id="{{$infor->id}}">
               <a href="">Sửa</a>
               </button>
               <button class="btn btn-danger xoa" data-id="{{$infor->id}}">Xóa </button>
            </td>
         </tr>
         @endif
         @endforeach
      </tbody>
   </table>
   <div class="posts-form">
   
      <i class="fa fa-times-circle dong"></i>
      <form id="posts">
            <div class="form-group">
               <label style="font-weight: 800;" class="form-label" for="cate_name">Tên danh mục:</label><br>
               <input style="width:100%;" class="form-control" type="text" name="cate_name" id="cate_name"><br>
               <input class="form-control" type="hidden" name="cate_id" id="cate_id">
            </div>
            <div class="form-group">
               <label style="font-weight: 800;" class="form-label" for="catee_id">Danh mục cha:</label><br>
               <select class="form-control" id="catee_id" name="catee_id">
               @foreach ($prod_cate as $infor)  
                  @if($infor->parent == 0)     
                     <option   value="{{ $infor->id }}">{{ $infor->name }}</option>
                  @endif
               @endforeach
               </select>
            </div>
            <div class="form-group">
            <button class="btn btn-info mt-3 btnthem"  type="button">Thêm bài viết</button>
            <button class="btn btn-info mt-3 btnsua"  type="button">Cập nhật</button>
            </div>
       
      </form>
   </div>
</div>
<script src="{{asset('frontend/js/notify.js')}}"></script>
<script>
$(document).ready(function() {
   $('#billSale').DataTable({
        "language": {
        "sProcessing":   "Đang xử lý...",
        "sLengthMenu":   "Xem _MENU_ mục",
        "sZeroRecords":  "Không tìm thấy dòng nào phù hợp",
        "sInfo":         "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
        "sInfoEmpty":    "Đang xem 0 đến 0 trong tổng số 0 mục",
        "sInfoFiltered": "(được lọc từ _MAX_ mục)",
        "sInfoPostFix":  "",
        "sSearch":       "Tìm:",
        "sUrl":          "",
        "oPaginate": {
            "sFirst":    "Đầu",
            "sPrevious": "Trước",
            "sNext":     "Tiếp",
            "sLast":     "Cuối"
            }
        }
   } ); 
   $('.themmoi').click(function() {
         resetForm();
         $('.posts-form').show();
         $('.btnthem').show();
   });
   $('.dong').click(function() {
            $('.posts-form').hide();
            $('.btnthem').hide();
            $('.btnsua').hide();
   }); 
   $('.btnthem').click(function(e) {
         e.preventDefault();
         var name = $('#cate_name').val();
         var id_cate = $('#catee_id').val();
         $.ajax({
            url: '{{URL::to("/add-cate")}}',
            method: 'POST',
            data: {
               name: name,
               id_cate: id_cate,
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
   $('#billSale').on('click', '.xoa', function(e) {
         e.preventDefault();
         var id_cate = $(this).data('id');
         $.ajax({
            url: '{{URL::to("/remove-cate")}}',
            method: 'POST',
            data: {
               id: id_cate,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
               $.notify('Xóa thành công', 'warn')
               location.reload();

            },
            error: function(xhr, status, error) {
                console.log(error);
            }
            
         });
   });
   $('#billSale').on('click', '.sua', function(e) {
      e.preventDefault();
      var id_cate = $(this).data('id');
      var $row = $(this).closest('tr');
      var name = $row.find('td:eq(2)').text();
      var id_catee = $row.find('td:eq(1)').data('id');

      $('#cate_name').val(name);
      $('#cate_id').val(id_cate);
      $('#catee_id').val(id_catee);

      $('.btnsua').show();
      $('.posts-form').show();
   } );
   $('.btnsua').click(function(e) {
         e.preventDefault();
         var id = $('#cate_id').val();
         var name = $('#cate_name').val();
         var id_cate = $('#catee_id').val();
         $.ajax({
            url: '{{URL::to("/update-cate")}}',
            method: 'POST',
            data: {
               id: id,
               name: name,
               id_cate: id_cate,
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
   function resetForm() {
      $('#cate_name').val('');
      $('#catee_id').val(1);
   }      
    } ); 
</script>        
            
@endsection