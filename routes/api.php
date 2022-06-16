<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\PaypalWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/send-message', [ApiController::class, 'sendIM'])->name('api.chat.send');
Route::get('/chat-messages', [ApiController::class, 'getChatMessages'])->name('api.chat.messages');
Route::post('/read-message', [ApiController::class, 'readAll'])->name('api.chat.read');
