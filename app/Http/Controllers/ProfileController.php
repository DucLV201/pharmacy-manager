<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

use App\Models\Category;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;

class ProfileController extends Controller
{
    public function show_profile(){
        $id = Session::get('user')->id;
        $ordered = DB::table('orders')->where('userid',$id)->orderBy('id', 'DESC')->get(); 

        $categories = Category::all();

        $in4_user = DB::table('users')->where('id','=',Session::get('user')->id)->get();
        
        $provinces = Province::all();
        $districts = District::all();
        $wards = Ward::all();
        return view('user.profile',['categories' => $categories, 'provinces' => $provinces, 'districts' => $districts, 'wards' => $wards])
        ->with('ordered',$ordered)->with('in4_user',$in4_user);
    }

    public function show_details_ordered($orderid){
        $categories = Category::all();
        $provinces = Province::all();
        $districts = District::all();
        $wards = Ward::all();

        $userid = Session::get('user')->id;
        $ordered = DB::table('orders')->where('userid',$userid)->orderBy('id', 'DESC')->get(); 
        $ordertt = DB::table('order_status')->where('orderid',$orderid)->get(); 
        // $orderdetail = DB::table('ordersdetails')->where('orderid',$orderid)->get();
        $in4_user = DB::table('users')->where('id','=',Session::get('user')->id)->get();
        $orderdetail = DB::table('products')
        ->join('images', 'products.id', '=', 'images.id_prod')
        ->join('order_details','order_details.product_id','=','products.id')
        ->select('products.*', 'images.url as url','order_details.*')->DISTINCT()
        ->where('orderid',$orderid)->groupby('products.id')->get();
        //dd($orderdetail);
        return view('user.profile',['categories' => $categories, 'provinces' => $provinces, 'districts' => $districts, 'wards' => $wards])
        ->with('ordered',$ordered)->with('details',$orderdetail)
        ->with('ordertt',$ordertt)->with('in4_user',$in4_user);
    }

    public function update_profile(Request $request){
        $fullname = $request->hoten;
        $phone = $request->phone;
        $address = $request->address;
        $provinceId = $request->province;
        $districtId = $request->district;
        $wardId = $request->ward;
        //dd($request);
        DB::update('update users set fullname = ?,phone=?,address=?,province_id=?,district_id=?,ward_id=? where id = ?',
        [$fullname,$phone,$address,$provinceId,$districtId,$wardId,Session::get('user')->id]);
        
                         
        return Redirect::to('/thong-tin-ca-nhan');
    }
    public function province($provinceId) {
        $districts = District::where('province_id', $provinceId)->get();
        return response()->json($districts);
    }
    public function district($districtId) {
        $wards = Ward::where('district_id', $districtId)->get();
        return response()->json($wards);
    }
    public function fee(Request $request) {
        $wardId = $request->wardid;
        $districtId = $request->districtid;
        //dd($wardId,$districtId);
        $response = Http::withHeaders([
            'Token' => 'ce83ded6-f55f-11ed-a967-deea53ba3605',
            'ShopId' => '4148300',
            'Content-Type' => 'application/json'
        ])->get('https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee', [
            'service_type_id' => 2,
            'insurance_value' => 50000,
            'to_district_id' => $districtId,
            'to_ward_code' => $wardId,
            'height' => 15,
            'length' => 15,
            'weight' => 1000,
            'width' => 10
        ]);
        $data = json_decode($response->body(), true);
        $fee = $data['data']['total'];
        
        $subtotal = floatval(str_replace(',', '', Cart::subtotal()));//chuyển đổi để tính 
        $coupon = 0;
        if($subtotal>1000000){
            $coupon = $fee;
            $total = $subtotal;
        }else{
            $total = $subtotal + $fee;
        }

        
        //dd(Cart::subtotal(),$subtotal);
        //dd($districtId,$wardId);
        
        return response()->json(['total' => $total,'fee' => $fee,'coupon' => $coupon]);
    }
    public function order(Request $request) {
        
        //dd($request);
        $ward = $request->ward;
        $district = $request->district;
        $province = $request->province;
        if($request->payment==1){
            $payment="Thanh toán khi nhận hàng";
        }else{
            $payment="Đã thanh toán qua VNPay";
        }

        $data_order = array();
        $data_order['userid'] = Session::get('user')->id;
        $data_order['receivername'] = $request->username;
        $data_order['phone'] = $request->phone;
        $data_order['payment'] = $payment;
        $data_order['address'] = $request->address.",".$ward.",".$district.",".$province;
        $data_order['totalmoney'] = $request->total;
        $data_order['coupon'] = $request->coupon;
        $data_order['fee'] = $request->fee;
        $data_order['orderstatus'] = 0;
        $orderid = Db::table('orders')->insertGetId($data_order);

        $data = array();
        $content = Cart::content();
        foreach($content as $v_content){
            $data['orderid'] = $orderid;
            $data['product_id'] = $v_content->id;
            $data['amount'] = $v_content->price;
            $data['qtyordered'] = $v_content->qty;
            $data['form'] = $v_content->options->form;
            Db::table('order_details')->insert($data);
        }
        $datatt = array();
        $datatt['orderid'] = $orderid;
        $datatt['content'] = "Đang xử lý";
        Db::table('order_status')->insert($datatt);
        Cart::destroy();
        $check = "ok";
        return response()->json(['orderid' => $orderid,'check' => $check]); 
    }
    public function cancer_order(Request $request) {
        $id = $request->rowid;
        DB::table('orders')
        ->where('id', $id)
        ->update(['payment' => 'Khách hàng hủy đơn','orderstatus'=> 5]);
        $datatt = array();
        $datatt['orderid'] = $id;
        $datatt['content'] = "Khách hủy đơn";
        Db::table('order_status')->insert($datatt);
        $data="Đã hủy";
        return response()->json(['data' => $data]);
    }
}
