@extends('layouts.master')

@section('content')
    {{-- <link rel="stylesheet" href="{{ asset('assets/persian-date/persian-datepicker.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('perisanDatePicker/css/persianDatepicker-default.css') }}" />

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
                        <select name="province_id" class="form-select" data-control="" data-placeholder="انتخاب کنید">
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
            // --- Initialize Persian Datepicker ---
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

            // --- Auto reset form on page load ---
            $('#generalReportForm')[0].reset();
        });
    </script>
@endsection
