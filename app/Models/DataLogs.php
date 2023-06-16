<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataLogs extends Model
{
    use HasFactory;
    protected $fillable = [
        'module',
        'moduleid',
        'logname',
        'olddata',
        'newdata',
        'createbyid',
    ];
    protected $table = "datalogs";
}
