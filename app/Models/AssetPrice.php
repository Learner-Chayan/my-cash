<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetPrice extends Model
{
    use HasFactory;
    protected $fillable = [
        'asset_type','price','highest_price','date'
    ];
}
