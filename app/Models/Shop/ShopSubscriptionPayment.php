<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopSubscriptionPayment extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['next_billing_date', 'last_payment_date'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shop_subscription_id', 'pay_txn_id', 'next_billing_date', 'last_payment_date', 'last_payment_amount', 'failed_payment_count', 'status'
    ];


    /**
     * Get the subscription for the subscription payment.
     */
    public function subscription()
    {
        return $this->belongsTo('App\Models\Shop\ShopSubscription');
    }


    /**
     * Get the next billing date.
     *
     * @param  string  $value
     * @return string
     */
    public function getNextBillingDateAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d M Y g:i A');
    }

    /**
     * Get the next billing date.
     *
     * @param  string  $value
     * @return string
     */
    public function getLastPaymentDateAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d M Y g:i A');
    }

    /**
     * Get the next billing date.
     *
     * @param  string  $value
     * @return string
     */
    public function getLastPaymentAmountAttribute($value) {
        return config('constants.currency_sign').' '.number_format($value, 2);
    }

    /**
     * Get the created at.
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d M Y g:i A');
    }

    /**
     * Get the updated at.
     *
     * @param  string  $value
     * @return string
     */
    public function getUpdatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d M Y g:i A');
    }
}
