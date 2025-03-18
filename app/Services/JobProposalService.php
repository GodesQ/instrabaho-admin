<?php

namespace App\Services;

use Yajra\DataTables\DataTables;

class JobProposalService
{
    public function datatable($data)
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('worker', function ($row) {
                return ($row->worker->user->first_name ?? '') . ' ' . ($row->worker->user->last_name ?? '');
            })
            ->addColumn('job_post', function ($row) {
                return $row->job_post->title;
            })
            ->editColumn('status', function ($row) {
                return '<div class="badge bg-primary">"' . $row->status . '"</div>';
            })
            ->addColumn('action', function ($row) {
                return '<ul class="list-inline hstack gap-1 mb-0">
                            <li class="list-inline-item edit" title="Show">
                                <a href="' . route('job-proposals.show', $row->id) . '"  class="text-primary d-inline-block edit-item-btn">
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
}
