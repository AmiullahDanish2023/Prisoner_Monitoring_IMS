<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 30px;
        }

        @font-face {
            font-family: 'bahijfont';
            src: url('{{ public_path('assets/fonts/bahij-nazanin.ttf') }}') format('truetype');
        }

        body {
            font-family: 'bahijfont', sans-serif;
            direction: rtl;
            font-size: 13px;
            unicode-bidi: embed;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .no-border td {
            border: none !important;
        }

        .header-title {
            font-size: 15px;
            font-weight: bold;
            line-height: 1.6;
        }

        .section-title {
            background-color: #e8eef5;
            font-weight: bold;
            text-align: right;
            padding: 6px;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>

    @php
        // Column count depends on gender
        $colCount = $suspect->gender === 'ښځینه' ? 8 : 7;
    @endphp

    {{-- ================= HEADER ================= --}}
    <table width="100%" class="no-border" style="margin-bottom:10px;">
        <tr>
            <td style="text-align:left">
                <img src="{{ public_path('assets/moi.png') }}" width="100">
            </td>

            <td style="font-size:115%; text-align:center; line-height:1.3;">
                <p>امـــــارت اســـــلامی افغــــانــستان</p>
                <p>وزارت امـــــــور داخـــــــــلــه</p>
                <p>معینیت ارشد امــــور امنیتــی</p>
                <p>قومنـدانی امنیه ولایت کابل</p>
                <p>معاونـــــیت امــــور امــنیتــی</p>
                <p>آمــریت نـظارت خــانه</p>
            </td>

            <td style="text-align:right">
                <img src="{{ public_path('assets/logo.png') }}" width="90">
            </td>
        </tr>
    </table>

    <table>

        {{-- ================= BASIC INFO ================= --}}
        <tr>
            <td colspan="{{ $colCount }}" class="section-title"
                style="text-align:center; font-size:16px; font-weight:bold;">
                اطلاعات اساسی مظنون
            </td>
        </tr>

        <tr>
            <th style="font-size:16px;">نام</th>
            <th style="font-size:16px;">نام پدر</th>
            <th style="font-size:16px;">نام پدرکلان</th>

            @if ($suspect->gender === 'ښځینه')
                <th style="font-size:16px;">تعداد اطفال</th>
            @endif

            <th style="font-size:16px;">نوع جرم</th>
            <th style="font-size:16px;">مرجع اعزامی</th>
            <th style="font-size:16px;">تاریخ نظارت</th>
            <th style="font-size:16px;">وضعیت مظنون</th>
        </tr>

        <tr>
            <td>{{ $suspect->suspect_name }}</td>
            <td>{{ $suspect->father_name }}</td>
            <td>{{ $suspect->grandfather_name }}</td>

            @if ($suspect->gender === 'ښځینه')
                <td>{{ $suspect->children_with_mother ?? 0 }}</td>
            @endif

            <td>{{ $suspect->crime_type }}</td>
            <td>{{ $suspect->referring_authority }}</td>
            
            <td>{{ $suspect->monitoring_date }}</td>
            <td>
                @if ($suspect->status === 'prisoner')
                    در نظارت خانه است
                    
                @else
                    {{ $suspect->status ?? '-' }}
                @endif
            </td>
        </tr>

        {{-- ================= LOCATION ================= --}}
        <tr>
            <td colspan="{{ $colCount }}" class="section-title"
                style="text-align:center; font-size:16px; font-weight:bold;">
                محل سکونت و نظارت
            </td>
        </tr>

        <tr>
            <th style="font-size:16px;"  colspan="{{ floor($colCount / 4) }}">ولایت</th>
            <th style="font-size:16px;" colspan="{{ floor($colCount / 4) }}">ناحیه</th>
            <th style="font-size:16px;" colspan="{{ floor($colCount / 4) }}">منطقه</th>
            <th style="font-size:16px;" colspan="{{ $colCount - floor($colCount / 4) * 3 }}">تاریخ نظارت</th>
        </tr>

        <tr>
            <td colspan="{{ floor($colCount / 4) }}">{{ $suspect->provinceRelation->name_da ?? '-' }}</td>
            <td colspan="{{ floor($colCount / 4) }}">{{ $suspect->district }}</td>
            <td colspan="{{ floor($colCount / 4) }}">{{ $suspect->area }}</td>
            <td colspan="{{ $colCount - floor($colCount / 4) * 3 }}">{{ $suspect->monitoring_date }}</td>
        </tr>

        {{-- ================= NOTES ================= --}}
        @if (!empty($suspect->notes) && trim($suspect->notes) !== '0')
            <tr>
                <td colspan="{{ $colCount }}" class="section-title"
                    style="text-align:center; font-size:16px; font-weight:bold;">
                   د وسایلو تفصیل / ملاحظات
                </td>
            </tr>

            <tr>
                <td colspan="{{ $colCount }}" class="text-right"
                    style="white-space:pre-wrap; font-size:18px; line-height:1.6;">
                    {{ $suspect->notes }}
                </td>
            </tr>
        @endif

        {{-- ================= FOOTER ================= --}}
        <tr class="no-border">
            <td colspan="{{ $colCount }}" style="text-align:right; font-size:16px;">
                قرار شرح فوق جدول ترتیب و صحت است
            </td>
        </tr>

        <tr class="no-border">
            <td colspan="{{ $colCount }}" style="text-align:center; padding-top:16px; font-size:14px;">
                آمر نظارت خانه
            </td>
        </tr>

    </table>

</body>

</html>
