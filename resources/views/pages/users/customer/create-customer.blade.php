@extends('layouts.master')

@section('title', 'Create Customer')

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
            Add Customer
        @endslot
    @endcomponent

    <div class="card">
        <div class="card-header border-bottom-dashed">
            <div class="row g-4 align-items-center">
                <div class="col-sm">
                    <div>
                        <h5 class="card-title mb-0">Add Customer</h5>
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
                action="{{ route('customers.store') }}" enctype="multipart/form-data">
                @csrf

                @if ($user)
                    <input type="hidden" name="user_id" value="{{ $user->id }}" id="user-id-field" />
                @endif

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
                            <button class="nav-link" id="v-pills-customer-info-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-customer-info" type="button" role="tab"
                                aria-controls="v-pills-customer-info" aria-selected="false">
                                <span class="step-title me-2">
                                    <i class="ri-close-circle-fill step-icon me-2"></i> Step 3
                                </span>
                                Customer Info
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
                                                        placeholder="Enter first name"
                                                        value="{{ $user->first_name ?? null }}" required>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="middlename-field" class="form-label">Middle Name <span
                                                            class="text-muted">(Optional)</span></label>
                                                    <input type="text" class="form-control" id="middlename-field"
                                                        name="middle_name" placeholder="Enter middle name"
                                                        value="{{ $user->middle_name ?? null }}">
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="lastName" class="form-label">Last name</label>
                                                    <input type="text" class="form-control" id="lastName"
                                                        name="last_name" maxlength="50" placeholder="Enter last name"
                                                        value="{{ $user->last_name ?? null }}" required>
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
                                                            value="{{ $user->username ?? null }}" name="username">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="email-field" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email-field"
                                                        name="email" placeholder="Enter Email" required
                                                        value="{{ $user->email ?? null }}" />
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
                                                        <option value="">Selecte Gender</option>
                                                        <option
                                                            {{ ($user->profile->gender ?? null) == 'Male' ? 'selected' : null }}
                                                            value="Male">Male</option>
                                                        <option
                                                            {{ ($user->profile->gender ?? null) == 'Female' ? 'selected' : null }}
                                                            value="Female">Female</option>
                                                        <option
                                                            {{ ($user->profile->gender ?? null) == 'Other' ? 'selected' : null }}
                                                            value="Other">Other</option>
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
                                                        placeholder="" name="latitude"
                                                        value="{{ $user->profile->latitude ?? null }}" />
                                                    <div class="invalid-feedback"></div>
                                                </div>

                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="longitude-field" class="form-label">Longitude</label>
                                                    <input type="text" class="form-control" id="longitude-field"
                                                        placeholder="" name="longitude"
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
                                            data-nexttab="v-pills-customer-info-tab"><i
                                                class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go
                                            to Customer Info</button>
                                    </div>
                                </div>
                                <!-- end tab pane -->
                                <div class="tab-pane fade" id="v-pills-customer-info" role="tabpanel"
                                    aria-labelledby="v-pills-customer-info-tab">
                                    <div>
                                        <h5>Customer Info</h5>
                                        <p class="text-muted">Fill all information below</p>
                                    </div>


                                    <div class="row gy-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="customer-type-field" class="form-label">Customer Type</label>
                                                <select class="form-control" data-plugin="choices" data-choices
                                                    data-choices-search-false id="customer-type-field"
                                                    name="customer_type">
                                                    <option value="">Selecte Customer Type</option>
                                                    <option value="Individual" selected>Individual</option>
                                                    <option value="Business">Business</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 customer-individual-grp">
                                            <div class="form-group">
                                                <label for="facebook-url-field" class="form-label">Facebook URL</label>
                                                <input type="text" class="form-control" id="facebook-url-field"
                                                    name="facebook_url" placeholder="">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 customer-individual-grp">
                                            <div class="form-group">
                                                <label for="occupation-field" class="form-label">Occupation</label>
                                                <input type="text" class="form-control" id="occupation-field"
                                                    name="occupation" placeholder="Job title or role">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 customer-business-grp">
                                            <div class="form-group">
                                                <label for="company-name-field" class="form-label">Company Name</label>
                                                <input type="text" class="form-control" id="company-name-field"
                                                    name="company_name">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 customer-business-grp">
                                            <div class="form-group">
                                                <label for="company-website-field" class="form-label">Company
                                                    Website</label>
                                                <input type="text" class="form-control" id="company-website-field"
                                                    name="company_website">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 customer-business-grp">
                                            <div class="form-group">
                                                <label for="industry-field" class="form-label">Industry</label>
                                                <input type="text" class="form-control" id="industry-field"
                                                    name="industy">
                                                <div class="invalid-feedback"></div>
                                            </div>
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
                                            Submit New Customer</button>
                                    </div>
                                </div>
                                <!-- end tab pane -->
                                {{-- <div class="tab-pane fade" id="v-pills-finish" role="tabpanel"
                                    aria-labelledby="v-pills-finish-tab">
                                    <div class="text-center pt-4 pb-2">

                                        <div class="mb-4">
                                            <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop"
                                                colors="primary:#0ab39c,secondary:#405189"
                                                style="width:120px;height:120px"></lord-icon>
                                        </div>
                                        <h5>Your Order is Completed !</h5>
                                        <p class="text-muted">You Will receive an order confirmation email with
                                            details of your order.</p>
                                    </div>
                                </div> --}}
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
    <script src="{{ URL::asset('build/js/custom-js/client-form.js') }}"></script>
    <script>
        var pond;

        $('#worker-form').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(e.target);

            formData.delete("identification_filename");

            let submitBtn = document.querySelector('#submit-worker-btn');

            submitBtn.setAttribute("disabled", true);

            handleRemoveFieldsError();

            $.ajax({
                url: "{{ route('customers.store') }}",
                method: 'POST',
                headers: {
                    'Accept': "application/json",
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    console.log(data);
                    submitBtn.removeAttribute("disabled");

                    location.href = `/backend/customers/${data?.user?.id}/edit`;

                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(xhr);
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


        const controlCustomerTypeField = (customer_type) => {
            if (customer_type === "Individual") {
                $('.customer-individual-grp').show();
                $('.customer-business-grp').hide();
            } else {
                $('.customer-individual-grp').hide();
                $('.customer-business-grp').show();
            }
        }

        $(document).ready(function() {
            controlCustomerTypeField($('#customer-type-field').val());
        })

        $('#customer-type-field').change(function(e) {
            controlCustomerTypeField(e.target.value);
        })

        setupFilePond();
    </script>
@endsection
