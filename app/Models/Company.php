<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;

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
        'v2_domain_link',
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
        'open_check',
        'style_background',
        'style_theme',
        'timezone'
    ];

    public function users()
    {
        return $this->hasMany('App\Models\User')->whereNull('is_staff');
    }
    public function staffs()
    {
        return $this->hasMany('App\Models\User')->where('is_staff', 1);
    }
    public function owner()
    {
        return $this->hasOne('App\Models\User')->where('is_admin', 1);
    }
    public function styling()
    {
        return $this->hasOne('App\Models\Styling');
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
    public function defaultTuningCreditGroup()
    {
        return $this->tuningCreditGroups->where('set_default_tier', 1);
    }
	public function tuningCreditGroupsSelected()
    {
        return $this->hasMany('App\Models\TuningCreditGroup');
    }
    public function getCreatedAtAttribute($value) {
        $timezone = Helper::companyTimeZone();
        $tz = Timezone::find($timezone ?? 1);
        return \Carbon\Carbon::parse($value)->tz($tz->name)->format('d M Y h:i A');
    }
    public function getTotalCustomersAttribute($value) {
        if(!$this->users()){
            return 0;
        }else{
            return $this->users()->where('is_master', 0)->where('is_admin', 0)->count();
        }

    }
    public function getUpdatedAtAttribute($value) {
        $timezone = Helper::companyTimeZone();
        $tz = Timezone::find($timezone ?? 1);
        return \Carbon\Carbon::parse($value)->tz($tz->name)->format('d M Y h:i A');
    }
}
