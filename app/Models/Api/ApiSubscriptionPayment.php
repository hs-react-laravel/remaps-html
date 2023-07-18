<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiSubscriptionPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['next_billing_date', 'last_payment_date'];

    protected $fillable = [
        'subscription_id', 'pay_txn_id', 'next_billing_date', 'last_payment_date', 'last_payment_amount', 'failed_payment_count', 'status'
    ];

    public function subscription()
    {
        return $this->belongsTo('App\Models\Api\ApiSubscription');
    }
    public function getNextBillingDateAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d M Y g:i A');
    }
    public function getLastPaymentDateAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d M Y g:i A');
    }
    public function getLastPaymentAmountAttribute($value) {
        return config('constants.currency_sign').' '.number_format($value, 2);
    }
    public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d M Y g:i A');
    }
    public function getUpdatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d M Y g:i A');
    }
}
