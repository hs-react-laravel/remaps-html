<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopProductSkuItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_sku_id', 'title', 'price'
    ];
}
