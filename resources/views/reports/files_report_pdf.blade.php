<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin: 25px;
        }

        @font-face {
            font-family: 'bahijfont';
            src: url('{{ public_path('assets/fonts/bahij-nazanin.ttf') }}') format('truetype');
        }

        body {
            font-family: 'bahijfont', sans-serif;
            direction: rtl;
            margin: 0;
        }

        .page {
            page-break-after: always;
        }

        .header-table {
            border: 2px solid #000;
            padding: 5px;
            margin-bottom: 10px;
        }

        .info-box {
            text-align: center;
            padding: 8px;
            margin-bottom: 10px;
            font-size: 14px;
            line-height: 1.8;
        }

        .image-box {
            text-align: center;
        }

        .file-img {
            width: 90%;
            height: 800px;
            object-fit: contain;
        }

        .empty {
            text-align: center;
            margin-top: 100px;
            font-size: 18px;
        }
    </style>
</head>

<body>

    @if ($files->count() > 0)

        @foreach ($files as $file)
            @php
                $suspectName = $file->suspect->suspect_name ?? '-';
            @endphp

            <div class="page">

                {{-- HEADER --}}
                <table width="100%">
                    <tr>
                        <td style="text-align:left">
                            <img src="{{ public_path('assets/moi.png') }}" width="100">
                        </td>

                        <td style="text-align:center; font-size:14px;">
                            <p>امـــــــــارت اســـــلامی افغــــانــستان</p>
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

                {{-- INFO --}}
                <div class="info-box">

                    <div><strong>مظنون نوم :</strong> {{ $suspectName }}</div>

                    <div>
                        <strong> فایل ډول:</strong>
                        @if ($file->file_type == 'suspect')
                            د مظنون د نظارت فایل
                        @else
                            د مظنون د رهایی فایل
                        @endif
                    </div>

                </div>

                {{-- IMAGE --}}
                <div class="image-box">

                    @if ($file->file_path)
                        <img src="{{ public_path($file->file_path) }}" class="file-img">
                    @else
                        ---
                    @endif

                </div>

            </div>
        @endforeach
    @else
        <div class="empty">
            هیڅ فایل موجود نه دی
        </div>

    @endif

</body>

</html>
