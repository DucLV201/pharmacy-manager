<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;


use App\Models\Category;
use App\Models\Product;
use App\Models\Post;
use App\Models\PostCate;
use App\Models\User;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;

session_start();
use Exception;

class CartController extends Controller
{

    public function save_cart(Request $request){
        //$cate_product = DB::table('categories')->get(); 
        //$all_product = DB::table('books')->get();
        
        $productid = $request->product_id_hidden;
        $qty = $request->qty;
        $form = $request->form_id_hidden;

        $product_info  = DB::table('products')
        ->join('images', 'products.id', '=', 'images.id_prod')
        ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
        ->where('products.id','=',$productid)
        ->first();
        //dd($product_info);
        
        $data['id'] = $product_info ->id;
        $data['name'] = $product_info ->name;
        $data['options']['form'] = $product_info ->id_form;
        $data['price'] = $product_info ->price;
        // $data['weight'] = $product_info ->bookweight;
        // Tách chuỗi thành mảng các ảnh
        $imageArray = explode(',', $product_info->url);
        // Lấy ảnh đầu tiên từ mảng
        $data['options']['image'] = $imageArray[0];
        $data['qty'] = $qty;

        $check = $product_info ->id_form;
        if($check == 1)
            $data['options']['form'] = "Tuýp";
        elseif($check==2)
            $data['options']['form'] = "Chai";
        elseif($check==3)
            $data['options']['form'] = "Hộp";
        elseif($check==4){
            if($form==3)
                $data['options']['form'] = "Gói";
            else{
                $data['options']['form'] = "Hộp";
                $data['price'] = $product_info ->price * $product_info ->numberone;
            }       
        }
        elseif($check==5){
            if($form==3)
                $data['options']['form'] = "Ống";
            else{
                $data['options']['form'] = "Hộp";
                $data['price'] = $product_info ->price * $product_info ->numberone;
            }  
        }
        else{
            if($form==3)
                $data['options']['form'] = "Viên";
            elseif($form==2){
                $data['options']['form'] = "Vỉ";
                $data['price'] = $product_info ->price * $product_info ->numberone;
            }   
            else{
                $data['options']['form'] = "Hộp";
                $data['price'] = $product_info ->price * $product_info ->numberone * $product_info ->numberone;
            }
                
        }

        //dd($data);

        Cart::add($data);
        //dd(Cart::content());
        return Redirect::to('/gio-hang');
    }
    public  function show_cart(){
        $categories = Category::all();

        $provinces = Province::all();
        $districts = District::all();
        $wards = Ward::all();
        //$total1 = Cart::subtotal();

        return view('user.cart', ['categories' => $categories, 'provinces' => $provinces, 'districts' => $districts, 'wards' => $wards]);
       
    }
    public function delete_to_cart($rowId){
        Cart::update($rowId,0);
        return Redirect::to('/gio-hang');
    }

    // public function update_cart_quantity(Request $request){
    //     $rowId = $request->rowid;
    //     $qty = $request->cart_quantity;
    //     //dd($rowId);
    //     Cart::update($rowId,$qty);
          
    //     return Redirect::to('/gio-hang');
        
    // }
    public function update_cart(Request $request){
        $rowId = $request->rowid;
        $qty = $request->cart_quantity;

        Cart::update($rowId,$qty);
        $content = Cart::content()->where('rowId', $rowId)->first();
        $price = number_format($content->price * $qty, 0, ',', '.');//tính tổng và format định dạng tiền
        //dd($price,$content->price);
        $total1 = floatval(str_replace(',', '', Cart::subtotal()));//vì nó dạng chuỗi nên chuyển sang số để tính
        $coupon1 = 0;
        if($total1>1000000){
            $subtotal1 =$total1;
            $coupon1 = $request->fee;
        }else{
            $subtotal1 =$total1 + $request->fee;//cộng tổng tiền bao gồm ship
        }

        $total = number_format($total1, 0, ',', '.'); //định dạng lại dạng tiền tệ
        $coupon = number_format($coupon1, 0, ',', '.');
        $subtotal = number_format($subtotal1, 0, ',', '.');
        //dd($subtotal,$request->fee,$total);
        return response()->json(['subtotal' => $subtotal,'price' => $price,'total' => $total,'coupon' => $coupon]);
        
    }

    public function login_cart(Request $request) {
        $email = $request -> email;
        $password = $request -> password;
        if(Auth::attempt(['email'=>$email, 'password'=>$password])) {
            Session::put('user', Auth::user());
        } 
        return Redirect::to('/gio-hang'); 
    }
    public function signin_cart(Request $request) {
        try {
            User::create([
                'fullname' => $request -> fullname,
                'email' => $request -> email,
                'phone' => $request -> phone,
                'password' =>bcrypt($request -> password) 
                ]);
        } catch(Exception $e) {

        }   
        if(Auth::attempt(['email'=>$request -> email, 'password'=>$request -> password])) {
            Session::put('user', Auth::user());
        }  
        return Redirect::to('/gio-hang'); 
    }
    
    public function show_checkout(){
        return view('user.checkout_complete');
    }
    public function returnvnpay(){
        return view('vnpay.return_vnpay');
    }


}
