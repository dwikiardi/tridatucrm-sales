<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevocationDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'notrans',
        'stockid',
        'qty',
        'serial',
        'status',
        'revserial',
        'revqty',
    ];
    protected $table = "revocation_detail";
}
