@extends('layouts.main')

@section('title')
    {{ __('Manage Lead') }}
@endsection
@section('page-breadcrumb')
    {{ __   ('Lead') }}
@endsection
@section('page-action')
    <a href="#" data-size="lg" data-url="{{ route('leads.create') }}" data-ajax-popup="true"
        data-bs-toggle="tooltip" data-title="{{ __('Add New Lead') }}" class="btn btn-sm btn-primary">
        <i class="fa fa-plus text-white"></i>
    </a>

    <a href="{{ route('leads.grid') }}" data-size="md" data-url="#!" data-ajax-popup="true"
        data-bs-toggle="tooltip" data-title="{{ __('Grid View') }}" class="btn btn-sm btn-primary">
        <i class="fa fa-th text-white"></i>
    </a>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <h4 class="card-title"><i class="fa-solid fa-file-lines me-1"></i>Lead List</h4>
    </div>
    <div class="card-body pb-4">
        <div class="table-responsive">
            <table class="display" id="example" >
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>User Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leads as $index => $lead)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $lead->title }}</td>
                            <td>{{ $lead->name }}</td>
                            <td>
                                <a href="javaScript:void(0)" onclick="openDetails('{{ $lead->description }}')" title="Click for view title"> {{ substr(strip_tags($lead->description), 0, 20) }}.. </a>
                            </td>
                            <td>{{ $lead->status }}</td>
                            <td >
                                <div class="d-flex">
                                    <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-primary shadow btn-sm sharp me-1 text-white"
                                        data-title="{{ __('Show Lead') }}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="#!" data-size="md" data-url="{{ route('leads.edit', $lead->id) }}"
                                        data-ajax-popup="true" class="btn btn-primary shadow btn-sm sharp me-1 text-white"
                                        data-title="{{ __('Edit User') }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['leads.destroy', $lead->id]]) !!}
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

@push('after-scripts')

<script>
    function openDetails(question) {
        Swal.fire({
            title: "<h6><strong>Description:</strong> " + question + "</h6>",
            type: "warning",
            confirmButtonText: "Ok",
        });
    }
</script>

@endpush
