<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>د بیلونو راپور</title>



    <style>
        .print-actions {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            width: 98%;
            direction: rtl;
        }

        @font-face {
            font-family: 'BahijNazanin';
            src: url('{{ public_path('assets/fonts/bahij-nazanin.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'BahijNazanin';
            src: url('{{ public_path('assets/fonts/bahij-nazanin-bold.ttf') }}') format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'BahijNazanin', sans-serif;
            direction: rtl;
            margin: 0;
            padding: 15px;
            font-size: 12px;
            color: #000;
            background: #fff;
        }

        /* ==========================================
           د چاپ تڼۍ (یوازې د سکرین لپاره)
           ========================================== */
        .print-actions {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 9999;
            display: flex;
            gap: 10px;
        }

        .print-actions button,
        .print-actions a {
            padding: 10px 20px;
            font-size: 14px;
            font-family: inherit;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }

        .btn-print {
            background: #28a745;
        }

        .btn-print:hover {
            background: #218838;
        }

        .btn-back {
            background: #6c757d;
        }

        .btn-back:hover {
            background: #5a6268;
        }

        /* ==========================================
           د هدر
           ========================================== */
        .header-table {
            width: 100%;
            margin-bottom: 10px;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: middle;
            text-align: center;
        }

        .header-title p {
            margin: 2px 0;
            font-size: 14px;
            font-weight: bold;
            line-height: 1.5;
        }

        /* ==========================================
           د راپور سرلیک
           ========================================== */
        .report-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
            padding: 8px;
            border: 2px solid #000;
            background: #f0f0f0;
        }

        .report-date {
            text-align: center;
            font-size: 13px;
            margin-bottom: 10px;
        }

        /* ==========================================
           د فلټر معلومات
           ========================================== */
        .filter-info {
            text-align: center;
            font-size: 12px;
            margin-bottom: 10px;
            padding: 8px;
            border: 1px dashed #666;
            background: #fafafa;
        }

        .filter-info span {
            display: inline-block;
            margin: 0 8px;
            padding: 2px 0;
        }

        /* ==========================================
           د ټولیز معلومات
           ========================================== */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .summary-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            background: #f8f8f8;
        }

        .summary-table .label {
            font-size: 12px;
            color: #333;
            margin-bottom: 3px;
        }

        .summary-table .value {
            font-size: 16px;
            font-weight: bold;
        }

        /* ==========================================
           د راپور جدول
           ========================================== */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .report-table thead th {
            background: #3f577c;
            color: #fff;
            font-weight: bold;
            text-align: center;
            padding: 8px 5px;
            border: 2px solid #000;
            font-size: 13px;
            vertical-align: middle;
        }

        .report-table tbody td {
            text-align: center;
            padding: 6px 5px;
            border: 1px solid #000;
            font-size: 12px;
            vertical-align: middle;
        }

        .report-table tbody tr:nth-child(even) {
            background: #f5f5f5;
        }

        .report-table tfoot td {
            background: #e0e0e0;
            font-weight: bold;
            border: 1px solid #000;
            padding: 8px 5px;
            font-size: 13px;
            text-align: center;
        }

        .items-cell {
            text-align: right !important;
            font-size: 11px;
            line-height: 1.7;
        }

        .items-cell div {
            margin-bottom: 3px;
        }

        /* ==========================================
           بیج
           ========================================== */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 3px;
            font-size: 11px;
            color: #fff;
            font-weight: bold;
        }

        .badge-cash {
            background: #28a745;
        }

        .badge-credit {
            background: #ffc107;
            color: #000;
        }

        .badge-card {
            background: #17a2b8;
        }

        .badge-active {
            background: #28a745;
        }

        .badge-cancelled {
            background: #dc3545;
        }

        .badge-primary {
            background: #007bff;
        }

        .badge-secondary {
            background: #6c757d;
        }

        /* ==========================================
           د لاسلیک برخه
           ========================================== */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .signature-table td {
            text-align: center;
            font-size: 14px;
            padding: 15px;
            vertical-align: top;
            line-height: 2;
        }

        /* ==========================================
           د فوټر
           ========================================== */
        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 11px;
            color: #555;
            border-top: 1px solid #999;
            padding-top: 8px;
        }

        /* ==========================================
           د عکسونو ګالري
           ========================================== */
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .image-item {
            border: 1px solid #333;
            padding: 5px;
            text-align: center;
        }

        .image-item img {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }

        /* ==========================================
           د چاپ تنظیمات (Print Media)
           ========================================== */
        @media print {
            @page {
                size: A4 landscape;
                margin: 10mm;
            }

            body {
                padding: 0;
                font-size: 11px;
            }

            /* د چاپ تڼۍ پټول */
            .print-actions {
                display: none !important;
            }

            /* د راپور سرلیک */
            .report-title {
                font-size: 16px;
                padding: 5px;
                margin: 5px 0;
            }

            /* د جدول سټایلونه */
            .report-table thead th {
                font-size: 11px;
                padding: 5px 3px;
            }

            .report-table tbody td {
                font-size: 10px;
                padding: 4px 3px;
            }

            .summary-table .value {
                font-size: 14px;
            }

            /* د بیج سټایلونه */
            .badge {
                padding: 2px 6px;
                font-size: 10px;
            }

            /* د لاسلیک */
            .signature-table td {
                font-size: 12px;
                padding: 10px;
            }

            /* د فوټر */
            .footer {
                font-size: 10px;
            }

            /* د عکسونو ګالري */
            .image-gallery {
                grid-template-columns: repeat(4, 1fr);
                gap: 5px;
            }

            .image-item img {
                height: 100px;
            }

            /* د هر قطار مخنیوی د ماتیدو */
            .report-table tr {
                page-break-inside: avoid;
            }

            /* د جدول سر په هر پاڼه کې تکرار */
            .report-table thead {
                display: table-header-group;
            }

            .report-table tfoot {
                display: table-footer-group;
            }

            /* د هدر تکرار */
            .header-table {
                page-break-after: avoid;
            }
        }

        /* ==========================================
           د سکرین لپاره (Screen)
           ========================================== */
        @media screen {
            body {
                max-width: 1400px;
                margin: 0 auto;
                padding: 60px 20px 20px 20px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            }
        }
    </style>
