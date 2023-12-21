<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'notrans',
        'date',
        'leadid',
        'staffid',
        'ipid',
        'pops',
        'packageid',
        'status',
        'note',
        'createdbyid',
        'updatedbyid',
    ];
    protected $table = "revocation";
}
