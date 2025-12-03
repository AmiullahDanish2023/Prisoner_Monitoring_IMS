<!DOCTYPE html>
<html lang="en" @if (Session::get('locale') != 'en') dir="rtl" @endif>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ $setting->name }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset($setting->logo) }}" rel="icon">
    <link href="{{ asset('frontend/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <!-- Google Fonts -->
    {{-- <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet"> --}}

    <!-- Vendor CSS Files -->
    <link href="{{ asset('frontend/assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    {{-- Data Table  --}}
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Template Main CSS File -->
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
    @yield('css')
    <!-- =======================================================
  * Template Name: Medilab
  * Template URL: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/
  * Updated: Mar 17 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
    @if (Session::get('locale') != 'en')
        <link rel="stylesheet" href="{{ asset('frontend/boostrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/bootstrap.rtl.min.css') }}">
        <style>
            [dir="rtl"] .my-element {
                right: 20px;
                /* instead of left: 20px; */
            }
        </style>
    @endif
    @if (Session::get('locale') == 'pa' || Session::get('locale') == 'fa')
        <style>
            @font-face {
                font-family: 'Bahij';
                src: url('{{ asset('assets/fonts/bahij.ttf') }}') format('truetype');
            }

            body,
            label,
            a,
            h2,
            h3,
            h4,
            p,
            .logo-title {
                font-family: 'Bahij', 'Roboto', sans-serif;
                font-size: 17px !important;
            }
        </style>
    @endif

</head>

<body>

    <!-- ======= Top Bar ======= -->
    <div id="topbar" class="d-flex align-items-center fixed-top top_bar">
        <div class="container-fluid d-flex justify-content-between top_bar">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope"></i> <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>
                <i class="bi bi-phone"></i>+93-{{ $setting->number }}
            </div>
            <div class="d-none d-lg-flex social-links align-items-center">
                @if (!empty($setting->facebook_link))
                    <a href="{{ $setting->facebook_link }}" class="facebook" target="_blank"><i class="bi bi-facebook"></i></a>
                @endif
                @if (!empty($setting->instagram_link))
                    <a href="{{ $setting->instagram_link }}" class="instagram" target="_blank"><i class="bi bi-instagram"></i></a>
                @endif
                @if (!empty($setting->twiter_link))
                    <a href="{{ $setting->twiter_link }}" class="twitter" target="_blank"><i class="bi bi-twitter"></i></a>
                @endif
                @if (!empty($setting->linkedin_link))
                    <a href="{{ $setting->linkedin_link }}" class="linkedin" target="_blank"><i class="bi bi-linkedin"></i></i></a>
                @endif
            </div>
        </div>
    </div>


    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container-fluid d-flex align-items-center justify-content-between">

            <div class="d-flex align-items-center">
                <img src="{{ asset('uploads/default_log.png') }}" width="60" alt="logo">

                <span class="me-auto why-us text-center m-2 header_title" >
                    <b>{{ $setting->name }}</b>
                </span>
            </div>

            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo me-auto"></a>-->
            <div class="d-flex align-items-center">
                <nav id="navbar" class="navbar order-last order-lg-0 na">
                    <ul>
                        @if (stripos(request()->fullUrl(), 'book-detail') == false)
                            <li><a class="nav-link scrollto active no-underline"
                                    href="#hero">{{ __('translate.home') }}
                                </a>
                            </li>
                            <li><a class="nav-link scrollto no-underline"
                                    href="#about ">{{ __('translate.about') }}</a>
                            </li>

                            <li><a class="nav-link scrollto no-underline"
                                    href="#doctors">{{ __('translate.doctors') }}</a>
                            </li>
                            <li><a class="nav-link scrollto no-underline"
                                    href="#books">{{ __('translate.books') }}</a>
                            </li>
                            <li><a class="nav-link scrollto no-underline"
                                    href="#contact">{{ __('translate.contact') }}</a>
                            </li>
                                    <li class="dropdown"><a href="#"
                                            class="no-underline"><b>{{ __('translate.language') }}</b> </a>
                                        <ul>
                                            <li><a class="no-underline"
                                                href="{{ route('site.pa') }}">{{ __('translate.pashto') }}</a></li>
                                            <li><a class="no-underline"
                                                href="{{ route('site.fa') }}">{{ __('translate.dari') }}</a></li>
                                            <li><a class="no-underline"
                                                    href="{{ route('site.en') }}">{{ __('translate.english') }}</a></li>
                                        </ul>
                                    </li>
                        @else
                            <li>
                                <a href="/" class="nav-link scrollto no-underline">{{ __('translate.home') }}</a>
                            </li>
                        @endif

                    </ul>

                    {{-- <i class="bi bi-list mobile-nav-toggle" style="border:1px solid red; class="openbtn" onclick="openNav()"></i> --}}
                        <button class="openbtn" onclick="openNav()" style="margin-inline:10px">&#9776;</button>
                </nav>

                <a href="{{ route('login') }}" class="appointment-btn scrollto no-underline">
                    {{ __('translate.login') }}</a>
            </div>
        </div>

        <div id="mySidepanel" class="sidepanel">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a class="nav-link scrollto active no-underline mobileMenu"
                href="#hero"onclick="closeNav()">{{ __('translate.home') }}
            </a>

        <a class="nav-link scrollto no-underline mobileMenu"
                href="#about" onclick="closeNav()">{{ __('translate.about') }}</a>
         <a class="nav-link scrollto no-underline mobileMenu"
                href="#doctors" onclick="closeNav()">{{ __('translate.doctors') }}</a>

        <a class="nav-link scrollto no-underline mobileMenu"
                href="#books" onclick="closeNav()">{{ __('translate.books') }}</a>
        <a class="nav-link scrollto no-underline mobileMenu"
                href="#contact" onclick="closeNav()">{{ __('translate.contact') }}</a>
                <a class="dropdown mobileMenu"
                        class="no-underline"><b>{{ __('translate.language') }}</b> </a>
                    <ul class="mobileMenuLang">
                        <li class=""><a class="no-underline "
                            href="{{ route('site.pa') }}">{{ __('translate.pashto') }}</a></li>
                        <li class="mobileMen"><a class="no-underline "
                            href="{{ route('site.fa') }}">{{ __('translate.dari') }}</a></li>
                        <li class="mobileMen"><a class="no-underline "
                                href="{{ route('site.en') }}">{{ __('translate.english') }}</a></li>
                    </ul>
          </div>

    </header>
    <!-- End Header -->

    @yield('contents')

    <!-- ======= Footer ======= -->
    <footer id="footer">
        @if (stripos(request()->fullUrl(), 'book-detail') == false)
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2 col-md-6 footer-links">
                            <h4>{{ __('translate.useful links') }}</h4>
                            <ul>
                                <li><i class="bx bx-chevron-right"></i> <a href="#"
                                        class="no-underline">{{ __('translate.home') }}</a>
                                </li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#"
                                        class="no-underline">{{ __('translate.about') }}</a>
                                </li>
                                <li><i class="bx bx-chevron-right"></i> <a class="no-underline"
                                        href="#">{{ __('translate.services') }}</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-2 col-md-6 footer-links">
                            <h4>{{ __('translate.useful links') }}</h4>
                            <ul>
                                <li><i class="bx bx-chevron-right"></i>
                                    <a href="#" class="no-underline">{{ __('translate.doctors') }}</a>
                                </li>
                                <li><i class="bx bx-chevron-right"></i>
                                    <a href="#" class="no-underline">{{ __('translate.contact') }}</a>
                                </li>
                            </ul>
                        </div>


                    </div>
                </div>
            </div>
        @endif
        <div class="container d-md-flex py-4">

            <div class="me-md-auto text-center text-md-start">
                <div class="copyright">
                    &copy; Copyright <strong><span>{{ $setting->name }}</span></strong>. All Rights Reserved by
                    <b>MOI</b>
                </div>
                <div class="credits">
                    <!-- All the links in the footer should remain intact. -->
                    <!-- You can delete the links only if you purchased the pro version. -->
                    <!-- Licensing information: https://bootstrapmade.com/license/ -->
                    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/ -->
                    Designed by <b>MOI Developers</b> <i class="fas fa-heart"></i>
                </div>
            </div>
            <div class="social-links text-center text-md-right pt-3 pt-md-0">
                @if (!empty($setting->facebook_link))
                    <a href="{{ $setting->facebook_link }}" class="facebook"  target="_blank"><i class="bx bxl-facebook"></i></a>
                @endif
                @if (!empty($setting->instagram_link))
                    <a href="{{ $setting->instagram_link }}" class="instagram"  target="_blank"><i class="bx bxl-instagram"></i></a>
                @endif
                @if (!empty($setting->twiter_link))
                    <a href="{{ $setting->twiter_link }}" class="twitter"  target="_blank"><i class="bx bxl-twitter"></i></a>
                @endif
                @if (!empty($setting->linkedin_link))
                    <a href="{{ $setting->linkedin_link }}" class="linkedin"  target="_blank"><i class="bx bxl-linkedin"></i></a>
                @endif
            </div>
        </div>
    </footer><!-- End Footer -->

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('frontend/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/php-email-form/validate.js') }}"></script>


    <!-- Template Main JS File -->
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/script.js') }}"></script>

    <!--  Data Table -->
    <script src="{{ asset('assets/plugins/custom/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/datatables/dataTables.bootstrap5.min.js') }}"></script>


    @yield('scripts')

<script>
/* Set the width of the sidebar to 250px (show it) */
function openNav() {
  document.getElementById("mySidepanel").style.width = "100%";
  document.getElementById("mySidepanel").style.height = "80%";
}

/* Set the width of the sidebar to 0 (hide it) */
function closeNav() {
  document.getElementById("mySidepanel").style.width = "0";
}
</script>
</body>

</html>
