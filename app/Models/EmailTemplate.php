<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Helper;

class EmailTemplate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'label', 'subject', 'body', 'is_active'
    ];

    /**
     * Get the company that owns email template.
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    /**
     * Get the created at.
     *
     * @param  string  $value
     * @return string
     */
    public function getEmailTypeAttribute($value) {
        return config('constants.emails')[$this->label];
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
