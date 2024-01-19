{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html> --}}


<!DOCTYPE html>
<html lang="en" <head>

<!-- Title -->
<title>Laravel</title>

<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="author" content="Dexignlabs">
<meta name="robots" content="">

<meta name="keywords"
	content="admin dashboard, admin template, analytics, bootstrap, bootstrap 5 admin template, finance admin, admin, modern, responsive admin dashboard, sales dashboard, sass, ui kit, web app, bootstrap5, admin panel, Crypto Trading, Cryptocurrency, Trading Platform, Financial Insights, Efficiency, Data Visualization, User-Friendly, User Interface, Investment, Financial Management, Trading Tools, Performance Metrics, Real-Time Data, Portfolio Optimization, bitcoin, share market">

<meta name="twitter:image" content="https://finlab.dexignlab.com/xhtml/social-image.png">
<meta name="twitter:card" content="summary_large_image">

<!-- Mobile Specific -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- FAVICONS ICON -->
<link rel="shortcut icon" type="image/png" href="images/favicon.png">
<link href="{{ asset('assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
<link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">

</head>

<body>
	<div class="login-account">
        @yield('content')
    </div>
    <script src="{{ asset('assets/vendor/global/global.min.js')}}"></script>
	<script src="{{ asset('assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
	<script src="{{ asset('assets/js/custom.min.js')}}"></script>
	<script src="{{ asset('assets/js/dlabnav-init.js')}}"></script>
</body>

</html>
