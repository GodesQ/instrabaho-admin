<?php

namespace App\Services;

use App\Enum\RoleEnum;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Worker;
use App\Models\WorkerJobService;
use App\Models\WorkerService;
use App\Services\ExceptionHandlerService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserWorkerService
{
    public function store($request)
    {
        try {
            DB::beginTransaction();

            $password = Str::random(8);

            $user = User::create(array_merge(
                $request->only('first_name', 'last_name', 'middle_name', 'username', 'email'),
                ['password' => Hash::make($password)]
            ));

            $user->syncRoles([RoleEnum::WORKER]);

            $worker = Worker::create(array_merge(
                $request->only('hourly_rate', 'personal_description', 'gender', 'birthdate', 'address', 'latitude', 'longitude'),
                ['user_id' => $user->id, 'country_code' => '63', 'contact_number' => $request->contact_number]
            ));

            $filename = null;
            $file = null;

            if ($request->hasFile('identification_file')) {
                $file = $request->file('identification_file');
                $filename = $user->username . '_' . time() . '.' . $file->getClientOriginalExtension();

                $filePath = 'workers/identification_ids/' . $user->id . '/';
                Storage::disk('public')->putFileAs($filePath, $file, $filename);

                $worker->update([
                    'identification_file' => $filename,
                ]);
            }

            WorkerJobService::create([
                'worker_id' => $user->id,
                'service_id' => $request->service_id,
            ]);

            DB::commit();

            return $user;

        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function update($request, $id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOr($id, function () {
                throw new Exception("User Not Found.", 404);
            });

            $user->update($request->only('first_name', 'last_name', 'middle_name', 'username', 'email'));

            $user->profile->update($request->only('gender', 'birthdate', 'address', 'latitude', 'longitude', 'contact_number'));

            $worker = $user->worker_details->update($request->only('tagline', 'hourly_rate', 'personal_description'));

            if ($request->hasFile('identification_file')) {
                $file = $request->file('identification_file');
                $filename = $user->username . '_' . time() . '.' . $file->getClientOriginalExtension();

                $filePath = 'workers/identification_ids/' . $user->id . '/';
                Storage::disk('public')->putFileAs($filePath, $file, $filename);

                $worker->update([
                    'identification_file' => $filename,
                ]);
            }

            $user->worker_service->update([
                'service_id' => $request->service_id,
                'hourly_rate' => $request->service_hourly_rate,
            ]);

            DB::commit();

            return $user;

        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
