<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Shop\ShopCart;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

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
        'add_tax',
        'is_reserve_filename'
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
        return $this->hasMany('App\Models\Ticket', 'receiver_id');
    }
    public function getUnreadTicketsAttribute() {
        $user = $this;
        if ($this->is_admin) {
            return $this->company->owner->tickets()
                ->where('parent_chat_id', 0)
                ->whereNull('assign_id')
                ->where('is_read', 0)->count()
            + $this->company->owner->tickets()->whereHas('parent', function($query) use($user){
                $query->whereNull('assign_id');
            })->where('is_read', 0)->count();
        } else if ($this->is_staff) {
            return $this->company->owner->tickets()
                ->where('parent_chat_id', 0)
                ->where('assign_id', $user->id)
                ->where('is_read', 0)->count()
            + $this->company->owner->tickets()->whereHas('parent', function($query) use($user){
                $query->where('assign_id', $user->id);
            })->where('is_read', 0)->count();
        } else {
            return $this->tickets()->where('is_read', 0)->count();
        }
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
    public function notifies()
    {
        return $this->belongsToMany(Notification::class, 'notification_reads', 'user_id', 'notification_id');
    }
    public function notifyReads()
    {
        return $this->hasMany(NotificationRead::class);
    }
    public function cartProducts()
    {
        return $this->hasMany(ShopCart::class);
    }

    public function getFullNameAttribute() {
        return ucwords($this->first_name . ' ' . $this->last_name);
    }
    public function getFileServicesCountAttribute() {
        return $this->fileServices()->count();
    }
    public function getFileServicesAssignedCountAttribute() {
        return FileService::where('assign_id', $this->id)->count();
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
    public function getUserTuningCreditsAttribute($value) {
        return number_format($this->tuning_credits, 2);
    }
    // public function getLastLoginAttribute($value) {
    //     if(empty($value)){
    //         return 'Never';
    //     }
    //     return \Carbon\Carbon::parse($value)->diffForHumans();
    // }
    public function getSubscriptionEndedStringAttribute() {

        $string = "";
        $subscription = $this->subscriptions()->orderBy('id', 'DESC')->first();

        if ($subscription) {
            if($subscription->is_trial == 1){
                $trailStartDate = \Carbon\Carbon::parse($subscription->start_date);
                $updateDate = $trailStartDate->addDays($subscription->trial_days);
                if($updateDate->isToday()){
                    $string = "Your plan is expiring today.";
                }elseif($updateDate->isPast()){
                    $string = "Your plan has been expired. Please <a href='".url('admin/subscription/packages')."'><strong>click to subscribe</strong></a> any plan for uninterrupted services.";
                }else{
                    $string = "Your trial plan will end on ".$updateDate->format('Y-m-d').".";
                }
            } else {
                if($subscription->status == 'Suspended' || $subscription->status == 'Cancelled'){
                    if($subscription->is_immediate==1){
                        $string = "Your plan has been expired. Please <a href='".url('admin/subscription/packages')."'><strong>click to subscribe</strong></a> any plan for uninterrupted services.";
                    }else{
                        $subscriptionPayment = $subscription->subscriptionPayments()->orderBy('id', 'DESC')->first();
                        if(isset($subscriptionPayment) && isset($subscriptionPayment->next_billing_date)){
                            if(\Carbon\Carbon::parse($subscriptionPayment->next_billing_date)->isToday()){
                                $string = "Your plan is expiring today.";
                            }elseif(\Carbon\Carbon::parse($subscriptionPayment->next_billing_date)->isPast()){
                                $string = "Your plan has been expired. Please <a href='".url('admin/subscription/packages')."'><strong>click to subscribe</strong></a> any plan for uninterrupted services.";
                            }else{
                                $string = "Your plan will end on ".\Carbon\Carbon::parse($subscriptionPayment->next_billing_date)->format('Y-m-d').".";
                            }
                        }
                    }
                }
            }
        } else {
            if (!$this->is_master) {
                $string = "You haven't subscribe any plan. Please <a href='".url('admin/subscription/packages')."'><strong>click to subscribe</strong></a> any plan for uninterrupted services.";
            }
        }

        return $string;
    }

    public function hasActiveSubscription(){
        $subscription = $this->subscriptions()->orderBy('id', 'DESC')->first();
        if($subscription){

            if($subscription->is_trial == 1){
                $trailStartDate = \Carbon\Carbon::parse($subscription->start_date);
                if($trailStartDate->addDays($subscription->trial_days)->isPast()){
                    return FALSE;
                }
				else if(strtolower($subscription->status) == strtolower('Cancelled')) {
					return FALSE;
				}
                 else
                {
                     return TRUE;
                }
            }else{
                if(strtolower($subscription->status) == strtolower('Active')){
                    return TRUE;
                }else if(strtolower($subscription->status) == strtolower('Suspended') || strtolower($subscription->status) == strtolower('Cancelled')){
                    if($subscription->is_immediate==1){
                        return FALSE;
                    }else{
                        $subscriptionPayment = $subscription->subscriptionPayments()->orderBy('id', 'DESC')->first();
                        if(isset($subscriptionPayment) && isset($subscriptionPayment->next_billing_date)){
                            if(!\Carbon\Carbon::parse($subscriptionPayment->next_billing_date)->isPast()){
                                return FALSE;
                            }
                        }else{
                            return FALSE;
                        }
                    }
                }else{
                    return FALSE;
                }
            }
        }
        return FALSE;
    }
    public function getUserEvcTuningCreditsAttribute() {
        if ($this->reseller_id) {
            $url = "https://evc.de/services/api_resellercredits.asp";
            $dataArray = array(
                'apiid'=>'j34sbc93hb90',
                'username'=> $this->company->reseller_id,
                'password'=> $this->company->reseller_password,
                'verb'=>'getcustomeraccount',
                'customer' => $this->reseller_id
            );
            $ch = curl_init();
            $params = http_build_query($dataArray);
            $getUrl = $url."?".$params;
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_URL, $getUrl);
            curl_setopt($ch, CURLOPT_TIMEOUT, 500);

            $response = curl_exec($ch);
            if (strpos($response, 'ok') !== FALSE) {
                return str_replace('ok: ', '', $response);
            }
        }
        else {
            return '';
        }
    }
}
