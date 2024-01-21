@extends('layouts.main')

@section('title')
    {{ __('Manage Role') }}
@endsection

@section('content')
    <div class="page-titles">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Role</li>
            </ol>
        </nav>
    </div>

    <div class="filter cm-content-box box-primary">
        <div class="content-title SlideToolHeader">
            <div class="cpa">
                <i class="fa-solid fa-file-lines me-1"></i>Role List
            </div>
            <div class="">
                <div class="add-icon" style="margin-right: 23px;">
                    <a href="#" data-size="md" data-url="{{ route('roles.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-title="{{ __('Add New User') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus text-white"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
