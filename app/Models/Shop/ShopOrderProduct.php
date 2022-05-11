<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopOrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'amount',
        'sku_detail',
    ];

    public function product() {
        return $this->hasOne(ShopProduct::class, 'id', 'product_id');
    }
}
