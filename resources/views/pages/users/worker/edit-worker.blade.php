@extends('layouts.master')

@section('title', 'Edit Worker')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/libs/filepond/filepond.min.css') }}" type="text/css" />
    <link rel="stylesheet"
        href="{{ URL::asset('build/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pages
        @endslot
        @slot('title')
            Edit Worker
        @endslot
    @endcomponent

    <div class="card">
        <div class="card-header border-bottom-dashed">
            <div class="row g-4 align-items-center">
                <div class="col-sm">
                    <div>
                        <h5 class="card-title mb-0">Edit Worker</h5>
                    </div>
                </div>
                <div class="col-sm-auto">
                    <div class="d-flex flex-wrap align-items-start gap-2">
                        <a href="{{ route('users.index') }}" class="btn btn-dark""><i
                                class="ri-arrow-go-back-line align-bottom me-1"></i> Back to List</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form class="vertical-navs-step form-steps" method="POST" novalidate id="worker-form"
                action="{{ route('workers.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row gy-5">
                    <div class="col-lg-3">
                        <div class="nav flex-column custom-nav nav-pills" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-account-info-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-account-info" type="button" role="tab"
                                aria-controls="v-pills-account-info" aria-selected="true">
                                <span class="step-title me-2">
                                    <i class="ri-close-circle-fill step-icon me-2"></i> Step 1
                                </span>
                                Account Info
                            </button>
                            <button class="nav-link " id="v-pills-profile-info-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-profile-info" type="button" role="tab"
                                aria-controls="v-pills-profile-info" aria-selected="false">
                                <span class="step-title me-2">
                                    <i class="ri-close-circle-fill step-icon me-2"></i> Step 2
                                </span>
                                Profile Info
                            </button>
                            <button class="nav-link" id="v-pills-worker-info-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-worker-info" type="button" role="tab"
                                aria-controls="v-pills-worker-info" aria-selected="false">
                                <span class="step-title me-2">
                                    <i class="ri-close-circle-fill step-icon me-2"></i> Step 3
                                </span>
                                Worker Info
                            </button>
                            <button class="nav-link" id="v-pills-worker-service-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-worker-service" type="button" role="tab"
                                aria-controls="v-pills-worker-service" aria-selected="false">
                                <span class="step-title me-2">
                                    <i class="ri-close-circle-fill step-icon me-2"></i> Step 4
                                </span>
                                Worker Service
                            </button>
                        </div>
                        <!-- end nav -->
                    </div> <!-- end col-->
                    <div class="col-lg-9">
                        <div class="px-lg-4">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="v-pills-account-info" role="tabpanel"
                                    aria-labelledby="v-pills-bill-info-tab">
                                    <div>
                                        <h5>Account Info</h5>
                                        <p class="text-muted">Fill all information below</p>
                                    </div>

                                    <div>
                                        <div class="row g-3">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="firstname-field" class="form-label">First Name</label>
                                                    <input type="text" class="form-control" maxlength="50"
                                                        id="firstname-field" name="first_name"
                                                        placeholder="Enter first name" value="{{ $user->first_name }}"
                                                        required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="middlename-field" class="form-label">Middle Name <span
                                                            class="text-muted">(Optional)</span></label>
                                                    <input type="text" class="form-control" id="middlename-field"
                                                        name="middle_name" placeholder="Enter first name"
                                                        value="{{ $user->middle_name }}">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="lastName" class="form-label">Last name</label>
                                                    <input type="text" class="form-control" id="lastName"
                                                        name="last_name" maxlength="50" placeholder="Enter last name"
                                                        value="{{ $user->last_name }}" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="username-field" class="form-label">Username</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">@</span>
                                                        <input type="text" class="form-control" id="username-field"
                                                            maxlength="20" placeholder="Username" required
                                                            value="{{ $user->username }}" name="username">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="email-field" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email-field"
                                                        name="email" placeholder="Enter Email"
                                                        value="{{ $user->email }}" required />
                                                    <div class="invalid-feedback"></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <button type="button"
                                            class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                            data-nexttab="v-pills-profile-info-tab"><i
                                                class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go
                                            to Profile</button>
                                    </div>
                                </div>
                                <!-- end tab pane -->
                                <div class="tab-pane fade" id="v-pills-profile-info" role="tabpanel"
                                    aria-labelledby="v-pills-profile-info-tab">
                                    <div>
                                        <h5>Profile Info</h5>
                                        <p class="text-muted">Fill all information below</p>
                                    </div>

                                    <div>
                                        <div class="row g-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="contact-number-field" class="form-label">Contact
                                                        Number</label>
                                                    <div class="input-group" data-input-flag>
                                                        <button class="btn btn-light border disabled" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false"><img
                                                                src="{{ URL::asset('build/images/flags/ph.svg') }}"
                                                                alt="flag img" height="20"
                                                                class="country-flagimg rounded"><span
                                                                class="ms-2 country-codeno">+63</span></button>
                                                        <input type="hidden" name="country_code" id="country-code-value"
                                                            value="+63">
                                                        <input type="text" class="form-control rounded-end flag-input"
                                                            value="{{ $user->profile->contact_number ?? null }}"
                                                            placeholder="Enter number" name="contact_number"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1'); console.log(this.value)" />
                                                        <div class="dropdown-menu w-100">
                                                            <div class="p-2 px-3 pt-1 searchlist-input">
                                                                <input type="text"
                                                                    class="form-control form-control-sm border search-countryList"
                                                                    placeholder="Search country name or country code..." />
                                                            </div>
                                                            <ul class="list-unstyled dropdown-menu-list mb-0"></ul>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="address2" class="form-label">Gender<span
                                                            class="text-muted">(Optional)</span></label>
                                                    <select class="form-control" data-plugin="choices" data-choices
                                                        data-choices-search-false id="gender-select-field" name="gender">
                                                        <option value="">Select Gender</option>
                                                        <option value="Male"
                                                            {{ ($user->profile->gender ?? null) == 'Male' ? 'selected' : null }}>
                                                            Male
                                                        </option>
                                                        <option value="Female"
                                                            {{ ($user->profile->gender ?? null) == 'Female' ? 'selected' : null }}>
                                                            Female</option>
                                                        <option value="Other"
                                                            {{ ($user->profile->gender ?? null) == 'Other' ? 'selected' : null }}>
                                                            Other</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="address2" class="form-label">Date of Birth<span
                                                            class="text-muted">(Optional)</span></label>
                                                    <input type="text" class="form-control" id="birthdate-field"
                                                        max="today" data-provider="flatpickr" data-range="false"
                                                        name="birthdate" placeholder="Select date"
                                                        value="{{ $user->profile->birthdate ?? null }}">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="address-field" class="form-label">Address</label>
                                                    <input type="text" class="form-control" id="address-field"
                                                        placeholder="" name="address"
                                                        value="{{ $user->profile->address ?? null }}" />
                                                    <div class="invalid-feedback"></div>
                                                </div>

                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="latitude-field" class="form-label">Latitude</label>
                                                    <input type="text" class="form-control" id="latitude-field"
                                                        placeholder="" name="latitude" readonly
                                                        value="{{ $user->profile->latitude ?? null }}" />
                                                    <div class="invalid-feedback"></div>
                                                </div>

                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="longitude-field" class="form-label">Longitude</label>
                                                    <input type="text" class="form-control" id="longitude-field"
                                                        placeholder="" name="longitude" readonly
                                                        value="{{ $user->profile->longitude ?? null }}" />
                                                    <div class="invalid-feedback"></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <button type="button" class="btn btn-light btn-label previestab"
                                            data-previous="v-pills-account-info-tab"><i
                                                class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                            Back to Account Info</button>
                                        <button type="button"
                                            class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                            data-nexttab="v-pills-worker-info-tab"><i
                                                class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go
                                            to Worker Info</button>
                                    </div>
                                </div>
                                <!-- end tab pane -->
                                <div class="tab-pane fade" id="v-pills-worker-info" role="tabpanel"
                                    aria-labelledby="v-pills-worker-info-tab">
                                    <div>
                                        <h5>Worker Info</h5>
                                        <p class="text-muted">Fill all information below</p>
                                    </div>

                                    <div>

                                        <div class="row gy-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tagline-field" class="form-label">Tagline</label>
                                                    <input type="text" class="form-control" id="tagline-field"
                                                        name="tagline" placeholder=""
                                                        value="{{ $user->worker_details->tagline ?? null }}" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="hourly-rate-field" class="form-label">Hourly Rate</label>
                                                    <input type="text" class="form-control" id="hourly-rate-field"
                                                        name="hourly_rate" placeholder=""
                                                        value="{{ $user->worker_details->hourly_rate ?? null }}" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="description-field" class="form-label">Personal
                                                        Description</label>
                                                    <textarea name="personal_description" id="description-field" cols="30" rows="5" class="form-control">{{ $user->worker_details->personal_description ?? null }}</textarea>
                                                    <div class="invalid-feedback"></div>
                                                </div>

                                            </div>

                                            {{-- <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title mb-0">Identification Image Upload</h4>
                                                    </div><!-- end card header -->

                                                    <div class="card-body">
                                                        <p class="text-muted"></p>
                                                        <input type="file" class="filepond" data-allow-reorder="true"
                                                            id="identification-file-field" data-max-file-size="3MB"
                                                            data-max-files="1">
                                                    </div>
                                                    <!-- end card body -->
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div> <!-- end col --> --}}
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <button type="button" class="btn btn-light btn-label previestab"
                                            data-previous="v-pills-profile-info-tab"><i
                                                class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                            Back to Profile Info</button>
                                        <button type="submit" id="submit-worker-btn"
                                            class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                            data-nexttab="#"><i
                                                class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                            Update Worker</button>
                                    </div>
                                </div>
                                <!-- end tab pane -->
                                <div class="tab-pane fade" id="v-pills-worker-service" role="tabpanel"
                                    aria-labelledby="v-pills-worker-service-tab">
                                    <div>
                                        <h5>Worker Service</h5>
                                        <p class="text-muted">Fill all information below</p>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="service-select-field" class="form-label">Type of
                                                    Service</label>
                                                <select class="form-control" data-plugin="choices" data-choices
                                                    data-choices-search-true id="service-select-field" name="service_id">
                                                    <option value="">Select Service</option>
                                                    @foreach ($services as $service)
                                                        <option
                                                            {{ $service->id == $user->worker_service->service_id ? 'selected' : null }}
                                                            value="{{ $service->id }}">{{ $service->service_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="service-hourly-rate-field" class="form-label">Service
                                                    Hourly Rate</label>
                                                <input type="number" class="form-control" name="service_hourly_rate"
                                                    id="service-hourly-rate-field"
                                                    value="{{ $user->worker_service->hourly_rate }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-start gap-3 mt-4">
                                        <button type="button" class="btn btn-light btn-label previestab"
                                            data-previous="v-pills-worker-info-tab"><i
                                                class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                            Back to Worker Info</button>
                                        <button type="submit" id="submit-worker-btn"
                                            class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                            data-nexttab="#"><i
                                                class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                            Update Worker</button>
                                    </div>
                                </div>
                                <!-- end tab pane -->
                            </div>
                            <!-- end tab content -->
                        </div>
                    </div>
                    <!-- end col -->


                </div>
                <!-- end row -->
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('build/js/pages/form-wizard.init.js') }}"></script>
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
    {{-- <script src="{{ URL::asset('build/js/pages/form-file-upload.init.js') }}"></script> --}}
    {{-- <script src="{{ URL::asset('build/js/pages/flag-input.init.js') }}"></script> --}}
    <script src="{{ URL::asset('build/js/custom-js/worker-form.js') }}"></script>

    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBkEg-gEi37ABEp2EHxHMMEiYr_ZwdzQyg&loading=async&libraries=places&callback=initMap">
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
        var identificationPond;

        $('#worker-form').submit(function(e) {
            e.preventDefault();

            const formData = new FormData(e.target);

            // Add file from FilePond if exists
            const files = identificationPond.getFiles();
            if (files.length > 0) {
                formData.append('identification_file', files[0].file);
            }

            // Delete unnecessary fields if any
            formData.delete("identification_filename");

            // Convert FormData to JSON object
            let formObject = {};
            formData.forEach((value, key) => {
                formObject[key] = value;
            });

            let submitBtn = document.querySelector('#submit-worker-btn');
            submitBtn.setAttribute("disabled", true);

            handleRemoveFieldsError();
            let urlAction = e.target.getAttribute('action');

            $.ajax({
                url: urlAction,
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': "application/json",
                    'Content-Type': "application/json", // Set content type to JSON
                },
                processData: true, // Default, no need for formData processing
                data: JSON.stringify(formObject), // Convert object to JSON string
                success: function(data) {
                    console.log('Server response:', data);

                    submitBtn.removeAttribute("disabled");
                    showToastSuccessMessage(data.message ?? "Updated Successfully");
                },
                error: function(xhr, textStatus, errorThrown) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        navigateToInvalidFieldTab(errors);
                        handleFieldsError(errors);
                    } else {
                        showToastErrorMessage(xhr.responseJSON?.message ??
                            "Submission Failed. Please try again later.");
                    }

                    submitBtn.removeAttribute("disabled");
                }
            });
        });

        setupFilePond();
    </script>
@endsection
