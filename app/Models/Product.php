<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'description',
        'price',
        'stock',
        'status',
        'unit'
    ];

    //Thêm trường ảo để lấy dữ liệu hiển thị 
    protected $append = ['image_url', 'formatted_price'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function images() {
        return $this->hasMany(ProductImage::class);
    }

    public function cartItems() {
        return $this->hasMany(CartItem::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }

    
    //Lấy 1 ảnh đầu tiên của sản phẩm
    public function firstImage() {
        return $this->hasOne(ProductImage::class)->orderBy('id');
    }

    // lấy image_url
    public function getImageUrlAttribute() {
        return $this->firstImage?->image 
            ? asset('storage/' . $this->firstImage->image)
            : asset('storage/uploads/products/default-product-img.png');
    }

    // Format tiền
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', '.') . ' ' . 'đ';
    }
}
