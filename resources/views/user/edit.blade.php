@extends('layouts.main')
@section('title')
    {{ __('Update Profile') }}
@endsection
@section('page-breadcrumb')
    {{ __(' Update Profile') }}
@endsection
<style>
    .nav-pills .nav-link.active,
    .nav-pills:hover .show>.nav-link {
        background-color: var(--primary) !important;
    }
</style>
@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center mb-3">
                <div class="col-md-8">
                </div>
                <div class="col-md-4">
                    <ul class="nav nav-pills nav-fill cust-nav information-tab" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="personal_details-tab" data-bs-toggle="pill"
                                data-bs-target="#personal_details" type="button">{{ __('Personal Details') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="shipping_details-tab" data-bs-toggle="pill"
                                data-bs-target="#shipping_details" type="button">{{ __('Shipping Details') }}</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{ Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT']) }}
    <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="clearfix">
                <div class="card card-bx profile-card author-profile m-b30">
                    <div class="card-body">
                        <div class="p-5">
                            <div class="author-profile">
                                <div class="author-media">
                                    @if ($user->avatar != null)
                                        <img src="{{ asset('/avatars/' . $user->avatar) }}">
                                    @else
                                        <img src="{{ asset('/assets/images/avatar/1.png') }}">
                                    @endif
                                    <div class="upload-link" title="" data-toggle="tooltip" data-placement="right"
                                        data-original-title="update">
                                        <input type="file" class="update-flie" name="image">
                                        <i class="fa fa-camera"></i>
                                    </div>
                                </div>
                                <div class="author-info">
                                    <h6 class="title">Nella Vita</h6>
                                    <span>Developer</span>
                                </div>
                            </div>
                        </div>
                        <div class="info-list">
                            <ul>
                                <li><a href="app-profile.html">Models</a><span>36</span></li>
                                <li><a href="uc-lightgallery.html">Gallery</a><span>3</span></li>
                                <li><a href="app-profile.html">Lessons</a><span>1</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="input-group mb-3">
                            <div class="form-control rounded text-center">Portfolio</div>
                        </div>
                        <div class="input-group">
                            <a href="https://www.dexignlab.com/" target="_blank"
                                class="form-control text-primary rounded text-center">https://www.dexignlab.com/</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-content col-xl-9 col-lg-8" id="pills-tabContent">
            <div class="tab-pane fade show active" id="personal_details" role="tabpanel"
                aria-labelledby="pills-personal_details-tab">
                <div class="card profile-card card-bx m-b30">
                    <div class="card-header">
                        <h4 class="card-title">Personal Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="f_name" class="text-label form-label required">First Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="f_name"
                                            placeholder="Enter First Name.." required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="l_name" class="text-label form-label required">Last Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="l_name"
                                            placeholder="Enter Last Name.." required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="text-label form-label required">Email</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="email"
                                            placeholder="Enter Email.." required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone_no" class="text-label form-label required">Phone No.</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="phone_no"
                                            placeholder="Enter Phone Number.." required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="assistants_name" class="text-label form-label required">Assistants
                                        Names</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="assistants_name"
                                            placeholder="Enter Assistants Name.." required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="assistants_mail" class="text-label form-label required">Assistants
                                        Mail</label>
                                    <div class="input-group">
                                        <input type="email" class="form-control" name="assistants_mail"
                                            placeholder="Enter Assistants Mails.." required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="assistants_phone" class="text-label form-label required">Assistants
                                        Phone</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="assistants_phone"
                                            placeholder="Enter Assistants Phone.." required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="department_name" class="text-label form-label required">Department
                                        Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="department_name"
                                            placeholder="Enter Department Name.." required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="dob" class="text-label form-label required">Date Of Birth</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="dob" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="social_media_profile" class="text-label form-label">Social Media
                                        Profile</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="social_media_profile"
                                            placeholder="Enter Social Media Profile..">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="notes" class="text-label form-label">Notes</label>
                                    <div class="input-group">
                                        <textarea rows="3" class="form-control" name="notes" placeholder="Enter About User Note.."></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="send_mail" class="text-label form-label">Send In Mail</label>
                                    <div class="input-group">
                                        <div class="col-xl-4 col-xxl-6 col-6">
                                            <div class="form-check custom-checkbox mb-3">
                                                <input type="checkbox" name="send_mail" class="form-check-input">
                                                <label class="form-check-label">Send Mail</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="shipping_details" role="tabpanel"
                aria-labelledby="pills-shipping_details-tab">
                <div class="card profile-card card-bx m-b30">
                    <div class="card-header">
                        <h4 class="card-title">Shipping Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-label form-label">Billing City</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="billing_city"
                                            placeholder="Enter Billing City..">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-label form-label">Billing State</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="billing_state"
                                            placeholder="Enter Billing State..">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-label form-label">Billing Country</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="billing_country"
                                            placeholder="Enter Billing Country..">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-label form-label">Billing Zip</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="billing_zip"
                                            placeholder="Enter Billing Zip..">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary mb-3" id="copyBilling">Copy Billing
                                Address</button>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-label form-label">shipping City</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="shipping_city"
                                            placeholder="Enter shipping City..">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-label form-label">Shipping State</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="shipping_state"
                                            placeholder="Enter Shipping State..">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-label form-label">Shipping Country</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="shipping_country"
                                            placeholder="Enter Shipping Country..">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-label form-label">Shipping Zip</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="shipping_zip"
                                            placeholder="Enter Shipping Zip..">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-end">
            <button type="button" class="btn btn-danger light">Cancel</button>
            <button type="submit" class="btn me-2 btn-primary" id="createButton" disabled>Submit</button>
        </div>

    </div>
    {{ Form::close() }}
@endsection
