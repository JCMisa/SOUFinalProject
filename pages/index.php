<?php
@include '../configurations/config.php';
session_start();

if(isset($_SESSION['user_type']) && isset($_SESSION['user_name']) && isset($_SESSION['image']) && isset($_SESSION['user_id']) && isset($_SESSION['user_email']) && isset($_SESSION['organization'])){
  $user_type = $_SESSION['user_type'];
  $user_name = $_SESSION['user_name'];
  $user_image = $_SESSION['image'];
  $user_id = $_SESSION['user_id'];
  $user_email = $_SESSION['user_email'];
  $user_organization = $_SESSION['organization'];
}
else {
  header('location: ./identity/login.php');
  die();
}

$name = "JC";
?>

<!-- doctype -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SOU Management System</title>
    <?php include_once './reusable/head.php'; ?>

    <style>
      .events-body {
        max-height: 650px;
        overflow-y: auto;
        padding: 20px;
      }

      ::-webkit-scrollbar {
          width: 7px;
      }

      ::-webkit-scrollbar-thumb {
          background: #888;
      }

      ::-webkit-scrollbar-thumb:hover {
          background: #555;
      }

      .plan-item::after {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.6);
      }

      .plan-content {
        z-index: 999;
        max-width: 80%;
        overflow: scroll;
        white-space: nowrap;
      }

      td {
        max-width: 100px;
        overflow: hidden;
        white-space: nowrap;
      }

      /* The scrollbar itself */
      .plan-content::-webkit-scrollbar {
        width: 100%;
        height: 5px;
      }

      /* The scrollbar track */
      .plan-content::-webkit-scrollbar-track {
        background: transparent;
      }

      /* The scrollbar thumb (the part you drag) */
      .plan-content::-webkit-scrollbar-thumb {
        background: #888;
      }

      /* The scrollbar thumb when you hover over it */
      .plan-content::-webkit-scrollbar-thumb:hover {
        background: #555;
      }

      @media (max-width: 500px) {
        .submission-stats {
          display: none;
        }
      }

    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <?php include_once './reusable/preloader.php'; ?>

  <!-- Navbar -->
  <?php include_once './reusable/topNav.php'; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include_once './reusable/sideNav.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Hello! <?php echo $user_name ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <?php
      // get the total number of registered account
      $result = mysqli_query($conn, " SELECT COUNT(*) FROM user_tbl; ");
      $row = mysqli_fetch_array($result);
      $registration_count = $row[0];

      // get the total number of commitment form submitted
      $commitments = mysqli_query($conn, " SELECT COUNT(*) FROM commitment_tbl; ");
      $commitment_row = mysqli_fetch_array($commitments);
      $commitments_count = $commitment_row[0];

      // get the total number of application form submitted
      $applications = mysqli_query($conn, " SELECT COUNT(*) FROM application_tbl; ");
      $application_row = mysqli_fetch_array($applications);
      $applications_count = $application_row[0];

      // get the total number of renewal form submitted
      $renewals = mysqli_query($conn, " SELECT COUNT(*) FROM renewal_tbl; ");
      $renewal_row = mysqli_fetch_array($renewals);
      $renewals_count = $renewal_row[0];

      // get the total number of plan of activities form submitted
      $plans = mysqli_query($conn, " SELECT COUNT(*) FROM plans; ");
      $plan_row = mysqli_fetch_array($plans);
      $plans_count = $plan_row[0];

      // get the number of user roles (user, admin, super_admin)
      // users
      $user_roles = mysqli_query($conn, " SELECT COUNT(*) FROM user_tbl WHERE user_type = 'user'; ");
      $user_roles_row = mysqli_fetch_array($user_roles);
      $user_roles_count = $user_roles_row[0];
      //admins
      $admin_roles = mysqli_query($conn, " SELECT COUNT(*) FROM user_tbl WHERE user_type = 'admin'; ");
      $admin_roles_row = mysqli_fetch_array($admin_roles);
      $admin_roles_count = $admin_roles_row[0];
      //super_admins
      $super_admin_roles = mysqli_query($conn, " SELECT COUNT(*) FROM user_tbl WHERE user_type = 'super_admin'; ");
      $super_admin_roles_row = mysqli_fetch_array($super_admin_roles);
      $super_admin_roles_count = $super_admin_roles_row[0];

      // get the total number of application submissions
      $application_submissions = mysqli_query($conn, " SELECT COUNT(*) FROM application_upload WHERE form_type = 'application'; ");
      $application_submissions_row = mysqli_fetch_array($application_submissions);
      $application_submissions_count = $application_submissions_row[0];

      // get the total number of renewal submissions
      $renewal_submissions = mysqli_query($conn, " SELECT COUNT(*) FROM application_upload WHERE form_type = 'renewal'; ");
      $renewal_submissions_row = mysqli_fetch_array($renewal_submissions);
      $renewal_submissions_count = $renewal_submissions_row[0];

      // get the total number of commitment submissions
      $commitment_submissions = mysqli_query($conn, " SELECT COUNT(*) FROM application_upload WHERE form_type = 'commitment'; ");
      $commitment_submissions_row = mysqli_fetch_array($commitment_submissions);
      $commitment_submissions_count = $commitment_submissions_row[0];


      // get the total number of user registration depends on specific organization
      $current_user = " SELECT * FROM user_tbl WHERE id = $user_id; ";
      $result_current_user = mysqli_query($conn, $current_user);
      $row = mysqli_fetch_assoc($result_current_user);
      $organization = $row['organization'];

      $registrations = mysqli_query($conn, " SELECT COUNT(*) FROM user_tbl WHERE organization = '$organization'; "); 
      $registrations_row = mysqli_fetch_array($registrations);
      $registration_count2 = $registrations_row[0];  
      
      // get the total number of commitment form submitted for admin dashboard
      $commitments2 = mysqli_query($conn, " SELECT COUNT(*) FROM commitment_tbl WHERE organization = '$organization'; ");
      $commitment2_row = mysqli_fetch_array($commitments2);
      $commitments2_count = $commitment2_row[0];

      // get the total number of application form submitted for admin dashboard
      $application2 = mysqli_query($conn, " SELECT COUNT(*) FROM application_tbl WHERE organization = '$organization'; ");
      $application2_row = mysqli_fetch_array($application2);
      $application2_count = $application2_row[0];

      // get the total number of renewal form submitted for admin dashboard
      $renewal2 = mysqli_query($conn, " SELECT COUNT(*) FROM renewal_tbl WHERE organization = '$organization'; ");
      $renewal2_row = mysqli_fetch_array($renewal2);
      $renewal2_count = $renewal2_row[0];

      // get the total number of plans form submitted for admin dashboard
      $plan2 = mysqli_query($conn, " SELECT COUNT(*) FROM plans WHERE organization = '$organization'; ");
      $plan2_row = mysqli_fetch_array($plan2);
      $plan2_count = $plan2_row[0];

      // get the number of user roles (user, admin, super_admin) base on organization
      // users
      $user_roles2 = mysqli_query($conn, " SELECT COUNT(*) FROM user_tbl WHERE user_type = 'user' AND organization = '$organization'; ");
      $user_roles2_row = mysqli_fetch_array($user_roles2);
      $user_roles2_count = $user_roles2_row[0];
      // admins
      $admin_roles2 = mysqli_query($conn, " SELECT COUNT(*) FROM user_tbl WHERE user_type = 'admin' AND organization = '$organization'; ");
      $admin_roles2_row = mysqli_fetch_array($admin_roles2);
      $admin_roles2_count = $admin_roles2_row[0];
      // super admin
      $super_admin2 = mysqli_query($conn, " SELECT COUNT(*) FROM user_tbl WHERE user_type = 'super_admin' AND organization = '$organization'; ");
      $super_admin2_row = mysqli_fetch_array($super_admin2);
      $super_admin2_count = $super_admin2_row[0];

      if($user_type === 'super_admin')
      {
        echo 
          <<<CONTENT
                <section class="content">
                <div class="container-fluid">
                  <!-- Small boxes (Stat box) -->
                  <div class="row">
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-warning">
                        <div class="inner">
                          <h3>$registration_count</h3>

                          <p>User Registrations</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-person-add"></i>
                        </div>
                        
                      </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-success">
                        <div class="inner">
                          <h3>$commitments_count</h3>

                          <p>Commitment Form</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-stats-bars"></i>
                        </div>
                        
                      </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-info">
                        <div class="inner">
                          <h3>$applications_count</h3>

                          <p>Application Form</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-plus"></i>
                        </div>
                        
                      </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-danger">
                        <div class="inner">
                          <h3>$renewals_count</h3>

                          <p>Renewal Form</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-pie-graph"></i>
                        </div>
                        
                      </div>
                    </div>
                    <!-- ./col -->
                  </div>
                  <!-- /.row -->
                  <!-- Main row -->


                  <!-- solid sales graph -->
                  <div class="card bg-gradient-info submission-stats">
                    <div class="card-header border-0">
                      <h3 class="card-title">
                        <i class="fas fa-th mr-1"></i>
                        Form Submission Statistics
                      </h3>

                      <div class="card-tools">
                        <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer bg-transparent">
                      <div class="row">
                        <div class="col-3 text-center">
                          <input type="text" class="knob" data-readonly="true" value="$application_submissions_count" data-width="60" data-height="60"
                                data-fgColor="#39CCCC">

                          <div class="text-white">Application</div>
                        </div>
                        <!-- ./col -->
                        <div class="col-3 text-center">
                          <input type="text" class="knob" data-readonly="true" value="$renewal_submissions_count" data-width="60" data-height="60"
                                data-fgColor="#39CCCC">

                          <div class="text-white">Renewal</div>
                        </div>
                        <!-- ./col -->
                        <div class="col-3 text-center">
                          <input type="text" class="knob" data-readonly="true" value="$commitment_submissions_count" data-width="60" data-height="60"
                                data-fgColor="#39CCCC">

                          <div class="text-white">Commitment</div>
                        </div>
                        <!-- ./col -->
                        <!-- ./col -->
                        <div class="col-3 text-center">
                          <input type="text" class="knob" data-readonly="true" value="$plans_count" data-width="60" data-height="60"
                                data-fgColor="#39CCCC">

                          <div class="text-white">Plans of Activities</div>
                        </div>
                        <!-- ./col -->
                      </div>
                      <!-- /.row -->
                    </div>
                    <!-- /.card-footer -->
                  </div>
                  <!-- /.card -->
                  
                  <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-7 connectedSortable">
                      <!-- Custom tabs (Charts with tabs)-->
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            User Statistics
                          </h3>
                          <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">
                              <li class="nav-item d-none">
                                <a class="nav-link" href="#revenue-chart" data-toggle="tab">Area</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link active" href="#sales-chart" data-toggle="tab">Donut</a>
                              </li>
                            </ul>
                          </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                          <div class="tab-content p-0">
                            <!-- Morris chart - Sales -->
                            <div class="chart tab-pane d-none" id="revenue-chart"
                                style="position: relative; height: 300px;">
                                <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                            </div>
                            <div class="chart tab-pane active" id="sales-chart" style="position: relative; height: 300px;">
                              <input value="$user_roles_count" id="user_count" hidden>
                              <input value="$admin_roles_count" id="admin_count" hidden>
                              <input value="$super_admin_roles_count" id="super_admin_count" hidden>
                              <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                            </div>
                          </div>
                        </div><!-- /.card-body -->
                      </div>
                      <!-- /.card -->

                      <!-- DIRECT CHAT -->
                      <!--/.direct-chat -->

                      <!-- TO DO List -->
                      <!-- /.card -->
                    </section>
                    <!-- /.Left col -->


                    <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    <section class="col-lg-5 connectedSortable">

                      <!-- Calendar -->
                      <div class="card bg-gradient-success">
                        <div class="card-header border-0">

                          <h3 class="card-title">
                            <i class="far fa-calendar-alt"></i>
                            Calendar
                          </h3>
                          <!-- tools card -->
                          <div class="card-tools">
                            <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                              <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                              <i class="fas fa-times"></i>
                            </button>
                          </div>
                          <!-- /. tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body pt-0">
                          <!--The calendar -->
                          <div id="calendar" style="width: 100%"></div>
                        </div>
                        <!-- /.card-body -->
                      </div>

                      <!-- Map card -->
                      <div class="card bg-gradient-primary d-none">
                        <div class="card-body">
                          <div id="world-map" style="height: 250px; width: 100%;"></div>
                        </div>
                        <!-- /.card-body-->
                        <div class="card-footer bg-transparent">
                          <div class="row">
                            <div class="col-4 text-center">
                              <div id="sparkline-1"></div>
                              <div class="text-white">Visitors</div>
                            </div>
                            <!-- ./col -->
                            <div class="col-4 text-center">
                              <div id="sparkline-2"></div>
                              <div class="text-white">Online</div>
                            </div>
                            <!-- ./col -->
                            <div class="col-4 text-center">
                              <div id="sparkline-3"></div>
                              <div class="text-white">Sales</div>
                            </div>
                            <!-- ./col -->
                          </div>
                          <!-- /.row -->
                        </div>
                      </div>
                      <!-- /.card -->
                      <!-- /.card -->
                    </section>
                    <!-- right col -->
                  </div>
                  <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
              </section>
        CONTENT;
      }
      else if($user_type === 'admin')
      {
        include_once './reusable/admin_dashboard.php';
        include_once './reusable/plan_activities.php';
      }
      else 
      {
        include_once './reusable/organization_records.php';
        include_once './reusable/plan_activities.php';
      }
    ?>

    <div class="events">
      <?php include_once './reusable/events.php'; ?>
    </div>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <!-- footer -->
  <?php include_once './reusable/footer.php'; ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
 <?php include_once './reusable/jquery.php'; ?>

</body>
</html>