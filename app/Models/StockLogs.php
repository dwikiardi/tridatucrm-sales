<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLogs extends Model
{
    use HasFactory;
    protected $fillable = [
        'stockid',
        'stockcode',
        'serial',
        'qty',
        'transtype',
        'module',
        'moduleid',
        'note',
        'createdbyid',
        'updatedbyid',
        'transcation_number',
    ];
    protected $table = "stock_logs";
}
