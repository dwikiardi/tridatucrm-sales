<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotes extends Model
{
    use HasFactory;
    protected $fillable = [
        'ownerid',
        'leadid',
        'quotenumber',
        'quotedate',
        'quotename',
        'toperson',
        'toaddress',
        'approve',
        'approvedbyid',
        'note',
        'attcfile',
        'createbyid',
        'updatebyid',
    ];
    protected $table = "quotes";
}
