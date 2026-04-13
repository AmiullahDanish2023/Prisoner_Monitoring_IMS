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
            unicode-bidi: embed;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* ✅ ONLY report table has border */
        .report-table th,
        .report-table td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }

        .report-table thead th {
            background: #ddd;
        }

        .report-table tfoot td {
            background: #eee;
            font-weight: bold;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>

</head>

<body>

    <table width="100%" style="margin-bottom:10px;">
        <tr>
            <td style="text-align:left">
                <img src="{{ public_path('assets/moi.png') }}" width="100">
            </td>
            <td style="text-align:center">
                <p class="header-label" style="font-size: 100% ;">امـــــارت اســـــلامــی افغـــــــانـــــــستان</p>
                <p class="header-label" style="font-size: 100%;">وزارت امـــــــــــور داخـــــــــلــــــــه</p>
                <p class="header-label" style="font-size: 100%">معینیت ارشد امـــــور امنیتــی</p>
                <p class="header-label" style="font-size: 100%">قومنـدانی امنیه ولایت کابل</p>
                <p class="header-label" style="font-size: 100%">معاونیت امـور امنیتــی</p>
                <p class="header-label" style="font-size: 100%">آمریت نظارت خانه</p>
            </td>
            <td style="text-align:right">
                <img src="{{ public_path('assets/logo.png') }}" width="90">
            </td>
        </tr>
    </table>

    <p style="text-align:center">
       تعداد مجموعی مظنونین : {{ $totals['persons'] }} نفر

    </p>

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
                {{-- @php
                $visibleFields = [];

                foreach ($items as $field => $label) {
                    foreach ($rows as $row) {
                        if (!empty($row[$field]) && $row[$field] != 0) {
                            $visibleFields[$field] = $label;
                            break;
                        }
                    }
                }
                @endphp
                @foreach ($visibleFields as $field => $label)
                    <th>{{ $label }}</th>
                @endforeach --}}
                @foreach ($items as $field => $label)
                     
                    <td>{{ $row[$field] == 0 ? 0 : number_format($row[$field], 0) }}</td>
                   
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
                <td>{{ $totals[$field] == 0 ? 0 : number_format($totals[$field], 0) }}</td>
            @endforeach
        </tr>
    </tfoot>
</table>



    <table style="width:100%; margin-top:8px; border-collapse:collapse; direction:ltr;">



        <tr>
            <td colspan="3" style="height:8px;"></td>
        </tr>

        <!-- Signatures Row -->
        <tr>

            <!-- LEFT -->
            <td style="width:33.33%; text-align:left; font-size:20px; vertical-align:top;">
                <div style="direction:rtl; text-align:left;">
                    <br>
                     آمر نظارت خانه
                   
                </div>
            </td>

               <!-- CENTER -->
            <td style="width:33.33%; text-align:center; font-size:20px; vertical-align:top;">
                <div style="direction:rtl; text-align:center;">
                    <br>
       					نام رئیس هیئت
                        <br>
                        <br>
                        و قطعه مربوطه
                </div>
            </td>

            <!-- CENTER -->
            <td style="width:33.33%; text-align:center; font-size:20px; vertical-align:top;">
                <div style="direction:rtl; text-align:center;">
                    <br>
       					نام  هیئت
                        <br>
                        <br>
                        و قطعه مربوطه
                </div>
            </td>

             <!-- CENTER -->
            <td style="width:33.33%; text-align:center; font-size:20px; vertical-align:top;">
                <div style="direction:rtl; text-align:center;">
                    <br>
       					نام  هیئت
                        <br>
                        <br>
                        و قطعه مربوطه
                </div>
            </td>

          

            <!-- RIGHT -->
            <td style="width:33.33%; text-align:right; font-size:20px; vertical-align:top;">
                <div style="direction:rtl; text-align:right;">
                    <br>
                    مسئول اکمال نظارت خانه
                </div>
            </td>

        </tr>

    </table>




</body>

</html>
