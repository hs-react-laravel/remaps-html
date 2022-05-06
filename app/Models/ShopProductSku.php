<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopProductSku extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id', 'title', 'type'
    ];

    public function items() {
        return $this->hasMany(ShopProductSkuItem::class, 'product_sku_id', 'id');
    }
}
