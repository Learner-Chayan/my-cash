<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class HomeNotification extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title', 'description'
    ];

    public function getImageAttribute(): string
    {
        if (!empty($this->getFirstMediaUrl('home_notification'))) {
            return asset($this->getFirstMediaUrl('home_notification'));
        }
        return '';
    }
}
