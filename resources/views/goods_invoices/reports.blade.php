@extends('layouts.master')

@section('content')
    <link rel="stylesheet" href="{{ asset('perisanDatePicker/css/persianDatepicker-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons/bootstrap-icons.css') }}" />

    <style>
     
        .report-header {
            background: linear-gradient(135deg, #2c3e7a, #3f577c);
            color: #fff;
            padding: 20px 25px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .report-header h3 {
            margin: 0;
            font-weight: 700;
        }

        .report-header p {
            margin: 5px 0 0;
            opacity: 0.8;
        }

        /* د فلټر پینل */
        .filter-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
        }

        .filter-section .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #3f577c;
            margin-bottom: 4px;
        }

        .filter-section .form-control-sm,
        .filter-section .form-select-sm {
            border-radius: 6px;
            border: 1px solid #ced4da;
            font-size: 13px;
        }

        .filter-section .form-control-sm:focus,
        .filter-section .form-select-sm:focus {
            border-color: #3f577c;
            box-shadow: 0 0 0 0.2rem rgba(63, 87, 124, 0.15);
        }

        /* د راپور ډول بټنونه */
        .report-type-btns {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .report-type-btns .btn {
            border-radius: 20px;
            font-size: 13px;
            padding: 6px 18px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .report-type-btns .btn.active {
            background: #3f577c;
            color: #fff;
            border-color: #3f577c;
            box-shadow: 0 4px 10px rgba(63, 87, 124, 0.3);
        }

        /* د مجموعاً کارتونه */
        .summary-card {
            background: #fff;
            border-radius: 10px;
            padding: 18px;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            height: 100%;
        }

        .summary-card:hover {
            box-shadow: 0 4px 15px rgba(63, 87, 124, 0.1);
            transform: translateY(-2px);
        }

        .summary-card .card-icon {
            font-size: 28px;
            color: #3f577c;
            margin-bottom: 10px;
        }

        .summary-card .card-value {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e7a;
        }

        .summary-card .card-label {
            font-size: 13px;
            color: #6c757d;
            font-weight: 500;
        }

        /* د راپور جدول */
        .report-table {
            border: 2px solid #3f577c !important;
            border-radius: 10px;
            overflow: hidden;
            width: 100%;
        }

        .report-table thead th {
            background: #3f577c !important;
            color: #fff !important;
            font-weight: 600;
            text-align: center;
            padding: 12px 10px;
            border: 1px solid #2c3e7a !important;
            font-size: 13px;
            white-space: nowrap;
        }

        .report-table tbody td {
            text-align: center;
            padding: 10px;
            border: 1px solid #dee2e6 !important;
            vertical-align: middle;
            font-size: 13px;
        }

        .report-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .report-table tbody tr:hover {
            background-color: #e3f2fd !important;
            transition: background-color 0.3s ease;
        }

        .report-table tfoot td {
            background: #f1f3f5;
            font-weight: 700;
            border: 1px solid #dee2e6 !important;
            padding: 12px 10px;
            font-size: 14px;
        }

        /* د بار کولو انیمیشن */
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 40px;
        }

        .loading-spinner.show {
            display: block;
        }

        /* د چاپ سټایل */
        @media print {
            @page {
                size: A4 landscape;
                margin: 10mm;
            }

            body * {
                visibility: hidden;
            }

            #reportContent,
            #reportContent * {
                visibility: visible;
            }

            #reportContent {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }

            .report-table {
                border-collapse: collapse !important;
            }

            .report-table th,
            .report-table td {
                border: 1px solid #333 !important;
                padding: 6px !important;
                font-size: 11px;
            }
        }
    </style>

    <div class="card shadow-sm">
        {{-- د راپور هدر --}}
        <div class="card-header" style="background: linear-gradient(135deg, #2c3e7a, #3f577c);">

            <div class="d-flex flex-row-reverse justify-content-between align-items-center w-100">

                {{-- د راپور عنوان --}}
                <div class="text-end">
                    <h4 class="mb-0 text-white">
                        <i class="bi bi-file-earmark-bar-graph me-2"></i>
                        د بیلونو راپور
                    </h4>
                </div>

                {{-- د چاپ او بېرته تګ بټنونه --}}
                <div class="no-print d-flex align-items-center gap-2">
                    @can('Print Goods Invoice Reports')
                        <button type="button" class="btn btn-light btn-sm" onclick="printReport()">
                            <i class="bi bi-printer"></i>
                            راپور چاپ کړئ
                        </button>
                    @endcan



                    <a href="{{ route('bills.index') }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-arrow-right"></i>
                        بېرته ستنېدل
                    </a>

                </div>
            </div>
        </div>
    </div>


    <div class="card-body">
        {{-- ==========================================
                 د فلټر پینل
          ========================================== --}}
        <div class="filter-section no-print">
            <form id="reportFilterForm">
                <div class="row g-3">
                    {{-- د بیل نمبر --}}
                    <div class="col-md-2">
                        <label class="form-label">
                            <i class="bi bi-hash"></i> بیل نمبر
                        </label>
                        <input type="text" name="bill_number" id="filter_bill_number"
                            class="form-control form-control-sm" placeholder="بیل نمبر ولیکئ">
                    </div>

                    {{-- د دوکان نوم --}}
                    <div class="col-md-2">
                        <label class="form-label">
                            <i class="bi bi-shop"></i> د دوکان نوم
                        </label>
                        <select name="shop_name" id="filter_shop_name" class="form-select form-select-sm">
                            <option value="">ټول دوکانونه</option>
                            @foreach ($shops as $shop)
                                <option value="{{ $shop }}">{{ $shop }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- د جنس نوم --}}
                    <div class="col-md-2">
                        <label class="form-label">
                            <i class="bi bi-box-seam"></i> د جنس نوم
                        </label>
                        <select name="item_name" id="filter_item_name" class="form-select form-select-sm">
                            <option value="">ټول اجناس</option>
                            @foreach ($itemsList as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- له نېټې --}}
                    <div class="col-md-2">
                        <label class="form-label">
                            <i class="bi bi-calendar"></i> له نېټې
                        </label>
                        <input type="text" name="start_date" id="filter_start_date"
                            class="form-control form-control-sm farsi-date" placeholder="له نېټې">
                    </div>

                    {{-- تر نېټې --}}
                    <div class="col-md-2">
                        <label class="form-label">
                            <i class="bi bi-calendar-check"></i> تر نېټې
                        </label>
                        <input type="text" name="end_date" id="filter_end_date"
                            class="form-control form-control-sm farsi-date" placeholder="تر نېټې">
                    </div>

                    {{-- کال --}}
                    <div class="col-md-2">
                        <label class="form-label">
                            <i class="bi bi-calendar-year"></i> کال
                        </label>
                        <select name="year" id="filter_year" class="form-select form-select-sm">
                            <option value="">ټول کالونه</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- میاشت --}}
                    {{-- <div class="col-md-2">
                        <label class="form-label">
                            <i class="bi bi-calendar-month"></i> میاشت
                        </label>
                        <select name="month" id="filter_month" class="form-select form-select-sm">
                            <option value="">ټول میاشتې</option>
                            @foreach ($jalaliMonths as $key => $month)
                                <option value="{{ $key }}">{{ $month }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    {{-- د تادیې طریقه --}}
                    <div class="col-md-2">
                        <label class="form-label">
                            <i class="bi bi-credit-card"></i> د تادیې طریقه
                        </label>
                        <select name="payment_method" id="filter_payment_method" class="form-select form-select-sm">
                            <option value="">ټولې طریقې</option>
                            <option value="cash">نقد</option>
                            <option value="credit">پور</option>
                            <option value="card">کارت</option>
                        </select>
                    </div>

                    {{-- حالت --}}
                    <div class="col-md-2">
                        <label class="form-label">
                            <i class="bi bi-toggle-on"></i> حالت
                        </label>
                        <select name="status" id="filter_status" class="form-select form-select-sm">
                            <option value="">ټول حالتونه</option>
                            <option value="active">فعال</option>
                            <option value="cancelled">لغو شوی</option>
                        </select>
                    </div>

                    {{-- د راپور ډول --}}
                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="bi bi-bar-chart"></i> د راپور ډول
                        </label>
                        <select name="report_type" id="filter_report_type" class="form-select form-select-sm">
                            <option value="summary"> راپور (تفصیلي)</option>
                            <option value="items">د جنس له مخې</option>
                            <option value="shops">د دوکان له مخې</option>
                            {{-- <option value="monthly">میاشتنی راپور</option> --}}
                            <option value="payment">د تادیې طریقې له مخې</option>
                            <option value="status">د حالت له مخې</option>
                            <option value="images">د عکسونو راپور</option>
                        </select>
                    </div>

                    {{-- بټنونه --}}
                    <div class="col-md-6 d-flex align-items-end gap-2">
                        <button type="button" class="btn btn-primary btn-sm" id="btnGenerateReport">
                            <i class="bi bi-search"></i> راپور جوړول
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" id="btnResetFilters">
                            <i class="bi bi-undo-alt"></i> پاکول
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- ==========================================
                 د بار کولو انیمیشن
                 ========================================== --}}
        <div class="loading-spinner" id="loadingSpinner">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">بار کیږي...</span>
            </div>
            <p class="mt-3 text-muted">راپور جوړیږي، مهرباني وکړئ انتظار وکړئ...</p>
        </div>

        {{-- ==========================================
                 د راپور مینځپانګه
                 ========================================== --}}
        <div id="reportContent" style="display: none;">
            {{-- د ټولیز کارتونه --}}
            <div class="row mb-4" id="summaryCards">
                {{-- به د JavaScript له لارې ډک شي --}}
            </div>

            {{-- د راپور جدول --}}
            <div class="table-responsive">
                <table class="table report-table" id="reportTable">
                    <thead id="reportTableHead">
                        {{-- به د JavaScript له لارې ډک شي --}}
                    </thead>
                    <tbody id="reportTableBody">
                        {{-- به د JavaScript له لارې ډک شي --}}
                    </tbody>
                    <tfoot id="reportTableFoot">
                        {{-- به د JavaScript له لارې ډک شي --}}
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- ==========================================
                 د خالي حالت
                 ========================================== --}}
        <div id="emptyState" class="text-center py-5" style="display: none;">
            <i class="bi bi-inbox" style="font-size: 60px; color: #dee2e6;"></i>
            <h5 class="mt-3 text-muted">هیڅ معلومات ونه موندل شو</h5>
            <p class="text-muted">مهرباني وکړئ د فلټر انتخابونه بدل کړئ</p>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    {{-- ==========================================
         1. لومړی jQuery
         ========================================== --}}


    <script src="{{ asset('perisanDatePicker/js/persianDatepicker.min.js') }}"></script>
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
        $(document).ready(function() {




            // ============================================
            // د راپور جوړولو بټن
            // ============================================
            $('#btnGenerateReport').on('click', function() {
                generateReport();
            });

            // ============================================
            // د فلټر پاکولو بټن
            // ============================================
            $('#btnResetFilters').on('click', function() {
                $('#reportFilterForm')[0].reset();
                $('#filter_report_type').val('summary');
                $('#reportContent').hide();
                $('#emptyState').show();
            });

            // ============================================
            // د راپور ډول بدلول
            // ============================================
            $('#filter_report_type').on('change', function() {
                generateReport();
            });

            // ============================================
            // د راپور جوړولو اصلي فنکشن
            // ============================================
            function generateReport() {
                // د بار کولو ښودل
                $('#loadingSpinner').addClass('show');
                $('#reportContent').hide();
                $('#emptyState').hide();

                // د فلټر ډاټا راټولول
                var formData = {
                    bill_number: $('#filter_bill_number').val(),
                    shop_name: $('#filter_shop_name').val(),
                    item_name: $('#filter_item_name').val(),
                    start_date: $('#filter_start_date').val(),
                    end_date: $('#filter_end_date').val(),
                    year: $('#filter_year').val(),
                    month: $('#filter_month').val(),
                    payment_method: $('#filter_payment_method').val(),
                    status: $('#filter_status').val(),
                    report_type: $('#filter_report_type').val(),
                };

                $.ajax({
                    url: '{{ route('bills.reports.data') }}',
                    type: 'GET',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        $('#loadingSpinner').removeClass('show');

                        if (response.success) {
                            renderReport(response);
                        } else {
                            $('#emptyState').show();
                        }
                    },
                    error: function(xhr) {
                        $('#loadingSpinner').removeClass('show');
                        $('#emptyState').show();
                        console.error('Report error:', xhr);
                        if (typeof toastr !== 'undefined') {
                            toastr.error('د راپور جوړولو کې تېروتنه رامنځته شوه');
                        }
                    }
                });
            }

            // ============================================
            // د راپور ښودل
            // ============================================
            function renderReport(response) {
                var reportType = response.report_type;
                var data = response.data;
                var summary = response.summary;

                // د ټولیز کارتونه
                renderSummaryCards(summary, reportType);

                // د جدول سر
                renderTableHead(reportType);

                // د جدول مینځپانګه
                renderTableBody(data, reportType);

                // د جدول فوټر
                renderTableFoot(summary, reportType);

                // د راپور ښودل
                $('#reportContent').show();
                $('#emptyState').hide();
            }

            // ============================================
            // د ټولیز کارتونه
            // ============================================
            function renderSummaryCards(summary, reportType) {
                var html = '';

                if (reportType === 'summary') {
                    html = `
                        <div class="col-md-3 mb-3">
                            <div class="summary-card text-center">
                                <div class="card-icon"><i class="bi bi-receipt"></i></div>
                                <div class="card-value">${summary.total_bills || 0}</div>
                                <div class="card-label">ټول بیلونه</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="summary-card text-center">
                                <div class="card-icon"><span class="badge bg-light text-dark">AFG</span></i></div>
                                <div class="card-value">${Number(summary.total_amount || 0)}</div>
                                <div class="card-label">مجموعي قیمت</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="summary-card text-center">
                                <div class="card-icon"><i class="bi bi-box"></i></div>
                                <div class="card-value">${summary.total_items || 0}</div>
                                <div class="card-label">ټول اجناس</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="summary-card text-center">
                                <div class="card-icon"><i class="bi bi-shop"></i></div>
                                <div class="card-value">${summary.total_shops || 0}</div>
                                <div class="card-label">دوکانونه</div>
                            </div>
                        </div>
                    `;
                } else if (reportType === 'items') {
                    html = `
                        <div class="col-md-4 mb-3">
                            <div class="summary-card text-center">
                                <div class="card-icon"><i class="bi bi-box-seam"></i></div>
                                <div class="card-value">${summary.total_items || 0}</div>
                                <div class="card-label">د اجناسو ډولونه</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="summary-card text-center">
                                <div class="card-icon"><i class="bi bi-123"></i></div>
                                <div class="card-value">${Number(summary.total_quantity || 0)}</div>
                                <div class="card-label">ټول تعداد</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="summary-card text-center">
                                <div class="card-icon"><span class="badge bg-light text-dark">AFG</span></div>
                                <div class="card-value">${Number(summary.total_amount || 0)}</div>
                                <div class="card-label">مجموعي قیمت</div>
                            </div>
                        </div>
                    `;
                } else if (reportType === 'shops') {
                    html = `
                        <div class="col-md-4 mb-3">
                            <div class="summary-card text-center">
                                <div class="card-icon"><i class="bi bi-shop"></i></div>
                                <div class="card-value">${summary.total_shops || 0}</div>
                                <div class="card-label">دوکانونه</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="summary-card text-center">
                                <div class="card-icon"><i class="bi bi-receipt"></i></div>
                                <div class="card-value">${summary.total_bills || 0}</div>
                                <div class="card-label">ټول بیلونه</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="summary-card text-center">
                                <div class="card-icon"><span class="badge bg-light text-dark">AFG</span></div>
                                <div class="card-value">${Number(summary.total_amount || 0)}</div>
                                <div class="card-label">مجموعي قیمت</div>
                            </div>
                        </div>
                    `;
                } else if (reportType === 'images') {
                    html = `
                        <div class="col-md-6 mb-3">
                            <div class="summary-card text-center">
                                <div class="card-icon"><i class="bi bi-images"></i></div>
                                <div class="card-value">${summary.total_images || 0}</div>
                                <div class="card-label">ټول عکسونه</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="summary-card text-center">
                                <div class="card-icon"><i class="bi bi-receipt"></i></div>
                                <div class="card-value">${summary.total_bills || 0}</div>
                                <div class="card-label">اړوند بیلونه</div>
                            </div>
                        </div>
                    `;
                } else {
                    html = `
                        <div class="col-md-6 mb-3">
                            <div class="summary-card text-center">
                                <div class="card-icon"><i class="bi bi-receipt"></i></div>
                                <div class="card-value">${summary.total_bills || 0}</div>
                                <div class="card-label">ټول بیلونه</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="summary-card text-center">
                                <div class="card-icon"><span class="badge bg-light text-dark">AFG</span></div>
                                <div class="card-value">${Number(summary.total_amount || 0)}</div>
                                <div class="card-label">مجموعي قیمت</div>
                            </div>
                        </div>
                    `;
                }

                $('#summaryCards').html(html);
            }

            // ============================================
            // د جدول سر
            // ============================================
            function renderTableHead(reportType) {
                var html = '';

                if (reportType === 'summary') {
                    html = `
                        <tr>
                            <th>شمېره</th>
                            <th>بیل نمبر</th>
                            <th>د دوکان نوم</th>
                            <th>د اجناسو شمېر</th>
                            <th>مجموعي قیمت</th>
                            <th>بیل نیټه</th>
                            <th>د تادیې طریقه</th>
                            <th>حالت</th>
                        </tr>
                    `;
                } else if (reportType === 'items') {
                    html = `
                        <tr>
                            <th>شمېره</th>
                            <th>د جنس نوم</th>
                            <th>ټول تعداد</th>
                            <th>واحد</th>
                            <th>د بیلونو شمېر</th>
                            <th>اوسط قیمت</th>
                            <th>مجموعي قیمت</th>
                        </tr>
                    `;
                } else if (reportType === 'shops') {
                    html = `
                        <tr>
                            <th>شمېره</th>
                            <th>د دوکان نوم</th>
                            <th>تلیفون</th>
                            <th>پته</th>
                            <th>د بیلونو شمېر</th>
                            <th>مجموعي قیمت</th>
                            <th>اوسط قیمت</th>
                        </tr>
                    `;
                } else if (reportType === 'monthly') {
                    html = `
                        <tr>
                            <th>شمېره</th>
                            <th>میاشت</th>
                            <th>د بیلونو شمېر</th>
                            <th>مجموعي قیمت</th>
                            <th>اوسط قیمت</th>
                        </tr>
                    `;
                } else if (reportType === 'payment') {
                    html = `
                        <tr>
                            <th>شمېره</th>
                            <th>د تادیې طریقه</th>
                            <th>د بیلونو شمېر</th>
                            <th>مجموعي قیمت</th>
                        </tr>
                    `;
                } else if (reportType === 'status') {
                    html = `
                        <tr>
                            <th>شمېره</th>
                            <th>حالت</th>
                            <th>د بیلونو شمېر</th>
                            <th>مجموعي قیمت</th>
                        </tr>
                    `;
                } else if (reportType === 'images') {
                    html = `
                        <tr>
                            <th>شمېره</th>
                            <th>بیل نمبر</th>
                            <th>د دوکان نوم</th>
                            <th>بیل نیټه</th> 
                            <th>عکس</th>
                            <th>ډاونلوډ / چاپ</th>
                            
                        </tr>
                    `;
                }

                $('#reportTableHead').html(html);
            }

            // ============================================
            // د جدول مینځپانګه
            // ============================================
            function renderTableBody(data, reportType) {
                var html = '';
                var filterItem = $('#filter_item_name').val();

                if (!data || data.length === 0) {
                    var colCount = $('#reportTableHead th').length;
                    html = '<tr><td colspan="' + colCount +
                        '" class="text-center">هیڅ معلومات ونه موندل شو</td></tr>';
                    $('#reportTableBody').html(html);
                    return;
                }

                if (reportType === 'summary') {
                    data.forEach(function(bill, index) {
                        var billDate = bill.bill_date_jalali || bill.bill_date || '';
                        if (billDate.indexOf(' ') !== -1) {
                            billDate = billDate.split(' ')[0];
                        }

                        var paymentMethod = '';
                        if (bill.payment_method === 'cash') {
                            paymentMethod = '<span class="badge bg-success">نقد</span>';
                        } else if (bill.payment_method === 'credit') {
                            paymentMethod = '<span class="badge bg-warning text-dark">پور</span>';
                        } else if (bill.payment_method === 'card') {
                            paymentMethod = '<span class="badge bg-info">کارت</span>';
                        }

                        var status = bill.status === 'active' ?
                            '<span class="badge bg-success">فعال</span>' :
                            '<span class="badge bg-danger">لغو شوی</span>';

                        var itemsCount = bill.items ? bill.items.length : 0;
                        var totalAmount = bill.filtered_total || bill.total_amount;

                        html += '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td><strong>' + (bill.bill_number || '') + '</strong></td>' +
                            '<td>' + (bill.shop_name || '') + '</td>' +
                            '<td>' + itemsCount + '</td>' +
                            '<td><strong>' + Number(totalAmount) + '</strong></td>' +
                            '<td>' + billDate + '</td>' +
                            '<td>' + paymentMethod + '</td>' +
                            '<td>' + status + '</td>' +
                            '</tr>';
                    });
                } else if (reportType === 'items') {
                    data.forEach(function(item, index) {
                        html += '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td><strong>' + (item.item_name || '') + '</strong></td>' +
                            '<td>' + Number(item.total_quantity) + '</td>' +
                            '<td>' + (item.category || 'نشته') + '</td>' +
                            '<td>' + (item.bill_count || 0) + '</td>' +
                            '<td>' + Number(item.avg_price) + '</td>' +
                            '<td><strong>' + Number(item.total_amount) + '</strong></td>' +
                            '</tr>';
                    });
                } else if (reportType === 'shops') {
                    data.forEach(function(shop, index) {
                        html += '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td><strong>' + (shop.shop_name || '') + '</strong></td>' +
                            '<td>' + (shop.shop_phone || 'نشته') + '</td>' +
                            '<td>' + (shop.shop_address || 'نشته') + '</td>' +
                            '<td>' + (shop.total_bills || 0) + '</td>' +
                            '<td><strong>' + Number(shop.total_amount) + '</strong></td>' +
                            '<td>' + Number(shop.avg_amount) + '</td>' +
                            '</tr>';
                    });
                } else if (reportType === 'monthly') {
                    data.forEach(function(month, index) {
                        html += '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td><strong>' + (month.month_name || '') + '</strong></td>' +
                            '<td>' + (month.total_bills || 0) + '</td>' +
                            '<td><strong>' + Number(month.total_amount) + '</strong></td>' +
                            '<td>' + Number(month.avg_amount) + '</td>' +
                            '</tr>';
                    });
                } else if (reportType === 'payment') {
                    data.forEach(function(payment, index) {
                        html += '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td><strong>' + (payment.payment_method_name || '') + '</strong></td>' +
                            '<td>' + (payment.total_bills || 0) + '</td>' +
                            '<td><strong>' + Number(payment.total_amount) + '</strong></td>' +
                            '</tr>';
                    });
                } else if (reportType === 'status') {
                    data.forEach(function(status, index) {
                        var badgeClass = status.status === 'active' ? 'bg-success' : 'bg-danger';
                        html += '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td><span class="badge ' + badgeClass + '">' + (status.status_name || '') +
                            '</span></td>' +
                            '<td>' + (status.total_bills || 0) + '</td>' +
                            '<td><strong>' + Number(status.total_amount) + '</strong></td>' +
                            '</tr>';
                    });

                } else if (reportType === 'images') {
                    data.forEach(function(image, index) {

                        // ==========================================
                        // ⭐ دلته مو د بیل شمسی نیټه (هجري) تنظیم کړه
                        // ==========================================
                        var billDate = 'نشته';
                        if (image.bill) {
                            if (image.bill.bill_date_jalali) {
                               
                                billDate = image.bill.bill_date_jalali;
                            } else if (image.bill.bill_date) {
                                
                                billDate = image.bill.bill_date.split(' ')[0];
                            }
                        }

                        var imageUrl = '/storage/' + image.image_path;

                        html += '<tr>' +
                            '<td>' + (index + 1) + '</td>' +

                            '<td><strong>' +
                            (image.bill ? image.bill.bill_number : 'نشته') +
                            '</strong></td>' +

                            '<td>' +
                            (image.bill ? image.bill.shop_name : 'نشته') +
                            '</td>' +

                            // ⬅️ اوس به شمسی نیټه (مثلاً 1405/07/19) ښکاره کړي
                            '<td><strong>' + billDate + '</strong></td>' +

                            // د بیل د عکس مخکتنه
                            '<td>' +
                            '<a href="' + imageUrl + '" target="_blank" title="د عکس لیدل">' +
                            '<img src="' + imageUrl + '" ' +
                            'style="width:70px;height:70px;object-fit:cover;' +
                            'border-radius:5px;border:1px solid #ccc;">' +
                            '</a>' +
                            '</td>' +

                            // د ډاونلوډ او چاپ بټنونه
                            '<td class="text-nowrap">' +
                            '<a href="' + imageUrl + '" download ' +2
                            '<i class="bi bi-download"></i> ډاونلوډ' +
                            '</a> ' +

                            '<button type="button" ' +
                            'class="btn btn-primary btn-sm" ' +
                            'onclick="window.open(\'' + imageUrl + '\', \'_blank\')" ' +
                            'title="د چاپ مخکتنه">' +
                            '<i class="bi bi-printer"></i> چاپ' +
                            '</button>' +
                            '</td>' +

                            '</tr>';
                    });
                }


                $('#reportTableBody').html(html);
            }

            // ============================================
            // د جدول فوټر
            // ============================================
            function renderTableFoot(summary, reportType) {
                var html = '';

                if (reportType === 'summary') {
                    html = '<tr>' +
                        '<td colspan="4" class="text-end"><strong>مجموعاً:</strong></td>' +
                        '<td><strong>' + Number(summary.total_amount || 0) + '</strong></td>' +
                        '<td colspan="3"></td>' +
                        '</tr>';
                } else if (reportType === 'items') {
                    html = '<tr>' +
                        '<td colspan="3" class="text-end"><strong>مجموعاً:</strong></td>' +
                        '<td><strong>' + Number(summary.total_quantity || 0) + '</strong></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td><strong>' + Number(summary.total_amount || 0) + '</strong></td>' +
                        '</tr>';
                } else if (reportType === 'shops') {
                    html = '<tr>' +
                        '<td colspan="4" class="text-end"><strong>مجموعاً:</strong></td>' +
                        '<td><strong>' + (summary.total_bills || 0) + '</strong></td>' +
                        '<td><strong>' + Number(summary.total_amount || 0) + '</strong></td>' +
                        '<td></td>' +
                        '</tr>';
                } else if (reportType === 'images') {
                    html = '<tr>' +
                        '<td colspan="5" class="text-end"><strong>ټول عکسونه:</strong></td>' +
                        '<td><strong>' + (summary.total_images || 0) + '</strong></td>' +
                        '<td></td>' +
                        '</tr>';
                } else {
                    html = '<tr>' +
                        '<td colspan="2" class="text-end"><strong>مجموعاً:</strong></td>' +
                        '<td><strong>' + (summary.total_bills || 0) + '</strong></td>' +
                        '<td><strong>' + Number(summary.total_amount || 0) + '</strong></td>' +
                        '</tr>';
                }

                $('#reportTableFoot').html(html);
            }

            // ============================================
            // د شمېرو فورمټ کول
            // ============================================
            function formatNumber(num) {
                if (!num) return '0.00';
                return parseFloat(num).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }


            // ============================================
            // د راپور چاه
            // ============================================
            window.printReport = function() {
                if (!$('#reportContent').is(':visible')) {
                    if (typeof toastr !== 'undefined') {
                        toastr.warning('لومړی راپور جوړ کړئ');
                    } else {
                        alert('لومړی راپور جوړ کړئ');
                    }
                    return;
                }

                var formData = {
                    bill_number: $('#filter_bill_number').val(),
                    shop_name: $('#filter_shop_name').val(),
                    item_name: $('#filter_item_name').val(),
                    start_date: $('#filter_start_date').val(),
                    end_date: $('#filter_end_date').val(),
                    year: $('#filter_year').val(),
                    month: $('#filter_month').val(),
                    payment_method: $('#filter_payment_method').val(),
                    status: $('#filter_status').val(),
                    report_type: $('#filter_report_type').val(),
                };

                var queryString = $.param(formData);

                //  د چاپ پاڼه خلاصول
                window.open('{{ route('bills.reports.print') }}?' + queryString, '_blank');
            };
            // ============================================
            // پیل کې راپور جوړول
            // ============================================
            generateReport();

        }); // end document ready
    </script>
@endsection
