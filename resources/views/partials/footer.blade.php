<!-- Required vendors -->
<script src="{{ asset('assets/vendor/global/global.min.js') }}"></script>
<script src="{{ asset('assets/vendor/chart-js/chart.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<!-- Apex Chart -->
<script src="{{ asset('assets/vendor/apexchart/apexchart.js') }}"></script>
<!-- Chart piety plugin files -->
<script src="{{ asset('assets/vendor/peity/jquery.peity.min.js') }}"></script>

<!--swiper-slider-->
<script src="{{ asset('assets/vendor/swiper/js/swiper-bundle.min.js') }}"></script>
<!-- Dashboard 1 -->
{{-- <script src="{{ asset('assets/js/dashboard/dashboard-1.js') }}"></script> --}}
<script src="{{ asset('assets/vendor/wow-master/dist/wow.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-datetimepicker/js/moment.js') }}"></script>
<script src="{{ asset('assets/vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-select-country/js/bootstrap-select-country.min.js') }}"></script>

<script src="{{ asset('assets/js/dlabnav-init.js') }}"></script>
<script src="{{ asset('assets/js/custom.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
  @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
  @endif
  @if(Session::has('info'))
        toastr.info("{{ Session::get('info') }}");
  @endif
  @if(Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
  @endif
  @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
  @endif
</script>


<script>
    $(function() {
        $("#datepicker").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('update', new Date());

    });

    $(document).ready(function() {
        $(".booking-calender .fa.fa-clock-o").removeClass(this);
        $(".booking-calender .fa.fa-clock-o").addClass('fa-clock');
    });
    $('.my-select').selectpicker();
</script>
