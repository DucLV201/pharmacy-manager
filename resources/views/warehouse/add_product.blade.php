@extends('warehouse.header')
@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/29.2.0/classic/ckeditor.js"></script>
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
      Thêm thuốc
 </div>
 <div class="product-form">
   <form id="product">
      <div class="form-group">
         <label style="font-weight: 800;" class="form-label" for="product_code">Mã thuốc:</label>
         <input style="width:300px;" class="form-control" type="text" name="product_code" id="product_code">
      </div>
      <div class="form-group">
         <label style="font-weight: 800;" class="form-label" for="product_name">Tên thuốc:</label>
         <input style="width:75%;" class="form-control" type="text" name="product_name" id="product_name">
      </div>
      <div class="form-group">
         <label style="font-weight: 800;" class="form-label" for="postcate_id">Danh mục:</label>
         <select class="form-control" id="postcate_id">
                @foreach ($prod_cate as $infor)       
                  <option   value="{{ $infor->id }}">{{ $infor->name }}</option>
                @endforeach
         </select>
         <label style="font-weight: 800;" class="form-label" for="product_type">Loại thuốc:</label>
         <select class="form-control" id="product_type">
                <option   value="1">Không kê đơn</option>
                <option   value="2">Cần kê đơn</option>
         </select>
         <label style="font-weight: 800;" class="form-label" for="product_form">Dạng thuốc:</label>
         <select class="form-control" id="product_form">
                @foreach ($prod_form as $infor)       
                  <option   value="{{ $infor->id }}">{{ $infor->name }}</option>
                @endforeach
         </select>
      </div>
      <div class="form-group">
         <label style="font-weight: 800;" for="image">Hình ảnh:</label>
         <input type="file" class="form-control-file" id="image">
      </div>
      <img class="img_tt" id="previewImage">
      <div class="form-group">
         <label style="font-weight: 800;" class="form-label" for="product_dosage_form">Dạng bào chế:</label>
         <input style="width:300px;" class="form-control" type="text" name="product_dosage_form" id="product_dosage_form">
      </div>
      <div class="form-group">
         <label style="font-weight: 800;" class="form-label" for="product_description">Mô tả:</label>
         <input style="width:300px;" class="form-control" type="text" name="product_description" id="product_description">
      </div>
      <div class="form-group">
         <label style="font-weight: 800;" class="form-label" for="product_benefits">Công dụng:</label><br>
         <textarea class="ckeditor" type="text" name="product_benefits" id="product_benefits"></textarea>
         <br>
      </div>
      <div class="form-group">
         <label style="font-weight: 800;" class="form-label" for="product_dosage">Liều dùng:</label><br>
         <textarea class="ckeditor" type="text" name="product_dosage" id="product_dosage"></textarea>
         <br>
      </div>
      <div class="form-group">
         <label style="font-weight: 800;" class="form-label" for="product_side_effects">Tác dụng phụ:</label><br>
         <textarea class="ckeditor" type="text" name="product_side_effects" id="product_side_effects"></textarea>
         <br>
      </div>
      <div class="form-group">
         <label style="font-weight: 800;" class="form-label" for="product_storage">Bảo quản:</label><br>
         <textarea class="ckeditor" type="text" name="product_storage" id="product_storage"></textarea>
         <br>
      </div>
      <div class="form-group">
         <label style="font-weight: 800;" class="form-label" for="product_price">Giá:</label>
         <input style="width:300px;" class="form-control" type="text" name="product_price" id="product_price">
      </div>
      <div class="form-group">
         <label style="font-weight: 800;" class="form-label" for="quantity_one">Số lượng một:</label>
         <input style="width:150px;" class="form-control" type="text" name="quantity_one" id="quantity_one">
         <label style="font-weight: 800;" class="form-label" for="quantity_two">Số lượng hai:</label>
         <input style="width:150px;" class="form-control" type="text" name="quantity_two" id="quantity_two">
      </div>
      <div class="form-group">
         <button class="btn btn-info mt-3 btnthem" type="button">Thêm</button>
      </div>
   </form>
</div>


</div>
<script src="{{asset('frontend/js/notify.js')}}"></script>
<script>
      var editors = [];

    // Lặp qua mỗi thẻ content
    $('.ckeditor').each(function() {
    var textareaId = $(this).attr('id');
    
    ClassicEditor
        .create(document.querySelector('#' + textareaId), {
        language: 'vi'
        })
        .then(newEditor => {
        editors.push(newEditor);
        })
        .catch(error => {
        console.error(error);
        });
    });

    // Lấy dữ liệu từ các editors
    function getEditorsData() {
    var editorsData = [];
    
    for (var i = 0; i < editors.length; i++) {
        var editorData = editors[i].getData();
        editorsData.push(editorData);
    }
    
    return editorsData;
    }
</script>
<script>
    // Lắng nghe sự kiện khi có tệp tin được chọn
    document.getElementById('image').addEventListener('change', function(event) {
        var input = event.target;
        
        // Kiểm tra xem đã chọn tệp tin hay chưa
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            // Đọc dữ liệu của tệp tin
            reader.onload = function(e) {
                var imagePreview = document.getElementById('previewImage');
                
                // Gán dữ liệu vào phần tử hình ảnh
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block'; // Hiển thị phần tử hình ảnh
            }

            reader.readAsDataURL(input.files[0]); // Đọc dữ liệu dưới dạng base64
        }
    });
</script>
<script>
$(document).ready(function() {
    $('.btnthem').click(function() {
   // Lấy giá trị từ các trường input và select
   var productCode = $('#product_code').val();
   var productName = $('#product_name').val();
   var productPrice = $('#product_price').val();
   var postCateId = $('#postcate_id').val();
   var productType = $('#product_type').val();
   var productForm = $('#product_form').val();
   var productDosageForm = $('#product_dosage_form').val();
   var productDescription = $('#product_description').val();
   var productBenefits = getEditorsData()[0];
   var productDosage = getEditorsData()[1];
   var productSideEffects = getEditorsData()[2];
   var productStorage = getEditorsData()[3];
   var quantityOne = $('#quantity_one').val();
   var quantityTwo = $('#quantity_two').val();
   var imagePath = $('#image').val();
   var imageName = imagePath.split('\\').pop();
   // Xử lý thêm sản phẩm vào cơ sở dữ liệu bằng Ajax
   $.ajax({
      url: '{{URL::to("/add-product")}}',
      method: 'POST',
      data: {
         product_code: productCode,
         product_name: productName,
         product_price: productPrice,
         postcate_id: postCateId,
         product_type: productType,
         product_form: productForm,
         product_dosage_form: productDosageForm,
         product_description: productDescription,
         product_benefits: productBenefits,
         product_dosage: productDosage,
         product_side_effects: productSideEffects,
         product_storage: productStorage,
         quantity_one: quantityOne,
         quantity_two: quantityTwo,
         image_name: imageName,
         _token: '{{csrf_token()}}'
      },
      success: function(response) {
         // Xử lý thành công
         $.notify('Thêm sản phẩm thành công', 'success');
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