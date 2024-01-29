@extends('layouts.main')

@section('title')
    {{ __('Manage User') }}
@endsection
@section('page-breadcrumb')
    {{ 'User' }}
@endsection
@section('page-action')
        <a href="#" data-size="md" data-url="{{ route('users.create') }}" data-ajax-popup="true"
            data-bs-toggle="tooltip" data-title="{{ __('Add New User') }}" class="btn btn-sm btn-primary">
            <i class="fa fa-plus text-white"></i>
        </a>
@endsection

@section('content')
    <div class="filter cm-content-box ">
        <div class="content-title SlideToolHeader">
            <div class="cpa">
                <i class="fa-solid fa-file-lines me-1"></i>User List
            </div>

        </div>
            <div class="card-body pb-4">
                <div class="table-responsive">
                    <table class="display" id="example" >
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
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->type }}</td>
                                    <td >
                                        <div class="d-flex">
                                            <a href="#!" data-size="md" data-url="{{ route('users.edit', $user->id) }}"
                                                data-ajax-popup="true" class="btn btn-primary shadow btn-sm sharp me-1 text-white"
                                                data-title="{{ __('Edit User') }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id]]) !!}
                                            <a href="javascript:;" class="btn btn-danger shadow btn-sm sharp text-white js-sweetalert"
                                                title="Delete data">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
@endsection
