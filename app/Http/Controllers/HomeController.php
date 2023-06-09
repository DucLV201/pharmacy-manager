<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Models\Category;
use App\Models\Product;
use App\Models\Post;
use App\Models\PostCate;
use App\Models\User;



session_start();
class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::all();
        $postcates = PostCate::all();
        $all_product = DB::table('products')
        ->join('images', 'products.id', '=', 'images.id_prod')
        ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
        ->groupBy('products.id')
        ->get();
        $suggested_product = DB::table('products')
        ->join('images', 'products.id', '=', 'images.id_prod')
        ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
        ->groupBy('products.id')
        ->where('products.bestsell','=',1)
        ->take(4)
        ->get();
        $all_post = Post::join('post_cates','posts.id_cate','=','post_cates.id')
        ->select('posts.*', 'post_cates.title as cate_name')->get();
        $randomPosts1 = $all_post->random(1);
        $randomPosts5 = $all_post->random(5);
        
        //$randomPosts = $all_post->inRandomOrder()->take(5)->get();

        // foreach($all_product as $cate){
        //     dd($cate);
        // }
        // dd($all_product);
        return view('user.home', ['categories' => $categories,'products'=>$products,'postcates'=>$postcates])
        ->with('all_product',$all_product)->with('all_post1',$randomPosts1)
        ->with('all_post5',$randomPosts5)->with('suggested_product',$suggested_product);
    }

    public function postDangKy(Request $request) {
        try {
            $email = $request->email;

            // Kiểm tra trùng email
            $emailExists = User::where('email', $email)->exists();

            if ($emailExists) {
                return 'fail'; // Trả về thông báo "fail" nếu email đã tồn tại
            }

            $user = new User;
                $user->fullname = $request -> fullname;
                $user->email = $request -> email;
                $user->phone = $request -> phone;
                $user->password = bcrypt($request -> password);
                $user->save();
                Session::put('user', $user);
                return 'success';
               
                
        } catch(Exception $e) {
            
        }   
        
        
    }
    public function postDangNhap(Request $request) {
        $email = $request -> email;
        $password = $request -> password;
        if(Auth::attempt(['email'=>$email, 'password'=>$password])) {
            if(Auth::user()->isdisable == 1) {
                echo 'disabled';
            } else {
                Session::put('user', Auth::user());
                echo 'success';
            }
        } else {
            echo 'fail';
        }
    }

    public function getDangXuat(Request $request) {
        Session::remove('user');
        return Redirect::to('/'); 
    }

    public function changedPassword(Request $request) {
        $data = $request->all();
        //dd($data);
        $email = $data['email'];
        $password = $data['password'];
        $userid = $data['id'];
        $data = array();
        $data['password'] = bcrypt($request->newPassword);
        if (Auth::attempt(['email'=>$email, 'password'=>$password])) { 
            if(User::updateUser($userid, $data)) {
                echo 'Cập nhật thành công';
            } else {
                echo 'Cập nhật thất bại';
            }
        } else {
                echo 'Mật khẩu chưa chính xác';
        }
    }
}
