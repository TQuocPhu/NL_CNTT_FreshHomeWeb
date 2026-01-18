<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'phone_number',
        'avatar',
        'address',
        'role_id',
        'activation_token',
        'google_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     * 
     * @var list<string>
     */

    protected $hidden =
    [
        'password',
        'remember_token'
    ];

    /**
     * Get the arrtibutes that should be cast.
     * 
     * @return array<string, string>
     */

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class);
    }


    // kiểm tra trạng thái tài khoản
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isBanned()
    {
        return $this->status === 'banned';
    }

    public function isDeleted()
    {
        return $this->status === 'deleted';
    }


    // public function getAvatarUrlAttribute()
    // {
    //     if (!$this->avatar) {
    //         return asset('images/default-avatar.png'); 
    //     }

    //     if (Str::startsWith($this->avatar, ['http://', 'https://'])) {
    //         return $this->avatar;
    //     }

    //     return asset('storage/' . $this->avatar); 
    // }
}
