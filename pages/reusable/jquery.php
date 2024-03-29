<script src="../app/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../app/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>


<!-- Bootstrap 4 -->
<!-- <script src="../app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
<!-- ChartJS (merged inside app.min.js) -->
<!-- <script src="../app/plugins/chart.js/Chart.min.js"></script> -->
<!-- Sparkline -->
<script src="../app/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<!-- <script src="../app/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../app/plugins/jqvmap/maps/jquery.vmap.usa.js"></script> -->
<!-- jQuery Knob Chart (merged inside app.min.js) -->
<!-- <script src="../app/plugins/jquery-knob/jquery.knob.min.js"></script> -->
<!-- daterangepicker -->
<script src="../app/plugins/moment/moment.min.js"></script>
<!-- <script src="../app/plugins/daterangepicker/daterangepicker.js"></script> -->
<!-- Tempusdominus Bootstrap 4 (merged inside app.min.js) -->
<!-- <script src="../app/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> -->
<!-- Summernote -->
<!-- <script src="../app/plugins/summernote/summernote-bs4.min.js"></script> -->
<!-- overlayScrollbars -->
<script src="../app/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../app/dist/js/adminlte.js"></script>
<!-- custom js -->
<script src="../js/app.min.js"></script>
<script src="../js/graphs.js"></script>
<script src="../js/customize.js"></script>


<!-- datatables -->
<script src="../app/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../app/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../app/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../app/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../app/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../app/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../app/plugins/jszip/jszip.min.js"></script>
<script src="../app/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../app/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../app/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../app/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../app/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>