<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tuning_credit_group_id',
        'tuning_evc_credit_group_id',
        'company_id',
        'lang',
        'title',
        'first_name',
        'last_name',
        'business_name',
        'address_line_1',
        'address_line_2',
        'phone',
        'county',
        'town',
        'post_code',
        'email',
        'password',
        'tools',
        'state',
        'is_master',
        'is_admin',
        'is_staff',
        'is_active',
        'tuning_credits',
        'last_login',
        'more_info',
        'reseller_id',
        'private',
        'vat_number',
        'add_tax'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute() {
        return ucwords($this->first_name . ' ' . $this->last_name);
    }
    public function getFileServicesCountAttribute() {
        return $this->fileServices()->count();
    }
    public function getTuningPriceGroupAttribute() {
        return @$this->tuningCreditGroup->name;
    }
    public function getTuningEVCPriceGroupAttribute() {
        return @$this->tuningEVCCreditGroup->name;
    }
    public function getLastLoginDiffAttribute() {
        if(empty($this->last_login)){
            return 'Never';
        }
        return \Carbon\Carbon::parse($this->last_login)->diffForHumans();
    }
    public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d M Y g:i A');
    }
    public function getUpdatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d M Y g:i A');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
    public function tuningCreditGroup()
    {
        return $this->belongsTo('App\Models\TuningCreditGroup');
    }
    public function tuningEVCCreditGroup()
    {
        return $this->belongsTo('App\Models\TuningCreditGroup', 'tuning_evc_credit_group_id', 'id');
    }
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
    public function tickets()
    {
        return $this->hasMany('App\Models\Tickets', 'receiver_id');
    }
    public function fileServices()
    {
        return $this->hasMany('App\Models\FileService');
    }
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }
    public function subscriptions()
    {
        return $this->hasMany('App\Models\Subscription');
    }
}
