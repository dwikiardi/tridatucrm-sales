<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    protected $fillable = [
        'meetingname',
        'location',
        'allday',
        'startdate',
        'starttime',
        'enddate',
        'endtime',
        'host',
        'leadid',
        'detail',
        'result',
        'reminder',
        'remindertime',
        'createdbyid',
        'updatedbyid'
    ];
    protected $table = "meetings";
}
