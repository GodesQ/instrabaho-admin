<?php

namespace App\Services;

use App\Enum\RoleEnum;
use App\Jobs\SendUserRegistrationOTP;
use App\Models\Client;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\Worker;
use App\Models\WorkerJobService;
use App\Services\Handlers\ExceptionHandlerService;
use App\Services\ThirdParty\SemaphoreService;
use DB;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApiAuthService
{
    public function workerRegistration($request)
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

            UserWallet::updateOrCreate([
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

            if ($request->has('identification_file')) {
                $identificationFile = $request->file('identification_file');
                $identificationFileName = Str::random(5) . '-' . time() . $identificationFile->getClientOriginalPath();
                $filePath = 'workers/identification_ids/' . $worker->id . '/';
                Storage::disk('public')->putFileAs($filePath, $identificationFile, $identificationFileName);

                $worker->update([
                    'identification_file' => $identificationFileName,
                ]);
            }

            if ($request->has('nbi_copy_file')) {
                $nbiCopyFile = $request->file('nbi_copy_file');
                $nbiCopyFileName = Str::random(5) . '-' . time() . $nbiCopyFile->getClientOriginalPath();
                $filePath = 'workers/nbi/' . $worker->id . '/';
                Storage::disk('public')->putFileAs($filePath, $nbiCopyFile, $identificationFileName);

                $worker->update([
                    'nbi_copy_file' => $nbiCopyFileName,
                ]);
            }

            WorkerJobService::create([
                'worker_id' => $worker->id,
                'service_id' => $request->service_id,
            ]);

            // SendUserRegistrationOTP::dispatch($worker->country_code, $worker->contact_number);
            $semaphoreService = new SemaphoreService;
            $response = $semaphoreService->sendOTP($worker->country_code, $worker->contact_number);

            DB::commit();
            $user->response = json_encode($response);

            return $user;

        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function workerLogin($request)
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

            return $worker;

        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function clientRegistration($request)
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

            UserWallet::updateOrCreate([
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

            return $user;

        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function clientLogin($request)
    {
        try {
            $client = Client::where('contact_number', $request->contact_number)
                ->with('user')
                ->first();

            if (!$client) {
                throw new Exception("The contact number is invalid. Please check and try again.", 400);
            }

            if (!Hash::check($request->password, $client->user->password)) {
                throw new Exception("Invalid Credentials.", 400);
            }

            return $client;
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
