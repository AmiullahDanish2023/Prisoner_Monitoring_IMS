@extends('layouts.master')

@section('content')
    <div class="card shadow-sm">

        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0 fw-bold text-align-center">د مراجعو لیست</h4>
            @can('Save New Suspect  Reference')
                <a href="{{ route('release-sources.create') }}" class="btn btn-primary btn-sm">
                    نوې مرجع اضافه کړئ
                </a>
            @endcan

            <style>
                /* ------------------ Card Header ------------------ */
                .card-header {
                    background: #f1fbff !important;
                    border-bottom: 1px solid #d7f3ff;
                    padding: 15px 20px !important;
                }

                /* ------------------ Table Styling ------------------ */
                table.table {
                    border-radius: 10px !important;
                    overflow: hidden;
                    font-size: 14px;
                }

                table.table thead {
                    background-color: #c1effa !important;
                }

                table.table thead th {
                    font-weight: 700;
                    color: #00394f;
                }

                table.table tbody tr:hover {
                    background-color: #f7fdff !important;
                    transition: 0.2s ease-in-out;
                }

                /* ------------------ Action Buttons ------------------ */
                .action-buttons {
                    display: flex;
                    gap: 6px;
                }

                .action-buttons a {
                    padding: 5px 8px;
                    border-radius: 5px;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 13px;
                    color: #fff !important;
                    text-decoration: none;
                    transition: 0.2s ease;
                }

                .action-buttons a:hover {
                    transform: scale(1.05);
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
                }

                .edit-btn {
                    background-color: #0dcaf0;
                }

                .delete-btn {
                    background-color: #e26774;
                }

                /* Tooltip on hover */
                .action-buttons a[data-title] {
                    position: relative;
                }

                .action-buttons a[data-title]::after {
                    content: attr(data-title);
                    position: absolute;
                    bottom: 130%;
                    left: 50%;
                    transform: translateX(-50%);
                    background: #000;
                    padding: 4px 7px;
                    border-radius: 4px;
                    color: #fff;
                    font-size: 11px;
                    opacity: 0;
                    white-space: nowrap;
                    transition: 0.25s ease;
                    pointer-events: none;
                }

                .action-buttons a[data-title]:hover::after {
                    opacity: 1;
                    bottom: 140%;
                }

                .swal2-title,
                .swal2-html-container {
                    font-family: 'Bahij', sans-serif !important;
                    font-weight: 700 !important;
                    /* bold */
                    font-size: 18px !important;
                }
            </style>
        </div>

        <!-- Body -->
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle" id="source_table">
                    <thead>
                        <tr>
                            <th>نمبر</th>
                            <th>نوم</th>
                            <th>نېټه</th>
                            <th style="width: 120px;">عملیات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($sources as $src)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $src->name_da }}</td>
                                <td>{{ jdate($src->created_at)->format('Y/m/d') }}</td>


                                <td>
                                    <div class="action-buttons">

                                        <!-- Edit -->
                                        @can('Edit Suspect Reference')
                                            <a href="javascript:void(0)" class="edit-btn" data-id="{{ $src->id }}"
                                                data-name="{{ $src->name_da }}" data-title="د مرجع نوم تغیرول">
                                                ✏️
                                            </a>
                                        @endcan

                                        <!-- Delete -->
                                        {{-- @can('Delete Suspect Reference')
                                            <a href="{{ route('release-sources.delete', $src->id) }}" class=" delete-btn"
                                                data-id="{{ $src->id }}" data-title="د مرجع حذف کول">
                                                🗑️
                                            </a>
                                        @endcan --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!-- Edit Modal -->
    <div class="modal fade" id="editSourceModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">
                        د مرجع نوم تغیرول
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="edit_id">

                    <div class="mb-3">
                        <label class="form-label">نوم (دری)</label>
                        <input type="text" id="edit_name_da" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">نوم (پښتو)</label>
                        <input type="text" id="edit_name_pa" class="form-control">
                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        بندول
                    </button>
                    <button type="button" class="btn btn-primary" id="updateBtn">
                        تغیر ثبت کړه
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Delete Script -->
    {{-- <script>
        $(document).on('click', '.delete-btn', function() {
            var suspectId = $(this).data('id');
            event.preventDefault();

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
                        url: "{{ route('release-sources.delete', '') }}/" + suspectId,
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
                                window.location.reload();

                            } else {
                                Swal.fire(
                                    'خطا!',
                                    'د معلوماتو د حذف کولو پر مهال ستونزه رامنځته شوه.',
                                    'error'
                                );
                            }
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
    </script> --}}
    <script>
        // Open modal and fill data
        $(document).on('click', '.edit-btn', function() {

            let id = $(this).data('id');
            let name = $(this).data('name');

            $('#edit_id').val(id);
            $('#edit_name_da').val(name);

            $('#editSourceModal').modal('show');
        });


        // Update request
        $('#updateBtn').click(function() {

            let id = $('#edit_id').val();

            $.ajax({
                url: "/release-sources/update/" + id,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    name_da: $('#edit_name_da').val(),
                    name_pa: $('#edit_name_pa').val()
                },
                success: function(response) {

                    if (response.status === true) {

                        Swal.fire(
                            'بریالی!',
                            'معلومات اپډیټ شول',
                            'success'
                        );

                        $('#editSourceModal').modal('hide');
                        location.reload();

                    } else {
                        Swal.fire('خطا!', 'اپډیټ کې ستونزه ده', 'error');
                    }
                },
                error: function() {
                    Swal.fire('خطا!', 'سرور ستونزه', 'error');
                }
            });
        });
    </script>
@endsection
