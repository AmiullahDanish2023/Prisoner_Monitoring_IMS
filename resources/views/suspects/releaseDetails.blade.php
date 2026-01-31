@extends('layouts.master')

@section('header-menu')
@endsection

@section('content')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

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
                                <td>
                                    @if ($suspect->file)
                                        <a href="{{ asset($suspect->file) }}" target="_blank" class="text-primary">لیدل</a>
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
                                    <th>صادره رهایی ویا انتقال</th>
                                    <th>مرجع رها کننده</th>
                                    <th>د انتقال کولو نیټه</th>
                                    <th>د رهایی یا انتقال فایل لیدل</th>
                                    @if (!empty($suspect->release?->items_status))
                                        <th>مظنون د وسایلو حالت</th>
                                    @endif

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
                                    <td>
                                        @if ($suspect->release && $suspect->release->file)
                                            <a href="{{ asset($suspect->release->file) }}" target="_blank"
                                                class="text-primary">لیدل</a>
                                        @else
                                            ---
                                        @endif
                                    </td>
                                    <td>

                                        {{-- د وسایلو حالت badge --}}
                                        @if ($suspect->release && !empty($suspect->notes))
                                            @if ($suspect->release->items_status === 'confiscated')
                                                <span class="badge bg-success cursor-pointer" data-bs-toggle="modal"
                                                    data-bs-target="#itemsModal{{ $suspect->id }}">
                                                    وسایل مظنون ته تسلیم شوي
                                                </span>
                                            @elseif ($suspect->release->items_status === 'not_confiscated')
                                                <span class="badge bg-danger cursor-pointer" data-bs-toggle="modal"
                                                    data-bs-target="#itemsModal{{ $suspect->id }}">
                                                    وسایل مظنون ته ندي تسلیم شوي
                                                </span>
                                            @endif
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

      

            <!-- Notes Modal -->
            <div class="modal fade" id="itemsModal{{ $suspect->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title text-center w-100"> له مظنون سره موجود وسایلو تفصیل</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <p style="white-space: pre-wrap;">
                                {{ $suspect->notes }}
                            </p>
                        </div>

                        <div class="modal-footer d-flex justify-content-between mb-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">بندول</button>

                            <a href="{{ route('suspects.release.notes.pdf', $suspect->id) }}" target="_blank"
                                class="btn btn-primary btn-sm">
                                پرینټ
                            </a>
                        </div>
                    </div>


                </div>
            </div>

        @endsection
