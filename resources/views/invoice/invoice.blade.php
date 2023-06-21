@extends('invoice.header')
@section('content')
<link href="./frontend/admin/css/ds.css" rel="stylesheet">
<script src="./frontend/admin/js/html5-qrcode.min.js"></script>
<style>
   .product-form {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: white;
      padding: 20px;
      /* width:60%; */
      z-index: 9999;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 8px;
      border-bottom: 1px solid #ddd;
    }
    .ds-ip{
      width:100%;
      height:91px;
      border:none;
      font-size:19px;
      font-weight:600;
    }
    .doimau:hover{
      color:red;
    }
    .dsform{
      width:60%;
      margin-left:20px;
    }
</style>
<!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Bán hàng</h4>
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
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
   <!-- Recent Comments -->
   <!-- ============================================================== -->
   <div class="row">
      <!-- .col -->
      <div class="col-md-12 col-lg-6 col-sm-12">
         <div class="card white-box p-0">
         <h3 style="margin: 15px;">Thêm sản phẩm</h3>
         <input type="text" id="productId" placeholder="Nhập ID sản phẩm" autocomplete="off" class="form-control dsform">
         <div class="product-form">
            <h2>Thông tin sản phẩm</h2>
            <div class="row">
               
               <div class="col-lg-4">
                  <img id="productImage" class="card-img-top anh" src="">
               </div>
               <div class="col-lg-8">
                  <form id="productInfoForm">
                  <div class="row">
                     <!-- <div class="col-lg-4">
                        <label for="productName">Tên sản phẩm:</label><br>
                        <label for="productPrice">Giá:</label><br>
                        <label for="productQuantity">Số lượng:</label><br>
                     </div> -->
                     <div class="col-lg-12">
                     <textarea class="ds-ip" type="text" id="productName" readonly></textarea><br>
                     <label for="productPrice" style="font-weight: 700;">Giá:</label>
                     <span  id="productPrice"  style="margin-left: 35px; font-weight: 700; font-size: 19px; "></span><br>
                     <label for="productQuantity" style="font-weight: 700;">Số lượng:</label>
                     <input type="number" id="productQuantity" min="1" max="100" value="1" required>
                     <input type="hidden" id="one"><input type="hidden" id="two"><input type="hidden" id="price">
                     <select id="selectElement">
                        
                     </select><br>
                     </div>
                  </div>

                  <input type="submit" value="Thêm sản phẩm" style="margin: 10px 34px;">

                  </form>
               </div>
            </div>
            
            
         </div>

            <div class="card-body">
               <h3 class="box-title mb-0"></h3>
            </div>
            <!-- <div style="width: 100%" id="reader"></div> -->
         </div>
      </div>
      <div class="col-lg-6 col-md-12 col-sm-12">
         <div class="card white-box pds heigh550">
            <div class="scrollable-content" style="height: 490px;">
               <table class="table" id="productTable">
                  <thead>
                     <tr>
                     <th>Tên</th>
                     <th>Số lượng</th>
                     <th>Giá</th>
                     <th>Thành tiền</th>
                     <th></th>
                     </tr>
                  </thead>
                  <tbody>

                  </tbody>
               </table>
            </div>
            
            <div class="row">
               <hr margin="0px" />
               <div class="col-4 nutpay">
                  <select id="selectPay" style="padding:5px 0px;">
                        <option>Phương thức thanh toán</option>
                        <option value="1">Tiền mặt</option> 
                        <option value="2">Thanh toán VNPAY</option>   
                  </select>
               </div>
               <br>
               <button id="printButton" class="nutthanhtoan col-4" name="redirect">Thanh toán</button>
               <div class="box-orange1 col-4 tongbill">Tổng tiền: <span id="totalAmount">0đ</span></div>
            </div>         
         </div>
      </div>
      <!-- /.col -->
   </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="{{asset('frontend/js/notify.js')}}"></script>
<script src="./frontend/admin/js/hoadon.js"></script>

