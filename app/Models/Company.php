<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Helper;

class Company extends Model
{
    use SoftDeletes;
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
        'timezone',
        'is_first_shop',
        'is_open_shop',
        'is_tc',
        'tc_pdf',
        'is_invoice_pdf',
        'is_show_car_data',
        'secret_2fa_key'
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
    public function adminupdates()
    {
        return $this->belongsToMany(AdminUpdate::class, 'adminupdate_reads', 'company_id', 'adminupdate_id');
    }
    public function tickets()
    {
        $receiverIDs = $this->staffs->pluck('id')->toArray();
        array_push($receiverIDs, $this->owner->id);
        return Ticket::where('parent_chat_id', 0)->where(function($query) use($receiverIDs){
            return $query->whereIn('receiver_id', $receiverIDs)->orWhereIn('sender_id', $receiverIDs);
        });
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
        try {
            $timezone = Helper::companyTimeZone();
            $tz = Timezone::find($timezone ?? 1);
            return \Carbon\Carbon::parse($value)->tz($tz->name)->format('d M Y h:i A');
        } catch (\Exception $ex) {
            return \Carbon\Carbon::parse($value)->format('d M Y h:i A');
        }
    }
    public function getTotalCustomersAttribute($value) {
        if(!$this->users()){
            return 0;
        }else{
            return $this->users()->where('is_master', 0)->where('is_admin', 0)->count();
        }

    }
    public function getUpdatedAtAttribute($value) {
        try {
            $timezone = Helper::companyTimeZone();
            $tz = Timezone::find($timezone ?? 1);
            return \Carbon\Carbon::parse($value)->tz($tz->name)->format('d M Y h:i A');
        } catch (\Exception $ex) {
            return \Carbon\Carbon::parse($value)->format('d M Y h:i A');
        }
    }

    public function hasActiveShopSubscription($mode = 1){
        $subscription = $this->owner->shopSubscriptions()->whereHas('package', function($query) use($mode) {
            $query->where('mode', $mode);
        })->orderBy('id', 'DESC')->first();
        if($subscription) {
            if(strtolower($subscription->status) == strtolower('Active')) {
                return TRUE;
            } else if (strtolower($subscription->status) == strtolower('Suspended') || strtolower($subscription->status) == strtolower('Cancelled')) {
                $subscriptionPayment = $subscription->subscriptionPayments()->orderBy('id', 'DESC')->first();
                if(isset($subscriptionPayment) && isset($subscriptionPayment->next_billing_date)) {
                    if(!\Carbon\Carbon::parse($subscriptionPayment->next_billing_date)->isPast()) {
                        return FALSE;
                    }
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        }
        return FALSE;
    }

    public function getActiveShopSubscription($mode = 1) {
        $subscription = $this->owner->shopSubscriptions()
            ->whereHas('package', function($query) use($mode) {
                $query->where('mode', $mode);
            })
            ->where('status', "ACTIVE")
            ->orderBy('id', 'DESC')
            ->first();
        return $subscription;
    }
}
