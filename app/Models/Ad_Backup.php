<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad_Backup extends Model
{
    use HasFactory;

    protected $table = 'ad_backups';
    protected $fillable = [
        "user_id",
        "ads_unique_num",
        "ad_type",
        "asset_type",
        "unit_price",
        "highest_price",
        "sell_price",
        "price_type",
        "total_amount",
        "order_limit_min",
        "order_limit_max",
        "delete_status",
        "permission_status",
        "visibility_status",
        "date",
    ];
}
