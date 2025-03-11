<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobProject\StoreAttachmentRequest;
use App\Http\Requests\JobProject\StoreRequest;
use App\Models\JobAttachment;
use App\Models\JobProject;
use App\Models\Service;
use App\Models\User;
use App\Services\ExceptionHandlerService;
use App\Services\JobProjectService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JobProjectController extends Controller
{
    private $jobProjectService;

    public function __construct(JobProjectService $jobProjectService)
    {
        $this->jobProjectService = $jobProjectService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = JobProject::query();
            return $this->jobProjectService->datatable($data);
        }

        return view('backend-pages.job-projects.index-job-projects');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = User::whereHas('customer_details')->get();
        $services = Service::active()->get();
        return view('backend-pages.job-projects.create-job-project', compact('customers', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $job_project = $this->jobProjectService->store($request);

            if ($request->acceptsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Project Successfully Added',
                    'job_project' => $job_project,
                ]);
            }

            return redirect()->route('backend.job-projects.edit', $job_project->id)->withSuccess('Project Successfully Added.');

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
        $jobProject = JobProject::findOrFail($id);
        return view('backend-pages.job-projects.show-job-project', compact('jobProject'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $job_project = JobProject::findOrFail($id);
        $customers = User::whereHas('customer_details')->get();
        $services = Service::active()->get();

        return view('backend-pages.job-projects.edit-job-project', compact('job_project', 'customers', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $job_project = $this->jobProjectService->update($request, $id);

            if ($request->acceptsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Project Successfully Updated',
                    'job_project' => $job_project,
                ]);
            }

            return redirect()->route('backend.job-projects.edit', $job_project->id)->withSuccess('Project Successfully Updated.');

        } catch (Exception $exception) {
            DB::rollBack();
            $exceptionHandler = new ExceptionHandlerService();
            return $exceptionHandler->handler($request, $exception);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $this->jobProjectService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Job Project Successfully Deleted'
            ]);

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService();
            return $exceptionHandler->handler($request, $exception);
        }
    }

    /**
     * Store newly attachments for job project
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return mixed|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function storeNewAttachments(StoreAttachmentRequest $request)
    {
        try {
            $job_project = JobProject::findOr($request->job_id, fn () => throw new Exception('Job Project Not Found.', 404));

            if ($request->has('job_attachments')) {
                foreach ($request->job_attachments as $key => $attachment) {
                    $filename = Str::random(5).'_'.time().'.'.$attachment->getClientOriginalExtension();

                    $filePath = 'job_projects/attachments/'.$job_project->id.'/';
                    Storage::disk('public')->putFileAs($filePath, $attachment, $filename);

                    JobAttachment::create([
                        'job_id' => $job_project->id,
                        'attachment_filename' => $filename,
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Attachment Added Successfully.',
            ]);

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService();
            return $exceptionHandler->handler($request, $exception);
        }
    }

    /**
     * Remove the specified attachment from storage and database 
     * 
     * @param Request $request
     * @param string $id
     */
    public function destroyAttachment(Request $request, string $id)
    {
        try {

            $jobAttachment = JobAttachment::findOr($id, function () {
                throw new Exception('Attachment Not Found', 404);
            });

            $attachmentPath = 'job_projects/attachments/'.$jobAttachment->job_id.'/'.$jobAttachment->attachment_filename;

            if (Storage::disk('public')->exists($attachmentPath)) {
                Storage::disk('public')->delete($attachmentPath);
            }

            $jobAttachment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Attachment Deleted Successfully'
            ]);

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService();
            return $exceptionHandler->handler($request, $exception);
        }
    }
}
