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
        use Gloudemans\Shoppingcart\Facades\Cart;
        $content = Cart::content();
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

                    <label><?php echo $_GET['vnp_TxnRef'] ?></label>
                </div>    
                <div class="form-group">

                    <label >Số tiền:</label>
                    <label><?php echo $_GET['vnp_Amount']/100 ?></label>
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
                    <label><?php 
                            $dateTime = DateTime::createFromFormat('YmdHis', $_GET['vnp_PayDate']);
                            $formattedDateTime = $dateTime->format('d/m/Y H:i:s');
                            echo $formattedDateTime;echo $_GET['vnp_PayDate'] ?>
                    </label>
                </div> 
                <div class="form-group">
                    <label >Kết quả:</label>
                    <label>
                        <?php
                        $data_order = session()->get('checkoutData');
                        if ($secureHash == $vnp_SecureHash) {
                            if ($_GET['vnp_ResponseCode'] == '00') {
                                    
                                    $data = array();
                                    $content = Cart::content();
                                    foreach($content as $v_content){
                                        $data['orderid'] = $data_order['orderid'];
                                        $data['product_id'] = $v_content->id;
                                        $data['amount'] = $v_content->price;
                                        $data['qtyordered'] = $v_content->qty;
                                        $data['form'] = $v_content->options->form;
                                        Db::table('order_details')->insert($data);
                                    }
                                    $datatt = array();
                                    $datatt['orderid'] = $data_order['orderid'];
                                    $datatt['content'] = "Đang xử lý";
                                    Db::table('order_status')->insert($datatt);
                                    Session::forget('checkoutData');
                                    Cart::destroy();
                                echo "<span style='color:blue'>GD Thanh cong</span>";
                               
                            } else {
                                $data = array();
                                    $content = Cart::content();
                                    foreach($content as $v_content){
                                        $data['orderid'] = $data_order['orderid'];
                                        $data['product_id'] = $v_content->id;
                                        $data['amount'] = $v_content->price;
                                        $data['qtyordered'] = $v_content->qty;
                                        $data['form'] = $v_content->options->form;
                                        Db::table('order_details')->insert($data);
                                    }
                                    $datatt = array();
                                    $datatt['orderid'] = $data_order['orderid'];
                                    $datatt['content'] = "Đã hủy thanh toán";
                                    Db::table('order_status')->insert($datatt);
                                    //Session::forget('checkoutData');
                                DB::table('orders')
                                ->where('id', $data_order['orderid'])
                                ->update(['payment' => 'Huỷ thanh toán','orderstatus'=> 4]);
                                Session::forget('checkoutData');
                                echo "<span style='color:red'>GD Khong thanh cong</span>";
                            }
                        } else {
                            $data = array();
                                    $content = Cart::content();
                                    foreach($content as $v_content){
                                        $data['orderid'] = $data_order['orderid'];
                                        $data['product_id'] = $v_content->id;
                                        $data['amount'] = $v_content->price;
                                        $data['qtyordered'] = $v_content->qty;
                                        $data['form'] = $v_content->options->form;
                                        Db::table('order_details')->insert($data);
                                    }
                                    $datatt = array();
                                    $datatt['orderid'] = $data_order['orderid'];
                                    $datatt['content'] = "Đã hủy thanh toán";
                                    Db::table('order_status')->insert($datatt);
                                    Session::forget('checkoutData');
                                DB::table('orders')
                                ->where('id', $data_order['orderid'])
                                ->update(['payment' => 'Huỷ thanh toán','orderstatus'=> 4]);
                                //Session::forget('checkoutData');
                            echo "<span style='color:red'>Chu ky khong hop le</span>";
                        }
                        ?>

                    </label>
                    <?php
                        if ($secureHash == $vnp_SecureHash) {
                            if ($_GET['vnp_ResponseCode'] == '00') {
                                ?>
                                <br>
                                <a href="{{URL::to('/')}}" class="btn nutmuathem mb-3">Tiếp tục mua hàng</a>
                                <?php
                            } else {
                                ?>
                                <br>
                                <a href="{{URL::to('/gio-hang')}}" class="btn nutmuathem mb-3">Quay lại</a>
                                <?php
                            }
                        } else {
                            ?>
                            <br>
                            <a href="{{URL::to('/gio-hang')}}" class="btn nutmuathem mb-3">Quay lại</a>
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
    </body>
</html>
