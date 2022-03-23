<?php

use App\Http\Controllers\V1\PhoneController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('phone', [PhoneController::class, 'index']);
Route::post('phone', [PhoneController::class, 'store']);
Route::put('phone/{id}', [PhoneController::class, 'update']);
Route::delete('phone/{id}', [PhoneController::class, 'delete']);
Route::post('phone/auto', [PhoneController::class, 'auto']);
