<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Bill;
use App\Models\BillDetail;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public  function index(){
        $id = Session::get('user')->id;
        $name = Session::get('user')->fullname;
        $check = Session::get('user')->isadmin;
        if($check==1 || $check==2 || $check==3)
            return view('invoice.invoice', ['id' => $id, 'name' => $name]);
        else
            return Redirect::to('/');
       
    }
    public  function add_retail(Request $request){
        $id = Session::get('user')->id;
        $name = Session::get('user')->fullname; 
        
        $products = $request->get('products'); // Lấy thông tin về danh sách sản phẩm

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
                    $quantity_analysis = $quantity*$product_info ->numberone*$product_info ->numbertwo;
                }      
            }
            //dd($quantity_analysis);
            $bill_detail = new BillDetail;
                $bill_detail->id_bill_retail = $billId;
                $bill_detail->id_product = $productId;
                $bill_detail->quantity = $quantity;
                $bill_detail->quantity_analysis = $quantity_analysis;
                $bill_detail->form = $form;
                $bill_detail->save();

            //xử lý thuốc đã bán 
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
        
        

        
        return $billId;
       
    }
    public function returnvnpay_st(){
        return view('vnpay.return_vnpay_st');
    }
    public function order_processing(){
        $id = Session::get('user')->id;
        $name = Session::get('user')->fullname; 
        //dd($id);
        $list_order = DB::table('orders')
        ->join('users', 'orders.userid', '=', 'users.id')
        ->select('orders.*','users.email')
        ->get();

        return view('invoice.invoice_ordp', ['id' => $id, 'name' => $name])
        ->with('list_order',$list_order);
    }

    public function order_detail($id){

        $user_infor = DB::table('orders')
        ->where('orders.id','=',$id)
        ->get();
        $order_details = DB::table('order_details')
        ->join('products', 'order_details.product_id', '=', 'products.id')
        ->where('order_details.orderid','=',$id)
        ->select('order_details.*','products.name as name')
        ->get();
        $order_info = DB::table('orders')
        ->where('orders.id','=',$id)
        ->get();
        $order_status = DB::table('order_status')
        ->where('order_status.orderid','=',$id)
        ->get();
        
        //dd($user_infor[0]->receivername);
        return view('invoice.order_detail')->with('user_infor',$user_infor)
        ->with('order_details',$order_details)->with('order_info',$order_info)
        ->with('order_status',$order_status);
    }

    public function confirm_order(Request $request) {
        $order_id = $request->orderId;
        // Lấy múi giờ Việt Nam
        $timezone = new DateTimeZone('Asia/Ho_Chi_Minh');
        // Lấy thời gian hiện tại theo múi giờ Việt Nam
        $now = new DateTime('now', $timezone);
        $order = array();
        $order['orderstatus'] = 1;
        $order_detail =DB::table('orders')->where('id', $order_id )->update($order);

        $order_status = array();
        $order_status['orderid'] = $order_id;
        $order_status['content'] = "Đang giao hàng";
        $order_status['timestamp'] = $now;
        $order_status_in =DB::table('order_status')->insert($order_status);
        if($order_detail && $order_status_in) {
            echo 'success'; 
        } else {
            echo 'failure';
        }
    }

    public function success_order(Request $request) {
        $order_id = $request->orderId;
        // Lấy múi giờ Việt Nam
        $timezone = new DateTimeZone('Asia/Ho_Chi_Minh');
        // Lấy thời gian hiện tại theo múi giờ Việt Nam
        $now = new DateTime('now', $timezone);
        $order = array();
        $order['orderstatus'] = 2;
        $order_detail =DB::table('orders')->where('id', $order_id )->update($order);

        $order_status = array();
        $order_status['orderid'] = $order_id;
        $order_status['content'] = "Giao thành công";
        $order_status['timestamp'] = $now;
        $order_status_in =DB::table('order_status')->insert($order_status);
        if($order_detail && $order_status_in) {
            echo 'success'; 
        } else {
            echo 'failure';
        }
    }
    public function cancer_order(Request $request) {
        $order_id = $request->orderId;
        // Lấy múi giờ Việt Nam
        $timezone = new DateTimeZone('Asia/Ho_Chi_Minh');
        // Lấy thời gian hiện tại theo múi giờ Việt Nam
        $now = new DateTime('now', $timezone);
        $order = array();
        $order['orderstatus'] = 3;
        $order_detail =DB::table('orders')->where('id', $order_id )->update($order);

        $order_status = array();
        $order_status['orderid'] = $order_id;
        $order_status['content'] = "Người bán từ chối đơn hàng";
        $order_status['timestamp'] = $now;
        $order_status_in =DB::table('order_status')->insert($order_status);
        if($order_detail && $order_status_in) {
            echo 'success'; 
        } else {
            echo 'failure';
        }
    }

    public function delete_order(Request $request) {
        $order_id = $request->orderId;
        $del_order_detail = DB::table('order_details')->where('orderid', $order_id)->delete();
        $del_order = DB::table('orders')->where('id', $order_id)->delete();
        
        $del_order_status = DB::table('order_status')->where('orderid', $order_id)->delete();

        
            echo 'success'; 
       
       
    }

    public function sale_history(){
        $id = Session::get('user')->id;
        $name = Session::get('user')->fullname;
        $check = Session::get('user')->isadmin;

        $bill_sale = Bill::join('users', 'bill_retail.id_invoice', '=', 'users.id')
        ->select('bill_retail.*','users.fullname as name')
        ->get();

        $bill_sum = BillDetail::join('products', 'bill_detail.id_product','=','products.id')
        ->select('bill_detail.*',DB::raw('SUM(products.price * bill_detail.quantity_analysis) as total_price'))
        ->groupBy('bill_detail.id_bill_retail')
        ->get();


        //dd($data);
        if($check==1 || $check==2 || $check==3)
            return view('invoice.sale_history', ['id' => $id, 'name' => $name])
            ->with('bill_sale',$bill_sale)->with('bill_sum',$bill_sum);
        else
            return Redirect::to('/');
    }
    public function sale_statistics(){
        $id = Session::get('user')->id;
        $name = Session::get('user')->fullname;
        $check = Session::get('user')->isadmin;
        
        // Lấy ngày đầu tuần hiện tại
        $startDate = Carbon::now()->startOfWeek();
        // Lấy ngày cuối tuần hiện tại
        $endDate = Carbon::now()->endOfWeek();
        $bill_s = BillDetail::join('products', 'bill_detail.id_product', '=', 'products.id')
        ->select('bill_detail.*', 'products.price', 'products.id_form', 'products.name', 'products.numberone', 'products.numbertwo', DB::raw('SUM(bill_detail.quantity_analysis) as count1'), DB::raw('SUM(products.price * bill_detail.quantity_analysis) as total_price'))
        ->groupBy('bill_detail.id_product')
        ->get();
        $data = [];

        foreach ($bill_s as $row) {
            $count1 = $row->count1;
            $numberone = $row->numberone;
            $numbertwo = $row->numbertwo;
            
            if ($row->id_form == 6) {
                $result="";
                $remainder1 = $count1 % ($numberone * $numbertwo);
                if($count1 / ($numberone * $numbertwo) >= 1){
                    $result = floor($count1 / ($numberone * $numbertwo)) . ' Hộp ';
                }
                $remainder2 = $remainder1 % $numbertwo ;
                if ($remainder1 / $numbertwo >= 1) {
                    
                    $result .= floor($remainder1 / $numbertwo ) . ' Vỉ ';
                }
                if($remainder2 > 0)
                    $result .= $remainder2 . ' Viên';

            }else if($row->id_form == 5){
                $remainder1 = $count1 % $numberone ;
                if($count1 / $numberone  >= 1){
                    if($remainder1 !=0 )
                        $result = floor($count1 / ($numberone * $numbertwo)) . ' Hộp '.$remainder1. ' Ống';
                    else
                        $result = floor($count1 / ($numberone * $numbertwo)) . ' Hộp ';
                }else{
                    $result =$remainder1. 'Ống';
                }

            }else if($row->id_form == 4){
                $remainder1 = $count1 % $numberone ;
                if($count1 / $numberone  >= 1){
                    if($remainder1 !=0 )
                        $result = floor($count1 / ($numberone * $numbertwo)) . ' Hộp '.$remainder1. ' Gói';
                    else
                        $result = floor($count1 / ($numberone * $numbertwo)) . ' Hộp ';
                }else{
                    $result =$remainder1. ' Gói';
                }
            }else if($row->id_form == 3){
                $result =$count1. ' Hộp';
            }else if($row->id_form == 2){
                $result =$count1. ' Chai';
            }else if($row->id_form == 1){
                $result =$count1. ' Tuýp';
            }
            $row->count1 = $result;
            $data[] = $row;
        }


        //dd($data);
        if($check==1 || $check==2 || $check==3)
            return view('invoice.sale_statistic', ['id' => $id, 'name' => $name])
            ->with('data',$data);
        else
            return Redirect::to('/');
    }

    public function bill_detail($id){
        $bill_sale = Bill::join('users', 'bill_retail.id_invoice', '=', 'users.id')
        ->where('bill_retail.id','=',$id)
        ->select('bill_retail.*','users.fullname as name')
        ->get();
        $bill_details = BillDetail::join('products', 'bill_detail.id_product', '=', 'products.id')
        ->where('bill_detail.id_bill_retail','=',$id)
        ->select('bill_detail.*','products.name as name','products.price as price','products.id_form as formid','products.numberone as one','products.numbertwo as two')
        ->get();
        $bill_sum = BillDetail::join('products', 'bill_detail.id_product','=','products.id')
        ->select('bill_detail.*',DB::raw('SUM(products.price * bill_detail.quantity_analysis) as total_price'))
        ->where('bill_detail.id_bill_retail',$id)
        ->first();
        //dd($bill_sum["id_bill_retail"]);
        return view('invoice.bill_detail')->with('bill_sum',$bill_sum)
        ->with('bill_sale',$bill_sale)->with('bill_details',$bill_details);
    }

    public function filter_bill(Request $request){
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $bill_sale = Bill::join('users', 'bill_retail.id_invoice', '=', 'users.id')
        ->join('bill_detail', 'bill_retail.id', '=', 'bill_detail.id_bill_retail')
        ->join('products', 'bill_detail.id_product','=','products.id')
        ->select('bill_retail.*','users.fullname as name',DB::raw('SUM(products.price * bill_detail.quantity_analysis) as total_price'))
        ->groupBy('bill_detail.id_bill_retail')
        ->whereBetween('bill_retail.timestamp', [$startDate, $endDate])
        ->get();
        //dd(response()->json($bill_sale));
        return response()->json($bill_sale);
    }

    public function filter_ts(Request $request){
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $bill_s = BillDetail::join('products', 'bill_detail.id_product', '=', 'products.id')
        ->join('bill_retail', 'bill_retail.id', '=', 'bill_detail.id_bill_retail')
        ->select('bill_detail.*', 'products.price', 'products.id_form', 'products.name', 'products.numberone', 'products.numbertwo', DB::raw('SUM(bill_detail.quantity_analysis) as count1'), DB::raw('SUM(products.price * bill_detail.quantity_analysis) as total_price'))
        ->groupBy('bill_detail.id_product')
        ->whereBetween('bill_retail.timestamp', [$startDate, $endDate])
        ->get();
        $data = [];

        foreach ($bill_s as $row) {
            $count1 = $row->count1;
            $numberone = $row->numberone;
            $numbertwo = $row->numbertwo;
            
            if ($row->id_form == 6) {
                $result="";
                $remainder1 = $count1 % ($numberone * $numbertwo);
                if($count1 / ($numberone * $numbertwo) >= 1){
                    $result = floor($count1 / ($numberone * $numbertwo)) . ' Hộp ';
                }
                $remainder2 = $remainder1 % $numbertwo ;
                if ($remainder1 / $numbertwo >= 1) {
                    
                    $result .= floor($remainder1 / $numbertwo ) . ' Vỉ ';
                }
                if($remainder2 > 0)
                    $result .= $remainder2 . ' Viên';

            }else if($row->id_form == 5){
                $remainder1 = $count1 % $numberone ;
                if($count1 / $numberone  >= 1){
                    if($remainder1 !=0 )
                        $result = floor($count1 / ($numberone * $numbertwo)) . ' Hộp '.$remainder1. ' Ống';
                    else
                        $result = floor($count1 / ($numberone * $numbertwo)) . ' Hộp ';
                }else{
                    $result =$remainder1. 'Ống';
                }

            }else if($row->id_form == 4){
                $remainder1 = $count1 % $numberone ;
                if($count1 / $numberone  >= 1){
                    if($remainder1 !=0 )
                        $result = floor($count1 / ($numberone * $numbertwo)) . ' Hộp '.$remainder1. ' Gói';
                    else
                        $result = floor($count1 / ($numberone * $numbertwo)) . ' Hộp ';
                }else{
                    $result =$remainder1. ' Gói';
                }
            }else if($row->id_form == 3){
                $result =$count1. ' Hộp';
            }else if($row->id_form == 2){
                $result =$count1. ' Chai';
            }else if($row->id_form == 1){
                $result =$count1. ' Tuýp';
            }
            $row->count1 = $result;
            $data[] = $row;
        }
        //dd(response()->json($bill_sale));
        return response()->json($data);
    }

    public function postcate_manager(){
        $post_cate = DB::table('post_cates')
        ->get();
        return view('invoice.postcate_manager')
        ->with('post_cate',$post_cate);
    }
    public function add_postcate(Request $request){
        $name = $request->name;
        DB::table('post_cates')->insert([
            'title' => $name
        ]);
        return "ok";
    }
    public function remove_postcate(Request $request){
        $id = $request->id;
        DB::table('post_cates')->where('id', $id)->delete();
        return "ok";
    }
    public function update_postcate(Request $request){
        $id = $request->id;
        $name = $request->name;
        DB::table('post_cates')->where('id', $id)->update(['title' => $name]);
        return "ok";
    }
    public function add_post(Request $request){
        $name = $request->name;
        $id_cate = $request->id_cate;
        $img = $request->image;
        $content = $request->content;
        //dd($name,$img,$title,$content);

        DB::table('posts')->insert([
            'title' => $name,
            'id_cate' => $id_cate,
            'img_title' => $img,
            'description' => $content,
        ]);
        return "ok";
    }
    public function remove_post(Request $request){
        $id = $request->id;
        //dd($id);
        DB::table('posts')->where('id', $id)->delete();
        return "ok";
    }
    public function getinfor_post(Request $request){
        $id = $request->id;
        //dd($id);
        $post =DB::table('posts')->where('id', $id)->first();

        //dd($post);
        $data['id'] = $id;
        $data['id_cate'] = $post ->id_cate;
        $data['title'] = $post ->title;
        $data['img_title'] = $post ->img_title;
        $data['description'] = $post ->description;

        return response()->json($data);
    }
    public function update_post(Request $request){
        $id = $request->id;
        $name = $request->name;
        $id_cate = $request->id_cate;
        $img = $request->image;
        $content = $request->content;
        //dd($id,$name,$img,$id_cate,$content);
        if($img != ""){
            DB::table('posts')->where('id', $id)->update([
            'title' => $name,
            'id_cate' => $id_cate,
            'img_title' => $img,
            'description' => $content,
        ]);
        }else{
            DB::table('posts')->where('id', $id)->update([
            'title' => $name,
            'id_cate' => $id_cate,
            'description' => $content,
        ]);
        }
        

        return "ok";
    }
    public function post_manager(){
        $post = DB::table('posts')
        ->join('post_cates', 'posts.id_cate', '=', 'post_cates.id')
        ->select('posts.*','post_cates.title as name')
        ->get();
        $post_cate = DB::table('post_cates')->get();
        //dd($post);
        return view('invoice.post_manager')
        ->with('post',$post)->with('post_cate',$post_cate);
    }
    public function product_cate(){
        $product = DB::table('products')
        ->get();
        return view('invoice.product_cate')->with('product',$product);
    }
    // public function get_all_prod(){
    //     $product = DB::table('products')
    //     ->get();
    //     foreach($product as $info) {
    //         $output =  '   <tr> 
    //         <!-- mã sp -->
    //         <td>
    //         '.$info->id.'
    //         </td> 

    //         <!-- tên sp -->
    //         <td>
    //         '.$info->name.'
    //         </td> 

    //         <!-- Dạng bào chế -->
    //         <td>
    //         '.$info->dosage_forms.'
    //         </td>

    //         <!-- giá -->
    //         <td>
    //         '.number_format($info->price).' đ
    //         </td>';

            

    //         if($info->class == 1)
    //             $output .= '<td><input data-prod_id="'.$info->id.'" checked class="isadmin" type="checkbox" name="isadmin" ></td>';
    //         else
    //             $output .= '<td><input data-prod_id="'.$info->id.'" class="isadmin" type="checkbox" name="isadmin" ></td>';

    //         if($info->class == 2)
    //             $output .= '<td><input data-prod_id="'.$info->id.'" checked class="isdisable" type="checkbox" name="isdisable" ></td></tr>';
    //         else
    //             $output .= '<td><input data-prod_id="'.$info->id.'" class="isdisable" type="checkbox" name="isdisable" ></td></tr>';

    //         echo $output;
    //     }


    // }

    public function enableFeatured(Request $request) {
        $id = $request->prodId;
        $product = DB::table('products')
              ->where('id', $id)
              ->update(['featured' => 1]);
    }

    public function disableFeatured(Request $request) {
        $id = $request->prodId;
        $product = DB::table('products')
              ->where('id', $id)
              ->update(['featured' => 0]);
    }

    public function disableBestSell(Request $request) {
        $id = $request->prodId;
        $product = DB::table('products')
              ->where('id', $id)
              ->update(['bestsell' => 1]);

    }

    public function enableBestSell(Request $request) {
        $id = $request->prodId;
        $product = DB::table('products')
              ->where('id', $id)
              ->update(['bestsell' => 0]);
    }
}
