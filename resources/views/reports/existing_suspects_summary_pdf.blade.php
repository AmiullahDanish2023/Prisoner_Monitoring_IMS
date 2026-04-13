<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin: 35px;
        }

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

        #table {
            border-collapse: collapse;
            width: 100%;
        }

        #table th,
        #table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
            font-size: 12px;
        }

        #table thead th {
            background-color: #f2f2f2;
            font-weight: bold;
            font-size: 13px;
        }

        #table tbody td:first-child,
        #table tbody td:last-child,
        #table tbody th:first-child,
        #table tbody th:last-child {
            font-weight: bold;
        }

        .virtual-col {
            display: table-cell;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
        }

        .header-label {
            font-size: 16px;
            font-weight: bold;
            line-height: 1.3;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <table width="100%" style="margin-bottom:10px;">
        <tr>
            <td style="text-align:left">
                <img src="{{ public_path('assets/moi.png') }}" width="100">
            </td>
            <td style="text-align:center">
                <p>امـــــارت اســـــلامی افغــــانــستان</p>
                <p>وزارت امــــــــــور داخـــــــــلــــه</p>
                <p>معینیت ارشد امــــور امنیتــی</p>
                <p>قومنـدانی امنیه ولایت کابل</p>
                <p>معاونیت امــور امنیتی</p>
                <p>آمریت نظارت خانه</p>
            </td>
            <td style="text-align:right">
                <img src="{{ public_path('assets/logo.png') }}" width="90">
            </td>
        </tr>
    </table>

    @php
        $shamsiDate = \Morilog\Jalali\Jalalian::now()->format('Y/m/d');
        $qamariDate = \Alkoumi\LaravelHijriDate\Hijri::Date('Y/m/d');
        // $qamariDate = \Alkoumi\LaravelHijriDate\Hijri::Date('Y/m/d', now()->addDays(1));
    @endphp

    <h4 style="text-align:center; font-size:18px; font-weight:bold;">
        جدول راپور موجودی مظنونین ذکور واناث داخل نظارت خانه قومندانی امنیه ولایت کابل

        مورخ: {{ $shamsiDate }} هـ ش مطابق: {{ $qamariDate }} هـ ق
    </h4>

    <table id="table">
        <thead>
            <tr>
                <th style="text-align:center; margin-bottom:10px; font-size:16px; font-weight:bold;">تفصیلات</th>
                <th style="text-align:center; margin-bottom:10px; font-size:16px; font-weight:bold;">مظنونین سابقه</th>
                <th style="text-align:center; margin-bottom:10px; font-size:16px; font-weight:bold;">مظنونین جدید</th>
                <th style="text-align:center; margin-bottom:10px; font-size:16px; font-weight:bold;">مظنونین رهایی</th>
                <th style="text-align:center; margin-bottom:10px; font-size:16px; font-weight:bold;">انتقال به مراجع
                    مختلف</th>
                <th style="text-align:center; margin-bottom:10px; font-size:16px; font-weight:bold;">انتقال به توقیف
                </th>
                <th style="text-align:center; margin-bottom:10px; font-size:16px; font-weight:bold;">میزان عمومی</th>
            </tr>
        </thead>
        <tbody>


            <tr>
                <td style="text-align:center; margin-bottom:10px; font-size:16px; font-weight:bold;">مظنونین ذکور</td>
                <td>{{ $oldMaleSuspects }}</td>
                <td>{{ $newMaleSuspects }}</td>
                <td>{{ $maleReleasedToday }}</td>
                <td>{{ $maleTransferredToday }}</td>
                <td>{{ $maleDetainedToday }}</td>
                <td>{{ $TotalOfMale }}</td>
            </tr>


            <tr>
                <td style="text-align:center; margin-bottom:10px; font-size:16px; font-weight:bold;">مظنونین اناث</td>
                <td>{{ $oldFemaleSuspects }}</td>
                <td>{{ $newFemaleSuspects }}</td>
                <td>{{ $femaleReleasedToday }}</td>
                <td>{{ $femaleTransferredToday }}</td>
                <td>{{ $femaleDetainedToday }}</td>
                <td>{{ $TotalOfFemale }}</td>
            </tr>


            <tr>
                <td style="text-align:center; margin-bottom:10px; font-size:16px; font-weight:bold;">اطفال همراه طبقه
                    اناث</td>
                <td>{{ $oldChildrenSuspects }}</td>
                <td>{{ $newChildrenSuspects }}</td>
                <td>{{ $ChildrenReleasedToday }}</td>
                <td>{{ $ChildrenTransferredToday }}</td>
                <td>{{ $ChildrenDetainedToday }}</td>
                <td>{{ $TotalOfChildren }}</td>
            </tr>


            <tr>
                <th style="text-align:center; margin-bottom:10px; font-size:16px; font-weight:bold;"> میزان عمومی</th>
                <th>{{ $GeneralTotalOldSuspects }}</th>
                <th>{{ $GeneralTotalNewSuspects }}</th>
                <th>{{ $GeneralTotalReleasedSuspects }}</th>
                <th>{{ $GeneralTotalTransferredSuspects }}</th>
                <th>{{ $GeneralTotalDetainedSuspects }}</th>
                <th>{{ $GrandTotalOfSuspects }}</th>
            </tr>

        </tbody>
    </table>

    <table style="width:100%; margin-top:6px;">
        <tr>
            <td style="font-weight:bold; font-size:16px;">قرار شرح فوق جدول هذا ترتیب وصحت است</td>
        </tr>
        <tr>
            <td style="text-align:center; font-size:14px;">
                بااحترام<br>
                نوکریوال نظارت خانه<br>
                قومنـدانی امنیه ولایت کابل
            </td>
        </tr>
    </table>

</body>

</html>
