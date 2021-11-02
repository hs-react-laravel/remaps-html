<?php

use App\Http\Controllers\CarBrowserController;
use Illuminate\Support\Facades\Route;
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
use App\Http\Controllers\Remaps\SliderManagerController;
use App\Http\Controllers\Remaps\TuningEVCCreditController;

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
Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::resource('company/fileservices', FileServiceController::class);
    Route::get('/company/fileservices/{id}/download-original', [FileServiceController::class, 'download_original'])->name('fileservice.download.original');
    Route::get('/company/fileservices/{id}/download-modified', [FileServiceController::class, 'download_modified'])->name('fileservice.download.modified');
    Route::get('/company/fileservices/{id}/delete-modified', [FileServiceController::class, 'delete_modified_file'])->name('fileservice.delete.modified');
    Route::get('/company/fileservices/{id}/create-ticket', [FileServiceController::class, 'create_ticket'])->name('fileservice.tickets.create');
    Route::post('/company/fileservices/{id}/store-ticket', [FileServiceController::class, 'store_ticket'])->name('fileservice.tickets.store');

    Route::resource('company/tickets', TicketController::class);
    Route::get('/company/tickets/{id}/download-document', [TicketController::class, 'download_document'])->name('tickets.download');

    Route::resource('company/transactions', TransactionController::class);
    Route::resource('company/email-templates', EmailTemplateController::class);

    Route::resource('admin/companies', CompanyController::class);
    Route::get('admin/companies/{id}/activate', [CompanyController::class, 'activate'])->name('companies.activate');
    Route::get('admin/companies/{id}/public', [CompanyController::class, 'public'])->name('companies.public');
    Route::get('admin/companies/{id}/switch', [CompanyController::class, 'switchAsCompany'])->name('companies.switch');
    Route::get('admin/companies/{id}/trial', [CompanyController::class, 'trial'])->name('companies.trial');
    Route::post('admin/companies/{id}/trial', [CompanyController::class, 'trial_post'])->name('companies.trial.post');
    Route::get('admin/companies/{id}/reset-password-link', [CompanyController::class, 'resendPasswordResetLink'])->name('companies.reset-password');
    Route::resource('admin/packages', PackageController::class);
    Route::resource('admin/slidermanagers', SliderManagerController::class);

    Route::get('company/company-settings', [CompanySettingController::class, 'company_setting'])->name('company.setting');
    Route::post('company/company-settings-update', [CompanySettingController::class, 'store'])->name('company.setting.store');

    Route::resource('company/orders', OrderController::class);
    Route::get('company/orders/{id}/invoice', [OrderController::class, 'invoice'])->name('order.invoice');

    Route::resource('company/customers', CustomerController::class);
    Route::get('company/customers/{id}/file-services',[CustomerController::class, 'fileServices'])->name('customer.fs');
    Route::get('company/customers/{id}/transactions',[CustomerController::class, 'transactions'])->name('customer.tr');
    Route::post('company/customers/{id}/transactions',[CustomerController::class, 'transactions_post'])->name('customer.tr.post');
    Route::post('company/customers/{id}/transactions/evc',[CustomerController::class, 'transactions_post_evc'])->name('customer.tr.evc.post');
    Route::get('company/customers/{id}/switch-account',[CustomerController::class, 'switchAccount'])->name('customer.sa');

    Route::resource('company/tuning-credits', TuningCreditController::class);
    Route::get('company/tuning-credits/{id}/default', [TuningCreditController::class, 'set_default'])->name('tuning-credits.default');
    Route::delete('company/tuning-tires/{id}/delete', [TuningCreditController::class, 'delete_tire'])->name('tuning-tires.destroy');
    Route::get('company/tuning-tires/create', [TuningCreditController::class, 'add_tire'])->name('tuning-tires.create');
    Route::post('company/tuning-tires/store', [TuningCreditController::class, 'store_tire'])->name('tuning-tires.store');

    Route::resource('company/evc-tuning-credits', TuningEVCCreditController::class);
    Route::get('company/evc-tuning-credits/{id}/default', [TuningEVCCreditController::class, 'set_default'])->name('evc-tuning-credits.default');
    Route::delete('company/evc-tuning-tires/{id}/delete', [TuningEVCCreditController::class, 'delete_tire'])->name('evc-tuning-tires.destroy');
    Route::get('company/evc-tuning-tires/create', [TuningEVCCreditController::class, 'add_tire'])->name('evc-tuning-tires.create');
    Route::post('company/evc-tuning-tires/store', [TuningEVCCreditController::class, 'store_tire'])->name('evc-tuning-tires.store');

    Route::resource('company/tuning-types', TuningTypeController::class);
    Route::get('company/tuning-types/{id}/up-sort', [TuningTypeController::class, 'upSort'])->name('tuning-types.sort-up');
    Route::get('company/tuning-types/{id}/down-sort', [TuningTypeController::class, 'downSort'])->name('tuning-types.sort-down');

    Route::resource('company/tuning-types/{id}/options', TuningTypeOptionController::class);
    Route::get('company/tuning-types/{id}/options/{option}/up-sort', [TuningTypeOptionController::class, 'upSort'])->name('options.sort.up');
    Route::get('company/tuning-types/{id}/options/{option}/down-sort', [TuningTypeOptionController::class, 'downSort'])->name('options.sort.down');

    Route::resource('company/subscriptions', SubscriptionController::class);
    Route::get('company/subscriptions/{id}/payments', [SubscriptionController::class, 'payments'])->name('subscriptions.payments');
    Route::get('company/subscriptions/{id}/invoice', [SubscriptionController::class, 'invoice'])->name('subscriptions.invoice');
    Route::get('company/package/choose', [SubscriptionController::class, 'choose'])->name('packages.choose');
    Route::get('company/package/{id}/subscribe', [SubscriptionController::class, 'subscribeSubscription'])->name('subscribe.paypal');
    Route::get('company/package/execute', [SubscriptionController::class, 'executeSubscription'])->name('paypal.subscription.execute');
    Route::get('company/subscriptions/{id}/cancel', [SubscriptionController::class, 'cancelSubscription'])->name('subscriptions.cancel');
    Route::get('company/subscriptions/{id}/suspend', [SubscriptionController::class, 'immediateCancelSubscription'])->name('subscriptions.suspend');

    Route::resource('company/staffs', StaffController::class);

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
    Route::get('/', [DashboardController::class, 'dashboardEcommerce'])->name('dashboard');
    Route::post('/customer-rate', [DashboardController::class, 'addRating'])->name('dashboard.rate');
    Route::post('/set-reseller', [DashboardController::class, 'setReseller'])->name('dashboard.reseller');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::post('/profile_post', [DashboardController::class, 'profile_post'])->name('dashboard.profile.post');

    Route::get('/cars', [CarBrowserController::class, 'index'])->name('cars.index');
    Route::post('/cars/category', [CarBrowserController::class, 'category'])->name('cars.category');
    Route::get('/cars/category', [CarBrowserController::class, 'category'])->name('cars.category');

    // locale Route
    Route::get('lang/{locale}', [LanguageController::class, 'swap']);
});
