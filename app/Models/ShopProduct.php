<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'title', 'description', 'category_id', 'details', 'price', 'image', 'thumb', 'stock', 'live'
    ];
}
