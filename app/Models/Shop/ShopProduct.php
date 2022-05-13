<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id', 'title', 'description', 'category_id', 'brand', 'details', 'price', 'image', 'thumb', 'stock', 'live', 'rating'
    ];

    public function sku() {
        return $this->hasMany(ShopProductSku::class, 'product_id', 'id');
    }

    public function comments() {
        return $this->hasMany(ShopComment::class, 'product_id', 'id');
    }

    public function avgRating() {
        return $this->comments->avg('rating');
    }
}
