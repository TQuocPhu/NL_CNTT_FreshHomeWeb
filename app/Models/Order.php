<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_price',
        'coupon_id',
        'coupon_code',
        'discount_amount',
        'final_price',
        'status',
        'shipping_address_id',
    ];

    public function coupon() {
        return $this->belongsTo(Coupon::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress(){
        return $this->belongsTo(ShippingAddress::class);
    }

    public function payment() {
        return $this->hasOne(Payment::class);
    }

    public function orderStatusHistory() {
        return $this->hasMany(OrderStatusHistory::class);
    }
}
