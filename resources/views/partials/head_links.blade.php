<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon_io/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon_io/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon_io/favicon-16x16.png') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
<link href="{{ asset('assets/vendor/wow-master/css/libs/animate.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-select-country/css/bootstrap-select-country.min.css') }}">
<link href="{{ asset('assets/vendor/datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<!--swiper-slider-->
<link rel="stylesheet" href="{{ asset('assets/vendor/swiper/css/swiper-bundle.min.css') }}">
<!-- Style css -->
 <!-- Datatable -->
 <link href="{{ asset('assets/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
 <link href="{{ asset('assets/vendor/datatables/responsive/responsive.css') }}" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/vendor/toastr/toastr.min.css') }}">
<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">


<style>
    .blur {
    filter: blur(1px);
        pointer-events: none;
    }

    #loader {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Adjust the opacity as needed */
    }

    .loader-spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 3px solid #fff;
        border-top-color: #333;
        /* Adjust the color as needed */
        animation: spin 1s linear infinite;
    }

    .loader-text {
        position: absolute;
        top: 52%;
        left: 50%;
        transform: translate(-50%, -50%);
        margin-top: 20px;
        text-align: center;
        color: #fff;
        /* Adjust the color as needed */
        font-weight: bold;
    }

    @keyframes spin {
        0% {
            transform: translate(-50%, -50%) rotate(0deg);
        }

        100% {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }
</style>
