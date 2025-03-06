<?php

namespace App\Services;

use App\Jobs\ProcessJobPostWorkers;
use App\Models\JobAttachment;
use App\Models\JobPost;
use App\Models\JobProject;
use App\Models\JobService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class JobPostService
{
    public function __construct()
    {

    }

    public function datatable($data)
    {
        return DataTables::of($data)
            ->addColumn('client', function ($row) {
                return ($row->job_creator->user->first_name ?? '') . ' ' . ($row->job_creator->user->last_name ?? '');
            })
            ->addColumn('service', function ($row) {
                return $row->job_service->title;
            })
            ->editColumn('urgency', function ($row) {
                return Str::replace('_', ' ', $row->urgency);
            })
            ->editColumn('scheduled_date', function ($row) {
                return Carbon::parse($row->scheduled_date)->format('F d, Y') . ' ' . Carbon::parse($row->scheduled_time)->format('h:i A');
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 'blocked') {
                    return '<div class="badge bg-danger">Blocked</div>';
                }

                return $row->status == 'published' ? '<div class="badge bg-success">Published</div>' : '<div class="badge bg-warning">Pending</div>';
            })
            ->addColumn('action', function ($row) {
                return '<ul class="list-inline hstack gap-1 mb-0">
                            <li class="list-inline-item edit" title="Show">
                                <a href="' . route('job-posts.show', $row->id) . '"  class="text-primary d-inline-block edit-item-btn">
                                    <i class="ri-file-text-line fs-16"></i>
                                </a>
                            </li>
                            <li class="list-inline-item" title="Remove">
                                <button class="text-danger btn d-inline-block remove-item-btn" id="' . $row->id . '">
                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                </button>
                            </li>
                        </ul>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function store($request)
    {
        try {
            // dd($request->all());
            DB::beginTransaction();

            $job_post_data = $request->only(
                'creator_id',
                'service_id',
                'description',
                'notes',
                'transaction_type',
                'status',
                'address',
                'latitude',
                'longitude',
                'urgency'
            );

            $jobService = JobService::find($request->service_id);

            $job_post = JobPost::create(array_merge($job_post_data, [
                'title' => 'Looking for ' . $jobService->title . ' ( ' . Str::upper(Str::replace('_', ' ', $request->urgency)) . ' ) ',
                'scheduled_date' => $request->urgency === 'scheduled' ? $request->scheduled_date : Carbon::now(),
                'scheduled_time' => $request->urgency === 'scheduled' ? $request->scheduled_time : Carbon::now(),
            ]));

            if ($request->has('job_attachments')) {
                foreach ($request->job_attachments as $key => $attachment) {
                    $filename = Str::random(5) . '_' . time() . '.' . $attachment->getClientOriginalExtension();

                    $filePath = 'job_posts/attachments/' . $job_post->id . '/';
                    Storage::disk('public')->putFileAs($filePath, $attachment, $filename);

                    JobAttachment::create([
                        'job_post_id' => $job_post->id,
                        'attachment_filename' => $filename,
                    ]);
                }
            }

            ProcessJobPostWorkers::dispatch($job_post);

            DB::commit();

            return $job_post;

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
                'creator_id',
                'title',
                'description',
                'notes',
                'transaction_type',
                'status',
                'price_amount',
                'job_duration',
                'address',
                'latitude',
                'longitude',
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

            $jobPost = JobPost::findOr($id, function () {
                throw new Exception('Job Post Not Found', 404);
            });

            // Remove all files from the directory
            $directory = public_path('uploads/job_posts/attachments/') . $jobPost->id;
            $files = glob($directory . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }

            if (is_dir($directory)) {
                @rmdir($directory);
            }

            $jobPost->delete();

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
