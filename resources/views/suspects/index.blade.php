@extends('layouts.master')
@section('content')
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
            </style>

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped  table-checkable align-middle"
                    id="suspects_table">
                    <thead style="background-color:#c1effa;">
                        <tr class="bg-primary-o-10">
                            <th>شماره</th>
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
                                placeholder="د مظنون نوم">
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
                            <input type="date" name="monitoring_date" class="form-control form-control-sm"
                                placeholder="د نظارت نیټه">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ولایت</label>
                            <select name="province" id="province" class="form-select form-select-sm form-select-solid ">
                                <option selected disabled>ولایت انتخاب کړئ</option>
                                @foreach ($province as $prov)
                                    <option value="{{ $prov->id }}">{{ $prov->name_da }}</option>
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

                        <div class="col-md-12">
                            <label class="form-label">فایل</label>
                            <input type="file" name="file" class="form-control form-control-sm">
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
                    <h5 class="modal-title text-center w-100">د مظنون معلومات تغیرول</h5>
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
                            <input type="date" name="monitoring_date" id="edit_monitoring_date"
                                class="form-control form-control-sm">
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
                    <h5 class="modal-title text-center w-100" id="releaseModalLabel">رهایی / انتقال مظنون</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="releaseForm">
                    @csrf

                    <div class="modal-body">
                        <input type="hidden" name="suspect_id" id="release_suspect_id">

                        <div class="mb-3">
                            <label for="issued_or_transferred_number" class="form-label">صادره رهایی و یا انتقال</label>
                            <input type="text" class="form-control" id="issued_or_transferred_number"
                                name="issued_or_transferred_number">
                        </div>


                        <div class="mb-3">
                            <label class="form-label">مرجع رها کننده</label>

                            <div class="dropdown w-100">
                                <button class="form-control text-start d-flex justify-content-between align-items-center"
                                    type="button" id="releaseDropdownBtn" data-bs-toggle="dropdown">
                                    <span id="releaseDropdownLabel">یو اختیار انتخاب کړئ</span>
                                    <i class="bi bi-caret-down-fill"></i>
                                </button>

                                <div class="dropdown-menu p-3 w-100" style="max-width:350px;">

                                    {{-- 3 STATIC OPTIONS --}}
                                    <div class="form-check mb-2">
                                        <input class="form-check-input main-opt" type="radio" name="main_option"
                                            value="انتقال به توقیف" id="main_opt_1" data-key="detention">
                                        <label class="form-check-label" for="main_opt_1">انتقال به توقیف</label>
                                    </div>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input main-opt" type="radio" name="main_option"
                                            value="انتقال به مراجع مختلف" id="main_opt_2" data-key="multi">
                                        <label class="form-check-label" for="main_opt_2">انتقال به مراجع مختلف</label>
                                    </div>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input main-opt" type="radio" name="main_option"
                                            value="مظنونین رهایی" id="main_opt_3" data-key="release">
                                        <label class="form-check-label" for="main_opt_3">مظنونین رهایی</label>
                                    </div>

                                    <hr>

                                    {{-- DB OPTIONS (HIDDEN INITIALLY) --}}
                                    <div id="db_options_wrapper" style="display:none;">
                                        @foreach ($releaseOptions as $opt)
                                            <div class="form-check mb-2">
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



                        <div class="mb-3">
                            <label for="release_date" class="form-label">تاریخ رهایی یا انتقال</label>
                            <input type="date" class="form-control" id="release_date" name="release_date" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">فایل</label>
                            <input type="file" name="file" class="form-control form-control-sm">
                        </div>
                    </div>


                    <div class="modal-footer d-flex justify-content-between mb-0">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">بندول</button>
                        <button type="submit" class="btn btn-success btn-sm">ثبتول</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('perisanDatePicker/js/persianDatepicker.js') }}"></script>
    <script>
        $('#store_form').validate({
            ignore: [],
            rules: {
                gender: {
                    required: true,
                },
                suspect_name: {
                    required: true,
                },
                father_name: {
                    required: true,
                },
                grandfather_name: {
                    required: true,
                },
                children_with_mother: {
                    required: true,
                },
                crime_type: {
                    required: true,
                },
                referring_authority: {
                    required: true,
                },
                monitoring_date: {
                    required: true,
                },
                province: {
                    required: true,
                },
                district: {
                    required: true,
                },
                area: {
                    required: true,
                },
                file: {
                    required: true,
                    accept: "image/jpeg,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                }
            },
            messages: {

                gender: {
                    required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">جنسیت انتخاب کړئ</span>',
                },
                suspect_name: {
                    required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">د مظنون نوم ولیکئ</span>',
                },
                father_name: {
                    required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">د پلار نوم ولیکئ</span>',
                },
                grandfather_name: {
                    required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">د نیکه نوم ولیکئ</span>',
                },
                children_with_mother: {
                    required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">د مور سره د ماشومانو شمېره ولیکئ</span>',
                },
                crime_type: {
                    required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">د جرم ډول ولیکئ</span>',
                },
                referring_authority: {
                    required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">رالیږونکې اداره ولیکئ</span>',
                },
                monitoring_date: {
                    required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">د څارنې نیټه ولیکئ</span>',
                },
                province: {
                    required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">ولایت ولیکئ</span>',
                },
                district: {
                    required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">ناحیه ولیکئ</span>',
                },
                area: {
                    required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">منطقه ولیکئ</span>',
                },
                file: {
                    required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">فایل انتخاب کړئ</span>',
                    accept: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">فایل باید jpg, pdf, doc, docx بڼه ولري</span>'
                }

            },


        });
    </script>

    <script>
        $(document).ready(function() {

            // --- DataTable initialization ---
            $('#suspects_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('suspects.list') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
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

            // -------------------------------
            // Toggle Children Field on Gender
            // -------------------------------
            function toggleEditChildrenField() {
                if ($('#edit_gender').val() === 'ښځینه') {
                    $('#edit_childrenWithMotherDiv').show();
                } else {
                    $('#edit_childrenWithMotherDiv').hide();
                }
            }

            $('#edit_gender').on('change', toggleEditChildrenField);


            // -------------------------------
            // Load Edit Modal With Data
            // -------------------------------
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
    </script>
@endsection
