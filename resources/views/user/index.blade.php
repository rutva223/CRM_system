@extends('layouts.main')

@section('title')
    {{ __('Manage User') }}
@endsection

@section('content')
    <div class="page-titles">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">User</li>
            </ol>
        </nav>
    </div>

    <div class="filter cm-content-box box-primary">
        <div class="content-title SlideToolHeader">
            <div class="cpa">
                <i class="fa-solid fa-file-lines me-1"></i>User List
            </div>
            <div class="">
                <div class="add-icon" style="margin-right: 23px;">
                    <a href="#" data-size="md" data-url="{{ route('users.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-title="{{ __('Add New User') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus text-white"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="cm-content-body form excerpt">
            <div class="card-body pb-4">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users_data as $index => $user)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email}}</td>
                                    <td>{{ $user->type }}</td>
                                    <td class="">
                                        <a href="#!" data-size="md" data-url="{{ route('users.edit',$user->id) }}" data-ajax-popup="true" class="btn btn-warning btn-sm content-icon" data-title="{{__('Edit User')}}">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm content-icon bs-pass-para">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <p class="mb-2 me-3">Page 1 of 5, showing 2 records out of 8 total, starting on record 1, ending on
                            2</p>
                        <nav aria-label="Page navigation example mb-2">
                            <ul class="pagination mb-2 mb-sm-0">
                                <li class="page-item"><a class="page-link" href="javascript:void(0);"><i
                                            class="fa-solid fa-angle-left"></i></a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                                <li class="page-item"><a class="page-link " href="javascript:void(0);"><i
                                            class="fa-solid fa-angle-right"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
