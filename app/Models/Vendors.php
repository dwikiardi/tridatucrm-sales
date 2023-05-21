<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendorname',
        'vendortype',
        'ownerid',
        'address',
        'city',
        'province',
        'country',
        'contactname',
        'mobile',
        'phone',
        'email',
        'website',
        'note',
        'createbyid',
        'updatebyid'
    ];
    protected $table = "vendors";
}
