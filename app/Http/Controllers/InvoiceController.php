<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;


class InvoiceController extends Controller
{
    public  function index(){
        $id = Session::get('user')->id;
        $name = Session::get('user')->fullname; 
        //dd($id);
        return view('admin.invoice', ['id' => $id, 'name' => $name]);
       
    }
    public  function add_retail(Request $request){
        $id = Session::get('user')->id;
        $name = Session::get('user')->fullname; 

        dd($request);
        return view('admin.invoice', ['id' => $id, 'name' => $name]);
       
    }
}
