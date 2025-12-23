@extends('layouts.master')
@section('content')
@section('header-menu')

@endsection

@section('content')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('perisanDatePicker/css/persianDatepicker-default.css') }}" />

    <div class="card">
        <div class="card-body" style="font-weight: bold">
            <form action="{{ route('report.general.pdf') }}" method="POST" class="p-4 rounded shadow"
                style="background: #f8f8f8; border: 1px solid #e9ebee;">
                @csrf

                <p class="text-primary m-0 text-center" style="font-size: 1.6rem; font-weight:bold">
                    راپور عمومی مظنونین
                </p>
                <hr>

                <div class="row">

                    <!-- ولایت -->
                    <div class="col-md-3">
                        <label for="province_id" class="form-label">ولایت</label>
                        <select name="province_id" id="province_id" class="form-control select2" required>
                            <option selected disabled>ولایت انتخاب کړئ</option>
                            @foreach ($province as $prov)
                                <option value="{{ $prov->id }}">{{ $prov->name_da }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- تاریخ شروع -->
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">تاریخ شروع</label>
                        <input type="date" name="start_date" id="start_date" class="form-control farsi-date-picker"
                            placeholder="از تاریخ" autocomplete="off" required>
                    </div>

                    <!-- تاریخ ختم -->
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">تاریخ ختم</label>
                        <input type="date" name="end_date" id="end_date" class="form-control farsi-date-picker"
                            placeholder="تا تاریخ" autocomplete="off" required>
                    </div>

                </div>

                <br>

                <div class="modal-footer d-flex justify-content-between">
                    <div class="row" style="float: left;">
                        <button type="submit" id="submitBtn"
                            class="btn btn-success btn-sm">
                             راپور جوړول
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('perisanDatePicker/js/persianDatepicker.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Farsi date picker
            $(".farsi-date-picker").persianDatepicker({
                format: "YYYY/MM/DD",
                autoClose: true,
                initialValue: false,
            });

            // Form validation
            document.querySelector('form').addEventListener('submit', function(e) {
                let start = document.getElementById('start_date');
                let end = document.getElementById('end_date');
                if (!start.value || !end.value) {
                    e.preventDefault();
                    alert('لطفاً هر دو تاریخ شروع و ختم را انتخاب کنید.');
                }
            });
        });
    </script>
@endsection
