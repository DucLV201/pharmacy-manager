@extends('warehouse.header')
@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"></script>
<style>

</style>
<?php 
   use Illuminate\Support\Str;
?>

<div class="container-fluid">
<div class="panel-heading"
      style="
      font-size: 1.3rem;
      position: relative;
      height: 37px;
      line-height: 37px;
      letter-spacing: 0.2px;
      color: #000;
      font-size: 24px;
      font-weight: 400;
      padding: 0 16px;
      text-align: center;
      background: #188189;
      border-top-right-radius: 2px;
      border-top-left-radius: 2px;">
      Yêu cầu nhập thuốc
 </div>
   <table id="posts" class="table table-striped table-bordered" style="width:100%">
      <thead>
         <tr>
            <th>Mã thuốc</th>
            <th>Tên thuốc</th>
            <th>Số lượng nhập</th>
            <th>Số lượng còn</th>
            <th>Trình trạng</th>
            <th>Thời gian</th>
         </tr>
      </thead>
      <tbody>
         @foreach($import as $infor)
         <tr>
            <td>{{$infor->id_product}}</td>
            <td style="color:#038189">{{$infor->name}}</td>
            <td>{{$infor->quantity}}</td>
            <td>{{$infor->quantity_remaining}}</td>
            @if($infor->status=="Đã gửi yêu cầu")
            <td style="color:#b16039">Đã gửi yêu cầu</td>
            @elseif($infor->status=="Đã chấp nhận")
            <td style="color:#1f96cc">Yêu cầu được chấp thuận</td>
            @else
            <td style="color:#df1010">Yêu cầu bị từ chối</td>
            @endif
            <td>{{$infor->timestamp}}</td>
         </tr>
         @endforeach
      </tbody>
   </table>
   <div class="panel-heading"
      style="
      font-size: 1.3rem;
      position: relative;
      height: 37px;
      line-height: 37px;
      letter-spacing: 0.2px;
      color: #000;
      font-size: 24px;
      font-weight: 400;
      padding: 0 16px;
      text-align: center;
      background: #188189;
      border-top-right-radius: 2px;
      border-top-left-radius: 2px;">
      Yêu cầu thu hồi thuốc
 </div>
   <table id="posts" class="table table-striped table-bordered" style="width:100%">
      <thead>
         <tr>
            <th>Lô thuốc</th>
            <th>Mã thuốc</th>
            <th>Nhà cung cấp</th>
            <th>Số lượng nhập</th>
            <th>Số lượng còn</th>
            <th>Ngày sản xuất</th>
            <th>Hạn sử dụng</th>
            <th>Lý do</th>
            <th>Trình trạng</th>
            <th>Thời gian</th>
         </tr>
      </thead>
      <tbody>
         @foreach($recall as $infor)
         <tr>
            <td>{{$infor->id_product_bath}}</td>
            <td>{{$infor->id_product}}</td>
            <td style="color:#038189">{{$infor->name_supplier}}</td>
            
            <td>{{$infor->count}}</td>
            <td>{{$infor->count_acc}}</td>
            <td>{{$infor->export}}</td>
            <td>{{$infor->expiry}}</td>
            
            <td style="color:#ce1919">{{$infor->reason}}</td>
            @if($infor->status=="Đã gửi yêu cầu")
            <td style="color:#b16039">Đã gửi yêu cầu</td>
            @elseif($infor->status=="Đã chấp nhận")
            <td style="color:#1f96cc">Yêu cầu được chấp thuận</td>
            @else
            <td style="color:#df1010">Yêu cầu bị từ chối</td>
            @endif
            <td>{{$infor->timestamp}}</td>
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
    
         
    } ); 
</script>        
            
@endsection