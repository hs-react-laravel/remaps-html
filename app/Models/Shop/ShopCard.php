<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopCard extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'number', 'exp', 'cvv'
    ];
}
