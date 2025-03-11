<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobPost\StoreRequest;
use App\Models\Client;
use App\Models\JobPost;
use App\Models\JobService;
use App\Services\Handlers\ExceptionHandlerService;
use App\Services\JobPostService;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $jobPostService;

    public function __construct(JobPostService $jobPostService)
    {
        $this->jobPostService = $jobPostService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = JobPost::query();
            return $this->jobPostService->datatable($data);
        }

        return view('pages.job-posts.index-job-posts');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jobServices = JobService::get();
        $clients = Client::with('user')->get();
        return view('pages.job-posts.create-job-post', compact('jobServices', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $jobPost = $this->jobPostService->store($request);

            return response()->json([
                'success' => true,
                'message' => 'Job Post Successfully Created',
            ], 201);
        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService();
            return $exceptionHandler->handler($request, $exception);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobPost = JobPost::findOrFail($id);
        $jobServices = JobService::get();
        $clients = Client::with('user')->get();
        return view('pages.job-posts.show-job-post', compact('jobPost', 'jobServices', 'clients'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $this->jobPostService->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Job Post Successfully Deleted',
            ], 200);
        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService();
            return $exceptionHandler->handler($request, $exception);
        }
    }
}
