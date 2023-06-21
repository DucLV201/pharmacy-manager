@extends('invoice.header')
@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/29.2.0/classic/ckeditor.js"></script>
<style>
   .form{
   padding: 15px 15px 10px 0px;
    font-size: 14px;
    font-weight: 700;
   }
   .img_tt{
      width: 100px;
   }
   .posts-form {
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
    .btnsua{
      display: none;
      position: static;
    }
    .btnthem{
      display: none;
      position: static;
    }
    .dong{
      float:right;
    }
    .scrollable-content {
    overflow-y: auto;
   }
   .scrollable-content::-webkit-scrollbar {
      width: 0px;
   }
</style>
<?php 
   use Illuminate\Support\Str;
?>
<!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Danh mục bài viết</h4>
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
<button class="btn btn-info themmoi" style = "margin-bottom:15px;">Thêm mới </button>
   <table id="posts" class="table table-striped table-bordered" style="width:100%">
      <thead>
         <tr>
            <th>Mã bài viết</th>
            <th>Danh mục</th>
            <th>Tiêu đề</th>
            <th>Nội dung</th>
            <th>Hình ảnh</th>
            <th>Ngày tạo</th>
            <th>Cập nhật</th>
            <th>Thao tác</th>
         </tr>
      </thead>
      <tbody>
         @foreach($post as $infor)
         <tr>
            <td>{{$infor->id}}</td>
            <td style="color:#038189">{{$infor->name}}</td>
            <td>{{$infor->title}}</td>
            <td>{{ strip_tags(Str::limit($infor->description, 100, '...')) }}</td>
            <td><img class="img_tt" src="{{asset('frontend/images/'.$infor->img_title)}}"></img></td>
            <td>{{$infor->created_at}}</td>
            <td>{{$infor->updated_at}}</td>
            <td>
               <button class="btn btn-warning sua mb-2" data-id1="{{$infor->id}}">
                  <a href="">Sửa</a>
               </button>
               <button class="btn btn-danger xoa" data-id="{{$infor->id}}">Xóa </button>
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
   <div class="posts-form">
   
      <i class="fa fa-times-circle dong"></i>
      <form id="posts">
            <div class="form-group">
               <label style="font-weight: 800;" class="form-label" for="post_name">Tiêu đề:</label><br>
               <input style="width:75%;" class="form-control" type="text" name="post_name" id="post_name"><br>
               <input class="form-control" type="hidden" name="post_id" id="post_id">
            </div>
            <div class="form-group">
               <label style="font-weight: 800;" class="form-label" for="postcate_id">Danh mục:</label><br>
               <select class="form-control" id="postcate_id" name="postcate_id">
               @foreach ($post_cate as $infor)       
                  <option   value="{{ $infor->id }}">{{ $infor->title }}</option>
               @endforeach
               </select>
            </div>
            <div class="form-group">
               <label style="font-weight: 800;" for="image">Hình ảnh:</label>
               
               <input type="file" class="form-control-file" id="image" name="image">
            </div><img class="img_tt" id="previewImage">
            <div class="form-group">
               <label style="font-weight: 800;" class="form-label" for="content">Nội dung:</label><br>
               <div class="scrollable-content" style="max-height: 300px;">
               <textarea class="form-control" type="text" name="content" id="content"></textarea>
            </div>
               <br>
            </div>
            <div class="form-group">
            <button class="btn btn-info mt-3 btnthem"  type="button">Thêm bài viết</button>
            <button class="btn btn-info mt-3 btnsua"  type="button">Cập nhật</button>
            </div>
       
      </form>
   </div>
   
</div>
<script src="{{asset('frontend/js/notify.js')}}"></script>
<script>
      var editor;
		ClassicEditor
			.create( document.querySelector( '#content' ), {
				language: 'vi'
			} )
         .then(newEditor => {
         editor = newEditor;
         })
			.catch( error => {
				console.error( error );
			} );
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
   $('#posts').DataTable({
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
   $('.themmoi').click(function() {
         resetForm();
         $('.posts-form').show();
         $('.btnthem').show();
   });
   $('.dong').click(function() {
            $('.posts-form').hide();
            $('.btnthem').hide();
            $('.btnsua').hide();
   }); 
   $('.btnthem').click(function(e) {
         e.preventDefault();
         var name = $('#post_name').val();
         var id_cate = $('#postcate_id').val();
         var imagePath = $('#image').val();
         var imageName = imagePath.split('\\').pop();
         var content = editor.getData();
         $.ajax({
            url: '{{URL::to("/add-post")}}',
            method: 'POST',
            data: {
               name: name,
               id_cate: id_cate,
               image: imageName,
               content: content,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
               $.notify('Thêm thành công', 'success')
               location.reload();

            },
            error: function(xhr, status, error) {
                console.log(error);
            }
         });   
   }); 
   $('#posts').on('click', '.xoa', function(e) {
         e.preventDefault();
         var id_post = $(this).data('id');
         $.ajax({
            url: '{{URL::to("/remove-post")}}',
            method: 'POST',
            data: {
               id: id_post,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
               $.notify('Xóa thành công', 'warn')
               location.reload();

            },
            error: function(xhr, status, error) {
                console.log(error);
            }
            
         });
   });
   function getPostInfo(postId) {
        $.ajax({
          url: '{{URL::to("/getInfor/post")}}',
          method: 'GET',
          data: {
            id: postId
          },
          success: function(response) {
            $('#post_name').val(response.title);
            $('#post_id').val(response.id);
            $('#postcate_id').val(response.id_cate);
            //$('#image').val(response.img_title);
            editor.setData(response.description);
            $('#previewImage').attr("src", "{{asset('frontend/images')}}/"+response.img_title);
          },
          error: function(xhr, status, error) {
            console.log(error);
          }
      });
   };
   $('#posts').on('click', '.sua', function(e) {
      e.preventDefault();
      var id_post = $(this).data('id1');
      getPostInfo(id_post);
      $('.btnsua').show();
      $('.posts-form').show();
   } );
   $('.btnsua').click(function(e) {
         e.preventDefault();
         var id = $('#post_id').val();
         var name = $('#post_name').val();
         var id_cate = $('#postcate_id').val();
         var imagePath = $('#image').val();
         var imageName = imagePath.split('\\').pop();
         var content = editor.getData();
         $.ajax({
            url: '{{URL::to("/update-post")}}',
            method: 'POST',
            data: {
               id: id,
               name: name,
               id_cate: id_cate,
               image: imageName,
               content: content,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
               $.notify('Sửa thành công', 'success')
               location.reload();

            },
            error: function(xhr, status, error) {
                console.log(error);
            }
         });   
      });
   function resetForm() {
      $('#post_name').val('');
      $('#postcate_id').val(1);
      //$('#image').val(response.img_title);
      editor.setData('');
      $('#previewImage').attr("src", "");
   }
} ); 
</script>        
            
@endsection