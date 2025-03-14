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
                <button href="#" id="{{ $jobContract->id }}" class="btn btn-sm btn-danger""><i
                        class="ri-delete-bin-line align-bottom me-1"></i> Delete</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="border border-dashed p-3">
                <div class="card">
                    <div class="card-header pb-1" style="border: none;">
                        <div class="row g-4 align-items-center justify-between">
                            <div class="col-sm">
                                <h2>
                                    Instrabaho Contract
                                </h2>
                            </div>
                            <div class="col-sm-auto">
                                <div class="btn btn-group">
                                    <button href="#" id="{{ $jobContract->id }}" class="btn btn-sm btn-secondary""><i
                                            class="ri-download-line align-bottom me-1"></i> Download</a>
                                        <button href="#" id="{{ $jobContract->id }}"
                                            class="btn btn-sm btn-primary""><i
                                                class="ri-printer-line align-bottom me-1"></i> Print</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <table class="table table-borderless border-top border-bottom py-3">
                            <tbody>
                                <td style="font-weight: bold !important;">Contract Code Number</td>
                                <td>
                                    {{ $jobContract->contract_code_number }}
                                </td>
                                <td style="font-weight: bold !important;">Date</td>
                                <td>
                                    {{ Carbon\Carbon::parse($jobContract->created_at)->format('F d, Y') }}
                                </td>
                                <td style="font-weight: bold !important;">Contract Amount</td>
                                <td>
                                    ₱ {{ number_format($jobContract->contract_amount, 2) }}
                                </td>
                            </tbody>
                        </table>
                        <h2 class="my-4  fw-normal">
                            Parties Involved:
                        </h2>
                        <div id="client-table">
                            <h5 class="text-primary-emphasis text-uppercase">Client</h5>
                            <table class="table table-borderless border-top">
                                <tbody>
                                    <tr>
                                        <td style="font-weight: bold;">Name</td>
                                        <td>
                                            {{ $jobContract->client->user->first_name . ' ' . $jobContract->client->user->last_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Address</td>
                                        <td>
                                            {{ $jobContract->client->address }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Email</td>
                                        <td>
                                            {{ $jobContract->client->user->email }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Phone Number</td>
                                        <td>
                                            +({{ $jobContract->client->country_code }})
                                            {{ $jobContract->client->contact_number }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="worker-table">
                            <h5 class="text-primary-emphasis text-uppercase">Worker</h5>
                            <table class="table table-borderless border-top">
                                <tbody>
                                    <tr>
                                        <td style="font-weight: bold;">Name</td>
                                        <td>
                                            {{ $jobContract->worker->user->first_name . ' ' . $jobContract->worker->user->last_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Address</td>
                                        <td>
                                            {{ $jobContract->worker->address }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Email</td>
                                        <td>
                                            {{ $jobContract->worker->user->email }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Phone Number</td>
                                        <td>
                                            +({{ $jobContract->worker->country_code }})
                                            {{ $jobContract->worker->contact_number }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Contract Wallet</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Worker Progress</div>
                </div>
                <div class="card-body">
                    <div class="profile-timeline">
                        <div class="accordion accordion-flush " id="accordionFlushExample">
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
                                                <h6 class="fs-14 mb-0 fw-semibold">Preparing</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
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
                                                <h6 class="fs-14 mb-0 fw-semibold">On the Way</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
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
                                                <h6 class="fs-14 mb-0 fw-semibold">Arriving</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
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
                                                <h6 class="fs-14 mb-0 fw-semibold">Arrived</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
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
                                                <h6 class="fs-14 mb-0 fw-semibold">Working</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="accordion-item border-0">
                                <div class="accordion-header" id="headingFive">
                                    <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse"
                                        href="#collapseFile" aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 avatar-xs">
                                                <div class="avatar-title bg-light text-success rounded-circle">
                                                    <i class="ri-checkbox-blank-circle-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fs-14 mb-0 fw-semibold">Completed</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!--end accordion-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
