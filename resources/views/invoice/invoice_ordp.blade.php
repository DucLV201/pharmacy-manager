@extends('invoice.header')
@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"></script>

  

<script>
    $(document).ready(function() {
     
    // Cấu hình các nhãn phân trang
    $('#example').dataTable( {
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
<!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Quản lý đơn hàng</h4>
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
   <table id="example" class="table table-striped table-bordered" style="width:100%">
      <thead>
         <tr>
            <th>Tên người đặt</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Ngày đặt</th>
            <th>Tổng giá tiền</th>
            <th>Tình trạng</th>
            <th>Thao tác</th>
         </tr>
      </thead>
      <tbody>
         @foreach($list_order as $key=>$order)
         <tr>
            <td>{{$order->receivername}}</td>
            <td>{{$order->phone}}</td>
            <td>{{$order->email}}</td>
            <td>{{$order->timestamp}}</td>
            <td><?php echo number_format($order->totalmoney) ?> đ</td>
            @if($order->orderstatus == 0)
            <td style="color:#f97536">Chờ giao hàng</td>
            @elseif($order->orderstatus == 1)
            <td style="color:#009735">Đang giao hàng</td>
            @elseif($order->orderstatus == 2)
            <td style="color:#0093ff">Đã giao</td>
            @elseif($order->orderstatus == 3)
            <td style="color:#130000">Đã từ chối</td>
            @elseif($order->orderstatus == 4)
            <td style="color:#959595">Hủy thanh toán</td>
            @else
            <td style="color:#959595">Đã hủy</td>
            @endif
            <td>
               <button class="btn btn-warning">
               <a href="{{URL::to('chi-tiet-don-hang/'.$order->id)}}">Chi tiết</a>
               </button>
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
</div>

        
            
@endsection