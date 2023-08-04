<?php

use App\Events\ChatEvent;
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
use App\Http\Controllers\Remaps\NotificationController;
use App\Http\Controllers\Consumer\BuyTuningCreditsController;
use App\Http\Controllers\Consumer\FileServiceController as FSController;
use App\Http\Controllers\Consumer\TicketController as TKController;
use App\Http\Controllers\Consumer\OrderController as ODController;
use App\Http\Controllers\Consumer\ShopCustomerController;
use App\Http\Controllers\Consumer\TransactionController as TRController;
use App\Http\Controllers\Frontend\CompanyController as FrontendCompanyController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Remaps\SliderManagerController;
use App\Http\Controllers\Remaps\TuningEVCCreditController;
use App\Http\Controllers\PaypalWebhookController;
use App\Http\Controllers\Remaps\ChatController;
use App\Http\Controllers\Remaps\Shop\ShopCategoryController;
use App\Http\Controllers\Remaps\Shop\ShopGuideController;
use App\Http\Controllers\Remaps\Shop\ShopOrderController;
use App\Http\Controllers\Remaps\Shop\ShopPackageController;
use App\Http\Controllers\Remaps\Shop\ShopProductController;
use App\Http\Controllers\Remaps\Shop\ShopSubscriptionController;
use App\Http\Controllers\Staff\FileServiceController as StaffFileServiceController;
use App\Http\Controllers\Staff\TicketController as StaffTicketController;
use App\Http\Controllers\Staff\ChatController as StaffChatController;
use App\Http\Controllers\Consumer\CustomerChatController;
use App\Http\Controllers\Remaps\Api\ApiInterfaceController;
use App\Http\Controllers\Remaps\Api\ApiUserController;
use App\Http\Controllers\Remaps\Api\ApiSubscriptionController;
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
// Route::group(['domain' => 'remapdash.com'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('innerhome');
	Route::get('compare-prices', [FrontendCompanyController::class, 'companies'])->name('frontend.companies');
	Route::get('register-account', [FrontendCompanyController::class, 'create'])->name('register-account.create');
	Route::get('thankyou', [FrontendCompanyController::class, 'thankyou'])->name('thankyou');

	// route for post request
	Route::post('paypal', [FrontendCompanyController::class, 'postPaymentWithpaypal'])->name('pay.with.paypal.main');
	// route for check status responce
	Route::get('paypal', [FrontendCompanyController::class, 'getPaymentStatus'])->name('paypal.payment.status.main');

	Route::get('paypal/subscribe/execute', [FrontendCompanyController::class, 'executeSubscription'])->name('paypal.execute.subscription');
	Route::get('paypal/subscribe/{package}', [FrontendCompanyController::class, 'subscribeSubscription'])->name('paypal.subscribe.subscription');

    Route::get('api-intro', [FrontendCompanyController::class, 'api_intro'])->name('frontend.api.intro');
    Route::post('api-intro', [FrontendCompanyController::class, 'api_reg'])->name('frontend.api.register');
    Route::get('api-login', [FrontendCompanyController::class, 'api_login'])->name('frontend.api.login');
    Route::post('api-login', [FrontendCompanyController::class, 'api_login_post'])->name('frontend.api.login.post');
    Route::get('api-sub/{token}', [FrontendCompanyController::class, 'api_subscription'])->name('frontend.api.sub');
    Route::get('api/execute', [FrontendCompanyController::class, 'executeSubscription'])->name('frontend.subscription.execute');
    Route::get('api-dashboard', [FrontendCompanyController::class, 'api_dashboard'])->name('frontend.api.dashboard');
// });

// Auth::routes();

