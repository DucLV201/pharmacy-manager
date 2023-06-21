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
</style>
<!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Lịch sử bán hàng</h4>
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
   
   <form id="filterForm" class="form">
      <label for="startDate">Ngày bắt đầu:</label>
      <input type="date" id="startDate" name="startDate" class="form-control">
      <label for="endDate">Ngày kết thúc:</label>
      <input type="date" id="endDate" name="endDate" class="form-control">
      <button class="btn btn-secondary" type="submit">Lọc</button>
   </form>
   <table id="billSale" class="table table-striped table-bordered" style="width:100%">
      <thead>
         <tr>
            <th>Mã đơn hàng</th>
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
               {{number_format($bill->total_price, 0, ',', '.')}}
               @endif
               @endforeach
               ₫
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
    $('#filterForm').submit(function(e) {
        e.preventDefault();
        
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        
        // Cộng thêm 1 ngày cho endDate
        var nextDay = new Date(endDate);
        nextDay.setDate(nextDay.getDate() + 1);
        var adjustedEndDate = nextDay.toISOString().split('T')[0];
        // Gửi yêu cầu Ajax đến server để lọc đơn hàng
        $.ajax({
            url: "{{url('/filter-bill')}}", // Đường dẫn đến route hoặc controller xử lý yêu cầu lọc
            method: 'POST',
            data: {
               startDate: startDate,
               endDate: adjustedEndDate
            },
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Xóa các hàng đang hiển thị trong bảng
               $('#billSale tbody').empty();
               
               // Thêm các hàng mới từ dữ liệu lọc vào bảng
               response.forEach(function(order) {
                  var formattedNumber2 = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(order.total_price);
                  var row = '<tr>' +
                              '<td>' + order.id + '</td>' +
                              '<td>' + order.name + '</td>' +
                              '<td>' + formattedNumber2 + '</td>' +
                              '<td>' + order.timestamp + '</td>' +
                              '<td><button class="btn btn-warning"><a href="chi-tiet-hoa-don/'+ order.id +'">Chi tiết</a></button></td>' +
                              '</tr>';
                              
                  $('#billSale tbody').append(row);
               });
            },
            error: function() {
                
            }
        });
    });
         
    } ); 
</script>        
            
@endsection