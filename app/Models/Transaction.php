<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $table = "transactions";
    protected $fillable = [
        'sender_id','receiver_id','transaction_type','asset_type','amount','trans_id','note', 'date'
    ];


    public function sender():BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function receiver(): BelongsTo 
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }
}