// Route::get('/admin', function () {
//     return redirect(url('admin/login'));
// });
// Route::get('/', function () {
//     return redirect(route('login'));
// });
// Route::get('/customer', function () {
//     return redirect(url('customer/dashboard'));
// });
// Route::group(['middleware' => 'web', 'prefix'=>'admin'], function(){
// 	Route::get('login', '\App\Http\Controllers\Auth\Admin\LoginController@showLoginForm')->name('admin.auth.show.login');
// 	Route::post('login', '\App\Http\Controllers\Auth\Admin\LoginController@login')->name('admin.auth.login');
// 	Route::post('logout', '\App\Http\Controllers\Auth\Admin\LoginController@logout')->name('admin.auth.logout');
// 	Route::get('password/reset', '\App\Http\Controllers\Auth\Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.auth.show.password.reset');
// 	Route::post('password/reset', '\App\Http\Controllers\Auth\Admin\ResetPasswordController@reset')->name('admin.auth.password.reset');
// 	Route::get('password/reset/{token}', '\App\Http\Controllers\Auth\Admin\ResetPasswordController@showResetForm')->name('admin.auth.password.reset.form');
// 	Route::post('password/email', '\App\Http\Controllers\Auth\Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.auth.password.email');
// 	Route::get('{id}/switch-account','\App\Http\Controllers\Auth\Admin\LoginController@switchAsCompany')->name('admin.auth.switch-account');
//     Route::get('{id}/redirect-from-master','\App\Http\Controllers\Auth\Admin\LoginController@redirectFromMaster')->name('admin.auth.redirect-from-master');
// });
// Route::group(['prefix'=>'admin', 'middleware' => 'check.company'], function () {
//     Route::get('/dashboard', [DashboardController::class, 'dashboardAdmin'])->name('dashboard.admin');
//     Route::get('/dashboard-api', [DashboardController::class, 'dashboardAdminApi'])->name('dashboard.admin.api');
//     Route::resource('fileservices', FileServiceController::class);
//     Route::get('fileservices/{id}/download-original', [FileServiceController::class, 'download_original'])->name('fileservice.download.original');
//     Route::get('fileservices/{id}/download-modified', [FileServiceController::class, 'download_modified'])->name('fileservice.download.modified');
//     Route::get('fileservices/{id}/delete-modified', [FileServiceController::class, 'delete_modified_file'])->name('fileservice.delete.modified');
//     Route::get('fileservices/{id}/create-ticket', [FileServiceController::class, 'create_ticket'])->name('fileservice.tickets.create');
//     Route::post('fileservices/{id}/store-ticket', [FileServiceController::class, 'store_ticket'])->name('fileservice.tickets.store');
//     Route::post('fileservices/api', [FileServiceController::class, 'getFileServices'])->name('fileservices.api');
//     Route::post('fileservices/api/upload', [FileServiceController::class, 'uploadFile'])->name('fileservices.api.upload');

//     Route::resource('tickets', TicketController::class);
//     Route::get('tickets/{id}/download-document', [TicketController::class, 'download_document'])->name('tickets.download');
//     Route::get('tickets/{id}/close', [TicketController::class, 'close_ticket'])->name('tickets.close');
//     Route::get('ticket/ra', [TicketController::class, 'read_all'])->name('tickets.read.all');
//     Route::get('ticket/dc', [TicketController::class, 'delete_closed'])->name('tickets.delete.closed');
//     Route::post('tickets/api', [TicketController::class, 'getTickets'])->name('tickets.api');
//     Route::post('tickets/api/upload/ticket', [TicketController::class, 'uploadTicketFile'])->name('tickets.api.upload');

//     Route::resource('transactions', TransactionController::class);
//     Route::resource('email-templates', EmailTemplateController::class);

