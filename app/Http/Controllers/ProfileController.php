<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use App\Models\Category;

class ProfileController extends Controller
{
    public function show_profile(){
        $userid = Session::get('user')->userid;
        $ordered = DB::table('orders')->where('userid',$userid)->orderBy('orderid', 'DESC')->get(); 

        $categories = Category::all();

        $in4_user = DB::table('users')->where('userid','=',Session::get('user')->userid)->get();
        
        return view('user.profile',['categories' => $categories])
        ->with('ordered',$ordered)->with('in4_user',$in4_user);
    }

    public function show_details_ordered($orderid){
        $userid = Session::get('user')->userid;
        $ordered = DB::table('orders')->where('userid',$userid)->get(); 
        $cate_product = DB::table('categories')->where('categories.parent',1)->get();
        $sub_cate = DB::table('categories')->where('categories.parent','!=',1)->get();
        // $orderdetail = DB::table('ordersdetails')->where('orderid',$orderid)->get();
        $in4_user = DB::table('users')->where('userid','=',Session::get('user')->userid)->get();
        $orderdetail = DB::table('ordersdetails')->join('books','ordersdetails.bookid','=','books.bookid')->where(
            'orderid',$orderid)->get();

        return view('user.profile')->with('ordered',$ordered)->with('details',$orderdetail)
        ->with('in4_user',$in4_user)->with('category',$cate_product)->with('sub_cate',$sub_cate);;
    }

    public function update_profile(Request $request){
        $fullname = $request->hoten;
        $phone = $request->phone;
        $address = $request->address;

        DB::update('update users set fullname = ?,phone=?,address=? where userid = ?',
        [$fullname,$phone,$address,Session::get('user')->userid]);
        
                         
        return Redirect::to('/thong-tin-ca-nhan');
    }
}
