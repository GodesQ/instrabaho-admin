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
use App\Services\Handlers\ExceptionHandlerService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function workerRegister(WorkerRegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create(array_merge(
                $request->only('email', 'first_name', 'middle_name', 'last_name'),
                [
                    'password' => Hash::make($request->password),
                    'username' => $request->email,
                    'user_role_type' => 'user'
                ]
            ));

            if ($request->hasFile('profile_photo')) {
                $identificationFile = $request->file('profile_photo');
                $identificationFileName = Str::random(5) . '-' . time() . $identificationFile->getClientOriginalPath();
                $filePath = 'users/profile_photos/' . $user->id . '/';
                Storage::disk('public')->putFileAs($filePath, $identificationFile, $identificationFileName);

                $user->update([
                    'profile_photo' => $identificationFileName,
                ]);
            }

            $user->syncRoles([RoleEnum::WORKER]);

            UserWallet::updateOrCreatecreate([
                'user_id' => $user->id,
            ], [
                'balance' => 0.00,
                'deposit_method' => null,
                'withdraw_method' => null,
            ]);

            $worker = Worker::create(
                array_merge(
                    $request->only('country_code', 'contact_number', 'gender', 'address', 'latitude', 'longitude'),
                    [
                        'user_id' => $user->id,
                        'hourly_rate' => 0,
                    ]
                )
            );

            if ($request->hasFile('identification_file')) {
                $identificationFile = $request->file('identification_file');
                $identificationFileName = Str::random(5) . '-' . time() . $identificationFile->getClientOriginalPath();
                $filePath = 'workers/identification_ids/' . $worker->id . '/';
                Storage::disk('public')->putFileAs($filePath, $identificationFile, $identificationFileName);

                $worker->update([
                    'identification_filename' => $identificationFileName,
                ]);
            }

            if ($request->hasFile('nbi_copy_file')) {
                $nbiCopyFile = $request->file('nbi_copy_file');
                $nbiCopyFileName = Str::random(5) . '-' . time() . $nbiCopyFile->getClientOriginalPath();
                $filePath = 'workers/nbi/' . $worker->id . '/';
                Storage::disk('public')->putFileAs($filePath, $nbiCopyFile, $identificationFileName);

                $worker->update([
                    'nbi_copy_filename' => $nbiCopyFileName,
                ]);
            }

            WorkerJobService::create([
                'worker_id' => $worker->id,
                'service_id' => $request->service_id,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Worker registration was successful. Please check the registered email for verification.',
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
            DB::beginTransaction();
            $user = User::create(array_merge(
                $request->only('email', 'first_name', 'middle_name', 'last_name'),
                [
                    'password' => Hash::make($request->password),
                    'username' => $request->email,
                    'user_role_type' => 'user'
                ]
            ));

            $user->syncRoles([RoleEnum::CLIENT]);

            UserWallet::updateOrCreatecreate([
                'user_id' => $user->id,
            ], [
                'balance' => 0.00,
                'deposit_method' => null,
                'withdraw_method' => null,
            ]);

            $client = Client::create(array_merge(
                $request->only('country_code', 'contact_number', 'address', 'latitude', 'longitude'),
                [
                    'user_id' => $user->id,
                ]
            ));

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Client registration was successful. Please check the registered email for verification.',
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
            $worker = Worker::where('contact_number', $request->contact_number)
                ->with('user')
                ->first();

            if (!$worker) {
                throw new Exception("The contact number is invalid. Please check and try again.", 400);
            }

            if (!Hash::check($request->password, $worker->user->password)) {
                throw new Exception("Invalid Credentials.", 400);
            }

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

    }
}
