@extends('layouts.master')
@section('content')
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0"> د خلاص /انتقال شویو مظنونینو لیست </h4>

            <style>
                /* ---------- Action Buttons Container ---------- */
                .action-buttons {
                    display: flex;
                    gap: 6px;
                    /* space between buttons */
                }

                /* Base Button Styling */
                .action-buttons a {
                    display: flex !important;
                    /* override inline styles */
                    align-items: center;
                    justify-content: center;
                    gap: 6px;
                    cursor: pointer;
                    border-radius: 4px;
                    padding: 4px 6px;
                    transition: all 0.25s ease-in-out;
                    text-decoration: none;
                }

                /* SVG icons always white */
                .action-buttons a svg {
                    stroke: #fff !important;
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

                .release_destroy_btn {
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

                /* Tooltip for SVG buttons */
                .action-buttons a[data-title] {
                    position: relative;
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
            </style>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped  table-checkable align-middle"
                    id="release_table">
                    <thead style="background-color:#c1effa;">
                        <tr class="bg-primary-o-10">
                            <th>شماره</th>
                            <th>نوم</th>
                            <th>د پلار نوم</th>
                            <th>جرم</th>
                            <th>رالیږونکې مرجع</th>
                            <th>ولایت</th>
                            <th>ناحیه</th>
                            <th>منطقه</th>
                            <th>د نظارت نیټه</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {

            // --- DataTable initialization ---
            $('#release_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('release.list') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'suspect_name',
                        name: 'suspect_name'
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
                    // {
                    //     data: 'issued_or_transferred_number',
                    //     name: 'issued_or_transferred_number'
                    // },
                    // {
                    //     data: 'released_by',
                    //     name: 'released_by'
                    // },
                    {
                        data: 'monitoring_date',
                        name: 'monitoring_date'
                    },
                    {
                        data: 'action',
                        className: 'text-center font-weight-bolder'
                    },
                ]
            });
        });
    </script>
    <script>
        $(document).on('click', '.release_destroy_btn', function() {
            let suspectId = $(this).data('id');

            Swal.fire({
                title: 'ایا تاسې ډاډه یاست؟',
                text: 'تاسې به دا معلومات حذف کړئ!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: ' هو',
                cancelButtonText: 'نه!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('release.destroy', '') }}/" + suspectId,
                        type: 'GET',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === true) {
                                Swal.fire(
                                    'حذف شو!',
                                    'معلومات په بریالیتوب سره حذف شول.',
                                    'success'
                                );
                                $('#suspects_table').DataTable().ajax.reload();
                            } else {
                                Swal.fire(
                                    'خطا!',
                                    'د معلوماتو د حذف کولو پر مهال ستونزه رامنځته شوه.',
                                    'error'
                                );
                            }
                            $('#release_table').DataTable().ajax.reload();

                        },
                        error: function() {
                            Swal.fire(
                                'خطا!',
                                'د معلوماتو د حذف کولو پر مهال ستونزه رامنځته شوه.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endsection
