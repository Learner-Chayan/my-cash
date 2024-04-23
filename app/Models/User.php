<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class User extends Authenticatable implements HasMedia
{
    use InteractsWithMedia;
    use HasRoles;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'pay_id',
        'is_authenticated'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function getUserRoleAttribute()
    {
        return $this->roles->pluck('id', 'id')->first();
    }

    public function getUserRoleNameAttribute()
    {
        return $this->roles->pluck('name', 'name')->first();
    }

    public function getImageAttribute(): string
    {
        if (!empty($this->getFirstMediaUrl('profile'))) {
            return asset($this->getFirstMediaUrl('profile'));
        }
        return asset('images/default/profile.png');
    }

    public function getFrontSideAttribute(): string
    {
        if (!empty($this->getFirstMediaUrl('frontSide'))) {
            return asset($this->getFirstMediaUrl('frontSide'));
        }
        return null;
    }

    public function getBackSideAttribute(): string
    {
        if (!empty($this->getFirstMediaUrl('backSide'))) {
            return asset($this->getFirstMediaUrl('backSide'));
        }
        return null;
    }

    public function getSelfieAttribute(): string
    {
        if (!empty($this->getFirstMediaUrl('selfie'))) {
            return asset($this->getFirstMediaUrl('selfie'));
        }
        return null;
    }
    
}
