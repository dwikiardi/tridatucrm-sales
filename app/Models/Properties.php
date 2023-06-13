<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Properties extends Model
{
    use HasFactory;
    protected $fillable = [
        'propertyname',
        'ownerid',
        'accountid',
        'contactid',
        'address',
        'city',
        'province',
        'country',
        'zipcode',
        'fax',
        'email',
        'phone',
        'mobile',
        'maplat',
        'maplong',
        'mapurl',
        'note',
        'active',
        'productid',
        'createbyid',
        'updatebyid'
    ];
    protected $table = "properties";
}
