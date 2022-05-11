<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'tax',
        'ship_name',
        'ship_phone',
        'ship_address_1',
        'ship_address_2',
        'ship_town',
        'ship_state',
        'ship_country',
        'ship_zip',
        'ship_price',
        'payment_method',
        'status',
        'transaction',
        'is_checked'
    ];

    public function items() {
        return $this->hasMany(ShopOrderProduct::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
