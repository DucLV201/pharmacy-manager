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
        ->where('products.id','=',$id)->get();
        //  dd($detai_product);
        return view('user.details_product', ['categories' => $categories])
        ->with('product_details',$detai_product)->with('images',$images);
    }
}
