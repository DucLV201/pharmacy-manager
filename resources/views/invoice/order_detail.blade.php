@extends('invoice.header')
@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="container-fluid">
<div 
    class="panel panel-primary">
    <div class="panel-heading"
        style="
            font-size: 1.3rem;
            position: relative;
            height: 37px;
            line-height: 37px;
            letter-spacing: 0.2px;
            color: #000;
            font-size: 18px;
            font-weight: 400;
            padding: 0 16px;
            background: #ddede0;
            border-top-right-radius: 2px;
            border-top-left-radius: 2px;">
      Thông tin người nhận
    </div> 
   
    <div class="table-responsive" > 
      <table class="table table-striped b-t b-light" id="myTable"> 
        <thead> 
          <tr> 
            <th>Họ tên</th> 
            <th>Số điện thoại</th> 
            <th>Địa chỉ</th> 
            <th>Trình trạng đơn hàng</th> 
            <!-- <th style="width:30px;"></th>  -->
          </tr> 
        </thead> 
            <tr> 
                <td>{{$user_infor[0]->receivername}}</td> 
                <td>{{$user_infor[0]->phone}}</td>
                <td>{{$user_infor[0]->address}}</td>
                <td>
                @foreach($order_status as $status)
                    <p>{{$status->content}} - {{$status->timestamp}}</p>
                @endforeach
                </td>
            </tr> 
        <tbody class="user__list"> 
       
        </tbody> 
      </table> 
    </div> 
</div> 

<br><br>

<div 
    class="panel panel-primary">
    <div class="panel-heading"
        style="
            font-size: 1.3rem;
            position: relative;
            height: 37px;
            line-height: 37px;
            letter-spacing: 0.2px;
            color: #000;
            font-size: 18px;
            font-weight: 400;
            padding: 0 16px;
            background: #ddede0;
            border-top-right-radius: 2px;
            border-top-left-radius: 2px;">
      Chi tiết đơn hàng
    </div> 
   
    <div class="table-responsive" > 
      <table class="table table-striped b-t b-light" id="myTable"> 
        <thead> 
          <tr> 
            <th>STT</th>
            <!-- <th></th> -->
            <th>Tên thuốc</th> 
            <th>Giá bán (VND)</th>
            <th>Số lượng</th> 
            <th>Đơn giá (VND)</th>
            <!-- <th style="width:30px;"></th>  -->
          </tr> 
        </thead> 
        <tbody class="user__list"> 
            <?php $id =1; ?>
        @foreach($order_details as $key=>$product)
            <tr> 
                <td>{{$id++}}</td>
                <td>{{$product->name}}</td> 
                <td>{{number_format($product->amount)}} </td>
                <td>{{$product->qtyordered}} {{$product->form}}</td>
                <td>{{number_format($product->amount*$product->qtyordered)}}</td>
            </tr> 
        @endforeach
        
        </tbody> 
      </table> 
    <div class="order_execute">
        <div class="actions" style="display: flex; align-items: center;">
            @if($order_info[0]->orderstatus == 0)
              <button data-order__id="{{$order_info[0]->id}}" class="order__submit btn btn-success">Giao hàng</button>
              <button data-order__id="{{$order_info[0]->id}}" style="margin-left: 20px;" class="order__cancer btn btn-danger">Từ chối</button>
            @elseif($order_info[0]->orderstatus == 1)
              <button data-order__id="{{$order_info[0]->id}}" class="order__success btn btn-info">
                  Giao hàng thành công
              </button> 
            @elseif($order_info[0]->orderstatus == 2)
              <h4 >Đơn hàng đã giao thành công</h4>
            @elseif($order_info[0]->orderstatus == 3)
              <h4 >Đã từ chối</h4>
              <button data-order__id="{{$order_info[0]->id}}" style="margin-left: 20px;" class="order__delete btn btn-danger">
              Xóa
              </button>
            @elseif($order_info[0]->orderstatus == 4)
              <h4 >Người mua đã hủy</h4>
              <button data-order__id="{{$order_info[0]->id}}" style="margin-left: 20px;" class="order__delete btn btn-danger">
              Xóa
            </button>
            @endif
            
        </div>
        <div class="total">
            <h5>Giảm giá: &nbsp{{number_format($order_info[0]->coupon)}}</h5>
            <h5>Phí vận chuyển: {{number_format($order_info[0]->fee)}}</h5>
            <h4 style="font-weight:700">Tổng tiền: {{number_format($order_info[0]->totalmoney)}}</h4>
            <h6>{{$order_info[0]->payment}}</h6>
        </div>
    </div>
    </div> 
</div> 

<br><br>
<style>
    .order_execute {
        display: flex;
        width: 100%;
        padding: 20px 30px;
        box-sizing: border-box;
        justify-content: space-between;
    }
</style>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="{{asset('frontend/js/notify.js')}}"></script>
<script>
    $(document).on('click', '.order__submit', function() {
        if(confirm('Xác nhận giao hàng?')) {
           let orderId = $(this).data('order__id')
           $.ajax({
                url: "{{url('/order_confirm')}}",
                method: 'post',
                data: {
                    orderId: orderId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $.notify('Đã xác nhận đơn hàng thành công', 'success')
                    location.reload();
                }
           })
        }
    })

    $(document).on('click', '.order__success', function() {
      if(confirm('Đơn hàng đã được giao thành công?')) {
        let orderId = $(this).data('order__id')
           $.ajax({
                url: "{{url('/order_success')}}",
                method: 'post',
                data: {
                    orderId: orderId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                  if(data == 'success') {
                    $.notify('Cập nhật đơn hàng thành công', 'success')
                    location.reload();
                  }
                }
           })
      }
    })

    $(document).on('click', '.order__delete', function() {
      if(confirm('Bạn có muốn xóa đơn hàng này?')) {
        let orderId = $(this).data('order__id')
           $.ajax({
                url: "{{url('/order_delete')}}",
                method: 'post',
                data: {
                    orderId: orderId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                  if(data == 'success') {
                    $.notify('Đã xóa đơn hàng thành công', 'success')
                    window.location.replace("{{url('/xu-ly-don-hang')}}");
                  } 

                  if(data == 'failure')
                    $.notify('Cập nhật thất bại', 'warning')
                }
           })
      }
    })
    $(document).on('click', '.order__cancer', function() {
      if(confirm('Đơn hàng có vấn đề và bạn muốn từ chối?')) {
        let orderId = $(this).data('order__id')
           $.ajax({
                url: "{{url('/order_cancer')}}",
                method: 'post',
                data: {
                    orderId: orderId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                  if(data == 'success') {
                    $.notify('Đã từ chối đơn hàng thành công', 'success')
                    location.reload();
                  } 

                  if(data == 'failure')
                    $.notify('Cập nhật thất bại', 'warning')
                }
           })
      }
    })
</script>
        
            
@endsection