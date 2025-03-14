<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobContract\StoreRequest;

use App\Models\Client;
use App\Models\JobContract;
use App\Models\Worker;
use App\Services\Handlers\ExceptionHandlerService;
use App\Services\JobContractService;
use Exception;
use Illuminate\Http\Request;

class JobContractController extends Controller
{
    protected $jobContractService;

    public function __construct(JobContractService $jobContractService)
    {
        $this->jobContractService = $jobContractService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $jobContracts = JobContract::query();
            return $this->jobContractService->datatable($jobContracts);
        }

        return view('pages.job-contracts.index-job-contracts');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $workers = Worker::with('user')->get();
        $clients = Client::with('user')->get();
        return view('pages.job-contracts.create-job-contract', compact('workers', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $jobContract = $this->jobContractService->store($request);

            return $request->expectsJson() || $request->ajax()
                ? response()->json([
                    'status' => true,
                    'message' => "Job Contract Created Successfully.",
                    'url' => route('job-contracts.show', $jobContract->id),
                    'job_contract' => $jobContract
                ], 201)
                : redirect()->route('job-contracts.show', $jobContract->id)->with('success', 'Job Contract Created Successfully.');

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobContract = JobContract::findOrFail($id);
        return view('pages.job-contracts.show-job-contract', compact('jobContract'));
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
    public function destroy(string $id)
    {
        //
    }
}
