<?php

namespace App\Http\Controllers\API;

use App\Enum\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\API\ClientRegisterRequest;
use App\Http\Requests\Auth\API\WorkerRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\Client;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\Worker;
use App\Models\WorkerJobService;
use App\Services\ApiAuthService;
use App\Services\Handlers\ExceptionHandlerService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $apiAuthService;
    private $clientTokenAbilities;
    private $workerAbilities;
    public function __construct()
    {
        $this->apiAuthService = new ApiAuthService;
        $this->clientTokenAbilities = [
            'profile:update',
            'job_post:store',
            'job_post:update',
            'job_post:delete',
            'job_post:view',
            'job_proposal:view',
            'worker_review:store',
            'worker_review:delete',
            'notification:view',
        ];
        $this->workerAbilities = [
            'profile:update',
            'job_post:view',
            'job_post:report',
            'job_proposal:store',
            'job_proposal:view',
            'worker_proposal:view',
            'client_review:store',
            'client_review:delete',
            'notification:view',
        ];
    }

    public function workerRegister(WorkerRegisterRequest $request)
    {
        try {
            $user = $this->apiAuthService->workerRegistration($request);

            return response()->json([
                'status' => true,
                'message' => 'Worker registration was successful. Please check the registered email for verification.',
                'user' => $user,
            ], 201);

        } catch (Exception $exception) {
            DB::rollBack();
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }

    }

    public function clientRegister(ClientRegisterRequest $request)
    {
        try {
            $user = $this->apiAuthService->clientRegistration($request);

            return response()->json([
                'status' => true,
                'message' => 'Registered client successfully. Please check the registered email for verification.',
            ], 201);

        } catch (Exception $exception) {
            DB::rollBack();
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }
    }

    public function workerLogin(Request $request)
    {
        try {
            $worker = $this->apiAuthService->workerLogin($request);
            $userToken = $worker->user->createToken("worker-token-{$worker->user->id}");

            return response()->json([
                'status' => true,
                'user' => UserResource::make($worker->user->load('worker')),
                'token' => $userToken->plainTextToken,
            ]);

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }
    }

    public function clientLogin(Request $request)
    {
        try {
            $client = $this->apiAuthService->clientLogin($request);
            $userToken = $client->user->createToken("client-token-{$client->user->id}", $this->clientTokenAbilities);

            return response()->json([
                'status' => true,
                'user' => UserResource::make($client->user->load('client')),
                'token' => $userToken->plainTextToken,
            ]);

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = auth()->user();
            $user->currentAccessToken()->delete();

            return response()->json([
                'status' => true,
                'message' => 'User logged out successfully.',
            ], 200);

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }
    }
}
