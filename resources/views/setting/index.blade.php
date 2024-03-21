@extends('layouts.main')

@section('title')
    {{ __('Manage Setting') }}
@endsection
@section('page-breadcrumb')
    {{ __('Setting') }}
@endsection
@push('css')
<style>
    .nav-pills .nav-link.active, .nav-pills:hover .show > .nav-link {
    background-color: var(--primary) !important;
}
</style>
@endpush
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center mb-3">
                <div class="col-md-8">
                </div>
                <div class="col-md-4">
                    <ul class="nav nav-pills nav-fill cust-nav information-tab" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ session('active_tab', 'email_setting') == 'email_setting' ? 'active' : '' }}" id="email_setting-tab" data-bs-toggle="pill"
                                data-bs-target="#email_setting" type="button">{{ __('Email Setting') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ session('active_tab') == 'payment_setting' ? 'active' : '' }}" id="payment_setting-tab" data-bs-toggle="pill"
                                data-bs-target="#payment_setting" type="button">{{ __('Payment Setting') }}</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade {{ session('active_tab','email_setting') == 'email_setting' ? 'show active' : '' }}" id="email_setting" role="tabpanel" aria-labelledby="pills-email_setting-tab">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Email Setting</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            {{ Form::model($Settings,['route' => 'email.settings', 'method' => 'post','id'=>'payment-form']) }}
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label required">Mail Mailer</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="mail_mailer" value="{{ $Settings['mail_mailer'] ?? '' }}" placeholder="Enter a Mail Driver.." required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label required">Mail Host</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="mail_host" value="{{ $Settings['mail_host'] ?? '' }}" placeholder="Enter a Mail Host.." required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label required">Mail Port</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="mail_port" value="{{ $Settings['mail_port'] ?? '' }}" placeholder="Enter a Mail Port.." required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label required">Mail Username</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="mail_username" value="{{ $Settings['mail_username'] ?? '' }}" placeholder="Enter a Mail Username.." required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label required">Mail Password</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="mail_password" value="{{ $Settings['mail_password'] ?? '' }}" placeholder="Enter a Mail Password.." required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label required">Mail From Address</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="mail_from_address" value="{{ $Settings['mail_from_address'] ?? '' }}" placeholder="Enter a Mail From Address.." required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label required">Mail From Name</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="mail_from_name" value="{{ $Settings['mail_from_name'] ?? ''   }}" placeholder="Enter a Mail From Name.." required>
                                        </div>
                                    </div>
                                </div>
                                <input type="button" value="{{__('Cancel')}}" class="btn btn-light" id="cancelButton" data-bs-dismiss="modal">
                                <input type="submit" value="{{__('Submit')}}" class="btn btn-primary" id="createButton" disabled>
                            {{Form::close()}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade {{ session('active_tab') == 'payment_setting' ? 'show active' : '' }}" id="payment_setting" role="tabpanel" aria-labelledby="pills-payment_setting-tab">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Payment Setting</h4>
                    </div>
                </div>
                <div class="">
                    <div class="cm-content-box">
                        <div class="content-title SlideToolHeader">
                            <div class="card-header">
                                <h4 class="card-title">Stripe</h4>
                            </div>
                            <div class="tools" style="margin-right: 30px;">
                                <a href="javascript:void(0);" class="expand handle"><i class="fal fa-angle-down"></i></a>
                            </div>
                        </div>
                        <div class="cm-content-body form excerpt">
                            <div class="card-body">
                                <div class="basic-form">
                                    {{ Form::model($Settings, ['route' => 'payment.settings', 'method' => 'post','id'=>'payment_form']) }}
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="text-label form-label required">Currency</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="stripe_currency" value="{{ $Settings['stripe_currency'] ?? '' }}" placeholder="Enter Currancy.." required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="text-label form-label required">Stripe Key</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="stripe_key" value="{{ $Settings['stripe_key'] ?? '' }}" placeholder="Enter Stripe Key.." required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="text-label form-label required">Stripe Secret Key</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="stripe_secret_key" value="{{ $Settings['stripe_secret_key'] ?? '' }}" placeholder="Enter Stripe Secret Key.." required>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" id="cancelButton1" data-bs-dismiss="modal">
                                    <input type="submit" value="{{__('Submit')}}" class="btn btn-primary">
                                    {{Form::close()}}
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
<script>
    $(document).ready(function () {
        $('#cancelButton').on('click', function () {
            $('#payment-form')[0].reset();
        });
        $('#cancelButton1').on('click', function () {
            $('#payment_form')[0].reset();
        });
    });
</script>

@endpush
