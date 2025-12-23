<!DOCTYPE html>
<html lang="fa" dir="rtl" style="direction: rtl;">

<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 10px;
        }

        @font-face {
            font-family: 'bahijfont';
            src: url('{{ public_path('assets/fonts/bahij.ttf') }}') format('truetype');
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
                <img src="{{ public_path('assets/moi.png') }}" width="90">
            </td>

            <td style="text-align:center">
                <p class="header-label">امارت اسلامی افغانستان</p>
                <p class="header-label">وزارت امور داخله</p>
                <p class="header-label">معینیت ارشد امور امنیتی</p>
                <p class="header-label">د کابل ولایت امنیه قومندانۍ</p>
                <p class="header-label">د کابل امنیتي چارو مرستیال</p>
                <p class="header-label">د نظارت خونې آمریت</p>
            </td>

            <td style="text-align:right">
                <img src="{{ public_path('assets/logo.png') }}" width="90">
            </td>
        </tr>
    </table>

    {{-- REPORT INFO --}}
    <div class="report-info">
        <p>
            <strong>ولایت:</strong>
            {{ $province?->name_da ?? 'همه ولایات' }}
        </p>

        <p>
            <strong>تاریخ شروع:</strong>
            {{ $start ? $start->format('Y-m-d') : 'نامحدود' }}
        </p>

        <p>
            <strong>تاریخ ختم:</strong>
            {{ $end ? $end->format('Y-m-d') : 'نامحدود' }}
        </p>

        <p>
            <strong>تعداد مظنونین:</strong>
            {{ $suspects->count() }}
        </p>
    </div>

    {{-- TABLE --}}
    <table id="table">
        <thead>
            <tr>
                <th>شماره</th>
                <th>نام مظنون</th>
                <th>نام پدر</th>
                <th>جنسیت</th>
                <th>تاریخ نظارت</th>
                <th>ولایت</th>
                <th>ناحیه / ولسوالی</th>
                <th>آدرس</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($suspects as $index => $suspect)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $suspect->suspect_name ?? '-' }}</td>
                    <td>{{ $suspect->father_name ?? '-' }}</td>
                    <td>{{ $suspect->gender ?? '-' }}</td>
                    <td>{{ $suspect->monitoring_date ?? '-' }}</td>
                    <td>{{ $suspect->province_name ?? '-' }}</td>
                    <td>{{ $suspect->district ?? '-' }}</td>
                    <td>{{ $suspect->area ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="font-weight:bold">
                        هیڅ معلومات شتون نلري
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>
