<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    protected $fillable = [
        'transfer_id',
        'transfer_date',
        'from',
        'to',
        'transferdbyid',
        'recievedbyid',
        'qtytype',
        'note',
        'createdbyid',
        'updatedbyid',
    ];
    protected $table = "transfer";
}
