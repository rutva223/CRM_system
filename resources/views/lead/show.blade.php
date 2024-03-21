@extends('layouts.main')
@section('title')
    {{ $lead->name }}
@endsection
@section('page-breadcrumb')
    {{ __('leads') }},
    {{ __($lead->name) }}
@endsection
@push('css')
    <style>
        .nav-pills .nav-link.active,
        .nav-pills:hover .show>.nav-link {
            background-color: var(--primary) !important;
        }
    </style>
    <link href="{{ asset('assets\css\dropzone.min.css') }}" rel="stylesheet">
@endpush
@section('page-action')
    <div>
        @can('edit leads')
            <a class="btn btn-sm btn-primary btn-icon " data-size="md" data-bs-toggle="tooltip" data-bs-placement="top"
                title="{{ __('Labels') }}" data-ajax-popup="true" data-size="md" data-title="{{ __('Label') }}"
                data-url="{{ URL::to('lead/' . $lead->id . '/labels') }}"><i class="ti ti-tag text-white"></i></a>
            <a class="btn btn-sm btn-primary btn-icon " data-bs-toggle="tooltip" data-bs-placement="top"
                title="{{ __('Edit') }}" data-ajax-popup="true" data-size="lg" data-title="{{ __('Edit lead') }}"
                data-url="{{ URL::to('lead/' . $lead->id . '/edit') }}"><i class="ti ti-pencil text-white"></i></a>
        @endcan
        @if ($lead->status == 'Won')
            <a href="#" class="btn btn-sm btn-success btn-icon ">{{ __($lead->status) }}</a>
        @elseif($lead->status == 'Loss')
            <a href="#" class="btn btn-sm btn-danger btn-icon">{{ __($lead->status) }}</a>
        @else
            <a href="#" class="btn btn-sm btn-info btn-icon">{{ __($lead->status) }}</a>
        @endif
    </div>
