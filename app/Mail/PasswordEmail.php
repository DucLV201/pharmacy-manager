<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetUrl;

    public function __construct($resetUrl)
    {
        $this->resetUrl = $resetUrl;
    }
    public function build()
    {
        return $this->view('emails.reset_password') // Tên view cho nội dung email
                    ->subject('Đặt lại mật khẩu của bạn') // Chủ đề của email
                    ->from('sender@example.com', 'Người gửi'); // Địa chỉ email và tên người gửi
    }
}
