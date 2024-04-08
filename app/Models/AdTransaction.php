<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'add_trans_id',
        'method',
        'date'
    ];
}
