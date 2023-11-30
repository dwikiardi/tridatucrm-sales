<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstalationDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'noinstall',
        'category',
        'stockid',
        'stockcode',
        'serial',
        'qty',
        'status',
        'instaled',
        'instaledserial',
        'installedqty',
    ];
    protected $table = "installationdtl";
}
