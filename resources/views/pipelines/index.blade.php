@extends('layouts.main')

@section('title')
    {{ __('Manage Pipelines') }}
@endsection
@section('page-action')
    @can('create pipeline')
        <a href="#" data-size="md" data-url="{{ route('pipelines.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip"
            data-title="{{ __('Create Pipeline') }}" class="btn btn-sm btn-primary">
            <i class="fa fa-plus text-white"></i>
        </a>
    @endcan
@endsection
@section('page-breadcrumb')
    {{ __('Pipelines') }}
@endsection
@section('content')
    <div class="card p-0 rounded-0 file_area mb-0">
        <div class="row">
            @include('layouts.system')
            <div class="col-xl-9 col-xxl-9 pt-5">
                <div class="card">
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table " id="pipeline">
                                <thead>
                                    <tr>
                                        <th>{{ __('Pipeline') }}</th>
                                        <th width="250px">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pipelines as $pipeline)
                                        <tr>
                                            <td>{{ $pipeline->name }}</td>
                                            <td class="Action">
                                                <span class="d-flex float-end">
                                                    @can('edit pipeline')
                                                        <a href="#!" data-size="md"
                                                            data-url="{{ URL::to('pipelines/' . $pipeline->id . '/edit') }}"
                                                            data-ajax-popup="true"
                                                            class="btn btn-primary shadow btn-sm sharp me-1 text-white"
                                                            data-title="{{ __('Edit Pipeline') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @if (count($pipelines) > 1)
                                                        @can('delete pipeline')
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['pipelines.destroy', $pipeline->id]]) !!}
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
