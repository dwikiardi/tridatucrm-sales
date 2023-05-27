<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;
    protected $fillable = [
        'leadsname',
        'company',
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
        'description',
        'leadstatus',
        'maplat',
        'maplong',
        'mapurl',
        'note',
        'active',
        'createbyid',
        'updatebyid'
    ];
    protected $table = "leads";
}
