<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockCategorys extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_name',
        'desk',
        'createbyid',
        'updatebyid',
    ];
    protected $table = "stock_categories";
}
