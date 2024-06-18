<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuningTypeGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'name', 'is_default', 'group_type', 'set_default_tier'
    ];

    public function tuningTypes()
    {
        return $this->belongsToMany('App\Models\TuningType', 'tuning_type_group_tuning_type', 'tuning_type_group_id', 'tuning_type_id')->withPivot('for_credit');
    }

    public function tuningTypeOptions()
    {
        return $this->belongsToMany('App\Models\TuningTypeOption', 'tuning_type_group_tuning_option', 'tuning_type_group_id', 'tuning_type_option_id')->withPivot('for_credit');
    }

    public function getOneType($id)
    {
        return $this->tuningTypes()->where('id', $id)->first();
    }

    public function getOneOption($id)
    {
        return $this->tuningTypeOptions()->where('id', $id)->first();
    }
}
