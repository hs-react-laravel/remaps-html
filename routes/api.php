<?php

use App\Http\Controllers\ApiController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tuning-type-options/{id}', [ApiController::class, 'tuning_type_options']);
Route::post('/carquery', [ApiController::class, 'car_query'])->name('api.car.query');
Route::post('/carid', [ApiController::class, 'car_id'])->name('api.car.id');
Route::post('/styling', [ApiController::class, 'change_style'])->name('api.style');
Route::post('/fileservices', [ApiController::class, 'getFileServices'])->name('api.index.fileservices');
Route::post('/fileservices/delete/{id}', [ApiController::class, 'removeFileServices'])->name('api.delete.fileservices');
