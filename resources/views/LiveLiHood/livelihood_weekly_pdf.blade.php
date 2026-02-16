<!DOCTYPE html>
<html dir="rtl" lang="fa">

<head>
    <meta charset="UTF-8">

    <style>
        @font-face {
            font-family: 'bahijfont';
            src: url('{{ public_path('assets/fonts/bahij-nazanin.ttf') }}') format('truetype');
        }

        body {
            font-family: 'bahijfont', sans-serif;
            direction: rtl;
            margin: 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            border: none;
        }

        .header-title {
            font-size: 14px;
            margin: 2px 0;
        }

        .report-title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0 5px 0;
        }

        .report-subtitle {
            text-align: center;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
            font-size: 11px;
        }

        .report-table thead th {
            background: #e0e0e0;
        }

        .report-table tfoot td {
            background: #f2f2f2;
            font-weight: bold;
        }

        tr {
            page-break-inside: avoid;
        }

        .signature-table td {
            border: none;
            font-size: 13px;
            vertical-align: top;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <table class="header-table" style="margin-bottom:10px;">
        <tr>
            <td style="width:20%; text-align:left;">
                <img src="{{ public_path('assets/moi.png') }}" width="80">
            </td>

            <td style="width:60%; text-align:center;">
                <div class="header-title">امـــــارت اســـــلامــی افغـــــــانـــــــستان</div>
                <div class="header-title">وزارت امـــــــــــور داخـــــــــلــــــــه</div>
                <div class="header-title">معینیت ارشد امـــــور امنیتــی</div>
                <div class="header-title">قومنـدانی امنیه ولایت کابل</div>
                <div class="header-title">معاونیت امـور امنیتــی</div>
                <div class="header-title">آمریت نظارت خانه</div>
            </td>

            <td style="width:20%; text-align:right;">
                <img src="{{ public_path('assets/logo.png') }}" width="70">
            </td>
        </tr>
    </table>

    <!-- Titles -->
    <div class="report-title">
        راپور هفته وار ({{ $weekRange }})
    </div>

    <div class="report-subtitle">
        تعداد مجموعی مظنونین: {{ $totals['persons'] }} نفر
    </div>

    <!-- Report Table -->
    <table class="report-table">
        <thead>
            <tr>
                <th>شماره</th>
                <th>تاریخ</th>
                <th>روز</th>
                <th>تعداد مظنونین</th>
                <th>مبلغ</th>

                @foreach ($items as $label)
                    <th>{{ $label }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach ($rows as $row)
                <tr>
                    <td>{{ $row['no'] }}</td>
                    <td>{{ $row['date'] }}</td>
                    <td>{{ $row['weekday'] }}</td>
                    <td>{{ $row['persons'] }}</td>
                    <td>{{ number_format($row['amount'], 0) }}</td>

                    @foreach ($items as $field => $label)
                        <td>
                            {{ $row[$field] == 0 ? 0 : number_format($row[$field], 0) }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="3">مجموع</td>
                <td>{{ $totals['persons'] }}</td>
                <td>{{ number_format($totals['amount'], 0) }}</td>

                @foreach ($items as $field => $label)
                    <td>
                        {{ $totals[$field] == 0 ? 0 : number_format($totals[$field], 0) }}
                    </td>
                @endforeach
            </tr>
        </tfoot>
    </table>

    <!-- Signatures -->
    <table class="signature-table" style="margin-top:20px;">
        <tr>
            <td style="width:20%; text-align:right;">
                آمر نظارت خانه
            </td>

            <td style="width:20%; text-align:center;">
                نام رئیس هیئت<br><br>
                و قطعه مربوطه
            </td>

            <td style="width:20%; text-align:center;">
                نام هیئت<br><br>
                و قطعه مربوطه
            </td>

            <td style="width:20%; text-align:center;">
                نام هیئت<br><br>
                و قطعه مربوطه
            </td>

            <td style="width:20%; text-align:left;">
                مسئول اکمال نظارت خانه
            </td>
        </tr>
    </table>

</body>
</html> 

