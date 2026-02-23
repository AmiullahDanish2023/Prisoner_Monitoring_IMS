@extends('layouts.master')
@section('content')
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"> --}}

    <link rel="stylesheet" href="{{ asset('assets/persian-date/persian-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('perisanDatePicker/css/persianDatepicker-default.css') }}" />
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">لست مظنونین / زندانیان</h4>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#suspectModal">
                ثبت مظنون جدید
            </button>
            <link rel="stylesheet" href="{{ asset('assets/custom.css') }}">

            <style>
                /* ---------- Action Buttons Container ---------- */
                .action-buttons {
                    display: flex;
                    gap: 6px;
                    /* space between buttons */
                }

                /* Base Button Styling */
                .action-buttons a {
                    display: flex !important;
                    /* override inline styles */
                    align-items: center;
                    justify-content: center;
                    gap: 6px;
                    cursor: pointer;
                    border-radius: 4px;
                    padding: 4px 6px;
                    transition: all 0.25s ease-in-out;
                    text-decoration: none;
                }

                /* SVG icons always white */
                .action-buttons a svg {
                    stroke: #fff !important;
                }

                /* Hover effect */
                .action-buttons a:hover {
                    transform: scale(1.08);
                    box-shadow: 0 0 12px rgba(0, 0, 0, 0.15);
                }

                /* Button Colors */
                .view-btn {
                    background-color: #56a0f0 !important;
                    color: #fff !important;
                }

                .edit-btn {
                    background-color: #0dcaf0 !important;
                    color: #fff !important;
                }

                .destroy_btn {
                    background-color: #e26774 !important;
                    color: #fff !important;
                }

                .release-btn {
                    background-color: #a3ee94 !important;
                    color: #fff !important;
                }

                .btn-transfer {
                    background-color: #f0c14d !important;
                    color: #fff !important;
                }

                /* Tooltip for SVG buttons */
                .action-buttons a[data-title] {
                    position: relative;
                }

                .action-buttons a[data-title]::after {
                    content: attr(data-title);
                    position: absolute;
                    bottom: 125%;
                    left: 50%;
                    transform: translateX(-50%);
                    background: #000;
                    color: #fff;
                    font-size: 11px;
                    padding: 4px 8px;
                    border-radius: 4px;
                    opacity: 0;
                    white-space: nowrap;
                    pointer-events: none;
                    transition: all 0.25s ease;
                    z-index: 999;
                }

                .action-buttons a[data-title]:hover::after {
                    opacity: 1;
                    bottom: 135%;
                }

                .swal2-title,
                .swal2-html-container {
                    font-family: 'Bahij', sans-serif !important;
                    font-weight: 700 !important;
                    /* bold */
                    font-size: 18px !important;
                }

                #releaseDropdownBtn.form-control {
                    cursor: pointer;
                }

                #releaseDropdownBtn.form-control:focus {
                    box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
                    border-color: #86b7fe;
                }

                /* Validation error text */
                label.error {
                    color: #dc3545;
                    /* Bootstrap red */
                    font-size: 13px;
                    margin-top: 4px;
                    display: block;
                }

                /* Input border when error */
                input.error,
                select.error,
                textarea.error {
                    border-color: #dc3545 !important;
                }
            </style>

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped  table-checkable align-middle"
                    id="suspects_table">
                    <thead style="background-color:#c1effa;">
                        <tr class="bg-primary-o-10">
                            <th>شماره</th>
                            <th> مظنون نظارت ورځې </th>
                            <th>نوم</th>
                            <th>د پلار نوم</th>
                            <th>جرم</th>
                            <th>رالیږونکې مرجع</th>
                            <th>ولایت</th>
                            <th>ناحیه</th>
                            <th>منطقه</th>
                            <th>د نظارت نیټه</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="suspectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered mw-50">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center" style="background-color:#c8e6f3; color:white;">
                    <h5 class="modal-title text-center w-100">ثبت مظنون جدید</h5>


                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="store_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body row g-3">

                        <div class="col-md-4">
                            <label class="form-label">جنسیت</label>
                            <select id="gender" name="gender" class="form-control form-control-sm">
                                <option value="" selected disabled>جنسیت انتخاب کړئ</option>
                                <option value="نارینه">نارینه</option>
                                <option value="ښځینه">ښځینه</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">نوم مظنون</label>
                            <input type="text" name="suspect_name" class="form-control form-control-sm"
                                placeholder=" مظنون نوم">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">د پلار نوم</label>
                            <input type="text" name="father_name" class="form-control form-control-sm"
                                placeholder="پلار نوم">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">د نيکه نوم</label>
                            <input type="text" name="grandfather_name" class="form-control form-control-sm"
                                placeholder="د نيکه نوم">
                        </div>

                        <div class="col-md-4" id="childrenWithMotherDiv">
                            <label class="form-label">د مور سره ماشومان</label>
                            <input type="text" name="children_with_mother" class="form-control form-control-sm"
                                placeholder="ماشومان">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">جرم ډول</label>
                            <input type="text" name="crime_type" class="form-control form-control-sm"
                                placeholder="جرم ډول">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label"> رالیږونکې مرجع</label>
                            <input type="text" name="referring_authority" class="form-control form-control-sm"
                                placeholder="رالیږونکې مرجع">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">د څارنې نیټه</label>
                            <input type="text" name="monitoring_date" class="form-control form-control-sm farsi-date"
                                placeholder="د نظارت نیټه">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ولایت</label>
                            <select name="province" class="form-select">
                                <option value="">انتخاب ولایت</option>
                                @foreach ($province as $pro)
                                    <option value="{{ $pro->id }}">{{ $pro->name_da }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-md-4">
                            <label class="form-label">ناحیه</label>
                            <input type="text" name="district" class="form-control form-control-sm" placeholder="ناحیه">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">منطقه</label>
                            <input type="text" name="area" class="form-control form-control-sm" placeholder="منطقه">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">د نیولو پر وخت توکي موجود وو؟</label>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="has_items" value="1">
                                <label class="form-check-label">هو</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="has_items" value="0">
                                <label class="form-check-label">نه</label>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <label class="form-label">فایل</label>
                            <input type="file" name="file" class="form-control form-control-sm"
                                accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">

                        </div>

                    </div>

                    <div class="modal-footer d-flex justify-content-between mb-0">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">بندول</button>
                        <button class="btn btn-primary btn-sm">ثبتول</button>

                    </div>
                </form>

            </div>
        </div>
    </div>
    {{-- Edit Suspect Modal --}}
    <div class="modal fade" id="editSuspectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered mw-50">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center" style="background-color:#dff5fa; color:white;">
                    <h5 class="modal-title text-center w-100">${row} معلومات تغیرول</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="edit_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="suspect_id" id="edit_suspect_id">

                    <div class="modal-body row g-3">
                        <div class="col-md-4">
                            <label class="form-label">جنسیت</label>
                            <select id="edit_gender" name="gender" class="form-control form-control-sm">
                                <option value="" selected disabled>جنسیت انتخاب کړئ</option>
                                <option value="نارینه">نارینه</option>
                                <option value="ښځینه">ښځینه</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">نوم مظنون</label>
                            <input type="text" name="suspect_name" id="edit_suspect_name"
                                class="form-control form-control-sm">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">د پلار نوم</label>
                            <input type="text" name="father_name" id="edit_father_name"
                                class="form-control form-control-sm">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">د نيکه نوم</label>
                            <input type="text" name="grandfather_name" id="edit_grandfather_name"
                                class="form-control form-control-sm">
                        </div>

                        <div class="col-md-4" id="edit_childrenWithMotherDiv">
                            <label class="form-label">د مور سره ماشومان</label>
                            <input type="text" name="children_with_mother" id="edit_children_with_mother"
                                class="form-control form-control-sm">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">جرم ډول</label>
                            <input type="text" name="crime_type" id="edit_crime_type"
                                class="form-control form-control-sm">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label"> رالیږونکې مرجع</label>
                            <input type="text" name="referring_authority" id="edit_referring_authority"
                                class="form-control form-control-sm">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">د څارنې نیټه</label>
                            <input type="text" name="monitoring_date" class="form-control form-control-sm farsi-date"
                                id="edit_monitoring_date" placeholder="د نظارت نیټه">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ولایت</label>
                            <select name="province" id="edit_province" class="form-control form-control-sm">
                                <option disabled>ولایت انتخاب کړئ</option>
                                @foreach ($province as $prov)
                                    <option value="{{ $prov->id }}">{{ $prov->name_da }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">ناحیه</label>
                            <input type="text" name="district" id="edit_district"
                                class="form-control form-control-sm">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">منطقه</label>
                            <input type="text" name="area" id="edit_area" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">د نیولو پر وخت توکي موجود وو؟</label>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="has_items" value="1"
                                    id="edit_has_items_yes">
                                <label class="form-check-label" for="edit_has_items_yes">هو</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="has_items" value="0"
                                    id="edit_has_items_no">
                                <label class="form-check-label" for="edit_has_items_no">نه</label>
                            </div>


                            <div class="col-md-12">
                                <label class="form-label">فایل</label>
                                <input type="file" name="file" class="form-control form-control-sm">
                                <small id="edit_existing_file" class="text-muted"></small>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-between mb-0">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">بندول</button>
                            <button type="submit" class="btn btn-primary btn-sm">تغیراتو ثبت</button>
                        </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Release Modal -->
    <div class="modal fade" id="releaseModal" tabindex="-1" aria-labelledby="releaseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title text-center w-100" id="releaseModalLabel">
                        د مظنون رهايي / انتقال
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بندول"></button>
                </div>

                <form id="releaseForm">
                    @csrf

                    <div class="modal-body">
                        <input type="hidden" name="suspect_id" id="release_suspect_id">

                        {{-- Issue / Transfer Number --}}
                        <div class="mb-3">
                            <label for="issued_or_transferred_number" class="form-label">
                                د رهايي یا انتقال د صادرې شمېر
                            </label>
                            <input type="text" class="form-control" id="issued_or_transferred_number"
                                name="issued_or_transferred_number">
                        </div>

                        {{-- Releasing Authority --}}
                        <div class="mb-3">
                            <label class="form-label">
                                د رهايي یا انتقال مرجع
                            </label>

                            <div class="dropdown w-100">
                                <button class="form-control text-start dropdown-toggle" type="button"
                                    id="releaseDropdownBtn" data-bs-toggle="dropdown">
                                    <span id="releaseDropdownLabel">یوه مرجع وټاکئ</span>
                                </button>


                                <div class="dropdown-menu p-3 w-100" style="max-width:350px;">

                                    {{-- STATIC OPTIONS --}}
                                    <div class="form-check mb-2">
                                        <input class="form-check-input main-opt" type="radio" name="main_option"
                                            value="انتقال به توقیف" id="main_opt_1" data-key="detention">
                                        <label class="form-check-label" for="main_opt_1">
                                            توقیف‌خانې ته انتقال
                                        </label>
                                    </div>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input main-opt" type="radio" name="main_option"
                                            value="انتقال به مراجع مختلف" id="main_opt_2" data-key="multi">
                                        <label class="form-check-label" for="main_opt_2">
                                            بېلابېلو مراجعو ته انتقال
                                        </label>
                                    </div>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input main-opt" type="radio" name="main_option"
                                            value="مظنونین رهایی" id="main_opt_3" data-key="release">
                                        <label class="form-check-label" for="main_opt_3">
                                            د مظنون رهايي
                                        </label>
                                    </div>

                                    <hr>

                                    {{-- SEARCH DB OPTIONS --}}
                                    <div id="db_search_wrapper" style="display:none;" class="mb-2">
                                        <input type="text" id="db_option_search" class="form-control form-control-sm"
                                            placeholder="مرجع ولټوئ...">
                                    </div>

                                    {{-- DB OPTIONS --}}
                                    <div id="db_options_wrapper"
                                        style="display:none; max-height:220px; overflow-y:auto; border:1px solid #dee2e6; padding:8px; border-radius:6px;">

                                        @foreach ($releaseOptions as $opt)
                                            <div class="form-check mb-2 db-option-item">
                                                <input class="form-check-input db-opt" type="checkbox"
                                                    value="{{ $opt->name_da }}" id="db_opt_{{ $opt->id }}">
                                                <label class="form-check-label" for="db_opt_{{ $opt->id }}">
                                                    {{ $opt->name_da }}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>

                                </div>
                            </div>

                            <input type="hidden" name="main_option_key" id="main_option_key">
                            <input type="hidden" name="db_source_name" id="db_source_name">
                        </div>

                        {{-- Release / Transfer Date --}}
                        <div class="mb-3">
                            <label for="release_date" class="form-label">
                                د رهايي یا انتقال نېټه
                            </label>
                            <input type="text" class="form-control farsi-date" id="release_date" name="release_date"
                                required placeholder="د رهايي یا لېږد نېټه وټاکئ">
                        </div>



                        {{-- File --}}
                        <div class="col-md-12">
                            <label class="form-label">
                                ضمیمه فایل
                            </label>
                            <input type="file" name="file" class="form-control form-control-sm"
                                accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer d-flex justify-content-between mb-0">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                            بندول
                        </button>
                        <button type="submit" class="btn btn-success btn-sm">
                            ثبت کول
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('perisanDatePicker/js/persianDatepicker.js') }}"></script>


    <script>
        $('.select2').select2({
            width: '100%',
        });


        $(function() {
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
        });
    </script>
    <script>
        $('#store_form').validate({
            ignore: [],
            errorClass: 'error',
            errorElement: 'label',

            rules: {
                gender: {
                    required: true
                },
                suspect_name: {
                    required: true
                },
                father_name: {
                    required: true
                },
                grandfather_name: {
                    required: true
                },
                children_with_mother: {
                    required: true
                },
                crime_type: {
                    required: true
                },
                referring_authority: {
                    required: true
                },
                monitoring_date: {
                    required: true
                },
                province: {
                    required: true
                },
                district: {
                    required: true
                },
                area: {
                    required: true
                },
                file: {
                    required: true,
                    accept: "jpg,jpeg,png,pdf,doc,docx"
                }
            },

            messages: {
                gender: {
                    required: 'جنسیت انتخاب کړئ'
                },
                suspect_name: {
                    required: 'نوم ولیکئ'
                },
                father_name: {
                    required: 'د پلار نوم ولیکئ'
                },
                grandfather_name: {
                    required: 'د نیکه نوم ولیکئ'
                },
                children_with_mother: {
                    required: 'د مور سره د ماشومانو شمېره ولیکئ'
                },
                crime_type: {
                    required: 'د جرم ډول ولیکئ'
                },
                referring_authority: {
                    required: 'رالیږونکې اداره ولیکئ'
                },
                monitoring_date: {
                    required: 'د څارنې نیټه ولیکئ'
                },
                province: {
                    required: 'ولایت ولیکئ'
                },
                district: {
                    required: 'ناحیه ولیکئ'
                },
                area: {
                    required: 'منطقه ولیکئ'
                },
                file: {
                    required: 'فایل انتخاب کړئ',
                    accept: 'فایل باید jpg, png, pdf, doc, docx وي'
                }
            },

            highlight: function(element) {
                $(element).addClass('error');
            },

            unhighlight: function(element) {
                $(element).removeClass('error');
            },

            submitHandler: function(form) {
                form.submit();
            }
        });
    </script>



    <script>
        $(document).ready(function() {
            function gregorianToJalali(gy, gm, gd) {
                let g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
                let jy = (gy <= 1600) ? 0 : 979;
                gy -= (gy <= 1600) ? 621 : 1600;

                let gy2 = (gm > 2) ? (gy + 1) : gy;
                let days = 365 * gy + Math.floor((gy2 + 3) / 4) - Math.floor((gy2 + 99) / 100) + Math.floor((gy2 +
                    399) / 400) - 80 + gd + g_d_m[gm - 1];

                jy += 33 * Math.floor(days / 12053);
                days %= 12053;
                jy += 4 * Math.floor(days / 1461);
                days %= 1461;

                if (days > 365) {
                    jy += Math.floor((days - 1) / 365);
                    days = (days - 1) % 365;
                }

                let jm = (days < 186) ? 1 + Math.floor(days / 31) : 7 + Math.floor((days - 186) / 30);
                let jd = 1 + ((days < 186) ? (days % 31) : ((days - 186) % 30));

                return {
                    jy,
                    jm,
                    jd
                };
            }

            function getDifferenceInDays(date1, date2) {
                const oneDay = 24 * 60 * 60 * 1000;
                const firstDate = new Date(date1);
                const secondDate = new Date(date2);
                return Math.round((secondDate - firstDate) / oneDay);
            }

            $('#suspects_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('suspects.list') }}",
                columns: [{
                        "data": 'id',
                        render: function(data, type, row, meta) {
                            // Get current Gregorian date
                            const now = new Date();
                            const currentDate = gregorianToJalali(now.getFullYear(), now
                                .getMonth() + 1, now.getDate());

                            // Format as "1404-10-21"
                            const jalaliString =
                                `${currentDate.jy}-${currentDate.jm}-${currentDate.jd}`;
                            const diffInDays = getDifferenceInDays(row.monitoring_date,
                                jalaliString);

                            if (diffInDays < 9) {
                                return `<span class="badge badge-success">${meta.row + meta.settings._iDisplayStart + 1}</span>`;
                            } else if (diffInDays === 9) {
                                return `<span class="badge badge-warning">${meta.row + meta.settings._iDisplayStart + 1}</span>`;
                            } else {
                                return `<span class="badge badge-danger">${meta.row + meta.settings._iDisplayStart + 1}</span>`;
                            }
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {

                            // Current Gregorian date → Jalali
                            const now = new Date();
                            const currentDate = gregorianToJalali(
                                now.getFullYear(),
                                now.getMonth() + 1,
                                now.getDate()
                            );

                            const todayJalali =
                                currentDate.jy + '-' +
                                currentDate.jm + '-' +
                                currentDate.jd;

                            // Difference in days
                            const diffInDays = getDifferenceInDays(row.monitoring_date,
                                todayJalali);

                            let badgeClass = 'badge-success';
                            let message = '';


                            if (diffInDays === 0) {
                                message = `مظنون  لــــومــــړۍ ورځ ده`;
                            } else if (diffInDays === 1) {
                                message = `مظنون  (۱) ورځ تیره شوې`;
                            } else {
                                message = `مظنون (${diffInDays}) ورځې تېرې شوي`;
                            }

                            // ✅ Badge color
                            if (diffInDays < 9) {
                                badgeClass = 'badge-success';
                            } else if (diffInDays === 9) {
                                badgeClass = 'badge-warning';
                            } else {
                                badgeClass = 'badge-danger';
                            }

                            return `
                             <span class="badge ${badgeClass}">
                                 ${message}
                             </span>`;
                        }


                    },
                    {
                        data: 'suspect_name',
                        name: 'suspect_name'
                    },
                    {
                        data: 'father_name',
                        name: 'father_name'
                    },
                    {
                        data: 'crime_type',
                        name: 'crime_type'
                    },
                    {
                        data: 'referring_authority',
                        name: 'referring_authority'
                    },
                    {
                        data: 'province_name',
                        name: 'province_name'
                    },
                    {
                        data: 'district',
                        name: 'district'
                    },
                    {
                        data: 'area',
                        name: 'area'
                    },
                    {
                        data: 'monitoring_date',
                        name: 'monitoring_date'
                    },
                    {
                        data: 'action',
                        className: 'text-center font-weight-bolder'
                    },
                ]
            });



            // --- Show/hide "Children with Mother" based on Gender ---
            const $childrenDiv = $('#childrenWithMotherDiv');
            const $genderSelect = $('#gender');

            function toggleChildrenField() {
                if ($genderSelect.val() === 'ښځینه') {
                    $childrenDiv.show();
                } else {
                    $childrenDiv.hide();
                }
            }

            // Initial check in case the form is pre-filled
            toggleChildrenField();

            // When gender changes
            $genderSelect.on('change', function() {
                toggleChildrenField();
            });



            // --- Submit Form with AJAX ---
            $(document).on('submit', '#store_form', function(e) {
                e.preventDefault();

                clearFormErrors();

                $.ajax({
                    url: "{{ route('suspects.store') }}",
                    method: "POST",
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,

                    beforeSend: function() {
                        $('.someBlock').preloader({
                            zIndex: '6666666666'
                        });
                    },

                    success: function(response) {
                        $('.someBlock').preloader('remove');

                        if (response.status === true) {
                            Swal.fire(
                                'ثبت شو!',
                                'معــلومات په مکمـــل توګــه ثبت شــــو!',
                                'success'
                            );

                            setTimeout(() => {
                                $('#store_form')[0].reset();
                                toggleChildrenField(); // reset
                                location.assign("{{ route('suspects.index') }}");
                            }, 500); // delay to show success popup

                        } else {
                            $.each(response, function(field, msg) {
                                let input = $("[name='" + field + "']");
                                input.addClass('error').attr('aria-invalid', true);

                                if ($("#" + field + "-error").length) {
                                    $("#" + field + "-error").html(
                                        '<span class="text-danger" style="font-size:12px;font-weight:bold;float:left">' +
                                        msg[0] + '</span>'
                                    ).show();
                                } else {
                                    input.after(
                                        '<label id="' + field +
                                        '-error" class="error">' +
                                        '<span class="text-danger" style="font-size:12px;font-weight:bold;float:left">' +
                                        msg[0] + '</span></label>'
                                    );
                                }
                            });
                        }
                    },

                    error: function() {
                        error_function('! System Error Call Administrator Of System');
                    }
                });
            });

            // --- Reset modal when closed ---
            $('#suspectModal').on('hidden.bs.modal', function() {
                let modal = $(this);
                modal.find('label.error').remove();
                modal.find('.invalid-feedback').remove();
                modal.find('.is-invalid').removeClass('is-invalid');
                modal.find('.error').removeClass('error');
                $('#store_form')[0].reset();
                toggleChildrenField(); // Ensure children field is hidden/reset
            });

            // --- Clear form errors function ---
            function clearFormErrors() {
                $('#store_form').find('.error').removeClass('error');
                $('#store_form').find('[aria-invalid="true"]').attr('aria-invalid', false);
                $('#store_form').find('label.error').remove();
            }

        });
    </script>

    <script>
        $(document).ready(function() {


            function toggleEditChildrenField() {
                if ($('#edit_gender').val() === 'ښځینه') {
                    $('#edit_childrenWithMotherDiv').show();
                } else {
                    $('#edit_childrenWithMotherDiv').hide();
                }
            }

            $('#edit_gender').on('change', toggleEditChildrenField);

            $(document).on('click', '.edit-btn', function() {
                let id = $(this).data('id');

                $.ajax({
                    url: '/suspects/edit/' + id,
                    method: 'GET',
                    success: function(data) {

                        // Fill inputs
                        $('#edit_suspect_id').val(data.id);
                        $('#edit_gender').val(data.gender);
                        $('#edit_suspect_name').val(data.suspect_name);
                        $('#edit_father_name').val(data.father_name);
                        $('#edit_grandfather_name').val(data.grandfather_name);
                        $('#edit_children_with_mother').val(data.children_with_mother);
                        $('#edit_crime_type').val(data.crime_type);
                        $('#edit_referring_authority').val(data.referring_authority);
                        $('#edit_monitoring_date').val(data.monitoring_date);
                        // $('#edit_province').val(data.province_id);
                        $('#edit_province').val(data.province_id).trigger('change');

                        $('#edit_district').val(data.district);
                        $('#edit_area').val(data.area);

                        // Reset first
                        $("input[name='has_items']").prop('checked', false);

                        if (data.has_items !== null) {
                            $("input[name='has_items'][value='" + data.has_items + "']")
                                .prop('checked', true);
                        }



                        // Show existing file link if available
                        if (data.file) {
                            $('#edit_existing_file')
                                .html(
                                    `<a href="/uploads/${data.file}" target="_blank" class="text-primary">موجوده فایل (${data.file})</a>`
                                );
                        } else {
                            $('#edit_existing_file').text('هیڅ فایل اپلوډ شوی ندی');
                        }

                        toggleEditChildrenField();

                        $('#editSuspectModal').modal('show');
                    }
                });
            });

            // Submit Edit Form
            $('#edit_form').submit(function(e) {
                e.preventDefault();

                let id = $('#edit_suspect_id').val();

                $.ajax({
                    url: "{{ route('suspects.update', ['id' => ':id']) }}".replace(':id', id),

                    method: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    dataType: 'json',

                    success: function(response) {
                        var modal = bootstrap.Modal.getInstance(document.getElementById(
                            'editSuspectModal'));
                        modal.hide();

                        if (response.status === true) {

                            Swal.fire({
                                icon: 'success',
                                title: 'معلومات په بریالیتوب سره تغیر شول!',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            $('#editSuspectModal').modal('hide');

                            setTimeout(() => {
                                location.reload();
                            }, 1500);

                        } else {
                            // Validation errors
                            $.each(response, function(field, msg) {
                                let input = $("[name='" + field + "']");
                                input.addClass('error');

                                if ($("#" + field + "-error").length) {
                                    $("#" + field + "-error").html(msg[0]).show();
                                } else {
                                    input.after('<label id="' + field +
                                        '-error" class="error text-danger">' + msg[
                                            0] + '</label>');
                                }
                            });
                        }
                    },

                    error: function(err) {
                        console.log("AJAX Error:", err);
                    }
                });
            });

        });
    </script>



    <script>
        $(document).on('click', '.destroy_btn', function() {
            let suspectId = $(this).data('id');

            Swal.fire({
                title: 'ایا تاسې ډاډه یاست؟',
                text: 'تاسې به دا معلومات حذف کړئ!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: ' هو',
                cancelButtonText: 'نه!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('suspects.destroy', '') }}/" + suspectId,
                        type: 'GET',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === true) {
                                Swal.fire(
                                    'حذف شو!',
                                    'معلومات په بریالیتوب سره حذف شول.',
                                    'success'
                                );
                                $('#suspects_table').DataTable().ajax.reload();
                            } else {
                                Swal.fire(
                                    'خطا!',
                                    'د معلوماتو د حذف کولو پر مهال ستونزه رامنځته شوه.',
                                    'error'
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                'خطا!',
                                'د معلوماتو د حذف کولو پر مهال ستونزه رامنځته شوه.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '.release-btn', function() {
            let suspectId = $(this).data('id');
            $('#release_suspect_id').val(suspectId);
            $('#releaseModal').modal('show');
        });
        $('#releaseForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('release.store') }}",
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                dataType: 'json',

                success: function(res) {
                    if (res.status == true) {

                        $('#releaseModal').modal('hide');
                        $('#releaseForm')[0].reset();

                        // Refresh Released List Page
                        $('#suspects_table').DataTable().ajax.reload(null, false);


                        Swal.fire({
                            icon: 'success',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                }
            });
        });

        // --- Reset modal when closed ---
        $('#releaseModal').on('hidden.bs.modal', function() {
            let modal = $(this);
            modal.find('label.error').remove();
            modal.find('.invalid-feedback').remove();
            modal.find('.is-invalid').removeClass('is-invalid');
            modal.find('.error').removeClass('error');
            $('#releaseForm')[0].reset();

        });

        // --- Clear form errors function ---
        function clearFormErrors() {
            $('#releaseForm').find('.error').removeClass('error');
            $('#releaseForm').find('[aria-invalid="true"]').attr('aria-invalid', false);
            $('#releaseForm').find('label.error').remove();
            $('#releaseForm').find('label.error').remove();
        }
    </script>

    <!-- JS: behavior & sync label -->
    <script>
        document.getElementById('db_search_wrapper').style.display = 'block';


        document.addEventListener("DOMContentLoaded", function() {
            let mainOptions = document.querySelectorAll(".main-opt");
            let dbWrapper = document.getElementById("db_options_wrapper");
            let dbOptions = document.querySelectorAll(".db-opt");
            let label = document.getElementById("releaseDropdownLabel");

            // Hidden fields
            let mainKey = document.getElementById("main_option_key");
            let dbName = document.getElementById("db_source_name");
            let dropdownBtn = document.getElementById("releaseDropdownBtn");

            // Reset both hidden fields
            function resetDB() {
                dbOptions.forEach(x => x.checked = false);
                dbName.value = "";
            }

            // MAIN OPTION logic
            mainOptions.forEach(opt => {
                opt.addEventListener("change", function() {

                    let key = this.dataset.key; // detention, multi, release
                    let title = this.value;

                    // set main option key
                    mainKey.value = key;

                    resetDB(); // reset DB list

                    if (key === "detention") {
                        dbWrapper.style.display = "none";
                        dbName.value = null;

                        label.textContent = title;

                        bootstrap.Dropdown.getInstance(dropdownBtn).hide();
                        return;
                    }

                    if (key === "multi" || key === "release") {
                        dbWrapper.style.display = "block";

                        // Label shows only main category until DB selected
                        label.textContent = title;
                    }
                });
            });

            // DB option selected
            dbOptions.forEach(opt => {
                opt.addEventListener("change", function() {

                    // Single select only
                    dbOptions.forEach(x => {
                        if (x !== this) x.checked = false;
                    });

                    dbName.value = this.value; // store DB name

                    label.textContent = this.value;

                    bootstrap.Dropdown.getInstance(dropdownBtn).hide();
                });
            });
        });

        // Search functionality
        document.getElementById('db_option_search').addEventListener('keyup', function() {
            let searchValue = this.value.toLowerCase();
            let items = document.querySelectorAll('.db-option-item');

            items.forEach(function(item) {
                let text = item.innerText.toLowerCase();
                item.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });
    </script>
    {{--  suspect release modal notes showing properly --}}
    <script>
        $(document).on('click', '.release-btn', function() {

            let suspectId = $(this).data('id');
            let notes = $(this).data('notes');

            // set hidden input
            $('#release_suspect_id').val(suspectId);

            if (!notes || notes.trim() === '') {

                $('#itemsStatusWrapper').hide();
            } else {

                $('#itemsStatusWrapper').show();
            }

            $('#releaseModal').modal('show');
        });
    </script>
@endsection
