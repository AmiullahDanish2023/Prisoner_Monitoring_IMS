@extends('layouts.master')

@section('content')
<!--begin::datatable-->
<div class="card shadow-sm mt-6">
    <div class="card-header">
        <div class="card-title" style="font-size: 20px !important;font-weight:bold">
            {{ __('translate.information about user permission') }}
               </div>
        <div class="card-title">
            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                data-bs-target="#Store_Modal"> {{ __('translate.create') }}</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table">
            <table id="table_id" class="table yajra-datatable">
                <thead class="bg-light" style="font-weight:bold">
                    <th style="text-align:center">{{ __('translate.id') }}</th>
                    <th style="text-align:center">{{ __('translate.name') }}</th>
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
                <h3> {{ __('translate.adding permission') }} </h3>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1 bg-danger text-light">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
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
                <form id="store_form" method="POST" action="{{ route('role.store') }}" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label for="name" class="col-form-label">{{ __('translate.permission name') }}</label>
                            <input id="name" type="text" class="form-control form-control-sm"  name="name" autofocus required>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <fieldset>
                                <legend>
                                     {{ __('translate.permissions') }}
                                </legend>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <ul>
                                            @php
                                                $total_records = count($permission);
                                            @endphp
                                            @for ($i = 0; $i < $total_records / 2; $i++)
                                                <li style="overflow-wrap: anywhere;">
                                                    <input type="checkbox" value="{{ $permission[$i]->id }}" name="permissions[]"
                                                        id="add_role{{ $permission[$i]->id }}">
                                                    <label for="add_role{{ $permission[$i]->id }}">
                                                        @if(Session::get('locale') == 'en')
                                                        {{ $permission[$i]->name }}
                                                        @else
                                                        {{ $permission[$i]->name_fa }}
                                                        @endif

                                                    </label>
                                                </li>
                                            @endfor
                                        </ul>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <fieldset>
                                <legend>
                                    {{ __('translate.permissions') }}
                                </legend>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <ul>
                                            @for ($i = $i; $i < $total_records; $i++)
                                                <li style="overflow-wrap: anywhere;">
                                                    <input type="checkbox" value="{{ $permission[$i]->id }}" name="permissions[]"
                                                        id="add_role{{ $permission[$i]->id }}">
                                                    <label for="add_role{{ $permission[$i]->id }}">
                                                        @if(Session::get('locale') == 'en')
                                                        {{ $permission[$i]->name }}
                                                        @else
                                                        {{ $permission[$i]->name_fa }}
                                                        @endif

                                                    </label>
                                                </li>
                                            @endfor
                                        </ul>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-sm btn-primary flex-shrink-1 hover-scale   ">
                            <span class="indicator-label" data-kt-translate="sign-in-submit">{{ __('translate.save') }} </span>
                            <span id="spinner" hidden class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </button>
                        <button type="reset" class="btn btn-sm btn-danger" data-bs-dismiss="modal">{{ __('translate.close') }} </button>
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
                <h3>تغیر دادن صلاحیت</h3>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1 bg-danger text-light">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
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
                <form id="edit_form" method="POST" action="{{ route('role.update') }}" autocomplete="off">
                    @csrf
                    <input type="hidden" id="edit_record_id" name="id" value="">
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label for="edit_name" class="col-form-label">نام صلاحیت</label>
                            <input id="edit_name" type="text" class="form-control form-control-sm"  name="name" autofocus required>
                        </div>
                        <div class="d-flex" id="edit_role_permission">

                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-sm btn-primary flex-shrink-1 hover-scale">
                            <span class="indicator-label" data-kt-translate="sign-in-submit">ذخیره کردن</span>
                            <span id="spinner" hidden class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </button>
                        <button type="reset" class="btn btn-sm btn-danger" data-bs-dismiss="modal">بسته کردن</button>
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
        },
        messages: {
            name: {
                required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">نام صلاحیت ضروری میباشد</span>',
            },
        }
    });

    $('#edit_form').validate({
        rules: {
            name: {
                required: true,
            },
        },
        messages: {
            name: {
                required: '<span class="text-danger" style="font-size:12px; font-weight:bold;float:left">نام صلاحیت ضروری میباشد</span>',
            },
        }
    });
});

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
    ajax: "{{ route('user.roles') }}",
    columns: [{
            "data": 'id'
        },
        {
            "data": 'name'
        },
        {
            "data": 'action'
        }
    ]
});

// Add new permission
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
                        var error = '<label id="' + prefix + '-error" class="error" for="' + prefix + '">' + val[0] + '</label>';
                        $("input[name=" + prefix + "]").after(error);
                        $("select[name=" + prefix + "]").after(error);
                    });
                }
                $('.someBlock').preloader('remove');
                store_form_submited = false;
            },
            error: function() {
                error_function("There Is Problem on Processing Your Request Please Contact Database Administrator!");
                $('.someBlock').preloader('remove');
                store_form_submited = false;
            }
        });
    }
});

// Edit permission
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

                    $('#Edit_Modal').modal('hide');
                    success("موفقانه ایدیت گردید.!");
                } else {
                    $.each(response.data, function(prefix, val) {
                        var error = '<label id="' + prefix + '-error" class="error" for="' + prefix + '">' + val[0] + '</label>';
                        $("input[name=" + prefix + "]").after(error);
                        $("select[name=" + prefix + "]").after(error);
                    });
                }
                $('.someBlock').preloader('remove');
                edit_form_submited = false;
            },
            error: function() {
                error_function("There Is Problem on Processing Your Request Please Contact Database Administrator!");
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
    var url = $(this).attr('action');

    $.ajax({
        url: url,
        method: 'get',
        data: {'id': id},
        dataType: 'html',
        beforeSend: function() {
            $('.someBlock').preloader({
                zIndex: '6666666666'
            });
        },
        success: function(data) {
            $('#edit_role_permission').html(data);
            $('.someBlock').preloader('remove');
        },
        error: function() {
            error_function("There Is Problem on Processing Your Request Please Contact Database Administrator!");
            $('.someBlock').preloader('remove');
        }
    });

    $('#Edit_Modal').modal('show');
});
</script>
@endsection
