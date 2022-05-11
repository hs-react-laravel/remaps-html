<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id', 'title', 'description', 'category_id', 'details', 'price', 'image', 'thumb', 'stock', 'live'
    ];

    public function sku() {
        return $this->hasMany(ShopProductSku::class, 'product_id', 'id');
    }
}
