@extends('layouts.master')

@section('title', 'Customers')

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pages
        @endslot
        @slot('title')
            Customers
        @endslot
    @endcomponent

    <div class="card" id="customerList">
        <div class="card-header border-bottom-dashed">
            <div class="row g-4 align-items-center">
                <div class="col-sm">
                    <div>
                        <h5 class="card-title mb-0">Customer List</h5>
                    </div>
                </div>
                <div class="col-sm-auto">
                    <div class="d-flex flex-wrap align-items-start gap-2">
                        <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i
                                class="ri-delete-bin-2-line"></i></button>
                        <a href="{{ route('customers.create') }}" class="btn btn-primary""><i
                                class="ri-add-line align-bottom me-1"></i> Add
                            Customer</a>
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
                            <input type="text" class="form-control" id="customer-search" placeholder="Search Customer">
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
