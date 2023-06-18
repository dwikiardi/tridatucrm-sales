<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_name',
        'contact',
        'address',
        'city',
        'state',
        'zipcode',
        'country',
        'mobile',
        'phone',
        'email',
        'billing_contact',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_zipcode',
        'billing_country',
        'billing_mobile',
        'billing_phone',
        'billing_email',
        'type',//Vendor Type : Work, Sale stock
        'website',
        'note',
        'createbyid',
        'updatebyid',
    ];
    protected $table = "vendors";
}
