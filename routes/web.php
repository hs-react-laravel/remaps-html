<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppsController;
use App\Http\Controllers\UserInterfaceController;
use App\Http\Controllers\CardsController;
use App\Http\Controllers\ComponentsController;
use App\Http\Controllers\ExtensionController;
use App\Http\Controllers\PageLayoutController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\MiscellaneousController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ChartsController;

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
    Route::resource('company/tickets', TicketController::class);
    Route::resource('company/transactions', TransactionController::class);
    Route::resource('company/email-templates', EmailTemplateController::class);
    Route::resource('admin/companies', CompanyController::class);
    Route::resource('admin/packages', PackageController::class);

    Route::get('company/company-settings', [CompanySettingController::class, 'company_setting'])->name('company.setting');
    Route::post('company/company-settings-update', [CompanySettingController::class, 'store'])->name('company.setting.store');

    Route::resource('company/orders', OrderController::class);
    Route::get('company/orders/{id}/invoice', [OrderController::class, 'invoice'])->name('order.invoice');

    Route::resource('company/customers', CustomerController::class);
    Route::get('company/customers/{id}/file-services',[CustomerController::class, 'fileServices'])->name('customer.fs');
    Route::get('company/customers/{id}/transactions',[CustomerController::class, 'transactions'])->name('customer.tr');
    Route::get('company/customers/{id}/switch-account',[CustomerController::class, 'switchAccount'])->name('customer.sa');

    Route::resource('company/tuning-credits', TuningCreditController::class);
    Route::get('company/tuning-credits/{id}/default', [TuningCreditController::class, 'set_default'])->name('tuning-credits.default');
    Route::delete('company/tuning-tires/{id}/delete', [TuningCreditController::class, 'delete_tire'])->name('tuning-tires.destroy');
    Route::get('company/tuning-tires/create', [TuningCreditController::class, 'add_tire'])->name('tuning-tires.create');
    Route::post('company/tuning-tires/store', [TuningCreditController::class, 'store_tire'])->name('tuning-tires.store');;

    Route::resource('company/tuning-types', TuningTypeController::class);
    Route::get('company/tuning-types/{id}/up-sort', [TuningTypeController::class, 'upSort'])->name('tuning-types.sort-up');
    Route::get('company/tuning-types/{id}/down-sort', [TuningTypeController::class, 'downSort'])->name('tuning-types.sort-down');

    Route::resource('company/tuning-types/{id}/options', TuningTypeOptionController::class);
    Route::get('company/tuning-types/{id}/options/{option}/up-sort', [TuningTypeOptionController::class, 'upSort'])->name('options.sort.up');
    Route::get('company/tuning-types/{id}/options/{option}/down-sort', [TuningTypeOptionController::class, 'downSort'])->name('options.sort.down');

    Route::resource('fs', \App\Http\Controllers\Consumer\FileServiceController::class);
    Route::resource('tk', \App\Http\Controllers\Consumer\TicketController::class);
    // Main Page Route
    Route::get('/', [DashboardController::class, 'dashboardEcommerce'])->name('dashboard');

    // locale Route
    Route::get('lang/{locale}', [LanguageController::class, 'swap']);

    Route::get('chat', [AppsController::class, 'chatApp']);
});

Route::get('/passwordtest', function () {
    dd(Hash::make('abc'));
});

