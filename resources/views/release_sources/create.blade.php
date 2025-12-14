@extends('layouts.master')

@section('content')
<div class="card shadow-sm">

    <!-- Header -->
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">نوې مرجع اضافه کړئ</h4>

        <a href="{{ route('release-sources.index') }}" class="btn btn-primary btn-sm">
            لیست ته بیرته لاړ شئ
        </a>

        <style>
            .form-label {
                font-weight: 600;
                color: #333;
            }

            .form-control {
                border-radius: 6px !important;
                padding: 10px !important;
            }

            .card {
                border-radius: 10px;
            }

            .card-header {
                background: #f1fbff !important;
                border-bottom: 1px solid #d7f3ff;
            }

            .form-section-title {
                font-size: 16px;
                font-weight: bold;
                margin-bottom: 15px;
                color: #007bff;
                border-left: 4px solid #0dcaf0;
                padding-left: 8px;
            }

            .btn-save {
                padding: 8px 20px;
                border-radius: 6px;
                font-weight: 600;
            }
        </style>
    </div>

    <!-- FORM -->
    <form action="{{ route('release-sources.store') }}" method="POST">
        @csrf

        <div class="card-body">

           

            <div class="row">

                <!-- Name in Dari -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">نوم (په دری)</label>
                    <input type="text" name="name_da" class="form-control" required>
                </div>

                <!-- Name in Pashto -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">نوم (په پښتو)</label>
                    <input type="text" name="name_pa" class="form-control">
                </div>

            </div>

        </div>

        <!-- Footer -->
        <div class="card-footer text-end">
            <button class="btn btn-primary btn-save">ثبت</button>
        </div>
    </form>
</div>
@endsection
