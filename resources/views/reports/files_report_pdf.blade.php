{{-- <style>
    #table {
        border-collapse: collapse;
        width: 100%;
        font-family: sans-serif;
    }

    #table thead th {
        border: 2px solid #000;
        padding: 8px;
        text-align: center;
        font-size: 14px;
        background: #f2f2f2;
    }

    #table tbody td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
        vertical-align: middle;
        font-size: 13px;
    }

    .file-img {
        width: 220px;
        height: auto;
        border: 1px solid #333;
        padding: 4px;
    }

    .file-box {
        text-align: center;
    }
</style> --}}

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
<table id="table">

    <thead>

        <tr>

            <th style="width:60px; font-size: 160% ;">شماره</th>
            <th style="width:80px; font-size: 130%">نام مظنون</th>
            <th style="width:150px; font-size: 160%">نوع فایل</th>
            <th style="font-size: 160%">فایل</th>

        </tr>

    </thead>


    <tbody>

        @foreach ($files as $index => $file)
            <tr>

                <td >{{ $index + 1 }}</td>

                <td>
                    {{ $file->suspect->suspect_name ?? '-' }}
                </td>

                <td>

                    @if ($file->file_type == 'suspect')
                       د مظنون د معرفی فایل 
                    @else
                       د مظنون د رهایی  فایل
                    @endif

                </td>

                <td class="file-box">

                    @if ($file->file_path)
                        <img src="{{ public_path($file->file_path) }}" class="file-img">
                    @else
                        ---
                    @endif

                </td>

            </tr>
        @endforeach

    </tbody>

</table>
