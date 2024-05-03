<?php
    @include '../configurations/config.php';
    session_start();

    $sql = " SELECT * FROM application_upload WHERE form_type = 'commitment'; ";
    $result = mysqli_query($conn, $sql);
    $files = mysqli_fetch_all($result, MYSQLI_ASSOC);


    if(isset($_SESSION['user_type']) && isset($_SESSION['user_name']) && isset($_SESSION['image']) && isset($_SESSION['user_id'])){
        $user_type = $_SESSION['user_type'];
        $user_name = $_SESSION['user_name'];
        $user_image = $_SESSION['image'];
        $user_id = $_SESSION['user_id'];
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
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include_once './reusable/sideNav.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <?php
                if(isset($_SESSION['status']))
                {
            ?>
                    <div class="update-notif" style="z-index:100000; font-size:20px; background-color: #4CAF50; padding: 10px 20px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.7); position:fixed; top:5%; right:0; border-radius:5px;">
                        <p style="color: green;"><?php echo $_SESSION['status'] ?></p>
                    </div>
            <?php
                    unset($_SESSION['status']);
                }
            ?>
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

                        <h1 class="m-0">Commitment Submissions</h1>
                    </div>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="./commitment.php">Home</a></li>
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
                    <h3 class="card-title">Commitment Submission List</h3>
                </div>

                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>File Name</th>
                                <th>Status</th>
                                <th>Submission Year</th>
                                <th>Date Upload</th>
                                <th>Date Approved</th>
                                <th>Uploader</th>
                                <th>Form Type</th>
                                <th>Size</th>
                                <th>Attempts</th>
                                <th>Download</th>
                                <th>Set Status</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($files as $file): ?>
                            <tr>
                                <td> <?php echo $file['id']; ?> </td>
                                <td> <?php echo $file['name']; ?> </td>
                                <td> 
                                    <?php 
                                        if(strtolower($file['status']) === 'pending')
                                        {
                                            echo '<button type="button" class="btn btn-block bg-gradient-warning btn-sm">PENDING</button>';
                                        } else if(strtolower($file['status']) === 'success'){
                                            echo '<button type="button" class="btn btn-block bg-gradient-success btn-sm"> SUCCESS </button>';
                                        } else {
                                            echo '<button type="button" class="btn btn-block bg-gradient-danger btn-sm">FAILED</button>';
                                        }
                                    ?> 
                                </td>
                                <td> <?php echo $file['year'] ?> </td>
                                <td> <?php echo $file['date_upload'] ?> </td>
                                <td> <?php echo $file['date_approved'] ?> </td>
                                <td> <?php echo $file['uploader'] ?> </td>
                                <td> <?php echo $file['form_type'] ?> </td>
                                <td> <?php echo $file['size'] / 1000 . "KB"; ?> </td>
                                <td> <?php echo $file['downloads']; ?> </td>

                                <td> 
                                    <a href="./download_application_upload.php?file_id='<?php echo $file['id'] ?>'" class="btn btn-block btn-outline-success"> Download </a> 
                                </td>
                                <td>
                                    <a href="./update_commitment_upload.php?details_id='<?php echo $file['id'] ?>'" class="btn btn-block btn-outline-info"> Status </a>
                                </td>
                                <td> 
                                    <a href="./delete_application_upload.php?delete_id='<?php echo $file['id'] ?>'" class="delete btn btn-block btn-outline-danger"> Delete </a> 
                                </td>
                            </tr>

                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>File Name</th>
                                <th>Status</th>
                                <th>Submission Year</th>
                                <th>Date Upload</th>
                                <th>Date Approved</th>
                                <th>Uploader</th>
                                <th>Form Type</th>
                                <th>Size</th>
                                <th>Attempts</th>
                                <th>Download</th>
                                <th>Set Status</th>
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