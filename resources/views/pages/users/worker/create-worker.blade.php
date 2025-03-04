@extends('layouts.master')

@section('title', 'Create Worker')

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
            Add Worker
        @endslot
    @endcomponent

    <div class="card">
        <div class="card-header border-bottom-dashed">
            <div class="row g-4 align-items-center">
                <div class="col-sm">
                    <div>
                        <h5 class="card-title mb-0">Add Worker</h5>
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
                action="{{ route('workers.store') }}" enctype="multipart/form-data">
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
                            {{-- <button class="nav-link" id="v-pills-finish-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-finish" type="button" role="tab"
                                aria-controls="v-pills-finish" aria-selected="false">
                                <span class="step-title me-2">
                                    <i class="ri-close-circle-fill step-icon me-2"></i> Step 4
                                </span>
                                Finish
                            </button> --}}
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
                                                        placeholder="Enter first name" value="">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="middlename-field" class="form-label">Middle Name <span
                                                            class="text-muted">(Optional)</span></label>
                                                    <input type="text" class="form-control" id="middlename-field"
                                                        name="middle_name" placeholder="Enter middle name" value="">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="lastName" class="form-label">Last name</label>
                                                    <input type="text" class="form-control" id="lastName"
                                                        name="last_name" maxlength="50" placeholder="Enter last name"
                                                        value="">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="username-field" class="form-label">Username</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">@</span>
                                                        <input type="text" class="form-control" id="username-field"
                                                            maxlength="20" placeholder="Username"
                                                            name="username">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="email-field" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email-field"
                                                        name="email" placeholder="Enter Email" />
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
                                                            value="" placeholder="Enter number"
                                                            name="contact_number"
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
                                                        <option value="">Selecte Gender</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="address2" class="form-label">Date of Birth<span
                                                            class="text-muted">(Optional)</span></label>
                                                    <input type="text" class="form-control" id="birthdate-field"
                                                        max="today" data-provider="flatpickr" data-range="false"
                                                        name="birthdate" placeholder="Select date">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="address-field" class="form-label">Address</label>
                                                    <input type="text" class="form-control" id="address-field"
                                                        placeholder="" name="address" />
                                                    <div class="invalid-feedback"></div>
                                                </div>

                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="latitude-field" class="form-label">Latitude</label>
                                                    <input type="text" class="form-control" id="latitude-field"
                                                        placeholder="" name="latitude" />
                                                    <div class="invalid-feedback"></div>
                                                </div>

                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="longitude-field" class="form-label">Longitude</label>
                                                    <input type="text" class="form-control" id="longitude-field"
                                                        placeholder="" name="longitude" />
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
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="hourly-rate-field" class="form-label">Hourly Rate</label>
                                                    <input type="text" class="form-control" id="hourly-rate-field"
                                                        name="hourly_rate" placeholder="">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="description-field" class="form-label">Personal
                                                        Description</label>
                                                    <textarea name="personal_description" id="description-field" cols="30" rows="5" class="form-control"></textarea>
                                                    <div class="invalid-feedback"></div>
                                                </div>

                                            </div>

                                            <div class="col-lg-12">
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
                                            </div> <!-- end col -->
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
                                            Submit New Worker</button>
                                    </div>
                                </div>
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
    <script src="{{ URL::asset('js/worker-form.js') }}"></script>
    <script>
        var identificationPond;
        var certificatePond;

        $('#worker-form').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(e.target);

            const identificationFiles = identificationPond.getFiles();
            if (identificationFiles.length > 0) {
                formData.append('identification_file', identificationFiles[0].file);
            }

            const certificateFiles = certificatePond.getFiles();
            if (certificateFiles.length > 0) {
                formData.append('certificate_file', certificateFiles[0].file);
            }

            formData.delete("identification_filename");
            formData.delete("certificate_filename");

            let submitBtn = document.querySelector('#submit-worker-btn');

            submitBtn.setAttribute("disabled", true);

            handleRemoveFieldsError();

            $.ajax({
                url: "{{ route('workers.store') }}",
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
                    location.href = "/backend/users";

                },
                error: function(xhr, textStatus, errorThrown) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        navigateToInvalidFieldTab(errors);
                        handleFieldsError(errors);
                    }
                    showToastErrorMessage((xhr?.responseJSON?.message ??
                        "Submission Failed. Please try again later."));

                    submitBtn.removeAttribute("disabled");
                }
            });
        });

        setupFilePond();
    </script>
@endsection
