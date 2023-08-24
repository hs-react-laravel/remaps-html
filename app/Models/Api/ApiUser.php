<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiUser extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'phone', 'company', 'domain', 'api_token', 'body', 'body_default'];

    public function getFullNameAttribute() {
        return ucwords($this->first_name . ' ' . $this->last_name);
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Models\Api\ApiSubscription', 'user_id', 'id');
    }

    public function hasActiveSubscription(){
        $subscription = $this->subscriptions()->orderBy('id', 'DESC')->first();
        if($subscription) {
            if(strtolower($subscription->status) == strtolower('Active')) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
        return FALSE;
    }

    public function getActiveSubscription() {
        $subscription = $this->subscriptions()
            ->where('status', "ACTIVE")
            ->orderBy('id', 'DESC')
            ->first();
        return $subscription;
    }
}
