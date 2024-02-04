@extends('layouts.main')

@section('title')
    {{ __('Manage Lead') }}
@endsection
@section('page-breadcrumb')
    {{ __   ('Lead') }}
@endsection
@section('page-action')
    <a href="#" data-size="md" data-url="{{ route('leads.create') }}" data-ajax-popup="true"
        data-bs-toggle="tooltip" data-title="{{ __('Add New Lead') }}" class="btn btn-sm btn-primary">
        <i class="fa fa-plus text-white"></i>
    </a>

    <a href="{{ route('leads.index') }}" data-size="md" data-url="#!" data-ajax-popup="true"
        data-bs-toggle="tooltip" data-title="{{ __('List View') }}" class="btn btn-sm btn-primary">
        <i class="fa fa-list-ul text-white"></i>
    </a>
@endsection

@section('content')

<div class="card">
    {{-- <div class="card overflow-hidden mt-0">
        <div class="container-kanban">

        </div>
    </div> --}}
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

