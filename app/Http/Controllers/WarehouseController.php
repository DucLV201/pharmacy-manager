<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    public function statistics(){

        $prod = DB::table('coupon')->join('products', 'coupon.id_product', '=', 'products.id')
        ->select('coupon.*', 'products.id_form', 'products.name', 'products.numberone', 'products.numbertwo', DB::raw('SUM(coupon.count) as count1'), DB::raw('SUM(coupon.count_acc) as count2'))
        ->groupBy('coupon.id_product')
        ->get();
        $import_request = DB::table('import_request')->get();
        //dd($import_request);
        $data = [];
        foreach ($prod as $row) {
            $count1 = $row->count1;
            $count2 = $row->count2;
            $numberone = $row->numberone;
            $numbertwo = $row->numbertwo;

            if ($row->id_form == 6 || $row->id_form == 5 || $row->id_form == 4) {
                $count1 = floor($count1 / ($numberone * $numbertwo));
                $count2 = floor($count2 / ($numberone * $numbertwo));
                $row->count1 = intval($count1);
                $row->count2 = intval($count2);
            }
            if($count2<10){
                // Thêm thông số mới vào mỗi phần tử
                $row->status = "Sắp hết";
            }else if($count2 == 0){
                $row->status = "Đã hết";
            }else{
                $row->status = "Bình thường";
            }
            $row->check = "";
            foreach ($import_request as $infor) {
                if($infor->id_product == $row->id_product &&  $infor->status=="Đã gửi yêu cầu"){
                    $row->check ="ok";
                }
            }
        
            // Lưu phần tử vào mảng mới
            $data[] = $row;
            
        }
        //dd($data);

        return view('warehouse.statistics')->with('data',$data);
    }
    public function statistics_in(){
        $prod = DB::table('coupon')->join('product_bath', 'coupon.id_bath', '=', 'product_bath.id')
        ->join('products', 'coupon.id_product', '=', 'products.id')
        ->select('coupon.*', 'product_bath.export', 'product_bath.expiry', 'products.numberone', 'products.numbertwo', 'products.id_form', 'product_bath.name_supplier')
        ->get();
        $currentDate = date('Y-m-d'); // Ngày hiện tại
        $recall_request = DB::table('recall_request')->get();
        //dd($prod);
        $data = [];
        foreach ($prod as $row) {
            $count1 = $row->count;
            $count2 = $row->count_acc;
            $numberone = $row->numberone;
            $numbertwo = $row->numbertwo;

            if ($row->id_form == 6 || $row->id_form == 5 || $row->id_form == 4) {
                $count1 = floor($count1 / ($numberone * $numbertwo));
                $count2 = floor($count2 / ($numberone * $numbertwo));
                $row->count = intval($count1);
                $row->count_acc = intval($count2);
            }

            if($row->count_acc > 0){
                $expirationDate = $row->expiry;
                if ($currentDate < $expirationDate) {
                    $diffDays = strtotime($expirationDate) - strtotime($currentDate);
                    $diffDays = floor($diffDays / (60 * 60 * 24)); // Số ngày còn lại đến hết hạn
                    
                    if ($diffDays < 10) {
                        $row->status = 'Sắp hết hạn';
                    } else{
                        $row->status = '';
                    }
                } else {
                    $row->status = 'Đã hết hạn';
                }
                $row->check = "";
                foreach ($recall_request as $infor) {
                if($infor->id_product_bath == $row->id_bath &&  $infor->status=="Đã gửi yêu cầu"){
                    $row->check ="1";
                }
            }

                $data[] = $row;
            }else{
                $row->status = '';
                $row->check = "3";
                foreach ($recall_request as $infor) {
                if($infor->id_product_bath == $row->id_bath && $infor->status=="Đã chấp nhận"){
                    $row->check ="2";//thuốc đã thu hồi 
                }
            }
            $data[] = $row;
        }
        }
        return view('warehouse.statistics_in')->with('data',$data);
    }
    public function cate_manager(){
        $prod_cate = DB::table('categories')
        ->get();
        return view('warehouse.cate_manager')->with('prod_cate',$prod_cate);
    }
    public function add_cate(Request $request){
        $name = $request->name;
        $id_cate = $request->id_cate;

        DB::table('categories')->insert([
            'name' => $name,
            'parent' => $id_cate,
        ]);
        return "ok";
    }
    public function remove_cate(Request $request){
        $id = $request->id;
        //dd($id);
        DB::table('categories')->where('id', $id)->delete();
        return "ok";
    }
    public function update_cate(Request $request){
        $id = $request->id;
        $name = $request->name;
        $id_cate = $request->id_cate;
        
        DB::table('categories')->where('id', $id)->update([
            'name' => $name,
            'parent' => $id_cate,
        ]);
      
        

        return "ok";
    }
    public function prod_manager(){
        $prod = DB::table('products')
        ->join('images', 'products.id', '=', 'images.id_prod')
        ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
        ->groupBy('products.id')
        ->get();
        //dd($prod);
        return view('warehouse.prod_manager')->with('prod',$prod);
    }
    public function notification(){
        $import = DB::table('import_request')
        ->get();
        
        $recall = DB::table('recall_request')
        ->get();
        //dd($recall);
        return view('warehouse.notification')->with('import',$import)->with('recall',$recall);
    }
    public function requestRecovery(Request $request){
    
        $bathId = $request->bathid;
        $reason = $request->lydo;
        $prod = DB::table('coupon')->join('product_bath', 'coupon.id_bath', '=', 'product_bath.id')
        ->join('products', 'coupon.id_product', '=', 'products.id')
        ->select('coupon.*', 'product_bath.export', 'product_bath.expiry', 'products.numberone', 'products.numbertwo', 'products.id_form', 'product_bath.name_supplier')
        ->where('product_bath.id',$bathId)
        ->get();

        //dd($prod);
        foreach ($prod as $row) {
            $count1 = $row->count;
            $count2 = $row->count_acc;
            $numberone = $row->numberone;
            $numbertwo = $row->numbertwo;

            if ($row->id_form == 6 || $row->id_form == 5 || $row->id_form == 4) {
                $count1 = floor($count1 / ($numberone * $numbertwo));
                $count2 = floor($count2 / ($numberone * $numbertwo));
                $row->count = intval($count1);
                $row->count_acc = intval($count2);
            }

            DB::table('recall_request')->insert([
                'id_product' => $row->id_product,
                'export' => $row->export,
                'expiry' => $row->expiry,
                'count' => $row->count,
                'count_acc' => $row->count_acc,
                'reason' => $reason,
                'name_supplier' => $row->name_supplier,
                'id_product_bath' => $row->id_bath,
                'status' =>"Đã gửi yêu cầu"
            ]);
        }
    
        return response()->json(['success' => true]);
    }
    public function request_import(Request $request){
    
        $id = $request->id;

        $prod = DB::table('coupon')->join('products', 'coupon.id_product', '=', 'products.id')
        ->select('coupon.*', 'products.id_form', 'products.name', 'products.numberone', 'products.numbertwo', DB::raw('SUM(coupon.count) as count1'), DB::raw('SUM(coupon.count_acc) as count2'))
        ->groupBy('coupon.id_product')
        ->where('products.id',$id)
        ->get();

        //dd($prod);
        foreach ($prod as $product) {
            $count1 = $product->count1;
            $count2 = $product->count2;
            $numberone = $product->numberone;
            $numbertwo = $product->numbertwo;

            if ($product->id_form == 6 || $product->id_form == 5 || $product->id_form == 4) {
                $count1 = floor($count1 / ($numberone * $numbertwo));
                $count2 = floor($count2 / ($numberone * $numbertwo));
                $product->count1 = intval($count1);
                $product->count2 = intval($count2);
            }

            DB::table('import_request')->insert([
                'id_product' => $product->id_product,
                'name' => $product->name,
                'quantity' => $product->count1,
                'quantity_remaining' => $product->count2,
                'status' =>"Đã gửi yêu cầu"
            ]);
        }
    
        return response()->json(['success' => true]);
    }
    public function gdadd_product(){
        $prod_cate = DB::table('categories')->where('parent','!=',0)->get();
        $prod_form = DB::table('form_products')->get();
        //dd($prod_form);
        return view('warehouse.add_product')->with('prod_cate',$prod_cate)->with('prod_form',$prod_form);
    }
    public function add_product(Request $request){
        // Lấy các giá trị từ request
        $productCode = $request->input('product_code');
        $productName = $request->input('product_name');
        $productPrice = $request->input('product_price');
        $postCateId = $request->input('postcate_id');
        $productType = $request->input('product_type');
        $productForm = $request->input('product_form');
        $productDosageForm = $request->input('product_dosage_form');
        $productDescription = $request->input('product_description');
        $productBenefits = $request->input('product_benefits');
        $productDosage = $request->input('product_dosage');
        $productSideEffects = $request->input('product_side_effects');
        $productStorage = $request->input('product_storage');
        $quantityOne = $request->input('quantity_one');
        $quantityTwo = $request->input('quantity_two');
        $imageUrl = $request->input('image_name');
            //dd( $productCode);
        // Thực hiện insert dữ liệu vào bảng products
        $productId = DB::table('products')->insertGetId([
            'id' => $productCode,
            'name' => $productName,
            'price' => $productPrice,
            'id_cate' => $postCateId,
            'type_price' => $productType,
            'id_form' => $productForm,
            'dosage_forms' => $productDosageForm,
            'description' => $productDescription,
            'uses' => $productBenefits,
            'dosage' => $productDosage,
            'side_effects' => $productSideEffects,
            'preserve' => $productStorage,
            'numberone' => $quantityOne,
            'numbertwo' => $quantityTwo
        ]);
        $img = DB::table('images')->insert([
            'id_prod' => $productCode,
            'url' => $imageUrl,
        ]);
        // Kiểm tra kết quả insert
            if ($productId) {
                return response()->json(['success' => true, 'message' => 'Thêm sản phẩm thành công']);
            } else {
                return response()->json(['success' => false, 'message' => 'Thêm sản phẩm thất bại']);
            }
    }

    public function gdupdate_product($id){
        $prod_cate = DB::table('categories')->where('parent','!=',0)->get();
        $prod_form = DB::table('form_products')->get();

        $all_product = DB::table('products')
        ->join('images', 'products.id', '=', 'images.id_prod')
        ->select('products.*', DB::raw('GROUP_CONCAT(images.url) as url'))
        ->groupBy('products.id')
        ->where('products.id','=',$id)
        ->first();
        //dd($prod_form);
        return view('warehouse.update_product')->with('prod_cate',$prod_cate)
        ->with('prod_form',$prod_form)->with('all_product',$all_product);
    }
    public function update_product(Request $request){
        // Lấy các giá trị từ request
        $productCode = $request->input('product_code');
        $productName = $request->input('product_name');
        $productPrice = $request->input('product_price');
        $postCateId = $request->input('postcate_id');
        $productType = $request->input('product_type');
        $productForm = $request->input('product_form');
        $productDosageForm = $request->input('product_dosage_form');
        $productDescription = $request->input('product_description');
        $productBenefits = $request->input('product_benefits');
        $productDosage = $request->input('product_dosage');
        $productSideEffects = $request->input('product_side_effects');
        $productStorage = $request->input('product_storage');
        $quantityOne = $request->input('quantity_one');
        $quantityTwo = $request->input('quantity_two');
        $imageUrl = $request->input('image_name');
            //dd( $productCode);
        // Thực hiện insert dữ liệu vào bảng products
        $productId = DB::table('products')->where('id',$productCode)->update([
            'id' => $productCode,
            'name' => $productName,
            'price' => $productPrice,
            'id_cate' => $postCateId,
            'type_price' => $productType,
            'id_form' => $productForm,
            'dosage_forms' => $productDosageForm,
            'description' => $productDescription,
            'uses' => $productBenefits,
            'dosage' => $productDosage,
            'side_effects' => $productSideEffects,
            'preserve' => $productStorage,
            'numberone' => $quantityOne,
            'numbertwo' => $quantityTwo
        ]);
        // $img = DB::table('images')->update([
        //     'id_prod' => $productCode,
        //     'url' => $imageUrl,
        // ]);
        // Kiểm tra kết quả insert
            if ($productId) {
                return response()->json(['success' => true, 'message' => 'Cập nhật sản phẩm thành công']);
            } else {
                return response()->json(['success' => false, 'message' => 'Cập nhật sản phẩm thất bại']);
            }
    }
    public function gdimport_product(){
        $all_product = DB::table('products')
        ->get();
        //dd($prod_form);

        return view('warehouse.import_product')->with('all_product',$all_product);
    }
    public function import_product(Request $request){
        $id = Session::get('user')->id;
        $all_product = DB::table('products')
        ->where('products.id','=',$request->product_id)
        ->first();
        $count1 = $request->count * $all_product->numberone * $all_product->numbertwo;
        
        $product_bath = DB::table('product_bath')->insertGetId([
            'id' => $request->product_bath,
            'export' => $request->exportt,
            'expiry' => $request->expiry,
            'name_supplier' => $request->name_bath,
            'address' => $request->address,
            'phone' => $request->phone
        ]);
        
        
        $product_bath = DB::table('coupon')->insertGetId([
            'id_staff' => $id,
            'id_bath' => $request->product_bath,
            'id_product' => $request->product_id,
            'count' => $count1,
            'count_acc' => $count1
        ]);
        //dd($request,$id);
    }
    public function remove_product(Request $request){
        $id = $request->id;
        //dd($id);
        $bath = DB::table('coupon')->where('id_product','=',$id)->first();
        $id_bath = $bath->id_bath;
        DB::table('coupon')->where('id_product', $id)->delete();
        DB::table('product_bath')->where('id', $id_bath)->delete();
        DB::table('products')->where('id', $id)->delete();
        return "ok";
    }
}
