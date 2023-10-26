<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pops extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'createdbyid',
        'updatedbyid'
    ];
    protected $table = "pops";
}
