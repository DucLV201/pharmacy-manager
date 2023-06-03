// document.getElementById("printButton").addEventListener("click", function() {
//     // Tạo một cửa sổ in mới
//     var printWindow = window.open("", "_blank");
    
//     // Lấy nội dung HTML của bảng
//     var tableContent = document.getElementById("productTable").outerHTML;
    
//     // Thiết lập nội dung của cửa sổ in là bảng
//     printWindow.document.open();
//     printWindow.document.write('<html><head><title>Hóa đơn</title></head><body>' + tableContent + '</body></html>');
//     printWindow.document.close();
    
//     // In cửa sổ in
//     printWindow.print();
//     });

function getCurrentDateTimeVietnam() {
   var currentDate = new Date();
   currentDate.setMinutes(currentDate.getMinutes() + currentDate.getTimezoneOffset() + 420);
   
   var day = currentDate.getDate();
   var month = currentDate.getMonth() + 1;
   var year = currentDate.getFullYear();
   var hour = currentDate.getHours();
   var minute = currentDate.getMinutes();
   var second = currentDate.getSeconds();
 
   var dateTimeVietnam = day + '/' + month + '/' + year + ' ' + hour + ':' + minute + ':' + second;
   return dateTimeVietnam;
 }

function exportOrder($orderCode) {
   var orderCode = $orderCode;
   var Datetime = getCurrentDateTimeVietnam();
   

   var sumbill = $('#totalAmount').text();
   
// Tạo nội dung bảng hóa đơn
var tableContent = document.getElementById("productTable").outerHTML;

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
}

function insertRetail(){
    // Trích xuất thông tin từ bảng sản phẩm
   var products = [];
   $('#productTable tbody tr').each(function() {
    var productId = $(this).data('id');
    var quantity = $(this).find('td:nth-child(2)').text();
    var productQuantity = parseInt(quantity.replace(/[^0-9]/g, ''));
    var form = (quantity.replace(/[0-9]/g, ''));
    var formid = $(this).find('td:nth-child(2)').data('formid');
      
      // Thêm thông tin sản phẩm vào mảng products
      var product = {
        id: productId,
        quantity: productQuantity,
        form: form,
        formid: formid,
      };
      products.push(product);
   });

   // Gửi thông tin sản phẩm qua Ajax đến API hoặc route để lưu vào cơ sở dữ liệu
   $.ajax({
        url: addProductUrl, 
        method: 'POST',
        data: { products: products ,
        _token: token    
        },
      success: function(response) {
         // Xử lý phản hồi thành công
         exportOrder(response);
         checkout();
         console.log(response);
      },
      error: function(error) {
         // Xử lý lỗi
         console.log(error);
      }
   });

}
function insertRetail_VNP(){
   // Trích xuất thông tin từ bảng sản phẩm
  var products = [];
  var sumbill1 = parseInt($('#totalAmount').text().replace(/[^0-9]/g, ''));  
  $('#productTable tbody tr').each(function() {
   var productId = $(this).data('id');
   var quantity = $(this).find('td:nth-child(2)').text();
   var productQuantity = parseInt(quantity.replace(/[^0-9]/g, ''));
   var form = (quantity.replace(/[0-9]/g, ''));
   var formid = $(this).find('td:nth-child(2)').data('formid');
   
     // Thêm thông tin sản phẩm vào mảng products
     var product = {
       id: productId,
       quantity: productQuantity,
       form: form,
       formid: formid,
     };
     products.push(product);
  });

  // Gửi thông tin sản phẩm qua Ajax đến API hoặc route để lưu vào cơ sở dữ liệu
  $.ajax({
       url: addProductUrl1, 
       method: 'POST',
       data: { products: products ,
       sumbill: sumbill1,
       _token: token    
       },
       dataType: 'json',
     success: function(response) {
      if (response.code === "00") {
         window.location.href = response.data;
     } else {
         console.log(response.message);
     }
     },
     error: function(error) {
        // Xử lý lỗi
        console.log(error);
     }
  });

}
function checkout() {
   // Lấy thẻ tbody của bảng
   var tbody = document.getElementById("productTable").getElementsByTagName("tbody")[0];
   
   // Xóa tất cả các hàng trong tbody
   while (tbody.firstChild) {
      tbody.removeChild(tbody.firstChild);
   }
   //xử lý tổng tiền
   var total = 0;
   $('#productTable tbody tr').each(function() {
      var price = parseInt($(this).find('td:nth-child(4)').text().replace(/[^0-9]/g, ''));
      total += price;
   });
   var formattedNumber = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total);
   $('#totalAmount').text(formattedNumber);
}

document.getElementById("printButton").addEventListener("click", function() {
   var checkpay = $('#selectPay').val(); 
   var table = document.getElementById('productTable');
   var tbody = table.getElementsByTagName('tbody')[0];
   var rows = tbody.getElementsByTagName('tr');

   if (rows.length === 0) {
      $.notify(`Chưa chọn sản phẩm`, 'warn')
   }else{
      if(checkpay == 1){
         insertRetail();
         
      }else if(checkpay == 2){
         insertRetail_VNP();
      }else{
         $.notify(`Chọn phương thức thanh toán cho khách hàng`, 'warn');
      }
   }
   
   //insertRetail();
    //exportOrder();
    


});