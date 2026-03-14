<!DOCTYPE html>
<html lang="en"
    @if (Session::get('locale') == 'en') direction="ltr" dir="ltr" style="direction: ltr;"
@else
direction="rtl" dir="rtl" style="direction: rtl;" @endif>
<!--begin::Head-->

<head>
    <title>د بندیانو د ثبت اداري سیستم</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />

    <link rel="shortcut icon" href="{{ asset('frontend/logo/moi_logo.png') }}" />
    <!--begin::Fonts-->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" /> --}}
    <!--end::Fonts-->

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">









    <link href="{{ asset('assets/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <!--begin::Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.rtl.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />


    @if (Session::get('locale') == 'en')
        <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    @else
        <link href="{{ asset('assets/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    @endif

    <link rel="stylesheet" href="{{ asset('datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/loader/css/preloader.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome.css') }}">
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css" />

    @if (Session::get('locale') == 'pa' || Session::get('locale') == 'fa')
        <style>
            @font-face {
                font-family: 'Bahij';
                src: url('{{ asset('assets/fonts/bahij.ttf') }}') format('truetype');
            }

            * {
                font-family: 'Bahij', 'Roboto', sans-serif;
                font-size: 16px !important;
            }
        </style>
    @endif
    @yield('css')
    <style>
        .select2-container {
            width: 100% !important;
            font-size: 14px;
        }


        .is-invalid .select2-selection,
        .needs-validation~span>.select2-dropdown {
            border-color: red !important;
        }


        .select2-container--bootstrap-5 .select2-selection {
            min-height: 38px;
            padding: 6px 12px;
            font-size: 14px;
        }

        .select2-container--bootstrap-5 .select2-selection--single {
            line-height: 24px;
        }

        .select2-container--bootstrap-5 .select2-selection__arrow {
            height: 38px;
        }

        .select2-container--bootstrap-5 .select2-dropdown {
            font-size: 14px;
            direction: rtl;
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
    <!--begin::Theme mode setup on page load-->



    @include('layouts.partials.theme_mode')
    <!--end::Theme mode setup on page load-->
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root someBlock" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            @include('layouts.partials.header')
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::sidebar-->
                @include('layouts.partials.sidebar')
                <!--end::sidebar-->
                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                @yield('content')
                            </div>
                            <!--end::Content container-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Content wrapper-->
                    <!--begin::Footer-->
                    @include('layouts.partials.footer')
                    <!--end::Footer-->
                </div>
                <!--end:::Main-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->

    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
        <span class="svg-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1"
                    transform="rotate(90 13 6)" fill="currentColor" />
                <path
                    d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                    fill="currentColor" />
            </svg>
        </span>
        <!--end::Svg Icon-->
    </div>
    <!--end::Scrolltop-->

    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>


    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    {{-- <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script> --}}
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used by this page)-->
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <!--end::Custom Javascript-->
    <script src="{{ asset('assets/plugins/custom/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>



    <script src="{{ asset('datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('datepicker/bootstrap-datepicker.fa.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/custom/loader/js/jquery.preloader.js') }}"></script>
    {{-- Summernote  --}}
    {{-- <script src="{{ asset('assets/plugins/custom/summernote/summernote-bs4.js') }}"></script> --}}
    <!-- Select2 JS -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script src="{{ asset('assets/js/custom/sweetalert.js') }}"></script>

    <script>
        $('.select2').select2({
            width: '100%',
        });

        function success(msg) {

            Swal.fire({
                title: 'معلومات ذخیره شد',
                text: msg.data,
                icon: 'success',
                showConfirmButton: true,
                allowOutsideClick: false,
                onConfirm: () => {
                    // This function will be called when the user clicks the "Confirm" button
                    Swal.close();
                },
                timer: 100000
            });

            // Swal.fire({
            //     title: msg,
            //     text: "",
            //     type: "success",
            //     confirmButtonText: 'بستن',
            //     confirmButtonColor: "#0eacf9",
            //     timer: 10000
            // });
        }

        function error_function(msg) {
            Swal.fire({
                title: msg,
                text: "",
                type: "error",
                confirmButtonText: 'بستن'
            });
        }
        var timeout = ({{ config('session.lifetime') }} * 60000) + 1000;
        setTimeout(function() {
            window.location.reload(1);
        }, timeout);
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', 'input[type="date"]', function(e) {
                e.preventDefault();
            });

            $('[type="date"]').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: "yy-mm-dd",
                defaultDate: new Date() // This sets the current date as the default date
            }).datepicker("setDate", new Date()); // This sets the current date as the selected date
        });
    </script>
    @yield('scripts')
</body>
<!--end::Body-->

</html>
