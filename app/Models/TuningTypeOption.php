<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TuningTypeOption extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tuning_type_id', 'label', 'tooltip', 'credits', 'order_as'
    ];

    /**
     * Get the tuning type that owns the option.
     */
    public function tuningType()
    {
        return $this->belongsTo('App\Models\TuningType');
    }

    /**
     * The file servicess that belong to the tuning type option.
     */
    public function fileServices()
    {
        return $this->belongsToMany('App\Models\FileService');
    }

    /**
     * Get the credits.
     *
     * @param  string  $value
     * @return string
     */
    public function getCreditsAttribute($value) {
        return number_format($value, 2);
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
