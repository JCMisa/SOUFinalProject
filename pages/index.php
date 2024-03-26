<?php
@include '../configurations/config.php';
session_start();

if(isset($_SESSION['user_type']) && isset($_SESSION['user_name'])){
  $user_type = $_SESSION['user_type'];
  $user_name = $_SESSION['user_name'];
}

$name = "JC";
?>

<!-- doctype -->
<?php include_once './reusable/head.php'; ?>

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
      $commitments = mysqli_query($conn, " SELECT COUNT(*) FROM commitment_tbl ");
      $commitment_row = mysqli_fetch_array($commitments);
      $commitments_count = $commitment_row[0];

      if($user_type === 'super_admin' || $user_type === 'admin')
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
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-info">
                        <div class="inner">
                          <h3>150</h3>

                          <p>New Orders</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-danger">
                        <div class="inner">
                          <h3>65</h3>

                          <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                    <!-- ./col -->
                  </div>
                  <!-- /.row -->
                  <!-- Main row -->
                  <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-7 connectedSortable">
                      <!-- Custom tabs (Charts with tabs)-->
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Sales
                          </h3>
                          <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">
                              <li class="nav-item">
                                <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                              </li>
                            </ul>
                          </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                          <div class="tab-content p-0">
                            <!-- Morris chart - Sales -->
                            <div class="chart tab-pane active" id="revenue-chart"
                                style="position: relative; height: 300px;">
                                <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                            </div>
                            <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
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
                            <!-- button with a dropdown -->
                            <div class="btn-group">
                              <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                                <i class="fas fa-bars"></i>
                              </button>
                              <div class="dropdown-menu" role="menu">
                                <a href="#" class="dropdown-item">Add new event</a>
                                <a href="#" class="dropdown-item">Clear events</a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item">View calendar</a>
                              </div>
                            </div>
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

                      <!-- solid sales graph -->
                      <div class="card bg-gradient-info">
                        <div class="card-header border-0">
                          <h3 class="card-title">
                            <i class="fas fa-th mr-1"></i>
                            Sales Graph
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
                          <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer bg-transparent">
                          <div class="row">
                            <div class="col-4 text-center">
                              <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60"
                                    data-fgColor="#39CCCC">

                              <div class="text-white">Mail-Orders</div>
                            </div>
                            <!-- ./col -->
                            <div class="col-4 text-center">
                              <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60"
                                    data-fgColor="#39CCCC">

                              <div class="text-white">Online</div>
                            </div>
                            <!-- ./col -->
                            <div class="col-4 text-center">
                              <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60"
                                    data-fgColor="#39CCCC">

                              <div class="text-white">In-Store</div>
                            </div>
                            <!-- ./col -->
                          </div>
                          <!-- /.row -->
                        </div>
                        <!-- /.card-footer -->
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
    ?>
    <!-- /.content -->
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