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
                        <h4 class="page-title">Quản lý thuốc</h4>
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
<button class="btn btn-info" style = "margin-bottom:15px;"><a href="{{URL::to('/them-thuoc')}}">Thêm thuốc</a></button>
<button class="btn btn-warning" style = "margin-bottom:15px;"><a href="{{URL::to('/nhap-thuoc')}}">Nhập thuốc</a></button>
   <table id="posts" class="table table-striped table-bordered" style="width:100%">
      <thead>
         <tr>
            <th>Mã thuốc</th>
            <th>Hình ảnh</th>
            <th>Tên thuốc</th>
            <th>Dạng bào chế</th>
            <th>Mô tả ngắn</th>
            <th>Giá</th>
            <th>Thể loại</th>
            <th>Thao tác</th>
         </tr>
      </thead>
      <tbody>
         @foreach($prod as $infor)
         <tr>
            <td>{{$infor->id}}</td>
            <?php 
                $image_url = explode(',', $infor->url)[0]; // lấy giá trị đầu tiên
            ?>
            <td><img class="img_tt" src="{{asset('frontend/images/'.$image_url)}}"></img></td>
            <td style="color:#038189">{{$infor->name}}</td>
            <td>{{$infor->dosage_forms}}</td>
            <td>{{ strip_tags(Str::limit($infor->description, 100, '...')) }}</td>
            <td>{{number_format($infor->price)}} đ</td>
            @if($infor->type_price==1)
            <td>Không cần kê đơn</td>
            @else
            <td>Cần kê đơn</td>
            @endif
            <td>
               <button style="margin-bottom:5px;" class="btn btn-warning">
               <a href="{{URL::to('/sua-thuoc/'.$infor->id)}}">Sửa</a>
               </button>
               <button class="btn btn-danger xoa" data-id="{{$infor->id}}">Xóa </button>
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
</div>
<script src="{{asset('frontend/js/notify.js')}}"></script>
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
   $('#posts').on('click', '.xoa', function(e) {
         e.preventDefault();
         var id_prod = $(this).data('id');
         $.ajax({
            url: '{{URL::to("/remove-product")}}',
            method: 'POST',
            data: {
               id: id_prod,
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
         
} ); 
</script>        
            
@endsection