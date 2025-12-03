@extends('layouts.master')

@section('content')
    <!--begin::datatable-->
    <div class="card shadow-sm mt-6">
        <div class="card-header">
            <div class="card-title" style="font-size: 20px !important;font-weight:bold">
                {{ __('translate.user information') }}
            </div>
            <div class="card-title">
                <button type="button" class="btn btn-sm btn-info hover-scale" data-bs-toggle="modal"
                    data-bs-target="#Store_Modal">{{ __('translate.create user') }}</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table">
                <table id="table_id" class="table yajra-datatable">
                    <thead class="bg-light" style="font-weight:bold">
                        <th style="text-align:center">{{ __('translate.id') }}</th>
                        <th style="text-align:center">{{ __('translate.name') }}</th>
                        <th style="text-align:center">{{ __('translate.email') }}</th>
                        <th style="text-align:center">{{ __('translate.permession') }}</th>
                        <th style="text-align:center">{{ __('translate.action') }}</th>
                    </thead>
                    <tbody style="text-align:center">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end::datatable-->
    <!--begin::create form Modal-->
    <div class="modal fade" id="Store_Modal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-50">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>{{ __('translate.user registration') }}</h3>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1 bg-danger text-light">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <div class="modal-body">
                    <!--begin::Form-->
                    <form id="store_form" method="POST" action="{{ route('users.store') }}" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="name" class="col-form-label">{{ __('translate.name and lastname') }}</label>
                                <input id="name" type="text" class="form-control form-control-sm" name="name"
                                    autofocus required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="email" class="col-form-label">{{ __('translate.email') }}</label>
                                <input id="email" type="email" class="form-control form-control-sm" name="email"
                                    required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="password" class="col-form-label">{{ __('translate.password') }}</label>
                                <input id="password" type="password" autocomplete="new-password"
                                    class="form-control form-control-sm" minlength="6" name="password" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="password-confirm"
                                    class="col-form-label">{{ __('translate.confirm password') }}</label>
                                <input id="password-confirm" type="password" class="form-control form-control-sm"
                                    minlength="6" name="password_confirmation" required>
                                <div class="invalid-feedback password_confirmation_error"></div>
                            </div>
                            <div class="form-group col-lg-6">
                                @php $departments = \App\Models\Department::get(); @endphp
                                <label for="department_id" class="col-form-label">{{ __('translate.department') }}</label>
                                <select class="form-control form-control-sm" name="department_id" id="department_id"
                                    required>
                                    <option value="" style="direction: ltr !important;">
                                        {{ __('translate.select the department') }}
                                    </option>
                                    @foreach ($departments as $item)
                                        <option value="{{ $item->id }}" style="direction: ltr !important;">
                                            {{ $item->name_ps }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                @php $roles = \Spatie\Permission\Models\Role::get(); @endphp
                                <label for="role" class="col-form-label">{{ __('translate.permession') }}</label>
                                <select class="form-control form-control-sm" name="role" id="role" required>
                                    <option value="" style="direction: ltr !important;">
                                        {{ __('translate.select the permission') }}
                                    </option>
                                    @foreach ($roles as $item)
                                        <option value="{{ $item->id }}" style="direction: ltr !important;">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="photo" class="col-form-label">{{ __('translate.image') }}</label>
                                <input type="file" class="form-control form-control-sm" name="photo"
                                    id="photo">
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-sm btn-primary flex-shrink-1 hover-scale   ">
                                <span class="indicator-label"
                                    data-kt-translate="sign-in-submit">{{ __('translate.save') }}</span>
                                <span id="spinner" hidden
                                    class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </button>
                            <button type="reset" class="btn btn-sm btn-danger" data-bs-dismiss="modal">
                                {{ __('translate.close') }}
                            </button>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>
    <!--end::create form Modal-->
    <!--begin::Edit form Modal-->
    <div class="modal fade" id="Edit_Modal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-50">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>د کار کونکی معلومات تغیر کول</h3>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1 bg-danger text-light">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <div class="modal-body">
                    <!--begin::Form-->
                    <form id="edit_form" method="POST" action="{{ route('users.update') }}" autocomplete="off">
                        @csrf
                        <input type="hidden" id="edit_record_id" name="id" value="">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="edit_name" class="col-form-label">نام و تخلص</label>
                                <input id="edit_name" type="text" class="form-control" name="name" autofocus
                                    required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="edit_email" class="col-form-label">ایمل</label>
                                <input id="edit_email" type="email" class="form-control" name="email" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="edit_password" class="col-form-label">رمز</label>
                                <input id="edit_password" type="password" class="form-control" minlength="6"
                                    name="password">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="edit_password-confirm" class="col-form-label">تایید رمز</label>
                                <input id="edit_password-confirm" type="password" class="form-control" minlength="6"
                                    name="password_confirmation">
                                <div class="invalid-feedback password_confirmation_error"></div>
                            </div>
                            <div class="form-group col-lg-6">
                                @php $departments = \App\Models\Department::get(); @endphp
                                <label for="edit_department_id" class="col-form-label">دیپارتمنت</label>
                                <select class="form-control" name="department_id" id="edit_department_id" required>
                                    <option value="" style="direction: ltr !important;">--دیپارتمنت انتخاب کړی--
                                    </option>
                                    @foreach ($departments as $item)
                                        <option value="{{ $item->id }}" style="direction: ltr !important;">
                                            {{ $item->name_ps }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                @php $roles = \Spatie\Permission\Models\Role::get(); @endphp
                                <label for="edit_role" class="col-form-label">صلاحیت</label>
                                <select class="form-control" name="role" id="edit_role" required>
                                    <option value="" style="direction: ltr !important;">--صلاحیت انتخاب کړی--
                                    </option>
                                    @foreach ($roles as $item)
                                        <option value="{{ $item->id }}" style="direction: ltr !important;">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="edit_photo" class="col-form-label">عکس</label>
                                <input type="file" class="form-control" name="photo" id="edit_photo">
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-sm btn-primary flex-shrink-1 hover-scale">
                                <span class="indicator-label" data-kt-translate="sign-in-submit">ذخیره کردن</span>
                                <span id="spinner" hidden
                                    class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </button>
                            <button type="reset" class="btn btn-sm btn-danger" data-bs-dismiss="modal">بسته
                                کردن</button>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>
    <!--end::Edit form Modal-->
@endsection

@section('scripts')
    <script>
        // Form Validation
        $(document).ready(function() {
            $('#store_form').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    password: {
                        required: true,
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password",
                    },
                    department_id: {
                        required: true,
                    },
                    role: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">د نوم لیکل اړین دی.</span>',
                    },
                    email: {
                        required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">ایمیل ادرس ضروری دی.</span>',
                        email: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">ستاسو ایمیل ناسم دی.</span>',
                    },
                    password: {
                        required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">پټ نوم لیکل اړین دی.</span>',
                        minlength: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">پټ نوم باید حد اقل ۶ حروف ولری.</span>',
                    },
                    password_confirmation: {
                        required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">پټ نوم بیا لیکل اړین دی.</span>',
                        minlength: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">پټ نوم باید حد اقل ۶ حروف ولری.</span>',
                        equalTo: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">کود هم خوانی ندارد</span>',
                    },
                    department_id: {
                        required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">د دیپارتمنت انتخاب اړین دی.</span>',
                    },
                    role: {
                        required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">د صلاحیت انتخاب اړین دی.</span>',
                    },
                }
            });
        });

        $('#edit_form').validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                department_id: {
                    required: true,
                },
                role: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">د نوم لیکل اړین دی.</span>',
                },
                email: {
                    required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">ایمیل ادرس ضروری دی.</span>',
                    email: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">ستاسو ایمیل ناسم دی.</span>',
                },
                department_id: {
                    required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">د دیپارتمنت انتخاب اړین دی.</span>',
                },
                role: {
                    required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">د صلاحیت انتخاب اړین دی.</span>',
                },
            }
        });

        // User list
        var table = $('.yajra-datatable').DataTable({
            "bInfo": false,
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "aaSorting": [
                [0, "desc"]
            ],
            "info": true,
            language: {
                "emptyTable": "{{ __('translate.information not exists') }}",
                "lengthMenu": "{{ __('translate.showing') }} _MENU_ {{ __('translate.information') }}",
                "info": "{{ __('translate.from') }} _START_ {{ __('translate.to') }} _END_  {{ __('translate.total information') }} _TOTAL_",
                "infoEmpty": "{{ __('translate.form 0 to 0 - total 0 records') }}",
                "search": "{{ __('translate.search') }}:",
                "sProcessing": "{{ __('translate.under processing') }}",
                "paginate": {
                    "first": "{{ __('first') }}",
                    "last": "{{ __('last') }}",
                    "next": "{{ __('translate.next') }}",
                    "previous": "{{ __('translate.previous') }}"
                },
            },
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.index') }}",
            columns: [{
                    "data": 'id'
                },
                {
                    "data": 'name'
                },
                {
                    "data": 'email'
                },
                {
                    "data": 'role'
                },
                {
                    "data": 'action'
                }
            ]
        });

        // User create
        var store_form_submited = false;
        $(document).on('submit', '#store_form', function(event) {
            event.preventDefault();
            event.stopImmediatePropagation();

            if (!store_form_submited) {
                var url = $(this).attr('action');
                $.ajax({
                    url: url,
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        store_form_submited = true;
                        $('.someBlock').preloader({
                            zIndex: '6666666666'
                        });
                    },
                    success: function(data) {
                        if (data == true) {
                            $('.yajra-datatable').DataTable().ajax.reload();
                            $("input[name=name]").val('');
                            $("input[name=email]").val('');
                            $("input[name=password]").val('');
                            $("input[name=password_confirmation]").val('');
                            $("select[name=department_id").val('').change();
                            $("select[name=role").val('').change();

                            $('#Store_Modal').modal('hide');
                            success("موفقانه ثبت گردید.!");
                        } else {
                            $.each(response.data, function(prefix, val) {
                                var error = '<label id="' + prefix +
                                    '-error" class="error" for="' + prefix + '">' + val[0] +
                                    '</label>';
                                $("input[name=" + prefix + "]").after(error);
                                $("select[name=" + prefix + "]").after(error);
                            });
                        }
                        $('.someBlock').preloader('remove');
                        store_form_submited = false;
                    },
                    error: function() {
                        error_function(
                            "There Is Problem on Processing Your Request Please Contact Database Administrator!"
                        );
                        $('.someBlock').preloader('remove');
                        store_form_submited = false;
                    }
                });
            }
        });

        // User edit
        var edit_form_submited = false;
        $(document).on('submit', '#edit_form', function(event) {
            event.preventDefault();
            event.stopImmediatePropagation();

            if (!edit_form_submited) {
                var url = $(this).attr('action');
                $.ajax({
                    url: url,
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        edit_form_submited = true;
                        $('.someBlock').preloader({
                            zIndex: '6666666666'
                        });
                    },
                    success: function(data) {

                        if (data == true) {
                            $('.yajra-datatable').DataTable().ajax.reload();
                            $("input[id=edit_name]").val('');
                            $("input[id=edit_email]").val('');
                            $("input[id=edit_password]").val('');
                            $("input[id=edit_password_confirmation]").val('');
                            $("select[id=edit_department_id").val('').change();
                            $("select[id=edit_role").val('').change();

                            $('#Edit_Modal').modal('hide');
                            success("موفقانه ایدیت گردید.!");
                        } else {
                            $.each(data, function(prefix, val) {
                                var error = '<label id="' + prefix +
                                    '-error" class="error" for="' + prefix + '">' + val[0] +
                                    '</label>';
                                $("input[name=" + prefix + "]").after(error);
                                $("select[name=" + prefix + "]").after(error);
                            });
                        }
                        $('.someBlock').preloader('remove');
                        edit_form_submited = false;
                    },
                    error: function() {

                        error_function(
                            "There Is Problem on Processing Your Request Please Contact Database Administrator!"
                        );
                        $('.someBlock').preloader('remove');
                        edit_form_submited = false;
                    }
                });
            }
        });

        $(document).on('click', '.edit_btn', function(event) {
            var id = $(this).attr('record_id');
            $('#edit_record_id').val(id);
            $("input[id=edit_name]").val($(this).attr('name'));
            $("input[id=edit_email]").val($(this).attr('email'));
            $("select[id=edit_department_id").val($(this).attr('department_id')).change();
            $("select[id=edit_role").val($(this).attr('role')).change();

            $('#Edit_Modal').modal('show');
        });
    </script>
@endsection
