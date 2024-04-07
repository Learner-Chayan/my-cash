<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ad extends Model  
{
    use HasFactory;

    protected $table = "ads";

    protected $fillable = [
        "user_id",
        "ads_unique_num",
        "ad_type",
        "asset_type",
        "unit_price_floor",
        "unit_price_ceil",
        "price_updated_at",
        "user_price",
        "price_type",
        "payable_with",
        "advertise_total_amount",
        "order_limit_min",
        "order_limit_max",
        "delete_status",
        "permission_status",
        "visibility_status",
        "date",
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}




