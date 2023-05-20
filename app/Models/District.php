<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'districts'; // Tên bảng trong cơ sở dữ liệu

    protected $fillable = ['id', 'name','province_id']; // Các trường có thể được gán giá trị
    public $timestamps = false; // Vô hiệu hóa tính năng tự động cập nhật thời gian
}
