@extends('layouts.main')

@section('title')
    {{ __('Manage Profile') }}
@endsection

@section('page-breadcrumb')
    {{ __('Manage Profile') }}
@endsection
@push('css')
    <style>
        .nav-pills .nav-link.active,
        .nav-pills:hover .show>.nav-link {
            background-color: var(--primary) !important;
        }
    </style>
@endpush
@section('page-action')
@endsection
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center mb-3">
                <div class="col-md-8">
                </div>
                <div class="col-md-4">
                    <ul class="nav nav-pills nav-fill cust-nav information-tab" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile_info-tab" data-bs-toggle="pill"
                                data-bs-target="#profile_info" type="button">{{ __('Profile Information') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="update_password-tab" data-bs-toggle="pill"
                                data-bs-target="#update_password" type="button">{{ __('Update Password') }}</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="tab-content" id="pills-tabContent">
            {{ Form::open(['route' => ['profile.update', $user], 'method' => 'post']) }}
            @csrf
            @method('patch')
            <div class="tab-pane fade show active" id="profile_info" role="tabpanel"
                aria-labelledby="pills-profile_info-tab">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Personal Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        {{ Form::label('name', __('Name'), ['class' => 'form-label required']) }}
                                        {{ Form::text('name', $user->name, ['class' => 'form-control name', 'placeholder' => __('Enter Name'), 'required' => 'required']) }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        {{ Form::label('image', __('Image'), ['class' => 'form-label']) }}
                                        <input type="file" name="avatar" id="user_profile" class="form-control" onchange="document.getElementById('user_profile').src = window.URL.createObjectURL(this.files[0])">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        {{ Form::label('email', __('Email'), ['class' => 'form-label required']) }}
                                        {{ Form::email('email', $user->email, ['class' => 'form-control email', 'placeholder' => __('Enter Email'), 'required' => 'required']) }}
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <img id="user_profile" alt="your image" src="{{ asset($user->avatar ? 'assets/images/avatar/' . $user->avatar : 'assets/images/avatar/1.png') }}" width="70px"  class="big-logo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" id="cancelButton"
                            data-bs-dismiss="modal">
                        <input type="submit" value="{{ __('Save Changes') }}" class="btn btn-primary" id="updateButton">
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
        {{ Form::open(['route' => 'password.update', 'method' => 'post']) }}
        @csrf
        @method('put')
        <div class="tab-pane fade" id="update_password" role="tabpanel" aria-labelledby="pills-update_password-tab">
            <div class="card">

            </div>
        </div>
        {{ Form::close() }}
    </div>
    {{-- <div class="card">
        <div class="card-body" style="text-align: center;">
            <button type="button" class="btn btn-danger light">Cancel</button>
            <button type="submit" class="btn me-2 btn-primary" id="createButton" disabled>Submit</button>
        </div>
    </div> --}}
    </div>
@endsection
