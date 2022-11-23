<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopProductDigital extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'make',
        'model',
        'engine_code',
        'engine_displacement',
        'hp_stock',
        'ecu_make',
        'ecu_model',
        'software_version',
        'software_number',
        'hardware_version',
        'checksum',
        'tuning_tool',
        'document'
    ];
}
