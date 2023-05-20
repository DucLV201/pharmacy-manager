<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Post;
use App\Models\PostCate;

class CategoryProduct extends Controller
{
    public  function show_category_home($id){
        $categories = Category::all();
        $price =0;
        $all_product = DB::table('images')
        ->join('products','images.id_prod','=','products.id')
        ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
        ->groupBy('products.id')
        ->where('products.id_cate','=',$id)->get();
        $product_cate =DB::table('categories')
        ->select('categories.*')
        ->where('categories.id','=',$id)->get();
        $object=DB::table('object')
        ->join('products','object.id_product','=','products.id')
        ->select('object.name')->distinct()
        ->where('products.id_cate','=',$id)
        ->get();
        $trademark=DB::table('coupon')
        ->join('products','coupon.id_product','=','products.id')
        ->join('product_bath','coupon.id_bath','=','product_bath.id')
        ->select('product_bath.name_supplier')->distinct()
        ->where('products.id_cate','=',$id)
        ->get();
        $check_object = "";
        $check_trade="";
        return view('user.show_details', ['categories' => $categories])
        ->with('all_product',$all_product)->with('product_cate',$product_cate)
        ->with('check_object',$check_object)->with('object',$object)
        ->with('trademark',$trademark)->with('check_trade',$check_trade)
        ->with('price',$price);
    }

    // public  function show_category_outstanding($id){
    //     $categories = Category::all();

    //     $check =0;
    //     if($id==100)
    //          $check=1;
    //     elseif($id==200)
    //          $check=2;
    //     $all_product = DB::table('images')
    //     ->join('products','images.id_prod','=','products.id')
    //     ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
    //     ->groupBy('products.id')
    //     ->where('products.class','=',$check)->get();

        

    //     return view('user.show_details', ['categories' => $categories])
    //     ->with('all_product',$all_product)->with('check',$check);
    // }

    public  function category_object($id,$name){
        $categories = Category::all();
        $price =0;
        $all_product = DB::table('images')
        ->join('products','images.id_prod','=','products.id')
        ->join('object','products.id','=','object.id_product')
        ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
        ->groupBy('products.id')
        ->where('object.name','=',$name)
        ->where('products.id_cate','=',$id)->get();
        //dd($all_product);
        $product_cate =DB::table('categories')
        ->select('categories.*')
        ->where('categories.id','=',$id)->get();
        $object=DB::table('object')
        ->join('products','object.id_product','=','products.id')
        ->select('object.name')->distinct()
        ->where('products.id_cate','=',$id)
        ->get();
        $trademark=DB::table('coupon')
        ->join('products','coupon.id_product','=','products.id')
        ->join('object','products.id','=','object.id_product')
        ->join('product_bath','coupon.id_bath','=','product_bath.id')
        ->select('product_bath.name_supplier')->distinct()
        ->where('products.id_cate','=',$id)
        ->where('object.name','=',$name)
        ->get();
        $check_object=$name;
        $check_trade="";
        return view('user.show_details', ['categories' => $categories])
        ->with('all_product',$all_product)->with('product_cate',$product_cate)
        ->with('check_object',$check_object)->with('object',$object)
        ->with('trademark',$trademark)->with('check_trade',$check_trade)
        ->with('price',$price);
    }

    public  function category_trademark($id,$name_object,$name){
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
        ->where('products.id_cate','=',$id)->get();
        //dd($all_product);
        $product_cate =DB::table('categories')
        ->select('categories.*')
        ->where('categories.id','=',$id)->get();
        $object=DB::table('object')
        ->join('products','object.id_product','=','products.id')
        ->select('object.name')->distinct()
        ->where('products.id_cate','=',$id)
        ->get();
        $trademark=DB::table('coupon')
        ->join('products','coupon.id_product','=','products.id')
        ->join('product_bath','coupon.id_bath','=','product_bath.id')
        ->select('product_bath.name_supplier')->distinct()
        ->where('products.id_cate','=',$id)
        ->get();
        $check_object=$name_object;
        $check_trade=$name;
        return view('user.show_details', ['categories' => $categories])
        ->with('all_product',$all_product)->with('product_cate',$product_cate)
        ->with('check_object',$check_object)->with('object',$object)
        ->with('trademark',$trademark)->with('check_trade',$check_trade)
        ->with('price',$price);
    }

