<?php

namespace App\Services;

use App\Jobs\ProcessJobPostWorkers;
use App\Models\JobAttachment;
use App\Models\JobProject;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class JobProjectService
{
    public function __construct()
    {

    }

    public function datatable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn("service", function ($row) {
                return $row->service->service_type ?? 'N/A';
            })
            ->addColumn("customer", function ($row) {
                return $row->customer->first_name.' '.$row->customer->last_name;
            })
            ->editColumn('price_amount', function ($row) {
                return number_format($row->price_amount, 2);
            })
            ->addColumn('action', function ($row) {
                return '<ul class="list-inline hstack gap-1 mb-0">
                            <li class="list-inline-item edit" title="Edit">
                                <a href="'.route('backend.job-projects.show', $row->id).'"  class="text-dark d-inline-block show-item-btn">
                                    <i class="ri-eye-fill fs-16"></i>
                                </a>
                            </li>
                            <li class="list-inline-item edit" title="Edit">
                                <a href="'.route('backend.job-projects.edit', $row->id).'"  class="text-primary d-inline-block edit-item-btn">
                                    <i class="ri-pencil-fill fs-16"></i>
                                </a>
                            </li>
                            <li class="list-inline-item" title="Remove">
                                <a href="#" class="text-danger  d-inline-block remove-item-btn" id="'.$row->id.'">
                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                </a>
                            </li>
                        </ul>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();

            $job_project_data = $request->only(
                'creator_id', 'service_id', 'instructions', 'notes', 'transaction_type', 'status',
                'price_amount', 'address', 'latitude', 'longitude',
            );

            $job_project = JobProject::create(array_merge($job_project_data, [
                'project_type' => $request->is_scheduled ? 'scheduled' : 'instant',
                'schedule_date' => $request->is_scheduled ? $request->schedule_date : Carbon::now(),
                'schedule_time' => $request->is_scheduled ? $request->schedule_time : Carbon::now(),
            ]));

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

            ProcessJobPostWorkers::dispatch($job_project);

            DB::commit();

            return $job_project;

        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function update($request, $id)
    {
        try {
            DB::beginTransaction();
            $job_project = JobProject::findOr($id, function () {
                throw new Exception('Job Project Not Found', 404);
            });

            $job_project_data = $request->only(
                'creator_id', 'title', 'description', 'notes', 'transaction_type', 'status',
                'price_amount', 'job_duration', 'address', 'latitude', 'longitude',
            );

            $job_project->update($job_project_data);

            DB::commit();

            return $job_project;

        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $project = JobProject::findOr($id, function () {
                return throw new Exception('Job Project Not Found', 404);
            });

            // Remove all files from the directory
            $directory = public_path('uploads/job_projects/attachments/').$project->id;
            $files = glob($directory.'/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }

            if (is_dir($directory)) {
                @rmdir($directory);
            }

            $project->delete();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function deleteAttachment($id)
    {

    }

}