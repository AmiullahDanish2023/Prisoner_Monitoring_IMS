@extends('layouts.master')

@section('content')
    <div class="container mt-4">

        <div class="card shadow-sm">

            <div class="card-header bg-light d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    د مظنون فایلونه
                    <span class="text-muted">({{ $suspect->suspect_name }})</span>
                </h5>

                @if ($suspect->files()->where('file_type', 'suspect')->count() > 0)
                    <button onclick="printImages()" class="btn btn-sm btn-dark" title="✅ Print Preview ټول عکسونه">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path d="M2 7V2h12v5" />
                            <path d="M2 10h12v4H2z" />
                            <path d="M4 12h8v1H4z" />
                        </svg>
                        Print Preview
                    </button>
                @endif

            </div>

            <div class="card-body">

                @php
                    $suspectFiles = $suspect->files()->where('file_type', 'suspect')->get();
                @endphp

                @if ($suspectFiles->count() > 0)
                    <div class="row">
                        @foreach ($suspectFiles as $file)
                            @php
                                $extension = strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION));
                                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                $isPdf = $extension == 'pdf';
                            @endphp

                            <div class="col-md-3 mb-4">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body text-center">

                                        {{-- IMAGE --}}
                                        @if ($isImage)
                                            <img src="{{ asset($file->file_path) }}" class="img-fluid mb-2"
                                                style="height:120px; object-fit:cover;">
                                        @elseif($isPdf)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                                viewBox="0 0 24 24" fill="#dc3545">
                                                <path d="M6 2h9l5 5v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" />
                                                <text x="7" y="17" font-size="8" fill="white">PDF</text>
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                                viewBox="0 0 24 24" fill="#6c757d">
                                                <path d="M6 2h9l5 5v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" />
                                            </svg>
                                        @endif

                                        <p class="small text-muted mt-2">{{ basename($file->file_path) }}</p>

                                        <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">

                                            {{-- VIEW --}}
                                            <a href="{{ asset($file->file_path) }}" target="_blank" title="View File"
                                                class="btn btn-primary btn-sm p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="white">
                                                    <path
                                                        d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7zm0 11a4 4 0 1 1 0-8 4 4 0 0 1 0 8z" />
                                                </svg>
                                            </a>

                                            {{-- DOWNLOAD --}}
                                            <a href="{{ asset($file->file_path) }}" download title="Download File"
                                                class="btn btn-success btn-sm p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="white">
                                                    <path d="M12 16l4-5h-3V4h-2v7H8l4 5z" />
                                                    <path d="M5 20h14v-2H5v2z" />
                                                </svg>
                                            </a>

                                            {{-- SINGLE PRINT --}}
                                            <button
                                                onclick="printSingle('{{ asset($file->file_path) }}','{{ $isImage ? 1 : 0 }}')"
                                                title="Print File" class="btn btn-warning btn-sm p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="black">
                                                    <path d="M6 9V2h12v7H6z" />
                                                    <path d="M6 14h12v8H6z" />
                                                    <path d="M4 9h16a2 2 0 0 1 2 2v5h-4v-3H6v3H2v-5a2 2 0 0 1 2-2z" />
                                                </svg>
                                            </button>

                                            {{-- DELETE --}}
                                            <form action="{{ route('suspects.files.delete', $file->id) }}" method="POST"
                                                onsubmit="return confirm('ایا ډاډه یی چې حذف یې کول غواړې؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Delete File"
                                                    class="btn btn-danger btn-sm p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 24 24" fill="white">
                                                        <path d="M3 6h18" />
                                                        <path d="M8 6V4h8v2" />
                                                        <path d="M19 6l-1 14H6L5 6" />
                                                    </svg>
                                                </button>
                                            </form>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted">
                        هیڅ فایل موجود نه دی
                    </div>
                @endif

            </div>

        </div>

    </div>

    <script>
        function printImages() {
            var images = [];
            @foreach ($suspectFiles as $file)
                @php $ext = strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION)); @endphp
                @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                    images.push("{{ asset($file->file_path) }}");
                @endif
            @endforeach

            var win = window.open("", "", "width=900,height=700");
            win.document.write("<html><head><title>Print Preview</title>");
            win.document.write(
                "<style>body{text-align:center;font-family:sans-serif}.grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px} img{width:100%;height:auto}@media print{body{margin:0}}</style>"
            );
            win.document.write("</head><body><div class='grid'>");
            images.forEach(function(src) {
                win.document.write("<div><img src='" + src + "'></div>");
            });
            win.document.write("</div></body></html>");
            win.document.close();
            win.print();
        }

        function printSingle(src, isImage) {
            var win = window.open('', '', 'width=900,height=700');
            win.document.write('<html><head><title>Print Preview</title>');
            win.document.write(
                '<style>body{text-align:center;font-family:sans-serif} img{max-width:100%;height:auto} iframe{width:100%;height:600px}</style>'
            );
            win.document.write('</head><body>');
            if (isImage) {
                win.document.write('<img src="' + src + '">');
            } else {
                win.document.write('<iframe src="' + src + '"></iframe>');
            }
            win.document.write('</body></html>');
            win.document.close();
            win.print();
        }
    </script>
@endsection
