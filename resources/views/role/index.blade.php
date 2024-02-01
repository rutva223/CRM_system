@extends('layouts.main')

@section('title')
{{ __('Manage Role') }}
@endsection
@section('page-breadcrumb')
{{ __('Role')}}
@endsection
@section('page-action')
<a href="#" data-size="lg" data-url="{{ route('roles.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-title="{{ __('Add New Role') }}" class="btn btn-sm btn-primary">
    <i class="fa fa-plus text-white"></i>
</a>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
    <h4 class="card-title"><i class="fa-solid fa-file-lines me-1"></i>Role List</h4>
    </div>
    <div class="card-body pb-4">
        <div class="table-responsive">
            <table class="display" id="example">
                <thead>
                    <tr>
                        <th>{{__('Id ')}} </th>
                        <th>{{__('Role')}} </th>
                        <th>{{__('Permissions')}} </th>
                        <th>{{__('Action')}} </th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($roles as $index => $role)
                    <tr data-select-id="{{ $role->id }}">
                        <td>{{ ++$index }}</td>
                        <td>{{ $role->name }}</td>
                        <td class="Permission">
                            @for($j=0;$j<count($role->permissions()->pluck('name'));$j++)
                                <span class="badge rounded-pill bg-primary">{{$role->permissions()->pluck('name')[$j]}}</span>
                                @endfor
                        </td>
                        <td>
                            <div class="d-flex">
                                <a href="#!" data-size="md" data-url="{{ route('roles.edit', $role->id) }}" data-ajax-popup="true" class="btn btn-primary shadow btn-sm sharp me-1 text-white" data-title="{{ __('Edit Role') }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id]]) !!}
                                <a href="javascript:;" class="btn btn-danger shadow btn-sm sharp text-white js-sweetalert" title="Delete data">
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
