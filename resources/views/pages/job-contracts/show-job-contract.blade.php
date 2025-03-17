@extends('layouts.master')

@section('title')
    Job Contract - {{ $jobContract->contract_code_number }}
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pages
        @endslot
        @slot('title')
            Job Contract
        @endslot
    @endcomponent

    <div class="row g-4 mb-3 align-items-center">
        <div class="col-sm">
            <div>
                <h5 class="card-title mb-0">Job Contract - #{{ $jobContract->id }}</h5>
            </div>
        </div>
        <div class="col-sm-auto">
            <div class="btn btn-group">
                <a href="{{ route('job-contracts.index') }}" class="btn btn-sm btn-dark""><i
                        class="ri-arrow-go-back-line align-bottom me-1"></i> Back to List</a>
                {{-- <a href="#" id="{{ $jobContract->id }}" class="btn btn-sm btn-danger""><i
                        class="ri-delete-bin-line align-bottom me-1"></i> Delete</a> --}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <x-job-contract :jobContract="$jobContract" />
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Contract Other Info</div>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>Job Status</td>
                                <td>
                                    @switch($jobContract->job_post->status)
                                        @case('completed')
                                            <div class="badge bg-success">{{ $jobContract->job_post->status }}</div>
                                        @break

                                        @case('contracted')
                                            <div class="badge bg-primary">{{ $jobContract->job_post->status }}</div>
                                        @break

                                        @case('cancelled')
                                            <div class="badge bg-danger">{{ $jobContract->job_post->status }}</div>
                                        @break

                                        @case('published')
                                            <div class="badge bg-info">{{ $jobContract->job_post->status }}</div>
                                        @break

                                        @default
                                            <div class="badge bg-warning">{{ $jobContract->job_post->status }}</div>
                                    @endswitch

                                </td>
                            </tr>
                            <tr>
                                <td>Client Service Fee <small class="text-muted">(5%)</small></td>
                                <td>{{ number_format($jobContract->client_service_fee, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Worker Service Fee <small class="text-muted">(10%)</small></td>
                                <td>{{ number_format($jobContract->worker_service_fee, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Contract Total Amount</td>
                                <td>{{ number_format($jobContract->contract_total_amount, 2) }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card overflow-hidden">
                <div class="card-body ">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h5 class="fs-14 mb-3">Contract Wallet</h5>
                            <h2>₱ {{ number_format($jobContract->wallet->amount, 2) }}</h2>
                            <p class="text-muted mb-0">
                                Total Paid To Worker:
                                <span class="text-primary ">₱
                                    {{ number_format($jobContract->wallet->withdraw_amount, 2) }}
                                </span>
                            </p>
                            <p class="text-muted mb-0">
                                Withdraw At:
                                <span class="text-primary ">
                                    {{ $jobContract->wallet->contract_withdraw_at ? Carbon\Carbon::parse($jobContract->wallet->contract_withdraw_at)->format('M d,Y h:i A') : null }}
                                </span>

                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="mdi mdi-wallet-outline text-primary h1"></i>
                        </div>
                    </div>
                </div>
            </div><!--end card-->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Worker Progress</div>
                </div>
                <div class="card-body">
                    <div class="profile-timeline">
                        <div class="accordion accordion-flush " id="accordionFlushExample">
                            @foreach ($jobContract->contract_worker_progresses as $progress)
                                <div class="accordion-item border-0">
                                    <div class="accordion-header" id="headingFour">
                                        <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse"
                                            href="#collapseFour" aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-xs">
                                                    <div class="avatar-title bg-light text-success rounded-circle">
                                                        <i class="ri-checkbox-blank-circle-line"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-14 mb-0 fw-semibold">
                                                        {{ str_replace('_', ' ', ucfirst($progress->status)) }}
                                                    </h6>
                                                    <div class="text-success-emphasis fs-12">
                                                        {{ Carbon\Carbon::parse($progress->created_at)->format('M d, Y h:i A') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!--end accordion-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
