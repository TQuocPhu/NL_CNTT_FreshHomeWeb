<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    // use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_value',
        'usage_limit',
        'used_count',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];
    

    public function orders(){
        return $this->hasMany(Order::class);
    }




    public function isActive(): bool{
        return $this->is_active;
    }

    public function isExpired(): bool{
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isUsageLimitReached(): bool{
        return $this->usage_limit !== null
            && $this->used_count >= $this->usage_limit;
    }
}
