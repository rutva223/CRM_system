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

@section('content')
<div class="col-xl-12">
   <div class="row">
        @foreach ($contacts as $c)
            <div class="col-xl-3 col-md-6">
                <div class="card contact_list">
                    <div class="card-body">
                        <div class="user-content">
                            <div class="user-info">
                                <img src="{{ asset($c->avatar ? 'assets/images/avatar/' . $c->avatar : 'assets/images/avatar/1.png')}}" class="avatar avatar-lg me-3" alt="">
                                <div class="user-details">
                                    <h5 class="mb-0">{{ $c->name }}</h5>
                                    <p class="mb-0 text-primary">+{{ $c->phone_no }}</p>
                                    <p class="mb-0">{{ $c->email }}</p>
                                </div>
                            </div>
                            <div class="contact-button">
                                <a href="{{ route('contacts.edit', $c->id) }}" class="btn-link btn sharp tp-btn btn-primary" aria-expanded="false">
                                        <i class="fa fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
   </div>
</div>
@endsection

@push('after-scripts')

@endpush