//     Route::resource('companies', CompanyController::class);
//     Route::get('companies/{id}/activate', [CompanyController::class, 'activate'])->name('companies.activate');
//     Route::get('companies/{id}/public', [CompanyController::class, 'public'])->name('companies.public');
//     Route::get('companies/{id}/switch', [CompanyController::class, 'switchAsCompany'])->name('companies.switch');
//     Route::get('companies/{id}/trial', [CompanyController::class, 'trial'])->name('companies.trial');
//     Route::post('companies/{id}/trial', [CompanyController::class, 'trial_post'])->name('companies.trial.post');
//     Route::get('companies/{id}/reset-password-link', [CompanyController::class, 'resendPasswordResetLink'])->name('companies.reset-password');
//     Route::resource('packages', PackageController::class);
//     Route::resource('slidermanagers', SliderManagerController::class);
//     Route::resource('shopcategories', ShopCategoryController::class);
//     Route::resource('shopproducts', ShopProductController::class);
//     Route::get('shopproduct/digital/create', [ShopProductController::class, 'create_digital'])->name('shopproducts.digital.create');
//     Route::post('shopproduct/digital/store', [ShopProductController::class, 'store_digital'])->name('shopproducts.digital.store');
//     Route::get('shopproduct/digital/{id}/edit', [ShopProductController::class, 'edit_digital'])->name('shopproducts.digital.edit');
//     Route::put('shopproduct/digital/{id}/update', [ShopProductController::class, 'update_digital'])->name('shopproducts.digital.update');
//     Route::delete('shopproduct/digital/{id}/delete', [ShopProductController::class, 'delete_digital'])->name('shopproducts.digital.delete');
//     Route::resource('shoporders', ShopOrderController::class);
//     Route::resource('shoppackages', ShopPackageController::class);
//     Route::post('shoporders/{id}/dispatch', [ShopOrderController::class, 'dispatched'])->name('shoporders.dispatch');
//     Route::post('shoporders/{id}/process', [ShopOrderController::class, 'process'])->name('shoporders.process');
//     Route::get('shoporders/{id}/refund', [ShopOrderController::class, 'refund'])->name('shoporders.refund');
//     Route::get('shoporders/{id}/complete', [ShopOrderController::class, 'completed'])->name('shoporders.complete');
//     Route::post('shopproducts/api/upload', [ShopProductController::class, 'uploadImageFile'])->name('shopproducts.files.api');

//     Route::get('company-settings', [CompanySettingController::class, 'company_setting'])->name('company.setting');
//     Route::post('company-settings-update', [CompanySettingController::class, 'store'])->name('company.setting.store');

//     Route::resource('orders', OrderController::class);
//     Route::get('orders/{id}/invoice', [OrderController::class, 'invoice'])->name('order.invoice');
//     Route::get('orders/{id}/download', [OrderController::class, 'download'])->name('order.download');

//     Route::resource('customers', CustomerController::class);
//     Route::get('customers/{id}/file-services',[CustomerController::class, 'fileServices'])->name('customer.fs');
//     Route::get('customers/{id}/transactions',[CustomerController::class, 'transactions'])->name('customer.tr');
//     Route::post('customers/{id}/transactions',[CustomerController::class, 'transactions_post'])->name('customer.tr.post');
//     Route::post('customers/{id}/transactions/evc',[CustomerController::class, 'transactions_post_evc'])->name('customer.tr.evc.post');
//     Route::get('customers/{id}/switch-account',[CustomerController::class, 'switchAccount'])->name('customer.sa');
//     Route::get('customers/{id}/reset-password',[CustomerController::class, 'resetPasswordLink'])->name('customer.rp');
//     Route::post('customers/api', [CustomerController::class, 'api'])->name('customer.api');

//     Route::resource('notifications', NotificationController::class);
//     Route::post('notifications/api', [NotificationController::class, 'api'])->name('notification.api');

//     Route::resource('tuning-credits', TuningCreditController::class);
//     Route::get('tuning-credits/{id}/default', [TuningCreditController::class, 'set_default'])->name('tuning-credits.default');
//     Route::delete('tuning-tires/{id}/delete', [TuningCreditController::class, 'delete_tire'])->name('tuning-tires.destroy');
//     Route::get('tuning-tires/create', [TuningCreditController::class, 'add_tire'])->name('tuning-tires.create');
//     Route::post('tuning-tires/store', [TuningCreditController::class, 'store_tire'])->name('tuning-tires.store');

//     Route::resource('evc-tuning-credits', TuningEVCCreditController::class);
//     Route::get('evc-tuning-credits/{id}/default', [TuningEVCCreditController::class, 'set_default'])->name('evc-tuning-credits.default');
//     Route::delete('evc-tuning-tires/{id}/delete', [TuningEVCCreditController::class, 'delete_tire'])->name('evc-tuning-tires.destroy');
//     Route::get('evc-tuning-tires/create', [TuningEVCCreditController::class, 'add_tire'])->name('evc-tuning-tires.create');
//     Route::post('evc-tuning-tires/store', [TuningEVCCreditController::class, 'store_tire'])->name('evc-tuning-tires.store');