</head>

<body>

    {{-- ==========================================
         د چاپ تڼ)
         ========================================== --}}
    <div class="print-actions" dir="rtl">
        <button class="btn-print" onclick="window.print()">
            🖨️ چاپ / PDF
        </button>

        <a href="{{ route('bills.reports') }}" class="btn-back">
            ← بېرته ستنېدل
        </a>
    </div>

    {{-- ==========================================
      هیډر
         ========================================== --}}
    <table class="header-table">
        <tr>
            <td style="width:15%; text-align:left;">
                <img src="{{ asset('assets/moi.png') }}" width="90" alt="MOI">
            </td>
            <td style="width:70%;" class="header-title">
                <p>امـــــارت اســـــلامــی افغـــــــانـــــــستان</p>
                <p>وزارت امـــــــــــور داخـــــــــلــــــــه</p>
                <p>معینیت ارشد امـــــور امنیتــی</p>
                <p>قومنـدانی امنیه ولایت کابل</p>
                <p>معاونیت امـور امنیتــی</p>
                <p>آمریت نظارت خانه</p>
            </td>
            <td style="width:15%; text-align:right;">
                <img src="{{ asset('assets/logo.png') }}" width="80" alt="Logo">
            </td>
        </tr>
    </table>

    {{-- ==========================================
         د راپور سرلیک
         ========================================== --}}
    <div class="report-title">
        @if ($reportType == 'summary')
            @if ($filterItemName)
                د جنس راپور - {{ $filterItemName }}
            @else
                د بیلونو عمومي راپور
            @endif
        @elseif ($reportType == 'items')
            د جنسونو راپور
        @elseif ($reportType == 'shops')
            د دوکانونو راپور
        @elseif ($reportType == 'monthly')
            میاشتنی راپور
        @elseif ($reportType == 'payment')
            د تادیې طریقې راپور
        @elseif ($reportType == 'status')
            د حالت راپور
        @elseif ($reportType == 'images')
            د بیلونو د عکسونو راپور
        @endif
    </div>

    <div class="report-date">
        نېټه : {{ \Morilog\Jalali\Jalalian::now()->format('Y/m/d') }} هـ ش
    </div>

    {{-- ==========================================
         د فلټر معلومات
         ========================================== --}}
    @if (!empty($filterData) && count(array_filter($filterData)) > 1)
        <div class="filter-info">
            {{-- <strong>د فلټر معلومات:</strong> --}}
            @if (!empty($filterData['bill_number']))
                <span>بیل نمبر: <strong>{{ $filterData['bill_number'] }}</strong></span>
            @endif
            @if (!empty($filterData['shop_name']))
                <span>دوکان: <strong>{{ $filterData['shop_name'] }}</strong></span>
            @endif
            @if (!empty($filterData['item_name']))
                <span>جنس: <strong>{{ $filterData['item_name'] }}</strong></span>
            @endif
            @if (!empty($filterData['start_date']))
                <span>له: <strong>{{ $filterData['start_date'] }}</strong></span>
            @endif
            @if (!empty($filterData['end_date']))
                <span>تر: <strong>{{ $filterData['end_date'] }}</strong></span>
            @endif
            @if (!empty($filterData['payment_method']))
                <span>تادیه: <strong>
                        @if ($filterData['payment_method'] == 'cash')
                            نقد
                        @elseif ($filterData['payment_method'] == 'credit')
                            پور
                        @elseif ($filterData['payment_method'] == 'card')
                            کارت
                        @endif
                    </strong></span>
            @endif
            @if (!empty($filterData['status']))
                <span>حالت: <strong>{{ $filterData['status'] == 'active' ? 'فعال' : 'لغو شوی' }}</strong></span>
            @endif
        </div>
    @endif

    {{-- ==========================================
         د ټولیز معلومات
         ========================================== --}}
    <table class="summary-table">
        <tr>
            @if ($reportType == 'summary')
                <td style="width:25%;">
                    <div class="label">ټول بیلونه</div>
                    <div class="value">{{ $summary['total_bills'] ?? 0 }}</div>
                </td>
                <td style="width:25%;">
                    <div class="label">مجموعي قیمت</div>
                    <div class="value">{{ number_format($summary['total_amount'] ?? 0) }}</div>
                </td>
                <td style="width:25%;">
                    <div class="label">ټول اجناس</div>
                    <div class="value">{{ $summary['total_items'] ?? 0 }}</div>
                </td>
                <td style="width:25%;">
                    <div class="label">دوکانونه</div>
                    <div class="value">{{ $summary['total_shops'] ?? 0 }}</div>
                </td>
            @elseif ($reportType == 'items')
                <td style="width:33%;">
                    <div class="label">د اجناسو ډولونه</div>
                    <div class="value">{{ $summary['total_items'] ?? 0 }}</div>
                </td>
                <td style="width:33%;">
                    <div class="label">ټول تعداد</div>
                    <div class="value">{{ number_format($summary['total_quantity'] ?? 0, 0) }}</div>
                </td>
                <td style="width:33%;">
                    <div class="label">مجموعي قیمت</div>
                    <div class="value">{{ number_format($summary['total_amount'] ?? 0) }}</div>
                </td>
            @elseif ($reportType == 'shops')
                <td style="width:33%;">
                    <div class="label">دوکانونه</div>
                    <div class="value">{{ $summary['total_shops'] ?? 0 }}</div>
                </td>
                <td style="width:33%;">
                    <div class="label">ټول بیلونه</div>
                    <div class="value">{{ $summary['total_bills'] ?? 0 }}</div>
                </td>
                <td style="width:33%;">
                    <div class="label">مجموعي قیمت</div>
                    <div class="value">{{ number_format($summary['total_amount'] ?? 0) }}</div>
                </td>
            @elseif ($reportType == 'images')
                <td style="width:50%;">
                    <div class="label">ټول عکسونه</div>
                    <div class="value">{{ $summary['total_images'] ?? 0 }}</div>
                </td>
                <td style="width:50%;">
                    <div class="label">اړوند بیلونه</div>
                    <div class="value">{{ $summary['total_bills'] ?? 0 }}</div>
                </td>
            @else
                <td style="width:50%;">
                    <div class="label">ټول بیلونه</div>
                    <div class="value">{{ $summary['total_bills'] ?? 0 }}</div>
                </td>
                <td style="width:50%;">
                    <div class="label">مجموعي قیمت</div>
                    <div class="value">{{ number_format($summary['total_amount'] ?? 0) }}</div>
                </td>
            @endif
        </tr>
    </table>

    {{-- ==========================================
         د راپور جدولونه
         ========================================== --}}

    {{-- 1. ټولیز راپور --}}
    @if ($reportType == 'summary')
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width:4%;">#</th>
                    <th style="width:12%;">بیل نمبر</th>
                    <th style="width:18%;">د دوکان نوم</th>
                    <th style="width:30%;">د اجناسو لیست</th>
                    <th style="width:12%;">مجموعي قیمت</th>
                    <th style="width:10%;">بیل نیټه</th>
                    <th style="width:8%;">تادیه</th>
                    <th style="width:6%;">حالت</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bills as $index => $bill)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $bill->bill_number }}</strong></td>
                        <td>{{ $bill->shop_name }}</td>
                        <td class="items-cell">
                            @foreach ($bill->items as $item)
                                <div>
                                    • {{ $item->item_name }}
                                    <strong>({{ $item->quantity }})</strong>
                                    @if ($item->category)
                                        <small>[{{ $item->category }}]</small>
                                    @endif
                                    - {{ number_format($item->unit_price) }}
                                </div>
                            @endforeach
                        </td>
                        <td><strong>{{ number_format($bill->filtered_total ?? $bill->total_amount) }}</strong></td>
                        <td>{{ $bill->bill_date_jalali ?? '-' }}</td>
                        <td>
                            @if ($bill->payment_method == 'cash')
                                <span class="badge badge-cash">نقد</span>
                            @elseif ($bill->payment_method == 'credit')
                                <span class="badge badge-credit">پور</span>
                            @elseif ($bill->payment_method == 'card')
                                <span class="badge badge-card">کارت</span>
                            @endif
                        </td>
                        <td>
                            @if ($bill->status == 'active')
                                <span class="badge badge-active">فعال</span>
                            @else
                                <span class="badge badge-cancelled">لغو</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:15px; font-weight:bold;">
                            هیڅ معلومات ونه موندل شو
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align:left;"><strong>مجموعه:</strong></td>
                    <td><strong>{{ number_format($summary['total_amount'] ?? 0) }}</strong></td>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table>
    @endif

    {{-- 2. د جنس له مخې راپور --}}
    @if ($reportType == 'items')
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width:5%;">#</th>
                    <th style="width:25%;">د جنس نوم</th>
                    <th style="width:15%;">واحد</th>
                    <th style="width:15%;">ټول تعداد</th>
                    <th style="width:15%;">د بیلونو شمېر</th>
                    <th style="width:15%;">اوسط قیمت</th>
                    <th style="width:15%;">مجموعي قیمت</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $item->item_name }}</strong></td>
                        <td>{{ $item->category ?? 'نشته' }}</td>
                        <td>{{ number_format($item->total_quantity, 0) }}</td>
                        <td>{{ $item->bill_count }}</td>
                        <td>{{ number_format($item->avg_price) }}</td>
                        <td><strong>{{ number_format($item->total_amount) }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:15px; font-weight:bold;">
                            هیڅ معلومات ونه موندل شو
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align:left;"><strong>مجموعه:</strong></td>
                    <td><strong>{{ number_format($summary['total_quantity'] ?? 0, 0) }}</strong></td>
                    <td></td>
                    <td></td>
                    <td><strong>{{ number_format($summary['total_amount'] ?? 0) }}</strong></td>
                </tr>
            </tfoot>
        </table>
    @endif

    {{-- 3. د دوکان له مخې راپور --}}
    @if ($reportType == 'shops')
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width:5%;">#</th>
                    <th style="width:25%;">د دوکان نوم</th>
                    <th style="width:15%;">تلیفون</th>
                    <th style="width:20%;">پته</th>
                    <th style="width:12%;">د بیلونو شمېر</th>
                    <th style="width:13%;">مجموعي قیمت</th>
                    <th style="width:10%;">اوسط قیمت</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($shops as $index => $shop)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $shop->shop_name }}</strong></td>
                        <td>{{ $shop->shop_phone ?? 'نشته' }}</td>
                        <td>{{ $shop->shop_address ?? 'نشته' }}</td>
                        <td>{{ $shop->total_bills }}</td>
                        <td><strong>{{ number_format($shop->total_amount) }}</strong></td>
                        <td>{{ number_format($shop->avg_amount) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:15px; font-weight:bold;">
                            هیڅ معلومات ونه موندل شو
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align:left;"><strong>ټولیز:</strong></td>
                    <td><strong>{{ $summary['total_bills'] ?? 0 }}</strong></td>
                    <td><strong>{{ number_format($summary['total_amount'] ?? 0) }}</strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    @endif

    {{-- 4. میاشتنی راپور --}}
    @if ($reportType == 'monthly')
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width:8%;">#</th>
                    <th style="width:30%;">میاشت</th>
                    <th style="width:20%;">د بیلونو شمېر</th>
                    <th style="width:22%;">مجموعي قیمت</th>
                    <th style="width:20%;">اوسط قیمت</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($completeData as $index => $month)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $month['month_name'] }}</strong></td>
                        <td>{{ $month['total_bills'] }}</td>
                        <td><strong>{{ number_format($month['total_amount'], 2) }}</strong></td>
                        <td>{{ number_format($month['avg_amount'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="text-align:left;"><strong>ټولیز:</strong></td>
                    <td><strong>{{ $summary['total_bills'] ?? 0 }}</strong></td>
                    <td><strong>{{ number_format($summary['total_amount'] ?? 0, 2) }}</strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    @endif

    {{-- 5. د تادیې طریقې راپور --}}
    @if ($reportType == 'payment')
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width:8%;">#</th>
                    <th style="width:35%;">د تادیې طریقه</th>
                    <th style="width:25%;">د بیلونو شمېر</th>
                    <th style="width:32%;">مجموعي قیمت</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($completeData as $index => $payment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if ($payment['payment_method'] == 'cash')
                                <span class="badge badge-cash">نقد</span>
                            @elseif ($payment['payment_method'] == 'credit')
                                <span class="badge badge-credit">پور</span>
                            @elseif ($payment['payment_method'] == 'card')
                                <span class="badge badge-card">کارت</span>
                            @endif
                            <strong>{{ $payment['payment_method_name'] }}</strong>
                        </td>
                        <td>{{ $payment['total_bills'] }}</td>
                        <td><strong>{{ number_format($payment['total_amount'], 2) }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="text-align:left;"><strong>مجموعاً:</strong></td>
                    <td><strong>{{ $summary['total_bills'] ?? 0 }}</strong></td>
                    <td><strong>{{ number_format($summary['total_amount'] ?? 0, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>
    @endif

    {{-- 6. د حالت راپور --}}
    @if ($reportType == 'status')
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width:8%;">#</th>
                    <th style="width:35%;">حالت</th>
                    <th style="width:25%;">د بیلونو شمېر</th>
                    <th style="width:32%;">مجموعي قیمت</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($completeData as $index => $status)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span
                                class="badge {{ $status['status'] == 'active' ? 'badge-active' : 'badge-cancelled' }}">
                                {{ $status['status_name'] }}
                            </span>
                        </td>
                        <td>{{ $status['total_bills'] }}</td>
                        <td><strong>{{ number_format($status['total_amount'], 2) }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="text-align:left;"><strong>مجموعاً:</strong></td>
                    <td><strong>{{ $summary['total_bills'] ?? 0 }}</strong></td>
                    <td><strong>{{ number_format($summary['total_amount'] ?? 0, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>
    @endif

    {{-- 7. د عکسونو راپور --}}
    @if ($reportType == 'images')
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width:4%;">شمېره</th>
                    <th style="width:12%;">بیل نمبر</th>
                    <th style="width:18%;">د دوکان نوم</th>
                    <th style="width:30%;">بیل نیټه</th>
                    {{-- <th style="width:18%;">د عکس نوم</th> --}}
                    <th style="width:38%;">عکس</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($images as $index => $image)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $image->bill->bill_number ?? 'نشته' }}</strong></td>
                        <td>{{ $image->bill->shop_name ?? 'نشته' }}</td>
                        <td>{{ $image->bill->bill_date_jalali ?? '-' }}</td>
                        {{-- <td>{{ $image->image_name }}</td> --}}
                        <td>
                            @if (file_exists(public_path('storage/' . $image->image_path)))
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                    style="width:90px; height:90px; object-fit:cover; border:1px solid #333;">
                            @else
                                <span>عکس نشته</span>
                            @endif
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:15px; font-weight:bold;">
                            هیڅ عکس ونه موندل شو
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    @endif

    {{-- ==========================================
         د لاسلیک برخه
         ========================================== --}}
    <table class="signature-table">
        <tr>
            <td style="text-align:right; width:50%;">
                <br>
                ترتیب کوونکی:
                <br>
                مسؤل اداری نظارت خانه
            </td>
            <td style="text-align:center; width:50%;">
                <br><br>
                آمر نظارت خانه
            </td>
        </tr>
    </table>

    {{-- ==========================================
         د فوټر
         ========================================== --}}
    <div class="footer">
        {{-- دا راپور په اتوماتیک ډول د سیستم لخوا جوړ شوی دی - --}}
        {{ \Morilog\Jalali\Jalalian::now()->format('Y/m/d H:i') }}
    </div>

    {{-- ==========================================
         د چاپ اتوماتیک (اختیاري)
         ========================================== --}}
    <script>
        // که غواړئ چې په اتوماتیک ډول د چاپ ډیالوګ خلاص شي
        // دا لیکه لرې کړئ که نه غواړئ
        // window.onload = function() {
        //     setTimeout(function() {
        //         window.print();
        //     }, 500);
        // };
    </script>

</body>

</html>
