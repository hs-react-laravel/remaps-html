<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\CarBrowserController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Remaps\CustomerController;
use App\Http\Controllers\Remaps\FileServiceController;
use App\Http\Controllers\Remaps\TicketController;
use App\Http\Controllers\Remaps\OrderController;
use App\Http\Controllers\Remaps\TransactionController;
use App\Http\Controllers\Remaps\EmailTemplateController;
use App\Http\Controllers\Remaps\CompanyController;
use App\Http\Controllers\Remaps\CompanySettingController;
use App\Http\Controllers\Remaps\PackageController;
use App\Http\Controllers\Remaps\TuningCreditController;
use App\Http\Controllers\Remaps\TuningTypeController;
use App\Http\Controllers\Remaps\TuningTypeOptionController;
use App\Http\Controllers\Remaps\StaffController;
use App\Http\Controllers\Remaps\SubscriptionController;
use App\Http\Controllers\Consumer\BuyTuningCreditsController;
use App\Http\Controllers\Consumer\FileServiceController as FSController;
use App\Http\Controllers\Consumer\TicketController as TKController;
use App\Http\Controllers\Consumer\OrderController as ODController;
use App\Http\Controllers\Consumer\TransactionController as TRController;
use App\Http\Controllers\Frontend\CompanyController as FrontendCompanyController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Remaps\SliderManagerController;
use App\Http\Controllers\Remaps\TuningEVCCreditController;
use App\Http\Controllers\PaypalWebhookController;
use App\Http\Controllers\Staff\FileServiceController as StaffFileServiceController;
use App\Http\Controllers\Staff\TicketController as StaffTicketController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Remaps
Route::post('paypal/webhooks', [PaypalWebhookController::class, 'index']);
Route::group(['domain' => 'frontend.pbxphonesystems.co.uk'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
	Route::get('register-as-a-remapping-file-supplier', [HomeController::class, 'innerhome'])->name('innerhome');
	Route::get('compare-prices', [FrontendCompanyController::class, 'companies'])->name('companies');
	Route::get('/register-account', [FrontendCompanyController::class, 'create'])->name('register-account.create');
	Route::get('thankyou', [FrontendCompanyController::class, 'thankyou'])->name('thankyou');

	// route for post request
	Route::post('paypal', [FrontendCompanyController::class, 'postPaymentWithpaypal'])->name('pay.with.paypal.main');
	// route for check status responce
	Route::get('paypal', [FrontendCompanyController::class, 'getPaymentStatus'])->name('paypal.payment.status.main');

	Route::get('paypal/subscribe/execute', [FrontendCompanyController::class, 'executeSubscription'])->name('paypal.execute.subscription');
	Route::get('paypal/subscribe/{package}', [FrontendCompanyController::class, 'subscribeSubscription'])->name('paypal.subscribe.subscription');
});

Auth::routes();

