<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobProposal\StoreRequest;
use App\Models\JobProposal;
use App\Models\JobRankedWorker;
use App\Services\Handlers\ExceptionHandlerService;
use App\Services\JobProposalService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobProposalController extends Controller
{
    protected $jobProposalService;
    public function __construct()
    {
        $this->jobProposalService = new JobProposalService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $jobProposal = JobProposal::query();
            return $this->jobProposalService->dataTable($jobProposal);
        }

        return view('pages.job-proposals.index-job-proposals');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            DB::beginTransaction();

            // check if the worker is in the ranked workers on job post.
            $rankedWorker = JobRankedWorker::where('worker_id', $request->worker_id)
                ->where('job_post_id', $request->job_post_id)
                ->exists();

            $data = $request->validated();

            $jobProposal = JobProposal::create($data);

            DB::commit();

            return $request->expectsJson() || $request->ajax()
                ? response()->json([
                    'status' => true,
                    'message' => "Job Proposal was created successfully"
                ], 201)
                : redirect()->route('job-proposals.index')->with('success', 'An error occurred while creating the job proposal.');

        } catch (Exception $exception) {
            DB::rollBack();
            $exceptionHandler = new ExceptionHandlerService();
            return $exceptionHandler->handler($request, $exception);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobProposal = JobProposal::findOrFail($id);
        return view('pages.job-proposals.show-job-proposal', compact('jobProposal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {

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
    public function destroy(string $id)
    {
        //
    }
}
