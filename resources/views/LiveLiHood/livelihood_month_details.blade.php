@extends('layouts.master')

@section('content')
    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">پلان هفته بدل اعاشه – {{ $month }}</h4>
            <a href="{{ route('livelihood.list.show') }}" class="btn btn-secondary btn-sm">برگشت به لیست</a>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table text-center align-middle" style="min-width: 600px; border-collapse: collapse; width:100%;">
                <thead style="background:#9abacc; font-weight:bold;">
                    <tr>
                        <th style="border: 1px solid #dee2e6; width:5%;">شمیره</th>
                        <th style="border: 1px solid #dee2e6; width:20%;">هفته</th>
                        <th style="border: 1px solid #dee2e6; width:20%;">تاریخ</th>
                        <th style="border: 1px solid #dee2e6; width:20%;">مبلغ (AFN)</th>
                        <th style="border: 1px solid #dee2e6; width:15%;">عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($livelihoods as $key => $item)
                        @php $total += $item->amount; @endphp
                        <tr class="{{ $key % 2 == 0 ? 'even-row' : 'odd-row' }}">
                            <td style="border: 1px solid #dee2e6;">{{ $key + 1 }}</td>
                            <td style="border: 1px solid #dee2e6;">{{ $item->weekDay->name ?? '-' }}</td>
                            <td style="border: 1px solid #dee2e6;">{{ $item->livelihoodDate }}</td>
                            <td style="border: 1px solid #dee2e6;">{{ number_format($item->amount) }}</td>
                            <td style="border: 1px solid #dee2e6;">
                                <a href="{{ route('livelihood.edit', $item->id) }}" class="btn btn-sm btn-primary"
                                    title="پلان تغیرول">پلان تغیرول</a>

                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background:#d1e7dd; font-weight:bold;">
                        <td colspan="3" class="text-end" style="border: 1px solid #dee2e6;">ټول مبلغ:</td>
                        <td style="border: 1px solid #dee2e6;">{{ number_format($total) }}</td>
                        <td style="border: 1px solid #dee2e6;">
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
    <style>
        table {
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 10px 8px;
            border: 1px solid #dee2e6;
            /* داخلي borders */
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Striped effect */
        tbody tr.odd-row {
            background-color: #f8f9fa;
            /* روشن ردیف */
        }

        tbody tr.even-row {
            background-color: #ffffff;
            /* سپین ردیف */
        }

        /* Hover effect */
        tbody tr:hover {
            background-color: #e9f7fd !important;
        }

        .btn-sm {
            padding: 4px 8px;
            font-size: 13px;
        }

        .table-responsive {
            overflow-x: auto;
        }
    </style>
@endsection
