<!DOCTYPE html>
<html lang="en" direction="rtl" dir="rtl" style="direction: rtl;">
<!--begin::Head-->

<head>
    <title>وزارت امور داخله</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />

    <link rel="shortcut icon" href="{{ asset('assets/moi_logo.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons/bootstrap-icons.css') }}">
    <!--begin::Fonts-->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" /> -->
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    @if (Session::get('locale') == 'pa' || Session::get('locale') == 'fa')
        <style>
            @font-face {
                font-family: 'Bahij';
                src: url(assets/fonts/bahij.ttf) format('truetype');
            }

            body,
            label,
            a,
            h2,
            h4,
            p,
            * {
                font-family: 'Bahij', 'Roboto', sans-serif;
                font-size: 17px !important;
            }
        </style>
    @endif
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="app-blank app-blank" style="background-color: rgb(255, 252, 240);">
    <!--begin::Theme mode setup on page load-->
    @include('layouts.partials.theme_mode')
    <!--end::Theme mode setup on page load-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                <!--begin::Form-->
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <!--begin::Wrapper-->
                    <div class="w-lg-450px p-15 card drop-shadow-2xl"
                        style="background-color: rgb(180, 219, 253);   box-shadow: 4px 4px 6px rgba(2, 2, 2, 0.1);">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="loginForm" method="POST"
                            action="{{ route('login') }}">
                            @csrf
                            <!--begin::Heading-->
                            <div class="text-center mb-11">
                                <!--begin::Title-->
                                <img alt="Logo" class="mx-auto d-block" width="150px" height="150px"
                                    src="{{ asset('assets/moi_logo.png') }}" />
                                <!--end::Title-->
                                <!--begin::Subtitle-->
                                <div class="text-gray-900 fw-bold fs-1">د کـــــــورنیـــــــو چـــــــــــــارو وزارت
                                </div>

                                <div class="text-gray-900 fw-bold fs-1">د کـــابل ولایت امنیه قوماندانۍ </div>
                                <div class="text-gray-900 fw-bold fs-1">د نظــارت خــونې آمــریت </div>
                                <div class="text-gray-900 fw-bold fs-1">د مظنونینو د ثبت مدیریتي سیستم </div>
                                <!--end::Subtitle=-->
                            </div>
                            @if ($errors->any())
                                <!--begin::Alert-->
                                <div class="alert alert-danger d-flex align-items-center p-2">
                                    <!--begin::Icon-->
                                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-3"></span>
                                    <!--end::Icon-->

                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-column">
                                        <!--begin::Title-->
                                        @error('email')
                                            <h4 class="mb-1 text-danger">
                                                {{ __('translate.invalid_credentials') }}
                                            </h4>
                                        @enderror
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Alert-->
                            @endif
                            <!--begin::Input group=-->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="text" placeholder="ایمیل آدرس" name="email" id="email"
                                    value="{{ old('email') }}" required autocomplete="on"
                                    class="form-control form-control-lg bg-transparent" />

                                <!--end::Email-->
                            </div>
                            <!--end::Input group=-->
                            <div class="fv-row mb-3 position-relative">

                                <input type="password" placeholder="{{ __('translate.password') }}" name="password"
                                    id="password" autocomplete="off"
                                    class="form-control form-control-lg form-control-solid pe-10" />

                                <span onclick="togglePassword()"
                                    class="btn btn-sm btn-icon position-absolute translate-middle-y top-50 end-0 me-3">

                                    <!-- 👁 Eye -->
                                    <i id="eyeIcon" class="bi bi-eye fs-5"></i>

                                    <!-- 🙈 Eye Slash -->
                                    <i id="eyeSlashIcon" class="bi bi-eye-slash fs-5" style="display:none;"></i>

                                </span>

                            </div>
                            <!--end::Input group=-->
                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button type="submit" id="submitBtn" class="btn btn-primary me-2 flex-shrink-1">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label" data-kt-translate="sign-in-submit">ننوتل
                                    </span>
                                    <span id="spinner" class="spinner-border spinner-border-sm align-middle ms-2"
                                        hidden></span>
                                    <!--end::Indicator label-->
                                </button>
                            </div>
                            <!--end::Submit button-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Form-->
            </div>
            <!--end::Body-->
            <!--begin::Aside-->
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
                style="background-image: url({{ asset('assets/media/auth/bg2.jpg') }})">
            </div>
            <!--end::Aside-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
    <!--begin::Javascript-->

    <script>
        function togglePassword() {
            let password = document.getElementById("password");
            let eye = document.getElementById("eyeIcon");
            let eyeSlash = document.getElementById("eyeSlashIcon");

            if (password.type === "password") {
                password.type = "text";
                eye.style.display = "none";
                eyeSlash.style.display = "inline";
            } else {
                password.type = "password";
                eye.style.display = "inline";
                eyeSlash.style.display = "none";
            }
        }
    </script>
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/general.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/jquery.validate.min.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--end::Javascript-->
    <script>
        $(document).ready(function() {
            var valid = $('#loginForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                    },
                },
                messages: {
                    email: {
                        required: '<span class="text-danger" style="font-size:13px; font-weight:bold"> {{ __('translate.email_required') }} </span>',
                        email: '<span class="text-danger" style="font-size:13px; font-weight:bold"> {{ __('translate.invalid_email') }} </span>',
                    },
                    password: {
                        required: '<span class="text-danger" style="font-size:13px; font-weight:bold"> {{ __('translate.password_required') }} </span>',
                    },
                }
            });
            $('#submitBtn').click(function() {
                $('#spinner').attr('hidden', false);
            });
            $('#email').on('keyup', function() {
                $('#spinner').attr('hidden', true);
            });
            $('#password').on('keyup', function() {
                $('#spinner').attr('hidden', true);
            });
        });
    </script>
</body>
<!--end::Body-->

</html>
