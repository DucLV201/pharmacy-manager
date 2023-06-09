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
                        <h4 class="page-title">Thống kê bán hàng</h4>
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
   <form id="filterForm1" class="form">
      <label for="startDate">Ngày bắt đầu:</label>
      <input type="date" id="startDate" name="startDate" class="form-control">
      <label for="endDate">Ngày kết thúc:</label>
      <input type="date" id="endDate" name="endDate" class="form-control">
      <button class="btn btn-secondary" type="submit">Lọc</button>
   </form>
   <table id="saleStatistic" class="table table-striped table-bordered" style="width:100%">
      <thead>
         <tr>
            <th>Mã thuốc</th>
            <th>Tên thuốc</th>
            <th>Số lượng</th>
            <th>Tổng tiền</th>
         </tr>
      </thead>
      <tbody>
         @foreach($data as $infor)
         <tr>
            <td>{{$infor->id_product}}</td>
            <td>{{$infor->name}}</td>
            <td>{{$infor->count1}}</td>
            <td>
               {{number_format($infor->total_price, 0, ',', '.')}} ₫              
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
   <h5 style="font-weight:700;">Tổng tiền: <span id="totalAmount">0đ</span><h5>
</div>

<script>
$(document).ready(function() {
      tinhtong();
      $('#saleStatistic').DataTable({
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
      function tinhtong(){
         var total = 0;
         $('#saleStatistic tbody tr').each(function() {
                  var price = parseInt($(this).find('td:nth-child(4)').text().replace(/[^0-9]/g, ''));
                  total += price;
         });
         var formattedNumber = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total);
         $('#totalAmount').text(formattedNumber);
      }

      $('#filterForm1').submit(function(e) {
        e.preventDefault();
        
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        
        // Cộng thêm 1 ngày cho endDate
        var nextDay = new Date(endDate);
        nextDay.setDate(nextDay.getDate() + 1);
        var adjustedEndDate = nextDay.toISOString().split('T')[0];
        // Gửi yêu cầu Ajax đến server để lọc đơn hàng
        $.ajax({
            url: "{{url('/filter-ts')}}", // Đường dẫn đến route hoặc controller xử lý yêu cầu lọc
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
               $('#saleStatistic tbody').empty();
               
               // Thêm các hàng mới từ dữ liệu lọc vào bảng
               response.forEach(function(order) {
                  var formattedNumber2 = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(order.total_price);
                  var row = '<tr>' +
                              '<td>' + order.id_product + '</td>' +
                              '<td>' + order.name + '</td>' +
                              '<td>' + order.count1 + '</td>' +
                              '<td>' + formattedNumber2 + '</td>' +
                              '</tr>';
                              
                  $('#saleStatistic tbody').append(row);
               });
               tinhtong();
            },
            error: function() {
                
            }
        });
    });
         
    } ); 
</script>        
            
@endsection