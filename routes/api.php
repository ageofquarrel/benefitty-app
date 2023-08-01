<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\Goods\GoodBuyController;
use App\Http\Controllers\Goods\GoodRentController;
use App\Http\Controllers\Goods\GoodController;

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

Route::post('/auth', [AuthorizationController::class, 'auth']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () { 
    Route::post('/good/buy', [GoodBuyController::class, 'index']);
    Route::post('/good/rent', [GoodRentController::class, 'index']);
    Route::post('/good/rent/extend', [GoodRentController::class, 'extend']);
    Route::get('/good/history', [GoodController::class, 'history']);
    Route::get('/good/status', [GoodController::class, 'status']);
});
