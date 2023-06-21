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
                        <h4 class="page-title">Danh mục thuốc</h4>
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
<table id="product" class="table table-striped table-bordered" style="width:100%">
      <thead>
         <tr>
            <th>Mã thuốc</th>
            <th>Tên thuốc</th>
            <th>Dạng bào chế</th>
            <th>Giá</th>
            <th>Nổi bật</th>
            <th>Bán chạy</th>
         </tr>
      </thead>
      <tbody>
      @foreach($product as $infor)
         <tr>
            <td>{{$infor->id}}</td>
            <td>{{$infor->name}}</td>
            <td>{{$infor->dosage_forms}}</td>
            <td>{{number_format($infor->price)}}</td>
            @if($infor->featured == 1)
                <td><input data-prod_id="{{$infor->id}}" checked class="featured" type="checkbox" name="isadmin" ></td>
            @else
                <td><input data-prod_id="{{$infor->id}}"  class="featured" type="checkbox" name="isadmin" ></td>
            @endif
            @if($infor->bestsell == 1)
                <td><input data-prod_id="{{$infor->id}}" checked class="bestsell" type="checkbox" name="isadmin" ></td>
            @else
                <td><input data-prod_id="{{$infor->id}}"  class="bestsell" type="checkbox" name="isadmin" ></td>
            @endif

         </tr>
         @endforeach
      </tbody>
   </table>
</div>

<script src="{{asset('frontend/js/notify.js')}}"></script>
<script>
$(document).ready(function() {
    
    $('#product').DataTable({
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
    $(document).on('click', '.featured', function() {
                let prodId = $(this).data('prod_id')
                if($(this).is(':checked')) {
                    $.ajax({
                        url: "{{url('/featured_enable')}}",
                        method: 'post',
                        data: {prodId:prodId},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $.notify(`${prodId} đã trở thành sản phảm nổi bật`, 'success')
                            // load_data()
                        }
                    })
              } else {
                $.ajax({
                        url: "{{url('/featured_disable')}}",
                        method: 'post',
                        data: {prodId:prodId},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $.notify(`Đã gỡ sản phẩm nổi bật ${prodId}`, 'error')
                            
                        }
                    })
              }
    });

    $(document).on('click', '.bestsell', function() {
                let prodId = $(this).data('prod_id')
                if($(this).is(':checked')) {
                    $.ajax({
                        url: "{{url('/bestsell_disable')}}",
                        method: 'post',
                        data: {prodId:prodId},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $.notify(`${prodId} đã trở thành sản phẩm bán chạy`, 'warn')
                            // load_data()
                        }
                    })
              } else {
                $.ajax({
                        url: "{{url('/bestsell_enable')}}",
                        method: 'post',
                        data: {prodId:prodId},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $.notify(`Đã gỡ sản phẩm bán chạy ${prodId}`, 'info')
                            load_data()
                        }
                    })
              }
    });
} );
 
</script>        
            
@endsection