<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $theme
 * @property string|null $message
 * @property int|null $closed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminUpdate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminUpdate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminUpdate onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminUpdate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminUpdate whereClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminUpdate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminUpdate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminUpdate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminUpdate whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminUpdate whereTheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminUpdate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminUpdate withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminUpdate withoutTrashed()
 */
	class AdminUpdate extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $adminupdate_id
 * @property int|null $company_id
 * @property int|null $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminupdateRead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminupdateRead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminupdateRead onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminupdateRead query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminupdateRead whereAdminupdateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminupdateRead whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminupdateRead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminupdateRead whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminupdateRead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminupdateRead whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminupdateRead whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminupdateRead withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminupdateRead withoutTrashed()
 */
	class AdminupdateRead extends \Eloquent {}
}

namespace App\Models\Api{
/**
 * 
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $endpoint
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiLog whereEndpoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiLog whereUserId($value)
 */
	class ApiLog extends \Eloquent {}
}

namespace App\Models\Api{
/**
 * 
 *
 * @property int $id
 * @property string $pay_plan_id
 * @property string $name
 * @property string $billing_interval
 * @property float $amount
 * @property string|null $description
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiPackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiPackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiPackage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiPackage whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiPackage whereBillingInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiPackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiPackage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiPackage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiPackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiPackage whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiPackage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiPackage wherePayPlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiPackage whereUpdatedAt($value)
 */
	class ApiPackage extends \Eloquent {}
}

namespace App\Models\Api{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $package_id
 * @property string $pay_agreement_id
 * @property string|null $description
 * @property string|null $start_date
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $next_billing_date
 * @property-read \App\Models\Api\ApiPackage|null $package
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Api\ApiSubscriptionPayment> $subscriptionPayments
 * @property-read int|null $subscription_payments_count
 * @property-read \App\Models\Api\ApiUser|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscription onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscription query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscription whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscription whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscription wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscription wherePayAgreementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscription whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscription whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscription whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscription withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscription withoutTrashed()
 */
	class ApiSubscription extends \Eloquent {}
}

namespace App\Models\Api{
/**
 * 
 *
 * @property int $id
 * @property int $subscription_id
 * @property string|null $pay_txn_id
 * @property string|null $next_billing_date
 * @property string|null $last_payment_date
 * @property float|null $last_payment_amount
 * @property int $failed_payment_count
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Api\ApiSubscription|null $subscription
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscriptionPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscriptionPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscriptionPayment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscriptionPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscriptionPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscriptionPayment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscriptionPayment whereFailedPaymentCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscriptionPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscriptionPayment whereLastPaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscriptionPayment whereLastPaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscriptionPayment whereNextBillingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscriptionPayment wherePayTxnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscriptionPayment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscriptionPayment whereSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscriptionPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscriptionPayment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiSubscriptionPayment withoutTrashed()
 */
	class ApiSubscriptionPayment extends \Eloquent {}
}

namespace App\Models\Api{
/**
 * 
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string|null $password
 * @property string|null $phone
 * @property string|null $api_token
 * @property string|null $body
 * @property int|null $body_default
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $domain
 * @property string|null $company
 * @property-read mixed $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Api\ApiSubscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUser whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUser whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUser whereBodyDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUser whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUser whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUser whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUser whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUser wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUser whereUpdatedAt($value)
 */
	class ApiUser extends \Eloquent {}
}

