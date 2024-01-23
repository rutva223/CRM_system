@extends('layouts.main')

@section('title')
{{ __('Manage Setting') }}
@endsection

@section('content')
<div class="page-titles">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Setting</li>
        </ol>
    </nav>
</div>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Email Setting</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                {{ Form::open(['route' => 'email.settings', 'method' => 'post']) }}
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-label form-label">Mail Mailer</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="mail_mailer" placeholder="Enter a Mail Driver.." required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-label form-label">Mail Host</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="mail_host" placeholder="Enter a Mail Host.." required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-label form-label">Mail Port</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="mail_port" placeholder="Enter a Mail Port.." required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-label form-label">Mail Username</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="mail_username" placeholder="Enter a Mail Username.." required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-label form-label">Mail Password</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="mail_password" placeholder="Enter a Mail Password.." required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-label form-label">Mail From Address</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="mail_from_address" placeholder="Enter a Mail From Address.." required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-label form-label">Mail From Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="mail_from_name" placeholder="Enter a Mail From Name.." required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger light">Cancel</button>
                    <button type="submit" class="btn me-2 btn-primary">Submit</button>
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>

@endsection