//     Route::resource('tuning-types', TuningTypeController::class);
//     Route::get('tuning-types/{id}/up-sort', [TuningTypeController::class, 'upSort'])->name('tuning-types.sort-up');
//     Route::get('tuning-types/{id}/down-sort', [TuningTypeController::class, 'downSort'])->name('tuning-types.sort-down');

//     Route::resource('tuning-types/{id}/options', TuningTypeOptionController::class);
//     Route::get('tuning-types/{id}/options/{option}/up-sort', [TuningTypeOptionController::class, 'upSort'])->name('options.sort.up');
//     Route::get('tuning-types/{id}/options/{option}/down-sort', [TuningTypeOptionController::class, 'downSort'])->name('options.sort.down');

//     Route::resource('subscriptions', SubscriptionController::class);
//     Route::get('subscriptions/{id}/payments', [SubscriptionController::class, 'payments'])->name('subscriptions.payments');
//     Route::get('subscriptions/{id}/invoice', [SubscriptionController::class, 'invoice'])->name('subscriptions.invoice');
//     Route::get('package/choose', [SubscriptionController::class, 'choose'])->name('packages.choose');
//     Route::get('package/{id}/subscribe', [SubscriptionController::class, 'subscribeSubscription'])->name('subscribe.paypal');
//     Route::get('package/execute', [SubscriptionController::class, 'executeSubscription'])->name('paypal.subscription.execute');
//     Route::get('subscriptions/{id}/cancel', [SubscriptionController::class, 'cancelSubscription'])->name('subscriptions.cancel');
//     Route::get('subscriptions/{id}/suspend', [SubscriptionController::class, 'immediateCancelSubscription'])->name('subscriptions.suspend');

//     Route::get('shop/package/choose', [ShopSubscriptionController::class, 'choose'])->name('shop.packages.choose');
//     Route::get('shop/package/{id}/subscribe', [ShopSubscriptionController::class, 'subscribeSubscription'])->name('shop.subscribe.paypal');
//     Route::get('shop/package/execute', [ShopSubscriptionController::class, 'executeSubscription'])->name('shop.paypal.subscription.execute');
//     Route::get('shop/subscriptions', [ShopSubscriptionController::class, 'index'])->name('shop.subscription.index');
//     Route::get('shop/subscriptions/{id}/payments', [ShopSubscriptionController::class, 'payments'])->name('shop.subscriptions.payments');
//     Route::get('shop/subscriptions/{id}/invoice', [ShopSubscriptionController::class, 'invoice'])->name('shop.subscriptions.invoice');
//     Route::get('shop/subscriptions/{id}/cancel', [ShopSubscriptionController::class, 'cancelSubscription'])->name('shop.subscriptions.cancel');
//     Route::get('shop/subscriptions/{id}/suspend', [ShopSubscriptionController::class, 'immediateCancelSubscription'])->name('shop.subscriptions.suspend');
//     Route::get('shop/subscriptions/{id}/reactive', [ShopSubscriptionController::class, 'reactiveSubscription'])->name('shop.subscriptions.reactive');
//     Route::get('shop/guide', [ShopGuideController::class, 'index'])->name('shop.guide');
//     Route::post('shop/guide', [ShopGuideController::class, 'store'])->name('shop.guide.store');
//     Route::get('shop/open', [ShopSubscriptionController::class, 'open'])->name('shop.guide');

//     Route::get('chats', [ChatController::class, 'index'])->name('chats.index');

//     Route::resource('staffs', StaffController::class);
//     Route::get('staffs/{id}/set_semi_admin', [StaffController::class, 'set_semi_admin'])->name('staffs.semi.set');

//     Route::get('/cars', [CarBrowserController::class, 'index'])->name('admin.cars.index');
//     Route::post('/cars/category', [CarBrowserController::class, 'category'])->name('admin.cars.category');
//     Route::get('/cars/category', [CarBrowserController::class, 'category'])->name('admin.cars.category');

//     Route::get('/profile', [DashboardController::class, 'profile'])->name('admin.dashboard.profile');
//     Route::put('/profile_post', [DashboardController::class, 'profile_post'])->name('admin.dashboard.profile.post');

