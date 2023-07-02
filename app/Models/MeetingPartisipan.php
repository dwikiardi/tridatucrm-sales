<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingPartisipan extends Model
{
    use HasFactory;
    protected $fillable = [
        'meetingid', 'name', 'email', 'createdbyid', 'updatedbyid'
    ];
    protected $table = "meeting_partisipans";
}
