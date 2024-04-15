<?php 
@include '../configurations/config.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

$id = $_GET['details_id'];

$sql = " SELECT * FROM application_upload WHERE id = $id; ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$status_ac = $row['status'];
$year = $row['year'];
$uploader_user_id = $row['user_id'];

if(isset($_POST['submit'])){
    $status = $_POST['status'];

    $query = " UPDATE application_upload SET status = '$status' WHERE id = $id; "; 
    $query2 = " UPDATE commitment_tbl SET status = '$status' WHERE user_id = $uploader_user_id AND year = '$year'; ";
    $result = mysqli_query($conn, $query);
    $result2 = mysqli_query($conn, $query2);

    if($result && $result2){
        header('location:./commitment_submission.php');
        die();
    }else{
        die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
}

if(isset($_GET['details_id'])){
    $id = $_GET['details_id'];

    $sql = " SELECT * FROM application_upload WHERE id = $id; ";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) <= 0)
    {
        $error[] = 'No record with id: '.$id;
    }
    $row = mysqli_fetch_assoc($result);

    $id = $row['id'];
    $name = $row['name'];
    $size = $row['size'];
    $downloads = $row['downloads'];
    $uploader = $row['uploader'];
    $form_type = $row['form_type'];
    $status = $row['status'];
}

if(isset($_SESSION['user_type']) && isset($_SESSION['user_name'])){
  $user_type = $_SESSION['user_type'];
  $user_name = $_SESSION['user_name'];
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
                            <a href="./renewal.php" class="button">
                                <div class="button-box">
                                    <span class="button-elem">
                                    <i class="bi bi-arrow-right"></i>
                                    </span>
                                    <span class="button-elem">
                                    <i class="bi bi-arrow-right"></i>
                                    </span>
                                </div>
                            </a>
                            
                            <h1 class="m-0">Set Commitment Submission Status</h1>
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

            <section class="content">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-5">
                            <h5><strong>ID</strong></h5>
                            <p><?php echo $id ?></p>

                            <h5><strong>File Name</strong></h5>
                            <p><?php echo $name ?></p>

                            <h5><strong>File Size</strong></h5>
                            <p><?php echo $size ?></p>

                            <h5><strong>File Downloads Attempt</strong></h5>
                            <p><?php echo $downloads ?></p>

                            <h5><strong>Uploader Name</strong></h5>
                            <p><?php echo $uploader ?></p>

                            <h5><strong>Form Type</strong></h5>
                            <p><?php echo $form_type ?></p>

                            <h5><strong>Submission Status</strong></h5>
                            <p><?php echo $status ?></p>
                        </div>
                        <div class="col-7 application-form">
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
                                    <button type="submit" name="submit" class="btn btn-block btn-outline-info"> Edit </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            
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