@extends('layouts.master')
@section('content')
@section('css')
    <!-- Your custom CSS -->
    <style>
        .yajra-datatable th,
        .yajra-datatable td {
            font-size: 16px;
            /* or any desired font size */
        }
    </style>
@endsection
<!--begin::datatable-->
<div class="card shadow-sm mt-6">
    <div class="card-header">
        <div class="card-title" style="font-size: 20px !important;font-weight:bold">
            {{ __('translate.contact') }}

        </div>


    </div>

    <div class="card-body">
        <div class="table table-responsive">
            <table id="table_id" class="table yajra-datatable">
                <thead class="bg-light" style="font-weight:bold">
                    <th style="text-align:center">{{ __('translate.id') }}</th>
                    <th style="text-align:center">{{ __('translate.name') }}</th>
                    <th style="text-align:center">{{ __('translate.email') }}</th>
                    <th style="text-align:center">{{ __('translate.subject') }}</th>
                    <th style="text-align:center">{{ __('translate.message') }}</th>
                </thead>
                <tbody style="text-align:center">
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--end::datatable-->

{{-- Delete Model  --}}

<div class="modal fade" tabindex="-1" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">{{ __('translate.deleting information') }}</h1>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <p>{{ __('translate.are you sure to delete the record') }}</p>
            </div>

            <div class="modal-footer">
                <a href="#" class="btn btn-warning text-black"
                    data-bs-dismiss="modal">{{ __('translate.cancel') }}</a>
                <a class="btn btn-success delete">{{ __('translate.confirm') }}!</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var table = $('.yajra-datatable').DataTable({
            "paging": true,
            "lengthChange": true,
            "info": true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('contacts.index') }}",
            columns: [{
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'subject'
                },
                {
                    data: 'message'
                },

            ],
            orderable: true,
            searchable: true,
            order: [
                [0, 'decs']
            ],
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
        });

    });
</script>
<script>
    function deleteData(id) {
        $('#deleteModal').modal('show');
        delete_id = id;
    }

    $(document).ready(function() {
        $(document).on('click', '.delete', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('doctors.destroy', ':id') }}".replace(':id', delete_id),
                method: "GET",
                data: {
                    id: delete_id,
                },
                dataType: 'json',
                beforeSend: function() {
                    $('.someBlock').preloader({
                        zIndex: '6666666666'
                    });
                },
                success: function(response) {
                    $('.someBlock').preloader('remove');
                    if (response.status == true) {
                        success(response.message);
                        location.assign("{{ route('doctors.index') }}");
                    }
                },
                error: function() {

                    error_function('! System Error Call Administrator Of System');
                }
            });
        });
    });
</script>
@endsection
