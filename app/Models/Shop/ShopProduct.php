<?php

namespace App\Models\Shop;

use App\Models\Shop\ShopProductDigital;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id', 'title', 'description', 'category_id', 'brand', 'details', 'price', 'image', 'thumb', 'stock', 'live', 'rating', 'digital_id'
    ];

    public function sku() {
        return $this->hasMany(ShopProductSku::class, 'product_id', 'id');
    }

    public function shipping() {
        return $this->hasMany(ShopShippingOption::class, 'product_id', 'id');
    }

    public function comments() {
        return $this->hasMany(ShopComment::class, 'product_id', 'id');
    }

    public function avgRating() {
        return $this->comments->avg('rating');
    }

    public function digital() {
        return $this->hasOne(ShopProductDigital::class, 'product_id', 'id');
    }
}
