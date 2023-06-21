<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surveys extends Model
{
    use HasFactory;
    protected $fillable = [
        'requestdate',
        'leadid',
        'surveyorid',
        'surveyorto',
        'rmaplat',
        'rmaplong',
        'surveydate',
        'surveyresult',
        'note',
        'status',
        'createdbyid',
        'updatedbyid',
    ];
    protected $table = "surveys";
}
