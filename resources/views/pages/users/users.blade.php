@extends('layouts.master')

@section('title', 'Users')

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pages
        @endslot
        @slot('title')
            Users
        @endslot
    @endcomponent

    <div class="card" id="userList">
        <div class="card-header border-bottom-dashed">
            <div class="row g-4 align-items-center">
                <div class="col-sm">
                    <div>
                        <h5 class="card-title mb-0">User List</h5>
                    </div>
                </div>
                <div class="col-sm-auto">
                    <div class="btn-group">
                        <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i
                                class="ri-delete-bin-2-line"></i></button>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Create
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <a href="{{ route('workers.create') }}" class="dropdown-item" href="#">Worker</a>
                                <a href="{{ route('customers.create') }}" class="dropdown-item" href="#">Customer</a>
                            </div>
                        </div>

                        @if (config('app.env') === 'development')
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#import-workers">
                                <i class="ri-file-upload-line align-bottom me-1"></i>
                                Import Workers
                            </button>
                            <div id="import-workers" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
                                aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <form id="import-workers-form" action="{{ route('workers.import') }}" method="post"
                                        enctype="multipart/form-data">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="myModalLabel">Import Workers</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @csrf
                                                <input type="file" class="form-control" id="import-workers-file"
                                                    name="import-workers-file">
                                                <div class="form-text text-muted">
                                                    Only .csv files are allowed.
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" id="import-workers-btn" class="btn btn-primary ">Save
                                                    Changes</button>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </form>
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                        @endif
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
                <table class="table align-middle w-100" id="users-table">
                    <thead class="table-light text-muted">
                        <tr>
                            <th class="sort" data-sort="id">Id</th>
                            <th class="sort" data-sort="username">Username</th>
                            <th class="sort" data-sort="email">Email</th>
                            <th class="sort" data-sort="name">Name</th>
                            <th class="sort" data-sort="name">Roles</th>
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
        $('#users-table').on('draw.dt', function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

            $('.remove-item-btn').click(function() {
                console.log(true);
                var id = $(this).attr('id');

                showDeleteMessage({
                    message: 'Deleting this user will remove all of the information from our database.',
                    deleteFunction: function() {
                        $.ajax({
                            url: '/backend/users/' + id,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                showSuccessMessage(response.message);
                                $('#users-table').DataTable()
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
                    data: "roles",
                    name: "roles",
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

            let table = $("#users-table").DataTable({
                processing: true,
                searching: false,
                lengthChange: false,
                ordering: false,
                pageLength: 10,
                responsive: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('users.index') }}",
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

            $('#import-workers-form').submit(async function(e) {
                e.preventDefault();
                let formData = new FormData(e.target);
                let url = e.target.getAttribute('action');
                let importWorkersBtn = document.getElementById('import-workers-btn');
                importWorkersBtn.setAttribute("disabled", true);
                try {
                    let response = await fetch(url, {
                        method: "POST",
                        body: formData,
                    });

                    let data = await response.json();
                    showToastSuccessMessage("Import Successfully!");

                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } catch (error) {
                    showToastErrorMessage("Import Failed!");
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            })
        });
    </script>
@endpush
