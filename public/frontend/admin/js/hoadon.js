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

function exportOrder() {
    var currentDate = new Date();
// Tạo nội dung bảng hóa đơn
var tableContent = document.getElementById("productTable").outerHTML;document.getElementById("productTable").outerHTML;

// Tạo nội dung trang hóa đơn
var documentContent = "<html><head><title>Hóa đơn</title></head><body>" +
                      "<h1>Nhà thuốc Bình An</h1>" +
                      "<p>Website: www.nhathuocbinhan.com</p>" +
                      "<h2>HÓA ĐƠN BÁN LẺ</h2>" +
                      "<p>Thời gian: " + currentDate + "</p>" +
                      "<p>Mã nhân viên: " + employeeCode + "</p>" +
                      "<p>Tên nhân viên: " + employeeName + "</p>" +
                      "<p>Mã đơn hàng: " + orderCode + "</p>" +
                      tableContent +
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
    var productQuantity = $(this).find('td:nth-child(2)').text();
    var form = $(this).find('td:nth-child(2)').data('formid');
      
      // Thêm thông tin sản phẩm vào mảng products
      var product = {
        id: productId,
        quantity: productQuantity,
        form: form,
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
         console.log(response);
      },
      error: function(error) {
         // Xử lý lỗi
         console.log(error);
      }
   });

}

document.getElementById("printButton").addEventListener("click", function() {
    insertRetail();
    //exportOrder();
    


});