<script>
$(document).ready(function() {
      

      // Xử lý sự kiện khi nhấn Enter trong input ID sản phẩm
      $('#productId').on('keydown', function(e) {
        if (e.keyCode === 13) {
          e.preventDefault();
          var productId = $(this).val();
          getProductInfo(productId);
        }
      });

      function processProductInfoForm() {
         var productId = $('#productId').val();
         var productName = $('#productName').text();
         var productPrice = $('#productPrice').text();
         var productQuantity = $('#productQuantity').val();
         var form = $('#selectElement').find(':selected').text();
         var formId = $('#selectElement').find(':selected').val();
         addToTable(productId, productName, productPrice, productQuantity, form, formId);
         resetForm();

         // Xử lý tổng tiền
         var total = 0;
         $('#productTable tbody tr').each(function() {
            var price = parseInt($(this).find('td:nth-child(4)').text().replace(/[^0-9]/g, ''));
            total += price;
         });
         var formattedNumber = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total);
         $('#totalAmount').text(formattedNumber);
      }

      // Xử lý sự kiện khi submit form thông tin sản phẩm
      $('#productInfoForm').submit(function(e) {
      e.preventDefault();
      processProductInfoForm();
      });

      // Hàm gọi API lấy thông tin sản phẩm
      function getProductInfo(productId) {
        // Thực hiện AJAX request để lấy thông tin sản phẩm từ API
        $.ajax({
          url: 'path/to/product',
          method: 'GET',
          data: {
            productId: productId
          },
          success: function(response) {
            // Hiển thị thông tin sản phẩm trên form
            $('#productName').text(response.name);
            var formattedNumber = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(response.price);
            $('#productPrice').text(formattedNumber);
            $('#price').val(response.price);
            $('#one').val(response.one);
            $('#two').val(response.two);
            $('#productImage').attr("src", "{{asset('frontend/images')}}/"+response.image);
            var selectOptions = '';
            for (var i = 0; i < response.formOptions.length; i++) {
                  selectOptions += '<option value="' + i + '">' + response.formOptions[i] + '</option>';
            }
            $('#selectElement').html(selectOptions);
            $('.product-form').show();
          },
          error: function(xhr, status, error) {
            console.log(error);
          }
        });
      }
      $('#selectElement').change(function() {
         var selectedValue = $(this).val();
         var price = parseInt($('#price').val());
         var one = $('#one').val();
         var two = $('#two').val();
         if (selectedValue == 0) {
            var newPrice = price * 1;
            var formattedNumber = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(newPrice);
            $('#productPrice').text(formattedNumber);
         } else if (selectedValue == 1) {
            var newPrice = price * one;
            var formattedNumber = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(newPrice);
            $('#productPrice').text(formattedNumber);
         } else {
            var newPrice = price * two;
            var formattedNumber = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(newPrice);
            $('#productPrice').text(formattedNumber);
         }
      });
      // Hàm thêm sản phẩm vào bảng
      function addToTable(productId, productName, productPrice, productQuantity, form, formId) {
         var price = parseInt(productPrice.replace(/[^0-9]/g, ''));//loại bỏ ký tự ko phải số và dấu thập phân
         var total = price*productQuantity;
         var formattedNumber = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total);
         var newRow = '<tr data-id="' + productId + '">' +
          '<td>' + productName + '</td>' +
          '<td data-formid="' + formId + '">' + productQuantity +' '+ form +'</td>' +
          '<td>' + productPrice +'</td>' +
          '<td>' + formattedNumber +'</td>' +
          '<td><i class="fa fa-trash doimau" aria-hidden="true"></i></td>' +
          '</tr>';
        $('#productTable tbody').append(newRow);
      }
      //xóa hàng khỏi bảng
      $(document).on('click', '.fa-trash', function() {
         $(this).closest('tr').remove();
         //xử lý tổng tiền
         var total = 0;
         $('#productTable tbody tr').each(function() {
            var price = parseInt($(this).find('td:nth-child(4)').text().replace(/[^0-9]/g, ''));
            total += price;
         });
         var formattedNumber = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total);
         $('#totalAmount').text(formattedNumber);
      });
      // Hàm reset form
      function resetForm() {
        $('#productId').val('');
        $('#productName').text('');
        $('#productPrice').text('');
        $('#productQuantity').val('1');
        $('.product-form').hide();
      }
      
      
      // function onScanSuccess(decodedText, decodedResult) {
      //    // Handle on success condition with the decoded text or result.
      //    console.log('Scan result: ${decodedText}', decodedResult);
      //    $('#productId').val(decodedText) ;
      //    getProductInfo(decodedText);
      //    // setTimeout(
      //    //     () => {
      //    //         document.forms[1].submit();
                  
      //    //     },
      //    //     2 * 1000
      //    // );
         

      // }
   

      // var html5QrcodeScanner = new Html5QrcodeScanner(
      //    "reader", {
      //       fps: 10,
      //       qrbox: 350,
      //       rememberLastUsedCamera: false,
      //       formats: ["code_128"]
      //    });
      // html5QrcodeScanner.render(onScanSuccess);
});
</script>
<script>
   var employeeCode ="NV0"+"{{$id}}";
   var employeeName = "{{$name}}";
   
   var addProductUrl = '{{URL::to("/them-don-hang")}}';
   var addProductUrl1 = '{{URL::to("/them-don-hang-vnp")}}';
   var token ='{{csrf_token()}}';
   
</script>
@endsection