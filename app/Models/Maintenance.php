<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomaintenance',
        'date',
        'maintenancedate',
        'leadid',
        'staffid',
        'note',
        'problem',
        'result',
        'swap',
        'reqstock',
        'status',
        'createdbyid',
        'updatedbyid',
    ];
    protected $table = "maintenance";
}
