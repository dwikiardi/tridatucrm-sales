<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    use HasFactory;
    protected $fillable = [
        'ownerid',
        'account_name',
        'address',
        'city',
        'state',
        'zipcode',
        'country',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_zipcode',
        'billing_country',
        'website',
        'email',
        'phone',
        'createbyid',
        'updatebyid',
    ];
    protected $table = "leads";
}
