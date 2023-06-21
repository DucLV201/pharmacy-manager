<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use App\Models\Category;

class ProductController extends Controller
{
    public  function test($id){
        $categories = Category::all();
        $images = DB::table('images')->join('products','images.id_prod','=','products.id')->where('products.id','=',$id)->get();
        $detai_product = DB::table('products')
        ->join('coupon', 'products.id', '=', 'coupon.id_product')
        ->join('product_bath', 'coupon.id_bath', '=', 'product_bath.id')
        ->join('categories', 'products.id_cate', '=', 'categories.id')
        ->select('products.*','product_bath.name_supplier','product_bath.address',DB::raw('categories.name as name_cate') )
        ->groupby('products.id')
        ->where('products.id','=',$id)->get();
          //dd($detai_product);
        return view('user.details_product', ['categories' => $categories])
        ->with('product_details',$detai_product)->with('images',$images);
    }
    public function get_productid(Request $request){
        $id = $request -> productId;
        
        $product_info  = DB::table('products')
        ->join('images', 'products.id', '=', 'images.id_prod')
        ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
        ->where('products.id','=',$id)
        ->first();

        $check = $product_info ->id_form;
        if($check == 1)
            $data['formOptions'] = ["Tuýp"];
        elseif($check==2)
            $data['formOptions'] = ["Chai"];
        elseif($check==3)
            $data['formOptions'] = ["Hộp"];
        elseif($check==4){
                $data['formOptions'] = ["Gói", "Hộp"];
        }
        elseif($check==5){
                $data['formOptions'] = ["Ống", "Hộp"];
        }
        else{
                $data['formOptions'] = ["Viên", "Vỉ", "Hộp"];
        }
        //dd($data);

        $data['id'] = $product_info ->id;
        $data['name'] = $product_info ->name;
        $data['price'] = $product_info ->price;
        $data['one'] = $product_info ->numberone;
        $data['two'] = $product_info ->numbertwo;
        $imageArray = explode(',', $product_info->url);
        // Lấy ảnh đầu tiên từ mảng
        $data['image'] = $imageArray[0];
        //dd($data);
        return response()->json($data);
    }
}
