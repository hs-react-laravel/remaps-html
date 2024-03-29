<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Helper;

class FileService extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'tuning_type_id',
        'make',
        'model',
        'generation',
        'engine',
        'ecu',
        'engine_hp',
        'year',
        'gearbox',
        'fuel_type',
        'reading_tool',
        'license_plate',
        'vin',
        'orginal_file',
        'remain_orginal_file',
        'modified_file',
        'remain_modified_file',
        'note_to_engineer',
        'notes_by_engineer',
        'status',
        'displayable_id',
        'assign_id',
        'is_delay',
        'delay_time'
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User')->withTrashed();
    }
    public function tuningType()
    {
        return $this->belongsTo('App\Models\TuningType');
    }
    public function tuningTypeOptions()
    {
        return $this->belongsToMany('App\Models\TuningTypeOption');
    }
    public function tickets()
    {
        return $this->hasOne('App\Models\Ticket','file_servcie_id');
    }
    public function staff()
    {
        return $this->belongsTo(User::class, 'assign_id');
    }

    public function getStatusAttribute($value) {
        return config('constants.file_service_staus')[$value];
    }
    public function getCarAttribute($value) {
        return $this->make.' '.$this->model.' '.$this->generation;
    }
    public function getCreatedAtAttribute($value) {
        $timezone = $this->user->company->timezone;
        $tz = Timezone::find($timezone ?? 1);
        return \Carbon\Carbon::parse($value)->tz($tz->name)->format('d M Y h:i A');
    }
    public function getUpdatedAtAttribute($value) {
        $timezone = $this->user->company->timezone;
        $tz = Timezone::find($timezone ?? 1);
        return \Carbon\Carbon::parse($value)->tz($tz->name)->format('d M Y h:i A');
    }
}
