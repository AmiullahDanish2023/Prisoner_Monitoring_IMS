@extends('layouts.master')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/persian-date/persian-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('perisanDatePicker/css/persianDatepicker-default.css') }}" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <div class="card shadow-sm rounded">
        <div class="card-body p-4" style="background: #fdfdfd; font-weight: 500;">
            <form id="releasedSuspectForm" action="{{ route('reports.released.pdf') }}" method="POST" class="row g-3">
                @csrf

                <h4 class="text-center text-primary mb-3 fw-bold">
                    د رهایی یا انتقال مظنونینو عمومي راپور
                </h4>
                <hr>
                <!-- نوم -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">نوم</label>
                    <input type="text" name="first_name" class="form-control form-control-sm" placeholder="د مظنون نوم">
                </div>

                <!-- د پلار نوم -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">د پلار نوم</label>
                    <input type="text" name="father_name" class="form-control form-control-sm" placeholder="د پلار نوم">
                </div>

                <!-- جنسیت -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">جنسیت</label>
                    <select name="gender" class="form-select form-select-sm">
                        <option value=""> انتخاب جنسیت </option>
                        <option value="all">عمومی (ذکور و اناث)</option>
                        <option value="نارینه">مظنونین ذکور</option>
                        <option value="ښځینه">مظنونین اناث</option>
                    </select>
                </div>

                <!-- ولایت -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">ولایت</label>
                    <select name="province_id" class="form-select form-select-sm">
                        <option value="">انتخاب ولایت</option>
                        @foreach ($province as $pro)
                            <option value="{{ $pro->id }}">{{ $pro->name_da }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- تاریخ شروع -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">تاریخ شروع</label>
                    <input type="text" name="start_date" class="form-control form-control-sm farsi-date"
                        placeholder="از تاریخ" autocomplete="off">
                </div>

                <!-- تاریخ ختم -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">تاریخ ختم</label>
                    <input type="text" name="end_date" class="form-control form-control-sm farsi-date"
                        placeholder="تا تاریخ" autocomplete="off">
                </div>

                <!-- مرجع رها کننده -->
                <div class="col-md-3">
                    <label class="form-label fw-bold"> د رهايي یا انتقال مرجع</label>
                    <div class="dropdown w-100">
                        <button class="form-control form-control-sm text-start dropdown-toggle" type="button"
                            id="reportReleaseDropdownBtn" data-bs-toggle="dropdown">
                            <span id="reportReleaseDropdownLabel">یوه مرجع وټاکئ</span>
                        </button>
                        <div class="dropdown-menu p-3 w-100" style="max-width:350px;">
                            @foreach (['detention' => 'توقیف ته انتقال شوی', 'multi' => 'مختلفو مراجعو ته انتقال', 'release' => 'رها شوي مظنونین'] as $key => $label)
                                <div class="form-check mb-2">
                                    <input class="form-check-input report-main-opt" type="radio" name="report_main_option"
                                        value="{{ $key }}" data-title="{{ $label }}">
                                    <label class="form-check-label">{{ $label }}</label>
                                </div>
                            @endforeach
                            <hr>
                            <div id="report_db_wrapper" style="display:none; max-height:220px; overflow-y:auto;">
                                @foreach ($releaseSources as $opt)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input report-db-opt" name="report_db_option" type="radio"
                                            value="{{ $opt->name_da }}">
                                        <label class="form-check-label">{{ $opt->name_da }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="main_option_key" id="report_main_key">
                    <input type="hidden" name="db_source_name" id="report_db_name">
                </div>

                <!-- نوع جرم -->
                <div class="col-md-3">
                    <label class="form-label fw-bold"> د جرم ډول</label>
                    <select name="crime_type" class="form-select form-select-sm">
                        <option value="">د جرم ډول وټاکئ</option>
                        @foreach ($crimeTypes as $crime)
                            <option value="{{ $crime }}">{{ $crime }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="col-12 text-end mt-3">
                    <button type="submit" class="btn btn-success btn-sm px-4">
                        راپور جوړول
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('perisanDatePicker/js/persianDatepicker.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function resetReleasedForm() {
            const form = $('#releasedSuspectForm')[0];

            // Reset all text inputs, selects, textareas
            form.reset();

            // Reset hidden fields
            $('#report_main_key').val('');
            $('#report_db_name').val('');

            // Reset custom dropdown label
            $('#reportReleaseDropdownLabel').text('یوه مرجع وټاکئ');

            // Reset Persian datepickers
            $('.farsi-date').persianDatepicker({
                format: 'YYYY/MM/DD',
                initialValue: false,
                autoClose: true
            }).persianDatepicker("reset");

            // Clear all radio buttons
            $('.report-main-opt, .report-db-opt').prop('checked', false);

            // Hide DB wrapper
            $('#report_db_wrapper').hide();
        }

        // Reset on initial load
        $(document).ready(function() {
            resetReleasedForm();
        });

        // Reset when returning via back/forward button
        window.addEventListener('pageshow', function(event) {
            if (event.persisted || (window.performance && window.performance.getEntriesByType("navigation")[0]
                    .type === "back_forward")) {
                resetReleasedForm();
            }
        });

        // Dropdown logic
        document.addEventListener("DOMContentLoaded", function() {
            const mainOptions = document.querySelectorAll(".report-main-opt");
            const dbOptions = document.querySelectorAll(".report-db-opt");
            const dbWrapper = document.getElementById("report_db_wrapper");
            const mainKey = document.getElementById("report_main_key");
            const dbName = document.getElementById("report_db_name");
            const label = document.getElementById("reportReleaseDropdownLabel");
            const btn = document.getElementById("reportReleaseDropdownBtn");
            const dropdownInstance = new bootstrap.Dropdown(btn);

            mainOptions.forEach(opt => {
                opt.addEventListener("change", function() {
                    dbOptions.forEach(x => x.checked = false);
                    dbName.value = "";
                    mainKey.value = this.value;
                    label.textContent = this.dataset.title;
                    dbWrapper.style.display = (this.value === "detention") ? "none" : "block";
                    dropdownInstance.hide();
                });
            });

            dbOptions.forEach(opt => {
                opt.addEventListener("change", function() {
                    mainOptions.forEach(x => x.checked = false);
                    mainKey.value = "";
                    dbOptions.forEach(x => {
                        if (x !== this) x.checked = false;
                    });
                    dbName.value = this.value;
                    label.textContent = this.value;
                    dropdownInstance.hide();
                });
            });
        });
    </script>
@endsection
