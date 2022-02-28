
 <!--   Optional JS   -->
 <script src="{{ asset('/admin/js/plugins/chart.js/dist/Chart.min.js') }}"></script>
 <script src="{{ asset('/admin/js/plugins/chart.js/dist/Chart.extension.js') }}"></script>
 <!--   Argon JS   -->
 <script src="{{ asset('/admin/js/argon-dashboard.min.js?v=1.1.2') }}"></script>
 {{-- <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script> --}}
 <!-- DataTables -->
 <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

 <!--  Notifications Plugin    -->
 <script src="{{ asset('js/plugins/bootstrap-switch.js')}}"></script>
<script src="{{ asset('/js/plugins/bootstrap-notify.js')}}"></script>
<script src="{{ asset('/js/demo.js')}}"></script>

 

 <script>
     window.TrackJS &&
         TrackJS.install({
             token: "ee6fab19c5a04ac1a32a645abde4613a",
             application: "argon-dashboard-free"
         });

        
 </script>
 <script type="text/javascript">
     let language = {
         "decimal": "",
         "emptyTable": "Không có dữ liệu phù hợp",
         "info": "Đang xem từ _START_ đến _END_ trên tổng _TOTAL_ ",
         "infoEmpty": "Đang xem từ 0 đến 0 trên tổng 0 ",
         "infoFiltered": "(lọc trong _MAX_ total)",
         "infoPostFix": "",
         "thousands": ",",
         "lengthMenu": "Hiển thị _MENU_ ",
         "loadingRecords": "Đang tải...",
         "processing": "Đang xử lý...",
         "search": "Tìm kiếm:",
         "zeroRecords": "Không tìm thấy dữ liệu phù hợp",
         "paginate": {
             "first": "Đầu tiên",
             "last": "Cuối",
             "next": ">",
             "previous": "<"
         },
         "aria": {
             "sortAscending": ": sắp xếp tăng dần",
             "sortDescending": ": sắp xép giảm dần"
         }
     };
    var tableMembers =  $('#members-table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{ route('members.data') }}",
         language: language,
         columns: [{
                 data: 'id',
                 name: 'id'
             },
             {
                 data: 'img',
                 name: 'img'
             },
             {
                 data: 'name',
                 name: 'name'
             },
             {
                 data: 'dob',
                 name: 'dob',
             },
             {
                 data: 'dod',
                 name: 'dod'
             },
             {
                 data: 'gender',
                 name: 'gender'
             },
             {
                 data: 'action',
                 name: 'action'
             },

         ]
     });
 </script>
