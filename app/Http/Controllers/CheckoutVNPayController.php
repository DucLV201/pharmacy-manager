<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Bill;
use App\Models\BillDetail;
session_start();
class CheckoutVNPayController extends Controller
{
    public function vnpay_payment(Request $request) {
        
        //phần xử lý giỏ hàng
        $province = $request->province;
        $district = $request->district;
        $ward = $request->ward;
        // Lấy các giá trị từ request
        $userid = Session::get('user')->id;
        $username = $request->username;
        $phone = $request->phone;
        $payment = "Đã thanh toán qua VNPay";
        $address = $request->address.",".$ward.",".$district.",".$province;
        $total = $request->total;
        $coupon = $request->coupon;
        $fee = $request->fee;
        $orderstatus = 0;

        // Tạo một mảng lưu trữ thông tin
        $data = [
            'userid' => $userid,
            'payment' => $payment,
            'receivername' => $username,
            'phone' => $phone,
            'orderstatus' => $orderstatus,
            'address' => $address,
            'coupon' => $coupon,
            'fee' => $fee,
            'totalmoney' => $total,
        ];
        $orderid = Db::table('orders')->insertGetId($data);
        $data_order['orderid'] = $orderid;
        //dd($data);
        // Lưu mảng vào session
        session()->put('checkoutData', $data_order);



        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:8000/nhathuocbinhan/public/checkout_vnpay";
        $vnp_TmnCode = "EJ9CKLCW";//Mã website tại VNPAY 
        $vnp_HashSecret = "ZTOPRUWMOPJPRDJYBOXRYXEVKLZXZZFP"; //Chuỗi bí mật

        //$vnp_TxnRef = $_POST['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_TxnRef = $orderid;
        $vnp_OrderInfo = 'Thanh toán đơn hàng của bạn';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $total * 100;
        $vnp_Locale = 'vn';
        //$vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        //$vnp_ExpireDate = $_POST['txtexpire'];
        //Billing

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
    }
    public function vnpay_payment_staff(Request $request) {
        
        $id = Session::get('user')->id;
        $name = Session::get('user')->fullname; 
        
        $products = $request->get('products'); // Lấy thông tin về danh sách sản phẩm
        $total = $request->get('sumbill');
        //dd($total);
        $bill = new Bill;
                $bill->id_invoice = $id;
                $bill->save();
                $billId = $bill->id; // Lấy giá trị id vừa được tạo
        // Lặp qua từng sản phẩm trong danh sách
        foreach ($products as $product) {
            $productId = $product['id']; // Lấy ID của sản phẩm
            $quantity = $product['quantity']; // Lấy số lượng của sản phẩm
            $form = $product['form']; 
            $formid = $product['formid'];
            $quantity_analysis = $quantity;
            $product_info  = DB::table('products')
            ->select('products.*')
            ->where('products.id','=',$productId)
            ->first();

            $formcheck = $product_info ->id_form;
            if($formcheck==4 or $formcheck==5){
                if($formid==1)
                $quantity_analysis = $quantity*$product_info ->numberone;     
            }
            elseif($formcheck==6){
                if($formid==1)
                    $quantity_analysis = $quantity*$product_info ->numbertwo;
                elseif($formid==2){
                    $quantity_analysis = $quantity*$product_info ->numberone*$quantity*$product_info ->numbertwo;
                }      
            }
            
            $bill_detail = new BillDetail;
                $bill_detail->id_bill_retail = $billId;
                $bill_detail->id_product = $productId;
                $bill_detail->quantity = $quantity;
                $bill_detail->quantity_analysis = $quantity_analysis;
                $bill_detail->form = $form;
                $bill_detail->save();

            //xử lý thuốc đã bán 
            
        }



        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:8000/nhathuocbinhan/public/checkout-vnpay-st";
        $vnp_TmnCode = "EJ9CKLCW";//Mã website tại VNPAY 
        $vnp_HashSecret = "ZTOPRUWMOPJPRDJYBOXRYXEVKLZXZZFP"; //Chuỗi bí mật

        //$vnp_TxnRef = $_POST['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_TxnRef = $billId;
        $vnp_OrderInfo = 'Thanh toán đơn hàng';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $total * 100;
        $vnp_Locale = 'vn';
        //$vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        //$vnp_ExpireDate = $_POST['txtexpire'];
        //Billing

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
    }
}
