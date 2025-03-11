<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1'], function () {
    Route::post('workers/register', [AuthController::class, 'workerRegister']);
    Route::post('clients/register', [AuthController::class, 'clientRegister']);

    Route::post('workers/login', [AuthController::class, 'workerLogin']);
    Route::post('clients/login', [AuthController::class, 'clientLogin']);
});
