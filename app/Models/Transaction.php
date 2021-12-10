<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'credits', 'type', 'description', 'status'
    ];


    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the one credit.
     *
     * @param  string  $value
     * @return string
     */
    public function getCreditsWithTypeAttribute($value) {

        return ($this->type == 'S')?'-'.number_format($this->credits, 2):number_format($this->credits, 2);
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
