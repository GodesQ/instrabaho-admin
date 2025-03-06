<style>
    .choices {
        margin-bottom: 5px !important;
    }
</style>

<div id="proposalModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('job-proposals.store') }}" class="modal-content" id="job-proposal-store">
            @csrf
            <input type="hidden" name="job_post_id" id="job-post-id-field" value="{{ $jobPost->id }}">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Add Proposal for
                    {{ $jobPost->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="proposal-title-field" class="form-label">Worker</label>
                            <select class="form-control" data-plugin="choices" data-choices data-choices-search-true
                                id="worker-field" name="worker_id">
                                <option value="" selected>Select Worker</option>
                                @foreach ($jobPost->ranked_workers as $key => $rankedWorker)
                                    <option value="{{ $rankedWorker->worker->id }}">
                                        {{ $rankedWorker->worker->user->first_name }}
                                        {{ $rankedWorker->worker->user->last_name }}
                                        ({{ $rankedWorker->worker->user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                            <input type="hidden" name="address" id="worker-proposal-address-field">
                            <input type="hidden" name="latitude" id="worker-proposal-latitude-field">
                            <input type="hidden" name="longitude" id="worker-proposal-longitude-field">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="offer-amount-field" class="form-label">Offer
                                Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" class="form-control" id="offer-amount-field" placeholder="0.00"
                                    name="offer_amount">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="details-field" class="form-label">Details</label>
                            <textarea name="details" class="form-control" id="details-field" placeholder="Place other details here..."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="status-field" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" data-plugin="choices"
                                data-choices data-choices-search-true id="status-field" name="status">
                                <option value="" selected>Select Status</option>
                                <option value="draft">Draft</option>
                                <option value="submitted" selected>Submitted</option>
                                <option value="approved">Approved</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="proposal-submit-btn">Save Changes</button>
            </div>

        </form><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@push('scripts')
    <script>
        $("#worker-field").change(function(e) {
            let workerId = e.target.value;
            $.ajax({
                method: "GET",
                url: "/workers/" + workerId,
                success: function(data) {
                    $("#worker-proposal-address-field").val(data.worker.address);
                    $("#worker-proposal-latitude-field").val(data.worker.latitude);
                    $("#worker-proposal-longitude-field").val(data.worker.longitude);
                }
            });
        });

        $('#job-proposal-store').submit(function(e) {
            e.preventDefault();
            let url = e.target.getAttribute('action');
            let formData = new FormData(e.target);
            let submitBtn = document.querySelector('#proposal-submit-btn');

            submitBtn.setAttribute("disabled", true);
            $.ajax({
                url: url,
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    submitBtn.removeAttribute("disabled");
                    showToastSuccessMessage("Proposal submitted successfully!");
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                },
                error: function(xhr, textStatus, errorThrown) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        handleFieldsError(errors);
                    }
                    showToastErrorMessage((xhr?.responseJSON?.message ??
                        "Submission Failed. Please try again later."));

                    submitBtn.removeAttribute("disabled");
                }
            });
        })
    </script>
@endpush
