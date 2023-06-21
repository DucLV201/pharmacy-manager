@extends('admin.header')
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
      margin-bottom:10px;
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
            <th>Thời gian</th>
            <th>Trình trạng</th>
         </tr>
      </thead>
      <tbody>
         @foreach($import as $infor)
         <tr>
            <td>{{$infor->id_product}}</td>
            <td style="color:#038189">{{$infor->name}}</td>
            <td>{{$infor->quantity}}</td>
            <td>{{$infor->quantity_remaining}}</td>
            <td>{{$infor->timestamp}}</td>
            @if($infor->status=="Đã gửi yêu cầu")
            <td class="trinhtrang1" data-id="{{$infor->id}}">
               <button class="btn btn-info mb-2 yes1" data-prodd-id="{{$infor->id}}">Chấp nhận </button>
               <button class="btn btn-warning no1" data-prodd-id="{{$infor->id}}">Từ chối</button>
            </td>
            @elseif($infor->status=="Đã chấp nhận")
            <td style="color:#1f96cc" >Đã chấp nhận</td>
            @else
            <td style="color:#1f96cc">Đã từ chối</td>
            @endif
            
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
      margin-bottom:10px;
      text-align: center;
      background: #188189;
      border-top-right-radius: 2px;
      border-top-left-radius: 2px;">
      Yêu cầu thu hồi thuốc
 </div>
   <table id="posts1" class="table table-striped table-bordered" style="width:100%">
      <thead>
         <tr>
            <th>Lô thuốc</th>
            <th>Mã thuốc</th>
            <th>Nhà cung cấp</th>
            <th>Số lượng nhập</th>
            <th>Số lượng còn</th>
            <th>Ngày sản xuất</th>
            <th>Hạn sử dụng</th>
            <th>Thời gian</th>
            <th>Lý do</th>
            <th>Trình trạng</th>
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
            <td>{{$infor->timestamp}}</td>
            <td style="color:#ce1919">{{$infor->reason}}</td>
            @if($infor->status=="Đã gửi yêu cầu")
            <td class="trinhtrang" data-id="{{$infor->id}}">
               <button class="btn btn-info mb-2 yes" data-prod-id="{{$infor->id}}" data-bath-id="{{$infor->id_product_bath}}">Chấp nhận </button>
            <button class="btn btn-warning no" data-prod-id="{{$infor->id}}">Từ chối</button>
            </td>
            @elseif($infor->status=="Đã chấp nhận")
            <td style="color:#1f96cc">Đã chấp nhận</td>
            @else
            <td style="color:#df1010">Đã từ chối</td>
            @endif
            
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
   $('#posts1').DataTable({
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
   $('#posts').on('click', '.yes1', function(e) {
            e.preventDefault();
            var prodID = $(this).data('prodd-id');
            $.ajax({
            url: '{{URL::to("/reply-import-y")}}',
            method: 'POST',
            data: {
               id: prodID,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
               $('.trinhtrang1[data-id="'+ prodID +'"]').text("Đã chấp nhận");
               $('.yes1[data-prodd-id="'+ prodID +'"]').remove();
               $('.no1[data-prodd-id="'+ prodID +'"]').remove();
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
            
            });
      });
      $('#posts').on('click', '.no1', function(e) {
            e.preventDefault();
            var prodID = $(this).data('prodd-id');
            
            $.ajax({
            url: '{{URL::to("/reply-import-n")}}',
            method: 'POST',
            data: {
               id: prodID,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
               $('.trinhtrang1[data-id="'+ prodID +'"]').text("Đã từ chối");
               $('.yes1[data-prodd-id="'+ prodID +'"]').remove();
               $('.no1[data-prodd-id="'+ prodID +'"]').remove();
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
            
            });
      });       
   $('#posts1').on('click', '.yes', function(e) {
            e.preventDefault();
            var prodID = $(this).data('prod-id');
            var bathID = $(this).data('bath-id');
            $.ajax({
            url: '{{URL::to("/reply-recall-y")}}',
            method: 'POST',
            data: {
               id: prodID,
               bathid: bathID,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
               $('.trinhtrang[data-id="'+ prodID +'"]').text("Đã chấp nhận");
               $('.yes[data-prod-id="'+ prodID +'"]').remove();
               $('.no[data-prod-id="'+ prodID +'"]').remove();
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
            
            });
      });
      $('#posts1').on('click', '.no', function(e) {
            e.preventDefault();
            var prodID = $(this).data('prod-id');
            
            $.ajax({
            url: '{{URL::to("/reply-recall-n")}}',
            method: 'POST',
            data: {
               id: prodID,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
               $('.trinhtrang[data-id="'+ prodID +'"]').text("Đã từ chối");
               $('.yes[data-prod-id="'+ prodID +'"]').remove();
               $('.no[data-prod-id="'+ prodID +'"]').remove();
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
            
            });
      });       
} ); 
</script>        
            
@endsection