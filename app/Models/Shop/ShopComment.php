<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_product_id',
        'product_id',
        'rating',
        'comment'
    ];
}
