
<script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- chartjs -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<!-- overlayScrollbars -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/2.7.0/browser/overlayscrollbars.browser.es6.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>




<!-- sweet alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $('.delete').on('click', function (e) {
    e.preventDefault();

    const href = $(this).attr('href');

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.value) {
              document.location.href = href;
              // Swal.fire({
              // title: "Deleted!",
              // text: "Your record has been deleted.",
              // icon: "success"
              // });
            }
        });
  });
</script>





<!-- custom js -->
<script src="../js/app.min.js"></script>
<script src="../js/graphs.js"></script>
<script src="../js/customize.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<!-- show password -->
<script>
    let eyeIcon = document.getElementById('eye-icon');
    let password = document.getElementById('password');

    let cEyeIcon = document.getElementById('c-eye-icon');
    let cPassword = document.getElementById('c-password');

    eyeIcon.addEventListener('click', function(){
        if(password.type === 'password'){
            password.type = 'text';
        }else {
            password.type = 'password';
        }
    })

    cEyeIcon.addEventListener('click', function(){
        if(cPassword.type === 'password'){
            cPassword.type = 'text';
        }else {
            cPassword.type = 'password';
        }
    })
</script>




<!-- datatables -->
<script src="../app/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../app/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../app/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../app/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../app/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../app/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.10/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.10/pdfmake.min.js"></script>
<script src="../app/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../app/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../app/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    $("#example3").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false
    }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
    $("#example4").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false
    }).buttons().container().appendTo('#example4_wrapper .col-md-6:eq(0)');
  });
</script>



<script>
  let updateNotif = document.querySelector('.update-notif');
  setTimeout(() => {
      updateNotif.style.display = 'none';
  }, 5000);

  let imgErrorNotif = document.querySelector('.img-error-notif');
  setTimeout(() => {
      imgErrorNotif.style.display = 'none';
  }, 5000);

  let imgSizeError = document.querySelector('.img-size-error');
  setTimeout(() => {
      imgSizeError.style.display = 'none';
  }, 5000);
</script>