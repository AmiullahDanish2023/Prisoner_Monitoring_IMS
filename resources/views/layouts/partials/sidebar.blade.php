<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->

        {{-- <a href="/"> --}}
        {{-- <img alt="Logo" src="{{asset('assets/media/logos/default-dark.svg')}}" class="h-25px app-sidebar-logo-default" />
      <img alt="Logo" src="{{asset('assets/media/logos/default-small.svg')}}" class="h-20px app-sidebar-logo-minimize" /> --}}
        {{-- <img alt="Logo" src="{{ asset('assets/moi_logo.png') }}" width="60px" />
        </a> --}}
        <a href="{{ route('home') }}">
            <h3 class="text-white text-center">
                بندیانو نظارت‌ خونې د ثبت سیستم
            </h3>
        </a>

        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <img alt="Lcogo" src="{{ asset('uploads/default_log.png') }}" width="60px" />

        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
            <!--begin::Menu-->
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <!--begin:Menu link-->
                    <a href="{{ route('home') }}">

                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="2" y="2" width="9" height="9" rx="2"
                                            fill="currentColor" />
                                        <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2"
                                            fill="currentColor" />
                                        <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2"
                                            fill="currentColor" />
                                        <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">{{ __('translate.dashboard') }}</span>
                    </a>


                    </span>

                    </a>
                    <!--end:Menu link-->

                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase ">بخش مدیریت مظنونین</span>
                    </div>
                    <!--end:Menu content-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item {{ Request::is('contents*') ? 'here show' : '' }} menu-accordion">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 22V10M12 22V10M17 22V10" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" />
                                    <rect x="4" y="2" width="16" height="8" rx="2" stroke="currentColor"
                                        stroke-width="2" />
                                    <circle cx="12" cy="6" r="1.5" fill="currentColor" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">بخش مظنونین</span>

                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        @can('Create Book or Artical')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Route::currentRouteName() == 'suspects.index' ? 'active' : '' }}"
                                    href="{{ route('suspects.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">د نوی مظنون ثبتول </span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endcan

                        <!--end:Menu item-->

                    </div>
                    <!--end:Menu sub-->

                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        @can('Create Book or Artical')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Route::currentRouteName() == 'suspects.release' ? 'active' : '' }}"
                                    href="{{ route('suspects.release') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">رهایی / انتقال مظنونینو لیست</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endcan

                        <!--end:Menu item-->

                    </div>
                    <!--end:Menu sub-->


                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <a class="menu-link {{ request()->routeIs('release-sources.*') ? 'active' : '' }}"
                                href="{{ route('release-sources.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">د مراجعو اضافه کول</span>
                            </a>
                        </div>



                        <!--end:Menu item-->

                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->

                <!--end:Menu item-->

                {{-- ---------------------------report part--------------------- --}}

                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase ">بخش مدیریت راپورها</span>
                    </div>
                    <!--end:Menu content-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item {{ Request::is('contents*') ? 'here show' : '' }} menu-accordion">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="3" y="10" width="4" height="10" rx="1"
                                        fill="currentColor" />
                                    <rect x="10" y="6" width="4" height="14" rx="1" opacity="0.5"
                                        fill="currentColor" />
                                    <rect x="17" y="3" width="4" height="17" rx="1"
                                        fill="currentColor" opacity="0.3" />
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">بخش راپورها</span>


                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->

                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Route::currentRouteName() == 'report.general' ? 'active' : '' }}"
                                href="{{ route('report.general') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">د مظنونینو عمومی راپور </span>
                            </a>
                            <!--end:Menu link-->
                        </div>


                        <!--end:Menu item-->

                    </div>
                    <!--end:Menu sub-->

                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->

                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Route::currentRouteName() == 'reports.existing.pdf' ? 'active' : '' }}"
                                href="{{ route('reports.existing.pdf') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title"> د مظنونینو د موجودی راپور </span>
                            </a>
                            <!--end:Menu link-->
                        </div>


                        <!--end:Menu item-->

                    </div>
                    <!--end:Menu sub-->

                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->

                        <div class="menu-item">
                            <a class="menu-link" href="#" data-bs-toggle="modal"
                                data-bs-target="#releasedReportModal">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title"> د رهایی / انتقال مظنونینو راپور </span>
                            </a>
                        </div>



                        <!--end:Menu item-->

                    </div>
                    <!--end:Menu sub-->

                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->

                        <div class="menu-item">
                            <a class="menu-link" href="#" data-bs-toggle="modal"
                                data-bs-target="#monthlySuspectModal">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title"> د مظنونینو میاشتنی راپور </span>
                            </a>
                        </div>


                        <!--end:Menu item-->

                    </div>
                    <!--end:Menu sub-->

                </div>
                <!--end:Menu item-->

                <!--end:Menu item-->
                {{-- -----------------------------end report part--------------------------------- --}}





                {{-- ---------------------------start livelihood plan part--------------------- --}}

                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        <span class="menu-heading fw-bold text-uppercase ">بخش مدیریت اعاشه</span>
                    </div>
                    <!--end:Menu content-->
                </div>
                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item {{ Request::is('contents*') ? 'here show' : '' }} menu-accordion">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">

                                    <!-- Person -->
                                    <circle cx="12" cy="6" r="3" fill="currentColor" />
                                    <path d="M6 20C6 15.6 8.7 13 12 13C15.3 13 18 15.6 18 20" fill="currentColor"
                                        opacity="0.3" />

                                    <!-- Livelihood / Planning bars -->
                                    <rect x="4" y="14" width="2" height="6" rx="1"
                                        fill="currentColor" opacity="0.4" />
                                    <rect x="18" y="11" width="2" height="9" rx="1"
                                        fill="currentColor" opacity="0.6" />

                                </svg>
                            </span>
                        </span>

                        <span class="menu-title">مدیریت اعاشه</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->

                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->

                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Route::currentRouteName() == 'livelihood.plan' ? 'active' : '' }}"
                                href="{{ route('livelihood.plan') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">پلان اعاشه </span>
                            </a>
                            <!--end:Menu link-->
                        </div>


                        <!--end:Menu item-->

                    </div>
                    <!--end:Menu sub-->


                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->

                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{ Route::currentRouteName() == 'livelihood.list.show' ? 'active' : '' }}"
                                href="{{ route('livelihood.list.show') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title"> لیست  و  راپور اعاشه </span>
                            </a>
                            <!--end:Menu link-->
                        </div>


                        <!--end:Menu item-->

                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->

                <!--end:Menu item-->
                {{-- -----------------------------end livelihood plan part--------------------------------- --}}




                <!--end:Menu item-->
                <!--begin:Menu item-->
                @can('Create Users')
                    <div class="menu-item pt-5">
                        <!--begin:Menu content-->
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase ">{{ __('translate.user part') }}</span>
                        </div>
                        <!--end:Menu content-->
                    </div>
                    <!--end:Menu item-->
                @endcan

                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item {{ Request::is('users*') ? 'here show' : '' }} menu-accordion">
                    <!--begin:Menu link-->
                    @can('Create Users')
                        <span class="menu-link">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="9" cy="7" r="4" stroke="currentColor"
                                            stroke-width="2" />
                                        <path d="M2 20c0-4 3.5-7 7-7s7 3 7 7" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" />
                                        <circle cx="17" cy="9" r="3" stroke="currentColor"
                                            stroke-width="2" opacity="0.5" />
                                        <path d="M21 20c0-3-2-5-4-6" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" opacity="0.5" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">{{ __('translate.user management') }}</span>

                            <span class="menu-arrow"></span>
                        </span>
                    @endcan
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        @can('Create Users')
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Route::currentRouteName() == 'users.index' ? 'active' : '' }}"
                                    href="{{ route('users.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{ __('translate.users') }}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Route::currentRouteName() == 'user.roles' ? 'active' : '' }}"
                                    href="{{ route('user.roles') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">{{ __('translate.permession') }}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        @endcan
                        <!--end:Menu item-->
                        <!--begin:Menu item-->

                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->

                </div>
                <!--end:Menu item-->



                <div class="menu-sub menu-sub-accordion">
                </div>
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
    <!--begin::Footer-->
    <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
        document.getElementById('logout-form').submit();"
            class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100"
            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click">
            <span class="btn-label">

                {{ __('translate.logout') }}

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </span>
        </a>
    </div>
    <!--end::Footer-->