//     Route::get('/edit-password', [DashboardController::class, 'edit_password'])->name('admin.password.edit');
//     Route::post('/edit-password', [DashboardController::class, 'edit_password_post'])->name('admin.password.edit.post');

//     Route::get('/api/package', [ApiInterfaceController::class, 'package_edit'])->name('admin.api.package');
//     Route::post('/api/package', [ApiInterfaceController::class, 'package_edit_post'])->name('admin.api.package.post');

//     Route::resource('apiusers', ApiUserController::class);
//     Route::post('apiusers/api', [ApiUserController::class, 'api'])->name('apiusers.api');
//     Route::get('apiuser/token', [ApiUserController::class, 'generateToken'])->name('apiuser.api.generate');

//     Route::get('api/subscriptions', [ApiSubscriptionController::class, 'index'])->name('api.subscription.index');
//     Route::get('api/subscriptions/{id}/payments', [ApiSubscriptionController::class, 'payments'])->name('api.subscriptions.payments');
//     Route::get('api/subscriptions/{id}/invoice', [ApiSubscriptionController::class, 'invoice'])->name('api.subscriptions.invoice');
//     Route::get('api/subscriptions/{id}/cancel', [ApiSubscriptionController::class, 'cancelSubscription'])->name('api.subscriptions.cancel');
//     Route::get('api/subscriptions/{id}/suspend', [ApiSubscriptionController::class, 'immediateCancelSubscription'])->name('api.subscriptions.suspend');
//     Route::get('api/subscriptions/{id}/reactive', [ApiSubscriptionController::class, 'reactiveSubscription'])->name('api.subscriptions.reactive');
// });
// Route::group(['prefix'=>'staff', 'middleware' => 'check.customerstaff'], function () {
//     Route::get('stafffs/{id}/download-original', [StaffFileServiceController::class, 'download_original'])->name('stafffs.download.original');
//     Route::get('stafffs/{id}/download-modified', [StaffFileServiceController::class, 'download_modified'])->name('stafffs.download.modified');
//     Route::get('stafffs/{id}/delete-modified', [StaffFileServiceController::class, 'delete_modified_file'])->name('stafffs.delete.modified');

//     Route::get('profile', [DashboardController::class, 'profile_staff'])->name('staff.dashboard.profile');
//     Route::put('profile_post', [DashboardController::class, 'profile_staff_post'])->name('staff.dashboard.profile.post');

//     Route::get('edit-password', [DashboardController::class, 'edit_password'])->name('staff.password.edit');
//     Route::post('edit-password', [DashboardController::class, 'edit_password_post'])->name('staff.password.edit.post');

//     Route::get('chats', [StaffChatController::class, 'index'])->name('staff.chats.index');
// });
// Route::group(['middleware' => 'web', 'prefix'=>'staff'], function(){
// 	Route::get('login', '\App\Http\Controllers\Auth\Staff\LoginController@showLoginForm')->name('staff.auth.show.login');
// 	Route::post('login', '\App\Http\Controllers\Auth\Staff\LoginController@login')->name('staff.auth.login');
// 	Route::post('logout', '\App\Http\Controllers\Auth\Staff\LoginController@logout')->name('staff.auth.logout');
// 	Route::get('password/reset', '\App\Http\Controllers\Auth\Staff\ForgotPasswordController@showLinkRequestForm')->name('staff.auth.show.password.reset');
// 	Route::post('password/reset', '\App\Http\Controllers\Auth\Staff\ResetPasswordController@reset')->name('staff.auth.password.reset');
// 	Route::get('password/reset/{token}', '\App\Http\Controllers\Auth\Staff\ResetPasswordController@showResetForm')->name('staff.auth.password.reset.form');
// 	Route::post('password/email', '\App\Http\Controllers\Auth\Staff\ForgotPasswordController@sendResetLinkEmail')->name('staff.auth.password.email');
// 	Route::get('{id}/switch-account','\App\Http\Controllers\Auth\Staff\LoginController@switchAsCompany')->name('staff.auth.switch-account');
//     Route::get('{id}/redirect-from-master','\App\Http\Controllers\Auth\Staff\LoginController@redirectFromMaster')->name('staff.auth.redirect-from-master');
// });
// Route::group(['prefix'=>'staff', 'middleware' => 'check.onlystaff'], function () {
//     Route::get('/dashboard', [DashboardController::class, 'dashboardStaff'])->name('dashboard.staff');
//     Route::resource('stafffs', StaffFileServiceController::class);
//     Route::get('stafffs/{id}/create-ticket', [StaffFileServiceController::class, 'create_ticket'])->name('stafffs.tickets.create');
//     Route::post('stafffs/{id}/store-ticket', [StaffFileServiceController::class, 'store_ticket'])->name('stafffs.tickets.store');
//     Route::post('stafffs/api', [StaffFileServiceController::class, 'getFileServices'])->name('stafffs.api');
//     Route::post('stafffs/api/upload', [StaffFileServiceController::class, 'uploadFile'])->name('stafffs.api.upload');

