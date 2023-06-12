<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $fillable = [
        'productname',
        'producttype',
        'description',
        'havesn',
        'note',
        'createbyid',
        'updatebyid',
        'price'
    ];
    protected $table = "products";
}
