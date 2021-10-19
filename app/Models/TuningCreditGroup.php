<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TuningCreditGroup extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'name', 'is_default', 'group_type', 'set_default_tier'
    ];


    /**
     * Get the tuning credit tire that owns the tuning credit group.
     */
    public function tuningCreditTires()
    {
        return $this->belongsToMany('App\Models\TuningCreditTire', 'tuning_credit_group_tuning_credit_tire', 'tuning_credit_group_id', 'tuning_credit_tire_id')->withPivot('from_credit', 'for_credit');
    }


	public function tuningCreditTiresWithPivot()
    {
        return $this->belongsToMany('App\Models\TuningCreditTire', 'tuning_credit_group_tuning_credit_tire', 'tuning_credit_group_id', 'tuning_credit_tire_id')->select(['id'])->withPivot('from_credit', 'for_credit');
    }



    /**
     * Get the company that owns tuning credit group.
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
