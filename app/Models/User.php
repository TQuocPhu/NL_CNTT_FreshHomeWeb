<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
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


    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function shippingAddresses() {
        return $this->hasMany(ShippingAddress::class);
    }



    public function isPending() {
        return $this->status === 'pending';
    }

    public function isActive() {
        return $this->status === 'active';
    }

    public function isBanned() {
        return $this->status === 'banned';
    }

    public function isDeleted() {
        return $this->status === 'deleted';
    }
}
