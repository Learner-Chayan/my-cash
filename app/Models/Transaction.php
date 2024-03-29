<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    use HasFactory;

    protected $table = "transactions";
    protected $fillable = [
        'user_id','model_id','model_type','transaction_type','asset_type','amount','trans_id','note', 'status', 'date'
    ];


    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function model():MorphTo
    {
        return $this->morphTo();
    }

    public function transactionPin():HasOne
    {
        return $this->hasOne(TransactionPin::class, 'trans_id', 'trans_id');
    }
}
