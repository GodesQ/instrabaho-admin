<div class="border border-dashed p-3">
    <div class="card">
        <div class="card-header pb-1" style="border: none;">
            <div class="row g-4 align-items-center justify-between">
                <div class="col-sm">
                    <h2>
                        Instrabaho Contract
                    </h2>
                </div>
                @if (!isset($isDownload))
                    <div class="col-sm-auto">
                        <div class="btn btn-group">
                            <a href="{{ route('job-contracts.download', $jobContract->id) }}" id="{{ $jobContract->id }}"
                                class="btn btn-sm btn-secondary""><i class="ri-download-line align-bottom me-1"></i>
                                Download</a>
                            <button href="#" id="{{ $jobContract->id }}" class="btn btn-sm btn-primary""><i
                                    class="ri-printer-line align-bottom me-1"></i> Print</a>
                        </div>
                    </div>
                @endif
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
