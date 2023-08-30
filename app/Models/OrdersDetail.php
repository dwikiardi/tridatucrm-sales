<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'ordernumbers',
        'stockid',
        'qty',
        'hpp',
    ];
    protected $table = "orders_details";
}
