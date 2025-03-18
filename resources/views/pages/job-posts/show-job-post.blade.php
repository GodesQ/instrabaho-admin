@extends('layouts.master')

@section('title')
    Job Post - {{ $jobPost->title }}
@endsection


@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pages
        @endslot
        @slot('title')
            Job Post
        @endslot
    @endcomponent

    @if (!$jobPost->job_contract && $jobPost->status === 'completed')
        <div class="alert alert-danger bg-danger text-white alert-label-icon " role="alert">
            <i class="ri-error-warning-line label-icon"></i>
            This job requires a contract before it can begin. Verify whether a contract is in place before the task is
            finished. First, change the status to "Published".
        </div>
    @endif


    <div class="card">
        <div class="card-header">
            <div class="row g-4 align-items-center">
                <div class="col-sm">
                    <div>
                        <h5 class="card-title mb-0">Job Post - #{{ $jobPost->id }}</h5>
                    </div>
                </div>
                <div class="col-sm-auto">
                    <div class="btn btn-group">
                        <a href="{{ route('job-posts.index') }}" class="btn btn-sm btn-dark""><i
                                class="ri-arrow-go-back-line align-bottom me-1"></i> Back to List</a>
                        <a href="{{ route('job-posts.index') }}" class="btn btn-sm btn-primary""><i
                                class="ri-pencil-line align-bottom me-1"></i> Edit</a>
                        <a href="{{ route('job-posts.index') }}" class="btn btn-sm btn-danger""><i
                                class="ri-delete-bin-line align-bottom me-1"></i> Delete</a>

                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#job-post-details" role="tab"
                        aria-selected="false">
                        Job Post Details
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#attachments" role="tab" aria-selected="false">
                        Attachments
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#ranked-workers" role="tab" aria-selected="false">
                        Ranked Workers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#proposals" role="tab" aria-selected="false">
                        Proposals
                    </a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content text-muted">
                <div class="tab-pane active" id="job-post-details" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Client Details</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0 vstack gap-3">
                                        <li>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="{{ URL::asset('build/images/users/avatar-3.jpg') }}"
                                                        alt="" class="avatar-sm rounded">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-15 mb-1">
                                                        {{ $jobPost->job_creator->user->first_name . ' ' . $jobPost->job_creator->user->last_name }}
                                                    </h6>
                                                    <p class="text-muted mb-0">Client</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li><i
                                                class="ri-mail-line mx-2 align-middle text-muted fs-16"></i>{{ $jobPost->job_creator->user->email }}
                                        </li>
                                        <li><i
                                                class="ri-phone-line mx-2 align-middle text-muted fs-16"></i>+({{ $jobPost->job_creator->country_code }})
                                            {{ $jobPost->job_creator->contact_number }}</li>
                                        <li><i class="ri-map-pin-line mx-2 align-middle text-muted fs-16"></i>
                                            {{ $jobPost->job_creator->address }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Job Post</h5>
                                </div>
                                <div class="card-body">
                                    <h5 class="fw-semibold">{{ $jobPost->title }}</h5>
                                    <div class="flex gap-3">
                                        <small class="fw-semibold">
                                            {{ $jobPost->address }} ({{ $jobPost->latitude }}, {{ $jobPost->longitude }})
                                        </small>
                                    </div>
                                    <div class="my-3">
                                        <p>{{ $jobPost->description }}</p>
                                        <h6 class="font-bold">Notes</h6>
                                        <p>{{ $jobPost->notes ?? 'No Notes Found' }}</p>
                                    </div>
                                    <div class="pt-3 border-top border-top-dashed mt-4">
                                        <div class="row gy-3">

                                            <div class="col-lg-3 col-sm-6">
                                                <div>
                                                    <p class="mb-2 text-uppercase fw-medium fs-13">Create Date :</p>
                                                    <h5 class="fs-15 mb-0">
                                                        {{ \Carbon\Carbon::parse($jobPost->created_at)->format('d M, Y') }}
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div>
                                                    <p class="mb-2 text-uppercase fw-medium fs-13">Scheduled Datetime :
                                                    </p>
                                                    @if ($jobPost->urgency === 'scheduled')
                                                        <h5 class="fs-15 mb-0">29 Dec, 2021</h5>
                                                    @else
                                                        <h6>Immediate </h6>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div>
                                                    <p class="mb-2 text-uppercase fw-medium fs-13">Transaction Type :</p>
                                                    <div class="badge bg-primary fs-12">{{ $jobPost->transaction_type }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div>
                                                    <p class="mb-2 text-uppercase fw-medium fs-13">Status :</p>
                                                    <div class="badge bg-primary fs-12">{{ $jobPost->status }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($jobPost->job_contract)
                                        <div class="pt-3 border-top border-top-dashed mt-4">
                                            <a href="{{ route('job-contracts.show', $jobPost->job_contract->id) }}"
                                                class="btn btn-primary">
                                                <i class="bx bx-file"></i>
                                                View Contract
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane " id="attachments" role="tabpanel">
                    <div class="card">
                        <div class="card-header align-items-center d-flex border-bottom-dashed">
                            <h4 class="card-title mb-0 flex-grow-1">Attachments</h4>
                            <div class="flex-shrink-0">
                                <button type="button" class="btn btn-soft-info btn-sm"><i
                                        class="ri-upload-2-fill me-1 align-bottom"></i> Upload</button>
                            </div>
                        </div>

                        <div class="card-body">

                            <div class="vstack gap-2">
                                @foreach ($jobPost->job_post_attachments as $attachment)
                                    <div class="border rounded border-dashed p-2">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light text-secondary rounded fs-24">
                                                        <i class="ri-attachment-2"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="fs-15 mb-1"><a href="#"
                                                        class="text-body text-truncate d-block">{{ $attachment->attachment_file }}</a>
                                                </h5>
                                                <div>
                                                    @php
                                                        $path =
                                                            'job_posts/attachments/' .
                                                            $jobPost->id .
                                                            '/' .
                                                            $attachment->attachment_file;

                                                        if (Storage::disk('public')->exists($path)) {
                                                            $size = Storage::disk('public')->size($path);
                                                            echo formatSizeUnits($size);
                                                        } else {
                                                            echo 'File does not exist at path: ' . $path;
                                                        }
                                                    @endphp
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0 ms-2">
                                                <div class="d-flex gap-1">
                                                    {{-- <button type="button" class="btn btn-icon text-muted btn-sm fs-18"><i
                                                            class="ri-download-2-line"></i></button> --}}
                                                    <div class="dropdown">
                                                        <button class="btn btn-icon text-muted btn-sm fs-18 dropdown"
                                                            type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="ri-more-fill"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item" href="#">
                                                                    <i
                                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                    Rename
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#">
                                                                    <i
                                                                        class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                    Delete
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                </div>
                <div class="tab-pane" id="ranked-workers" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table align-middle table-nowrap table-hover" id="customerTable">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th class="sort" data-sort="ranking" scope="col" style="width: 98px;">
                                                Ranking</th>
                                            <th class="sort" data-sort="name" scope="col">Name</th>
                                            <th class="sort" data-sort="total_score" scope="col">Total Score</th>
                                            <th class="sort" data-sort="metadata" scope="col">Metadata</th>
                                        </tr>
                                        <!--end tr-->
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($jobPost->ranked_workers as $key => $rankedWorker)
                                            <tr>
                                                <td class="ranking text-info fw-semibold">
                                                    #{{ $key + 1 }}
                                                </td>
                                                <td class="collection">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ URL::asset('build/images/nft/img-01.jpg') }}"
                                                            class="avatar-xs rounded-circle object-fit-cover me-2">
                                                        <a href="apps-nft-item-details" class="text-body">
                                                            {{ $rankedWorker->worker->user->first_name }}
                                                            {{ $rankedWorker->worker->user->last_name }}
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="volume_price">{{ $rankedWorker->total_score }} %</td>
                                                <td>{{ $rankedWorker->metadata }}</td>
                                            </tr>
                                            <!--end tr-->
                                        @endforeach
                                    </tbody>
                                </table>
                                <!--end table-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="proposals" role="tabpanel">
                    <div class="container-fluid">

                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#proposalModal">
                                        <i class="ri-add-line"></i>
                                        Add Proposal
                                    </button>
                                    <x-proposal-modal :jobPost="$jobPost" />
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table align-middle table-nowrap table-hover" id="customerTable">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th data-sort="ranking" scope="col" style="width: 98px;">
                                                ID</th>
                                            <th data-sort="name" scope="col">Worker</th>
                                            <th data-sort="total_score" scope="col">Offer Amount
                                            </th>
                                            <th data-sort="metadata" scope="col">Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        <!--end tr-->
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @foreach ($jobPost->proposals as $key => $proposal)
                                            <tr>
                                                <td class="ranking text-info fw-semibold">
                                                    #{{ $key + 1 }}
                                                </td>
                                                <td class="collection">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ URL::asset('build/images/nft/img-01.jpg') }}"
                                                            class="avatar-xs rounded-circle object-fit-cover me-2">
                                                        <div>
                                                            <div href="#" class="text-body">
                                                                {{ $proposal->worker->user->first_name }}
                                                                {{ $proposal->worker->user->last_name }}
                                                            </div>
                                                            <a href="tel:{{ $proposal->worker->country_code . $proposal->worker->contact_number }}"
                                                                class="text-muted fs-12">
                                                                (+{{ $proposal->worker->country_code }})
                                                                {{ $proposal->worker->contact_number }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="volume_price">₱
                                                    {{ number_format($proposal->offer_amount, 2) }}
                                                </td>
                                                <td>{{ $proposal->status }}</td>
                                                <td>
                                                    <ul class="list-inline hstack  mb-0">
                                                        <li class="list-inline-item edit" title="Show">
                                                            <a href="{{ route('job-proposals.show', $proposal->id) }}"
                                                                class="text-primary d-inline-block edit-item-btn">
                                                                <i class="ri-file-text-line fs-16"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item" title="Remove">
                                                            <button class="text-danger btn remove-item-btn"
                                                                id="{{ $proposal->id }}">
                                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <!--end tr-->
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
