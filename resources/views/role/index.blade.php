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
                <a href="#" data-size="lg" data-url="{{ route('roles.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-title="{{ __('Add New User') }}" class="btn btn-sm btn-primary">
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
                            <td class="Action">
                                <span>
                                    <!-- @can('edit role') -->
                                        <a href="#!" data-size="lg" data-url="{{ route('roles.edit',$role->id) }}" data-ajax-popup="true" class="btn btn-warning btn-sm content-icon" data-title="{{__('Edit User')}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    <!-- @endcan
                                    @can('delete role') -->
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id]]) !!}
                                            <a href="javascript:;" class="btn btn-danger btn-sm content-icon js-sweetalert" title="Delete data">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        {!! Form::close() !!}
                                    <!-- @endcan -->
                                </span>
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
                            <li class="page-item"><a class="page-link" href="javascript:void(0);"><i class="fa-solid fa-angle-left"></i></a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                            <li class="page-item"><a class="page-link " href="javascript:void(0);"><i class="fa-solid fa-angle-right"></i></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
