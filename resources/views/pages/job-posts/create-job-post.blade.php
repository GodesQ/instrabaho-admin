@extends('layouts.master')

@section('title', 'Create Job Post')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/libs/filepond/filepond.min.css') }}" type="text/css" />
    <link rel="stylesheet"
        href="{{ URL::asset('build/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">

    <style>
        .choices {
            margin-bottom: 0 !important;
        }
    </style>
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1')
            Pages
        @endslot
        @slot('title')
            Add Job Post
        @endslot
    @endcomponent

    <form action="{{ route('job-posts.store') }}" method="post" id="job-post-form" novalidate>
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">Add Job Post</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <a href="{{ route('job-posts.index') }}" class="btn btn-dark""><i
                                            class="ri-arrow-go-back-line align-bottom me-1"></i> Back to List</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                There's an error in your form!
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="title-field" class="form-label">Client</label>
                                    <select class="form-control @error('service_id') is-invalid @enderror"
                                        data-plugin="choices" data-choices data-choices-search-true id="service-field"
                                        name="creator_id">
                                        <option value="" selected>Select Client</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">
                                                {{ $client->user->first_name . ' ' . $client->user->last_name }}
                                                ({{ $client->user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="title-field" class="form-label">Service</label>
                                    <select class="form-control @error('service_id') is-invalid @enderror"
                                        data-plugin="choices" data-choices data-choices-search-true id="service-field"
                                        name="service_id">
                                        <option value="" selected>Select Job Service</option>
                                        @foreach ($jobServices as $jobService)
                                            <option value="{{ $jobService->id }}">{{ $jobService->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="description-field" class="form-label">Description</label>
                                    <textarea rows="5" name="description" id="description"
                                        placeholder="Short description about your job service request..." class="form-control"></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="notes-field" class="form-label">Notes</label>
                                    <textarea rows="5" name="notes" id="description" class="form-control"
                                        placeholder="If you have any additional inputs or information."></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="transaction-type-field" class="form-label">Transaction Type</label>
                                    <select class="form-control @error('transaction_type') is-invalid @enderror"
                                        data-plugin="choices" data-choices data-choices-search-false
                                        id="transaction-type-field" name="transaction_type">
                                        <option value="fixed">Fixed</option>
                                        <option value="hourly">Hourly</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            {{-- <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="price-amount-field" class="form-label">Price Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="number" class="form-control" id="price-amount-field"
                                            placeholder="0.00" name="price_amount">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="job-duration-field" class="form-label">Job Duration</label>
                                    <input type="text" class="form-control" id="job-duration-field" maxlength="20"
                                        placeholder="1 Day" name="job_duration">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="urgency-field" class="form-label">Urgency</label>
                                    <select class="form-control @error('transaction_type') is-invalid @enderror"
                                        data-plugin="choices" data-choices data-choices-search-false id="urgency-field"
                                        name="urgency">
                                        <option value="book_now">Book Now</option>
                                        <option value="scheduled">Scheduled</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="urgency-other-field-div mb-3" style="display: none;">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="scheduled-date-field" class="form-label">Scheduled Date</label>
                                            <input type="text" class="form-control" id="scheduled-date-field"
                                                data-provider="flatpickr" data-range="false" name="scheduled_date"
                                                placeholder="Select date">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="scheduled-date-field" class="form-label">Scheduled Time</label>
                                            <input type="text" class="form-control" id="scheduled-time-field"
                                                data-provider="timepickr" data-time-basic="true" name="scheduled_time"
                                                data-enabled-time="true" placeholder="Select time">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="attachment-field" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address-field" name="address">
                                    <div class="invalid-feedback"></div>
                                    <input type="hidden" name="latitude" id="latitude-field">
                                    <input type="hidden" name="longitude" id="longitude-field">
                                </div>
                                <div id="map"></div>
                            </div>
                        </div>

                        <div class="card border">
                            <div class="card-header">Job Attachments</div>
                            <div class="card-body">
                                <input type="file" class="filepond" data-allow-reorder="true"
                                    id="job-attachments-field" multiple data-max-file-size="3MB" data-max-files="3">
                            </div>
                            <div class="invalid-feedback"></div>
                            {{-- <div class="text-muted ml-3">Max File: 3</div> --}}
                        </div>

                        <div class="form-check mb-2">
                            <input value="pending" class="form-check-input" type="radio" name="status"
                                id="status1">
                            <label class="form-check-label" for="status1">
                                Pending
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input value="published" class="form-check-input" type="radio" name="status"
                                id="status2" checked>
                            <label class="form-check-label" for="status2">
                                Published
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input value="blocked" class="form-check-input" type="radio" name="status"
                                id="status3">
                            <label class="form-check-label" for="status2">
                                Blocked
                            </label>
                        </div>
                    </div>
                    <div class="card-footer d-flex gap-2 justify-content-end">
                        <a href="{{ route('job-posts.index') }}" class="btn btn-dark ml-3">Back to List</a>
                        <button type="submit" class="btn btn-primary" id="submit-btn">Submit Job Post</button>
                    </div>
                </div>
            </div>
    </form>

@endsection

@push('scripts')
    <script src="{{ URL::asset('build/libs/filepond/filepond.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}">
    </script>
    <script
        src="{{ URL::asset('build/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script
        src="{{ URL::asset('build/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}">
    </script>
    <script src="{{ URL::asset('build/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoQm26OBHgxVPf6LRRwcS33gccHt4rHnQ&loading=async&libraries=places&callback=initMap">
    </script>
    <script>
        function initMap() {

            var mapOptions, map, marker, searchBox, city,
                infoWindow = '',
                addressEl = document.querySelector('#address-field'),
                latEl = document.querySelector('#latitude-field'),
                longEl = document.querySelector('#longitude-field');

            searchBox = new google.maps.places.SearchBox(addressEl);

            google.maps.event.addListener(searchBox, 'places_changed', function() {

                var places = searchBox.getPlaces(),
                    bounds = new google.maps.LatLngBounds(),
                    i, place, lat, long, resultArray,
                    address = places[0].formatted_address;

                if (places.length == 0) return;

                place = places[0];

                lat = place.geometry.location.lat();
                long = place.geometry.location.lng();
                latEl.value = lat;
                longEl.value = long;

                resultArray = places[0].address_components;
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#urgency-field').change(function() {
                if ($(this).val() === 'scheduled') {
                    $('.urgency-other-field-div').show();
                } else {
                    $('.urgency-other-field-div').hide();
                }
            });
        });
    </script>

    <script>
        var pond;

        $('#job-post-form').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(e.target);

            const files = pond.getFiles();
            if (files.length > 0) {
                files.forEach(fileData => {
                    formData.append('job_attachments[]', fileData.file);
                });
            }

            formData.delete("job_attachments_filename");

            let submitBtn = document.querySelector('#submit-btn');

            submitBtn.setAttribute("disabled", true);

            handleRemoveFieldsError();

            $.ajax({
                url: "{{ route('job-posts.store') }}",
                method: 'POST',
                headers: {
                    'Accept': "application/json",
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    submitBtn.removeAttribute("disabled");
                    location.href = "/job-posts";
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

        const jobAttachmentsField = document.querySelector(
            "#job-attachments-field"
        );

        FilePond.registerPlugin(
            // encodes the file as base64 data
            FilePondPluginFileEncode,
            // validates the size of the file
            FilePondPluginFileValidateSize,
            // corrects mobile image orientation
            FilePondPluginImageExifOrientation,
            // previews dropped images
            FilePondPluginImagePreview
        );
        pond = FilePond.create(jobAttachmentsField, {
            name: "job_attachments_filename",
            labelIdle: 'Drag & Drop your files or <span class="filepond--label-action">Browse</span>',
            acceptedFileTypes: ["image/*"],
            required: true,
            allowMultiple: true,
        });

        $(document).ready(function() {
            const scheduledGroupField = document.querySelector('#scheduled-group-field');
            const checkbox = document.querySelector('#is-scheduled-checkbox');

            const toggleVisibility = () => {
                scheduledGroupField.style.display = checkbox.checked ? 'block' : 'none';
            };

            // Initial state
            toggleVisibility();

            // Handle checkbox changes
            checkbox.addEventListener('change', toggleVisibility);
        });
    </script>
@endpush
