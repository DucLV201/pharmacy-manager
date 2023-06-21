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
                        <h4 class="page-title">Thống kê</h4>
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
   <div class="row justify-content-center">
      <div class="col-lg-4 col-md-12">
         <div class="white-box analytics-info">
            <h3 class="box-title">Tổng sản phẩm</h3>
            <ul class="list-inline two-part d-flex align-items-center mb-0">
               <li>
                  <div >
                    <i class="fas fa-sitemap" aria-hidden="true" style="font-size: 40px;color: #439737;"></i>
                  </div>
               </li>
               <li class="ms-auto"><span class="counter text-success">{{ $count1 }}</span></li>
            </ul>
         </div>
      </div>
      <div class="col-lg-4 col-md-12">
         <div class="white-box analytics-info">
            <h3 class="box-title">Tổng đơn hàng</h3>
            <ul class="list-inline two-part d-flex align-items-center mb-0">
               <li>
                  <div >
                     <i class="fas fa-ambulance" aria-hidden="true" style="font-size: 40px;color: #7460ee;"></i>
                  </div>
               </li>
               <li class="ms-auto"><span class="counter text-purple">{{ $count2 }}</span></li>
            </ul>
         </div>
      </div>
      <div class="col-lg-4 col-md-12">
         <div class="white-box analytics-info">
            <h3 class="box-title">Tổng hóa đơn bán lẻ</h3>
            <ul class="list-inline two-part d-flex align-items-center mb-0">
               <li>
                  <div >
                    <i class="fas fa-clipboard" aria-hidden="true" style="font-size: 40px;color: #11a0f8;"></i>
                  </div>
               </li>
               <li class="ms-auto"><span class="counter text-info">{{ $count3 }}</span>
               </li>
            </ul>
         </div>
      </div>
      
   </div>
</div>

<script>
$(document).ready(function() {
    
    
         
    } ); 
</script>        
            
@endsection