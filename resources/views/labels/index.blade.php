@extends('layouts.main')

@section('title')
    {{ __('Manage Labels') }}
@endsection

@section('page-action')
    @can('create labels')
        <a href="#" data-size="md" data-url="{{ route('labels.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip"
            data-title="{{ __('Create Label') }}" class="btn btn-sm btn-primary">
            <i class="fa fa-plus text-white"></i>
        </a>
    @endcan
@endsection

@section('page-breadcrumb')
    {{ __('Setup') }},
    {{ __('Labels') }}
@endsection

@section('content')
<div class="card p-0 rounded-0 file_area mb-0">
    <div class="row">
            @include('layouts.system')
            <div class="col-xl-9 col-xxl-9 pt-5">
                @if ($pipelines)
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        @php($i = 0)
                        @foreach ($pipelines as $key => $pipeline)
                            <li class="nav-item">
                                <a class="nav-link @if ($i == 0) active @endif" id="pills-home-tab"
                                    data-bs-toggle="pill" href="#tab{{ $key }}" role="tab"
                                    aria-controls="pills-home" aria-selected="true">{{ $pipeline['name'] }}</a>
                            </li>
                            @php($i++)
                        @endforeach
                    </ul>
                @endif
                @if ($pipelines)
                    {{-- <div class="card"> --}}
                        <div class="card-body">
                            <div class="tab-content tab-bordered">
                                @php($i = 0)
                                @foreach ($pipelines as $key => $pipeline)
                                    <div class="tab-pane fade show @if ($i == 0) active @endif"
                                        id="tab{{ $key }}" role="tabpanel">
                                        <ul class="list-group sortable">
                                            @foreach ($pipeline['labels'] as $label)
                                                <li class="list-group-item" data-id="{{ $label->id }}">
                                                    <div class="badge rounded p-2 px-3 bg-{{ $label->color }}">
                                                        {{ $label->name }}
                                                    </div>
                                                    <span class="float-end d-flex">
                                                        @can('edit labels')
                                                            <a href="#!" data-size="md" data-url="{{ URL::to('labels/' . $label->id . '/edit') }}"
                                                                data-ajax-popup="true" class="btn btn-primary shadow btn-sm sharp me-1 text-white"
                                                                data-title="{{ __('Edit Labels') }}">
                                                                <i class="fa fa-edit"></i>
                                                            </a>

                                                        @endcan
                                                        @can('delete labels')
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['labels.destroy', $label->id]]) !!}
                                                        <a href="javascript:;" class="btn btn-danger shadow btn-sm sharp text-white js-sweetalert"
                                                            title="Delete data">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                        {!! Form::close() !!}
                                                        @endcan
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @php($i++)
                                @endforeach
                            </div>
                        </div>
                    {{-- </div> --}}
                @endif
            </div>
        </div>
    </div>
@endsection
