<?php

use App\Http\Controllers\Api\AccessTokensController;
use App\Http\Controllers\Api\ProductsController;
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

Route::apiResource('/products', ProductsController::class);

Route::get('/access-tokens', [AccessTokensController::class, 'index'])
    ->middleware('auth:sanctum');

Route::post('/access-tokens', [AccessTokensController::class, 'store'])
    ->middleware('guest:sanctum');

Route::delete('/access-tokens/{token?}', [AccessTokensController::class, 'destroy'])
    ->middleware('auth:sanctum');
