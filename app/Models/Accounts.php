<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    use HasFactory;
    protected $fillable = [
        'fullname',
        'ownerid',
        'address',
        'city',
        'province',
        'country',
        'zipcode',
        'website',
        'email',
        'fax',
        'phone',
        'billingaddress',
        'billingcity',
        'billingprovince',
        'billingcountry',
        'billingzipcode',
        'billingemail',
        'billingfax',
        'billingphone',
        'description',
        'accounttype',
        'active',
        'createbyid',
        'updatebyid',
        'note',
        'leadid'
    ];
    protected $table = "accounts";
}
