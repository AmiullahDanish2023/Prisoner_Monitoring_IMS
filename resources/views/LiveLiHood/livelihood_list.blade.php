 @extends('layouts.master')

 @section('header-menu')
 @endsection
 @section('content')
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
            </style>

 @section('content')
 
     <div class="container-fluid">

         <h4 class="mb-4 fw-bold text-center">
             راپور  بدل اعاشه
         </h4>

         <div class="table-responsive">
             <table class="table table-bordered table-striped" id="weekly_livelihood_table">
                 <thead style="background:#9abacc">
                     <tr>
                         <th>#</th>
                         <th>هفته</th>
                         <th>تعداد روځ</th>
                         <th> تاریخ پلان</th>
                         <th>مجموع مصرف (AFN)</th>
                         <th>عملیات</th>
                     </tr>
                 </thead>
             </table>

         </div>

     </div>
 @endsection
@section('scripts')
<script>
    $('#weekly_livelihood_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('livelihood.week.report') }}",

    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
        { data: 'week_name', name: 'week_name' },
        { data: 'days_count', name: 'days_count' },
        { data: 'livelihoodDate', name: 'livelihoodDate' },
        { data: 'total_amount', name: 'total_amount' },
        { data: 'action', orderable: false, searchable: false }
    ]
});

</script>
@endsection