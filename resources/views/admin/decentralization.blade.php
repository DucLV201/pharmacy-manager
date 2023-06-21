@extends('admin.header')
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
                        <h4 class="page-title">Tài khoản</h4>
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
   <table id="taikhoan" class="table table-striped table-bordered" style="width:100%">
      <thead>
         <tr>
            <th>Mã</th>
            <th>Tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Quyền</th>
            <th>Chặn</th>
            <th>Thao tác</th>
         </tr>
      </thead>
      <tbody>
         @foreach($user as $infor)
         <tr>
            <td>{{$infor->id}}</td>
            <td>{{$infor->fullname}}</td>
            <td>{{$infor->email}}</td>
            <td>{{$infor->phone}}</td>
            <td>
            Admin <input type="radio" name="permission_{{ $infor->id }}" data-value="1" {{ $infor->isadmin == '1' ? 'checked' : '' }}>
            Nhân viên bán hàng <input type="radio" name="permission_{{ $infor->id }}" data-value="2" {{ $infor->isadmin == '2' ? 'checked' : '' }}>
            Nhân viên kho <input type="radio" name="permission_{{ $infor->id }}" data-value="3" {{ $infor->isadmin == '3' ? 'checked' : '' }}>
            Khách hàng <input type="radio" name="permission_{{ $infor->id }}" data-value="0" {{ $infor->isadmin == '0' ? 'checked' : '' }}>
            </td>
            @if($infor->isdisable == 1)
                <td><input data-prod_id="{{$infor->id}}" checked class="disable" type="checkbox" ></td>
            @else
                <td><input data-prod_id="{{$infor->id}}"  class="disable" type="checkbox"></td>
            @endif
            <td>
               </button>
               <button data-id="{{$infor->id}}" class="btn btn-danger xoa">Xóa </button>
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
</div>
<script src="{{asset('frontend/js/notify.js')}}"></script>
<script>
$(document).ready(function() {
    $('#taikhoan').DataTable({
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
    $(document).on('click', '.disable', function() {
                let userId = $(this).data('prod_id')
                if($(this).is(':checked')) {
                    $.ajax({
                        url: "{{url('/user/disable')}}",
                        method: 'post',
                        data: {userId:userId},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $.notify(`Đã chặn người dùng ${userId}`, 'warn')
                            // load_data()
                        }
                    })
              } else {
                $.ajax({
                        url: "{{url('/user/undisable')}}",
                        method: 'post',
                        data: {userId:userId},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $.notify(`Đã bỏ chặn người dùng ${userId} `, 'success')
                        }
                    })
              }
    }); 
    $('input[type=radio][name^=permission_]').change(function() {
            var accountId = $(this).attr('name').split('_')[1];
            var permission = $(this).data('value');

            $.ajax({
                url: "{{url('/user/update-permission')}}",
                method: 'POST',
                data: {
                    accountId: accountId,
                    permission: permission,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response == 1)
                        $.notify(`Người dùng ${accountId} trở thành admin`, 'warn');
                    else if(response == 2)
                        $.notify(`Người dùng ${accountId} trở thành nhân viên bán hàng `, 'warn');
                    else if(response == 3)
                        $.notify(`Người dùng ${accountId} trở thành nhân viên kho`, 'warn');
                    else
                        $.notify(`Người dùng ${accountId} trở thành khách hàng`, 'success');
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
    }); 
    $('#taikhoan').on('click', '.xoa', function(e) {
         e.preventDefault();
         var id = $(this).data('id');
         $.ajax({
            url: '{{URL::to("/remove-user")}}',
            method: 'POST',
            data: {
               id: id,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
               $.notify('Xóa thành công', 'success')
               $('.xoa[data-id="'+ id +'"]').closest('tr').remove();
               //location.reload();

            },
            error: function(xhr, status, error) {
                console.log(error);
            }
            
         });
    });
} ); 
</script>        
            
@endsection