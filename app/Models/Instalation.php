<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instalation extends Model
{
    use HasFactory;
    protected $fillable = [
        'noinstall',
        'date',
        'installdate',
        'leadid',
        'installerid',
        'processbyid',
        'note',
        'status',
        'createdbyid',
        'updatedbyid',
    ];
    protected $table = "installation";
}
