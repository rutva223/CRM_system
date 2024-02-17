
@extends('layouts.guest')

@section('content')

<div class="row h-100">
    <div class="col-lg-6 align-self-start">
        <div class="account-info-area" style="background-image: url(assets/images/crm.jpg)">

        </div>
    </div>
    <div class="col-lg-6 col-md-7 col-sm-12 mx-auto align-self-center">
        <div class="login-form">
            {{-- <div class="login-head">
                <h3 class="title">Welcome Back</h3>
                <p>Register page allows users to enter login credentials for authentication and access to secure content.</p>
            </div> --}}
            <h6 class="login-title"><span>Register</span></h6>
            <div class="row mb-5">
                <div class="col-xl-6 col-sm-6 offset-xl-3">
                    <a href="javascript:void(0);" class="btn btn-outline-danger d-block social-btn">
                    <svg width="16" height="16" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M27.9851 14.2618C27.9851 13.1146 27.8899 12.2775 27.6837 11.4094H14.2788V16.5871H22.1472C21.9886 17.8738 21.132 19.8116 19.2283 21.1137L19.2016 21.287L23.44 24.4956L23.7336 24.5242C26.4304 22.0904 27.9851 18.5093 27.9851 14.2618Z" fill="#4285F4"></path>
                    <path d="M14.279 27.904C18.1338 27.904 21.37 26.6637 23.7338 24.5245L19.2285 21.114C18.0228 21.9356 16.4047 22.5092 14.279 22.5092C10.5034 22.5092 7.29894 20.0754 6.15663 16.7114L5.9892 16.7253L1.58205 20.0583L1.52441 20.2149C3.87224 24.7725 8.69486 27.904 14.279 27.904Z" fill="#34A853"></path>
                    <path d="M6.15656 16.7113C5.85516 15.8432 5.68072 14.913 5.68072 13.9519C5.68072 12.9907 5.85516 12.0606 6.14071 11.1925L6.13272 11.0076L1.67035 7.62109L1.52435 7.68896C0.556704 9.58024 0.00146484 11.7041 0.00146484 13.9519C0.00146484 16.1997 0.556704 18.3234 1.52435 20.2147L6.15656 16.7113Z" fill="#FBBC05"></path>
                    <path d="M14.279 5.3947C16.9599 5.3947 18.7683 6.52635 19.7995 7.47204L23.8289 3.6275C21.3542 1.37969 18.1338 0 14.279 0C8.69485 0 3.87223 3.1314 1.52441 7.68899L6.14077 11.1925C7.29893 7.82856 10.5034 5.3947 14.279 5.3947Z" fill="#EB4335"></path>
                    </svg>
                    <span class="ms-1 font-w500 label-color">Sign in with Google</span></a>
                </div>
            </div>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-4">
                    <label class="mb-1 form-label required">Username</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter Your Name">
                </div>
                <div class="mb-4">
                    <label class="mb-1 form-label required">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter Your Email">
                </div>
                <div class="mb-4 position-relative">
                    <label class="mb-1 form-label required">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter Password">
                    <span class="show-pass eye">
                        <i class="fa fa-eye-slash"></i>
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
                <div class="mb-4 position-relative">
                    <label class="mb-1 form-label required">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Enter Confirm Password">
                    <span class="show-pass eye">
                        <i class="fa fa-eye-slash"></i>
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
                <div class="form-row d-flex justify-content-between mt-4 mb-2">
                    <div class="mb-4">
                        <div class="form-check custom-checkbox mb-3">
                            <input type="checkbox" class="form-check-input" id="customCheckBox1" required="">
                            <label class="form-check-label" for="customCheckBox1">Remember my preference</label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <a href="page-forgot-password.html" class="btn-link text-primary">Forgot Password?</a>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <button type="submit" class="btn btn-primary btn-block">Sign me up</button>
                </div>
                <p class="text-center">Not sign in ?
                    <a class="btn-link text-primary" href="{{ route('login')}}">Sign in</a>
                </p>
            </form>
        </div>
    </div>
</div>

@endsection
