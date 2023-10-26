<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferSerial extends Model
{
    use HasFactory;
    protected $fillable = [
        'transfer_id',
        'stockid',
        'stockcode',
        'serial',
    ];
    protected $table = "transfer_serial";
}