</div>


@section('content')
    <link rel="stylesheet" href="{{ asset('assets/persian-date/persian-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('perisanDatePicker/css/persianDatepicker-default.css') }}" />

    <style>
        .modal-content {
            border-radius: 10px;
        }

        .modal-header {
            border-bottom: 1px solid #dee2e6;
        }

        .modal-footer {
            border-top: 1px solid #dee2e6;
        }
    </style>
    <div class="modal fade" id="releasedReportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content shadow">

                {{-- Header --}}
                <div class="modal-header justify-content-center position-relative">
                    <h5 class="modal-title fw-bold">
                        انتخاب نوع راپور
                    </h5>

                    {{-- Close button fixed to right --}}
                    <button type="button" class="btn-close position-absolute end-0 me-2" data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>
                </div>

                <form method="GET" action="{{ route('reports.released.pdf') }}" target="_blank">

                    {{-- Body --}}
                    <div class="modal-body px-4">

                        <div class="mb-3 ">
                            <label class="form-label fw-bold mb-2">
                                انتخاب جنسیت مظنون
                            </label>

                            <select name="gender" class="form-select " required>
                                <option value=""> انتخاب نمایید </option>
                                <option value="all">عمومی (ذکور و اناث)</option>
                                <option value="نارینه">مظنونین ذکور </option>
                                <option value="ښځینه"> مظنونین اناث</option>
                            </select>
                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer d-flex justify-content-between mb-0">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"
                            onclick="this.closest('form').reset()">
                            بندول
                        </button>

                        <button type="submit" class="btn btn-primary btn-sm"> راپور لیدل</button>

                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- -----------------monthly suspect report modal ----------------------- --}}


    <div class="modal fade" id="monthlySuspectModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title text-align-center">د مظنونینو میاشتنی راپور</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="GET" action="{{ route('reports.monthly.pdf') }}" target="_blank">

                    <div class="modal-body">

                        <!-- تاریخ شروع -->
                        <div class="mb-3">
                            <label class="form-label">تاریخ شروع</label>
                            <input type="text" name="start_date" class="form-control farsi-date"
                                placeholder="از تاریخ" autocomplete="off" value="">
                        </div>

                        <!-- تاریخ ختم -->
                        <div class="mb-3">
                            <label class="form-label">تاریخ ختم</label>
                            <input type="text" name="end_date" class="form-control farsi-date" placeholder="تا تاریخ"
                                autocomplete="off" value="">
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">راپور جوړول </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@section('scripts')
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>

    <script src="{{ asset('perisanDatePicker/js/persianDatepicker.js') }}"></script>
    <script>
        $(document).ready(function() {

            // --- Initialize Persian Datepicker ---
            $('.farsi-date').persianDatepicker({
                format: 'YYYY/MM/DD',
                initialValue: false,
                autoClose: true,
                calendar: {
                    persian: {
                        locale: 'fa'
                    }
                }
            });

            // --- Auto reset form on page load ---
            $('#generalReportForm')[0].reset();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const modalEl = document.getElementById('monthlySuspectModal');
            const formEl = modalEl.querySelector('form');

            formEl.addEventListener('submit', function() {

                // Close modal
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) {
                    modalInstance.hide();
                }


                // Reset form after short delay (ensures submit still works)
                setTimeout(() => {
                    formEl.reset();
                }, 300);
            });

        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const modalEl = document.getElementById('releasedReportModal');
            const formEl = modalEl.querySelector('form');

            formEl.addEventListener('submit', function() {

                // Close modal
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) {
                    modalInstance.hide();
                }


                // Reset form after short delay (ensures submit still works)
                setTimeout(() => {
                    formEl.reset();
                }, 300);
            });

        });
    </script>
@endsection
