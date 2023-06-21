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
</style>
<?php 
   use Illuminate\Support\Str;
?>
<!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Thống kê thuốc</h4>
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
            <th>Mã thuốc</th>
            <th>Tên thuốc</th>
            <th>Số lượng nhập</th>
            <th>Số lượng còn</th>
            <th>Trình trạng</th>
            <th>Thao tác</th>
         </tr>
      </thead>
      <tbody>
      @foreach($data as $infor)
         <tr>
            <td>{{$infor->id_product}}</td>
            <td style="color:#038189">{{$infor->name}}</td>
            <td>{{$infor->count1}}</td>
            <td>{{$infor->count2}}</td>
            @if($infor->status=="Sắp hết" || $infor->status=="Đã hết")
            <td  style="color:red">{{$infor->status}}</td>
            @else
            <td>{{$infor->status}}</td>
            @endif

            <td data-id="{{$infor->id_product}}" class="trinhtrang">
            @if($infor->status=="Sắp hết" || $infor->status=="Đã hết")
            @if($infor->check=="ok")
               Đã gửi yêu cầu
            @else
               <button  class="btn btn-secondary thuhoi" data-prod-id="{{$infor->id_product}}">Yêu cầu nhập thuốc</button>
            @endif
            @endif
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
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
   
   $('#posts').on('click', '.thuhoi', function(e) {
            e.preventDefault();
            var prodID = $(this).data('prod-id');
            
            $.ajax({
            url: '{{URL::to("/request-import")}}',
            method: 'POST',
            data: {
               id: prodID,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
               $('.trinhtrang[data-id="'+ prodID +'"]').text("Đã gửi yêu cầu");
               $('.thuhoi[data-prod-id="'+ prodID +'"]').remove();

            },
            error: function(xhr, status, error) {
                console.log(error);
            }
            
            });
      }); 
         
    } ); 
</script>        
            
@endsection