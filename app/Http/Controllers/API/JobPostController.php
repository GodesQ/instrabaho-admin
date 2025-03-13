<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobPost\StoreRequest;
use App\Http\Resources\JobPostResource;
use App\Services\Handlers\ExceptionHandlerService;
use App\Services\JobPostService;
use DB;
use Exception;
use Illuminate\Http\Request;

class JobPostController extends Controller
{
    public function store(StoreRequest $request)
    {
        try {
            $jobPostService = new JobPostService();
            $jobPost = $jobPostService->store($request);

            return response()->json([
                'status' => true,
                'message' => 'Job Post Created Successfully.',
                'job_post' => JobPostResource::make($jobPost->load('job_post_attachments')),
            ]);

        } catch (Exception $exception) {
            DB::rollBack();
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }
    }

    public function updateJobStatus(Request $request, $job_post_id)
    {
        try {
            $jobPostService = new JobPostService();
            $jobPost = $jobPostService->updateStatus($request, $job_post_id);

            return response()->json([
                'status' => true,
                'message' => 'Status Updated Successfully',
                'job_post' => $jobPost,
            ]);

        } catch (Exception $exception) {
            DB::rollBack();
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }
    }
}
