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

    @php
        $shamsiDate = \Morilog\Jalali\Jalalian::now()->format('Y/m/d');
        $qamariDate = \Alkoumi\LaravelHijriDate\Hijri::Date('Y/m/d');
    @endphp

    <h4 style="text-align:center; font-size:18px; font-weight:bold; margin-bottom:3px;">
        جدول راپور مظنونین ذکور و اناث آمریت نظارت خانه قومندانی امنیه ولایت کابل
        از بابت برج {{ $reportMonth }} سال {{ $reportYear }}هـ ش
    </h4>


    <table id="table">
        <thead>
            <tr>
                <th style="text-align:center; margin-bottom:10px; font-size:16px; font-weight:bold;">
                    تعداد روز </th>
                <th style="text-align:center; margin-bottom:10px; font-size:16px; font-weight:bold;">
                    مظنونین ذکور</th>
                <th style="text-align:center; margin-bottom:10px; font-size:16px; font-weight:bold;">
                    مظنونین اناث</th>
                <th style="text-align:center; margin-bottom:10px; font-size:16px; font-weight:bold;">
                    اطفال همراه مادر شان </th>
                <th style="text-align:center; margin-bottom:10px; font-size:16px; font-weight:bold;">
                    میزان عمومی</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suspects as $data)
                <tr>
                    <td>{{ $data['day'] }}</td>
                    <td>{{ $data['male'] }}</td>
                    <td>{{ $data['female'] }}</td>
                    <td>{{ $data['children'] }}</td>
                    <td>{{ $data['total'] }}</td>
                </tr>
            @endforeach

            <tr style="font-weight:bold; background:#f2f2f2; font-size: 150%;">
                <td style="font-weight:bold; font-size: 100%;">مجموعه</td>
                <td style="font-weight:bold; font-size: 120%;">{{ $sumMale }}</td>
                <td style="font-weight:bold; font-size: 120%;">{{ $sumFemale }}</td>
                <td style="font-weight:bold; font-size: 120%;">{{ $sumChildren }}</td>
                <td style="font-weight:bold; font-size: 120%;">{{ $sumGrand }}</td>
            </tr>
        </tbody>

    </table>
    <table style="width:100%; margin-top:8px; border-collapse:collapse; direction:ltr;">

        <!-- Description Row -->
        <tr>
            <td colspan="3" style="font-weight:bold; font-size:16px; text-align:right; direction:rtl;">
                قرار شرح فوق جدول راپور عاشه ۲۴ ساعته مظنونین ذکور و اناثیه
                ازبابت برج {{ $reportMonth }} سال جاری نظارت میباشد ترتیب وصحت است.
            </td>
        </tr>

        <tr>
            <td colspan="3" style="height:8px;"></td>
        </tr>

        <!-- Signatures Row -->
        <tr>

            <!-- LEFT -->
            <td style="width:33.33%; text-align:left; font-size:14px; vertical-align:top;">
                <div style="direction:rtl; text-align:left;">
                   <br>
                    مسئول اکمال نظارت خانه
                </div>
            </td>

            <!-- CENTER -->
            <td style="width:33.33%; text-align:center; font-size:14px; vertical-align:top;">
                <div style="direction:rtl; text-align:center;">
                   <br>
                    مسئول امنیت داخلی
                </div>
            </td>

            <!-- RIGHT -->
            <td style="width:33.33%; text-align:right; font-size:14px; vertical-align:top;">
                <div style="direction:rtl; text-align:right;">
                   <br>
                    آمر نظارت خانه
                </div>
            </td>

        </tr>

    </table>





</body>

</html>
