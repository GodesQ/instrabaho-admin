<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\JobContractController;
use App\Http\Controllers\API\JobPostController;
use App\Http\Controllers\API\JobProposalController;
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

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('logout', [AuthController::class, 'logout']);

        Route::post('job-posts', [JobPostController::class, 'store'])
            ->middleware(['ability:job_post:store']);

        Route::patch('job-posts/{job_post_id}/status', [JobPostController::class, 'updateJobStatus']);
        // ->middleware(['ability:job_post:update_status']);

        Route::post('job-proposals', [JobProposalController::class, 'store'])
            ->middleware(['ability:job_proposal:store']);

        Route::get('job-proposals/{job_proposal_id}', [JobProposalController::class, 'show'])
            ->middleware(['ability:job_proposal:view']);

        Route::get('workers/{worker_id}/job-proposals', [JobProposalController::class, 'workerProposals'])
            ->middleware(['ability:worker_proposal:view']);

        Route::post('job-contracts', [JobContractController::class, 'store'])
            ->middleware(['ability:job_contract:store']);

        Route::get('job-contracts/{job_contract_id}', [JobContractController::class, 'show']);

        Route::patch('workers/{worker_id}/job-contracts/{job_contract_id}/accept', [JobContractController::class, 'workerAcceptOffer']);
        // ->middleware(['ability:job_contract:worker_accept']);

        Route::patch('job-contracts/{job_contract_id}/worker-progress', [JobContractController::class, 'updateWorkerProgress']);
    });

});
