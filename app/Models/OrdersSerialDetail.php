<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersSerialDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'ordernumbers',
        'stockid',
        'stockcode',
        'serial',
    ];
    protected $table = "orders_serial_detail";
}
