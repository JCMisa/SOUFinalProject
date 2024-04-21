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

                        <h1 class="m-0">Renewal List</h1>
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
                    <h3 class="card-title">Renewal List</h3>
                </div>

                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Organization</th>
                                <th>College</th>
                                <th>Academic Year</th>
                                <th>President</th>
                                <th>Status</th>
                                <th>View</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $select = " SELECT * FROM renewal_tbl; "; 
                                $result = mysqli_query($conn, $select);
                                $result_count = mysqli_num_rows($result);

                                $isDisabled = ($user_type !== 'super_admin') ? 'disabled' : '';

                                if($result_count > 0)
                                {
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                            ?>
                                <tr>
                                    <td> <?php echo $row['organization'] ?> </td>
                                    <td> <?php echo $row['college'] ?> </td>
                                    <td> <?php echo $row['year'] ?> </td>
                                    <td> <?php echo $row['president'] ?> </td>
                                    <td> 
                                        <?php 
                                            if(strtolower($row['status']) === 'pending')
                                            {
                                                echo '<button type="button" class="btn btn-block bg-gradient-warning btn-sm">PENDING</button>';
                                            } else if(strtolower($row['status']) === 'success'){
                                                echo '<button type="button" class="btn btn-block bg-gradient-success btn-sm"> SUCCESS </button>';
                                            } else {
                                                echo '<button type="button" class="btn btn-block bg-gradient-danger btn-sm">FAILED</button>';
                                            }
                                        ?> 
                                    </td>
                                    <td> <a href="./details_renewal.php?details_id='<?php echo $row['id'] ?>'" class="btn btn-block btn-outline-warning <?php echo $isDisabled ?>"> View </a> </td>
                                    <td> <a href="./update_renewal.php?update_id='<?php echo $row['id'] ?>'" class="btn btn-block btn-outline-info <?php echo $isDisabled ?>"> Edit </a> </td>
                                    <td> <a href="./delete_renewal.php?delete_id='<?php echo $row['id'] ?>'" class="delete btn btn-block btn-outline-danger <?php echo $isDisabled ?>"> Delete </a> </td>
                                </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Organization</th>
                                <th>College</th>
                                <th>Academic Year</th>
                                <th>President</th>
                                <th>Status</th>
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