Route::get('/admin', function () {
    return redirect(url('admin/login'));
});
Route::get('/', function () {
    return redirect(route('login'));
});
Route::get('/customer', function () {
    return redirect(url('customer/dashboard'));
});
Route::group(['middleware' => 'web', 'prefix'=>'admin'], function(){
	Route::get('login', '\App\Http\Controllers\Auth\Admin\LoginController@showLoginForm')->name('admin.auth.show.login');
	Route::post('login', '\App\Http\Controllers\Auth\Admin\LoginController@login')->name('admin.auth.login');
	Route::post('logout', '\App\Http\Controllers\Auth\Admin\LoginController@logout')->name('admin.auth.logout');
	Route::get('password/reset', '\App\Http\Controllers\Auth\Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.auth.show.password.reset');
	Route::post('password/reset', '\App\Http\Controllers\Auth\Admin\ResetPasswordController@reset')->name('admin.auth.password.reset');
	Route::get('password/reset/{token}', '\App\Http\Controllers\Auth\Admin\ResetPasswordController@showResetForm')->name('admin.auth.password.reset.form');
	Route::post('password/email', '\App\Http\Controllers\Auth\Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.auth.password.email');
	Route::get('{id}/switch-account','\App\Http\Controllers\Auth\Admin\LoginController@switchAsCompany')->name('admin.auth.switch-account');
    Route::get('{id}/redirect-from-master','\App\Http\Controllers\Auth\Admin\LoginController@redirectFromMaster')->name('admin.auth.redirect-from-master');
});
Route::group(['prefix'=>'admin', 'middleware' => 'check.company'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboardAdmin'])->name('dashboard.admin');
    Route::resource('fileservices', FileServiceController::class);
    Route::get('fileservices/{id}/download-original', [FileServiceController::class, 'download_original'])->name('fileservice.download.original');
    Route::get('fileservices/{id}/download-modified', [FileServiceController::class, 'download_modified'])->name('fileservice.download.modified');
    Route::get('fileservices/{id}/delete-modified', [FileServiceController::class, 'delete_modified_file'])->name('fileservice.delete.modified');
    Route::get('fileservices/{id}/create-ticket', [FileServiceController::class, 'create_ticket'])->name('fileservice.tickets.create');
    Route::post('fileservices/{id}/store-ticket', [FileServiceController::class, 'store_ticket'])->name('fileservice.tickets.store');

    Route::resource('tickets', TicketController::class);
    Route::get('tickets/{id}/download-document', [TicketController::class, 'download_document'])->name('tickets.download');

    Route::resource('transactions', TransactionController::class);
    Route::resource('email-templates', EmailTemplateController::class);

    Route::resource('companies', CompanyController::class);
    Route::get('companies/{id}/activate', [CompanyController::class, 'activate'])->name('companies.activate');
    Route::get('companies/{id}/public', [CompanyController::class, 'public'])->name('companies.public');
    Route::get('companies/{id}/switch', [CompanyController::class, 'switchAsCompany'])->name('companies.switch');
    Route::get('companies/{id}/trial', [CompanyController::class, 'trial'])->name('companies.trial');
    Route::post('companies/{id}/trial', [CompanyController::class, 'trial_post'])->name('companies.trial.post');
    Route::get('companies/{id}/reset-password-link', [CompanyController::class, 'resendPasswordResetLink'])->name('companies.reset-password');
    Route::resource('packages', PackageController::class);
    Route::resource('slidermanagers', SliderManagerController::class);

    Route::get('company-settings', [CompanySettingController::class, 'company_setting'])->name('company.setting');
    Route::post('company-settings-update', [CompanySettingController::class, 'store'])->name('company.setting.store');

    Route::resource('orders', OrderController::class);
    Route::get('orders/{id}/invoice', [OrderController::class, 'invoice'])->name('order.invoice');

    Route::resource('customers', CustomerController::class);
    Route::get('customers/{id}/file-services',[CustomerController::class, 'fileServices'])->name('customer.fs');
    Route::get('customers/{id}/transactions',[CustomerController::class, 'transactions'])->name('customer.tr');
    Route::post('customers/{id}/transactions',[CustomerController::class, 'transactions_post'])->name('customer.tr.post');
    Route::post('customers/{id}/transactions/evc',[CustomerController::class, 'transactions_post_evc'])->name('customer.tr.evc.post');
    Route::get('customers/{id}/switch-account',[CustomerController::class, 'switchAccount'])->name('customer.sa');

    Route::resource('tuning-credits', TuningCreditController::class);
    Route::get('tuning-credits/{id}/default', [TuningCreditController::class, 'set_default'])->name('tuning-credits.default');
    Route::delete('tuning-tires/{id}/delete', [TuningCreditController::class, 'delete_tire'])->name('tuning-tires.destroy');
    Route::get('tuning-tires/create', [TuningCreditController::class, 'add_tire'])->name('tuning-tires.create');
    Route::post('tuning-tires/store', [TuningCreditController::class, 'store_tire'])->name('tuning-tires.store');

    Route::resource('evc-tuning-credits', TuningEVCCreditController::class);
    Route::get('evc-tuning-credits/{id}/default', [TuningEVCCreditController::class, 'set_default'])->name('evc-tuning-credits.default');
    Route::delete('evc-tuning-tires/{id}/delete', [TuningEVCCreditController::class, 'delete_tire'])->name('evc-tuning-tires.destroy');
    Route::get('evc-tuning-tires/create', [TuningEVCCreditController::class, 'add_tire'])->name('evc-tuning-tires.create');
    Route::post('evc-tuning-tires/store', [TuningEVCCreditController::class, 'store_tire'])->name('evc-tuning-tires.store');

    Route::resource('tuning-types', TuningTypeController::class);
    Route::get('tuning-types/{id}/up-sort', [TuningTypeController::class, 'upSort'])->name('tuning-types.sort-up');
    Route::get('tuning-types/{id}/down-sort', [TuningTypeController::class, 'downSort'])->name('tuning-types.sort-down');

    Route::resource('tuning-types/{id}/options', TuningTypeOptionController::class);
    Route::get('tuning-types/{id}/options/{option}/up-sort', [TuningTypeOptionController::class, 'upSort'])->name('options.sort.up');
    Route::get('tuning-types/{id}/options/{option}/down-sort', [TuningTypeOptionController::class, 'downSort'])->name('options.sort.down');

    Route::resource('subscriptions', SubscriptionController::class);
    Route::get('subscriptions/{id}/payments', [SubscriptionController::class, 'payments'])->name('subscriptions.payments');
    Route::get('subscriptions/{id}/invoice', [SubscriptionController::class, 'invoice'])->name('subscriptions.invoice');
    Route::get('package/choose', [SubscriptionController::class, 'choose'])->name('packages.choose');
    Route::get('package/{id}/subscribe', [SubscriptionController::class, 'subscribeSubscription'])->name('subscribe.paypal');
    Route::get('package/execute', [SubscriptionController::class, 'executeSubscription'])->name('paypal.subscription.execute');
    Route::get('subscriptions/{id}/cancel', [SubscriptionController::class, 'cancelSubscription'])->name('subscriptions.cancel');
    Route::get('subscriptions/{id}/suspend', [SubscriptionController::class, 'immediateCancelSubscription'])->name('subscriptions.suspend');

    Route::resource('staffs', StaffController::class);

    Route::get('/cars', [CarBrowserController::class, 'index'])->name('admin.cars.index');
    Route::post('/cars/category', [CarBrowserController::class, 'category'])->name('admin.cars.category');
    Route::get('/cars/category', [CarBrowserController::class, 'category'])->name('admin.cars.category');

    Route::get('/profile', [DashboardController::class, 'profile'])->name('admin.dashboard.profile');
    Route::post('/profile_post', [DashboardController::class, 'profile_post'])->name('admin.dashboard.profile.post');
    Route::post('/profile_staff_post', [DashboardController::class, 'profile_staff_post'])->name('admin.dashboard.profile.staff.post');

    Route::get('/edit-password', [DashboardController::class, 'edit_password'])->name('admin.password.edit');
    Route::post('/edit-password', [DashboardController::class, 'edit_password_post'])->name('admin.password.edit.post');
});
Route::group(['prefix'=>'staff', 'middleware' => 'check.staff'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboardStaff'])->name('dashboard.staff');
    Route::resource('stafffs', StaffFileServiceController::class);
    Route::get('stafffs/{id}/download-original', [StaffFileServiceController::class, 'download_original'])->name('stafffs.download.original');
    Route::get('stafffs/{id}/download-modified', [StaffFileServiceController::class, 'download_modified'])->name('stafffs.download.modified');
    Route::get('stafffs/{id}/delete-modified', [StaffFileServiceController::class, 'delete_modified_file'])->name('stafffs.delete.modified');
    Route::get('stafffs/{id}/create-ticket', [StaffFileServiceController::class, 'create_ticket'])->name('stafffs.tickets.create');
    Route::post('stafffs/{id}/store-ticket', [StaffFileServiceController::class, 'store_ticket'])->name('stafffs.tickets.store');

    Route::resource('stafftk', StaffTicketController::class);
    Route::get('stafftk/{id}/download-document', [StaffTicketController::class, 'download_document'])->name('stafftk.download');
});
Route::group(['middleware' => 'auth:customer', 'prefix'=>'customer'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboardCustomer'])->name('dashboard.customer');
    Route::resource('fs', FSController::class);
    Route::get('/fs/{id}/download-original', [FSController::class, 'download_original'])->name('fs.download.original');
    Route::get('/fs/{id}/download-modified', [FSController::class, 'download_modified'])->name('fs.download.modified');
    Route::get('/fs/{id}/delete-modified', [FSController::class, 'delete_modified_file'])->name('fs.delete.modified');
    Route::get('/fs/{id}/create-ticket', [FSController::class, 'create_ticket'])->name('fs.tickets.create');
    Route::post('/fs/{id}/store-ticket', [FSController::class, 'store_ticket'])->name('fs.tickets.store');

    Route::resource('tk', TKController::class);
    Route::get('/tk/{id}/download-document', [TKController::class, 'download_document'])->name('tk.download');

    Route::resource('od', ODController::class);
    Route::resource('tr', TRController::class);
    Route::get('/buy-credits', [BuyTuningCreditsController::class, 'index'])->name('consumer.buy-credits');
    Route::post('/buy-credits/handle', [BuyTuningCreditsController::class, 'handlePayment'])->name('consumer.buy-credits.handle');
    Route::get('/buy-credits/cancel', [BuyTuningCreditsController::class, 'paymentCancel'])->name('consumer.buy-credits.cancel');
    Route::get('/buy-credits/success', [BuyTuningCreditsController::class, 'paymentSuccess'])->name('consumer.buy-credits.success');
    Route::post('/buy-credits/stripe-post', [BuyTuningCreditsController::class, 'stripePost'])->name('consumer.buy-credits.stripe-post');
    // Main Page Route
    // Route::get('/', [DashboardController::class, 'dashboardEcommerce'])->name('dashboard');
    Route::post('/customer-rate', [DashboardController::class, 'addRating'])->name('dashboard.rate');
    Route::post('/set-reseller', [DashboardController::class, 'setReseller'])->name('dashboard.reseller');

    Route::get('/cars', [CarBrowserController::class, 'index'])->name('cars.index');
    Route::post('/cars/category', [CarBrowserController::class, 'category'])->name('cars.category');
    Route::get('/cars/category', [CarBrowserController::class, 'category'])->name('cars.category');

    Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::post('/profile_post', [DashboardController::class, 'profile_post'])->name('dashboard.profile.post');

    Route::get('/edit-password', [DashboardController::class, 'edit_password'])->name('password.edit');
    Route::post('/edit-password', [DashboardController::class, 'edit_password_post'])->name('password.edit.post');
});

Route::get('lang/{locale}', [LanguageController::class, 'swap']);
