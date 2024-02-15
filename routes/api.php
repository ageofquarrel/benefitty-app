<?php

use App\Http\Controllers\GeoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorizationController;

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
Route::post('/register', [AuthorizationController::class, 'register']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () { 
    Route::post('/save-coordinates', [GeoController::class, 'saveCoordinates']);
    Route::get('/get-path', [GeoController::class, 'getPath']);
});