namespace App\Models\Api{
/**
 * 
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string|null $password
 * @property string|null $phone
 * @property string|null $api_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $domain
 * @property string|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUserReg newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUserReg newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUserReg query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUserReg whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUserReg whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUserReg whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUserReg whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUserReg whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUserReg whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUserReg whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUserReg whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUserReg whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUserReg wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUserReg wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUserReg whereUpdatedAt($value)
 */
	class ApiUserReg extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $brand
 * @property string|null $model
 * @property string|null $year
 * @property string|null $engine_type
 * @property string|null $std_bhp
 * @property string|null $tuned_bhp
 * @property string|null $tuned_bhp_2
 * @property string|null $std_torque
 * @property string|null $tuned_torque
 * @property string|null $tuned_torque_2
 * @property string|null $title
 * @property string|null $deleted_at
 * @property-read mixed $logo
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereEngineType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereStdBhp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereStdTorque($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereTunedBhp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereTunedBhp2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereTunedTorque($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereTunedTorque2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Car whereYear($value)
 */
	class Car extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $target
 * @property int|null $to
 * @property string|null $message
 * @property int|null $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ChatMessage withoutTrashed()
 */
	class ChatMessage extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $country
 * @property string|null $state
 * @property string|null $town
 * @property string|null $address_line_1
 * @property string|null $address_line_2
 * @property string|null $post_code
 * @property string|null $logo
 * @property string|null $theme_color
 * @property string|null $copy_right_text
 * @property string|null $domain_link
 * @property string|null $main_email_address
 * @property string|null $support_email_address
 * @property string|null $billing_email_address
 * @property string|null $bank_account
 * @property string|null $bank_identification_code
 * @property string|null $vat_number
 * @property float|null $vat_percentage
 * @property string|null $customer_note
 * @property string|null $mail_driver
 * @property string|null $mail_host
 * @property int|null $mail_port
 * @property string|null $mail_encryption
 * @property string|null $mail_username
 * @property string|null $mail_password
 * @property string|null $paypal_mode
 * @property string|null $paypal_client_id
 * @property string|null $paypal_secret
 * @property string|null $paypal_currency_code
 * @property int|null $is_default
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $is_public '1'=>'Public','0'=>'Private'
 * @property float|null $rating
 * @property string|null $more_info
 * @property string|null $reseller_id
 * @property string|null $reseller_password
 * @property string|null $link_name
 * @property string|null $link_value
 * @property string|null $stripe_key
 * @property string|null $stripe_secret
 * @property string|null $mon_from
 * @property string|null $mon_to
 * @property string|null $tue_from
 * @property string|null $tue_to
 * @property string|null $wed_from
 * @property string|null $wed_to
 * @property string|null $thu_from
 * @property string|null $thu_to
 * @property string|null $fri_from
 * @property string|null $fri_to
 * @property string|null $sat_from
 * @property string|null $sat_to
 * @property string|null $sun_from
 * @property string|null $sun_to
 * @property int|null $notify_check
 * @property int|null $open_check
 * @property string|null $v2_domain_link
 * @property string|null $style_background
 * @property int|null $mon_close
 * @property int|null $tue_close
 * @property int|null $wed_close
 * @property int|null $thu_close
 * @property int|null $fri_close
 * @property int|null $sat_close
 * @property int|null $sun_close
 * @property int|null $timezone
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $is_first_shop
 * @property int|null $is_open_shop
 * @property int|null $is_tc
 * @property string|null $tc_pdf
 * @property int|null $is_invoice_pdf
 * @property int|null $is_show_car_data
 * @property string|null $secret_2fa_key
 * @property string|null $secret_2fa_verified
 * @property int|null $secret_2fa_enabled
 * @property string|null $secret_2fa_device
 * @property int|null $is_accept_new_customer
 * @property int|null $is_forum_enabled
 * @property int|null $forum_id
 * @property int|null $is_bank_enabled
 * @property string|null $bank_info
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AdminUpdate> $adminupdates
 * @property-read int|null $adminupdates_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmailFlag> $emailFlags
 * @property-read int|null $email_flags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmailTemplate> $emailTemplates
 * @property-read int|null $email_templates_count
 * @property-read mixed $total_customers
 * @property-read \App\Models\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $semiadmins
 * @property-read int|null $semiadmins_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $staffs
 * @property-read int|null $staffs_count
 * @property-read \App\Models\Styling|null $styling
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TuningCreditGroup> $tuningCreditGroups
 * @property-read int|null $tuning_credit_groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TuningCreditGroup> $tuningCreditGroupsSelected
 * @property-read int|null $tuning_credit_groups_selected_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TuningCreditTire> $tuningCreditTires
 * @property-read int|null $tuning_credit_tires_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TuningTypeGroup> $tuningTypeGroups
 * @property-read int|null $tuning_type_groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TuningType> $tuningTypes
 * @property-read int|null $tuning_types_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereAddressLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereBankAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereBankIdentificationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereBankInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereBillingEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCopyRightText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCustomerNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereDomainLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereForumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereFriClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereFriFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereFriTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsAcceptNewCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsBankEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsFirstShop($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsForumEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsInvoicePdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsOpenShop($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsShowCarData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsTc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereLinkName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereLinkValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereMailDriver($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereMailEncryption($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereMailHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereMailPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereMailPort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereMailUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereMainEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereMonClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereMonFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereMonTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereMoreInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereNotifyCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereOpenCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePaypalClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePaypalCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePaypalMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePaypalSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereResellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereResellerPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereSatClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereSatFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereSatTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereSecret2faDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereSecret2faEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereSecret2faKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereSecret2faVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereStripeKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereStripeSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereStyleBackground($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereSunClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereSunFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereSunTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereSupportEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTcPdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereThemeColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereThuClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereThuFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereThuTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTown($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTueClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTueFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTueTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereV2DomainLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereVatNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereVatPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereWedClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereWedFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereWedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company withoutTrashed()
 */
	class Company extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $key
 * @property string|null $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Content whereUpdatedAt($value)
 */
	class Content extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $rating
 * @property int $user_id
 * @property int $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerRating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerRating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerRating onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerRating query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerRating whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerRating whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerRating whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerRating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerRating whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerRating whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerRating whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerRating withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerRating withoutTrashed()
 */
	class CustomerRating extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $is_email_failed
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailFlag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailFlag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailFlag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailFlag query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailFlag whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailFlag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailFlag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailFlag whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailFlag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailFlag whereIsEmailFailed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailFlag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailFlag withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailFlag withoutTrashed()
 */
	class EmailFlag extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $company_id
 * @property string $label
 * @property string $subject
 * @property string $body
 * @property int $is_active 1->active, 0->inactive
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Company|null $company
 * @property-read string $email_type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailTemplate whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailTemplate whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailTemplate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailTemplate whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailTemplate whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailTemplate whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailTemplate whereUpdatedAt($value)
 */
	class EmailTemplate extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $tuning_type_id
 * @property string $make
 * @property string $model
 * @property string $generation
 * @property string $engine
 * @property string|null $ecu
 * @property string|null $fuel_type
 * @property string|null $reading_tool
 * @property string|null $engine_hp
 * @property string $year
 * @property string $gearbox
 * @property string|null $license_plate
 * @property string|null $vin
 * @property string|null $orginal_file
 * @property string|null $remain_orginal_file
 * @property string|null $modified_file
 * @property string|null $remain_modified_file
 * @property string|null $note_to_engineer
 * @property string|null $notes_by_engineer
 * @property string $status
 * @property int $displayable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $assign_id
 * @property int|null $is_delay
 * @property int|null $delay_time
 * @property-read mixed $car
 * @property-read \App\Models\User|null $staff
 * @property-read \App\Models\Ticket|null $tickets
 * @property-read \App\Models\TuningType $tuningType
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TuningTypeOption> $tuningTypeOptions
 * @property-read int|null $tuning_type_options_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereAssignId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereDelayTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereDisplayableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereEcu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereEngine($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereEngineHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereFuelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereGearbox($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereGeneration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereIsDelay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereLicensePlate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereMake($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereModifiedFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereNoteToEngineer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereNotesByEngineer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereOrginalFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereReadingTool($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereRemainModifiedFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereRemainOrginalFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereTuningTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereVin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService whereYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FileService withoutTrashed()
 */
	class FileService extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $message_id
 * @property string|null $title
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guide query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guide whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guide whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guide whereMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guide whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Guide whereUpdatedAt($value)
 */
	class Guide extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $subject
 * @property string|null $body
 * @property string|null $icon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification withoutTrashed()
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $notification_id
 * @property int|null $user_id
 * @property int|null $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationRead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationRead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationRead onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationRead query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationRead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationRead whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationRead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationRead whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationRead whereNotificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationRead whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationRead whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationRead withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationRead withoutTrashed()
 */
	class NotificationRead extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $transaction_id
 * @property string $invoice_id
 * @property string|null $vat_number
 * @property float|null $vat_percentage
 * @property float $tax_amount
 * @property float $amount
 * @property string|null $description
 * @property string $status
 * @property int $displayable_id
 * @property string $created_at
 * @property string $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $document
 * @property string|null $payment_gateway
 * @property-read string $amount_with_sign
 * @property-read string $customer
 * @property-read string $customer_company
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDisplayableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentGateway($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereVatNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereVatPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order withoutTrashed()
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $pay_plan_id
 * @property string $name
 * @property string $billing_interval
 * @property float $amount
 * @property string|null $description
 * @property int $is_active
 * @property string $created_at
 * @property string $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $amount_with_current_sign
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereBillingInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package wherePayPlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package withoutTrashed()
 */
	class Package extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * 
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $number
 * @property string|null $exp
 * @property string|null $cvv
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCard onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCard query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCard whereCvv($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCard whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCard whereExp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCard whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCard whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCard withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCard withoutTrashed()
 */
	class ShopCard extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * 
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $product_id
 * @property string|null $price
 * @property int|null $amount
 * @property string|null $sku_detail
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Shop\ShopProduct|null $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCart onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCart query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCart whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCart whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCart wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCart whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCart whereSkuDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCart whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCart withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCart withoutTrashed()
 */
	class ShopCart extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * 
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $parent_category
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCategory whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCategory whereParentCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopCategory whereUpdatedAt($value)
 */
	class ShopCategory extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * 
 *
 * @property int $id
 * @property int|null $order_product_id
 * @property int|null $product_id
 * @property int|null $rating
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopComment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopComment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopComment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopComment whereOrderProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopComment whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopComment whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopComment whereUpdatedAt($value)
 */
	class ShopComment extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * 
 *
 * @property int $id
 * @property int|null $user_id
 * @property float|null $amount
 * @property float|null $tax
 * @property string|null $ship_name
 * @property string|null $ship_phone
 * @property string|null $ship_address_1
 * @property string|null $ship_address_2
 * @property string|null $ship_town
 * @property string|null $ship_state
 * @property string|null $ship_country
 * @property string|null $ship_zip
 * @property float|null $ship_price
 * @property string|null $payment_method
 * @property int|null $status
 * @property string|null $transaction
 * @property int|null $is_checked
 * @property string|null $dispatch_date
 * @property string|null $delivery_date
 * @property string|null $tracking_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopOrderProduct> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereDispatchDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereIsChecked($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereShipAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereShipAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereShipCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereShipName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereShipPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereShipPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereShipState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereShipTown($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereShipZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereTrackingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereTransaction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrder whereUserId($value)
 */
	class ShopOrder extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * 
 *
 * @property int $id
 * @property int|null $order_id
 * @property int|null $product_id
 * @property float|null $price
 * @property int|null $amount
 * @property string|null $sku_detail
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $shipping_detail
 * @property-read \App\Models\Shop\ShopComment|null $comment
 * @property-read \App\Models\Shop\ShopProduct|null $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrderProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrderProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrderProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrderProduct whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrderProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrderProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrderProduct whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrderProduct wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrderProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrderProduct whereShippingDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrderProduct whereSkuDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopOrderProduct whereUpdatedAt($value)
 */
	class ShopOrderProduct extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * 
 *
 * @property int $id
 * @property string $pay_plan_id
 * @property string $name
 * @property string $billing_interval
 * @property float $amount
 * @property string|null $description
 * @property int|null $product_count
 * @property int $is_active
 * @property string $created_at
 * @property string $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $color
 * @property int|null $mode
 * @property-read string $amount_with_current_sign
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopPackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopPackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopPackage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopPackage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopPackage whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopPackage whereBillingInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopPackage whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopPackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopPackage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopPackage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopPackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopPackage whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopPackage whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopPackage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopPackage wherePayPlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopPackage whereProductCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopPackage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopPackage withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopPackage withoutTrashed()
 */
	class ShopPackage extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * 
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $title
 * @property string|null $description
 * @property int|null $category_id
 * @property string|null $brand
 * @property string|null $details
 * @property float|null $price
 * @property string|null $image
 * @property string|null $thumb
 * @property int|null $stock
 * @property int|null $live
 * @property int|null $rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $digital_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopComment> $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\Shop\ShopProductDigital|null $digital
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopShippingOption> $shipping
 * @property-read int|null $shipping_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopProductSku> $sku
 * @property-read int|null $sku_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct whereDigitalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct whereLive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProduct withoutTrashed()
 */
	class ShopProduct extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * 
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $make
 * @property string|null $model
 * @property string|null $engine_code
 * @property string|null $engine_displacement
 * @property string|null $hp_stock
 * @property string|null $software_version
 * @property string|null $software_number
 * @property string|null $hardware_version
 * @property string|null $checksum
 * @property string|null $tuning_tool
 * @property string|null $document
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital whereChecksum($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital whereDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital whereEngineCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital whereEngineDisplacement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital whereHardwareVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital whereHpStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital whereMake($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital whereSoftwareNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital whereSoftwareVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital whereTuningTool($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductDigital withoutTrashed()
 */
	class ShopProductDigital extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * 
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $title
 * @property string|null $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopProductSkuItem> $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSku newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSku newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSku onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSku query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSku whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSku whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSku whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSku whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSku whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSku whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSku whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSku withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSku withoutTrashed()
 */
	class ShopProductSku extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * 
 *
 * @property int $id
 * @property int|null $product_sku_id
 * @property string|null $title
 * @property string|null $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSkuItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSkuItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSkuItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSkuItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSkuItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSkuItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSkuItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSkuItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSkuItem whereProductSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSkuItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSkuItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSkuItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopProductSkuItem withoutTrashed()
 */
	class ShopProductSkuItem extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * 
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $option
 * @property string|null $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopShippingOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopShippingOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopShippingOption onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopShippingOption query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopShippingOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopShippingOption whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopShippingOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopShippingOption whereOption($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopShippingOption wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopShippingOption whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopShippingOption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopShippingOption withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopShippingOption withoutTrashed()
 */
	class ShopShippingOption extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $package_id
 * @property string $pay_agreement_id
 * @property string|null $description
 * @property string $start_date
 * @property string|null $status
 * @property string $created_at
 * @property string $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $next_billing_date
 * @property-read \App\Models\Shop\ShopPackage|null $package
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopSubscriptionPayment> $subscriptionPayments
 * @property-read int|null $subscription_payments_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscription onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscription query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscription whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscription whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscription wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscription wherePayAgreementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscription whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscription whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscription whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscription withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscription withoutTrashed()
 */
	class ShopSubscription extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * 
 *
 * @property int $id
 * @property int $shop_subscription_id
 * @property string|null $pay_txn_id
 * @property string $next_billing_date
 * @property string $last_payment_date
 * @property string $last_payment_amount
 * @property int $failed_payment_count
 * @property string|null $status
 * @property string $created_at
 * @property string $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Shop\ShopSubscription|null $subscription
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscriptionPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscriptionPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscriptionPayment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscriptionPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscriptionPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscriptionPayment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscriptionPayment whereFailedPaymentCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscriptionPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscriptionPayment whereLastPaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscriptionPayment whereLastPaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscriptionPayment whereNextBillingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscriptionPayment wherePayTxnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscriptionPayment whereShopSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscriptionPayment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscriptionPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscriptionPayment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ShopSubscriptionPayment withoutTrashed()
 */
	class ShopSubscriptionPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string|null $image
 * @property string|null $button_text
 * @property string|null $button_link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SliderManager newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SliderManager newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SliderManager query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SliderManager whereButtonLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SliderManager whereButtonText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SliderManager whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SliderManager whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SliderManager whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SliderManager whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SliderManager whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SliderManager whereUpdatedAt($value)
 */
	class SliderManager extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $company_id
 * @property string|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Styling newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Styling newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Styling query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Styling whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Styling whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Styling whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Styling whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Styling whereUpdatedAt($value)
 */
	class Styling extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $pay_agreement_id
 * @property string|null $description
 * @property string $start_date
 * @property int $trial_days
 * @property int $is_trial
 * @property int $is_immediate
 * @property string|null $status
 * @property string $created_at
 * @property string $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $next_billing_date
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SubscriptionPayment> $subscriptionPayments
 * @property-read int|null $subscription_payments_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereIsImmediate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereIsTrial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription wherePayAgreementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereTrialDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription withoutTrashed()
 */
	class Subscription extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $subscription_id
 * @property string|null $pay_txn_id
 * @property string $next_billing_date
 * @property string $last_payment_date
 * @property string $last_payment_amount
 * @property int $failed_payment_count
 * @property string|null $status
 * @property string $created_at
 * @property string $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Subscription $subscription
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment whereFailedPaymentCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment whereLastPaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment whereLastPaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment whereNextBillingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment wherePayTxnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment whereSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubscriptionPayment withoutTrashed()
 */
	class SubscriptionPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $parent_chat_id
 * @property int $sender_id
 * @property int $receiver_id
 * @property int|null $file_servcie_id
 * @property string|null $subject
 * @property string|null $message
 * @property string|null $document
 * @property string|null $remain_file
 * @property int $is_closed
 * @property int $is_read
 * @property string $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $assign_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Ticket> $childrens
 * @property-read int|null $childrens_count
 * @property-read \App\Models\FileService|null $fileService
 * @property-read string $car
 * @property-read mixed $client
 * @property-read mixed $company
 * @property-read mixed $file_service_name
 * @property-read mixed $last_message
 * @property-read Ticket|null $parent
 * @property-read \App\Models\User $receiver
 * @property-read \App\Models\User $sender
 * @property-read \App\Models\User|null $staff
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereAssignId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereFileServcieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereIsClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereParentChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereReceiverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereRemainFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket withoutTrashed()
 */
	class Ticket extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $offset
 * @property string $diff_from_gtm
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone whereDiffFromGtm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone whereOffset($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone whereUpdatedAt($value)
 */
	class Timezone extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property float $credits
 * @property string $type 'A'=>'Give','S'=>'Take'
 * @property string|null $description
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $credits_with_type
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction withoutTrashed()
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property int $set_default_tier
 * @property int $is_default 1->default, 0-> not default
 * @property string $created_at
 * @property string $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $group_type
 * @property int|null $is_system_default
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TuningCreditTire> $tuningCreditTires
 * @property-read int|null $tuning_credit_tires_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TuningCreditTire> $tuningCreditTiresWithPivot
 * @property-read int|null $tuning_credit_tires_with_pivot_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditGroup whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditGroup whereGroupType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditGroup whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditGroup whereIsSystemDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditGroup whereSetDefaultTier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditGroup withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditGroup withoutTrashed()
 */
	class TuningCreditGroup extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $company_id
 * @property int $amount
 * @property string|null $group_type
 * @property string $created_at
 * @property string $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TuningCreditGroup> $tuningCreditGroups
 * @property-read int|null $tuning_credit_groups_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditTire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditTire newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditTire onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditTire query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditTire whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditTire whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditTire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditTire whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditTire whereGroupType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditTire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditTire whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditTire withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningCreditTire withoutTrashed()
 */
	class TuningCreditTire extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $company_id
 * @property string $label
 * @property string $credits
 * @property int|null $order_as
 * @property string $created_at
 * @property string $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FileService> $fileServices
 * @property-read int|null $file_services_count
 * @property-read string $formated_credits
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TuningTypeOption> $tuningTypeOptions
 * @property-read int|null $tuning_type_options_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningType whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningType whereCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningType whereOrderAs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningType withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningType withoutTrashed()
 */
	class TuningType extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $company_id
 * @property string|null $name
 * @property int|null $is_default
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $is_system_default
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TuningTypeOption> $tuningTypeOptions
 * @property-read int|null $tuning_type_options_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TuningType> $tuningTypes
 * @property-read int|null $tuning_types_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeGroup whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeGroup whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeGroup whereIsSystemDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeGroup withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeGroup withoutTrashed()
 */
	class TuningTypeGroup extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $tuning_type_id
 * @property string $label
 * @property string|null $tooltip
 * @property string $credits
 * @property int|null $order_as
 * @property string $created_at
 * @property string $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FileService> $fileServices
 * @property-read int|null $file_services_count
 * @property-read \App\Models\TuningType $tuningType
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeOption onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeOption query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeOption whereCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeOption whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeOption whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeOption whereOrderAs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeOption whereTooltip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeOption whereTuningTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeOption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeOption withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TuningTypeOption withoutTrashed()
 */
	class TuningTypeOption extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $company_id
 * @property int|null $tuning_credit_group_id
 * @property string $lang
 * @property string $title
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string|null $phone
 * @property string|null $password
 * @property string $business_name
 * @property string $address_line_1
 * @property string|null $address_line_2
 * @property string $county
 * @property string $town
 * @property string|null $post_code
 * @property string|null $tools
 * @property float|null $tuning_credits
 * @property int $is_master 1->true,0->false
 * @property int $is_admin 1->admin,0->customer
 * @property int $is_active 1->active, 0->inactive
 * @property string|null $remember_token
 * @property string|null $last_login
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $more_info
 * @property string|null $reseller_id
 * @property int|null $tuning_evc_credit_group_id
 * @property int|null $private
 * @property string|null $vat_number
 * @property string|null $add_tax
 * @property int|null $is_staff
 * @property string|null $is_reserve_filename
 * @property int|null $is_semi_admin
 * @property string|null $logo
 * @property int|null $is_verified
 * @property int|null $is_blocked
 * @property int|null $tuning_type_group_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopCart> $cartProducts
 * @property-read int|null $cart_products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FileService> $fileServices
 * @property-read int|null $file_services_count
 * @property-read mixed $file_services_assigned_count
 * @property-read mixed $full_name
 * @property-read mixed $last_login_diff
 * @property-read mixed $subscription_ended_string
 * @property-read mixed $tuning_e_v_c_price_group
 * @property-read mixed $tuning_price_group
 * @property-read mixed $unread_chats
 * @property-read mixed $unread_tickets
 * @property-read mixed $user_evc_tuning_credits
 * @property-read mixed $user_tuning_credits
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notification> $notifies
 * @property-read int|null $notifies_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NotificationRead> $notifyReads
 * @property-read int|null $notify_reads_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopSubscription> $shopSubscriptions
 * @property-read int|null $shop_subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ticket> $tickets
 * @property-read int|null $tickets_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Models\TuningCreditGroup|null $tuningCreditGroup
 * @property-read \App\Models\TuningCreditGroup|null $tuningEVCCreditGroup
 * @property-read \App\Models\TuningTypeGroup|null $tuningTypeGroup
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TuningType> $tuningTypes
 * @property-read int|null $tuning_types_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddressLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBusinessName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsBlocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsMaster($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsReserveFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsSemiAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsStaff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereMoreInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereResellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTools($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTown($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTuningCreditGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTuningCredits($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTuningEvcCreditGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTuningTypeGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereVatNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

