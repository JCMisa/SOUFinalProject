<?php
    @include '../configurations/config.php';
    session_start();


    if(isset($_SESSION['user_type']) && isset($_SESSION['user_name']) && isset($_SESSION['image'])){
        $user_type = $_SESSION['user_type'];
        $user_name = $_SESSION['user_name'];
        $user_image = $_SESSION['image'];
    }

    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'super_admin' && $_SESSION['user_type'] != 'admin') {
        // If the user is not an super admin, redirect them to a access denied page
        header('Location: ./error_pages/denied.php');
        die();
    }
?>

<!-- doctype -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SOU Management System</title>
    <?php include_once './reusable/head.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <?php include_once './reusable/preloader.php'; ?>

        <!-- Navbar -->
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
                    <!-- go back button -->
                    <div class="row">
                        <a href="./index.php" class="button">
                            <div class="button-box">
                                <span class="button-elem">
                                <i class="bi bi-arrow-right"></i>
                                </span>
                                <span class="button-elem">
                                <i class="bi bi-arrow-right"></i>
                                </span>
                            </div>
                        </a>

                        <h1 class="m-0">Plan of Activities List</h1>
                    </div>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            
            <!-- Main content -->

            <!-- table -->
            <div class="card">
            <div class="card-header">
            <h3 class="card-title">Plan of Activities List</h3>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Organization</th>
                            <th>President</th>
                            <th>Secretary</th>
                            <th>Academic Year</th>
                            <th>Status</th>
                            <th>Objectives</th>
                            <th>Activities</th>
                            <th>Brief Description</th>
                            <th>People Involved</th>
                            <th>Target Date</th>
                            <th>Budget</th>
                            <th>View</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $isDisabled = ($user_type !== 'super_admin') ? 'disabled' : '';

                            $sql = " SELECT plans.id AS plan_id, 
                            plans.organization, 
                            plans.president, 
                            plans.secretary, 
                            plans.year, 
                            plans.status, 
                            objectives.objective,
                            activities.activity,
                            brief_description.description,
                            persons_involved.person,
                            target_date.date,
                            target_budget.budget
                            FROM plans 
                            INNER JOIN objectives ON plans.id = objectives.plan_id
                            INNER JOIN activities ON plans.id = activities.plan_id
                            INNER JOIN brief_description ON plans.id = brief_description.plan_id
                            INNER JOIN persons_involved ON plans.id = persons_involved.plan_id
                            INNER JOIN target_date ON plans.id = target_date.plan_id
                            INNER JOIN target_budget ON plans.id = target_budget.plan_id
                            ; ";

                            $result = mysqli_query($conn, $sql);

                            if(mysqli_num_rows($result) > 0) {
                                $plans = array();

                                while($row = mysqli_fetch_assoc($result))
                                {
                                    if(!isset($plans[$row['plan_id']])) {
                                        $plans[$row['plan_id']] = array(
                                            'organization' => $row['organization'],
                                            'president' => $row['president'],
                                            'secretary' => $row['secretary'],
                                            'year' => $row['year'],
                                            'status' => $row['status'],
                                            'objectives' => array(),
                                            'activities' => array(),
                                            'brief_description' => array(),
                                            'persons_involved' => array(),
                                            'target_date' => array(),
                                            'target_budget' => array()
                                        );
                                    }

                                    if (!in_array($row['objective'], $plans[$row['plan_id']]['objectives'])) {
                                        $plans[$row['plan_id']]['objectives'][] = $row['objective'];
                                    }

                                    if (!in_array($row['activity'], $plans[$row['plan_id']]['activities'])) {
                                        $plans[$row['plan_id']]['activities'][] = $row['activity'];
                                    }

                                    if (!in_array($row['description'], $plans[$row['plan_id']]['brief_description'])) {
                                        $plans[$row['plan_id']]['brief_description'][] = $row['description'];
                                    }

                                    if (!in_array($row['person'], $plans[$row['plan_id']]['persons_involved'])) {
                                        $plans[$row['plan_id']]['persons_involved'][] = $row['person'];
                                    }

                                    if (!in_array($row['date'], $plans[$row['plan_id']]['target_date'])) {
                                        $plans[$row['plan_id']]['target_date'][] = $row['date'];
                                    }

                                    if (!in_array($row['budget'], $plans[$row['plan_id']]['target_budget'])) {
                                        $plans[$row['plan_id']]['target_budget'][] = $row['budget'];
                                    }
                                }

                                foreach ($plans as $plan_id => $plan)
                                {
                        ?>
                                    <tr>
                                        <td> <?php echo $plan_id ?> </td>
                                        <td> <?php echo $plan['organization'] ?> </td>
                                        <td> <?php echo $plan['president'] ?> </td>
                                        <td> <?php echo $plan['secretary'] ?> </td>
                                        <td> <?php echo $plan['year'] ?> </td>
                                        <td> 
                                            <?php 
                                                if(strtolower($plan['status']) === 'pending')
                                                {
                                                    echo '<button type="button" class="btn btn-block bg-gradient-warning btn-sm">PENDING</button>';
                                                } else if(strtolower($plan['status']) === 'success'){
                                                    echo '<button type="button" class="btn btn-block bg-gradient-success btn-sm"> SUCCESS </button>';
                                                } else {
                                                    echo '<button type="button" class="btn btn-block bg-gradient-danger btn-sm">FAILED</button>';
                                                }
                                            ?> 
                                        </td>
                                        <td> <?php echo implode("<hr>", $plan['objectives']) ?> </td>
                                        <td> <?php echo implode("<hr>", $plan['activities']) ?> </td>
                                        <td> <?php echo implode("<hr>", $plan['brief_description']) ?> </td>
                                        <td> <?php echo implode("<hr>", $plan['persons_involved']) ?> </td>
                                        <td> <?php echo implode("<hr>", $plan['target_date']) ?> </td>
                                        <td> <?php echo implode("<hr>", $plan['target_budget']) ?> </td>

                                        <td> <a href="./details_renewal.php?details_id='<?php echo $plan_id ?>'" class="btn btn-block btn-outline-warning <?php echo $isDisabled ?>"> View </a> </td>
                                        <td> <a href="./update_plans.php?update_id='<?php echo $plan_id ?>'" class="btn btn-block btn-outline-info <?php echo $isDisabled ?>"> Edit </a> </td>
                                        <td> <a href="./delete_plans.php?delete_id='<?php echo $plan_id ?>'" class="delete btn btn-block btn-outline-danger <?php echo $isDisabled ?>"> Delete </a> </td>
                                    </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Organization</th>
                            <th>President</th>
                            <th>Secretary</th>
                            <th>Academic Year</th>
                            <th>Status</th>
                            <th>Objectives</th>
                            <th>Activities</th>
                            <th>Brief Description</th>
                            <th>People Involved</th>
                            <th>Target Date</th>
                            <th>Budget</th>
                            <th>View</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            </div>

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

    <!-- jQuery -->
    <?php include_once './reusable/jquery.php'; ?>
</body>
</html>