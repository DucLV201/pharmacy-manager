<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupon'; // Tên bảng trong cơ sở dữ liệu

    protected $fillable = ['id', 'id_staff','time','id_bath','id_product','count','count_acc']; // Các trường có thể được gán giá trị
    public $timestamps = false; // Vô hiệu hóa tính năng tự động cập nhật thời gian
}
