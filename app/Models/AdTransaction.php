<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdTransaction extends Model
{
    use HasFactory;

    protected $table = "ad_transactions";
    protected $fillable = [
        'ad_id',
        'sell_by',
        'purchase_by',
        'payable_amount',
        'payable_asset_type',
        'receivable_asset_type',
        'receivable_amount',
        'ad_trans_id',
        'method',
        'date'
    ];

    public function ad():BelongsTo 
    {
        return $this->belongsTo(Ad::class);
    }

    public function seller():BelongsTo
    {
        return $this->belongsTo(User::class, 'sell_by');
    }

    public function buyer(): BelongsTo 
    {
        return $this->belongsTo(User::class, 'purchase_by');
    }
}
