<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JobService;
use Illuminate\Http\Request;

class JobServiceController extends Controller
{
    public function getJobServices(Request $request)
    {
        $services = JobService::get();

        return response()->json([
            'status' => true,
            'job_services' => $services
        ]);
    }
}
