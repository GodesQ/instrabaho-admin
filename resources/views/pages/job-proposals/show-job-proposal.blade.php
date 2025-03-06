@extends('layouts.master')

@section('title', 'Job Proposal')

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pages
        @endslot
        @slot('title')
            Job Proposal
        @endslot
    @endcomponent

    <div class="card">
        <div class="card-header">
            <div class="row g-4 align-items-center">
                <div class="col-sm">
                    <div>
                        <h5 class="card-title mb-0">Job Proposal - #{{ $jobProposal->id }}</h5>
                    </div>
                </div>
                <div class="col-sm-auto">
                    <div class="btn btn-group">
                        <a href="{{ route('job-proposals.index') }}" class="btn btn-sm btn-dark""><i
                                class="ri-arrow-go-back-line align-bottom me-1"></i> Back to List</a>
                        <button href="#" id="{{ $jobProposal->id }}" class="btn btn-sm btn-danger""><i
                                class="ri-delete-bin-line align-bottom me-1"></i> Delete</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card border-bottom">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="card-title">Job Post</h5>
                            <a class="text-primary" href="{{ route('job-posts.show', $jobProposal->job_post->id) }}">View
                                Job Post</a>
                        </div>
                        <div class="card-body">
                            <h5 class="fw-semibold">{{ $jobProposal->job_post->title }}</h5>
                            <div class="flex gap-3">
                                <small class="fw-semibold">
                                    {{ $jobProposal->job_post->address }} ({{ $jobProposal->job_post->latitude }},
                                    {{ $jobProposal->job_post->longitude }})
                                </small>
                            </div>
                            <div class="my-3">
                                <p>{{ $jobProposal->job_post->description }}</p>
                                <h6 class="font-bold">Notes</h6>
                                <p>{{ $jobProposal->job_post->notes ?? 'No Notes Found' }}</p>
                            </div>
                            <div class="pt-3 border-top border-top-dashed mt-4">
                                <div class="row gy-3">

                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Create Date :</p>
                                            <h5 class="fs-15 mb-0">
                                                {{ \Carbon\Carbon::parse($jobProposal->job_post->created_at)->format('d M, Y') }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Scheduled :
                                            </p>
                                            @if ($jobProposal->job_post->urgency === 'scheduled')
                                                <h5 class="fs-15 mb-0">29 Dec, 2021</h5>
                                            @else
                                                <h6>Immediate </h6>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Transaction Type :</p>
                                            <div class="badge bg-primary fs-12">
                                                {{ $jobProposal->job_post->transaction_type }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Status :</p>
                                            <div class="badge bg-primary fs-12">{{ $jobProposal->job_post->status }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-bottom">
                        <div class="card-header">
                            <h4 class="card-title">Worker</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="fw-semibold">
                                {{ $jobProposal->worker->user->first_name . ' ' . $jobProposal->worker->user->last_name }}
                            </h5>
                            <div class="flex gap-3">
                                <a href="tel:{{ $jobProposal->worker->country_code . $jobProposal->worker->contact_number }}"
                                    class="text-muted fs-12">
                                    (+{{ $jobProposal->worker->country_code }})
                                    {{ $jobProposal->worker->contact_number }}
                                </a>
                            </div>
                            <div>
                                <a
                                    href="mailto:{{ $jobProposal->worker->user->email }}">{{ $jobProposal->worker->user->email }}</a>
                            </div>
                            <div class="pt-3 border-top border-top-dashed mt-4">
                                <div class="row gy-3">

                                    <div class="col-lg-6 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Address :</p>
                                            <h5 class="fs-15 mb-0">
                                                {{ $jobProposal->worker->address }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <div>
                                            <p class="mb-2 text-uppercase fw-medium fs-13">Gender :
                                            </p>
                                            <h5 class="fs-15 mb-0">{{ $jobProposal->worker->gender }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card border-bottom">
                        <div class="card-header">
                            <h5 class="card-title">Job Proposal</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <th scope="row" style="width: 200px;">Offer Price</th>
                                            <td>{{ number_format($jobProposal->offer_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Details</th>
                                            <td>{{ $jobProposal->details ?? 'No Details Found' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Worker Proposal Address</th>
                                            <td>{{ $jobProposal->address }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Worker Proposal Latitude</th>
                                            <td>{{ $jobProposal->longitude }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Worker Proposal Longitude</th>
                                            <td>{{ $jobProposal->latitude }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Status</th>
                                            <td>{{ $jobProposal->status }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="btn-group">
                            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                <i class="ri-check-line"></i> Hire Worker & Create Contract
                            </button>
                            <!-- right offcanvas -->
                            <x-offcanvas-contract :jobProposal="$jobProposal" />
                            {{-- <button type="button" class="btn btn-primary">
                                <i class="ri-check-line"></i> Accept & Create Contract
                            </button> --}}
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#declineJobProposalModal">
                                <i class="ri-close-line"></i> Decline Job Proposal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
