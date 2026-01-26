<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
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

    protected $appends = [
        'formatted_total_price',
        'formatted_discount_amount',
        'formatted_final_price',
    ];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function orderStatusHistory()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }


    // Tổng tiền trước giảm
    public function getFormattedTotalPriceAttribute()
    {
        return number_format($this->total_price, 0, ',', '.');
    }

    // Tiền giảm
    public function getFormattedDiscountAmountAttribute()
    {
        return number_format($this->discount_amount ?? 0, 0, ',', '.');
    }

    // Tổng tiền phải trả
    public function getFormattedFinalPriceAttribute()
    {
        return number_format($this->final_price, 0, ',', '.');
    }
}
