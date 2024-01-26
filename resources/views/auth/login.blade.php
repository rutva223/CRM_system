{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}


@extends('layouts.guest')

@section('content')

<div class="row">
    <div class="col-lg-6 align-self-start">
        <div class="account-info-area" style="background-image: url(images/rainbow.gif)">
            <div class="login-content">
                <p class="sub-title">Log in to your admin dashboard with your credentials</p>
                <h1 class="title">The Evolution of <span>Finlab</span></h1>
                <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                    incididunt</p>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-7 col-sm-12 mx-auto align-self-center">
        <div class="login-form">
            {{-- <div class="login-head">
                <h3 class="title">Welcome Back</h3>
                <p>Login page allows users to enter login credentials for authentication and access to secure
                    content.</p>
            </div> --}}
            <h6 class="login-title"><span>Login</span></h6>
            <div class="row mb-5">
                <div class="col-xl-6 col-sm-6">
                    <a href="javascript:void(0);" class="btn btn-outline-danger d-block social-btn">
                        <svg width="16" height="16" viewBox="0 0 28 28" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M27.9851 14.2618C27.9851 13.1146 27.8899 12.2775 27.6837 11.4094H14.2788V16.5871H22.1472C21.9886 17.8738 21.132 19.8116 19.2283 21.1137L19.2016 21.287L23.44 24.4956L23.7336 24.5242C26.4304 22.0904 27.9851 18.5093 27.9851 14.2618Z"
                                fill="#4285F4"></path>
                            <path
                                d="M14.279 27.904C18.1338 27.904 21.37 26.6637 23.7338 24.5245L19.2285 21.114C18.0228 21.9356 16.4047 22.5092 14.279 22.5092C10.5034 22.5092 7.29894 20.0754 6.15663 16.7114L5.9892 16.7253L1.58205 20.0583L1.52441 20.2149C3.87224 24.7725 8.69486 27.904 14.279 27.904Z"
                                fill="#34A853"></path>
                            <path
                                d="M6.15656 16.7113C5.85516 15.8432 5.68072 14.913 5.68072 13.9519C5.68072 12.9907 5.85516 12.0606 6.14071 11.1925L6.13272 11.0076L1.67035 7.62109L1.52435 7.68896C0.556704 9.58024 0.00146484 11.7041 0.00146484 13.9519C0.00146484 16.1997 0.556704 18.3234 1.52435 20.2147L6.15656 16.7113Z"
                                fill="#FBBC05"></path>
                            <path
                                d="M14.279 5.3947C16.9599 5.3947 18.7683 6.52635 19.7995 7.47204L23.8289 3.6275C21.3542 1.37969 18.1338 0 14.279 0C8.69485 0 3.87223 3.1314 1.52441 7.68899L6.14077 11.1925C7.29893 7.82856 10.5034 5.3947 14.279 5.3947Z"
                                fill="#EB4335"></path>
                        </svg>

                        <span class="ms-1 font-w500 label-color">Sign in with Google</span></a>
                </div>
                <div class="col-xl-6 col-sm-6">
                    <a href="javascript:void(0);" class="btn btn-outline-dark d-block apple social-btn">
                        <svg clip-rule="evenodd" fill-rule="evenodd" height="16"
                            image-rendering="optimizeQuality" shape-rendering="geometricPrecision"
                            text-rendering="geometricPrecision" viewBox="0 0 256002 256300" width="16"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="Layer_x0020_1" fill="#cecccd" fill-rule="nonzero">
                                <path
                                    d="m179759 24214c-2454 7533-6427 14516-11214 20324v10c-4829 5841-11280 11005-18458 14429-6587 3141-13809 4834-20994 4273l-2199-171-290-2190c-933-7061 145-14210 2415-20824 2642-7699 6922-14723 11514-20045l-1-1c4752-5567 11125-10411 17949-13920 6848-3521 14203-5722 20896-5995l2530-104 278 2529c811 7392-175 14778-2426 21685z" />
                                <path
                                    d="m226282 90629c-2425 1500-25871 16009-25581 45251 307 35254 30199 47475 31849 48150h11l71 29 2345 971-803 2400c-47 143 6-8-64 215-761 2444-5932 19008-17612 36076-5300 7742-10700 15473-17076 21435-6601 6174-14140 10341-23454 10514-8779 165-14526-2322-20500-4906-5696-2465-11621-5029-20892-5029-9739 0-15965 2652-21960 5207-5645 2404-11104 4730-18969 5044h-10c-9082 338-16957-4089-23955-10647-6695-6273-12562-14487-17908-22219-12067-17424-22561-42776-25804-68555-2667-21205-438-42745 9814-60535 5723-9953 13721-18077 23073-23744 9310-5642 19960-8854 31046-9019v-1c9706-176 18858 3456 26866 6634 5667 2249 10716 4253 14502 4253 3343 0 8273-1944 14019-4209 9706-3827 21579-8508 34133-7259 5274 229 16256 1493 27482 7576 7151 3876 14406 9695 20368 18421l1572 2302-2348 1517c-126 81-4-3-215 128z" />
                            </g>
                            <path d="m0 298h256002v256002h-256002z" fill="none" />
                        </svg>
                        <span class="ms-1 ">Sign in with Apple</span></a>
                </div>
            </div>
            {{ Form::open(['route' => 'login', 'method' => 'post', 'id' => 'loginForm']) }}
                @csrf
                <div class="mb-4">
                    <label class="mb-1 form-label required">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter Your Email">
                </div>
                <div class="mb-4 position-relative">
                    <label class="mb-1 form-label required">Password</label>
                    <input type="password" name="password" id="dlab-password" class="form-control" placeholder="Enter Your Password">
                    <span class="show-pass eye">
                        <i class="fa fa-eye-slash"></i>
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
                <div class="form-row d-flex justify-content-between mt-4 mb-2">
                    <div class="mb-4">
                        
                    </div>
                    <div class="mb-4">
                        <a href="{{ route('password.request')}}" class="btn-link text-primary">Forgot Password?</a>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                </div>
                <p class="text-center">Not registered?
                    <a class="btn-link text-primary" href="{{ route('register')}}">Register</a>
                </p>
            {{ Form::close() }}
        </div>
    </div>
</div>

@endsection