@endsection
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center mb-3">
                <div class="col-md-8">
                </div>
                <div class="col-md-4">
                    <ul class="nav nav-pills nav-fill cust-nav information-tab" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="lead-info-tab" data-bs-toggle="pill"
                                data-bs-target="#lead-info" type="button">{{ __('Data highlights') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="user-assign-tab" data-bs-toggle="pill"
                                data-bs-target="#user-assign" type="button">{{ __('Recent activities') }}</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php
    $tasks = $lead->tasks;
    $calls = $lead->calls;
    $meetings = $lead->meetings;
    $emails = $lead->emails;
    ?>

    <div class="col-lg-12">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="lead-info" role="tabpanel" aria-labelledby="pills-lead-info-tab">
                <div class="row wow fadeInUp main-card" data-wow-delay="0.7s">
                    <!--column-->
                    <div class="col-xxl-8 col-xl-9">
                        <div class="swiper ticketing-Swiper position-relative overflow-hidden">
                            <div class="swiper-wrapper ">
                                <div class="swiper-slide">
                                    <div class="card ticket bg-secondary">
                                        <div class="back-image">
                                            <svg width="102" height="100" viewBox="0 0 102 100" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g opacity="0.3">
                                                    <path
                                                        d="M89.3573 123.082C59.4605 115.689 41.2417 85.3438 48.6706 55.2997C56.0995 25.2556 86.3609 6.89766 116.258 14.2901C146.155 21.6826 164.373 52.028 156.944 82.0721C149.516 112.116 119.254 130.474 89.3573 123.082Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M91.021 116.351C64.8418 109.878 48.891 83.2911 55.4008 56.964C61.9106 30.6368 88.4137 14.5476 114.593 21.0208C140.772 27.4941 156.723 54.0807 150.213 80.4078C143.703 106.735 117.2 122.824 91.021 116.351Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M82.6265 121.417C56.4473 114.944 40.4965 88.3576 47.0063 62.0304C53.5161 35.7033 80.0191 19.6141 106.198 26.0873C132.378 32.5605 148.328 59.1471 141.819 85.4743C135.309 111.801 108.806 127.891 82.6265 121.417Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M73.9723 126.42C47.9385 119.983 32.1005 93.4265 38.6109 67.0969C45.1213 40.7672 71.5104 24.6525 97.5442 31.0897C123.578 37.527 139.416 64.0831 132.906 90.4127C126.395 116.742 100.006 132.857 73.9723 126.42Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M65.3189 131.422C39.1396 124.949 23.1888 98.3625 29.6986 72.0353C36.2084 45.7082 62.7115 29.6189 88.8908 36.0922C115.07 42.5654 131.021 69.152 124.511 95.4792C118.001 121.806 91.4981 137.896 65.3189 131.422Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M56.6647 136.425C30.6309 129.987 14.7929 103.431 21.3033 77.1017C27.8137 50.7721 54.2027 34.6573 80.2365 41.0946C106.27 47.5318 122.108 74.0879 115.598 100.418C109.088 126.747 82.6985 142.862 56.6647 136.425Z"
                                                        stroke="white" />
                                                    <circle cx="59.7333" cy="94.0209" r="48.8339"
                                                        transform="rotate(103.889 59.7333 94.0209)" stroke="white" />
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="card-body">
                                            <div class="title">
                                                <svg width="9" height="8" viewBox="0 0 9 8" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="0.425781" width="8" height="8" fill="#FCFCFC" />
                                                </svg>
                                                <p class="text-white mb-2">Total Product</p>
                                            </div>
                                            <div class="chart-num">
                                                <h3 class="text-white mb-0">2.345</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card ticket bg-info">
                                        <div class="back-image">
                                            <svg width="102" height="100" viewBox="0 0 102 100" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g opacity="0.3">
                                                    <path
                                                        d="M89.3573 123.082C59.4605 115.689 41.2417 85.3438 48.6706 55.2997C56.0995 25.2556 86.3609 6.89766 116.258 14.2901C146.155 21.6826 164.373 52.028 156.944 82.0721C149.516 112.116 119.254 130.474 89.3573 123.082Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M91.021 116.351C64.8418 109.878 48.891 83.2911 55.4008 56.964C61.9106 30.6368 88.4137 14.5476 114.593 21.0208C140.772 27.4941 156.723 54.0807 150.213 80.4078C143.703 106.735 117.2 122.824 91.021 116.351Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M82.6265 121.417C56.4473 114.944 40.4965 88.3576 47.0063 62.0304C53.5161 35.7033 80.0191 19.6141 106.198 26.0873C132.378 32.5605 148.328 59.1471 141.819 85.4743C135.309 111.801 108.806 127.891 82.6265 121.417Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M73.9723 126.42C47.9385 119.983 32.1005 93.4265 38.6109 67.0969C45.1213 40.7672 71.5104 24.6525 97.5442 31.0897C123.578 37.527 139.416 64.0831 132.906 90.4127C126.395 116.742 100.006 132.857 73.9723 126.42Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M65.3189 131.422C39.1396 124.949 23.1888 98.3625 29.6986 72.0353C36.2084 45.7082 62.7115 29.6189 88.8908 36.0922C115.07 42.5654 131.021 69.152 124.511 95.4792C118.001 121.806 91.4981 137.896 65.3189 131.422Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M56.6647 136.425C30.6309 129.987 14.7929 103.431 21.3033 77.1017C27.8137 50.7721 54.2027 34.6573 80.2365 41.0946C106.27 47.5318 122.108 74.0879 115.598 100.418C109.088 126.747 82.6985 142.862 56.6647 136.425Z"
                                                        stroke="white" />
                                                    <circle cx="59.7333" cy="94.0209" r="48.8339"
                                                        transform="rotate(103.889 59.7333 94.0209)" stroke="white" />
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="card-body">
                                            <div class="title">
                                                <svg width="9" height="8" viewBox="0 0 9 8" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="0.425781" width="8" height="8" fill="#FCFCFC" />
                                                </svg>
                                                <p class="text-white mb-2">Total Users</p>
                                            </div>
                                            <div class="chart-num">
                                                <h3 class="mb-0 text-white">{{ count($lead->users) }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card ticket bg-dark">
                                        <div class="back-image">
                                            <svg width="102" height="100" viewBox="0 0 102 100" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g opacity="0.3">
                                                    <path
                                                        d="M89.3573 123.082C59.4605 115.689 41.2417 85.3438 48.6706 55.2997C56.0995 25.2556 86.3609 6.89766 116.258 14.2901C146.155 21.6826 164.373 52.028 156.944 82.0721C149.516 112.116 119.254 130.474 89.3573 123.082Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M91.021 116.351C64.8418 109.878 48.891 83.2911 55.4008 56.964C61.9106 30.6368 88.4137 14.5476 114.593 21.0208C140.772 27.4941 156.723 54.0807 150.213 80.4078C143.703 106.735 117.2 122.824 91.021 116.351Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M82.6265 121.417C56.4473 114.944 40.4965 88.3576 47.0063 62.0304C53.5161 35.7033 80.0191 19.6141 106.198 26.0873C132.378 32.5605 148.328 59.1471 141.819 85.4743C135.309 111.801 108.806 127.891 82.6265 121.417Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M73.9723 126.42C47.9385 119.983 32.1005 93.4265 38.6109 67.0969C45.1213 40.7672 71.5104 24.6525 97.5442 31.0897C123.578 37.527 139.416 64.0831 132.906 90.4127C126.395 116.742 100.006 132.857 73.9723 126.42Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M65.3189 131.422C39.1396 124.949 23.1888 98.3625 29.6986 72.0353C36.2084 45.7082 62.7115 29.6189 88.8908 36.0922C115.07 42.5654 131.021 69.152 124.511 95.4792C118.001 121.806 91.4981 137.896 65.3189 131.422Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M56.6647 136.425C30.6309 129.987 14.7929 103.431 21.3033 77.1017C27.8137 50.7721 54.2027 34.6573 80.2365 41.0946C106.27 47.5318 122.108 74.0879 115.598 100.418C109.088 126.747 82.6985 142.862 56.6647 136.425Z"
                                                        stroke="white" />
                                                    <circle cx="59.7333" cy="94.0209" r="48.8339"
                                                        transform="rotate(103.889 59.7333 94.0209)" stroke="white" />
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="card-body">
                                            <div class="title">
                                                <svg width="9" height="8" viewBox="0 0 9 8" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="0.425781" width="8" height="8" fill="#FCFCFC" />
                                                </svg>
                                                <p class="text-white mb-2">Total Call</p>
                                            </div>
                                            <div class="chart-num">
                                                <h3 class="mb-0 text-white">{{ count($calls) }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card ticket bg-info">
                                        <div class="back-image">
                                            <svg width="102" height="100" viewBox="0 0 102 100" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g opacity="0.3">
                                                    <path
                                                        d="M89.3573 123.082C59.4605 115.689 41.2417 85.3438 48.6706 55.2997C56.0995 25.2556 86.3609 6.89766 116.258 14.2901C146.155 21.6826 164.373 52.028 156.944 82.0721C149.516 112.116 119.254 130.474 89.3573 123.082Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M91.021 116.351C64.8418 109.878 48.891 83.2911 55.4008 56.964C61.9106 30.6368 88.4137 14.5476 114.593 21.0208C140.772 27.4941 156.723 54.0807 150.213 80.4078C143.703 106.735 117.2 122.824 91.021 116.351Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M82.6265 121.417C56.4473 114.944 40.4965 88.3576 47.0063 62.0304C53.5161 35.7033 80.0191 19.6141 106.198 26.0873C132.378 32.5605 148.328 59.1471 141.819 85.4743C135.309 111.801 108.806 127.891 82.6265 121.417Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M73.9723 126.42C47.9385 119.983 32.1005 93.4265 38.6109 67.0969C45.1213 40.7672 71.5104 24.6525 97.5442 31.0897C123.578 37.527 139.416 64.0831 132.906 90.4127C126.395 116.742 100.006 132.857 73.9723 126.42Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M65.3189 131.422C39.1396 124.949 23.1888 98.3625 29.6986 72.0353C36.2084 45.7082 62.7115 29.6189 88.8908 36.0922C115.07 42.5654 131.021 69.152 124.511 95.4792C118.001 121.806 91.4981 137.896 65.3189 131.422Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M56.6647 136.425C30.6309 129.987 14.7929 103.431 21.3033 77.1017C27.8137 50.7721 54.2027 34.6573 80.2365 41.0946C106.27 47.5318 122.108 74.0879 115.598 100.418C109.088 126.747 82.6985 142.862 56.6647 136.425Z"
                                                        stroke="white" />
                                                    <circle cx="59.7333" cy="94.0209" r="48.8339"
                                                        transform="rotate(103.889 59.7333 94.0209)" stroke="white" />
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="card-body">
                                            <div class="title">
                                                <svg width="9" height="8" viewBox="0 0 9 8" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="0.425781" width="8" height="8" fill="#FCFCFC" />
                                                </svg>
                                                <p class="text-white mb-2">Total File</p>
                                            </div>
                                            <div class="chart-num">
                                                <h3 class="mb-0 text-white">{{ count($lead->files) }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card ticket bg-secondary">
                                        <div class="back-image">
                                            <svg width="102" height="100" viewBox="0 0 102 100" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g opacity="0.3">
                                                    <path
                                                        d="M89.3573 123.082C59.4605 115.689 41.2417 85.3438 48.6706 55.2997C56.0995 25.2556 86.3609 6.89766 116.258 14.2901C146.155 21.6826 164.373 52.028 156.944 82.0721C149.516 112.116 119.254 130.474 89.3573 123.082Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M91.021 116.351C64.8418 109.878 48.891 83.2911 55.4008 56.964C61.9106 30.6368 88.4137 14.5476 114.593 21.0208C140.772 27.4941 156.723 54.0807 150.213 80.4078C143.703 106.735 117.2 122.824 91.021 116.351Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M82.6265 121.417C56.4473 114.944 40.4965 88.3576 47.0063 62.0304C53.5161 35.7033 80.0191 19.6141 106.198 26.0873C132.378 32.5605 148.328 59.1471 141.819 85.4743C135.309 111.801 108.806 127.891 82.6265 121.417Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M73.9723 126.42C47.9385 119.983 32.1005 93.4265 38.6109 67.0969C45.1213 40.7672 71.5104 24.6525 97.5442 31.0897C123.578 37.527 139.416 64.0831 132.906 90.4127C126.395 116.742 100.006 132.857 73.9723 126.42Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M65.3189 131.422C39.1396 124.949 23.1888 98.3625 29.6986 72.0353C36.2084 45.7082 62.7115 29.6189 88.8908 36.0922C115.07 42.5654 131.021 69.152 124.511 95.4792C118.001 121.806 91.4981 137.896 65.3189 131.422Z"
                                                        stroke="white" />
                                                    <path
                                                        d="M56.6647 136.425C30.6309 129.987 14.7929 103.431 21.3033 77.1017C27.8137 50.7721 54.2027 34.6573 80.2365 41.0946C106.27 47.5318 122.108 74.0879 115.598 100.418C109.088 126.747 82.6985 142.862 56.6647 136.425Z"
                                                        stroke="white" />
                                                    <circle cx="59.7333" cy="94.0209" r="48.8339"
                                                        transform="rotate(103.889 59.7333 94.0209)" stroke="white" />
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="card-body">
                                            <div class="title">
                                                <svg width="9" height="8" viewBox="0 0 9 8" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="0.425781" width="8" height="8" fill="#FCFCFC" />
                                                </svg>
                                                <p class="text-white mb-2">Amount</p>
                                            </div>
                                            <div class="chart-num">
                                                <h3 class="text-white mb-0">2.345</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 wow fadeInUp" data-wow-delay="1.5s">
                                <div class="card" >
                                    <div class="card-header border-0 flex-wrap">
                                        <h2 class="card-title mb-0">Recent activities</h2>
                                        {{-- <div class="d-flex align-items-center">
                                            <select class="image-select default-select dashboard-select me-4"
                                                aria-label="Default">
                                                <option selected>This Month</option>
                                                <option value="1">Weeks</option>
                                                <option value="2">This Day</option>
                                            </select>
                                        </div> --}}
                                    </div>
                                    <div class="card-body py-0 " >
                                        <div class="table-responsive">
                                            <table
                                                class="table-responsive table display mb-4 order-table card-table text-black no-footer student-tbl ">
                                                <tbody>
                                                    @forelse ($lead->activities as $activity)
                                                        <tr>
                                                            <td class="whitesp-no p-0">
                                                                <div
                                                                    class="d-flex py-sm-3 py-1 align-items-center trans-info">
                                                                    <div class="icon-bx border me-3">
                                                                        <i class="fas {{ $activity->logIcon() }}"></i>
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="mb-0">{!! $activity->getUser() !!}</h6>
                                                                        <p class="mb-0">
                                                                            {{ $activity->created_at->diffForHumans() }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{!! $activity->getUseremail() !!}</td>
                                                            <td><span class="badge light badge-success badge-sm"><svg
                                                                        width="13" height="13" viewBox="0 0 16 16"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M5.50912 14.5C5.25012 14.5 4.99413 14.4005 4.80013 14.2065L1.79362 11.2C1.40213 10.809 1.40213 10.174 1.79362 9.78302C2.18512 9.39152 2.81913 9.39152 3.21063 9.78302L5.62812 12.2005L12.9306 7.18802C13.3866 6.87502 14.0106 6.99102 14.3236 7.44702C14.6371 7.90352 14.5211 8.52702 14.0646 8.84052L6.07613 14.324C5.90363 14.442 5.70612 14.5 5.50912 14.5Z"
                                                                            fill="#1EBA62" />
                                                                        <path
                                                                            d="M5.50912 8.98807C5.25012 8.98807 4.99413 8.88857 4.80013 8.69457L1.79362 5.68807C1.40213 5.29657 1.40213 4.66207 1.79362 4.27107C2.18512 3.87957 2.81913 3.87957 3.21063 4.27107L5.62812 6.68857L12.9306 1.67607C13.3866 1.36307 14.0106 1.47907 14.3236 1.93507C14.6371 2.39157 14.5211 3.01507 14.0646 3.32857L6.07613 8.81257C5.90363 8.93057 5.70612 8.98807 5.50912 8.98807Z"
                                                                            fill="#1EBA62" />
                                                                    </svg>
                                                                    {!! $activity->getLeadRemark() !!}</span>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <td colspan="5" class="text-center">No Data Found</td>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="table-pagenation px-4">
                                        <p>Showing <strong class="text-primary me-1">1-5</strong>from <strong
                                                class="text-primary me-1">100</strong>data</p>
                                        <nav>
                                            <ul class="pagination pagination-gutter pagination-primary no-bg">
                                                <li class="page-item page-indicator">
                                                    <a class="page-link" href="javascript:void(0)">
                                                        <i class="fa-solid fa-angle-left"></i></a>
                                                </li>
                                                <li class="page-item "><a class="page-link"
                                                        href="javascript:void(0)">1</a>
                                                </li>
                                                <li class="page-item active"><a class="page-link"
                                                        href="javascript:void(0)">2</a></li>
                                                <li class="page-item"><a class="page-link"
                                                        href="javascript:void(0)">3</a></li>
                                                <li class="page-item page-indicator">
                                                    <a class="page-link" href="javascript:void(0)">
                                                        <i class="fa-solid fa-angle-right"></i></a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <!--/column-->
                        </div>
                        <!-- /row-->
                    </div>
                    <!--/column-->
                    <!--column-->
                    <div class="col-xxl-4 col-xl-3">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card event-agenda  h-auto">
                                    <div class="card-header border-0 pb-3">
                                        <div>
                                            <h2 class="card-title mb-0">Contacts
                                            </h2>
                                        </div>
                                        <div class="add-icon">
                                            <a href="#" data-size="md"
                                                data-url="{{ route('leadContactAssign', $lead->id) }}" data-ajax-popup="true"
                                                data-bs-toggle="tooltip" data-title="{{ __('Add Contact') }}"
                                                class="icon-bx icon-bx-sm bg-secondary">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M12 3C7.05 3 3 7.05 3 12C3 16.95 7.05 21 12 21C16.95 21 21 16.95 21 12C21 7.05 16.95 3 12 3ZM12 19.125C8.1 19.125 4.875 15.9 4.875 12C4.875 8.1 8.1 4.875 12 4.875C15.9 4.875 19.125 8.1 19.125 12C19.125 15.9 15.9 19.125 12 19.125Z"
                                                        fill="white" />
                                                    <path
                                                        d="M16.3503 11.0251H12.9753V7.65009C12.9753 7.12509 12.5253 6.67509 12.0003 6.67509C11.4753 6.67509 11.0253 7.12509 11.0253 7.65009V11.0251H7.65029C7.12529 11.0251 6.67529 11.4751 6.67529 12.0001C6.67529 12.5251 7.12529 12.9751 7.65029 12.9751H11.0253V16.3501C11.0253 16.8751 11.4753 17.3251 12.0003 17.3251C12.5253 17.3251 12.9753 16.8751 12.9753 16.3501V12.9751H16.3503C16.8753 12.9751 17.3253 12.5251 17.3253 12.0001C17.3253 11.4751 16.8753 11.0251 16.3503 11.0251Z"
                                                        fill="white" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body loadmore-content dlab-scroll height500  recent-activity-wrapper p-3 pt-0"
                                        id="RecentActivityContent">
                                        @foreach ($lead->users as $contact)
                                            <div class="d-flex align-items-center event">
                                                <div
                                                    class="icon-bx icon-bx-lg  me-3 d-flex flex-column justify-content-center">
                                                    <img alt="user-image" class=" rounded-circle img_users_fix_size"
                                                        avatar="{{ $contact->name }}">
                                                </div>
                                                <div class="event-info">
                                                    <h6 class="mb-0"><a href="">{{ $contact->name }}</a></h6>
                                                    <p class="mb-0">{{ $contact->email }}</p>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                    <div class="card-footer text-center border-0">
                                        <a href="javascript:void(0);"
                                            class="btn btn-block light btn-secondary  dlab-load-more" id="RecentActivity"
                                            rel="ajax/event-agenda.html">View More</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--/column-->
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="user-assign" role="tabpanel" aria-labelledby="pills-user-assign-tab">
            <div class="row">
                <div class="col-xl-8">
                    <div class="card h-auto">
                        <div class="card-body">
                            <form action="{{ route('leadnoteStore', $lead->id) }}" method="post" id="myForm">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="name" class="form-control" placeholder="Title"
                                        value="{{ $lead->name }}">
                                </div>
                                <label class="form-label">Description</label>
                                <textarea name="notes" id="ckeditor" rows="10" cols="80" style="display: none;">{!! $lead->notes !!}</textarea>

                                <div class="card-footer border-top text-end p-0 pt-3">
                                    <button class="btn btn-primary btn-sm" id="saveNoteBtn">Save Note</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="filter cm-content-box box-primary">
                        <div class="content-title SlideToolHeader">
                            <div class="cpa">
                                Call
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="mx-3">
                                    <a href="#" data-size="md" data-url="{{ route('leadcallCreate', $lead->id) }}"
                                        data-ajax-popup="true" data-bs-toggle="tooltip"
                                        data-title="{{ __('Add Call') }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-plus text-white"></i>
                                    </a>
                                </div>
                                <div class="tools">
                                    <a href="javascript:void(0);" class="expand handle btn btn-sm btn-info"><i
                                            class="fal fa-angle-down"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="cm-content-body form excerpt">

                            <div class="card-body">
                                <table class="table mb-0 pc-dt-simple" id="lead_call">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Subject') }}</th>
                                            <th>{{ __('Call Type') }}</th>
                                            <th>{{ __('Duration') }}</th>
                                            <th>{{ __('User') }}</th>
                                            <th width="14%">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($calls as $call)
                                            <tr>
                                                <td>{{ $call->subject }}</td>
                                                <td>{{ ucfirst($call->call_type) }}</td>
                                                <td>{{ $call->duration }}</td>
                                                <td>{{ !empty($call->getleadCallUser->name) ? $call->getleadCallUser->name : '' }}
                                                </td>
                                                <td class="text-end d-flex">
                                                    @can('edit lead call')
                                                        <a data-size="lg"
                                                            data-url="{{ URL::to('leads/' . $lead->id . '/call/' . $call->id . '/edit') }}"
                                                            data-ajax-popup="true" data-title="{{ __('Edit Call') }}"
                                                            class="btn btn-primary shadow btn-sm sharp me-1 text-white"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="{{ __('Edit Call') }}"><i
                                                                class="ti ti-pencil text-white"></i></a>
                                                    @endcan
                                                    @can('delete lead call')
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['leadcallDestroy', $lead->id, $call->id],
                                                            'id' => 'delete-form-' . $lead->id,
                                                        ]) !!}
                                                        <a href="#!"
                                                            class="btn btn-danger shadow btn-sm sharp text-white js-sweetalert"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="{{ __('Delete lead') }}">
                                                            <span class="text-white"> <i class="ti ti-trash"></i></span>
                                                            {!! Form::close() !!}
                                                        @endcan
                                                </td>
                                            </tr>
                                        @empty
                                            <td colspan="5" class="text-center">No Data Found</td>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                     {{-- lead task --}}
                     <div class="filter cm-content-box box-primary">
                        <div class="content-title SlideToolHeader">
                            <div class="cpa"> Task
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="mx-3">
                                    <a href="#" data-size="md"
                                        data-url="{{ route('lead.tasks.create', $lead->id) }}" data-ajax-popup="true"
                                        data-bs-toggle="tooltip" data-title="{{ __('Add Call') }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fa fa-plus text-white"></i>
                                    </a>
                                </div>
                                <div class="tools">
                                    <a href="javascript:void(0);" class="expand handle btn btn-sm btn-info"><i
                                            class="fal fa-angle-down"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="cm-content-body publish-content form excerpt">
                            <div class="card-body">
                                <table class="table mb-0 pc-dt-simple" id="lead_call">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Priority') }}</th>
                                            <th>{{ __('Date/Time') }}</th>
                                            <th width="14%">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($tasks as $task)
                                            <tr>
                                                <td>
                                                    <h6 class="media-title text-sm form-check-label">
                                                        {{ $task->name }}
                                                    </h6>
                                                </td>
                                                <td>
                                                    @if ($task->status)
                                                        <div class="badge rounded p-2 px-3 bg-success mb-1">
                                                            {{ __(App\Models\leadTask::$status[$task->status]) }}
                                                        </div>
                                                    @else
                                                        <div class="badge rounded p-2 px-3 bg-warning mb-1">
                                                            {{ __(App\Models\leadTask::$status[$task->status]) }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ __(App\Models\leadTask::$priorities[$task->priority]) }}
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-switch form-check form-switch ">
                                                        @can('edit lead task')
                                                            <input type="checkbox" class="form-check-input task-checkbox"
                                                                role="switch" id="task_{{ $task->id }}"
                                                                @if ($task->status) checked="checked" @endcan type="checkbox" value="{{ $task->status }}" data-url="{{ route('lead.tasks.update_status', [$lead->id, $task->id]) }}"/>

                                                        @endcan
                                                        <label for="task_{{ $task->id }}" class="custom-control-label ml-4 @if ($task->status) strike @endif">
                                                            <div class="text-xs text-muted">
                                                                <span
                                                                    class="text-primary">{{ date('d-M-y h:i A',strtotime($task->date . ' ' . $task->time)) }}</span>
                                                            </div>
                                                            </label>
                                                        </div>
                                                    </td>

                                                    <td class="text-end d-flex">
                                                        @can('edit lead task')
                                                                <a data-size="md"
                                                                    data-url="{{ route('lead.tasks.edit', [$lead->id, $task->id]) }}"
                                                                    data-ajax-popup="true" data-title="{{ __('Edit Task') }}"
                                                                    class="btn btn-sm btn-primary shadow sharp me-1 text-white"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ __('Edit Task') }}"><i
                                                                        class="ti ti-pencil text-white"></i></a>
                                                        @endcan
                                                        @can('delete lead task')
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'route' => ['lead.tasks.destroy', $lead->id, $task->id],
                                                                'id' => 'delete-form-' . $task->id,
                                                            ]) !!}
                                                            <a href="#!"
                                                                class="btn btn-sm btn-danger shadow sharp me-1 text-white show_confirm js-sweetalert"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="{{ __('Delete Task') }}">
                                                                <span class="text-white"> <i
                                                                        class="ti ti-trash"></i></span></a>
                                                            {!! Form::close() !!}
                                                        @endcan
                                                    </td>
                                                </tr>
                                                @empty
                                                    <td colspan="5" class="text-center">No Data Found</td>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="filter cm-content-box box-primary">
                                <div class="content-title SlideToolHeader">
                                    <div class="cpa">
                                        Meeting
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="mx-3">
                                            <a href="#" data-size="md" data-url="{{ route('leadmeetingCreate', $lead->id) }}"
                                                data-ajax-popup="true" data-bs-toggle="tooltip"
                                                data-title="{{ __('Add Call') }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-plus text-white"></i>
                                            </a>
                                        </div>
                                        <div class="tools">
                                            <a href="javascript:void(0);" class="expand handle btn btn-sm btn-info"><i
                                                    class="fal fa-angle-down"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="cm-content-body form excerpt">

                                    <div class="card-body">
                                        <table class="table mb-0 pc-dt-simple" id="lead_call">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Subject') }}</th>
                                                    <th>{{ __('Meeting Status') }}</th>
                                                    <th>{{ __('Duration') }}</th>
                                                    <th>{{ __('User') }}</th>
                                                    <th width="14%">{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($meetings as $meeting)
                                                    <tr>
                                                        <td>{{ $meeting->subject }}</td>
                                                        <td>{{ ucfirst($meeting->status) }}</td>
                                                        <td>{{ $meeting->duration }}</td>
                                                        <td>{{ !empty($meeting->getleadMeetingUser->name) ? $meeting->getleadMeetingUser->name : '' }}
                                                        </td>
                                                        <td class="text-end d-flex">
                                                            @can('edit lead meeting')
                                                                <a data-size="lg"
                                                                    data-url="{{ URL::to('leads/' . $lead->id . '/meeting/' . $meeting->id . '/edit') }}"
                                                                    data-ajax-popup="true" data-title="{{ __('Edit Meeting') }}"
                                                                    class="btn btn-primary shadow btn-sm sharp me-1 text-white"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ __('Edit Meeting') }}"><i
                                                                        class="ti ti-pencil text-white"></i></a>
                                                            @endcan
                                                            @can('delete lead meeting')
                                                                {!! Form::open([
                                                                    'method' => 'DELETE',
                                                                    'route' => ['meetingDestroy', $lead->id, $meeting->id],
                                                                    'id' => 'delete-form-' . $lead->id,
                                                                ]) !!}
                                                                <a href="#!"
                                                                    class="btn btn-danger shadow btn-sm sharp text-white js-sweetalert"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ __('Delete lead') }}">
                                                                    <span class="text-white"> <i class="ti ti-trash"></i></span>
                                                                    {!! Form::close() !!}
                                                                @endcan
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <td colspan="5" class="text-center">No Data Found</td>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="filter cm-content-box box-primary">
                                <div class="content-title SlideToolHeader">
                                    <div class="cpa">
                                        Attechment
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:void(0);" class="expand handle"><i class="fal fa-angle-down"></i></a>
                                    </div>
                                </div>
                                <div class="cm-content-body form excerpt">
                                    <div class="card-body">
                                        <div class="col-md-12 dropzone browse-file" id="dropzonewidget2"></div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-xl-4">
                            <div class="right-sidebar-sticky">
                                <div class="filter cm-content-box box-primary">
                                    <div class="content-title SlideToolHeader">
                                        <div class="cpa">
                                            Sources
                                        </div>
                                        <div class="tools">
                                            <a href="javascript:void(0);" class="expand handle"><i
                                                    class="fal fa-angle-down"></i></a>
                                        </div>
                                    </div>
                                    <div class="cm-content-body publish-content form excerpt">
                                        <div class="card-body py-3">
                                            <ul class="list-style-1 block">
                                                <li>
                                                    <div>
                                                        <label class="form-label mb-0 me-2">
                                                            <i class="fa-solid fa-key"></i>
                                                            Status:
                                                        </label>
                                                        <span class="font-w500">Published</span>
                                                        <a href="javascript:void(0);" class="badge badge-primary light ms-3"
                                                            id="headingOne" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOne" aria-controls="collapseOne"
                                                            aria-expanded="true" role="button">Edit</a>
                                                    </div>
                                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                                        data-bs-parent="#accordion-one">
                                                        <div class=" border rounded p-3 mt-3">
                                                            <div class="mb-2">
                                                                <label class="form-label w-100">Content Type</label>
                                                                <select class="form-control default-select">
                                                                    <option selected>Select Status</option>
                                                                    <option value="1">Published</option>
                                                                    <option value="2">Draft</option>
                                                                    <option value="3">Trash</option>
                                                                    <option value="4">Private</option>
                                                                    <option value="5">Pending</option>
                                                                </select>
                                                            </div>
                                                            <div class="mt-3">
                                                                <button class="btn btn-primary btn-sm me-2" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                                    aria-expanded="false" aria-controls="collapseOne">
                                                                    Ok
                                                                </button>
                                                                <button class="btn btn-danger light btn-sm" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                                    aria-expanded="false" aria-controls="collapseOne">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div>
                                                        <label class="form-label mb-0 me-2">
                                                            <i class="fa-solid fa-eye"></i>
                                                            Status:
                                                        </label>
                                                        <span class="font-w500">Public</span>
                                                        <a href="javascript:void(0);" class="badge badge-primary light ms-3"
                                                            id="headingtwo" data-bs-toggle="collapse"
                                                            data-bs-target="#collapsetwo" aria-controls="collapsetwo"
                                                            aria-expanded="true" role="button">Edit</a>
                                                    </div>
                                                    <div id="collapsetwo" class="collapse" aria-labelledby="headingtwo"
                                                        data-bs-parent="#accordion-one">
                                                        <div class="p-3 mt-3 border rounded">
                                                            <div class="basic-form">
                                                                <form>
                                                                    <div class="mb-3 mb-0">
                                                                        <div class="radio">
                                                                            <label class="form-check-label"><input type="radio"
                                                                                    name="optradio" class="form-check-input">
                                                                                Public</label>
                                                                        </div>
                                                                        <div class="radio">
                                                                            <label class="form-check-label"><input type="radio"
                                                                                    name="optradio" class="form-check-input">
                                                                                Password Protected</label>
                                                                        </div>
                                                                        <div class="radio disabled">
                                                                            <label class="form-check-label"><input type="radio"
                                                                                    name="optradio" class="form-check-input">
                                                                                Private</label>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div>
                                                                <button class="btn btn-primary btn-sm me-2" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapsetwo"
                                                                    aria-expanded="false" aria-controls="collapsetwo">
                                                                    Ok
                                                                </button>
                                                                <button class="btn btn-danger light btn-sm" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapsetwo"
                                                                    aria-expanded="false" aria-controls="collapsetwo">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="border-bottom-0">
                                                    <div>
                                                        <label class="form-label mb-0 me-2">
                                                            <i class="fa-solid fa-calendar-days"></i>
                                                            Published
                                                        </label>
                                                        <span class="font-w500">on :24-09-2023 16:22:52</span>
                                                        <a href="javascript:void(0);" class="badge badge-primary light ms-3"
                                                            id="headingthree" data-bs-toggle="collapse"
                                                            data-bs-target="#collapsethree" aria-controls="collapsethree"
                                                            aria-expanded="true" role="button">Edit</a>
                                                    </div>
                                                    <div id="collapsethree" class="collapse" aria-labelledby="headingthree"
                                                        data-bs-parent="#accordion-one">
                                                        <div class="p-3 mt-3 border rounded">
                                                            <div class="input-hasicon">
                                                                <input name="datepicker" class="form-control bt-datepicker">
                                                                <div class="icon"><i class="far fa-calendar"></i></div>
                                                            </div>
                                                            <div class="mt-3">
                                                                <button class="btn btn-primary btn-sm me-2" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapsethree"
                                                                    aria-expanded="false" aria-controls="collapsethree">
                                                                    Ok
                                                                </button>
                                                                <button class="btn btn-danger light btn-sm" type="button"
                                                                    data-bs-toggle="collapse" data-bs-target="#collapsethree"
                                                                    aria-expanded="false" aria-controls="collapsethree">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-footer border-top text-end py-3 ">
                                            <a href="javascript:void(0);" class="btn btn-primary btn-sm">Publish</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter cm-content-box box-primary">
                                    <div class="content-title SlideToolHeader">
                                        <div class="cpa">
                                            Emails
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="mx-3">
                                                <a href="#" data-size="md"
                                                    data-url="{{ route('leademailCreate', $lead->id) }}" data-ajax-popup="true"
                                                    data-bs-toggle="tooltip" data-title="{{ __('Email Create') }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fa fa-plus text-white"></i>
                                                </a>
                                            </div>
                                            <div class="tools">
                                                <a href="javascript:void(0);" class="expand handle btn btn-sm btn-info"><i
                                                        class="fal fa-angle-down"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cm-content-body publish-content form excerpt  event-agenda  h-auto">
                                        <div class="card-body loadmore-content dlab-scroll height500  recent-activity-wrapper p-3 pt-0"
                                            id="RecentActivityContent">
                                            @foreach ($emails as $email)
                                                <div class="d-flex align-items-center event">
                                                    <div
                                                        class="icon-bx icon-bx-lg  me-3 d-flex flex-column justify-content-center">
                                                        <img alt="user-image" class=" rounded-circle img_users_fix_size"
                                                            avatar="{{ $email->subject }}">
                                                    </div>
                                                    <div class="event-info">
                                                        <h6 class="mb-0">{{ $email->subject }} <span
                                                                class="text-primary">{{ $email->created_at->diffForHumans() }}</span>
                                                        </h6>
                                                        <p class="mb-0">{{ $email->to }}</p>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                                <div class="filter cm-content-box box-primary">
                                    <div class="content-title SlideToolHeader">
                                        <div class="cpa">
                                            Lable
                                        </div>
                                        <div class="tool">
                                            <a class="btn btn-sm btn-primary btn-icon " data-size="md" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ __('Labels') }}" data-ajax-popup="true" data-size="md" data-title="{{ __('Label') }}"
                                            data-url="{{ URL::to('lead/' . $lead->id . '/labels') }}"><i class="ti ti-tag text-white"></i></a>
                                        </div>
                                    </div>
                                    <div class="cm-content-body  form excerpt">
                                        <div class="card-body">
                                            @php($labels = $lead->labels())
                                            @if ($labels)
                                                @foreach ($labels as $label)
                                                    <p
                                                        class="badge light badge-{{ $label->color }} badge-lg ">{{ $label->name }}</p>
                                                @endforeach
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('after-scripts')
    <script src="{{ asset('assets/js/dashboard/cms.js') }}"></script>

    <script>
        var swiper = new Swiper('.ticketing-Swiper', {
            speed: 1500,
            slidesPerView: 4,
            spaceBetween: 40,
            parallax: true,
            loop: false,
            autoplay: {
                Delay: 1000,
            },
            breakpoints: {

                300: {
                    slidesPerView: 1,
                    spaceBetween: 30,
                },
                576: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                991: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1600: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            },
        });
        @if (Auth::user()->type != 'client' || in_array('Client View Files', $permission))
            Dropzone.autoDiscover = false;
            myDropzone2 = new Dropzone("#dropzonewidget2", {
                maxFiles: 20,
                maxFilesize: 20,
                parallelUploads: 1,
                acceptedFiles: ".jpeg,.jpg,.png,.pdf,.doc,.txt",
                url: "{{ route('leadfileUpload', $lead->id) }}",
                success: function(file, response) {
                    if (response.is_success) {
                        dropzoneBtn(file, response);
                    } else {
                        myDropzone2.removeFile(file);
                        toastrs('Error', response.error, 'error');
                    }
                },
                error: function(file, response) {
                    myDropzone2.removeFile(file);
                    if (response.error) {
                        toastrs('Error', response.error, 'error');
                    } else {
                        toastrs('Error', response, 'error');
                    }
                }
            });
            myDropzone2.on("sending", function(file, xhr, formData) {
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
                formData.append("lead_id", {{ $lead->id }});
            });

            function dropzoneBtn(file, response) {
                var download = document.createElement('a');
                download.setAttribute('href', response.download);
                download.setAttribute('class', "btn btn-sm btn-primary m-1");
                download.setAttribute('data-toggle', "tooltip");
                download.setAttribute('download', file.name);
                download.setAttribute('data-original-title', "{{ __('Download') }}");
                download.innerHTML = "<i class='ti ti-download'></i>";

                var del = document.createElement('a');
                del.setAttribute('href', response.delete);
                del.setAttribute('class', "btn btn-sm btn-danger mx-1");
                del.setAttribute('data-toggle', "tooltip");
                del.setAttribute('data-original-title', "{{ __('Delete') }}");
                del.innerHTML = "<i class='ti ti-trash'></i>";

                del.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (confirm("Are you sure ?")) {
                        var btn = $(this);
                        $.ajax({
                            url: btn.attr('href'),
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'DELETE',
                            success: function(response) {
                                if (response.is_success) {
                                    btn.closest('.dz-image-preview').remove();
                                } else {
                                    toastrs('Error', response.error, 'error');
                                }
                            },
                            error: function(response) {
                                response = response.responseJSON;
                                if (response.is_success) {
                                    toastrs('Error', response.error, 'error');
                                } else {
                                    toastrs('Error', response, 'error');
                                }
                            }
                        })
                    }
                });

                var html = document.createElement('div');
                html.appendChild(download);
                @if (Auth::user()->type != 'client')
                    @can('edit leads')
                        html.appendChild(del);
                    @endcan
                @endif

                file.previewTemplate.appendChild(html);
            }
            @foreach ($lead->files as $file)

                // Create the mock file:
                var mockFile2 = {
                    name: "{{ $file->file_name }}",
                    size: "{{ get_size(get_file($file->file_path)) }}"
                };
                // Call the default addedfile event handler
                myDropzone2.emit("addedfile", mockFile2);
                // And optionally show the thumbnail of the file:
                myDropzone2.emit("thumbnail", mockFile2, "{{ get_file($file->file_path) }}");
                myDropzone2.emit("complete", mockFile2);

                dropzoneBtn(mockFile2, {
                    download: "{{ get_file($file->file_path) }}",
                    delete: "{{ route('leadfileDelete', [$lead->id, $file->id]) }}"
                });
            @endforeach
        @endif
    </script>
@endpush
