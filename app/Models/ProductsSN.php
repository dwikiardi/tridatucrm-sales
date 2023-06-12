<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsSN extends Model
{
    use HasFactory;
    protected $fillable = [
        'stocksn',
        'productid',
        'vendorid',
        'propertiesid',
        'status',
        'createbyid',
        'updatebyid',
        'price'
    ];
    protected $table = "stocks";
}
