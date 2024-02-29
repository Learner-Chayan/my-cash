<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionPin extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_id','pin','expiration_time','attemps'
    ];
}
