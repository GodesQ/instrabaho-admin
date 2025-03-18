@extends('layouts.master')

@section('title')
    Create Job Contract
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pages
        @endslot
        @slot('title')
            Add Job Contract
        @endslot
    @endcomponent
@endsection
