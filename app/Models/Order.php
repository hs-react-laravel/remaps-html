<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'transaction_id', 'invoice_id', 'vat_number', 'vat_percentage', 'tax_amount', 'amount', 'description', 'status', 'displayable_id'
    ];


    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }


    /**
     * Get the customer attribute.
     *
     * @param  string  $value
     * @return string
     */
    public function getCustomerAttribute() {
        return @$this->user->full_name;
    }

	/**
     * Get the customer company attribute.
     *
     * @param  string  $value
     * @return string
     */
    public function getCustomerCompanyAttribute() {
        return @$this->user->business_name;
    }

    /**
     * Get the amount with sign.
     *
     * @param  string  $value
     * @return string
     */
    public function getAmountWithSignAttribute() {
        return number_format($this->amount, 2);
    }

    /**
     * Get the created at.
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtAttribute($value) {
        $timezone = Helper::companyTimeZone();
        $tz = Timezone::find($timezone ?? 1);
        return \Carbon\Carbon::parse($value)->tz($tz->name)->format('d M Y h:i A');
    }

    /**
     * Get the updated at.
     *
     * @param  string  $value
     * @return string
     */
    public function getUpdatedAtAttribute($value) {
        $timezone = Helper::companyTimeZone();
        $tz = Timezone::find($timezone ?? 1);
        return \Carbon\Carbon::parse($value)->tz($tz->name)->format('d M Y h:i A');
    }

}
