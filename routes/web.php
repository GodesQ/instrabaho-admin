<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\ClientController;
use App\Http\Controllers\Web\JobServiceController;
use App\Http\Controllers\Web\ServiceCategoryController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\WorkerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'saveLogin'])->name('login.post');

Route::group(['middleware' => ['auth']], function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');

    Route::resource('users', UserController::class);

    Route::resource('workers', WorkerController::class)->except(['index', 'destroy']);

    Route::resource('customers', ClientController::class)->except(['index', 'destroy']);

    Route::resource('service-categories', ServiceCategoryController::class);

    Route::resource('job-services', JobServiceController::class);
});
