<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(){
        $count1 = DB::table('products')->count();
        $count2 = DB::table('orders')->count();
        $count3 = DB::table('bill_retail')->count();
        return view('admin.statistic')->with('count1',$count1)->with('count2',$count2)->with('count3',$count3);
    }
    public function reply_request(){
        $import = DB::table('import_request')
        ->get();
        
        $recall = DB::table('recall_request')
        ->get();
        return view('admin.reply_request')->with('import',$import)->with('recall',$recall);
    }
    public function decentralization(){
        $user = DB::table('users')
        ->get();
        return view('admin.decentralization')->with('user',$user);
    }
    public function reply_recall_y(Request $request){
        $id = $request->id;
        $bathid = $request->bathid;
        //dd($bathid);
        
        $recall = DB::table('recall_request')
        ->where('id',$id)
        ->update(['status'=>"Đã chấp nhận"]);
        
        DB::table('coupon')->where('id_bath', $bathid)->update(['count_acc'=>0]);
        return "ok";
    }
    public function reply_recall_n(Request $request){
        $id = $request->id;
        $recall = DB::table('recall_request')
        ->where('id',$id)
        ->update(['status'=>"Đã từ chối"]);
    }
    public function reply_import_y(Request $request){
        $id = $request->id;
        $recall = DB::table('import_request')
        ->where('id',$id)
        ->update(['status'=>"Đã chấp nhận"]);
        return "ok";
    }
    public function reply_import_n(Request $request){
        $id = $request->id;
        $recall = DB::table('import_request')
        ->where('id',$id)
        ->update(['status'=>"Đã từ chối"]);
        return "ok";
    }
    public function undisable(Request $request) {
        $id = $request->userId;
        $user = DB::table('users')
              ->where('id', $id)
              ->update(['isdisable' => 0]);
    }
    public function disable(Request $request) {
        $id = $request->userId;
        $user = DB::table('users')
              ->where('id', $id)
              ->update(['isdisable' => 1]);
    }
    public function update_permission(Request $request) {
        $id = $request->accountId;
        $permission = $request->permission;
        $user = DB::table('users')
              ->where('id', $id)
              ->update(['isadmin' => $permission]);
        
        if($permission == 1)
            return 1;
        else if($permission == 2)
            return 2;
        else if($permission == 3)
            return 3;
        else
            return 0;
    }
    public function remove_user(Request $request){
        $id = $request->id;
        //dd($id);
        DB::table('users')->where('id', $id)->delete();
        return "ok";
    }
}
