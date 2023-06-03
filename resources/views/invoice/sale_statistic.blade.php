@extends('invoice.header')
@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"></script>


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
      Lịch sử bán hàng
    </div> 
<form id="filterForm" class="form">
    <label for="startDate">Ngày bắt đầu:</label>
    <input type="date" id="startDate" name="startDate">
    
    <label for="endDate">Ngày kết thúc:</label>
    <input type="date" id="endDate" name="endDate">
    
    <button type="submit">Lọc</button>
</form>
   <table id="billSale" class="table table-striped table-bordered" style="width:100%">
      <thead>
         <tr>
            <th>ID đơn hàng</th>
            <th>Người bán</th>
            <th>Tổng tiền</th>
            <th>Thời gian</th>
            <th></th>
         </tr>
      </thead>
      <tbody>
         @foreach($bill_sale as $infor)
         <tr>
            <td>{{$infor->id}}</td>
            <td>{{$infor->name}}</td>
            <td>
               @foreach($bill_sum as $bill)
               @if($bill->id_bill_retail == $infor->id)
                  {{number_format($bill->total_price)}}
               @endif
               @endforeach
                đ
            </td>
            <td>{{$infor->timestamp}}</td>
            <td>
               <button class="btn btn-warning">
               <a href="{{URL::to('chi-tiet-hoa-don/'.$infor->id)}}">Chi tiết</a>
               </button>
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
</div>

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
         
    } ); 
</script>        
            
@endsection