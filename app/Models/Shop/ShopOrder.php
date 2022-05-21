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
        'is_checked',
        'dispatch_date',
        'delivery_date',
        'tracking_number'
    ];

    public function items() {
        return $this->hasMany(ShopOrderProduct::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function shipPrice()
    {
        $sum = 0;
        foreach ($this->items as $item) {
            $obj = json_decode($item->shipping_detail);
            if ($obj) {
                $sum += $obj->price;
            }
        }
        return $sum;
    }
}
