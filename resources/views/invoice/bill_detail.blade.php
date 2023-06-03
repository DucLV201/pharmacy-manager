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
      Chi tiết hóa đơn
    </div> 
    <h5 style="margin: 12px 15px;">
        Mã nhân viên: <span style="font-weight:600;"class="employeeName">{{$bill_sale[0]->id_invoice}}</span>&nbsp&nbsp&nbsp
        Tên nhân viên: <span style="font-weight:600;" class="employeeCode">{{$bill_sale[0]->name}}</span>&nbsp&nbsp&nbsp
        Thời gian: <span style="font-weight:600;" class="timeBill">{{$bill_sale[0]->timestamp}}</span>&nbsp&nbsp&nbsp
    </h5>
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
        @foreach($bill_details as $key=>$product)
        <?php 
            $price = $product->price;
            if($product->form=="Hộp")
                $price = $product->price*$product->one*$product->two;
            elseif($product->form=="Vỉ")
                $price = $product->price*$product->two;

        ?>
            <tr> 
                <td>{{$id++}}</td>
                <td>{{$product->name}}</td> 
                <td>{{number_format($price)}}</td>
                <td>{{$product->quantity}} {{$product->form}}</td>
                <td>{{number_format($product->price*$product->quantity_analysis)}}</td>
            </tr> 
        @endforeach
        
        </tbody> 
      </table> 
    <div class="order_execute">
        <div class="actions" style="display: flex; align-items: center;">
              <button data-order__id="{{$bill_sum['id_bill_retail']}}" class="printButton btn btn-success">In hóa đơn</button>
        </div>
        <div class="total">
            <h4 style="font-weight:700" class="totalAmount">Tổng tiền: {{number_format($bill_sum["total_price"])}} đ</h4>
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
    $(document).on('click', '.printButton', function() {
        var orderCode = $(this).data('order__id');
        var Datetime = $('.timeBill').text();
        var employeeCode = $('.employeeCode').text();
        var employeeName = $('.employeeName').text();
        var sumbill = $('.totalAmount').text();
        
        // Tạo nội dung bảng hóa đơn
        var tableContent = document.getElementById("myTable").outerHTML;

        // Tạo nội dung trang hóa đơn
        var documentContent = "<html><head><title>Hóa đơn</title></head><body>" +
                            "<h1>Nhà thuốc Bình An</h1>" +
                            "<p>Website: www.nhathuocbinhan.com</p>" +
                            "<h2>HÓA ĐƠN BÁN LẺ</h2>" +
                            "<p>Thời gian: " + Datetime + "</p>" +
                            "<p>Mã nhân viên: " + employeeCode + "</p>" +
                            "<p>Tên nhân viên: " + employeeName + "</p>" +
                            "<p>Mã đơn hàng: " + orderCode + "</p>" +
                            tableContent +
                            "<strong>Tổng: " + sumbill + "</strong>" +
                            "</body></html>";

        // Tạo cửa sổ in và viết nội dung hóa đơn vào
        var printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.open();
        printWindow.document.write(documentContent);
        printWindow.document.close();
        printWindow.print();
    })

</script>
        
            
@endsection