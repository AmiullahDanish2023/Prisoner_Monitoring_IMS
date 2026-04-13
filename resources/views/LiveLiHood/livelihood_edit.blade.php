@extends('layouts.master')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/persian-date/persian-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('perisanDatePicker/css/persianDatepicker-default.css') }}" />

    <style>
        .section-title {
            color: #050b13;
            border-bottom: 4px solid #e1eeff;
        }
    </style>

    <div class="card shadow-sm">

        <div class="card-header fw-bold fs-4 d-flex justify-content-center align-items-center text-center"
            style="height:100px;">
            ویرایش فورم پلان مواد غذایی بدل اعاشه
        </div>


        <div class="card-body">

            <form action="{{ route('livelihood.update', $livelihood->id) }}" method="POST" id="livelihoodForm">
                @csrf
                @method('PUT')

                <!-- keep month for redirect -->
                <input type="hidden" name="month" value="{{ $month }}">

                {{-- ================== معلومات عمومی ================== --}}
                <h5 class="fw-bolder pb-2 mb-3 section-title">معلومات عمومی</h5>

                <div class="row row-cols-1 row-cols-md-3 g-3 mb-4">

                    <div class="col">
                        <label class="form-label">تاریخ</label>
                        <input type="text" name="livelihoodDate" class="form-control farsi-date"
                            value="{{ old('livelihoodDate', $livelihood->livelihoodDate) }}">
                    </div>

                    <div class="col">
                        <label class="form-label">روز هفته</label>
                        <select name="week_day_id" class="form-select">
                            @foreach ($weekDays as $day)
                                <option value="{{ $day->id }}"
                                    {{ $day->id == $livelihood->week_day_id ? 'selected' : '' }}>
                                    {{ $day->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <label class="form-label">مبلغ (افغانی)</label>
                        <input type="number" name="amount" class="form-control"
                            value="{{ old('amount', $livelihood->amount) }}">
                    </div>

                </div>

                {{-- ================== حبوبات و مواد اولیه ================== --}}
                <h5 class="fw-bold pb-2 mb-3 section-title">حبوبات و مواد اولیه</h5>

                @php
                    $foodFields = [
                        'rice' => 'برنج سیله (کیلوگرام)',
                        'sugar' => 'بوره میده (کیلوگرام)',
                        'green_tea' => 'چای سبز (گرام)',
                        'beans' => 'لوبیا (کیلوگرام)',
                        'chickpeas' => 'نخود خام (کیلوگرام)',
                    ];
                @endphp

                <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5 g-3 mb-4">
                    @foreach ($foodFields as $name => $label)
                        <div class="col">
                            <label class="form-label">{{ $label }}</label>
                            <input type="number" step="0.001" name="{{ $name }}" class="form-control"
                                value="{{ old($name, $livelihood->$name ?? 0) }}">
                        </div>
                    @endforeach
                </div>

                {{-- ================== لبنیات، پروتئین و گوشت ================== --}}
                <h5 class="fw-bolder pb-2 mb-3 section-title">لبنیات، پروتئین و گوشت</h5>

                @php
                    $proteinFields = [
                        'milk_powder' => 'شیرخشک (کیلوگرام)',
                        'eggs' => 'تخم مرغ (عدد)',
                        'oil' => 'روغن مایع (کیلوگرام)',
                        'mutton' => 'گوشت گوسفند (کیلوگرام)',
                        'chicken' => 'گوشت مرغ (کیلوگرام)',
                        'beef' => 'گوشت گاو (کیلوگرام)',
                        'cake' => 'کیک (کیلوگرام)',
                        'yogurt_drink' => 'دوغ (کیلوگرام)',
                        'dates' => 'خرما (کیلوگرام)',
                        'sweets' => 'شیرینی (کیلوگرام)',
                    ];
                @endphp

                <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5 g-3 mb-4">
                    @foreach ($proteinFields as $name => $label)
                        <div class="col">
                            <label class="form-label">{{ $label }}</label>
                            <input type="number" step="0.001" name="{{ $name }}" class="form-control"
                                value="{{ old($name, $livelihood->$name ?? 0) }}">
                        </div>
                    @endforeach
                </div>

                {{-- ================== سبزیجات ================== --}}
                <h5 class="fw-bolder pb-2 mb-3 section-title">سبزیجات</h5>

                @php
                    $vegFields = [
                        'eggplant' => 'بانجان سیاه (کیلوگرام)',
                        'zucchini' => 'کدوک (کیلوگرام)',
                        'potato' => 'کچالو (کیلوگرام)',
                        'potato_cooked' => 'کچالو جوشک (کیلوگرام)',
                        'fasila' => 'فاصیله (کیلوگرام)',
                        'onion' => 'پیاز (کیلوگرام)',
                        'tomato' => 'رومی تازه (کیلوگرام)',
                        'cucumber' => 'بادرنگ (کیلوگرام)',
                        'salad' => 'سلات مکس (کیلوگرام)',
                        'lemon' => 'لیمو (کیلوگرام)',
                    ];
                @endphp

                <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5 g-3 mb-4">
                    @foreach ($vegFields as $name => $label)
                        <div class="col">
                            <label class="form-label">{{ $label }}</label>
                            <input type="number" step="0.001" name="{{ $name }}" class="form-control"
                                value="{{ old($name, $livelihood->$name ?? 0) }}">
                        </div>
                    @endforeach
                </div>

                {{-- ================== مواد متفرقه ================== --}}
                <h5 class="fw-bold pb-2 mb-3 section-title">مواد متفرقه</h5>

                @php
                    $miscFields = [
                        'salt' => 'نمک (کیلوگرام)',
                        'raisin_rice' => 'کشمش پلو (کیلوگرام)',
                        'dry_bread' => 'نان خشک (کیلوگرام)',
                        'spice_pot' => 'مساله دیگ (گرام)',
                        'gas' => 'گاز مایع (کیلوگرام)',
                    ];
                @endphp

                <div class="row row-cols-1 row-cols-md-3 row-cols-xl-5 g-3 mb-4">
                    @foreach ($miscFields as $name => $label)
                        <div class="col">
                            <label class="form-label">{{ $label }}</label>
                            <input type="number" step="0.001" name="{{ $name }}" class="form-control"
                                value="{{ old($name, $livelihood->$name ?? 0) }}">
                        </div>
                    @endforeach
                </div>

                {{-- ================== Submit ================== --}}
                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-success px-5 fw-bold">
                        تغییراتو ذخیره کول
                    </button>

                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        بازگشت
                    </a>
                </div>

            </form>

        </div>
    </div>
@endsection

@section('scripts')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="{{ asset('perisanDatePicker/js/persianDatepicker.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('perisanDatePicker/js/persianDatepicker.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>



    <script>
        $('.farsi-date').persianDatepicker({
            format: 'YYYY/MM/DD',
            autoClose: true,
            initialValue: false
        });
    </script>
<script>
$('#livelihoodForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('livelihood.update', $livelihood->id) }}",
        type: "POST",
        data: $(this).serialize(),
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'موفقانه!',
                text: response.message,
                confirmButtonText: 'باشه'
            });
            
            setTimeout(function() {
                window.location.href = "{{ route('livelihood.month.details', $month) }}";
            }, 1500);
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'خطا!',
                text: 'ذخیره انجام نشد'
            });
        }
    });
});
</script>

@endsection