//     Route::resource('stafftk', StaffTicketController::class);
//     Route::get('stafftk/{id}/download-document', [StaffTicketController::class, 'download_document'])->name('stafftk.download');
//     Route::get('stafftk/{id}/close', [StaffTicketController::class, 'close_ticket'])->name('stafftk.close');
//     Route::get('stafftks/ra', [StaffTicketController::class, 'read_all'])->name('stafftk.read.all');
//     Route::post('stafftk/api', [StaffTicketController::class, 'getTickets'])->name('stafftk.api');
// });
// Route::group(['middleware' => 'auth:customer', 'prefix'=>'customer'], function () {
//     Route::get('/dashboard', [DashboardController::class, 'dashboardCustomer'])->name('dashboard.customer');
//     Route::resource('fs', FSController::class);
//     Route::get('/fs/{id}/download-original', [FSController::class, 'download_original'])->name('fs.download.original');
//     Route::get('/fs/{id}/download-modified', [FSController::class, 'download_modified'])->name('fs.download.modified');
//     Route::get('/fs/{id}/delete-modified', [FSController::class, 'delete_modified_file'])->name('fs.delete.modified');
//     Route::get('/fs/{id}/create-ticket', [FSController::class, 'create_ticket'])->name('fs.tickets.create');
//     Route::post('/fs/{id}/store-ticket', [FSController::class, 'store_ticket'])->name('fs.tickets.store');
//     Route::post('fs/api', [FSController::class, 'getFileServices'])->name('fs.api');
//     Route::post('fs/api/checkopen', [FSController::class, 'checkOpenStatus'])->name('fs.checkopen.api');
//     Route::post('fs/api/upload', [FSController::class, 'uploadFile'])->name('fs.api.upload');

//     Route::resource('tk', TKController::class);
//     Route::get('tk/{id}/download-document', [TKController::class, 'download_document'])->name('tk.download');
//     Route::get('tk/{id}/close', [TKController::class, 'close_ticket'])->name('tk.close');
//     Route::get('tks/ra', [TKController::class, 'read_all'])->name('tk.read.all');
//     Route::post('tk/api', [TKController::class, 'getTickets'])->name('tk.api');
//     Route::post('tk/api/upload', [TKController::class, 'uploadTicketFile'])->name('tk.api.upload');

//     Route::resource('od', ODController::class);
//     Route::resource('tr', TRController::class);
//     Route::get('/buy-credits', [BuyTuningCreditsController::class, 'index'])->name('consumer.buy-credits');
//     Route::post('/buy-credits/handle', [BuyTuningCreditsController::class, 'handlePayment'])->name('consumer.buy-credits.handle');
//     Route::get('/buy-credits/cancel', [BuyTuningCreditsController::class, 'paymentCancel'])->name('consumer.buy-credits.cancel');
//     Route::get('/buy-credits/success', [BuyTuningCreditsController::class, 'paymentSuccess'])->name('consumer.buy-credits.success');
//     Route::post('/buy-credits/stripe-post', [BuyTuningCreditsController::class, 'stripePost'])->name('consumer.buy-credits.stripe-post');
//     Route::get('orders/{id}/invoice', [ODController::class, 'invoice'])->name('customer.order.invoice');
//     Route::get('orders/{id}/download', [ODController::class, 'download'])->name('customer.order.download');
//     // Main Page Route
//     // Route::get('/', [DashboardController::class, 'dashboardEcommerce'])->name('dashboard');
//     Route::post('/customer-rate', [DashboardController::class, 'addRating'])->name('dashboard.rate');
//     Route::post('/set-reseller', [DashboardController::class, 'setReseller'])->name('dashboard.reseller');

