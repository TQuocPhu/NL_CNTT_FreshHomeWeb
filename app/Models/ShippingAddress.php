<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'address',
        'city',
        'default'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
