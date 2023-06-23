<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    use HasFactory;
    protected $fillable = [
        'stockid',
        'stockname',
        'desk',
        'sell_price',
        'categoryid',
        'qtytype',//0: Qty; 1: SumNoseri
        'unit',
        'createbyid',
        'updatebyid'
    ];
    protected $table = "stocks";
}
