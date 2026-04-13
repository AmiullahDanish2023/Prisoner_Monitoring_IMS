@extends('layouts.master')

@section('header-menu')
@endsection

@section('content')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    

    <style>
        <style>.cursor-pointer {
            cursor: pointer;
        }
    </style>

    </style>

    <div class="container-fluid mt-4 px-5">

        <div class="card shadow-sm">
            <div class="card-header text-white d-flex justify-content-center align-items-center"
                style="background-color: #cfe3f1; height: 60px;">
                <h4 class="mb-0 font-weight-bold">جـزئــیات مظــــنون</h4>
            </div>

            <div class="card-body">

                <!-- Basic Information -->
                <h5 class="text-primary mb-3 border-bottom pb-2 font-weight-bold">اطلاعات اصلی</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-striped table-bordered text-center">
                        <thead style="background-color: #e3f2fd;">
                            <tr>
                                <th>جنسیت</th>
                                <th>نوم</th>
                                <th>د پلار نوم</th>
                                <th>د نیکه نوم</th>

                                @if ($suspect->children_with_mother)
                                    <th>د مور سره ماشومان</th>
                                @endif
                                <th>جرم</th>
                                <th>رالیږونکې مرجع</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $suspect->gender }}</td>
                                <td>{{ $suspect->suspect_name }}</td>
                                <td>{{ $suspect->father_name }}</td>
                                <td>{{ $suspect->grandfather_name }}</td>
                                @if ($suspect->children_with_mother)
                                    <td>{{ $suspect->children_with_mother }}</td>
                                @endif
                                <td>{{ $suspect->crime_type }}</td>
                                <td>{{ $suspect->referring_authority }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Location Information -->
                <h5 class="text-primary mb-3 border-bottom pb-2 font-weight-bold">محل سکونت و نظارت</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-striped table-bordered text-center">
                        <thead style="background-color: #e3f2fd;">
                            <tr>
                                <th>ولایت</th>
                                <th>ناحیه</th>
                                <th>منطقه</th>
                                <th>د نظارت نیټه</th>
                                <th>د مظنون د معرفی فایل لیدل</th>


                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $suspect->provinceRelation->name_da ?? '---' }}</td>
                                <td>{{ $suspect->district }}</td>
                                <td>{{ $suspect->area }}</td>
                                <td>{{ $suspect->monitoring_date }}</td>
                                <td class="text-center">
                                    @php
                                        $suspectFiles = $suspect->files->where('file_type', 'suspect');
                                    @endphp

                                    @if ($suspectFiles->count() > 0)
                                        <a href="{{ route('suspects.files', $suspect->id) }}" target="_blank"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-folder-open"></i>
                                            د فایلونو لیدل ({{ $suspectFiles->count() }})
                                        </a>
                                    @else
                                        ---
                                    @endif
                                </td>

                            </tr>
                        </tbody>
                    </table>
                    <!-- RELEASE DETAILS SECTION -->
                    <h5 class="text-primary mb-3 border-bottom pb-2 font-weight-bold">د انتقال کولو معلومات</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-striped table-bordered text-center">
                            <thead style="background-color: #e3f2fd;">
                                <tr>
                                    <th>د رهايي یا انتقال د صادرې شمېر</th>
                                    <th>د رهايي / انتقال مرجع</th>
                                    <th>د انتقال کولو نیټه</th>
                                    <th>د رهایی یا انتقال فایل لیدل</th>
                                    <th>توکي موجود وو؟</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        {{ $suspect->release->issued_or_transferred_number ?? '---' }}
                                    </td>
                                    <td>
                                        @php
                                            $map = [
                                                'detention' => 'انتقال به توقیف',
                                                'multi' => 'انتقال به مراجع مختلف',
                                                'release' => 'مظنونین رهایی',
                                            ];

                                            $finalSource = !empty($suspect->release->db_source_name)
                                                ? $suspect->release->db_source_name
                                                : $map[$suspect->release->main_option_key] ?? null;
                                        @endphp

                                        {{ $finalSource }}
                                    </td>



                                    <td>
                                        {{ $suspect->release->release_date ?? '---' }}
                                    </td>
                                    <td class="text-center">
                                        @if ($suspect->releaseFiles->count() > 0)
                                            <a href="{{ route('suspects.release.files', $suspect->id) }}" target="_blank"
                                                class="btn btn-sm btn-success">

                                                <i class="fas fa-file-alt"></i>

                                                د ریلیز فایلونه
                                                ({{ $suspect->releaseFiles->count() }})

                                            </a>
                                        @else
                                            <span class="text-muted">---</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($suspect->has_items === 1)
                                            <span class="badge bg-success">هو</span>
                                        @elseif ($suspect->has_items === 0)
                                            <span class="badge bg-danger">نه</span>
                                        @else
                                            ---
                                        @endif
                                    </td>




                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('suspects.release') }}" class="btn btn-primary">بازگشت</a>
                    </div>

                </div>
            </div>
        </div>
    @endsection
