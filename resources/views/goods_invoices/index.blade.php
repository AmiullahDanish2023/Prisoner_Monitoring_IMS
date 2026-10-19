@extends('layouts.master')

@section('content')
    <link rel="stylesheet" href="{{ asset('perisanDatePicker/css/persianDatepicker-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons/bootstrap-icons.css') }}" />

    <style>
        /* ============================================
                                                   د عمل بټنونو سټایلونه
                                                   ============================================ */
        .action-buttons {
            display: flex;
            gap: 6px;
            justify-content: center;
        }

        .action-buttons a {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            gap: 6px;
            cursor: pointer;
            border-radius: 4px;
            padding: 6px 8px;
            transition: all 0.25s ease-in-out;
            text-decoration: none;
            border: none;
        }

        .action-buttons a:hover {
            transform: scale(1.08);
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.15);
        }

        .action-buttons a i {
            color: #fff !important;
            font-size: 16px;
        }

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

        .status-btn {
            background-color: #ffc107 !important;
            color: #fff !important;
        }

        .status-btn.active-status {
            background-color: #28a745 !important;
            color: #fff !important;
        }

        /* ============================================
                                                   د فلټر پینل
                                                   ============================================ */
        .filter-toggle-btn {
            background: #3f577c;
            color: #fff;
            border: none;
            padding: 6px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .filter-toggle-btn:hover {
            background: #2e4468;
            color: #fff;
        }

        .filter-toggle-btn i {
            margin-left: 5px;
        }

        /* ============================================
                                                   د جدول سټایلونه
                                                   ============================================ */
        .table th {
            background: #3f577c;
            color: #fff;
            font-weight: 600;
            text-align: center;
            vertical-align: middle;
        }

        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .card-header {
            background: #f8f9fa;
        }

        #bills_table {
            border: 1px solid #dee2e6;
        }

        #bills_table th,
        #bills_table td {
            border: 1px solid #dee2e6 !important;
        }

        #bills_table thead th {
            background: #3f577c;
            color: #fff;
            font-weight: 600;
            text-align: center;
            vertical-align: middle;
        }

        #bills_table tbody tr:hover {
            background-color: #e3f2fd;
            transition: background-color 0.3s ease;
        }

        #bills_table td {
            padding: 10px;
            vertical-align: middle;
            text-align: center;
        }

        /* ============================================
                                                   د Validation تېروتنې
                                                   ============================================ */
        label.error {
            color: #dc3545;
            font-size: 12px;
            margin-top: 4px;
            display: block;
            font-weight: normal;
        }

        input.error,
        select.error,
        textarea.error {
            border-color: #dc3545 !important;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }
    </style>

    <style>
        /* ============================================
                                                   د View Bill Modal سټایلونه
                                                   ============================================ */
        .view-bill-container {
            padding: 10px 0;
        }

        .view-bill-container .bill-header {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 10px;
            padding: 20px 25px;
            margin-bottom: 20px;
            border-left: 5px solid #3f577c;
        }

        .view-bill-container .bill-header .bill-number {
            font-size: 20px;
            font-weight: 700;
            color: #2c3e7a;
        }

        .view-bill-container .items-table {
            border: 2px solid #2c3e7a !important;
            border-radius: 8px;
            overflow: hidden;
        }

        .view-bill-container .items-table thead th {
            background: #3f577c !important;
            color: #fff !important;
            font-weight: 600;
            text-align: center;
            padding: 12px 8px;
            border: 1px solid #2c3e7a !important;
        }

        .view-bill-container .items-table tbody td {
            text-align: center;
            padding: 10px 8px;
            border: 1px solid #dee2e6 !important;
            vertical-align: middle;
        }

        .view-bill-container .items-table tfoot td {
            background: #f1f3f5;
            font-weight: 700;
            border: 1px solid #dee2e6 !important;
            padding: 12px 8px;
        }

        .view-bill-container .status-badge {
            font-size: 14px;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
        }

        .view-bill-container .status-badge.active {
            background: #28a745;
            color: #fff;
        }

        .view-bill-container .status-badge.cancelled {
            background: #dc3545;
            color: #fff;
        }

        .view-bill-container .total-amount {
            font-size: 22px;
            font-weight: 700;
            color: #28a745;
        }

        .view-bill-container .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #2c3e7a;
            border-bottom: 3px solid #3f577c;
            padding-bottom: 8px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .view-bill-container .section-title i {
            font-size: 22px;
            color: #3f577c;
        }

        .view-bill-container .info-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            border: 1px solid #e9ecef;
            height: 100%;
        }

        .view-bill-container .info-card .label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .view-bill-container .info-card .value {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e7a;
            margin-top: 4px;
        }

        .view-bill-container .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }

        .view-bill-container .image-gallery .image-item {
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #dee2e6;
            transition: all 0.3s ease;
            position: relative;
        }

        .view-bill-container .image-gallery .image-item:hover {
            border-color: #3f577c;
            transform: scale(1.03);
            box-shadow: 0 4px 15px rgba(63, 87, 124, 0.3);
        }

        .view-bill-container .image-gallery .image-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .view-bill-container .image-gallery .image-item .image-label {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            font-size: 11px;
            padding: 4px 8px;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>

    <style>
        /* ============================================
                                                   د چاپ سټایلونه
                                                   ============================================ */
        @media print {
            @page {
                size: A4;
                margin: 12mm;
            }

            html,
            body {
                background: #fff !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }

            body * {
                visibility: hidden !important;
            }

            #view_bill_content,
            #view_bill_content * {
                visibility: visible !important;
            }

            #view_bill_content {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #fff !important;
            }

            #viewBillModal {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #fff !important;
            }

            #viewBillModal .modal-dialog,
            #viewBillModal .modal-content,
            #viewBillModal .modal-body {
                position: static !important;
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
                border: 0 !important;
                box-shadow: none !important;
                background: #fff !important;
            }

            #viewBillModal .modal-header {
                display: none !important;
            }

            #view_bill_content .modal-footer {
                display: none !important;
            }

            #view_bill_content .view-bill-container {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #fff !important;
                box-shadow: none !important;
            }

            #view_bill_content table {
                width: 100% !important;
                border-collapse: collapse !important;
            }

            #view_bill_content th,
            #view_bill_content td {
                border: 1px solid #333 !important;
                padding: 6px !important;
            }

            #view_bill_content thead {
                display: table-header-group !important;
            }

            #view_bill_content tr {
                page-break-inside: avoid !important;
            }

            #view_bill_content img {
                max-width: 100% !important;
                page-break-inside: avoid !important;
            }

            #view_bill_content .table-responsive {
                overflow: visible !important;
                width: 100% !important;
            }

            #view_bill_content a {
                color: inherit !important;
                text-decoration: none !important;
            }

            #view_bill_content .row {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
        }
    </style>

    <div class="card shadow-sm">
        {{-- ============================================
             د کارت هدر
             ============================================ --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">
                <i class="bi bi-receipt"></i> د بیلونو لیست
            </h4>
            <div>
                <button class="filter-toggle-btn" id="searchToggle">
                    <i class="fas fa-filter"></i> فلتر
                </button>
                @can('Create Goods Invoice')
                    <button class="btn btn-primary btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#billModal">
                        <i class="fas fa-plus"></i> نوی بیل ثبت کړئ
                    </button>
                @endcan
            </div>
        </div>

        {{-- ============================================
             د فلټر پینل
             ============================================ --}}
        <form id="filterForm" autocomplete="off"
            class="row g-3 p-3 collapse {{ request()->hasAny(['start_date', 'end_date', 'shop_name', 'year', 'month']) ? 'show' : '' }}"
            style="background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
            <div class="col-md-2">
                <label class="form-label">له نېټې</label>
                <input type="text" name="start_date" id="filter_start_date"
                    class="form-control form-control-sm farsi-date" placeholder="له نېټې"
                    value="{{ request('start_date') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">تر نېټې</label>
                <input type="text" name="end_date" id="filter_end_date" class="form-control form-control-sm farsi-date"
                    placeholder="تر نېټې" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">د دوکان نوم</label>
                <input type="text" name="shop_name" id="filter_shop_name" class="form-control form-control-sm"
                    placeholder="د دوکان نوم" value="{{ request('shop_name') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">کال</label>
                <select name="year" id="filter_year" class="form-select form-select-sm">
                    <option value="">ټول</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">میاشت</label>
                <select name="month" id="filter_month" class="form-select form-select-sm">
                    <option value="">ټول</option>
                    @foreach ($jalaliMonths as $key => $month)
                        <option value="{{ $key }}" {{ request('month') == $key ? 'selected' : '' }}>
                            {{ $month }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 mt-2">
                <button type="button" class="btn btn-primary btn-sm" id="btnFilter">
                    <i class="fas fa-search"></i> فلتر
                </button>
                <button type="button" class="btn btn-secondary btn-sm" id="btnReset">
                    <i class="fas fa-undo-alt"></i> پاکول
                </button>
            </div>
        </form>

        {{-- ============================================
             د جدول
             ============================================ --}}
             
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped" id="bills_table" style="width:100%">
                    <thead>
                        <tr>
                            <th>شمیره</th>
                            <th>بیل نمبر</th>
                            <th>د دوکان نوم</th>
                            <th>د اجناسو شمېر</th>
                            <th>مجموعي قیمت</th>
                            <th>بیل نیټه</th>
                            <th>د تادیې طریقه</th>
                            <th>حالت</th>
                            <th>عمل</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- دا به د DataTables له لارې ډک شي --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ============================================
         Create/Edit Bill Modal
         ============================================ --}}
    <div class="modal fade" id="billModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header justify-content-center" style="background-color:#3f577c;">
                    <h5 class="modal-title text-center w-100 text-white" id="billModalTitle">
                        نوی بیل ثبت کړئ
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form id="bill_form" method="POST" enctype="multipart/form-data" autocomplete="off" novalidate>
                    @csrf
                    <input type="hidden" name="bill_id" id="bill_id">
                    <input type="hidden" name="_method" id="form_method" value="POST">

                    <div class="modal-body">
                        <div class="row g-3">

                            {{-- ============================================
                                 د بیل معلومات
                                 ============================================ --}}
                            <div class="col-md-4">
                                <label class="form-label">بیل نمبر <span class="text-danger">*</span></label>
                                <input type="text" name="bill_number" id="bill_number"
                                    class="form-control form-control-sm" placeholder="بیل نمبر">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">بیل نیټه <span class="text-danger">*</span></label>
                                <input type="text" name="bill_date" id="bill_date"
                                    class="form-control form-control-sm farsi-date" placeholder="بیل نیټه">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">د دوکان نوم <span class="text-danger">*</span></label>
                                <input type="text" name="shop_name" id="shop_name"
                                    class="form-control form-control-sm" placeholder="د دوکان نوم">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">د دوکان پته</label>
                                <input type="text" name="shop_address" id="shop_address"
                                    class="form-control form-control-sm" placeholder="د دوکان پته">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">د دوکان تلیفون</label>
                                <input type="text" name="shop_phone" id="shop_phone"
                                    class="form-control form-control-sm" placeholder="د دوکان تلیفون">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">د تادیې طریقه <span class="text-danger">*</span></label>
                                <select name="payment_method" id="payment_method" class="form-select form-select-sm">
                                    <option value="cash">نقد</option>
                                    <option value="credit">پور</option>
                                    <option value="card">کارت</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">خریداري مسوًول</label>
                                <input type="text" name="responsible_person" id="responsible_person"
                                    class="form-control form-control-sm" placeholder="خریداري مسوًول">
                            </div>

                            {{-- یادداشت --}}
                            <div class="col-12">
                                <label class="form-label">یادداشت</label>
                                <textarea name="note" id="note" class="form-control form-control-sm" rows="2"></textarea>
                            </div>

                            {{-- ============================================
                                 اجناسو برخه
                                 ============================================ --}}
                            <div class="col-12">
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="bi bi-box-seam"></i> د اجناسو لیست
                                        <span class="badge bg-primary" id="items_count_badge">0</span>
                                    </h6>
                                    <button type="button" class="btn btn-success btn-sm" id="addItemBtn">
                                        <i class="bi bi-plus"></i> جنس اضافه کړئ
                                    </button>
                                </div>
                                <div class="table-responsive mt-2">
                                    <table class="table table-bordered table-hover align-middle" id="items_table">
                                        <thead style="background-color:#e9ecef;">
                                            <tr>
                                                <th style="width:22%">د جنس نوم <span class="text-danger">*</span>
                                                </th>
                                                <th style="width:13%">تعداد <span class="text-danger">*</span></th>
                                                <th style="width:13%">واحد</th>
                                                <th style="width:15%">واحد قیمت <span class="text-danger">*</span>
                                                </th>
                                                <th style="width:15%">مجموعي قیمت</th>
                                                <th style="width:17%">تفصیل</th>
                                                <th style="width:5%">عمل</th>
                                            </tr>
                                        </thead>
                                        <tbody id="items_body">
                                            {{-- د اجناسو قطارونه به دلته اضافه شي --}}
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-end">
                                                    <strong>مجموعي قیمت:</strong>
                                                </td>
                                                <td colspan="2">
                                                    <strong id="grand_total">0.00</strong>
                                                </td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                {{-- د اجناسو validation error --}}
                                <label id="items-error" class="error" style="display:none;"></label>
                            </div>

                            {{-- ============================================
                                 عکسونه
                                 ============================================ --}}
                            <div class="col-12">
                                <label class="form-label">د بیل عکسونه</label>
                                <input type="file" name="images[]" id="images"
                                    class="form-control form-control-sm" multiple accept=".jpg,.jpeg,.png,.gif,.webp">
                                <small class="text-muted">
                                    تاسو کولی شئ څو عکسونه انتخاب کړئ (تر 5MB پورې)
                                </small>
                                <div id="existing_images" class="mt-2"></div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary btn-sm" id="submit_btn">
                            <i class="bi bi-save"></i> ثبت کول
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                            <i class="bi bi-x"></i> تړل
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ============================================
         View Bill Modal
         ============================================ --}}
    <div class="modal fade" id="viewBillModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #2c3e7a, #3f577c);">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-receipt me-2"></i> د بیل تفصیلات
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="view_bill_content">
                    {{-- به د AJAX له لارې ډک شي --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- ============================================
         5. Persian DatePicker
         ============================================ --}}
    <script src="{{ asset('perisanDatePicker/js/persianDatepicker.min.js') }}"></script>
    <script src="{{ asset('perisanDatePicker/js/persianDatepicker.js') }}"></script>

    <script>
        $(document).ready(function() {

            // ============================================
            // 1. DataTables
            // ============================================
            var table = $('#bills_table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ordering: false,
                responsive: true,
                language: {
                    "emptyTable": "{{ __('translate.information not exists') }}",
                    "lengthMenu": "{{ __('translate.showing') }} _MENU_ {{ __('translate.information') }}",
                    "info": "{{ __('translate.from') }} _START_ {{ __('translate.to') }} _END_  {{ __('translate.total information') }} _TOTAL_",
                    "infoEmpty": "{{ __('translate.form 0 to 0 - total 0 records') }}",
                    "search": "{{ __('translate.search') }}:",
                    "sProcessing": "{{ __('translate.under processing') }}",
                    "paginate": {
                        "first": "{{ __('first') }}",
                        "last": "{{ __('last') }}",
                        "next": "{{ __('translate.next') }}",
                        "previous": "{{ __('translate.previous') }}"
                    }
                },
                ajax: {
                    url: "{{ route('bills.list') }}",
                    data: function(d) {
                        d.start_date = $('#filter_start_date').val();
                        d.end_date = $('#filter_end_date').val();
                        d.shop_name = $('#filter_shop_name').val();
                        d.year = $('#filter_year').val();
                        d.month = $('#filter_month').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false,
                        width: '5%'
                    },
                    {
                        data: 'bill_number',
                        name: 'bill_number',
                        width: '12%'
                    },
                    {
                        data: 'shop_name',
                        name: 'shop_name',
                        width: '15%'
                    },
                    {
                        data: 'items_count',
                        name: 'items_count',
                        searchable: false,
                        orderable: false,
                        width: '8%'
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount',
                        width: '12%'
                    },
                    {
                        data: 'bill_date_jalali',
                        name: 'bill_date_jalali',
                        width: '10%'
                    },
                    {
                        data: 'payment_method_badge',
                        name: 'payment_method_badge',
                        searchable: false,
                        orderable: false,
                        width: '8%'
                    },
                    {
                        data: 'status_badge',
                        name: 'status_badge',
                        searchable: false,
                        orderable: false,
                        width: '8%'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false,
                        className: 'text-center',
                        width: '12%'
                    }
                ]
            });

            // ============================================
            // 2. د فلټر بټنونه
            // ============================================
            $('#btnFilter').on('click', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            $('#btnReset').on('click', function(e) {
                e.preventDefault();
                $('#filterForm')[0].reset();
                $('#filter_start_date, #filter_end_date').val('');
                table.ajax.reload();
            });

            // ============================================
            // 3. د فلټر پینل Show/Hide
            // ============================================
            $('#searchToggle').on('click', function() {
                $('#filterForm').collapse('toggle');
                $(this).find('i').toggleClass('fa-filter fa-filter-circle-xmark');
            });

            // ============================================
            // 4. Persian DatePicker
            // ============================================
            $('.farsi-date').persianDatepicker({
                format: 'YYYY/MM/DD',
                autoClose: true,
                initialValueType: 'gregorian',
                persian: {
                    locale: 'fa'
                }
            });

            // ============================================
            // 5. jQuery Validation
            // ============================================
            var validator = $('#bill_form').validate({
                ignore: [],
                errorClass: 'error',
                errorElement: 'label',

                rules: {
                    // د بیل معلومات
                    bill_number: {
                        required: true,
                        maxlength: 100
                    },
                    bill_date: {
                        required: true
                    },
                    shop_name: {
                        required: true,
                        maxlength: 255
                    },
                    shop_address: {
                        maxlength: 500
                    },
                    shop_phone: {
                        maxlength: 10
                    },
                    payment_method: {
                        required: true
                    },
                    responsible_person: {
                        maxlength: 255
                    },
                    note: {
                        maxlength: 1000
                    },

                    // د اجناسو لپاره - د class په واسطه
                    'item-name-input': {
                        required: true,
                        maxlength: 255
                    },
                    'item-quantity-input': {
                        required: true,
                        parseFloat: true,
                        min: 1
                    },
                    'item-unit-price-input': {
                        required: true,
                        number: true,
                        min: 0
                    },

                    // د فایل لپاره
                    // 'images[]': {
                    //     required: function() {
                    //         return $('#bill_id').val() === '';
                    //     },
                    //     extension: "jpg|jpeg|png|gif|webp"
                    // }
                },

                messages: {
                    bill_number: {
                        required: 'بیل نمبر ضروري ده',
                        maxlength: 'بیل نمبر باید تر 100 عددونو کم وي'
                    },
                    bill_date: {
                        required: 'بیل نیټه ضروري ده'
                    },
                    shop_name: {
                        required: 'د دوکان نوم ضروري ده',
                        maxlength: 'د دوکان نوم باید تر 255 عددونو کم وي'
                    },
                    shop_address: {
                        maxlength: 'د دوکان پته باید تر 500 عددونو کم وي'
                    },
                    shop_phone: {
                        maxlength: 'د دوکان تلیفون شمېره باید  10 عدده  وي'
                    },
                    payment_method: {
                        required: 'د تادیې طریقه ضروري ده'
                    },
                    responsible_person: {
                        maxlength: 'مسوول کس باید تر 255 عددونو کم وي'
                    },
                    note: {
                        maxlength: 'یادداشت باید تر 1000 عددونو کم وي'
                    },
                    'item-name-input': {
                        required: 'د جنس نوم ضروري ده',
                        maxlength: 'د جنس نوم باید تر 255 عددونو کم وي'
                    },
                    'item-quantity-input': {
                        required: 'تعداد ضروري ده',
                        number: 'تعداد باید یو شمېره وي',
                        min: 'تعداد باید لږ تر لږه 1 وي'
                    },
                    'item-unit-price-input': {
                        required: 'واحد قیمت ضروري ده',
                        number: 'واحد قیمت باید یو شمېره وي',
                        min: 'واحد قیمت باید 0 یا تر هغه ډېر وي'
                    },
                    // 'images[]': {
                    //     required: 'لږ تر لږه یو عکس انتخاب کړئ',

                    // }
                },

                errorPlacement: function(error, element) {
                    element.addClass('is-invalid');

                    if (element.hasClass('select2-hidden-accessible')) {
                        error.insertAfter(element.next('.select2-container'));
                    } else {
                        error.insertAfter(element);
                    }
                },

                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },

                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },

                submitHandler: function(form) {
                    submitBillForm(form);
                    return false;
                }
            });

            // ============================================
            // 6. د تېروتنې پاکول کله چې input بدل شي
            // ============================================
            $(document).on('input change', '.is-invalid', function() {
                $(this).removeClass('is-invalid');
                $(this).next('label.error').remove();
            });

            // ============================================
            // 7. د دینامیک اجناسو validation
            // ============================================
            $(document).on('input change', '.item-name-input, .item-quantity-input, .item-unit-price-input',
                function() {
                    $(this).valid();
                    updateItemsCount();
                });

            // ============================================
            // 8. د اجناسو شمېر تازه کول
            // ============================================
            function updateItemsCount() {
                var count = $('#items_body tr').length;
                $('#items_count_badge').text(count);
            }

            // ============================================
            // 9. د addItemRow فنکشن
            // ============================================
            $('#addItemBtn').on('click', function() {
                addItemRow();
            });

            window.addItemRow = function(itemData = null) {
                var rowIndex = $('#items_body tr').length;

                var html = `
                    <tr>
                        <td>
                            <input type="text" 
                                name="items[${rowIndex}][item_name]"
                                class="form-control form-control-sm item-name item-name-input" 
                                placeholder="د جنس نوم"
                                value="${itemData ? itemData.item_name : ''}">
                        </td>
                        <td>
                            <input type="number" 
                                name="items[${rowIndex}][quantity]"
                                class="form-control form-control-sm item-quantity item-quantity-input" 
                                placeholder="تعداد"
                                value="${itemData ? itemData.quantity : 1}" 
                                min="1"
                                onchange="calculateRowTotal(this)">
                        </td>
                        <td>
                            <input type="text" 
                                name="items[${rowIndex}][category]"
                                class="form-control form-control-sm item-category" 
                                placeholder="واحد"
                                value="${itemData ? itemData.category : ''}">
                        </td>
                        <td>
                            <input type="number" 
                                name="items[${rowIndex}][unit_price]"
                                class="form-control form-control-sm item-unit-price item-unit-price-input" 
                                placeholder="واحد قیمت"
                                value="${itemData ? itemData.unit_price : ''}" 
                                min="0"
                                onchange="calculateRowTotal(this)">
                        </td>
                        <td>
                            <input type="text" 
                                class="form-control form-control-sm item-total"
                                value="${itemData ? itemData.total_price : '0'}" 
                                readonly>
                        </td>
                        <td>
                            <input type="text" 
                                name="items[${rowIndex}][description]"
                                class="form-control form-control-sm item-description" 
                                placeholder="تفصیل"
                                value="${itemData ? itemData.description : ''}">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" 
                                onclick="removeItemRow(this)">
                                <i class="bi bi-x"></i>
                            </button>
                        </td>
                    </tr>
                `;

                $('#items_body').append(html);
                calculateGrandTotal();
                updateItemsCount();
            };

            // ============================================
            // 10. د calculateRowTotal فنکشن
            // ============================================
            window.calculateRowTotal = function(element) {
                var row = $(element).closest('tr');
                var quantity = parseFloat(row.find('.item-quantity').val()) || 0;
                var unitPrice = parseFloat(row.find('.item-unit-price').val()) || 0;
                var total = quantity * unitPrice;
                row.find('.item-total').val(total.toFixed());
                calculateGrandTotal();
            };

            // ============================================
            // 11. د calculateGrandTotal فنکشن
            // ============================================
            window.calculateGrandTotal = function() {
                var total = 0;
                $('.item-total').each(function() {
                    total += parseFloat($(this).val()) || 0;
                });
                $('#grand_total').text(total.toFixed());
            };

            // ============================================
            // 12. د removeItemRow فنکشن
            // ============================================
            window.removeItemRow = function(button) {
                $(button).closest('tr').remove();

                // د قطارونو نومونه بیا تنظیم کول
                $('#items_body tr').each(function(index) {
                    $(this).find('input').each(function() {
                        var name = $(this).attr('name');
                        if (name) {
                            var newName = name.replace(/items\[\d+\]/, 'items[' + index + ']');
                            $(this).attr('name', newName);
                        }
                    });
                });

                calculateGrandTotal();
                updateItemsCount();

                // که ټول قطارونه لرې شول، یو نوی اضافه کړه
                if ($('#items_body tr').length === 0) {
                    addItemRow();
                }
            };

            // ============================================
            // 13. د submitBillForm فنکشن
            // ============================================
            function submitBillForm(form) {
                var formData = new FormData(form);
                var billId = $('#bill_id').val();
                var url = billId ? '/bills/update/' + billId : '/bills/store';

                if (billId) {
                    formData.append('_method', 'PUT');
                }

                $('#submit_btn').prop('disabled', true).html(
                    '<i class="bi bi-spinner"></i> ثبت کیږي...'
                );

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#submit_btn').prop('disabled', false).html(
                            '<i class="bi bi-save"></i> ثبت کول'
                        );

                        if (response.success === true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'بیل په بریالیتوب سره ثبت شو',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            $('#billModal').modal('hide');

                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function(xhr) {
                        $('#submit_btn').prop('disabled', false).html(
                            '<i class="bi bi-save"></i> ثبت کول'
                        );

                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error('تېروتنه رامنځته شوه: ' + (
                                xhr.responseJSON?.message || 'نامعلومه تېروتنه'
                            ));
                        }
                    }
                });
            }

            // ============================================
            // 14. د Modal Reset کول
            // ============================================
            $('#billModal').on('hidden.bs.modal', function() {
                $('#bill_form')[0].reset();
                $('#bill_id').val('');
                $('#form_method').val('POST');
                $('#items_body').empty();
                $('#grand_total').text('0.00');
                $('#billModalTitle').text('نوی بیل ثبت کړئ');
                $('#submit_btn').html('<i class="bi bi-save"></i> ثبت کول').prop('disabled', false);
                $('#existing_images').empty();
                $('#images').val('');
                $('#bill_number').val('');

                // د Validation تېروتنې پاکول
                if (typeof validator !== 'undefined') {
                    validator.resetForm();
                }
                $('#bill_form').find('.is-invalid').removeClass('is-invalid');
                $('#bill_form').find('label.error').remove();

                // یو نوی قطار اضافه کول
                addItemRow();
                calculateGrandTotal();
                updateItemsCount();
            });

            // ============================================
            // 15. د View Bill فنکشن
            // ============================================
            window.viewBill = function(id) {
                $.ajax({
                    url: '/bills/show/' + id,
                    type: 'GET',
                    success: function(data) {
                        if (data.bill_date_jalali && data.bill_date_jalali.includes(' ')) {
                            data.bill_date_jalali = data.bill_date_jalali.split(' ')[0];
                        }
                        if (data.bill_date && data.bill_date.includes(' ') && !data
                            .bill_date_jalali) {
                            data.bill_date = data.bill_date.split(' ')[0];
                        }

                        var html = generateBillViewHtml(data);
                        $('#view_bill_content').html(html);
                        $('#viewBillModal').modal('show');
                    },
                    error: function() {
                        toastr.error('د بیل معلوماتو بارولو کې تېروتنه');
                    }
                });
            };

            // ============================================
            // 16. د Edit Bill فنکشن
            // ============================================
            window.editBill = function(id) {
                $.ajax({
                    url: '/bills/edit/' + id,
                    type: 'GET',
                    success: function(data) {
                        // د Validation تېروتنې پاکول
                        if (typeof validator !== 'undefined') {
                            validator.resetForm();
                        }
                        $('#bill_form').find('.is-invalid').removeClass('is-invalid');
                        $('#bill_form').find('label.error').remove();

                        $('#billModalTitle').text('بیل سمول');
                        $('#submit_btn').html('<i class="bi bi-save"></i> تازه کول');
                        $('#bill_id').val(data.id);
                        $('#form_method').val('PUT');

                        // د فارم ډاټا ډکول
                        $('#bill_number').val(data.bill_number);
                        $('#shop_name').val(data.shop_name);
                        $('#shop_address').val(data.shop_address);
                        $('#shop_phone').val(data.shop_phone);

                        var billDate = data.bill_date_jalali || data.bill_date;
                        if (billDate && billDate.includes(' ')) {
                            billDate = billDate.split(' ')[0];
                        }
                        $('#bill_date').val(billDate);

                        $('#payment_method').val(data.payment_method);
                        $('#responsible_person').val(data.responsible_person);
                        $('#note').val(data.note);

                        // اجناس ډکول
                        $('#items_body').empty();
                        if (data.items && data.items.length > 0) {
                            data.items.forEach(function(item) {
                                addItemRow(item);
                            });
                        } else {
                            addItemRow();
                        }
                        calculateGrandTotal();
                        updateItemsCount();

                        // عکسونه ښودل
                        $('#existing_images').empty();
                        if (data.images && data.images.length > 0) {
                            var imagesHtml = '<div class="row">';
                            data.images.forEach(function(image) {
                                imagesHtml += `
                                    <div class="col-md-3 mb-2">
                                        <div class="card">
                                            <img src="/storage/${image.image_path}" class="card-img-top" 
                                                alt="${image.image_name}"
                                                style="height:100px;object-fit:cover;">
                                            <div class="card-body p-1 text-center">
                                                <small>${image.image_name}</small>
                                                <button type="button" class="btn btn-danger btn-sm" 
                                                    onclick="deleteImage(${image.id})">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
                            imagesHtml += '</div>';
                            $('#existing_images').html(imagesHtml);
                        }

                        $('#billModal').modal('show');
                    },
                    error: function() {
                        toastr.error('د بیل معلوماتو بارولو کې تېروتنه');
                    }
                });
            };

            // ============================================
            // 17. د Generate Bill View Html فنکشن
            // ============================================
            window.generateBillViewHtml = function(data) {
                var billDate = data.bill_date_jalali || data.bill_date;
                if (billDate && billDate.includes(' ')) {
                    billDate = billDate.split(' ')[0];
                }

                var paymentMethod = {
                    'cash': 'نقد',
                    'credit': 'پور',
                    'card': 'کارت'
                } [data.payment_method] || data.payment_method;

                var statusClass = data.status === 'active' ? 'active' : 'cancelled';
                var statusText = data.status === 'active' ? 'فعال' : 'لغو شوی';

                return `
                    <div class="view-bill-container">
                        {{-- هدر برخه --}}
                        <div class="bill-header">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="bill-number">
                                        بیل نمبر: ${data.bill_number}
                                    </div>
                                    <div class="mt-1">
                                        <i class="bi bi-calendar3 me-1"></i> 
                                        ثبت نیټه: ${new Date(data.created_at).toLocaleDateString('fa-IR')}
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <span class="status-badge ${statusClass}">
                                        <i class="bi ${data.status === 'active' ? 'bi-check-circle' : 'bi-x-circle'} me-1"></i>
                                        ${statusText}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- د دوکان معلومات --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="info-card">
                                    <div class="label">
                                        <i class="bi bi-shop me-1"></i> د دوکان معلومات
                                    </div>
                                    <div class="value">${data.shop_name}</div>
                                    <div class="text-muted small mt-2">
                                        <div><i class="bi bi-geo-alt me-1"></i> ${data.shop_address || 'نشته'}</div>
                                        <div><i class="bi bi-telephone me-1"></i> ${data.shop_phone || 'نشته'}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-card">
                                    <div class="label">
                                        <i class="bi bi-info-circle me-1"></i> د بیل معلومات
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <div class="text-muted small">بیل نیټه</div>
                                            <div class="fw-bold">${billDate}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted small">د تادیې طریقه</div>
                                            <div class="fw-bold">
                                                <span class="badge bg-info">${paymentMethod}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <div class="text-muted small">مسوول کس</div>
                                            <div class="fw-bold">${data.responsible_person || 'نشته'}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted small">ثبت کوونکی</div>
                                            <div class="fw-bold">${data.user ? data.user.name : 'نشته'}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        ${data.note ? `
                                                                    <div class="row mb-4">
                                                                        <div class="col-12">
                                                                            <div class="info-card" style="background: #fff3cd; border-color: #ffc107;">
                                                                                <div class="label">
                                                                                    <i class="bi bi-sticky-fill me-1"></i> یادداشت
                                                                                </div>
                                                                                <div class="value" style="font-weight:400;color:#856404;">
                                                                                    ${data.note}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                ` : ''}

                        {{-- د اجناسو لیست --}}
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="section-title">
                                    <i class="bi bi-box-seam"></i>
                                    د اجناسو لیست
                                    <span class="badge bg-primary rounded-pill ms-2">${data.items.length}</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover items-table">
                                        <thead>
                                            <tr>
                                                <th style="width:5%;">شمېره</th>
                                                <th style="width:25%;">د جنس نوم</th>
                                                <th style="width:15%;">تعداد</th>
                                                <th style="width:15%;">واحد</th>
                                                <th style="width:20%;">واحد قیمت</th>
                                                <th style="width:20%;">مجموعي قیمت</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${data.items.map((item, index) => `
                                              <tr>
                                                 <td>${index + 1}</td>
                                                   <td class="fw-bold">${item.item_name}</td>
                                                 <td>${item.quantity}</td>
                                                    <td>${item.category || 'نشته'}</td>
                                                    <td>${parseFloat(item.unit_price).toFixed()}</td>
                                                     <td class="fw-bold text-primary">
                                                       ${parseFloat(item.total_price).toFixed()}
                                                       </td>
                                                    </tr>
                                             `).join('')}
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-end">
                                                    <strong>مجموعي قیمت:</strong>
                                                </td>
                                                <td class="total-amount">
                                                    ${parseFloat(data.total_amount).toFixed()}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                      

                        {{-- فوټر --}}
                        <div class="modal-footer justify-content-between no-print"
                            style="border-top: 1px solid #e9ecef;">
                            <div>
                                <button type="button" class="btn btn-primary btn-sm" onclick="printBill()">
                                    <i class="bi bi-printer"></i> چاپ
                                </button>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                                <i class="bi bi-x"></i> بندول
                            </button>
                        </div>
                    </div>
                `;
            };

            // ============================================
            // 18. د Delete Bill فنکشن
            // ============================================
            window.deleteBill = function(id) {
                Swal.fire({
                    title: 'آیا تاسو ډاډه یاست؟',
                    text: 'دا ریکارډ بیرته راګرځولو وړ نه دی!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'هو، حذف یې کړه',
                    cancelButtonText: 'نه، لغوه یې کړه'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/bills/destroy/' + id,
                            type: 'GET',
                            success: function(response) {
                                if (response.success === true) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'حذف شو!',
                                        text: response.message,
                                        confirmButtonText: 'سمه ده',
                                        confirmButtonColor: '#3085d6'
                                    }).then(() => {
                                        table.ajax.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'تېروتنه!',
                                        text: response.message || 'بیل حذف نه شو',
                                        confirmButtonText: 'سمه ده'
                                    });
                                }
                            },
                            error: function() {
                                toastr.error('تېروتنه رامنځته شوه');
                            }
                        });
                    }
                });
            };

            // ============================================
            // 19. د حالت بدلولو فنکشن
            // ============================================
            window.changeStatus = function(id, status) {
                var statusIcon = status === 'active' ? 'فعال' : 'لغوه';
                var confirmText = status === 'active' ?
                    'غواړئ دا بیل فعال کړئ؟' :
                    'غواړئ دا بیل لغو کړئ؟';

                Swal.fire({
                    title: 'آیا تاسو ډاډه یاست؟',
                    text: confirmText,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: status === 'active' ? '#28a745' : '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'هو، ' + statusIcon + ' یې کړه',
                    cancelButtonText: 'نه، لغوه یې کړه'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'حالت بدلیږي...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: '/bills/status/' + id + '/' + status,
                            type: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'بریالیتوب!',
                                        text: response.message ||
                                            'د بیل حالت بدل شو',
                                        timer: 1500,
                                        timerProgressBar: true,
                                        showConfirmButton: false
                                    });
                                    setTimeout(function() {
                                        table.ajax.reload();
                                    }, 1500);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'تېروتنه!',
                                        text: response.message ||
                                            'تېروتنه رامنځته شوه',
                                        confirmButtonText: 'هو'
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'تېروتنه!',
                                    text: xhr.responseJSON?.message ||
                                        'تېروتنه رامنځته شوه',
                                    confirmButtonText: 'هو'
                                });
                            }
                        });
                    }
                });
            };

            // ============================================
            // 20. د Image Delete فنکشن - پرته له Modal تړلو
            // ============================================
            window.deleteImage = function(imageId) {
                Swal.fire({
                    title: 'آیا تاسو ډاډه یاست؟',
                    text: 'دا عکس به حذف شي!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'هو، حذف یې کړه',
                    cancelButtonText: 'نه'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/bills/image/destroy/' + imageId,
                            type: 'GET',
                            success: function(response) {
                                if (response.success) {
                                    toastr.success(response.message);

                                    // ==========================================
                                    // یوازې د عکس کارت لرې کول (پرته له ریلوډ)
                                    // ==========================================

                                    $('#existing_images .col-md-3').each(function() {
                                        var $card = $(this);
                                        var $btn = $card.find(
                                            'button[onclick*="deleteImage(' +
                                            imageId + ')"]');

                                        if ($btn.length > 0) {
                                            // د کارت لرې کول
                                            $card.fadeOut(300, function() {
                                                $(this).remove();

                                                // که ټول عکسونه لرې شول
                                                if ($(
                                                        '#existing_images .col-md-3'
                                                    )
                                                    .length === 0) {
                                                    $('#existing_images')
                                                        .html(
                                                            '<p class="text-muted text-center">هیڅ عکس نشته</p>'
                                                        );
                                                }
                                            });

                                            return false; // لوپ ودروه
                                        }
                                    });
                                }
                            },
                            error: function() {
                                toastr.error('تېروتنه رامنځته شوه');
                            }
                        });
                    }
                });
            };

            // ============================================
            // 21. د چاپ فنکشن
            // ============================================
            window.printBill = function() {
                if (!$('#view_bill_content').html().trim()) {
                    toastr.error('د بیل تفصیلات موجود نه دي');
                    return;
                }
                window.print();
            };

            // ============================================
            // 22. د فورم بیا تنظیم کول د Modal خلاصولو دمخه
            // ============================================
            $('button[data-bs-target="#billModal"]').on('click', function() {
                // د نوي بیل لپاره فورم پاکول
                $('#bill_form')[0].reset();
                $('#bill_id').val('');
                $('#form_method').val('POST');
                $('#items_body').empty();
                $('#grand_total').text('0.00');
                $('#billModalTitle').text('نوی بیل ثبت کړئ');
                $('#submit_btn').html('<i class="bi bi-save"></i> ثبت کول').prop('disabled', false);
                $('#existing_images').empty();

                // د Validation تېروتنې پاکول
                if (typeof validator !== 'undefined') {
                    validator.resetForm();
                }
                $('#bill_form').find('.is-invalid').removeClass('is-invalid');
                $('#bill_form').find('label.error').remove();

                // یو نوی قطار اضافه کول
                addItemRow();
                calculateGrandTotal();
                updateItemsCount();
            });

            // ============================================
            // 23. د پیل لپاره یو قطار اضافه کول
            // ============================================
            addItemRow();
            updateItemsCount();

        }); // end document ready
    </script>
@endsection
