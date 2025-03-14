@extends('layouts.master')

@section('title', 'Create Service Category')

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pages
        @endslot
        @slot('title')
            Add Service Category
        @endslot
    @endcomponent

    <form class="" method="POST" id="job-project-form" action="{{ route('service-categories.store') }}">
        @csrf
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">Add Service Category</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <a href="{{ route('service-categories.index') }}" class="btn btn-dark""><i
                                            class="ri-arrow-go-back-line align-bottom me-1"></i> Back to List</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body border-bottom-dashed">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                Invalid Fields.
                            </div>
                        @endif
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="name-field" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name-field">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" name="status" type="checkbox" role="switch"
                                            id="status-field">
                                        <label class="form-check-label" for="status-field">Active</label>
                                    </div>
                                </div>
                                <button class="btn btn-primary w-100">Save Service Category</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
            </div>

        </div>
    </form>

@endsection
