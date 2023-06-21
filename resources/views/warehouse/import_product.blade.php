@extends('warehouse.header')
@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"></script>
<style>
.img_tt{
      width: 100px;
   }
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
      margin-bottom:10px;
      background: #188189;
      border-top-right-radius: 2px;
      border-top-left-radius: 2px;">
      Nhập thuốc
 </div>
 <div class="product-form">
   <form id="product">
      <div class="form-group">
         <label style="font-weight: 800;" class="form-label" for="product_bath">Mã lô thuốc:</label>
         <input style="width:300px;" class="form-control" type="text" name="product_bath" id="product_bath" >
      </div>
      <div class="form-group">
         <label style="font-weight: 800;" class="form-label" for="name_bath">Tên nhà cung cấp:</label>
         <input style="width:75%;" class="form-control" type="text" name="name_bath"  id="name_bath">
      </div>
      <div class="form-group">
         <label style="font-weight: 800;" class="form-label" for="postcate_id">Thuốc:</label>
         <select class="form-control" id="product_id">
                @foreach ($all_product as $infor)       
                  <option   value="{{ $infor->id }}">{{ $infor->id }} - {{ $infor->name }}</option>
                @endforeach
         </select>
      </div>
    
      
      <div class="form-group">
        <label for="startDate">Ngày sản xuất:</label>
        <input type="date" id="startDate" name="startDate" class="form-control">
        <label for="endDate">Hạn sử dụng:</label>
        <input type="date" id="endDate" name="endDate" class="form-control">
      </div>
      <div class="form-group">
         <label style="font-weight: 800;" class="form-label" for="address">Địa chỉ:</label>
         <input style="width:300px;" class="form-control" type="text"  name="address" id="address">
      </div>
      <div class="form-group">
         <label style="font-weight: 800;" class="form-label" for="phone">Số điện thoại:</label>
         <input style="width:300px;" class="form-control" type="text" name="phone" id="phone">
      </div>
      <div class="form-group">
         <label style="font-weight: 800;" class="form-label" for="count">Số lượng nhập:</label>
         <input style="width:150px;" class="form-control" type="text" name="count" id="count">
      </div>
      <div class="form-group">
         <button class="btn btn-info mt-3 btnthem" type="button">Thêm</button>
      </div>
   </form>
</div>


</div>
<script src="{{asset('frontend/js/notify.js')}}"></script>

<script>
$(document).ready(function() {
    $('.btnthem').click(function() {
        // Lấy giá trị từ các trường input và select
        var product_bath = $('#product_bath').val();
        var name_bath = $('#name_bath').val();
        var product_id = $('#product_id').val();
        var address = $('#address').val();
        var phone = $('#phone').val();
        var count = $('#count').val();
        var exportt = $('#startDate').val();
        var expiry = $('#endDate').val();
        // Xử lý thêm sản phẩm vào cơ sở dữ liệu bằng Ajax
        $.ajax({
            url: '{{URL::to("/import-product")}}',
            method: 'POST',
            data: {
                product_bath: product_bath,
                name_bath: name_bath,
                product_id: product_id,
                address: address,
                phone: phone,
                count: count,
                exportt: exportt,
                expiry: expiry,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
                // Xử lý thành công
                $.notify('Cập nhật phẩm thành công', 'success');
                location.reload();
            },
            error: function(xhr, status, error) {
                // Xử lý lỗi
                console.log(error);
            }
        });
    });
    
         
    } ); 
</script>        
            
@endsection