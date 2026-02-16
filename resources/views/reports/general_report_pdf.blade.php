<!DOCTYPE html>
<html lang="fa" dir="rtl" style="direction: rtl;">

<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 35px;
        }

        @font-face {
            font-family: 'bahijfont';
            src: url('{{ public_path('assets/fonts/bahij-nazanin.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
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

        #table thead th {
            border: 2px solid #000;
            text-align: center;
            padding: 5px;
            background-color: #f2f2f2;
            font-weight: bold;
            font-size: 13px;
        }

        #table tbody td {
            border: 1px solid #000;
            text-align: center;
            padding: 4px;
            font-size: 12px;
        }

        .header-label {
            font-size: 16px;
            font-weight: bold;
            line-height: 1.3;
        }

        .report-info {
            margin: 8px 0;
            font-size: 14px;
            text-align: right;
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

            <td style="font-size: 115% ; text-align:center; line-height:1.3;">
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

    <table style="width:100%; border-collapse:collapse; margin-bottom:6px;" dir="rtl">
        <tr style="font-weight:bold;">
            <td style="text-align:center; font-size:110%; line-height:1.6;">
                جدول شهرت
                @php
                    $gender = request('gender');
                @endphp

                @if ($gender === 'ښځینه')
                    مظنونین طبقه اناثیه
                @elseif($gender === 'نارینه')
                    مظنونین ذکور
                @else
                    مظنونین عمومي ذکور و اناث
                @endif

                آمریت نظارت خانه قومندانی امنیه ولایت کابل

                مورخ: {{ $shamsiDate }} هـ ش
                &nbsp;
                مطابق: {{ $qamariDate }} هـ ق
            </td>
        </tr>
    </table>


    {{-- TABLE --}}
    <table id="table">
        <thead>
            <tr>
                <th style="font-size: 115%">شماره</th>
                <th style="font-size: 115%"> نام مظنون </th>
                <th style="font-size: 115%"> نام پدر</th>
                @if (request('gender') === 'ښځینه')
                    <th style="font-size: 115%">دماشومانوتعداد</th>
                @endif
                <th style="font-size: 115%">ولایت</th>
                <th style="font-size: 115%">ناحیه</th>
                <th style="font-size: 115%">منطقه</th>
                <th style="font-size: 115%">نوع جرم</th>
                <th style="font-size: 115%"> مرجع اعزامی</th>
                <th style="font-size: 115%">تاریخ نظارت</th>

            </tr>
        </thead>
        ‍
        <tbody>
            @forelse ($suspects as $index => $suspect)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $suspect->suspect_name ?? '-' }}</td>
                    <td>{{ $suspect->father_name ?? '-' }}</td>
                    @if (request('gender') === 'ښځینه')
                        <td>{{ $suspect->children_with_mother ?? '-' }}</td>
                    @endif
                    <td>{{ $suspect->province_name ?? '-' }}</td>
                    <td>{{ $suspect->district ?? '-' }}</td>
                    <td>{{ $suspect->area ?? '-' }}</td>
                    <td>{{ $suspect->crime_type ?? '-' }}</td>
                    <td>{{ $suspect->referring_authority ?? '-' }}</td>

                   <td>{{ $suspect->monitoring_date_dari ?? '-' }}</td>


                </tr>
            @empty
                <tr>
                    <td colspan="10" style="font-weight:bold">
                        هیڅ معلومات شتون نلري
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table style="width:100%; border-collapse:collapse; margin-top:12px;" dir="rtl">
        <tr style="font-weight:bold;">
            <td style="text-align:right; font-size:115%; line-height:1.8;">
                قرار شرح فوق جدول تعداد ({{ $suspects->count() }}) نفر جدول هذا ترتیب وصحت است
            </td>
        </tr>

        <tr>
            <td style="text-align:center; font-size:14px; padding-top:6px;">
               
                <br>
                آمر نظارت خانه
            </td>
        </tr>
    </table>



</body>

</html>
