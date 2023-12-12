<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomaintenance',
        'stockid',
        'qty',
        'serial',
        'status',
        'instaledserial',
        'installedqty',
    ];
    protected $table = "maintenance_detail";
}
