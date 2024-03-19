<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;
    protected $fillable = [
        'ownerid',
        'accountid',
        'type',// Lead or Contacts
        'leadsname',
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
        'pic_contact',
        'pic_email',
        'pic_mobile',
        'pic_phone',
        'billing_contact',
        'billing_email',
        'billing_mobile',
        'billing_phone',
        'property_name',
        'property_address',
        'property_city',
        'property_state',
        'property_zipcode',
        'property_country',
        'maplong',
        'maplat',
        'gmapurl',
        'status',
        'active',
        'note',
        'createbyid',
        'updatebyid',
        'packageid','req_packageid'
    ];
    protected $table = "leads";
}
