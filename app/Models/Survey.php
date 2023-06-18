<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;
    protected $fillable = [
        'requestdate',
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
