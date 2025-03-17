<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\ClientController;
use App\Http\Controllers\Web\ClientReviewController;
use App\Http\Controllers\Web\ContractWorkerProgressController;
use App\Http\Controllers\Web\JobContractController;
use App\Http\Controllers\Web\JobPostController;
use App\Http\Controllers\Web\JobProposalController;
use App\Http\Controllers\Web\JobServiceController;
use App\Http\Controllers\Web\ServiceCategoryController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\WorkerController;
use App\Http\Controllers\Web\WorkerReviewController;
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
    Route::post('workers/import', [WorkerController::class, 'import'])->name('workers.import');

    Route::resource('customers', ClientController::class)->except(['index', 'destroy']);

    Route::resource('service-categories', ServiceCategoryController::class);

    Route::resource('job-services', JobServiceController::class);

    Route::resource('job-posts', JobPostController::class);

    Route::resource('job-proposals', JobProposalController::class);

    Route::resource('job-contracts', JobContractController::class);
    Route::get('job-contracts/{job_contract_id}/download', [JobContractController::class, 'download'])
        ->name('job-contracts.download');

    Route::resource('job-contract-worker-progresses', ContractWorkerProgressController::class);

    Route::resource('worker-reviews', WorkerReviewController::class);

    Route::resource('client-reviews', ClientReviewController::class);

    Route::get('system-server-logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
});
