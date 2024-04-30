<?php

@include '../configurations/config.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

$id = $_GET['update_id'];

$sql = " SELECT * FROM manage_events WHERE id = $id; ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$status_ac = $row['status'];

if(isset($_POST['submit'])){
    $status = $_POST['status'];

    $query = " UPDATE manage_events SET status = '$status' WHERE id = $id; "; 
    $result = mysqli_query($conn, $query);

    if($result){
        $_SESSION['status'] = "Status Updated Successfully";
        header('location:./approve_events.php');
        die();
    }else{
        header('location:./error_pages/error.php');
        die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
}

if(isset($_SESSION['user_type']) && isset($_SESSION['user_name']) && isset($_SESSION['image'])){
  $user_type = $_SESSION['user_type'];
  $user_name = $_SESSION['user_name'];
  $user_image = $_SESSION['image'];
}

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'super_admin') {
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
                        <!-- go back button -->
                        <div class="row">
                            <a href="./approve_events.php" class="button">
                                <div class="button-box">
                                    <span class="button-elem">
                                    <i class="bi bi-arrow-right"></i>
                                    </span>
                                    <span class="button-elem">
                                    <i class="bi bi-arrow-right"></i>
                                    </span>
                                </div>
                            </a>
                            
                            <h1 class="m-0">Set Event Status</h1>
                        </div>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            
            <!-- Main content -->
            <!-- form -->
            <form action="" method="post">
            <div class="card-body">
                <?php
                    if($user_type === 'super_admin')
                    {
                        echo <<<SHOWSTATUS
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" multiple class="custom-select" value="$status_ac">
                                    <option value="pending">Pending</option>
                                    <option value="success">Success</option>
                                    <option value="failed">Failed</option>
                                </select>
                            </div>
                        SHOWSTATUS;
                    } else {
                        echo <<<SHOWSTATUS
                            <div class="form-group">
                                <input type="text" name="status" class="form-control" id="status" value="$status_ac" hidden>
                            </div>
                        SHOWSTATUS;
                    }
                ?>
            </div>

            <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
            
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