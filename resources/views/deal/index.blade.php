@extends('layouts.main')
@section('title')
    {{ __('Manage Deals') }} @if ($pipeline)
        - {{ $pipeline->name }}
    @endif
@endsection

@section('page-breadcrumb')
    {{ __('Deal Manage') }}
@endsection
@push('after-scripts')
    @can('move deal')
        @if ($pipeline)
            <script>
                ! function(a) {
                    "use strict";
                    var t = function() {
                        this.$body = a("body")
                    };
                    t.prototype.init = function() {
                        a('[data-plugin="dragula"]').each(function() {
                            var t = a(this).data("containers"),
                                n = [];
                            if (t)
                                for (var i = 0; i < t.length; i++) n.push(a("#" + t[i])[0]);
                            else n = [a(this)[0]];
                            var r = a(this).data("handleclass");
                            r ? dragula(n, {
                                moves: function(a, t, n) {
                                    return n.classList.contains(r)
                                }
                            }) : dragula(n).on('drop', function(el, target, source, sibling) {

                                var order = [];
                                $("#" + target.id + " > div").each(function() {
                                    order[$(this).index()] = $(this).attr('data-id');
                                });

                                var id = $(el).attr('data-id');

                                var old_status = $("#" + source.id).data('status');
                                var new_status = $("#" + target.id).data('status');
                                var stage_id = $(target).attr('data-id');
                                var pipeline_id = '{{ $pipeline->id }}';

                                $("#" + source.id).parent().find('.count').text($("#" + source.id + " > div")
                                    .length);
                                $("#" + target.id).parent().find('.count').text($("#" + target.id + " > div")
                                    .length);
                                $.ajax({
                                    url: '{{ route('deals.order') }}',
                                    type: 'POST',
                                    data: {
                                        deal_id: id,
                                        stage_id: stage_id,
                                        order: order,
                                        new_status: new_status,
                                        old_status: old_status,
                                        pipeline_id: pipeline_id,
                                        "_token": $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(data) {
                                        toastrs('{{ __('Success') }}', 'Deal Move Successfully!',
                                            'success');
                                    },
                                    error: function(data) {
                                        data = data.responseJSON;
                                        toastrs('Error', data.error, 'error')
                                    }
                                });
                            });
                        })
                    }, a.Dragula = new t, a.Dragula.Constructor = t
                }(window.jQuery),
                function(a) {
                    "use strict";

                    a.Dragula.init()

                }(window.jQuery);
            </script>
        @endif
    @endcan
    <script>
        $('.multi-select').select2();
        $(document).on("change", "#change-pipeline select[name=default_pipeline_id]", function() {
            $('#change-pipeline').submit();
        })
    </script>
@endpush
@section('page-action')
<div class="d-flex">

    @if ($pipeline)
        <div class="col-auto ps-1 pt-1 px-3">
            {{ Form::open(['route' => 'deals.change.pipeline', 'id' => 'change-pipeline']) }}
            {{ Form::select('default_pipeline_id', $pipelines, $pipeline->id, ['class' => 'form-control custom-form-select mx-2', 'id' => 'default_pipeline_id']) }}
            {{ Form::close() }}
        </div>
    @endif
    {{-- <div class="col-auto pe-0 pt-2 px-1">
        <a href="{{ route('deals.list') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('List View') }}"
            class="btn btn-sm btn-primary btn-icon"><i class="ti ti-list"></i> </a>
    </div> --}}
    @can('create deal')
        <div class="col-auto ps-1 pt-2">
            <a class="btn btn-sm btn-primary btn-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                title="{{ __('Create Deal') }}" data-ajax-popup="true" data-size="md" data-title="{{ __('Create Deal') }}"
                data-url="{{ route('deals.create') }}"><i class="ti ti-plus text-white"></i></a>
        </div>
    @endcan
</div>
@endsection
@section('content')

    @if ($pipeline)

        @php
            $stages = $pipeline->dealStages;
            $json = [];
            foreach ($stages as $stage) {
                $json[] = 'task-list-' . $stage->id;
            }
        @endphp
        <div class="row kanban-bx gx-0" data-plugin="dragula" data-containers='{!! json_encode($json) !!}'>
            @foreach ($stages as $stage)
                @php($deals = $stage->deals())
                <div class="col-xl-3 col-md-6" id="progress">
                    <div class="kanbanPreview-bx">
                        <div class="draggable-zone dropzoneContainer">
                            <div class="sub-card align-items-center d-flex justify-content-between mb-2">
                                <div>
                                    <h3 class="card-title">{{ $stage->name }} </h3>
                                </div>
                            </div>
                            <div class="plus-bx">
                                <a href="#" data-title="{{ __('Create Deal') }}" data-url="{{ route('deals.create',['stage'=>$stage->name]) }}" data-size="md" data-bs-toggle="modal" data-ajax-popup="true"><svg width="18"
                                        height="18" viewBox="0 0 18 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9 0C4.05 0 0 4.05 0 9C0 13.95 4.05 18 9 18C13.95 18 18 13.95 18 9C18 4.05 13.95 0 9 0ZM9 16.125C5.1 16.125 1.875 12.9 1.875 9C1.875 5.1 5.1 1.875 9 1.875C12.9 1.875 16.125 5.1 16.125 9C16.125 12.9 12.9 16.125 9 16.125Z"
                                            fill="var(--primary)" />
                                        <path
                                            d="M13.3498 8.02503H9.9748V4.65003C9.9748 4.12503 9.52481 3.67503 8.99981 3.67503C8.47481 3.67503 8.02481 4.12503 8.02481 4.65003V8.02503H4.6498C4.1248 8.02503 3.6748 8.47503 3.6748 9.00003C3.6748 9.52503 4.1248 9.97503 4.6498 9.97503H8.02481V13.35C8.02481 13.875 8.47481 14.325 8.99981 14.325C9.52481 14.325 9.9748 13.875 9.9748 13.35V9.97503H13.3498C13.8748 9.97503 14.3248 9.52503 14.3248 9.00003C14.3248 8.47503 13.8748 8.02503 13.3498 8.02503Z"
                                            fill="var(--primary)" />
                                    </svg>
                                    Add new card
                                </a>
                            </div>
                            <div class="draggable" id="task-list-{{ $stage->id }}"
                                data-id="{{ $stage->id }}">
                                @foreach ($deals as $deal)
                                    <div class="card draggable-handle draggable" data-id="{{ $deal->id }}">
                                        <div class="card-body">
                                            <div class=" kanban-user">
                                                <ul class="users">
                                                    @foreach ($deal->users as $user)
                                                        <li><img @if ($user->avatar) src="{{ $user->avatar }}" @else src="{{ 'uploads/users-avatar/avatar.png' }}" @endif
                                                                class="avatar avatar-xs rounded-circle" alt=""></li>
                                                    @endforeach
                                                    <li><span>5+</span></li>
                                                </ul>
                                                @php($labels = $deal->labels())
                                                @if ($labels)
                                                    @foreach ($labels as $label)
                                                        <span
                                                            class="badge light badge-{{ $label->color }} badge-md  mb-0">{{ $label->name }}</span>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <h6><a
                                                    href="@can('show deal') @if ($deal->is_active) {{ route('deals.show', $deal->id) }} @else # @endif @else # @endcan">{{ ucfirst($deal->name) }}
                                                </a></h6>
                                            <p class="mb-0">Task Done: <strong
                                                    class="text-secondary">{{ count($deal->tasks) }}/{{ count($deal->complete_tasks) }}</strong>
                                            </p>
                                            <div class="progress default-progress mb-3 mt-2 h-auto">
                                                <div class="progress-bar bg-secondary progress-animated"
                                                    style="width: {{ count($deal->products()) }}%; height:6px;"
                                                    role="progressbar">
                                                    <span class="sr-only">{{ count($deal->products()) }}% Complete</span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center ">
                                                <ul class="d-flex align-items-center share-tp">
                                                    <li>
                                                        <svg width="20" height="20" viewBox="0 0 24 24"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M18.0797 12.42L11.8997 18.61C11.0895 19.33 10.0348 19.7133 8.95139 19.6814C7.86797 19.6495 6.83767 19.2049 6.07124 18.4384C5.30482 17.672 4.86018 16.6417 4.82829 15.5583C4.7964 14.4749 5.17966 13.4202 5.89967 12.61L13.8997 4.61C14.3773 4.1563 15.0109 3.90333 15.6697 3.90333C16.3284 3.90333 16.962 4.1563 17.4397 4.61C17.905 5.08159 18.1659 5.71747 18.1659 6.38C18.1659 7.04253 17.905 7.67841 17.4397 8.15L10.5397 15.04C10.4714 15.1135 10.3893 15.1729 10.298 15.2147C10.2068 15.2565 10.1082 15.28 10.008 15.2837C9.90767 15.2874 9.80763 15.2713 9.71356 15.2364C9.61948 15.2014 9.53321 15.1483 9.45967 15.08C9.38613 15.0117 9.32676 14.9296 9.28495 14.8384C9.24314 14.7471 9.21971 14.6486 9.216 14.5483C9.21228 14.448 9.22836 14.348 9.2633 14.2539C9.29825 14.1598 9.35138 14.0735 9.41967 14L14.5497 8.88C14.738 8.6917 14.8438 8.4363 14.8438 8.17C14.8438 7.9037 14.738 7.6483 14.5497 7.46C14.3614 7.2717 14.106 7.16591 13.8397 7.16591C13.5734 7.16591 13.318 7.2717 13.1297 7.46L7.99967 12.6C7.74298 12.8547 7.53924 13.1577 7.4002 13.4915C7.26117 13.8253 7.18959 14.1834 7.18959 14.545C7.18959 14.9066 7.26117 15.2647 7.4002 15.5985C7.53924 15.9323 7.74298 16.2353 7.99967 16.49C8.52404 16.9895 9.22048 17.2681 9.94467 17.2681C10.6689 17.2681 11.3653 16.9895 11.8897 16.49L18.7797 9.59C19.5746 8.73695 20.0073 7.60867 19.9867 6.44286C19.9662 5.27706 19.4939 4.16475 18.6694 3.34027C17.8449 2.51579 16.7326 2.04352 15.5668 2.02295C14.401 2.00238 13.2727 2.43512 12.4197 3.23L4.41967 11.23C3.34087 12.4248 2.7647 13.9899 2.8112 15.599C2.85771 17.2081 3.5233 18.7372 4.66931 19.8678C5.81532 20.9983 7.35335 21.6431 8.96296 21.6677C10.5726 21.6923 12.1296 21.0949 13.3097 20L19.4997 13.82C19.5929 13.7268 19.6669 13.6161 19.7173 13.4942C19.7678 13.3724 19.7938 13.2419 19.7938 13.11C19.7938 12.9781 19.7678 12.8476 19.7173 12.7257C19.6669 12.6039 19.5929 12.4932 19.4997 12.4C19.4064 12.3068 19.2957 12.2328 19.1739 12.1823C19.0521 12.1319 18.9215 12.1059 18.7897 12.1059C18.6578 12.1059 18.5272 12.1319 18.4054 12.1823C18.2836 12.2328 18.1729 12.3068 18.0797 12.4V12.42Z"
                                                                fill="#666666" />
                                                        </svg>
                                                    </li>
                                                    <li>
                                                        <svg width="20" height="19" viewBox="0 0 20 19"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M10.2378 1.15881L11.7564 5.83258C11.9906 6.55362 12.6626 7.0418 13.4207 7.0418H18.335C18.5772 7.0418 18.6779 7.3517 18.4819 7.49405L14.5062 10.3826C13.8928 10.8282 13.6362 11.6181 13.8705 12.3392L15.3891 17.0129C15.4639 17.2432 15.2003 17.4348 15.0044 17.2924L11.0286 14.4039C10.4153 13.9583 9.58473 13.9583 8.97138 14.4039L4.99564 17.2924C4.79971 17.4348 4.53609 17.2432 4.61093 17.0129L6.12952 12.3392C6.3638 11.6181 6.10715 10.8282 5.4938 10.3826L1.51806 7.49405C1.32213 7.3517 1.42283 7.0418 1.66501 7.0418H6.57929C7.33743 7.0418 8.00936 6.55362 8.24364 5.83258L9.76224 1.15881C9.83707 0.928484 10.1629 0.928488 10.2378 1.15881Z"
                                                                stroke="#666666" stroke-width="1.5" />
                                                        </svg>
                                                    </li>
                                                </ul>
                                                <div class="col-4 d-flex justify-content-end">
                                                    <a href="{{ URL::to('pipelines/' . $pipeline->id . '/edit') }}" class="btn-link btn sharp tp-btn btn-primary" aria-expanded="false">
                                                            <i class="fa fa-edit"></i>
                                                    </a>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $pipeline->id]]) !!}
                                                    <a href="javascript:;" class="btn-link btn sharp tp-btn btn-danger" aria-expanded="false" title="Delete data">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    {!! Form::close() !!}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
