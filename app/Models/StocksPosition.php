<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StocksPosition extends Model
{
    use HasFactory;
    protected $fillable = [
        'stockid',
        'posmodule',
        'module_id',
        'qty',
    ];
    protected $table = "stocks_position";
}
