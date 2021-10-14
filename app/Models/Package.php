<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pay_plan_id', 'name', 'billing_interval', 'amount', 'description', 'is_active'
    ];

    /**
     * Get the amount with currency sign.
     *
     * @param  string  $value
     * @return string
     */
    public function getAmountWithCurrentSignAttribute() {
        return config('constants.currency_sign').' '.number_format($this->amount, 2);
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
