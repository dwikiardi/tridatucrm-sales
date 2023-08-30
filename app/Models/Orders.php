<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $fillable = [
        'ordernumbers',
        'ordername',
        'orderdate',
        'note',
        'vendorid',
        'orderstatus',
        'createdbyid',
        'updatedbyid',
        'subtotal',
        'tax',
        'shipping',
        'total',
        'supno',
    ];
    protected $table = "orders";
}
