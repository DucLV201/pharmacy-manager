@extends('admin.header')
@section('content')
<link href="./frontend/admin/css/ds.css" rel="stylesheet">
<script src="./frontend/admin/js/html5-qrcode.min.js"></script>
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
   <!-- Recent Comments -->
   <!-- ============================================================== -->
   <div class="row">
      <!-- .col -->
      <div class="col-md-12 col-lg-6 col-sm-12">
         <div class="card white-box p-0">
            <div class="card-body">
               <h3 class="box-title mb-0">Quét mã sản phẩm</h3>
            </div>
            <!--<div style="width: 600px" id="reader"></div>-->
         </div>
      </div>
      <div class="col-lg-6 col-md-12 col-sm-12">
         <div class="card white-box pds heigh550">
            <div class="scrollable-content" style="height: 490px;">
               <table class="table">
                  <thead>
                     <tr>
                     <th>Tên</th>
                     <th>Số lượng</th>
                     <th>Giá</th>
                     <th></th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                     <td>Viên uống trường thọ, trẻ hóa da NMN Premium 21600 (60 viên)</td>
                     <td>5 / viên</td>
                     <td>50.000đ</td>
                     <td><i class="far fa-clock" aria-hidden="true"></i></td>
                     <tr>
                     <td>Viên uống trường thọ, trẻ hóa da NMN Premium 21600 (60 viên)</td>
                     <td>5 / viên</td>
                     <td>50.000đ</td>
                     <td><i class="far fa-clock" aria-hidden="true"></i></td>
                     </tr>
                     <tr>
                     <td>Viên uống trường thọ, trẻ hóa da NMN Premium 21600 (60 viên)</td>
                     <td>5 / viên</td>
                     <td>50.000đ</td>
                     <td><i class="far fa-clock" aria-hidden="true"></i></td>
                     </tr>
                     <tr>
                     <td>Viên uống trường thọ, trẻ hóa da NMN Premium 21600 (60 viên)</td>
                     <td>5 / viên</td>
                     <td>50.000đ</td>
                     <td><i class="far fa-clock" aria-hidden="true"></i></td>
                     <tr>
                     <tr>
                     <td>Viên uống trường thọ, trẻ hóa da NMN Premium 21600 (60 viên)</td>
                     <td>5 / viên</td>
                     <td>50.000đ</td>
                     <td><i class="far fa-clock" aria-hidden="true"></i></td>
                     <tr>
                     <tr>
                     <td>Viên uống trường thọ, trẻ hóa da NMN Premium 21600 (60 viên)</td>
                     <td>5 / viên</td>
                     <td>50.000đ</td>
                     <td><i class="far fa-clock" aria-hidden="true"></i></td>
                     <tr>
                     <tr>
                     <td>Viên uống trường thọ, trẻ hóa da NMN Premium 21600 (60 viên)</td>
                     <td>5 / viên</td>
                     <td>50.000đ</td>
                     <td><i class="far fa-clock" aria-hidden="true"></i></td>
                     <tr>
                  </tbody>
               </table>
            </div>
            
            <div class="box-orange">
               <hr margin="0px" />
               <div class="box-orange1">Tổng tiền: <span>15000000đ</span></div>
            </div>         
         </div>
      </div>
      <!-- /.col -->
   </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<script src="./frontend/admin/js/qr.js"></script>

@endsection