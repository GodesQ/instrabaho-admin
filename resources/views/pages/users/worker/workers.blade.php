@extends('layouts.master')

@section('title', 'Workers')

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pages
        @endslot
        @slot('title')
            Workers
        @endslot
    @endcomponent

    <div class="card" id="workerList">
        <div class="card-header border-bottom-dashed">

            <div class="row g-4 align-items-center">
                <div class="col-sm">
                    <div>
                        <h5 class="card-title mb-0">Worker List</h5>
                    </div>
                </div>
                <div class="col-sm-auto">
                    <div class="d-flex flex-wrap align-items-start gap-2">
                        <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i
                                class="ri-delete-bin-2-line"></i></button>
                        <a href="{{ route('workers.create') }}" class="btn btn-primary""><i
                                class="ri-add-line align-bottom me-1"></i> Add
                            Worker</a>
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
                            <input type="text" class="form-control" id="datepicker-range" placeholder="Search Worker">
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
                <table class="table align-middle w-100" id="workers-table">
                    <thead class="table-light text-muted">
                        <tr>
                            <th class="sort" data-sort="id">Id</th>
                            <th class="sort" data-sort="username">Username</th>
                            <th class="sort" data-sort="email">Email</th>
                            <th class="sort" data-sort="name">Name</th>
                            <th class="sort" data-sort="created_at">Joining Date</th>
                            <th class="sort" data-sort="status">Status</th>
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
        $('#workers-table').on('draw.dt', function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

            $('.remove-item-btn').click(function() {
                console.log(true);
                var id = $(this).attr('id');

                showDeleteMessage({
                    message: 'Deleting this worker will remove all of the information from our database.',
                    deleteFunction: function() {
                        $.ajax({
                            url: '/backend/workers/' + id,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                showSuccessMessage(response.message);
                                $('#workers-table').DataTable()
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
                    data: "username",
                    name: "username"
                },
                {
                    data: "email",
                    name: "email",
                },
                {
                    data: "name",
                    name: "name",
                },
                {
                    data: "created_at",
                    name: "created_at",
                },
                {
                    data: "status",
                    name: "status",
                    orderable: false,
                    searchable: false,
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                },
            ];

            let table = $("#workers-table").DataTable({
                processing: true,
                searching: false,
                lengthChange: false,
                ordering: false,
                pageLength: 10,
                responsive: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('backend.workers.index') }}",
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
            console.log('Yahra');
            initializeTables();
        });
    </script>
@endpush
