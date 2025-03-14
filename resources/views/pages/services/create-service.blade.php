@extends('layouts.master')

@section('title', 'Create Service')

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pages
        @endslot
        @slot('title')
            Add Service
        @endslot
    @endcomponent

    <form class="" method="POST" id="job-project-form" action="{{ route('job-services.store') }}">
        @csrf
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">Add Service</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <a href="{{ route('job-services.index') }}" class="btn btn-dark""><i
                                            class="ri-arrow-go-back-line align-bottom me-1"></i> Back to List</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body border-bottom-dashed">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                There's an error in your form!
                            </div>
                        @endif
                        <div class="row gy-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="category-field" class="form-label">Category</label>
                                    <select class="form-control @error('service_type') is-invalid @enderror"
                                        data-plugin="choices" data-choices data-choices-search-false id="category-field"
                                        name="category_id">
                                        @foreach ($service_categories as $service_category)
                                            <option value="{{ $service_category->id }}">{{ $service_category->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('service_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="service-type-field" class="form-label">Title</label>
                                    <input type="text" class="form-control @error('service_type') is-invalid @enderror"
                                        name="service_type" id="service-type-field">
                                    @error('service_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description-field" class="form-label">Description</label>
                                    <textarea name="service_description" id="description-field" cols="30" rows="5"
                                        class="form-control @error('service_type') is-invalid @enderror"></textarea>
                                    @error('service_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" name="status" type="checkbox" role="switch"
                                            id="status-field">
                                        <label class="form-check-label" for="status-field">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary w-100">Save Service</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
            </div>

        </div>
    </form>

@endsection