    public  function category_price($id,$price){
        $categories = Category::all();
        // $check =0;
        
        if($price==1)
            $all_product = DB::table('images')
            ->join('products','images.id_prod','=','products.id')
            ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
            ->groupBy('products.id')
            ->where('products.price', '<', 100000)
            ->where('products.id_cate','=',$id)->get();
        elseif($price==2)
            $all_product = DB::table('images')
            ->join('products','images.id_prod','=','products.id')
            ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
            ->groupBy('products.id')
            ->where('products.price', '>', 100000)->where('products.price', '<', 300000)
            ->where('products.id_cate','=',$id)->get();
        elseif($price==3)
            $all_product = DB::table('images')
            ->join('products','images.id_prod','=','products.id')
            ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
            ->groupBy('products.id')
            ->where('products.price', '>', 300000)->where('products.price', '<', 500000)
            ->where('products.id_cate','=',$id)->get();
        else
            $all_product = DB::table('images')
            ->join('products','images.id_prod','=','products.id')
            ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
            ->groupBy('products.id')
            ->where('products.price', '>', 500000)
            ->where('products.id_cate','=',$id)->get();

        //dd($all_product);
        $product_cate =DB::table('categories')
        ->select('categories.*')
        ->where('categories.id','=',$id)->get();
        $object=DB::table('object')
        ->join('products','object.id_product','=','products.id')
        ->select('object.name')->distinct()
        ->where('products.id_cate','=',$id)
        ->get();
        $trademark=DB::table('coupon')
        ->join('products','coupon.id_product','=','products.id')
        ->join('product_bath','coupon.id_bath','=','product_bath.id')
        ->select('product_bath.name_supplier')->distinct()
        ->where('products.id_cate','=',$id)
        ->get();
        $check_object = "";
        $check_trade="";
        return view('user.show_details', ['categories' => $categories])
        ->with('all_product',$all_product)->with('product_cate',$product_cate)
        ->with('check_object',$check_object)->with('object',$object)
        ->with('trademark',$trademark)->with('check_trade',$check_trade)
        ->with('price',$price);
    }
    // public function yourMethod($id,Request $request)
    // {
    //     $name = $request->query('name');
    //     //dd($name); // Lấy giá trị của tham số "price" từ query string
        
    //     $categories = Category::all();
    //     $check =0;
    //     $all_product = DB::table('images')
    //     ->join('products','images.id_prod','=','products.id')
    //     ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
    //     ->groupBy('products.id')
    //     ->where('products.id_cate','=',$id)->get();
    //     $product_cate =DB::table('categories')
    //     ->select('categories.*')
    //     ->where('categories.id','=',$id)->get();
    //     $object=DB::table('object')
    //     ->join('products','object.id_product','=','products.id')
    //     ->select('object.name')->distinct()
    //     ->where('products.id_cate','=',$id)
    //     ->get();
    //     $trademark=DB::table('coupon')
    //     ->join('products','coupon.id_product','=','products.id')
    //     ->join('product_bath','coupon.id_bath','=','product_bath.id')
    //     ->select('product_bath.name_supplier')->distinct()
    //     ->where('products.id_cate','=',$id)
    //     ->get();
    //     $check_object = "";
    //     $check_trade="";
    //     return view('user.test', ['categories' => $categories])
    //     ->with('all_product',$all_product)->with('product_cate',$product_cate)
    //     ->with('check',$check)->with('check_object',$check_object)->with('object',$object)
    //     ->with('trademark',$trademark)->with('check_trade',$check_trade);

        
    // }

    
}
