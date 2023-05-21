<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountLogs extends Model
{
    use HasFactory;
    protected $fillable = [
        'created_at','module','moduleid','userid','subject','prevdata','newdata'
    ];
    protected $table = "accountlogs";
}
