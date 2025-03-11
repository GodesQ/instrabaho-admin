<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Create Contract</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-4 overflow-hidden">

        <div data-simplebar style="height: calc(100vh - 112px);">
            <p>This section allows job contracts to be proposed before finalization, enabling clients and workers to
                review and agree on terms before acceptance.</p>
            <form action="{{ route('job-contracts.store') }}" method="post" id="contract-form">
                @csrf
                <input type="hidden" name="proposal_id" id="proposal-id-field" value="{{ $jobProposal->id }}">
                <input type="hidden" name="client_id" id="client-id-field"
                    value="{{ $jobProposal->job_post->job_creator->id }}">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="contract-amount-field" class="form-label">Contract Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" class="form-control" id="offer-amount-field" placeholder="0.00"
                                    name="contract_amount" id="contract-amount-field"
                                    value="{{ $jobProposal->offer_amount }}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="border border-dashed p-2 mb-3">
                            <h5>Payment Summary</h5>
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <td>Service Fee Percentage:</td>
                                        <td>5%</td>
                                    </tr>
                                    <tr>
                                        <td>Sub Amount:</td>
                                        <td>
                                            ₱ <span id="contract-amount-text">{{ $jobProposal->offer_amount }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Service Fee Amount:</td>
                                        <td>
                                            ₱ <span id="service-fee-text">0</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Amount:</td>
                                        <td>₱ <span id="total-amount-text"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="contract-amount-field" class="form-label">Payment Type</label>
                            <input type="text" class="form-control" id="payment-type-field" name="payment_type"
                                value="Fixed Price" disabled>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="form-check form-check-outline form-check-primary mb-3">
                                <input class="form-check-input" type="checkbox" id="formCheck13"
                                    name="is_worker_approved">
                                <label class="form-check-label" for="formCheck13">
                                    Worker Approved
                                </label>
                                <div class="invalid-feedback mb-2"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-check-outline form-check-primary mb-3">
                                <input class="form-check-input" type="checkbox" id="formCheck14"
                                    name="is_client_approved">
                                <label class="form-check-label" for="formCheck14">
                                    Client Approved
                                </label>
                                <div class="invalid-feedback mb-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-top py-3">
                    <div class="form-group">
                        <div class="form-check form-check-outline form-check-primary mb-3">
                            <input class="form-check-input" type="checkbox" id="formCheck15"
                                name="approved_terms_conditions">
                            <label class="form-check-label" for="formCheck15">
                                Agree on <a href="#" class="text-primary">Terms & Conditions</a>
                            </label>
                            <div class="invalid-feedback mb-2"></div>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100" id="submit-contract-btn">Submit & Save Contract</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $("#contract-amount-field").on('input', (e) => {
            $("#contract-amount-text").text(e.target.value);
        })

        const computeContractAmount = () => {
            let contractAmountField = document.querySelector('#contract-amount-field');
            let processingFeeText = document.querySelector('#contract-amount-text');
            let totalAmountText = document.querySelector('#total-amount-text');

            let processingFeePercent = .05; // 5%



        }

        $('#contract-form').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(e.target);
            let url = e.target.getAttribute('action');
            let submitContractBtn = document.getElementById('submit-contract-btn');

            handleRemoveFieldsError();
            axios.post(url, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                })
                .then(response => {
                    let {
                        job_contract,
                        url
                    } = response.data;

                    submitContractBtn.removeAttribute("disabled");
                    showToastSuccessMessage(
                        `Contract - ${job_contract.contract_code_number} created successfully!`
                    );
                    setTimeout(() => {
                        location.href = url;
                    }, 1000);
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        const errors = error.response.data.errors;
                        handleFieldsError(errors);
                    }
                    showToastErrorMessage(error.response?.data?.message ??
                        "Submission Failed. Please try again later.");

                    submitContractBtn.removeAttribute("disabled");
                });
        });
    </script>
@endpush
