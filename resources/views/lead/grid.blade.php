@extends('layouts.main')

@section('title')
    {{ __('Manage Lead') }}
@endsection
@section('page-breadcrumb')
    {{ __   ('Lead') }}
@endsection
@php
    $statusClass = App\Models\Lead::lead_title();
    // dd($statusClass);
@endphp
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

    <div class="row kanban-bx gx-0">
        <!--column-->
        @foreach ($statusClass as $class)
            <div class="col-xl-3 col-md-6">
                <div class="kanbanPreview-bx">
                    <div class="draggable-zone dropzoneContainer">
                        <div class="sub-card align-items-center d-flex justify-content-between mb-2">
                            <div>
                                <h3 class="card-title">{{ $class }}</h3>
                            </div>
                            <div class="ms-2">
                                <div class="btn sharp btn-primary tp-btn sharp-sm">
                                    2
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!--/column-->
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