//     Route::get('/cars', [CarBrowserController::class, 'index'])->name('cars.index');
//     Route::post('/cars/category', [CarBrowserController::class, 'category'])->name('cars.category');
//     Route::get('/cars/category', [CarBrowserController::class, 'category'])->name('cars.category');

//     Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
//     Route::put('/profile_post', [DashboardController::class, 'profile_post'])->name('dashboard.profile.post');
//     Route::post('/profile_staff_post', [DashboardController::class, 'profile_staff_post'])->name('admin.dashboard.profile.staff.post');

//     Route::get('/edit-password', [DashboardController::class, 'edit_password'])->name('password.edit');
//     Route::post('/edit-password', [DashboardController::class, 'edit_password_post'])->name('password.edit.post');
//     Route::get('/notifications', [DashboardController::class, 'notifications'])->name('dashboard.notifications');
//     Route::post('/notifications/read', [DashboardController::class, 'notification_read_one'])->name('dashboard.notifications.read');

//     Route::get('/shop/physical', [ShopCustomerController::class, 'physical_list'])->name('customer.shop.physical');
//     Route::get('/shop/digital', [ShopCustomerController::class, 'digital_list'])->name('customer.shop.digital');
//     Route::get('/shop/checkout', [ShopCustomerController::class, 'checkout'])->name('customer.shop.checkout');
//     Route::get('/shop/product/{id}', [ShopCustomerController::class, 'detail'])->name('customer.shop.detail');
//     Route::post('/shop/cart/add', [ShopCustomerController::class, 'add2cart'])->name('customer.shop.cart.add');
//     Route::post('/shop/cart/update', [ShopCustomerController::class, 'updateCartItem'])->name('customer.shop.cart.update');
//     Route::post('/shop/cart/delete', [ShopCustomerController::class, 'deleteCartItem'])->name('customer.shop.cart.delete');
//     Route::post('/shop/card/add', [ShopCustomerController::class, 'addCard'])->name('customer.shop.payment.card');
//     Route::post('/shop/order/place', [ShopCustomerController::class, 'placeOrder'])->name('customer.shop.order.place');
//     Route::post('/shop/order/{id}/address', [ShopCustomerController::class, 'setOrderAddress'])->name('customer.shop.order.address');
//     Route::post('/shop/order/{id}/shipment', [ShopCustomerController::class, 'setShippingOption'])->name('customer.shop.order.ship');
//     Route::post('/shop/order/{id}/stripe-payment', [ShopCustomerController::class, 'payOrderByStripe'])->name('customer.shop.order.pay.stripe');
//     Route::post('/shop/order/{id}/paypal-payment', [ShopCustomerController::class, 'payOrderByPaypal'])->name('customer.shop.order.pay.paypal');
//     Route::get('/shop/order/{id}/paypal-payment/cancel', [ShopCustomerController::class, 'paypalPaymentCancel'])->name('customer.shop.order.pay.paypal.cancel');
//     Route::get('/shop/order/{id}/paypal-payment/success', [ShopCustomerController::class, 'paypalPaymentSuccess'])->name('customer.shop.order.pay.paypal.success');
//     Route::get('/shop/order/list', [ShopCustomerController::class, 'orderList'])->name('customer.shop.order.list');
//     Route::get('/shop/order/{id}/show', [ShopCustomerController::class, 'orderShow'])->name('customer.shop.order.show');
//     Route::post('/shop/comment/{id}', [ShopCustomerController::class, 'commentProduct'])->name('customer.shop.comment.save');

//     Route::get('chats', [CustomerChatController::class, 'index'])->name('customer.chats.index');
// });
// Route::group(['middleware' => 'check.common'], function () {

// });
// Route::get('lang/{locale}', [LanguageController::class, 'swap']);
// Route::post('/cars/print', [CarBrowserController::class, 'print_customer'])->name('cars.print');
