<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StocksNoSeri extends Model
{
    use HasFactory;
    protected $fillable = [
        'noseri',
        'stockid',
        'posmodule',
        'module_id',
    ];
    protected $table = "stocks_no_seri";
}
