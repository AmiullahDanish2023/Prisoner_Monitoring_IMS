@extends('layouts.master')

@section('content')
    {{-- <link rel="stylesheet" href="{{ asset('perisanDatePicker/css/persianDatepicker-default.css') }}" /> --}}
    <style>
        .form-select,
        .form-control {
            min-height: 38px;
        }

        .form-label {
            display: block;
            min-height: 24px;
        }

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
        <div class="card-body" style="font-weight: bold ">

            <form method="GET" id="monthlyReportForm" action="{{ route('reports.monthly.pdf') }}" target="_blank"
                method="POST" class="p-4 rounded shadow" style="background: #fdfdfd; border: 1px solid #fdfdfd;"
                autocomplete="off">
                @csrf

                <p class="text-primary text-center" style="font-size: 1.6rem; font-weight:bold">
                    د تاریخ په اساس د مظنونینو میاشتنی او ورځنی راپور جوړول
                </p>
                <hr>

                <div class="row justify-content-center align-items-end g-3">

                    <div class="col-md-3">
                        <label class="form-label">تاریخ شروع</label>
                        <input type="text" name="start_date" class="form-control farsi-date "
                            placeholder="تاریخ شروع  انتخاب کړیً">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">تاریخ ختم</label>
                        <input type="text" name="end_date" class="form-control farsi-date"
                            placeholder="تاریخ ختم  انتخاب کړیً">
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



            // reset form
            $('#monthlyReportForm')[0].reset();
        });
    </script>
@endsection
