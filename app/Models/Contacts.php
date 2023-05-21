<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;
    protected $fillable = [
        'contactname'
        ,'ownerid'
        ,'accountid'
        ,'email'
        ,'optemail'
        ,'address'
        ,'city'
        ,'province'
        ,'country'
        ,'zipcode'
        ,'fax'
        ,'phone'
        ,'mobile'
        ,'optmobile'
        ,'billingaddress'
        ,'billingcity'
        ,'billingprovince'
        ,'billingcountry'
        ,'billingzipcode'
        ,'note'
        ,'active'
        ,'createbyid'
        ,'updatebyid'
    ];
    protected $table = "contacts";
}
