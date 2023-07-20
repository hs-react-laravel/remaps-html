<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\PaypalWebhookController;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PassportCarApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/paypal/webhooks', [PaypalWebhookController::class, 'index']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tuning-type-options/{id}', [ApiController::class, 'tuning_type_options']);
Route::post('/carquery', [ApiController::class, 'car_query'])->name('api.car.query');
Route::post('/carid', [ApiController::class, 'car_id'])->name('api.car.id');
Route::post('/styling', [ApiController::class, 'change_style'])->name('api.style');
Route::post('/read-shop-guide', [ApiController::class, 'readShopGuide'])->name('api.shop.readguide');
Route::post('/open-shop', [ApiController::class, 'openShop'])->name('api.shop.open');
Route::get('/chat-users', [ApiController::class, 'getChatUsers'])->name('api.chat.users');
Route::get('/chat-admin-user', [ApiController::class, 'getAdminUsers'])->name('api.chat.users.admin');
Route::post('/send-message', [ApiController::class, 'sendIM'])->name('api.chat.send');
Route::get('/chat-messages', [ApiController::class, 'getChatMessages'])->name('api.chat.messages');
Route::post('/read-message', [ApiController::class, 'readAll'])->name('api.chat.read');
Route::get('/chat-count', [ApiController::class, 'unreadCount'])->name('api.chat.count');
Route::post('shop/upload/product/digital', [ApiController::class, 'uploadDigital'])->name('api.upload.product.digital');
Route::post('shop/category/create', [ApiController::class, 'createShopCategory'])->name('api.shop.createcategory');
Route::post('shop/category/delete', [ApiController::class, 'deleteShopCategory'])->name('api.shop.deletecategory');
Route::post('shop/category/move', [ApiController::class, 'updateParentShopCategory'])->name('api.shop.movecategory');
Route::post('/order/upload-invoice', [ApiController::class, 'uploadInvoicePdf'])->name('api.order.upload');

Route::post('login', [PassportAuthController::class, 'login']);

Route::group(['domain' => 'remapdash.com'], function () {
    Route::post('makes', [PassportCarApiController::class, 'getMakes']);
    Route::post('models', [PassportCarApiController::class, 'getModels']);
    Route::post('generations', [PassportCarApiController::class, 'getGenerations']);
    Route::post('engines', [PassportCarApiController::class, 'getEngines']);
});
