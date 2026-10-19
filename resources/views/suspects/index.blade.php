@extends('layouts.master')
@section('content')
    
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons/bootstrap-icons.css') }}">

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">{{ __('translate.suspect_list') }}</h4>
            @can('Save New Suspect')
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#suspectModal">
                    {{ __('translate.save_new_suspect') }}
                </button>
            @endcan
        @section('button')
            <button class="btn btn-primary fa fa-search p-3 m-1" id="searchToggle"> ygjjhjyyyy</button>
        @endsection
       

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

            /* ---------- Action Buttons Container ---------- */
            .action-buttons {
                display: flex;
                gap: 6px;
            }

            /* Base Button Styling */
            .action-buttons a {
                display: flex !important;
                align-items: center;
                justify-content: center;
                gap: 6px;
                cursor: pointer;
                border-radius: 4px;
                padding: 4px 6px;
                transition: all 0.25s ease-in-out;
                text-decoration: none;
            }

            /* 🔥 Bootstrap Icons Styling */
            .action-buttons a i {
                color: #fff !important;
                /* icon color */
                font-size: 16px;
                /* same as old svg size */
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Hover effect */
            .action-buttons a:hover {
                transform: scale(1.08);
                box-shadow: 0 0 12px rgba(0, 0, 0, 0.15);
            }

            /* Button Colors */
            .view-btn {
                background-color: #56a0f0 !important;
                color: #fff !important;
            }

            .edit-btn {
                background-color: #0dcaf0 !important;
                color: #fff !important;
            }

            .destroy_btn {
                background-color: #e26774 !important;
                color: #fff !important;
            }

            .release-btn {
                background-color: #a3ee94 !important;
                color: #fff !important;
            }

            .btn-transfer {
                background-color: #f0c14d !important;
                color: #fff !important;
            }

            /* Tooltip */
            .action-buttons a[data-title] {
                position: relative;
            }

            .action-buttons a:hover i {
                transform: scale(1.2);
            }

            .action-buttons a i {
                color: #fff !important;
                font-size: 16px;
            }

            .action-buttons a[data-title]::after {
                content: attr(data-title);
                position: absolute;
                bottom: 125%;
                left: 50%;
                transform: translateX(-50%);
                background: #000;
                color: #fff;
                font-size: 11px;
                padding: 4px 8px;
                border-radius: 4px;
                opacity: 0;
                white-space: nowrap;
                pointer-events: none;
                transition: all 0.25s ease;
                z-index: 999;
            }

            .action-buttons a[data-title]:hover::after {
                opacity: 1;
                bottom: 135%;
            }

            .swal2-title,
            .swal2-html-container {
                font-family: 'Bahij', sans-serif !important;
                font-weight: 700 !important;
                /* bold */
                font-size: 18px !important;
            }

            #releaseDropdownBtn.form-control {
                cursor: pointer;
            }

            #releaseDropdownBtn.form-control:focus {
                box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
                border-color: #86b7fe;
            }

            /* Validation error text */
            label.error {
                color: #dc3545;
                /* Bootstrap red */
                font-size: 13px;
                margin-top: 4px;
                display: block;
            }

            /* Input border when error */
            input.error,
            select.error,
            textarea.error {
                border-color: #dc3545 !important;
            }

            #suspects_table {
                border: 1px solid #dee2e6;
            }

            #suspects_table th,
            #suspects_table td {
                border: 1px solid #dee2e6 !important;
            }

            #suspects_table thead th {
                background: #3f577c;
                /* bootstrap primary */
                color: #fff;
                font-weight: 600;
                text-align: center;
                vertical-align: middle;
            }

            #suspects_table tbody tr {
                transition: all 0.2s ease;
            }

            #suspects_table tbody tr:hover {
                background-color: #f1faff;
            }

            #suspects_table td {
                padding: 10px;
                vertical-align: middle;
                text-align: center;
            }

            .table-responsive {
                border-radius: 8px;
                overflow: hidden;
                border: 1px solid #dee2e6;
            }

            #suspects_table.table-striped tbody tr:nth-of-type(odd) {
                background-color: #f9fbfd;
            }
        </style>

    </div>

    <div class="card-body">
        <div id="filterPanel" class="collapse mb-3">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <input type="text" id="filter_name" class="form-control" placeholder="نوم">
                </div>
                <div class="col-md-3">
                    <input type="text" id="filter_f_name" class="form-control" placeholder="پلار نوم">
                </div>
                <div class="col-md-3">
                    <input type="text" id="filter_chasis" class="form-control" placeholder="شاسي نمبر ">
                </div>

                <div class="col-md-1">
                    <button class="btn btn-primary btn-block w-100" id="btnFilter">
                        <i class="fas fa-search"></i>پلټنه
                    </button>
                </div>

                <div class="col-md-1">
                    <button class="btn btn-danger btn-block w-100" id="btnReset">
                        <i class="fas fa-undo-alt"></i>پاکول
                    </button>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-responsive  table-checkable align-middle"
                id="suspects_table">
                <thead style="background-color:lightgray; !important;">
                    <tr class="bg-primary-o-10">
                        <th>{{ __('translate.number') }}</th>
                        <th>{{ __('translate.suspect days') }}</th>
                        <th>{{ __('translate.suspect name') }}</th>
                        <th>{{ __('translate.father name') }}</th>
                        <th>{{ __('translate.crime') }}</th>
                        <th>{{ __('translate.source') }}</th>
                        <th>{{ __('translate.province') }}</th>
                        <th>{{ __('translate.district') }}</th>
                        <th>{{ __('translate.area') }}</th>
                        <th>{{ __('translate.monitoring date') }}</th>
                        <th>{{ __('translate.action') }}</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
{{--  Create Suspect Modal --}}
<div class="modal fade" id="suspectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header justify-content-center" style="background-color:#3f577c;">
                <h5 class="modal-title text-center w-100 text-white">
                    {{ __('translate.create_suspect') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- Form --}}
            <form id="store_form" method="POST" action="{{ route('suspects.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Gender --}}
                        <div class="col-md-4">
                            <label class="form-label">{{ __('translate.gender') }}</label>
                            <select name="gender" id="gender" class="form-select form-select-sm">
                                <option value="" disabled selected>
                                    {{ __('translate.select_gender') }}
                                </option>
                                <option value="نارینه">{{ __('translate.male') }}</option>
                                <option value="ښځینه">{{ __('translate.female') }}</option>
                            </select>
                        </div>

                        {{-- Name --}}
                        <div class="col-md-4">
                            <label class="form-label">{{ __('translate.name') }}</label>
                            <input type="text" name="suspect_name" class="form-control form-control-sm"
                                placeholder="{{ __('translate.name') }}">
                        </div>

                        {{-- Father --}}
                        <div class="col-md-4">
                            <label class="form-label">{{ __('translate.father_name') }}</label>
                            <input type="text" name="father_name" class="form-control form-control-sm"
                                placeholder="{{ __('translate.father_name') }}">
                        </div>

                        {{-- Grandfather --}}
                        <div class="col-md-4">
                            <label class="form-label">{{ __('translate.grandfather_name') }}</label>
                            <input type="text" name="grandfather_name" class="form-control form-control-sm"
                                placeholder="{{ __('translate.grandfather_name') }}">
                        </div>

                        {{-- Children --}}
                        <div class="col-md-4" id="childrenWithMotherDiv">
                            <label class="form-label">{{ __('translate.children_with_mother') }}</label>
                            <input type="text" name="children_with_mother" class="form-control form-control-sm"
                                placeholder="{{ __('translate.children_with_mother') }}">
                        </div>

                        {{-- Crime --}}
                        <div class="col-md-4">
                            <label class="form-label">{{ __('translate.crime_type') }}</label>
                            <input type="text" name="crime_type" class="form-control form-control-sm"
                                placeholder="{{ __('translate.crime_type') }}">
                        </div>

                        {{-- Authority --}}
                        <div class="col-md-4">
                            <label class="form-label">{{ __('translate.referring_authority') }}</label>
                            <select name="referring_authority" id="referring_authority"
                                class="form-select form-select-sm" style="width:100%">
                            </select>
                        </div>

                        {{-- Date --}}
                        <div class="col-md-4">
                            <label class="form-label">{{ __('translate.monitoring_date') }}</label>
                            <input type="text" name="monitoring_date"
                                class="form-control form-control-sm farsi-date"
                                placeholder="{{ __('translate.monitoring_date') }}">
                        </div>

                        {{-- Province --}}
                        <div class="col-md-4">
                            <label class="form-label">{{ __('translate.province') }}</label>
                            <select name="province" id="province" class="form-select form-select-sm"
                                style="width:100%">
                                <option value=""></option>
                                @foreach ($province as $pro)
                                    <option value="{{ $pro->id }}">
                                        {{ $pro->name_da }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- District --}}
                        <div class="col-md-4">
                            <label class="form-label">{{ __('translate.district') }}</label>
                            <input type="text" name="district" class="form-control form-control-sm"
                                placeholder="{{ __('translate.district') }}">
                        </div>

                        {{-- Area --}}
                        <div class="col-md-4">
                            <label class="form-label">{{ __('translate.area') }}</label>
                            <input type="text" name="area" class="form-control form-control-sm"
                                placeholder="{{ __('translate.area') }}">
                        </div>

                        {{-- Has Items --}}
                        <div class="col-md-4">
                            <label class="form-label d-block">
                                {{ __('translate.has_items') }}
                            </label>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="has_items" value="1">
                                <label class="form-check-label">
                                    {{ __('translate.yes') }}
                                </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="has_items" value="0">
                                <label class="form-check-label">
                                    {{ __('translate.no') }}
                                </label>
                            </div>
                        </div>

                        {{-- File Upload --}}
                        <div class="col-md-12">
                            <label class="form-label">{{ __('translate.file') }}</label>
                            <input type="file" name="file[]" class="form-control form-control-sm" multiple
                                accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx,.xls,.xlsx">
                            <small id="edit_existing_file" class="text-muted"></small>
                        </div>

                    </div>
                </div>

                {{-- Footer --}}
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary btn-sm">
                        {{ __('translate.save') }}
                    </button>

                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                        {{ __('translate.close') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
{{-- Edit Suspect Modal --}}

<div class="modal fade" id="editSuspectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header d-flex justify-content-center " style="background-color:#3f577c;">
                <h5 class="modal-title text-center w-100 text-white">
                    {{ __('translate.edit_suspect') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="edit_form" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                <input type="hidden" name="suspect_id" id="edit_suspect_id">
                <input type="hidden" name="deleted_files" id="deleted_files">

                <div class="modal-body row g-3">

                    {{-- Gender --}}
                    <div class="col-md-4">
                        <label class="form-label">{{ __('translate.gender') }}</label>
                        <select id="edit_gender" name="gender" class="form-control form-control-sm">
                            <option value="" selected disabled>
                                {{ __('translate.select_gender') }}
                            </option>
                            <option value="نارینه">{{ __('translate.male') }}</option>
                            <option value="ښځینه">{{ __('translate.female') }}</option>
                        </select>
                    </div>

                    {{-- Name --}}
                    <div class="col-md-4">
                        <label class="form-label">{{ __('translate.name') }}</label>
                        <input type="text" name="suspect_name" id="edit_suspect_name"
                            class="form-control form-control-sm">
                    </div>

                    {{-- Father Name --}}
                    <div class="col-md-4">
                        <label class="form-label">{{ __('translate.father_name') }}</label>
                        <input type="text" name="father_name" id="edit_father_name"
                            class="form-control form-control-sm">
                    </div>

                    {{-- Grandfather --}}
                    <div class="col-md-4">
                        <label class="form-label">{{ __('translate.grandfather_name') }}</label>
                        <input type="text" name="grandfather_name" id="edit_grandfather_name"
                            class="form-control form-control-sm">
                    </div>

                    {{-- Children with Mother --}}
                    <div class="col-md-4" id="edit_childrenWithMotherDiv">
                        <label class="form-label">{{ __('translate.children_with_mother') }}</label>
                        <input type="text" name="children_with_mother" id="edit_children_with_mother"
                            class="form-control form-control-sm">
                    </div>

                    {{-- Crime --}}
                    <div class="col-md-4">
                        <label class="form-label">{{ __('translate.crime_type') }}</label>
                        <input type="text" name="crime_type" id="edit_crime_type"
                            class="form-control form-control-sm">
                    </div>

                    {{-- Referring Authority --}}
                    <div class="col-md-4">
                        <label class="form-label">{{ __('translate.referring_authority') }}</label>
                        <select name="referring_authority" id="edit_referring_authority"
                            class="form-select form-select-sm" style="width:100%">
                        </select>
                    </div>


                    {{-- Monitoring Date --}}
                    <div class="col-md-4">
                        <label class="form-label">{{ __('translate.monitoring_date') }}</label>
                        <input type="text" name="monitoring_date" class="form-control form-control-sm farsi-date"
                            id="edit_monitoring_date" placeholder="{{ __('translate.monitoring_date') }}">
                    </div>


                    {{-- Province --}}
                    <div class="col-md-4">
                        <label class="form-label">{{ __('translate.province') }}</label>
                        <select name="province" id="edit_province" class="form-select form-select-sm select2"
                            style="width:100%">
                            <option value=""></option>
                            @foreach ($province as $pro)
                                <option value="{{ $pro->id }}">
                                    {{ $pro->name_da }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- District --}}
                    <div class="col-md-4">
                        <label class="form-label">{{ __('translate.district') }}</label>
                        <input type="text" name="district" id="edit_district"
                            class="form-control form-control-sm">
                    </div>

                    {{-- Area --}}
                    <div class="col-md-4">
                        <label class="form-label">{{ __('translate.area') }}</label>
                        <input type="text" name="area" id="edit_area" class="form-control form-control-sm">
                    </div>

                    {{-- Has Items --}}
                    <div class="col-md-4">
                        <label class="form-label">{{ __('translate.has_items') }}</label>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="has_items" value="1"
                                id="edit_has_items_yes">
                            <label class="form-check-label" for="edit_has_items_yes">
                                {{ __('translate.yes') }}
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="has_items" value="0"
                                id="edit_has_items_no">
                            <label class="form-check-label" for="edit_has_items_no">
                                {{ __('translate.no') }}
                            </label>
                        </div>
                    </div>

                    {{-- File --}}
                    <div class="col-md-12">
                        <label class="form-label">{{ __('translate.file') }}</label>
                        <input type="file" name="edit_files[]" id="edit_file_input"
                            class="form-control form-control-sm" multiple
                            accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx,.xls,.xlsx">

                        <div id="edit_existing_files_area" class="mt-2"></div>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="modal-footer d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary btn-sm">
                        {{ __('translate.save_changes') }}
                    </button>

                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                        {{ __('translate.close') }}
                    </button>


                </div>

            </form>
        </div>
    </div>
</div>
</div>

<!-- Release Modal -->
<div class="modal fade" id="releaseModal" tabindex="-1" aria-labelledby="releaseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header justify-content-center " style="background-color:#3f577c;">
                <h5 class="modal-title text-center w-100 text-white" id="releaseModalLabel">
                    {{ __('translate.release_transfer') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="{{ __('translate.close') }}"></button>
            </div>

            <form id="releaseForm" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf

                <div class="modal-body">
                    <input type="hidden" name="suspect_id" id="release_suspect_id">

                    {{-- Issue Number --}}
                    <div class="mb-3">
                        <label class="form-label">
                            {{ __('translate.issue_number') }}
                        </label>
                        <input type="text" class="form-control" id="issued_or_transferred_number"
                            name="issued_or_transferred_number">
                    </div>

                    {{-- Authority --}}
                    <div class="mb-3">
                        <label class="form-label">
                            {{ __('translate.releasing_authority') }}
                        </label>

                        <div class="dropdown w-100">
                            <button class="form-control text-start dropdown-toggle" type="button"
                                id="releaseDropdownBtn" data-bs-toggle="dropdown">
                                <span id="releaseDropdownLabel">
                                    {{ __('translate.select_authority') }}
                                </span>
                            </button>

                            <div class="dropdown-menu p-3 w-100" style="max-width:350px;">

                                {{-- STATIC OPTIONS --}}
                                <div class="form-check mb-2">
                                    <input class="form-check-input main-opt" type="radio" name="main_option"
                                        value="انتقال به توقیف" id="main_opt_1" data-key="detention">

                                    <label class="form-check-label" for="main_opt_1">
                                        {{ __('translate.to_detention') }}
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input main-opt" type="radio" name="main_option"
                                        value="انتقال به مراجع مختلف" id="main_opt_2" data-key="multi">

                                    <label class="form-check-label" for="main_opt_2">
                                        {{ __('translate.to_multiple_sources') }}
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input main-opt" type="radio" name="main_option"
                                        value="مظنونین رهایی" id="main_opt_3" data-key="release">

                                    <label class="form-check-label" for="main_opt_3">
                                        {{ __('translate.suspect_release') }}
                                    </label>
                                </div>

                                <hr>

                                {{-- Search --}}
                                <div id="db_search_wrapper" style="display:none;" class="mb-2">
                                    <input type="text" id="db_option_search" class="form-control form-control-sm"
                                        placeholder="{{ __('translate.search_authority') }}">
                                </div>

                                {{-- DB OPTIONS --}}
                                <div id="db_options_wrapper"
                                    style="display:none; max-height:220px; overflow-y:auto; border:1px solid #dee2e6; padding:8px; border-radius:6px;">

                                    @foreach ($releaseOptions as $opt)
                                        <div class="form-check mb-2 db-option-item">
                                            <input class="form-check-input db-opt" type="checkbox"
                                                value="{{ $opt->name_da }}" id="db_opt_{{ $opt->id }}">

                                            <label class="form-check-label" for="db_opt_{{ $opt->id }}">
                                                {{ $opt->name_da }}
                                            </label>
                                        </div>
                                    @endforeach

                                </div>

                            </div>
                        </div>

                        <input type="hidden" name="main_option_key" id="main_option_key">
                        <input type="hidden" name="db_source_name" id="db_source_name">
                    </div>

                    {{-- Date --}}
                    <div class="mb-3">
                        <label class="form-label">
                            {{ __('translate.release_date') }}
                        </label>
                        <input type="text" class="form-control farsi-date" id="release_date" name="release_date"
                            placeholder="{{ __('translate.select_date') }}">
                    </div>

                    {{-- File --}}
                    <div class="mb-3">
                        <label class="form-label">{{ __('translate.file') }}</label>
                        <input type="file" name="file[]" id="release_files" class="form-control" multiple
                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                    </div>

                </div>

                {{-- Footer --}}
                <div class="modal-footer d-flex justify-content-between">
                    <button type="submit" class="btn btn-success btn-sm">
                        {{ __('translate.save') }}
                    </button>

                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        {{ __('translate.close') }}
                    </button>


                </div>

            </form>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="{{ asset('perisanDatePicker/js/persianDatepicker.js') }}"></script>


<script>
    $('.select2').select2({
        width: '100%',
    });


    $(function() {
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
    });
</script>
<script>
    $('#store_form').validate({
        ignore: [],
        errorClass: 'error',
        errorElement: 'label',

        rules: {
            gender: {
                required: true
            },
            suspect_name: {
                required: true
            },
            father_name: {
                required: true
            },
            grandfather_name: {
                required: true
            },
            children_with_mother: {
                required: function(element) {
                    return $('#gender').val() === 'ښځینه';
                }
            },
            crime_type: {
                required: true
            },
            referring_authority: {
                required: true
            },
            monitoring_date: {
                required: true
            },
            province: {
                required: true
            },
            district: {
                required: true
            },
            area: {
                required: true
            },
            'file[]': {
                required: true,
                extension: "jpg|jpeg|png|gif|webp|pdf|doc|docx|xls|xlsx"
            }
        },

        messages: {
            gender: {
                required: 'جنسیت انتخاب کړئ'
            },
            suspect_name: {
                required: 'نوم ولیکئ'
            },
            father_name: {
                required: 'د پلار نوم ولیکئ'
            },
            grandfather_name: {
                required: 'د نیکه نوم ولیکئ'
            },
            children_with_mother: {
                required: 'د مور سره د ماشومانو شمېره ولیکئ'
            },
            crime_type: {
                required: 'د جرم ډول ولیکئ'
            },
            referring_authority: {
                required: 'رالیږونکې اداره ولیکئ'
            },
            monitoring_date: {
                required: 'د څارنې نیټه ولیکئ'
            },
            province: {
                required: 'ولایت ولیکئ'
            },
            district: {
                required: 'ناحیه ولیکئ'
            },
            area: {
                required: 'منطقه ولیکئ'
            },
            'file[]': {
                required: 'فایل انتخاب کړئ',
                extension: 'فایل باید jpg, png, pdf, doc, docx وي'
            }
        },
        errorPlacement: function(error, element) {
            element.addClass('is-invalid');
            $(element).parent().addClass('is-invalid');
            if (element.hasClass('select2') && element.next('.select2-container').length) {
                error.insertAfter(element.next('.select2-container'));
            } else {
                error.insertAfter(element);
            }
        }

     
    });
</script>



<script>
    $(document).ready(function() {

        $('#referring_authority').select2({
            dropdownParent: $('#suspectModal'),
            placeholder: 'مرجع انتخاب یا اضافه کړئ',
            tags: true,
            allowClear: true,
            width: '100%',

            ajax: {
                url: '/get-referring-authorities',
                dataType: 'json',
                delay: 250,

                data: function(params) {
                    return {
                        search: params.term
                    };
                },

                processResults: function(data) {
                    return {
                        results: data.map(function(item) {
                            return {
                                id: item.referring_authority,
                                text: item.referring_authority
                            };
                        })
                    };
                },

                cache: true
            }

        });

    });

    $(document).ready(function() {

        $('#province').select2({
            dropdownParent: $('#suspectModal'),
            placeholder: 'ولایت انتخاب کړئ',
            allowClear: true,
            width: 'resolve'
        });




        function gregorianToJalali(gy, gm, gd) {
            let g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
            let jy = (gy <= 1600) ? 0 : 979;
            gy -= (gy <= 1600) ? 621 : 1600;

            let gy2 = (gm > 2) ? (gy + 1) : gy;
            let days = 365 * gy + Math.floor((gy2 + 3) / 4) - Math.floor((gy2 + 99) / 100) + Math.floor((gy2 +
                399) / 400) - 80 + gd + g_d_m[gm - 1];

            jy += 33 * Math.floor(days / 12053);
            days %= 12053;
            jy += 4 * Math.floor(days / 1461);
            days %= 1461;

            if (days > 365) {
                jy += Math.floor((days - 1) / 365);
                days = (days - 1) % 365;
            }

            let jm = (days < 186) ? 1 + Math.floor(days / 31) : 7 + Math.floor((days - 186) / 30);
            let jd = 1 + ((days < 186) ? (days % 31) : ((days - 186) % 30));

            return {
                jy,
                jm,
                jd
            };
        }

        function getDifferenceInDays(date1, date2) {
            const oneDay = 24 * 60 * 60 * 1000;
            const firstDate = new Date(date1);
            const secondDate = new Date(date2);
            return Math.round((secondDate - firstDate) / oneDay);
        }

        $('#suspects_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
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
            ajax: "{{ route('suspects.list') }}",
            columns: [{
                    "data": 'id',
                    render: function(data, type, row, meta) {
                        // Get current Gregorian date
                        const now = new Date();
                        const currentDate = gregorianToJalali(now.getFullYear(), now
                            .getMonth() + 1, now.getDate());

                        const jalaliString =
                            `${currentDate.jy}-${currentDate.jm}-${currentDate.jd}`;
                        const diffInDays = getDifferenceInDays(row.monitoring_date,
                            jalaliString);

                        if (diffInDays < 9) {
                            return `<span class="badge badge-success">${meta.row + meta.settings._iDisplayStart + 1}</span>`;
                        } else if (diffInDays === 9) {
                            return `<span class="badge badge-warning">${meta.row + meta.settings._iDisplayStart + 1}</span>`;
                        } else {
                            return `<span class="badge badge-danger">${meta.row + meta.settings._iDisplayStart + 1}</span>`;
                        }
                    }
                },
                {
                    data: null,
                    searching: false,
                    ordering: false,
                    render: function(data, type, row, meta) {

                        // Current Gregorian date → Jalali
                        const now = new Date();
                        const currentDate = gregorianToJalali(
                            now.getFullYear(),
                            now.getMonth() + 1,
                            now.getDate()
                        );

                        const todayJalali =
                            currentDate.jy + '-' +
                            currentDate.jm + '-' +
                            currentDate.jd;

                        // Difference in days
                        const diffInDays = getDifferenceInDays(row.monitoring_date,
                            todayJalali);

                        let badgeClass = 'badge-success';
                        let message = '';


                        if (diffInDays === 0) {
                            message = `مظنون  لــــومــــړۍ ورځ ده`;
                        } else if (diffInDays === 1) {
                            message = `مظنون  (۱) ورځ تیره شوې`;
                        } else {
                            message = `مظنون (${diffInDays}) ورځې تېرې شوي`;
                        }

                        // ✅ Badge color
                        if (diffInDays < 9) {
                            badgeClass = 'badge-success';
                        } else if (diffInDays === 9) {
                            badgeClass = 'badge-warning';
                        } else {
                            badgeClass = 'badge-danger';
                        }

                        return `
                             <span class="badge ${badgeClass}">
                                 ${message}
                             </span>`;
                    }


                },
                {
                    data: 'suspect_name',
                    name: 'suspect_name',
                    searching: true,
                    ordering: true,
                },
                {
                    data: 'father_name',
                    name: 'father_name'
                },
                {
                    data: 'crime_type',
                    name: 'crime_type'
                },
                {
                    data: 'referring_authority',
                    name: 'referring_authority'
                },
                {
                    data: 'province_name',
                    name: 'province_name'
                },
                {
                    data: 'district',
                    name: 'district'
                },
                {
                    data: 'area',
                    name: 'area'
                },
                {
                    data: 'monitoring_date',
                    name: 'monitoring_date'
                },
                {
                    data: 'action',
                    searching: false,
                    ordering: false,
                    className: 'text-center font-weight-bolder'
                },
            ]
        });




        // --- Show/hide "Children with Mother" based on Gender ---
        const $childrenDiv = $('#childrenWithMotherDiv');
        const $genderSelect = $('#gender');

        function toggleChildrenField() {

            if ($genderSelect.val() === 'ښځینه') {

                $childrenDiv.show();

            } else {

                $childrenDiv.hide();

                $('[name="children_with_mother"]').val('');

                $('#children_with_mother-error').remove();
            }
        }

        // Initial check in case the form is pre-filled
        toggleChildrenField();

        // When gender changes
        $genderSelect.on('change', function() {
            toggleChildrenField();
        });



        // --- Submit Form with AJAX ---
        $(document).on('submit', '#store_form', function(e) {

            e.preventDefault();

            clearFormErrors();

            $.ajax({
                url: "{{ route('suspects.store') }}",
                method: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,

                beforeSend: function() {
                    $('.someBlock').preloader({
                        zIndex: '6666666666'
                    });
                },

                success: function(response) {


                    $('.someBlock').preloader('remove');

                    if (response.status == true) {
                        Swal.fire(
                            'ثبت شو!',
                            'معــلومات په مکمـــل توګــه ثبت شــــو!',
                            'success'
                        );

                        setTimeout(() => {
                            $('#store_form')[0].reset();
                            toggleChildrenField(); // reset
                            location.assign("{{ route('suspects.index') }}");
                        }, 500); // delay to show success popup

                    } else {
                        $.each(response, function(field, msg) {
                            let input;

                            if (field.startsWith('file.')) {
                                input = $("[name='file[]']");
                            } else {
                                input = $("[name='" + field + "']");
                            }
                            input.addClass('error').attr('aria-invalid', true);

                            if ($("#" + field + "-error").length) {
                                $("#" + field + "-error").html(
                                    '<span class="text-danger" style="font-size:12px;font-weight:bold;float:left">' +
                                    msg[0] + '</span>'
                                ).show();
                            } else {
                                input.after(
                                    '<label id="' + field +
                                    '-error" class="error">' +
                                    '<span class="text-danger" style="font-size:12px;font-weight:bold;float:left">' +
                                    msg[0] + '</span></label>'
                                );
                            }
                        });
                    }
                },

                error: function(xhr) {


                    if (xhr.status === 422) {

                        let errors = xhr.responseJSON;

                        $.each(errors, function(field, msg) {

                            let input;

                            if (field.startsWith('file.')) {
                                input = $("[name='file[]']");
                            } else {
                                input = $("[name='" + field + "']");
                            }

                            input.addClass('error');

                            input.after(
                                '<label class="error text-danger" style="font-size:12px;font-weight:bold;">' +
                                msg[0] +
                                '</label>'
                            );
                        });

                    } else {
                        // console.log(xhr.responseText);
                    }
                }
            });
        });

        // --- Reset modal when closed ---
        $('#suspectModal').on('hidden.bs.modal', function() {
            let modal = $(this);
            modal.find('label.error').remove();
            modal.find('.invalid-feedback').remove();
            modal.find('.is-invalid').removeClass('is-invalid');
            modal.find('.error').removeClass('error');
            $('#store_form')[0].reset();
            toggleChildrenField(); // Ensure children field is hidden/reset
        });

        // --- Clear form errors function ---
        function clearFormErrors() {
            $('#store_form').find('.error').removeClass('error');
            $('#store_form').find('[aria-invalid="true"]').attr('aria-invalid', false);
            $('#store_form').find('label.error').remove();
        }

    });
</script>


//edit modal related scripts
<script>
    $(document).ready(function() {

        function initEditSelect2() {

            // destroy first
            if ($('#edit_province').hasClass("select2-hidden-accessible")) {
                $('#edit_province').select2('destroy');
            }

            if ($('#edit_referring_authority').hasClass("select2-hidden-accessible")) {
                $('#edit_referring_authority').select2('destroy');
            }

            // province
            $('#edit_province').select2({
                dropdownParent: $('#editSuspectModal'),
                placeholder: 'ولایت انتخاب کړئ',
                allowClear: true,
                width: '100%'
            });

            // referring authority (AJAX + TAGS)
            $('#edit_referring_authority').select2({
                dropdownParent: $('#editSuspectModal'),
                placeholder: 'مرجع انتخاب یا اضافه کړئ',
                tags: true,
                allowClear: true,
                width: '100%',

                ajax: {
                    url: '/get-referring-authorities',
                    dataType: 'json',
                    delay: 250,

                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },

                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.referring_authority,
                                    text: item.referring_authority
                                };
                            })
                        };
                    },

                    cache: true
                }
            });
        }

        // ===========================
        // SELECT2 INIT
        // ===========================
        function initSelect2() {
            $('#edit_province').select2({
                dropdownParent: $('#editSuspectModal'),
                placeholder: 'ولایت انتخاب کړئ',
                allowClear: true,
                width: '100%'
            });
        }

        $('#editSuspectModal').on('shown.bs.modal', function() {
            initEditSelect2();
            if ($('#edit_province').hasClass("select2-hidden-accessible")) {
                $('#edit_province').select2('destroy');
            }
            // initSelect2();
        });


        $('#edit_form').validate({

            // ignore: ":hidden:not(.select2-hidden-accessible)",

            rules: {
                gender: {
                    required: true
                },
                suspect_name: {
                    required: true,

                },
                father_name: {
                    required: true
                },
                grandfather_name: {
                    required: true
                },
                crime_type: {
                    required: true
                },
                referring_authority: {
                    required: true
                },
                monitoring_date: {
                    required: true
                },
                province: {
                    required: true
                },
                district: {
                    required: true
                },
                area: {
                    required: true
                },
                'edit_files[]': {
                    required: function() {


                        let newFiles = $('#edit_file_input')[0].files.length;


                        let oldFiles = $('#edit_existing_files_area .old-file-item').length;


                        return (newFiles === 0 && oldFiles === 0);
                    }
                }
            },


            messages: {
                gender: "جنسیت انتخاب کړئ",
                suspect_name: {
                    required: "د مظنون نوم داخل کړئ",

                },
                father_name: "د مظنون د پلار نوم داخل کړئ",
                grandfather_name: "د مظنون د نیکه نوم داخل کړئ",
                crime_type: "د مظنون د جرم ډول انتخاب کړئ",
                referring_authority: "رالیږونکې  مرجع انتخاب کړئ",
                monitoring_date: "د مظنون د څارنې نیټه انتخاب کړئ",
                province: "ولایت انتخاب کړئ",
                district: "ناحیه انتخاب کړئ",
                area: "سیمه انتخاب کړئ",
                'edit_files[]': "فایل انتخاب کړئ"


            },

            errorElement: 'div',
            errorClass: 'invalid-feedback',

            highlight: function(element) {
                if ($(element).hasClass('select2-hidden-accessible')) {
                    $(element).next('.select2').find('.select2-selection')
                        .addClass('is-invalid');
                } else {
                    $(element).addClass('is-invalid');
                }
            },

            unhighlight: function(element) {
                if ($(element).hasClass('select2-hidden-accessible')) {
                    $(element).next('.select2').find('.select2-selection')
                        .removeClass('is-invalid');
                } else {
                    $(element).removeClass('is-invalid');
                }
            },

            errorPlacement: function(error, element) {
                if (element.hasClass('select2-hidden-accessible')) {
                    error.insertAfter(element.next('.select2'));
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $('#edit_province, #edit_referring_authority').on('change', function() {
            $(this).valid();
        });

        // ===========================
        // TOGGLE FIELD
        // ===========================
        function toggleEditChildrenField() {
            if ($('#edit_gender').val() === 'ښځینه') {
                $('#edit_childrenWithMotherDiv').show();
            } else {
                $('#edit_childrenWithMotherDiv').hide();
            }
        }

        $('#edit_gender').on('change', toggleEditChildrenField);

        // ===========================
        // OPEN EDIT MODAL
        // ===========================
        $(document).on('click', '.edit-btn', function() {

            let id = $(this).data('id');

            // reset deleted files
            window.deletedFiles = [];
            $('#deleted_files').val('');

            $.ajax({
                url: '/suspects/edit/' + id,
                method: 'GET',

                success: function(data) {

                    $('#edit_form')[0].reset();

                    $('#edit_form').validate().resetForm();
                    $('#edit_form .form-control, #edit_form .form-select')
                        .removeClass('is-invalid');

                    // fill fields
                    $('#edit_suspect_id').val(data.id);
                    $('#edit_gender').val(data.gender);
                    $('#edit_suspect_name').val(data.suspect_name);
                    $('#edit_father_name').val(data.father_name);
                    $('#edit_grandfather_name').val(data.grandfather_name);
                    $('#edit_children_with_mother').val(data.children_with_mother);
                    $('#edit_crime_type').val(data.crime_type);
                    $('#edit_monitoring_date').val(data.monitoring_date);
                    $('#edit_district').val(data.district);
                    $('#edit_area').val(data.area);

                    $('#edit_province').val(data.province).trigger('change');

                    if (data.referring_authority) {
                        let option = new Option(
                            data.referring_authority,
                            data.referring_authority,
                            true,
                            true
                        );
                        $('#edit_referring_authority').append(option).trigger('change');
                    }

                    // =========================
                    //  SHOW OLD FILES + PREVIEW
                    // =========================
                    let html = '';

                    if (data.files && data.files.length > 0) {

                        data.files.forEach(function(file) {

                            let fileUrl = '/' + file.file_path;
                            let ext = file.file_path.split('.').pop().toLowerCase();

                            let preview = '';

                            // 🔥 Image preview
                            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(
                                    ext)) {

                                preview = `
                              <img src="${fileUrl}" 
                             class="rounded border me-2"
                                style="width:60px;height:60px;object-fit:cover;">
                              `;

                            }
                            // 📄 PDF
                            else if (ext === 'pdf') {
                                preview =
                                    `<i class="bi bi-file-earmark-pdf text-danger fs-2 me-2"></i>`;
                            }
                            // 📊 Excel
                            else if (['xls', 'xlsx'].includes(ext)) {
                                preview =
                                    `<i class="bi bi-file-earmark-excel text-success fs-2 me-2"></i>`;
                            }
                            // 📝 Word
                            else if (['doc', 'docx'].includes(ext)) {
                                preview =
                                    `<i class="bi bi-file-earmark-word text-primary fs-2 me-2"></i>`;
                            }
                            // 📁 Default
                            else {
                                preview =
                                    `<i class="bi bi-file-earmark text-secondary fs-2 me-2"></i>`;
                            }

                            html += `
                               <div class="d-flex align-items-center justify-content-between 
                                  border rounded p-2 mb-2 old-file-item">

                            <div class="d-flex align-items-center">
                           ${preview}

                               <div>
                                   <a href="${fileUrl}" target="_blank" 
                                      class="fw-bold text-dark text-hover-primary">
                                        فایل لیدل
                                  </a>
                                   <div class="text-muted small">
                                  ${ext.toUpperCase()}
                                </div>
                                   </div>
                                      </div>

                                   <button type="button" 
                                 class="btn btn-sm btn-light-danger remove-old-file" title="فایل حذف کول"
                                data-id="${file.id}">
                                   ❌
                                  </button>

                               </div>
                                          `;
                        });

                    } else {
                        html = `<small class="text-muted">هیڅ فایل نشته</small>`;
                    }

                    $('#edit_existing_files_area').html(html);

                    toggleEditChildrenField();
                    $('#editSuspectModal').modal('show');
                }
            });
        });
        window.deletedFiles = [];

        $(document).on('click', '.remove-old-file', function() {


            let btn = $(this);
            let id = btn.data('id');

            Swal.fire({
                title: 'ډاډه یې؟',
                text: "دا فایل به حذف شي!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'هو، حذف یې کړه!',
                cancelButtonText: 'نه'
            }).then((result) => {

                if (result.isConfirmed) {

                    window.deletedFiles.push(id);
                    $('#deleted_files').val(window.deletedFiles.join(','));

                    btn.closest('.old-file-item').remove();

                    Swal.fire({
                        icon: 'success',
                        title: 'فایل حذف شو!',
                        timer: 1000,
                        showConfirmButton: false
                    });
                }
            });



            $('#edit_file_input').valid();
        });


        $('#edit_file_input').on('change', function() {

            let previewArea = $('#edit_existing_files_area');

            Array.from(this.files).forEach(file => {

                let reader = new FileReader();

                reader.onload = function(e) {

                    let ext = file.name.split('.').pop().toLowerCase();

                    let preview = '';

                    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                        preview = `<img src="${e.target.result}" 
                            style="width:60px;height:60px;object-fit:cover;" 
                            class="rounded border me-2">`;
                    } else {
                        preview = `<i class="bi bi-file-earmark fs-2 me-2"></i>`;
                    }

                    let html = `
                      <div class="d-flex align-items-center border rounded p-2 mb-2">

                        ${preview}

                       <div class="small text-muted">
                        نوی فایل
                        </div>

                        </div> `;


                    previewArea.append(html);
                };

                reader.readAsDataURL(file);
            });
        });


        $('#edit_form').submit(function(e) {

            if (!$(this).valid()) {
                return false;
            }

            e.preventDefault();

            let id = $('#edit_suspect_id').val();

            $.ajax({
                url: "{{ route('suspects.update', ['id' => ':id']) }}".replace(':id', id),
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                dataType: 'json',

                success: function(response) {

                    if (response.status === true) {

                        Swal.fire({
                            icon: 'success',
                            title: 'معلومات په بریالیتوب سره تغیر شول!',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $('#editSuspectModal').modal('hide');

                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    }

                }
            });
        });

        // ===========================
        // RESET ON CLOSE
        // ===========================
        $('#editSuspectModal').on('hidden.bs.modal', function() {

            $('#edit_form')[0].reset();

            $('#edit_form').validate().resetForm();

            $('#edit_form .form-control, #edit_form .form-select')
                .removeClass('is-invalid');

            $('#edit_province').val(null).trigger('change');
        });

    });
</script>




<script>
    $(document).on('click', '.release-btn', function(e) {

        e.preventDefault();
        let suspectId = $(this).data('id');
        $('#release_suspect_id').val(suspectId);
        // $('#releaseModal').modal('show');
        new bootstrap.Modal(document.getElementById('releaseModal')).show();
    });
    $('#releaseForm').on('submit', function(e) {

        let isValid = true;
        $('.text-danger').remove();

        function showError(input, message) {
            isValid = false;
            $(input).after('<small class="text-danger">' + message + '</small>');
        }

        let number = $('#issued_or_transferred_number').val();
        let option = $('#main_option_key').val();
        let date = $('#release_date').val();
        let files = $('#release_files')[0].files;

        if (!number) {
            showError('#issued_or_transferred_number', 'د صادرې یا انتقال شمېره ضروري ده.');
        }

        if (!option) {
            showError('#releaseDropdownBtn', 'مهرباني وکړئ یوه مرجع انتخاب کړئ.');
        }

        if (!date) {
            showError('#release_date', 'د رهایي نېټه ضروري ده.');
        }
        if (!files.length) {
            showError('#release_files', 'لطفاً حداقل یو فایل انتخاب کړئ.');
        }

        if (!isValid) {
            e.preventDefault();
            return;
        }

        e.preventDefault();

        $.ajax({
            url: "{{ route('release.store') }}",
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function(res) {
                if (res.status == true) {

                    Swal.fire({
                        icon: 'success',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false

                    });
                    $('#releaseModal').modal('hide');

                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            }
        });
    });

    $('#releaseModal').on('show.bs.modal', function() {
        $('#releaseForm')[0].reset();
        $('.text-danger').remove();
    });
    $(document).on('change', '.main-opt', function() {

        let selectedText = $(this).next('label').text();
        let key = $(this).data('key');

        // label update
        $('#releaseDropdownLabel').text(selectedText);

        // hidden input set
        $('#main_option_key').val(key);


        if (key === 'detention') {
            let dropdown = bootstrap.Dropdown.getInstance(document.getElementById('releaseDropdownBtn'));
            if (dropdown) {
                dropdown.hide();
            }
        }
    });

    $('#releaseModal').on('hidden.bs.modal', function() {

        let form = $('#releaseForm');

        // ✅ reset form fields
        form[0].reset();

        // ✅ remove validation messages
        form.find('.text-danger').remove();

        // ✅ remove invalid classes
        form.find('.is-invalid').removeClass('is-invalid');


        $('#main_option_key').val('');
        $('#db_source_name').val('');
        $('#release_suspect_id').val('');

        // ✅ reset dropdown label
        $('#releaseDropdownLabel').text(
            "{{ __('translate.select_authority') }}");

        // ✅ uncheck radio buttons
        $('input[name="main_option"]').prop('checked', false);

        // ✅ uncheck db checkboxes
        $('.db-opt').prop('checked', false);

        // ✅ hide dynamic sections
        $('#db_search_wrapper').hide();
        $('#db_options_wrapper').hide();


    });
</script>

<!-- JS: behavior & sync label -->
<script>
    document.getElementById('db_search_wrapper').style.display = 'block';


    document.addEventListener("DOMContentLoaded", function() {
        let mainOptions = document.querySelectorAll(".main-opt");
        let dbWrapper = document.getElementById("db_options_wrapper");
        let dbOptions = document.querySelectorAll(".db-opt");
        let label = document.getElementById("releaseDropdownLabel");

        // Hidden fields
        let mainKey = document.getElementById("main_option_key");
        let dbName = document.getElementById("db_source_name");
        let dropdownBtn = document.getElementById("releaseDropdownBtn");

        // Reset both hidden fields
        function resetDB() {
            dbOptions.forEach(x => x.checked = false);
            dbName.value = "";
        }

        // MAIN OPTION logic
        mainOptions.forEach(opt => {
            opt.addEventListener("change", function() {

                let key = this.dataset.key; // detention, multi, release
                let title = this.value;

                // set main option key
                mainKey.value = key;

                resetDB(); // reset DB list

                if (key === "detention") {
                    dbWrapper.style.display = "none";
                    dbName.value = null;

                    label.textContent = title;

                    bootstrap.Dropdown.getInstance(dropdownBtn).hide();
                    return;
                }

                if (key === "multi" || key === "release") {
                    dbWrapper.style.display = "block";

                    // Label shows only main category until DB selected
                    label.textContent = title;
                }
            });
        });

        // DB option selected
        dbOptions.forEach(opt => {
            opt.addEventListener("change", function() {

                dbOptions.forEach(x => {
                    if (x !== this) x.checked = false;
                });

                dbName.value = this.value; // store DB name

                label.textContent = this.value;

                bootstrap.Dropdown.getInstance(dropdownBtn).hide();
            });
        });
    });



    // Search functionality
    document.getElementById('db_option_search').addEventListener('keyup', function() {
        let searchValue = this.value.toLowerCase();
        let items = document.querySelectorAll('.db-option-item');

        items.forEach(function(item) {
            let text = item.innerText.toLowerCase();
            item.style.display = text.includes(searchValue) ? '' : 'none';
        });
    });
</script>
@endsection
