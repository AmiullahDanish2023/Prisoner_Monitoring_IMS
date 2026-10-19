@extends('layouts.master')

@section('header-menu')
@endsection
@section('content')
    <style>
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #dee2e6;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }

        .custom-datatable {
            width: 100%;
            border-collapse: collapse !important;
            font-size: 14px;
        }

        /* ---------- Borders ---------- */
        .custom-datatable th,
        .custom-datatable td {
            border: 1px solid #dee2e6 !important;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
        }

        /* ---------- Header ---------- */
        .custom-datatable thead th {
            background: #3f577c !important;
            color: #fff !important;
            font-weight: 600;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }

        /* ---------- Rows ---------- */
        .custom-datatable tbody tr {
            transition: all 0.2s ease-in-out;
        }

        /* Hover */
        .custom-datatable tbody tr:hover {
            background-color: #94c8e4 !important;
        }

        /* Striped
            .custom-datatable.table-striped tbody tr:nth-of-type(odd) {
                background-color: #f9fbfd;
            } */

        /* ---------- Footer ---------- */
        .custom-datatable tfoot td {
            background: #c3e4f1;
            font-weight: 700;
        }

        /* =========================================================
                       ACTION BUTTONS
        ========================================================= */

        .action-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        /* ---------- Base Button ---------- */
        .action-buttons a {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;

            min-width: 38px;
            height: 38px;

            padding: 0 12px;

            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;

            transition: all 0.25s ease-in-out;

            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        /* ---------- Icons ---------- */
        .action-buttons a i,
        .action-buttons a svg {
            color: #fff !important;
            stroke: #fff !important;
            font-size: 16px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ---------- Hover ---------- */
        .action-buttons a:hover {
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.18);
        }

        /* ---------- Active ---------- */
        .action-buttons a:active {
            transform: scale(0.96);
        }

        /* =========================================================
                   BUTTON COLORS
          ========================================================= */

        .view-btn {
            background: linear-gradient(135deg, #4f9cf9, #1d4ed8);
            color: #fff !important;
        }

        .edit-btn {
            background: linear-gradient(135deg, #22d3ee, #0891b2);
            color: #fff !important;
        }

        .destroy_btn {
            background: linear-gradient(135deg, #fb7185, #dc2626);
            color: #fff !important;
        }

        .release-btn {
            background: linear-gradient(135deg, #4ade80, #16a34a);
            color: #fff !important;
        }

        .btn-transfer {
            background: linear-gradient(135deg, #facc15, #d97706);
            color: #fff !important;
        }

        /* =========================================================
                           TOOLTIP
          ========================================================= */

        .action-buttons a[data-title] {
            position: relative;
        }

        .action-buttons a[data-title]::after {
            content: attr(data-title);

            position: absolute;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);

            background: rgba(0, 0, 0, 0.92);
            color: #fff;

            font-size: 11px;
            padding: 5px 9px;

            border-radius: 5px;

            opacity: 0;
            white-space: nowrap;
            pointer-events: none;

            transition: all 0.25s ease;
            z-index: 999;
        }

        .action-buttons a[data-title]:hover::after {
            opacity: 1;
            bottom: 140%;
        }

        /* =========================================================
                                     SWEET ALERT
          ========================================================= */

        .swal2-title,
        .swal2-html-container {
            font-family: 'Bahij', sans-serif !important;
            font-weight: 700 !important;
            font-size: 18px !important;
        }

        /* =========================================================
                            FORM VALIDATION
   ========================================================= */

        label.error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 4px;
            display: block;
        }

        input.error,
        select.error,
        textarea.error {
            border-color: #dc3545 !important;
        }

        /* =========================================================
                              INPUT FOCUS
       ========================================================= */

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 .20rem rgba(13, 110, 253, .15);
            border-color: #86b7fe;
        }

        /* =========================================================
                               DATATABLE FIX
         ========================================================= */

        table.dataTable {
            border-collapse: collapse !important;
        }

        /* =========================================================
                             MOBILE RESPONSIVE
         ========================================================= */

        @media (max-width: 768px) {

            .custom-datatable th,
            .custom-datatable td {
                font-size: 12px;
                padding: 8px;
            }

            .action-buttons a {
                min-width: 34px;
                height: 34px;
                padding: 0 10px;
            }

            .action-buttons a i,
            .action-buttons a svg {
                font-size: 14px;
            }
        }
    </style>
    <div class="container-fluid">


        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">د بدل اعاشې د اونۍ پلان  {{ $month }}</h4>
            <a href="{{ route('livelihood.list.show') }}" class="btn btn-secondary btn-sm">برگشت به لیست</a>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table custom-datatable table-striped text-center align-middle">
                <thead>
                    <tr>
                        <th>شمیره</th>
                        <th>د هفتې ورځې</th>
                        <th>تاریخ</th>
                        <th>مبلغ (AFN)</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($livelihoods as $key => $item)
                        @php $total += $item->amount; @endphp
                        <tr class="{{ $key % 2 == 0 ? 'even-row' : 'odd-row' }}">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->weekDay->name ?? '-' }}</td>
                            <td>{{ $item->livelihoodDate }}</td>
                            <td>{{ number_format($item->amount) }}</td>
                            <td>
                                <a href="{{ route('livelihood.edit', $item->id) }}" class="btn btn-sm btn-primary"
                                    title="پلان تغیرول">پلان تغیرول</a>

                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end">ټول مبلغ:</td>
                        <td>{{ number_format($total) }}</td>
                        <td>
                            @can('Make Weekly Livelihood Report')
                                <a href="{{ route('livelihood.weekly.report.pdf', $livelihoods->first()->id) }}"
                                    class="btn btn-sm btn-success">
                                    هفته وار راپور پرینټ
                                </a>
                            @endcan

                        </td>
                        </td>

                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
@endsection

@section('scripts')
@endsection
