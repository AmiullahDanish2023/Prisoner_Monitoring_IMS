@extends('layouts.master')

@section('content')
    {{-- <link rel="stylesheet" href="{{ asset('assets/persian-date/persian-datepicker.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('perisanDatePicker/css/persianDatepicker-default.css') }}" />
    <style>
        .select2-results__options {
            max-height: 200px !important;

            overflow-y: auto !important;

        }

        .select2-dropdown {
            border: 1px solid #ced4da !important;
            border-radius: 6px !important;
        }

        .select2-dropdown {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .select2-results__options::-webkit-scrollbar {
            width: 6px;
        }

        .select2-results__options::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 5px;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-selection--single {
            height: 38px !important;
            display: flex !important;
            align-items: center !important;
        }

        .select2-selection__rendered {
            width: 100% !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da;
            border-radius: 6px;
        }
    </style>

    <div class="card">
        <div class="card-body" style="font-weight: bold">
            <form id="generalReportForm" action="{{ route('report.general.pdf') }}" method="POST" class="p-4 rounded shadow"
                style="background: #f8f8f8; border: 1px solid #e9ebee;">
                @csrf

                <p class="text-primary text-center" style="font-size: 1.6rem; font-weight:bold">
                    راپور عمومی مظنونین
                </p>
                <hr>

                <div class="row">
                    <!-- جنسیت -->
                    <div class="col-md-3">
                        <label class="form-label">جنسیت</label>
                        <select name="gender" class="form-select">
                            <option value=""> انتخاب جنسیت </option>
                            <option value="نارینه">نارینه</option>
                            <option value="ښځینه">ښځینه</option>
                        </select>
                    </div>


                    <!-- ولایت -->
                    <div class="col-md-3">
                        <label class="form-label">ولایت</label>
                        <select name="province_id" id="province_id" class="form-select" style="width:100%"
                            data-placeholder="انتخاب کنید">
                            <option value="">انتخاب ولایت</option>
                            @foreach ($province as $pro)
                                <option value="{{ $pro->id }}">{{ $pro->name_da }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- تاریخ شروع -->
                    <div class="col-md-3">
                        <label class="form-label">تاریخ شروع</label>
                        <input type="text" name="start_date" class="form-control farsi-date" placeholder="از تاریخ"
                            autocomplete="off" value="">
                    </div>

                    <!-- تاریخ ختم -->
                    <div class="col-md-3">
                        <label class="form-label">تاریخ ختم</label>
                        <input type="text" name="end_date" class="form-control farsi-date" placeholder="تا تاریخ"
                            autocomplete="off" value="">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">رالیږونکې مرجع</label>

                    <select name="referrer" id="referrer" class="form-select" style="width:100%">
                        <option value="">انتخاب رالیږونکې مرجع</option>

                        @foreach ($referrer as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>

                    @if (isset($selectedReferrer) && $selectedReferrer)
                        <small class="text-success">
                            انتخاب شوی: {{ $selectedReferrer }}
                        </small>
                    @endif
                </div>

                <br>

                <div class="text-end">
                    <button type="submit" class="btn btn-success btn-sm">
                        راپور جوړول
                    </button>

                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('perisanDatePicker/js/persianDatepicker.js') }}"></script>


    <script>
        $(document).ready(function() {

            // Persian datepicker
            $('.farsi-date').persianDatepicker({
                format: 'YYYY/MM/DD',
                initialValue: false,
                autoClose: true,
                calendar: {
                    persian: {
                        locale: 'fa'
                    }
                }
            });

            $('#referrer').select2({
                placeholder: 'مرجع انتخاب یا اضافه کړئ',
                tags: true, // 👈 allow new
                allowClear: true,
                width: '100%'
            });

            // ✅ Province Select2
            $('#province_id').select2({
                placeholder: 'انتخاب ولایت',
                allowClear: true,
                width: '100%'
            });

            // ✅ Referrer Select2
            $('#referrer').select2({
                placeholder: 'انتخاب رالیږونکې مرجع',
                allowClear: true,
                width: '100%'
            });

            // reset form
            $('#generalReportForm')[0].reset();
        });
    </script>
@endsection
