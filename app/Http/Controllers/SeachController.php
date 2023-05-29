<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class SeachController extends Controller
{
    public function show_suggestion (Request $request) {
        $data = $request->all();

        $results  =DB::table('images')
        ->join('products','images.id_prod','=','products.id')
        ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
        ->groupBy('products.id')
        ->where('products.name','like', '%'.$data['searchKey'].'%')->limit(4)->get();
        

        $output = '';
        

        foreach($results as $key => $product) {
            $image_url = explode(',', $product->url)[0]; 
            $output .= '<li class="input-resultlist">
                <a class="row input-result__item" href=./chi-tiet-san-pham/' . $product->id.') . ">
                    
                    <img src="' . asset('frontend/images/' . $image_url) . '" alt="" class="col-lg-2 col-md-2 col-xs-2">
                    <div class="col-lg-9">
                        <h6 class="row" style="color:#000000">' . $product->name . '</h4>
                        <h7 class="row" style="color:red">' . number_format($product->price) . 'đ</h5>
                    </div>
                </a>
            </li>';

        }
        echo $output;

                
    }
    public function show_search_results(Request $request){
        $searchKey = $request->search_key;
        $categories = Category::all();
        $price =0;
        $all_product = DB::table('images')
        ->join('products','images.id_prod','=','products.id')
        ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
        ->groupBy('products.id')
        ->where('products.name','like', '%'.$searchKey.'%')->paginate(8);
        $object=DB::table('object')
        ->join('products','object.id_product','=','products.id')
        ->select('object.name')->distinct()
        ->where('products.name','like', '%'.$searchKey.'%')
        ->paginate(8);
        $trademark=DB::table('coupon')
        ->join('products','coupon.id_product','=','products.id')
        ->join('product_bath','coupon.id_bath','=','product_bath.id')
        ->select('product_bath.name_supplier')->distinct()
        ->where('products.name','like', '%'.$searchKey.'%')
        ->paginate(8);
        $check_object = "";
        $check_trade="";
        return view('user.product', ['categories' => $categories])
        ->with('all_product',$all_product)
        ->with('check_object',$check_object)->with('object',$object)
        ->with('trademark',$trademark)->with('check_trade',$check_trade)
        ->with('price',$price)->with('searchKey',$searchKey);
                   
    }
    public  function category_object($searchKey,$name){
        $categories = Category::all();
        $price =0;
        $all_product = DB::table('images')
        ->join('products','images.id_prod','=','products.id')
        ->join('object','products.id','=','object.id_product')
        ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
        ->groupBy('products.id')
        ->where('object.name','=',$name)
        ->where('products.name','like', '%'.$searchKey.'%')->paginate(8);
        //dd($all_product);

        $object=DB::table('object')
        ->join('products','object.id_product','=','products.id')
        ->select('object.name')->distinct()
        ->where('products.name','like', '%'.$searchKey.'%')->paginate(8);

        $trademark=DB::table('coupon')
        ->join('products','coupon.id_product','=','products.id')
        ->join('object','products.id','=','object.id_product')
        ->join('product_bath','coupon.id_bath','=','product_bath.id')
        ->select('product_bath.name_supplier')->distinct()
        ->where('products.name','like', '%'.$searchKey.'%')
        ->paginate(8);
        $check_object=$name;
        $check_trade="";
        return view('user.product', ['categories' => $categories])
        ->with('all_product',$all_product)->with('searchKey',$searchKey)
        ->with('check_object',$check_object)->with('object',$object)
        ->with('trademark',$trademark)->with('check_trade',$check_trade)
        ->with('price',$price);
    }

    public  function category_trademark($searchKey,$name){
        $categories = Category::all();
        $price =0;
        $all_product = DB::table('images')
        ->join('products','images.id_prod','=','products.id')
        ->join('coupon','products.id','=','coupon.id_product')
        ->join('object','products.id','=','object.id_product')
        ->join('product_bath','coupon.id_bath','=','product_bath.id')
        ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'),'product_bath.name_supplier')
        ->groupBy('products.id')
        ->where('product_bath.name_supplier','=',$name)
        ->where('products.name','like', '%'.$searchKey.'%')->paginate(8);
        //dd($all_product);
        $object=DB::table('object')
        ->join('products','object.id_product','=','products.id')
        ->select('object.name')->distinct()
        ->where('products.name','like', '%'.$searchKey.'%')
        ->paginate(8);
        $trademark=DB::table('coupon')
        ->join('products','coupon.id_product','=','products.id')
        ->join('product_bath','coupon.id_bath','=','product_bath.id')
        ->select('product_bath.name_supplier')->distinct()
        ->where('products.name','like', '%'.$searchKey.'%')
        ->paginate(8);
        $check_object="";
        $check_trade=$name;
        return view('user.product', ['categories' => $categories])
        ->with('all_product',$all_product)->with('searchKey',$searchKey)
        ->with('check_object',$check_object)->with('object',$object)
        ->with('trademark',$trademark)->with('check_trade',$check_trade)
        ->with('price',$price);
    }
    public  function category_price($searchKey,$price){
        $categories = Category::all();
        // $check =0;
        
        if($price==1)
            $all_product = DB::table('images')
            ->join('products','images.id_prod','=','products.id')
            ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
            ->groupBy('products.id')
            ->where('products.price', '<', 100000)
            ->where('products.name','like', '%'.$searchKey.'%')->get();
        elseif($price==2)
            $all_product = DB::table('images')
            ->join('products','images.id_prod','=','products.id')
            ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
            ->groupBy('products.id')
            ->where('products.price', '>', 100000)->where('products.price', '<', 300000)
            ->where('products.name','like', '%'.$searchKey.'%')->paginate(8);
        elseif($price==3)
            $all_product = DB::table('images')
            ->join('products','images.id_prod','=','products.id')
            ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
            ->groupBy('products.id')
            ->where('products.price', '>', 300000)->where('products.price', '<', 500000)
            ->where('products.name','like', '%'.$searchKey.'%')->paginate(8);
        else
            $all_product = DB::table('images')
            ->join('products','images.id_prod','=','products.id')
            ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
            ->groupBy('products.id')
            ->where('products.price', '>', 500000)
            ->where('products.name','like', '%'.$searchKey.'%')->paginate(8);

        //dd($all_product);
        $object=DB::table('object')
        ->join('products','object.id_product','=','products.id')
        ->select('object.name')->distinct()
        ->where('products.name','like', '%'.$searchKey.'%')
        ->paginate(8);
        $trademark=DB::table('coupon')
        ->join('products','coupon.id_product','=','products.id')
        ->join('product_bath','coupon.id_bath','=','product_bath.id')
        ->select('product_bath.name_supplier')->distinct()
        ->where('products.name','like', '%'.$searchKey.'%')
        ->paginate(8);
        $check_object = "";
        $check_trade="";
        return view('user.product', ['categories' => $categories])
        ->with('all_product',$all_product)->with('searchKey',$searchKey)
        ->with('check_object',$check_object)->with('object',$object)
        ->with('trademark',$trademark)->with('check_trade',$check_trade)
        ->with('price',$price);
    }
}
