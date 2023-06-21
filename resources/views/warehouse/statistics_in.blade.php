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
   .img_tt{
      width: 100px;
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
    .dong{
      float:right;
    }
</style>
<?php 
   use Illuminate\Support\Str;
?>
<!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Thống kê nhập thuốc</h4>
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

   <table id="posts" class="table table-striped table-bordered" style="width:100%">
      <thead>
         <tr>
            <th>Mã Thuốc</th>
            <th>Lô thuốc</th>
            <th>Tên nhà cung cấp</th>
            <th>Số lượng nhập</th>
            <th>Số lượng còn</th>
            <th>Ngày sản xuất</th>
            <th>Hạn sử dụng</th>
            <th>Trình trạng</th>
            <th></th>
         </tr>
      </thead>
      <tbody>
      @foreach($data as $infor)
         <tr>
            <td>{{$infor->id_product}}</td>
            <td>{{$infor->id_bath}}</td>
            <td style="color:#038189">{{$infor->name_supplier}}</td>
            <td >{{$infor->count}}</td>
            <td >{{$infor->count_acc}}</td>
            <td>{{$infor->export}}</td>
            <td>{{$infor->expiry}}</td>
            <td style="color:red">{{$infor->status}}</td>
            <td class="trinhtrang" data-id="{{$infor->id_bath}}">
            @if($infor->check=="1")
               Đã gửi yêu cầu
            @elseif($infor->check=="2")
               Đã thu hồi
            @elseif($infor->check=="3")
               
            @else
               <button  class="btn btn-secondary thuhoi" data-bath-id="{{$infor->id_bath}}">Yêu cầu thu hồi</button>
            @endif
            
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
   <div class="postcate-form">
      <i class="fa fa-times-circle dong"></i>
      <div class="form-group">
         <form id="post_cate">
            <label class="form-label" for="lydo">Lý do thu hồi:</label><br>
            <input class="form-control" type="text" name="lydo" id="lydo"><br>
            <input class="form-control" type="hidden" name="bath_id" id="bath_id">
            <button class="btn btn-secondary mt-3 btngui"  type="button">Gửi yêu cầu</button>
         </form>
      </div> 
   </div>  
</div>

<script>
$(document).ready(function() {
   $('#posts').DataTable({
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
   $('.dong').click(function() {
            $('.postcate-form').hide();
      }); 
   $('.thuhoi').click(function(e) {
      var bathId = $(this).data('bath-id');
      $('#bath_id').val(bathId);
      $('.postcate-form').show();     
            
   });

   $('.btngui').click(function(e) {
         e.preventDefault();
         var lydo = $('#lydo').val();
         var bathId = $('#bath_id').val();
         $.ajax({
            url: '{{URL::to("/request-recovery")}}',
            method: 'POST',
            data: {
               bathid: bathId,
               lydo: lydo,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
               $('.trinhtrang[data-id="'+ bathId +'"]').text("Đã gửi yêu cầu");
               $('.thuhoi[data-bath-id="'+ bathId +'"]').remove();
               $('.postcate-form').hide();

            },
            error: function(xhr, status, error) {
                console.log(error);
            }
            
   });     
   } ); 
} );
</script>        
            
@endsection