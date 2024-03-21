@extends('layouts.main')

@section('title')
    {{ __('Contact Information') }}
@endsection
@section('page-breadcrumb')
    {{ __('Contact Information') }}
@endsection
@section('page-action')
    <a href="{{ route('contacts.create') }}" class="btn btn-sm btn-primary">
        <i class="fa fa-plus text-white"></i>
    </a>
@endsection
@push('css')
@endpush
@section('content')
    <div class="col-xl-12">
        <div class="row">
            @forelse ($contacts as $c)
                <div class="col-md-3 mb-4">
                    <div class="card text-center card-2">
                        <div class="card-header border-0 pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                {{-- <h6 class="mb-0">
                                        <div class="badge bg-primary p-2 px-3 rounded">
                                            HR
                                        </div>
                                    </h6> --}}
                            </div>
                            <div class="dropdown custom-dropdown ms-2">
                                <div class="btn sharp btn-primary tp-btn sharp-sm" data-bs-toggle="dropdown">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="12" cy="5" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="19" r="2"></circle></g></svg>
                                </div>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('contacts.edit', $c->id) }}" class="dropdown-item">
                                        <i class="ti ti-pencil"></i>
                                        <span>{{ __('Edit') }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body full-card">
                            <div class="img-fluid rounded-circle card-avatar">
                                <img src="{{ asset($c->avatar ? 'assets/images/avatar/' . $c->avatar : 'assets/images/avatar/1.png') }}"
                                    class="img-user wid-80 round-img rounded-circle" alt="img">
                            </div>
                            <h4 class=" mt-3">{{ $c->name }}</h4>
                            <a href="mailto:{{ $c->email }}"><small class="text-primary">{{ $c->email }}</small></a>
                            <div class="text-center" data-bs-toggle="tooltip" title=""
                                data-bs-original-title="Last Login">
                                {{ $c->created_at }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                @include('layouts.nodatafound')
            @endforelse
        </div>
    </div>
@endsection

@push('after-scripts')
    <script src="{{ asset('assets/js/required.js') }}"></script>
@endpush
