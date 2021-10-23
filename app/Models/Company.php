<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address_line_1',
        'address_line_2',
        'town',
        'post_code',
        'country',
        'state',
        'logo',
        'theme_color',
        'copy_right_text',
        'domain_link',
        'main_email_address',
        'support_email_address',
        'billing_email_address',
        'bank_account',
        'bank_identification_code',
        'vat_number',
        'vat_percentage',
        'customer_note',
        'mail_driver',
        'mail_host',
        'mail_port',
        'mail_encryption',
        'mail_username',
        'mail_password',
        'paypal_mode',
        'paypal_client_id',
        'paypal_secret',
        'paypal_currency_code',
        'mail_sent',
        'is_final_step_filled',
        'more_info',
        'reseller_id',
        'reseller_password',
        'link_name',
        'link_value',
        'stripe_key',
        'stripe_secret',
        'mon_from',
        'mon_to',
        'mon_close',
        'tue_from',
        'tue_to',
        'tue_close',
        'wed_from',
        'wed_to',
        'wed_close',
        'thu_from',
        'thu_to',
        'thu_close',
        'fri_from',
        'fri_to',
        'fri_close',
        'sat_from',
        'sat_to',
        'sat_close',
        'sun_from',
        'sun_to',
        'sun_close',
        'notify_check',
        'open_check'
    ];

    public function users()
    {
        return $this->hasMany('App\Models\User')->where('is_staff', 0);
    }
    public function staffs()
    {
        return $this->hasMany('App\Models\User')->where('is_staff', 1);
    }
    public function owner()
    {
        return $this->hasOne('App\Models\User')->where('is_admin', 1);
    }
    public function emailTemplates()
    {
        return $this->hasMany('App\Models\EmailTemplate');
    }
    public function tuningTypes()
    {
        return $this->hasMany('App\Models\TuningType');
    }
    public function tuningCreditTires()
    {
        return $this->hasMany('App\Models\TuningCreditTire');
    }
    public function tuningCreditGroups()
    {
        return $this->hasMany('App\Models\TuningCreditGroup');
    }
	public function tuningCreditGroupsSelected()
    {
        return $this->hasMany('App\Models\TuningCreditGroup');
    }
    public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d M Y g:i A');
    }
    public function getTotalCustomersAttribute($value) {
        if(!$this->users()){
            return 0;
        }else{
            return $this->users()->where('is_master', 0)->where('is_admin', 0)->count();
        }

    }
    public function getUpdatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d M Y g:i A');
    }
}
