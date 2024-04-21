
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
        <div class="col-lg-12 col-md-12">
            <!-- small box -->
            <div class="small-box bg-warning">
            <div class="inner">
                <h3><?php echo $registration_count2 ?></h3>

                <p><?php echo $organization ?> Registrations</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            
            </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <!-- ./col -->
        <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->


        <!-- solid sales graph -->
        <div class="card bg-gradient-info">
        <div class="card-header border-0">
            <h3 class="card-title">
            <i class="fas fa-th mr-1"></i>
            Form Submission Statistics (Not Yet Signed)
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
                <input type="text" class="knob" data-readonly="true" value="<?php echo $application2_count ?>" data-width="60" data-height="60"
                    data-fgColor="#39CCCC">

                <div class="text-white">Application</div>
            </div>
            <!-- ./col -->
            <div class="col-3 text-center">
                <input type="text" class="knob" data-readonly="true" value="<?php echo $renewal2_count ?>" data-width="60" data-height="60"
                    data-fgColor="#39CCCC">

                <div class="text-white">Renewal</div>
            </div>
            <!-- ./col -->
            <div class="col-3 text-center">
                <input type="text" class="knob" data-readonly="true" value="<?php echo $commitments2_count ?>" data-width="60" data-height="60"
                    data-fgColor="#39CCCC">

                <div class="text-white">Commitment</div>
            </div>
            <!-- ./col -->
            <!-- ./col -->
            <div class="col-3 text-center">
                <input type="text" class="knob" data-readonly="true" value="<?php echo $plan2_count ?>" data-width="60" data-height="60"
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
                    <input value="<?php echo $user_roles2_count ?>" id="user_count" hidden>
                    <input value="<?php echo $admin_roles2_count ?>" id="admin_count" hidden>
                    <input value="<?php echo $super_admin2_count ?>" id="super_admin_count" hidden>
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