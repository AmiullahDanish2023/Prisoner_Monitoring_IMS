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
            background: #f2f2f2;
            font-weight: bold;
        }

        .no-border td {
            border: none;
        }

        .section-title {
            background: #e8eef5;
            font-weight: bold;
            text-align: center;
            font-size: 16px;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>

    {{-- ================= HEADER ================= --}}
    <table class="no-border" style="margin-bottom:10px;">
        <tr>
            <td style="text-align:left">
                <img src="{{ public_path('assets/moi.png') }}" width="90">
            </td>

           <td style="font-size:120%; text-align:center; line-height:1.3;">
                <p>امـــــارت اســـــلامی افغــــانــستان</p>
                <p>وزارت امــــــــــور داخـــــــــلــــه</p>
                <p>معینیت ارشد امــــور امنیتــی</p>
                <p>قومنـدانی امنیه ولایت کابل</p>
                <p>معاونیت امــور امنیتی</p>
                <p>آمریت نظارت خانه</p>
            </td>

            <td style="text-align:right">
                <img src="{{ public_path('assets/logo.png') }}" width="80">
            </td>
        </tr>
    </table>

    <table>

        {{-- ================= BASIC INFO ================= --}}
        <tr>
            <td colspan="4" class="section-title">معلومات اساسی مظنون</td>
        </tr>

        <tr>
            <th style="font-size:16px;">نوم</th>
            <th style="font-size: 16px;">د پلار نوم</th>
            <th style="font-size:16px;">د نیکه نوم</th>
            <th style="font-size:16px;">وضعیت مظنون</th>
        </tr>

        <tr>
            <td>{{ $suspect->suspect_name }}</td>
            <td>{{ $suspect->father_name }}</td>
            <td>{{ $suspect->grandfather_name }}</td>
            <td>
                @if ($suspect->status === 'prisoner')
                    در نظارت خانه است
                @elseif ($suspect->status === 'released')
                    رها شده است
                    
                @else
                    {{ $suspect->status ?? '-' }}
                @endif
            </td>
        </tr>

        <tr>
            <th style="font-size:16px;">جرم</th>
            <th style="font-size:16px;">مرجع معرفی</th>
            <th style="font-size:16px;" colspan="2">د نظارت نیټه</th>
        </tr>

        <tr>
            <td>{{ $suspect->crime_type }}</td>
            <td>{{ $suspect->referring_authority }}</td>
            <td colspan="2">{{ $suspect->monitoring_date }}</td>
        </tr>

        {{-- ================= RELEASE INFO ================= --}}
        <tr>
            <td colspan="4" class="section-title">د رهایی / انتقال معلومات</td>
        </tr>

        <tr>
            <th style="font-size:16px;">شماره صادره</th>
            <th style="font-size:16px;">مرجع رها کننده</th>
            <th style="font-size:16px;">تاریخ انتقال </th>
            <th style="font-size:16px;">وسایلو حالت</th>
        </tr>

        <tr>
            <td>{{ $suspect->release->issued_or_transferred_number ?? '-' }}</td>

            <td>
                @php
                    $map = [
                        'detention' => 'انتقال به توقیف',
                        'multi' => 'انتقال به مراجع مختلف',
                        'release' => 'مظنون رهایی',
                    ];
                @endphp
                {{ $suspect->release->db_source_name ?? ($map[$suspect->release->main_option_key] ?? '-') }}
            </td>

            <td>{{ $suspect->release->release_date ?? '-' }}</td>

            <td style="font-weight:bold;">
                @if ($suspect->release?->items_status === 'not_confiscated')
                    مظنون ته وسایل ندي تسلیم شوي
                @elseif($suspect->release?->items_status === 'confiscated')
                    مظنون ته وسایل تسلیم شوي
                @else
                    ---
                @endif
            </td>
        </tr>

        {{-- ================= NOTES ================= --}}
        @if (!empty($suspect->notes))
            <tr>
                <td colspan="4" class="section-title">د وسایلو تفصیل / ملاحظات</td>
            </tr>

            <tr>
                <td colspan="4" class="text-right" style="white-space:pre-wrap; font-size:15px; line-height:1.7;">
                    {{ $suspect->notes }}
                </td>
            </tr>
        @endif

        {{-- ================= FOOTER ================= --}}
        <tr class="no-border">
            <td colspan="4" class="text-right" style="padding-top:20px;">
                قرار شرح فوق جدول ترتیب و صحت است
            </td>
        </tr>

        <tr class="no-border">
            <td colspan="4" style="text-align:center; padding-top:15px;">
                آمر نظارت خانه
            </td>
        </tr>

    </table>

</body>

</html>
