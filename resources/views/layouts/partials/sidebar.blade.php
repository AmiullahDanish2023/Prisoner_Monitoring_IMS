<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle"
    style="background-color: #142d4b;">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->

        {{-- <a href="/"> --}}
        {{-- <img alt="Logo" src="{{asset('assets/media/logos/default-dark.svg')}}" class="h-25px app-sidebar-logo-default" />
      <img alt="Logo" src="{{asset('assets/media/logos/default-small.svg')}}" class="h-20px app-sidebar-logo-minimize" /> --}}
        {{-- <img alt="Logo" src="{{ asset('assets/moi_logo.png') }}" width="60px" />
        </a> --}}
        <style>
            .app-sidebar .logo-box {
                text-align: center;
                padding: 15px 0;
            }

            .app-sidebar .logo-box img {
                max-width: 60px;
            }

            .title-text {
                white-space: nowrap;

                font-size: 14px;

            }

            .logo-box a {
                display: flex;
                align-items: center;
                gap: 10px;
            }
        </style>
        <div class="logo-box">
            <a href="{{ route('home') }}">
                <img src="{{ asset('uploads/default_log.png') }}" alt="Logo">
                <h6 class="text-white mt-2 title-text">
                    دمظنونینو د ثبت مدیریتي سیستم
                </h6>
            </a>
        </div>

        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        {{-- <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
        </div> --}}
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
                        <span class="menu-heading fw-bold text-uppercase ">{{ __('translate.suspect_section') }}</span>
                    </div>
                    <!--end:Menu content-->
                </div>

                <!--end:Menu item-->
                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click"
                    class="menu-item {{ request()->routeIs('suspects.*') || request()->routeIs('release-sources.*') ? 'here show' : '' }} menu-accordion">
                    <!--begin:Menu link-->
                    @can('Suspect Section')
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
                            <span class="menu-title">{{ __('translate.suspect_part') }}</span>

                            <span class="menu-arrow"></span>
                        </span>
                    @endcan
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">

                        @can('Save New Suspect Section')
                            <div class="menu-item">
                                <a class="menu-link {{ Route::currentRouteName() == 'suspects.index' ? 'active' : '' }}"
                                    href="{{ route('suspects.index') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('translate.add_new_suspect') }}</span>
                                </a>
                            </div>
                        @endcan

                        @can(' List of Release or Transfer Suspects')
                            <div class="menu-item">
                                <a class="menu-link {{ Route::currentRouteName() == 'suspects.release' ? 'active' : '' }}"
                                    href="{{ route('suspects.release') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('translate.release_transfer_list') }}</span>
                                </a>
                            </div>
                        @endcan

                        @can('Add Suspect Release Reference Section')
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('release-sources.*') ? 'active' : '' }}"
                                    href="{{ route('release-sources.index') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('translate.add_reference') }}</span>
                                </a>
                            </div>
                        @endcan

                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->

                <!--end:Menu item-->

                {{-- ---------------------------report part--------------------- --}}

                @can('Report Mangement Section')
                    <div class="menu-item pt-5">
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase ">
                                {{ __('translate.report_section') }}
                            </span>
                        </div>
                    </div>
                @endcan

                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion 
                       {{ request()->routeIs('report.general') ||
                       request()->routeIs('reports.existing.pdf') ||
                       request()->routeIs('release.suspect.report') ||
                       request()->routeIs('reports.monthly')
                           ? 'here show'
                           : '' }}">

                    @can('Report Section')
                        <span class="menu-link">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect x="3" y="10" width="4" height="10" rx="1"
                                            fill="currentColor" />
                                        <rect x="10" y="6" width="4" height="14" rx="1" opacity="0.5"
                                            fill="currentColor" />
                                        <rect x="17" y="3" width="4" height="17" rx="1"
                                            fill="currentColor" opacity="0.3" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">{{ __('translate.report_part') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                    @endcan

                    <!-- ✅ ONE menu-sub ONLY -->
                    <div class="menu-sub menu-sub-accordion">

                        @can(' Create Suspects Genral Report')
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('report.general') ? 'active' : '' }}"
                                    href="{{ route('report.general') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('translate.general_report') }}</span>
                                </a>
                            </div>
                        @endcan

                        @can(' Create Suspects Existing Report')
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('reports.existing.pdf') ? 'active' : '' }}"
                                    href="{{ route('reports.existing.pdf') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('translate.existing_report') }}</span>
                                </a>
                            </div>
                        @endcan

                        @can('Create Release or Transfer Suspcets Report')
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('release.suspect.report') ? 'active' : '' }}"
                                    href="{{ route('release.suspect.report') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('translate.release_report') }}</span>
                                </a>
                            </div>
                        @endcan

                        @can('Create Suspects Mothly Report')
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('reports.monthly') ? 'active' : '' }}"
                                    href="{{ route('reports.monthly') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('translate.monthly_report') }}</span>
                                </a>
                            </div>
                        @endcan

                    </div>
                </div>

                {{-- -----------------------------end report part--------------------------------- --}}


                {{-- ---------------------------start livelihood plan part--------------------- --}}

                @can('Livelihood Manegement Section')
                    <div class="menu-item pt-5">
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase ">
                                {{ __('translate.livelihood_section') }}
                            </span>
                        </div>
                    </div>
                @endcan

                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion 
                  {{ request()->routeIs('livelihood.plan') || request()->routeIs('livelihood.list.show') ? 'here show' : '' }}">

                    @can('Livelihood Manegement')
                        <span class="menu-link">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">

                                        <circle cx="12" cy="6" r="3" fill="currentColor" />
                                        <path d="M6 20C6 15.6 8.7 13 12 13C15.3 13 18 15.6 18 20" fill="currentColor"
                                            opacity="0.3" />

                                        <rect x="4" y="14" width="2" height="6" rx="1"
                                            fill="currentColor" opacity="0.4" />
                                        <rect x="18" y="11" width="2" height="9" rx="1"
                                            fill="currentColor" opacity="0.6" />

                                    </svg>
                                </span>
                            </span>

                            <span class="menu-title">{{ __('translate.livelihood_management') }}</span>
                            <span class="menu-arrow"></span>
                        </span>
                    @endcan

                    <!-- ✅ ONE menu-sub ONLY -->
                    <div class="menu-sub menu-sub-accordion">

                        @can('Make Livelihood Plan')
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('livelihood.plan') ? 'active' : '' }}"
                                    href="{{ route('livelihood.plan') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('translate.livelihood_plan') }}</span>
                                </a>
                            </div>
                        @endcan

                        @can('List of Livelihood Plans')
                            <div class="menu-item">
                                <a class="menu-link {{ request()->routeIs('livelihood.list.show') ? 'active' : '' }}"
                                    href="{{ route('livelihood.list.show') }}">
                                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                    <span class="menu-title">{{ __('translate.livelihood_list') }}</span>
                                </a>
                            </div>
                        @endcan

                    </div>
                </div>

                {{-- -----------------------------end livelihood plan part--------------------------------- --}}
                <!--end:Menu item-->
                {{-- ---------------------------start Goods Invoices part--------------------- --}}

                {{-- 1. د برخې سرلیک --}}
                @can('Goods Invoices Section')
                    <div class="menu-item pt-5">
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase">
                                د اجناسو د بیلونو مدیریت برخه
                            </span>
                        </div>
                    </div>
                @endcan

                {{-- 2. د اصلي مینو (Parent) برخه --}}
                @can('Goods Invoices Management')
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion 
        {{ request()->routeIs('bills.index') || request()->routeIs('bills.reports') ? 'here show' : '' }}">

                        <span class="menu-link">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <circle cx="12" cy="6" r="3" fill="currentColor" />
                                        <path d="M6 20C6 15.6 8.7 13 12 13C15.3 13 18 15.6 18 20" fill="currentColor"
                                            opacity="0.3" />
                                        <rect x="4" y="14" width="2" height="6" rx="1"
                                            fill="currentColor" opacity="0.4" />
                                        <rect x="18" y="11" width="2" height="9" rx="1"
                                            fill="currentColor" opacity="0.6" />
                                    </svg>
                                </span>
                            </span>

                            <span class="menu-title">د اجناسو د بیلونو مدیریت</span>
                            <span class="menu-arrow"></span>
                        </span>

                        <!-- مینو فرعي برخه -->
                        <div class="menu-sub menu-sub-accordion">

                            {{-- د بیلونو لیست او ثبت --}}
                            @can('List Goods Invoices')
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('bills.index') ? 'active' : '' }}"
                                        href="{{ route('bills.index') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">د اجناسو د بیلونو ثبت او لیست</span>
                                    </a>
                                </div>
                            @endcan

                            {{-- د بیلونو راپور --}}
                            @can('Goods Invoice Reports')
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('bills.reports') ? 'active' : '' }}"
                                        href="{{ route('bills.reports') }}">
                                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                        <span class="menu-title">د اجناسو د بیلونو راپور</span>
                                    </a>
                                </div>
                            @endcan

                        </div>
                    </div>
                @endcan

                {{-- -----------------------------end Goods Invoices part--------------------------------- --}}
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
                                    <span class="menu-title">{{ __('translate.permission') }}</span>
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
    <script src="{{ asset('perisanDatePicker/js/persianDatepicker.js') }}"></script>
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
