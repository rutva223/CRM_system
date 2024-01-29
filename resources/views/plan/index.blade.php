@extends('layouts.main')

@section('title')
    {{ __('Manage Plan') }}
@endsection

@section('page-breadcrumb')
    {{ __('Plans') }}
@endsection

@section('page-action')
    @can('create plan')
    <a data-size="md" data-url="{{ route('plans.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip"
        data-title="Add New Plan" class="btn btn-sm btn-primary">
        <i class="fa fa-plus text-white"></i>
    </a>
    @endcan
@endsection
@section('content')
    <div class="row">
        @foreach ($plans as $plan)
            <div class="col-xl-4 wow fadeInUp" data-wow-delay="1s"
                style="visibility: visible; animation-delay: 1s; animation-name: fadeInUp;">
                <div class="card">
                    <div class="card-header border-0">
                        <h2 class="card-title">{{ $plan->name }} </h2>
                        @if ($plan->is_free_plan == 0)
                            @can('edit plan')
                                <div>
                                    <a href="#" data-size="md" data-url="{{ route('plans.edit', $plan->id) }}"
                                        data-ajax-popup="true" data-bs-toggle="tooltip" data-title="Plan Update"
                                        class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit text-white"></i>
                                    </a>
                                </div>
                            @endcan
                        @endif

                    </div>
                    <div class="card-body text-center pt-0 pb-2">
                        <div class="p-5">
                            <div class="author-profile">
                                <div class="author-info">
                                    <h1>{{ $plan->price }}$</h1>
                                    <span>
                                        <h6>{{ $plan->duration }}</h6>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="chart-items">
                            <!--row-->
                            <div class="row">
                                <!--column-->
                                <div class=" col-xl-12 col-sm-12 mb-3">
                                    <div class="text-start mt-2">
                                        <div class="color-picker">
                                            <p class="mb-0  text-gray ">
                                                <i class="fa fa-user me-2"></i>
                                                Maximum User
                                            </p>
                                            <h6 class="mb-0">{{ $plan->max_user }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-xl-12 col-sm-12 mb-3">
                                    <div class="text-center mt-2">
                                        {{ $plan->description }}
                                    </div>
                                </div>
                                <div class=" col-xl-12 col-sm-12 mb-3">
                                    <div class="text-center mt-2">
                                        @can('plan subscribe')
                                            <div class="card-footer">
                                                @if (Auth::user()->plan == $plan->id)
                                                    <div class="input-group">
                                                        <a
                                                            class="form-control text-primary rounded text-center">{{ Auth::user()->plan_expire_date ?? '' }}</a>
                                                    </div>
                                                @else
                                                    <div class="input-group">
                                                        <a href="{{ route('plan.subscribe', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}"
                                                            class="form-control text-primary rounded text-center">Subscription</a>
                                                    </div>
                                                @endif
                                            </div>
                                        @endcan
                                    </div>
                                </div>
                                <!--/column-->
                            </div>
                            <!--/row-->
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
