<script src="{{asset('tabler/js/demo-theme.min.js?v=1')}}"></script>
<script src="{{asset('tabler/js/tabler.min.js?v=1')}}" defer></script>
<script src="{{asset('tabler/js/demo.min.js?v=1')}}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- jQuery (required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- DataTables Bootstrap 5 integration JS -->
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<!-- Responsive DataTables JS -->
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<!-- Responsive Bootstrap 5 integration JS -->
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>

<script src="{{ asset('massage/toastr/toastr.js') }}"></script>

<script>
$(document).ready(function() {
    $('#dataTables').DataTable({
        responsive: true,
        columnDefs: [
            { orderable: false, targets: [3] } // Disable ordering on the 'Action' column
        ],
        "language": {
            "emptyTable": "No data available",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "No entries to show",
            "search": "Search:",
            "paginate": {
                "previous": "Previous",
                "next": "Next"
            }
        }
    });
});
</script>