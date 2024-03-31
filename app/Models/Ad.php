<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ad extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = "ads";

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

    public function getImageAttribute(): string
    {
        if (!empty($this->getFirstMediaUrl('ads'))) {
            return asset($this->getFirstMediaUrl('ads'));
        }
        return asset('images/default/ads.png');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}




