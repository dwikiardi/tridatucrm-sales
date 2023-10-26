<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ipaddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'ip_address',
        'description',
        'leadid',
        'popid',
        'ip_type',
        'peruntukan',
        'createdbyid',
        'updatedbyid'
    ];
    protected $table = "ip_address";
}
