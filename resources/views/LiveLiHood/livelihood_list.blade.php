 @extends('layouts.master')

 @section('header-menu')
 @endsection
 @section('content')

     <style>
       

         /* ---------- Table Container ---------- */
         .table-responsive {
             border-radius: 10px;
             overflow: hidden;
             border: 1px solid #dee2e6;
             background: #fff;
         }

         /* ---------- Table Base ---------- */
         #monthly_livelihood_table {
             width: 100%;
             border-collapse: collapse !important;
             font-size: 14px;
             border: 1px solid #dee2e6;
         }

         /* ---------- Table Borders ---------- */
         #monthly_livelihood_table th,
         #monthly_livelihood_table td {
             border: 1px solid #dee2e6 !important;
             padding: 10px;
             text-align: center;
             vertical-align: middle;
         }

         /* ---------- Header ---------- */
         #monthly_livelihood_table thead th {
             background: #3f577c !important;
             color: #fff;
             font-weight: 600;
             text-align: center;
             vertical-align: middle;
         }

         /* ---------- Body Hover ---------- */
         #monthly_livelihood_table tbody tr {
             transition: all 0.2s ease-in-out;
         }

         #monthly_livelihood_table tbody tr:hover {
             background-color: #f1faff !important;
         }

         /* ---------- Striped Rows ---------- */
         /* #monthly_livelihood_table.table-striped tbody tr:nth-of-type(odd) {
             background-color: #f9fbfd;
         } */

         /* ---------- Action Buttons Container ---------- */
         .action-buttons {
             display: flex;
             justify-content: center;
             gap: 6px;
         }

         
         .action-buttons {
             display: flex;
             align-items: center;
             justify-content: center;
             gap: 8px;
         }

         /* ---------- Base Button Styling ---------- */
         .action-buttons a {
             display: inline-flex !important;
             align-items: center;
             justify-content: center;
             gap: 6px;

             min-width: 38px;
             height: 38px;

             padding: 0 12px;

             border-radius: 8px;
             cursor: pointer;
             text-decoration: none;

             transition: all 0.25s ease-in-out;

             box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
         }

         /* ---------- Icons ---------- */
         .action-buttons a i,
         .action-buttons a svg {
             color: #fff !important;
             stroke: #fff !important;
             font-size: 16px;
         }

         /* ---------- Hover Effect ---------- */
         .action-buttons a:hover {
             transform: translateY(-2px) scale(1.03);
             box-shadow: 0 6px 14px rgba(124, 56, 56, 0.18);
         }

         /* ---------- Active Click ---------- */
         .action-buttons a:active {
             transform: scale(0.96);
         }

         /* =========================================================
           BUTTON COLORS
        ========================================================= */

         .view-btn {
             background: linear-gradient(135deg, #4f9cf9, #1d4ed8);
             color: #fff !important;
         }

         .edit-btn {
             background: linear-gradient(135deg, #22d3ee, #0891b2);
             color: #fff !important;
         }

         .destroy_btn {
             background: linear-gradient(135deg, #fb7185, #dc2626);
             color: #fff !important;
         }

         .release-btn {
             background: linear-gradient(135deg, #4ade80, #16a34a);
             color: #fff !important;
         }

         .btn-transfer {
             background: linear-gradient(135deg, #facc15, #d97706);
             color: #fff !important;
         }

         /* =========================================================
           TOOLTIP
        ========================================================= */

         .action-buttons a[data-title] {
             position: relative;
         }

         .action-buttons a[data-title]::after {
             content: attr(data-title);

             position: absolute;
             bottom: 125%;
             left: 50%;
             transform: translateX(-50%);

             background: rgba(0, 0, 0, 0.9);
             color: #fff;

             font-size: 11px;
             padding: 5px 9px;

             border-radius: 5px;

             opacity: 0;
             white-space: nowrap;
             pointer-events: none;

             transition: all 0.25s ease;
             z-index: 999;
         }

         .action-buttons a[data-title]:hover::after {
             opacity: 1;
             bottom: 140%;
         }
     </style>

 @section('content')

     <div class="container-fluid">

         <h4 class="mb-4 fw-bold text-center">
            د بدل اعاشې راپور
         </h4>

         <div class="table-responsive">
             <table class="table table-bordered table-striped align-middle" id="monthly_livelihood_table">

                 <thead>
                     <tr>
                         <th>شمیره</th>
                         <th>د ورځو تعداد</th>
                         <th>د پلان تاریخ</th>
                         <th>مجموعي مصرف (AFN)</th>
                         <th>عملیات</th>
                     </tr>
                 </thead>

                 <tbody>
                 </tbody>

             </table>
         </div>

     </div>
 @endsection
 @section('scripts')
     <script>
         $('#monthly_livelihood_table').DataTable({
             processing: true,
             serverSide: true,
             ajax: "{{ route('livelihood.monthly.report') }}",

             columns: [{
                     data: 'DT_RowIndex',
                     name: 'DT_RowIndex'
                 },
                 {
                     data: 'days_count',
                     name: 'days_count'
                 },
                 {
                     data: 'livelihoodDate',
                     name: 'livelihoodDate'
                 },
                 {
                     data: 'total_amount',
                     name: 'total_amount'
                 },
                 {
                     data: 'action',
                     orderable: false,
                     searchable: false
                 }
             ]
         });
         //  
     </script>

     {{-- <script>
         $(document).on('click', '.delete-month', function() {
             var suspectId = $(this).data('id');
             event.preventDefault();

             Swal.fire({
                 title: 'ایا تاسې ډاډه یاست؟',
                 text: 'ایا د دې میاشت ټول راپورونه حذف شي؟',
                 icon: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#3085d6',
                 cancelButtonColor: '#d33',
                 confirmButtonText: ' هو',
                 cancelButtonText: 'نه!'
             }).then((result) => {
                 if (result.isConfirmed) {
                     $(document).on('click', '.delete-month', function(event) {

                         event.preventDefault();

                         var month = $(this).data('month'); // ✅ صحیح

                         Swal.fire({
                             title: 'ایا تاسې ډاډه یاست؟',
                             text: 'ایا د دې میاشت ټول راپورونه حذف شي؟',
                             icon: 'warning',
                             showCancelButton: true,
                             confirmButtonText: 'هو',
                             cancelButtonText: 'نه!'
                         }).then((result) => {
                             if (result.isConfirmed) {

                                 $.ajax({
                                     url: '/livelihood/month/' +
                                     month, // ✅ اوس month شته
                                     type: 'DELETE',
                                     data: {
                                         _token: '{{ csrf_token() }}'
                                     },
                                     success: function(response) {

                                         if (response.status === true) {
                                             Swal.fire('حذف شو!',
                                                 'معلومات حذف شول', 'success'
                                                 );
                                             location.reload();
                                         } else {
                                             Swal.fire('خطا!', 'حذف ونه شو',
                                                 'error');
                                         }

                                     }
                                 });

                             }
                         });
                     });
                 }
             });
         });
     </script> --}}
 @endsection
