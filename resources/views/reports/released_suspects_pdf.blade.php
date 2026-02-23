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

        #table th,
        #table td {
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
            padding: 4px;
            font-size: 11px;
            line-height: 1.5;
        }

        #table thead th {
            font-weight: bold;
            background-color: #f2f2f2;
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
            <td style="text-align:center; font-size:110%; line-height:1.8;">

                @php
                    $gender = request('gender');
                    $mainOption = request('main_option_key');
                @endphp

                {{-- ================== DETENTION MODE ================== --}}
                @if ($mainOption === 'detention')

                    جدول شهرت مظنونین طبقه

                    @if ($gender === 'ښځینه')
                        اناثیه
                    @elseif($gender === 'نارینه')
                        ذکور
                    @else
                        عمومي ذکور و اناث
                    @endif

                    که سجل توقیفی ایشان از مراجع مختلف این اداره مواصلت کرده است
                    انتقال آن به توقیف ولایت کابل

                   

                    مورخ: {{ $shamsiDate }} هـ ش
                     &nbsp;  &nbsp;
                    مطابق: {{ $qamariDate }} هـ ق

                    {{-- ================== NORMAL MODE ================== --}}
                @else
                    جدول شهرت

                    @if ($gender === 'ښځینه')
                        مظنونین طبقه اناثیه
                    @elseif($gender === 'نارینه')
                        مظنونین ذکور
                    @else
                        مظنونین عمومي ذکور و اناث
                    @endif

                  

                    آمریت نظارت خانه قومندانی امنیه ولایت کابل

                    

                    مورخ: {{ $shamsiDate }} هـ ش
                   
                    مطابق: {{ $qamariDate }} هـ ق

                @endif

            </td>
        </tr>
    </table>



    {{-- TABLE --}}
    <table id="table" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th rowspan="2" style="font-size:15px;">شماره</th>
                <th colspan="3" style="font-size:17px;">شهرت مظنون</th>

                @if (request('gender') === 'ښځینه')
                    <th rowspan="2">تعداد اطفال</th>
                @endif
                <th colspan="3" style="font-size:17px;">سکونت اصلی</th>

                <th rowspan="2" style="font-size:15px;">نوع جرم</th>
                <th rowspan="2" style="font-size:15px;">مرجع اعزامی</th>
                <th rowspan="2" style="font-size:15px;">تاریخ نظارت</th>
                <th rowspan="2" style="font-size:15px;">شماره صادره</th>
                <th rowspan="2" style="font-size:15px;">مرجع رها کننده</th>
                <th rowspan="2" style="font-size:15px;">تاریخ رهایی</th>
            </tr>

            <tr>
                {{-- Identity --}}
                <th style="font-size:15px;">نام مظنون</th>
                <th style="font-size:15px;">نام پدر</th>
                <th style="font-size:15px;">نام پدر کلان</th>

                {{-- Residence --}}
                <th style="font-size:15px;">ولایت</th>
                <th style="font-size:15px;">ناحیه</th>
                <th style="font-size:15px;">منطقه</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($suspects as $index => $suspect)
                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td>{{ $suspect->suspect_name ?? '-' }}</td>
                    <td>{{ $suspect->father_name ?? '-' }}</td>
                    <td>{{ $suspect->grandfather_name ?? '-' }}</td>

                    @if (request('gender') === 'ښځینه')
                        <td>{{ $suspect->children_with_mother ?? '-' }}</td>
                    @endif

                    <td>{{ $suspect->provinceRelation->name_da ?? '---' }}</td>
                    <td>{{ $suspect->district ?? '-' }}</td>
                    <td>{{ $suspect->area ?? '-' }}</td>

                    <td>{{ $suspect->crime_type ?? '-' }}</td>
                    <td>{{ $suspect->referring_authority ?? '-' }}</td>


                    <td>{{ $suspect->monitoring_date_dari ?? '-' }}</td>


                    <td>{{ $suspect->release->issued_or_transferred_number ?? '---' }}</td>

                    <td>
                        @php
                            $map = [
                                'detention' => 'انتقال به توقیف',
                                'multi' => 'انتقال به مراجع مختلف',
                                'release' => 'مظنونین رهایی',
                            ];

                            $finalSource = '---';

                            if ($suspect->release) {
                                if (!empty($suspect->release->db_source_name)) {
                                    $finalSource = $suspect->release->db_source_name;
                                } elseif (!empty($suspect->release->main_option_key)) {
                                    $finalSource = $map[$suspect->release->main_option_key] ?? '---';
                                }
                            }
                        @endphp

                        {{ $finalSource }}
                    </td>

                    <td>{{ $suspect->release->release_date_dari ?? '---' }}</td>

                </tr>
            @empty
                <tr>
                    <td colspan="14" style="font-weight:bold">
                        هیڅ معلومات شتون نلري
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table style="width:100%; margin-top:6px;">
        <tr>
            <td style="font-weight:bold; font-size:16px;">قرار شرح فوق جدول هذا ترتیب وصحت است</td>
        </tr>
        <tr>
            <td style="text-align:center; font-size:14px; padding-top:6px;">

                <br>
                آمر نظارت خانه
            </td>
        </tr>
        <tr>
            <td style="text-align:right; font-size:14px; padding-top:6px;">

                <br>
                ترتیب کننده:
                <br><br>

                مسؤل اداری نظارت خانه
            </td>
        </tr>
    </table>


</body>

</html>
