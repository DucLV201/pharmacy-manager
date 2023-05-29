<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

use App\Mail\PasswordEmail;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class ForgotPasswordController extends Controller
{

    protected function sendResetLinkEmail(Request $request)
    {
        $email= $request->email;
        $token= $request->_token;
        //dd($token);
        $user = DB::table('users')->where('email', $email)->first();
        if ($user) {
            $password_reset = new PasswordReset;
                $password_reset->email = $email;
                $password_reset->token = $token;
                $password_reset->save();

            $resetUrl = URL::to('/password/reset/'.$token);
            // Tạo một instance của lớp email và truyền địa chỉ email nhận
            $mail = new PasswordEmail($resetUrl); // Thay thế bằng tên lớp của email mẫu của bạn
            $mail->to($email);

            // Gửi email
            Mail::send($mail);

            return 'success';
        } else {
            // Email không tồn tại trong bảng "users"
            return 'fail';
        }
        
    }
    public  function showResetForm($token){
        $categories = Category::all();
        $password_reset = PasswordReset::where('token', $token)->latest('created_at')->first();
        $email = $password_reset->email;
        $user = DB::table('users')->where('email', $email)->first();
        //dd($user);

        return view('emails.form_reset_pass', ['categories' => $categories])
        ->with('user',$user);
       
    }

    // public function changePassword($newPassword)
    // {
    //     $this->password = bcrypt($newPassword);
    //     $this->save();
    // }
    public function reset(Request $request) {
        $id = $request -> id;
        
        $password = $request -> password;
        //dd(bcrypt($password),$password);

        $user = DB::table('users')->where('id', $id)->update(['password' => bcrypt($password)]);
        //dd($user);
        //$user->changePassword($password);

        return 'success';
    }

}