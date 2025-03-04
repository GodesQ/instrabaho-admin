@extends('layouts.master')

@section('title', 'Service Categories')

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pages
        @endslot
        @slot('title')
            Service Category
        @endslot
    @endcomponent

    <div class="card" id="serviceCategoriesList">
        <div class="card-header border-bottom-dashed">
            <div class="row g-4 align-items-center">
                <div class="col-sm">
                    <div>
                        <h5 class="card-title mb-0">Service Category List</h5>
                    </div>
                </div>
                <div class="col-sm-auto">
                    <div class="d-flex flex-wrap align-items-start gap-2">
                        <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i
                                class="ri-delete-bin-2-line"></i></button>
                        <a href="{{ route('service-categories.create') }}" class="btn btn-primary""><i
                                class="ri-add-line align-bottom me-1"></i> Add Service Category</a>
                        <button type="button" class="btn btn-secondary"><i
                                class="ri-file-download-line align-bottom me-1"></i> Export as CSV</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body border-bottom-dashed border-bottom">
            <form>
                <div class="row g-3">
                    <div class="col-xl-6">
                        <div class="search-box">
                            <input type="text" class="form-control" id="user-search" placeholder="Search User">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-xl-6">
                        <div class="row g-3">
                            <div class="col-sm-4">
                                <div class="">
                                    <input type="text" class="form-control" id="datepicker-range"
                                        data-provider="flatpickr" data-range="true" placeholder="Select date">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-sm-4">
                                <div>
                                    <select class="form-control" data-plugin="choices" data-choices
                                        data-choices-search-false name="choices-single-default" id="idStatus">
                                        <option value="">Status</option>
                                        <option value="all" selected>All</option>
                                        <option value="Active">Active</option>
                                        <option value="Block">Block</option>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->

                            <div class="col-sm-4">
                                <div>
                                    <button type="button" class="btn btn-primary w-100" onclick="SearchData();"> <i
                                            class="ri-equalizer-fill me-2 align-bottom"></i>Filters</button>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                    </div>
                </div>
                <!--end row-->
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive-xl table-card mb-1">
                <table class="table align-middle w-100" id="service-categories-table">
                    <thead class="table-light text-muted">
                        <tr>
                            <th class="sort" data-sort="id">Id</th>
                            <th class="sort" data-sort="name">Title</th>
                            <th class="sort" data-sort="created_at">Created At</th>
                            <th class="sort" data-sort="action">Action</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#service-categories-table').on('draw.dt', function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

            $('.remove-item-btn').click(function() {
                console.log(true);
                var id = $(this).attr('id');

                showDeleteMessage({
                    message: 'Deleting this record will remove all of the information from our database.',
                    deleteFunction: function() {
                        $.ajax({
                            url: '/service-categories/' + id,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                showSuccessMessage(response.message);
                                $('#service-categories-table').DataTable()
                                    .draw(false);
                            },
                            error: function(xhr, response, error) {
                                showErrorMessage(xhr.statusText);
                            }
                        });
                    }
                });
            });
        });

        function initializeTables() {
            let columns = [{
                    data: "id",
                    name: "id",
                },
                {
                    data: "title",
                    name: "title"
                },
                {
                    data: "created_at",
                    name: "created_at",
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                },
            ];

            let table = $("#service-categories-table").DataTable({
                processing: true,
                searching: false,
                lengthChange: false,
                ordering: false,
                pageLength: 10,
                responsive: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('service-categories.index') }}",
                },
                columns: columns,
                language: {
                    emptyTable: `<div class="noresult">
                    <div class="text-center">
                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                            colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                        </lord-icon>
                        <h5 class="mt-2">Sorry! This table is empty</h5>
                        <p class="text-muted mb-0">No data available in table. Please add some records.</p>
                    </div>
                </div>`,
                    zeroRecords: `<div class="noresult">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" id="search-icon"
                                            colors="primary:#b4b4b4,secondary:#08a88a" style="width:75px;height:75px">
                                        </lord-icon>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                        <p class="text-muted mb-0">We've searched all of our records, We did not find any data for you search.</p>
                                    </div>
                                </div>`,
                },
                order: [
                    [0, "desc"], // Sort by the first column (index 0) in descending order
                ],
            });
        }

        $(document).ready(function() {
            initializeTables();
        });
    </script>
@endpush
