@extends('layouts.master')

@section('content')
    {{-- <link rel="stylesheet" href="{{ asset('assets/persian-date/persian-datepicker.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('perisanDatePicker/css/persianDatepicker-default.css') }}" />
    <style>
        .section-title {
            color: #050b13;
            border-bottom: 4px solid #e1eeff;
        }

        .error-msg {
            color: red;
            font-size: 0.85rem;
            margin-top: 2px;
        }
    </style>

    <div class="card shadow-sm">
        <div class="card-header fw-bold fs-4 d-flex justify-content-center align-items-center text-center"
            style="height: 100px;">
            فورم پلان مواد غذایی مظنونین ذکور واناث امریت نظارت خانه قومندانی ا منیه ولایت کابل
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('livelihood.store') }}" id="livelihoodForm">
                @csrf

                {{-- ================== معلومات عمومی ================== --}}
                <h5 class="fw-bolder pb-2 mb-3 section-title">معلومات عمومی</h5>
                <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-3 mb-4">

                    <div class="col">
                        <label class="form-label">تاریخ</label>
                        <input type="text" name="livelihoodDate" class="form-control farsi-date" placeholder="تاریخ">
                        <div class="error-msg" data-error-for="livelihoodDate"></div>
                    </div>

                    <div class="col">
                        <label class="form-label">روز هفته</label>
                        <select name="week_day_id" class="form-select">
                            <option value="" selected disabled>روز هفته را انتخاب کنید</option>
                            @foreach ($weekDays as $day)
                                <option value="{{ $day->id }}">{{ $day->name }}</option>
                            @endforeach
                        </select>
                        <div class="error-msg" data-error-for="week_day_id"></div>
                    </div>

                    <div class="col">
                        <label class="form-label">مبلغ (افغانی)</label>
                        <input type="number" name="amount" class="form-control" min="0">
                        <div class="error-msg" data-error-for="amount"></div>
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
                            <input type="number" name="{{ $name }}" class="form-control" step="0.001"
                                min="0">
                            <div class="error-msg" data-error-for="{{ $name }}"></div>
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
                            <input type="number" name="{{ $name }}" class="form-control" step="0.001"
                                min="0">
                            <div class="error-msg" data-error-for="{{ $name }}"></div>
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
                            <input type="number" name="{{ $name }}" class="form-control" step="0.001"
                                min="0">
                            <div class="error-msg" data-error-for="{{ $name }}"></div>
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
                            <input type="number" name="{{ $name }}" class="form-control" step="0.001"
                                min="0">
                            <div class="error-msg" data-error-for="{{ $name }}"></div>
                        </div>
                    @endforeach
                </div>

                {{-- ================== Submit ================== --}}
                <div class="d-flex justify-content-start mt-4">
                    <button type="submit" class="btn btn-primary px-5 fw-bold">
                        ثبت معلومات
                    </button>
                </div>

            </form>


        </div>
    </div>
@endsection

@section('scripts')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('perisanDatePicker/js/persianDatepicker.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('perisanDatePicker/js/persianDatepicker.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


    <script>
        $(document).ready(function() {

            $('.farsi-date').persianDatepicker({
                format: 'YYYY/MM/DD',
                initialValue: false,
                autoClose: true,
            });

            $('#livelihoodForm').on('submit', function(e) {
                e.preventDefault();

                let form = this;
                let hasValue = false;
                let hasError = false;

                $('.error').text('');

                $(form).find('input[type="number"]').each(function() {

                    let val = $(this).val().trim();
                    let name = $(this).attr('name');

                    if (val !== '') {
                        hasValue = true;

                        
                        if (isNaN(val)) {
                            showError(name, 'لطفاً یک عدد معتبر را داخل کنید');
                            hasError = true;
                            return;
                        }

                        let num = parseFloat(val);

                        // ❌ max range
                        if (num > 999999) {
                            showError(name, 'عدد وارد شده بیش از حد مجاز است');
                            hasError = true;
                            return;
                        }

                        // ❌ decimal places > 3
                        let decimalMatch = val.match(/\.(\d+)$/);
                        if (decimalMatch && decimalMatch[1].length > 3) {
                            showError(name, 'حداکثر سه رقم اعشاری مجاز است');
                            hasError = true;
                            return false; // ⛔ stop loop
                        }
                    }
                });

                // ❌ all empty
                if (!hasValue) {
                    Swal.fire({
                        icon: 'error',
                        title: 'فورم خالی است',
                        text: 'حداقل یک خانه را پر کنید'
                    });
                    return;
                }

                if (hasError) {
                    return;
                }

                // ✅ submit via ajax
                $.ajax({
                    url: $(form).attr('action'),
                    method: 'POST',
                    data: $(form).serialize(),
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'موفقیت',
                            text: 'پلان با موفقیت ذخیره شد'
                        });
                        form.reset();
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطا',
                            text: 'خطا در ذخیره اطلاعات'
                        });
                    }
                });
            });

            function showError(name, message) {
                $('[data-error-for="' + name + '"]').text(message);
            }
        });
    </script>
@endsection
