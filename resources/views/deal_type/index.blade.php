@extends('layouts.main')

@section('title')
    {{ __('Manage Deal Type') }}
@endsection
@section('page-action')
    @can('create dealtype')
        <a href="#" data-size="md" data-url="{{ route('dealtypes.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip"
            data-title="{{ __('Create Deal Type') }}" class="btn btn-sm btn-primary">
            <i class="fa fa-plus text-white"></i>
        </a>
    @endcan
@endsection
@section('page-breadcrumb')
    {{ __('Deal Type') }}
@endsection
@section('content')
    <div class="card p-0 rounded-0 file_area mb-0">
        <div class="row">
            @include('layouts.system')
            <div class="col-xl-9 col-xxl-9 pt-5">
                <div class="card">
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table " id="dealtype">
                                <thead>
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th width="250px">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dealtypes as $dealtype)
                                        <tr>
                                            <td>{{ $dealtype->name }}</td>
                                            <td class="Action">
                                                <span class="d-flex float-end">
                                                    @can('edit dealtype')
                                                        <a href="#!" data-size="md"
                                                            data-url="{{ route('dealtypes.edit',$dealtype->id) }}"
                                                            data-ajax-popup="true"
                                                            class="btn btn-primary shadow btn-sm sharp me-1 text-white"
                                                            data-title="{{ __('Edit Deal Type') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @if (count($dealtypes) > 1)
                                                        @can('delete dealtype')
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['dealtypes.destroy', $dealtype->id]]) !!}
                                                            <a href="javascript:;"
                                                                class="btn btn-danger shadow btn-sm sharp text-white js-sweetalert"
                                                                title="Delete data">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                            {!! Form::close() !!}
                                                        @endcan
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
