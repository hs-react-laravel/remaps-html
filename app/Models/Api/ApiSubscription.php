<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiSubscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'package_id', 'pay_agreement_id', 'description', 'start_date', 'status',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Api\ApiUser', 'user_id', 'id');
    }
    public function package()
    {
        return $this->belongsTo('App\Models\Api\ApiPackage', 'package_id', 'id');
    }
    public function subscriptionPayments()
    {
        return $this->hasMany('App\Models\Api\ApiSubscriptionPayment', 'subscription_id', 'id');
    }
    public function getNextBillingDateAttribute($value) {
        $spayment = $this->subscriptionPayments()->orderBy('id', 'DESC')->first();
        if($spayment){
            return \Carbon\Carbon::parse($spayment->next_billing_date)->format('d M Y g:i A');
        }

        return "";
    }
    public function getStartDateAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d M Y g:i A');
    }
    public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d M Y g:i A');
    }
    public function getUpdatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d M Y g:i A');
    }
}
