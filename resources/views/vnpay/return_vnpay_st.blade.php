<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <title>VNPAY RESPONSE</title>
        <!-- Bootstrap core CSS -->
        <link href="/vnpay_php/assets/bootstrap.min.css" rel="stylesheet"/>
        <!-- Custom styles for this template -->
        <link href="/vnpay_php/assets/jumbotron-narrow.css" rel="stylesheet">         
        <script src="/vnpay_php/assets/jquery-1.11.3.min.js"></script>
        <style>
            .nutmuathem {
            border: 1px solid #F5A623;
            color: #F5A623;
        }
        </style>
    </head>
    <body>
    <?php
        use Illuminate\Support\Facades\DB;
        use App\Models\Coupon;
        use App\Models\Bill;
        use App\Models\BillDetail;
    ?>
        <?php
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        
        
        $vnp_HashSecret = "ZTOPRUWMOPJPRDJYBOXRYXEVKLZXZZFP"; //Secret key
        
        
        
        
        //Config input format
        //Expire
        $startTime = date("YmdHis");
        $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        ?>
        <!--Begin display -->
        <div class="container">
            <div class="header clearfix">
                <h3 class="text-muted">VNPAY RESPONSE</h3>
            </div>
            <div class="table-responsive">
                <div class="form-group">
                    <label >Mã đơn hàng:</label>

                    <label class="ordercode"><?php echo $_GET['vnp_TxnRef'] ?></label>
                </div>    
                <div class="form-group">

                    <label >Số tiền:</label>
                    <label class="sumbill"><?php echo $_GET['vnp_Amount']/100 ?></label>
                </div>  
                <div class="form-group">
                    <label >Nội dung thanh toán:</label>
                    <label><?php echo $_GET['vnp_OrderInfo'] ?></label>
                </div> 
                <div class="form-group">
                    <label >Mã phản hồi (vnp_ResponseCode):</label>
                    <label><?php echo $_GET['vnp_ResponseCode'] ?></label>
                </div> 
                <div class="form-group">
                    <label >Mã GD Tại VNPAY:</label>
                    <label><?php echo $_GET['vnp_TransactionNo'] ?></label>
                </div> 
                <div class="form-group">
                    <label >Mã Ngân hàng:</label>
                    <label><?php echo $_GET['vnp_BankCode'] ?></label>
                </div> 
                <div class="form-group">
                    <label >Thời gian thanh toán:</label>
                    <label class="datetime"><?php 
                            $dateTime = DateTime::createFromFormat('YmdHis', $_GET['vnp_PayDate']);
                            $formattedDateTime = $dateTime->format('d/m/Y H:i:s');
                            echo $formattedDateTime; ?>
                    </label>
                </div> 
                <div class="form-group">
                    <label >Kết quả:</label>
                    <label>
                        <?php
                        $data_staff = session()->get('user');
                        $id_staff = $data_staff['id'];
                        $name_staff = $data_staff['fullname'];
                        $id_bill = $_GET['vnp_TxnRef'];
                        $bill_product =  BillDetail::where('id_bill_retail','=',$id_bill)
                        ->join('products','bill_detail.id_product','=','products.id')
                        ->select('bill_detail.*','products.name as name','products.price as price')
                        ->get();

                        if ($secureHash == $vnp_SecureHash) {
                            if ($_GET['vnp_ResponseCode'] == '00') {
                                $bill_detail =  BillDetail::where('id_bill_retail','=',$id_bill)
                                ->get();   
                                foreach ($bill_detail as $detail) {
                                    //xử lý thuốc đã bán 
                                    $productId = $detail->id_product;
                                    $quantity_analysis = $detail->quantity_analysis;
                                    $coupon  =Coupon::where('id_product','=',$productId)
                                    ->where('count_acc','>',0)
                                    ->orderBy('time', 'ASC')
                                    ->first();
                                    $quantityToDeduct = $quantity_analysis;
                                    $check =$coupon->count_acc - $quantityToDeduct;

                                    if($check >=0){
                                        $coupon->count_acc = $check;
                                        $coupon->save();
                                    }else{
                                        $quantityToDeduct -= $coupon->count_acc;
                                        $coupon->count_acc = 0;
                                        $coupon->save();

                                        $nextCoupon = Coupon::where('id_product','=',$productId)
                                        ->where('count_acc','>',0)
                                        ->where('time', '>', $coupon->time)
                                        ->orderBy('time', 'ASC')
                                        ->first();
                                        
                                        while($quantityToDeduct > 0){
                                            $check = $nextCoupon->count_acc - $quantityToDeduct;
                                            if($check >=0){
                                                $nextCoupon->count_acc = $check;
                                                $nextCoupon->save();
                                                $quantityToDeduct = 0;
                                            }else{
                                                $quantityToDeduct -= $nextCoupon->count_acc;
                                                $nextCoupon->count_acc = 0;
                                                $nextCoupon->save();

                                                $nextCoupon = Coupon::where('id_product','=',$productId)
                                                ->where('count_acc','>',0)
                                                ->where('time', '>', $nextCoupon->time)
                                                ->orderBy('time', 'ASC')
                                                ->first();
                                            }
                                        }
                                    }
                                }
                                echo "<span style='color:blue'>GD Thanh cong</span>";
                               
                            } else {
                                $bill_retail =  Bill::where('id','=',$id_bill)
                                ->delete();
                                $bill_detail =  BillDetail::where('id_bill_retail','=',$id_bill)
                                ->delete(); 
                                echo "<span style='color:red'>GD Khong thanh cong</span>";
                            }
                        } else {
                            $bill_retail =  Bill::where('id','=',$id_bill)
                            ->delete();
                            $bill_detail =  BillDetail::where('id_bill_retail','=',$id_bill)
                            ->delete(); 
                            echo "<span style='color:red'>Chu ky khong hop le</span>";
                        }
                        ?>

                    </label>
                    <?php
                        if ($secureHash == $vnp_SecureHash) {
                            if ($_GET['vnp_ResponseCode'] == '00') {
                                ?>
                                <br>
                                <a href="#" class="btn nutmuathem mb-3" id="printButton">In hóa đơn</a>
                                <a href="{{URL::to('/xuat-hoa-don')}}" class="btn nutmuathem mb-3">Quay lại</a>
                                <br>
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
                                    @foreach($bill_product as $detail)
                                    <tr>
                                        <td>{{$detail->name}}</td>
                                        <td>{{$detail->quantity}} {{$detail->form}}</td>
                                        <td>{{$detail->price}} đ</td>
                                        <td><?php $tt=$detail->price*$detail->quantity_analysis; echo number_format($tt);?> đ</td>
                                        
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>                               
                                
                                
                                <?php
                            } else {
                                ?>
                                <br>
                                <a href="{{URL::to('/xuat-hoa-don')}}" class="btn nutmuathem mb-3">Quay lại</a>
                                <?php
                            }
                        } else {
                            ?>
                            <br>
                            <a href="{{URL::to('/xuat-hoa-don')}}" class="btn nutmuathem mb-3">Quay lại</a>
                            <?php
                        }
                        ?>
                </div> 
            </div>
            <p>
                &nbsp;
            </p>
            <footer class="footer">
                   <p>&copy; VNPAY <?php echo date('Y')?></p>
            </footer>
        </div> 
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function exportOrder() {
                var orderCode = $('.ordercode').text();
                var Datetime = $('.datetime').text();
                var employeeCode = {{$id_staff}};
                var employeeName = "{{$name_staff}}";
                var sumbill = $('.sumbill').text();
                var formattedSumbill = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(sumbill);
                
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
                                    "<strong>Tổng: " + formattedSumbill + "</strong>" +
                                    "</body></html>";

                // Tạo cửa sổ in và viết nội dung hóa đơn vào
                var printWindow = window.open('', '', 'width=800,height=600');
                printWindow.document.open();
                printWindow.document.write(documentContent);
                printWindow.document.close();
                printWindow.print();
            }
            document.getElementById("printButton").addEventListener("click", function() {
                exportOrder();
            });
        </script>

    </body>
</html>
