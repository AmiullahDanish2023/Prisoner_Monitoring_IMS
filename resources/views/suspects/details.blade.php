@extends('layouts.master')

@section('header-menu')
@endsection

@section('content')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <div class="container-fluid mt-4 px-5">

        <div class="card shadow-sm">
            <div class="card-header text-white d-flex justify-content-center align-items-center"
                style="background-color: #cfe3f1; height: 60px;">
                <h4 class="mb-0 font-weight-bold">جــزئــیات مظــــنون</h4>
            </div>

            <div class="card-body">

                <!-- Basic Information -->
                <legend></legend>
                <h5 class="text-primary mb-3 border-bottom pb-2 font-weight-bold">اطلاعات اصلی</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-striped table-bordered text-center">
                        <thead style="background-color: #e3f2fd;"> <!-- light header color -->
                            <tr>
                                 <th>جنسیت</th>
                                <th>نوم</th>
                                <th>د پلار نوم</th>
                                <th>د نیکه نوم</th>
                               
                               @if($suspect->children_with_mother)
                                <th>د مور سره ماشومان </th>
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
                        <thead style="background-color: #e3f2fd;"> <!-- light header color -->
                            <tr>
                                <th>ولایت</th>
                                <th>ناحیه</th>
                                <th>منطقه</th>
                                <th>د نظارت نیټه</th>
                                <th>د فایل لیدل</th>
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
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('suspects.index') }}" class="btn btn-primary">بازگشت</a>
                </div>

            </div>
        </div>
    </div>
@endsection
