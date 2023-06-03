<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    use HasFactory;
    protected $table = 'bill_detail'; // Tên bảng trong cơ sở dữ liệu

    protected $fillable = ['id', 'id_bill_retail','id_product','quantity','quantity_analysis','form','timestamp']; // Các trường có thể được gán giá trị
    public $timestamps = false; // Vô hiệu hóa tính năng tự động cập nhật thời gian
}
