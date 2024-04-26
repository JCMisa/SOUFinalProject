<?php 
@include '../configurations/config.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}


if(isset($_SESSION['user_type']) && isset($_SESSION['user_name']) && isset($_SESSION['image']) && isset($_SESSION['organization'])){
  $user_type = $_SESSION['user_type'];
  $user_name = $_SESSION['user_name'];
  $user_image = $_SESSION['image'];
  $organization = $_SESSION['organization'];
}

if (!isset($_SESSION['user_type'])) {
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

    <style>
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

                            <h1 class="m-0"><?php echo $organization ?> Representatives</h1>
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
            
            <!-- admin table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?php echo $organization ?> Admin(s)</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <?php
                            $select_admin = " SELECT * FROM user_tbl WHERE user_type = 'admin' AND organization = '$organization'; ";
                            $result_admin = mysqli_query($conn, $select_admin);
                            $result_admin_count = mysqli_num_rows($result_admin);

                            if($result_admin_count > 0)
                            {
                                while($row = mysqli_fetch_assoc($result_admin))
                                {
                        ?>
                                    <div class="col-md-4">
                                        <div class="card card-widget widget-user">
                                        <div class="widget-user-header bg-info">
                                        <h3 class="widget-user-username"><?php echo $row['name'] ?></h3>
                                        <h5 class="widget-user-desc">Administrator</h5>
                                        </div>
                                        <div class="widget-user-image">
                                        <img class="img-circle elevation-2" style="width: 100px; height: 100px;" src="./profile_images/<?php echo $row['image'] ?>" alt="User Avatar">
                                        </div>
                                        <div class="card-footer">
                                        <div class="row">
                                        <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                        <h5 class="description-header" style="font-size: 10px;"><?php echo $row['birthday'] ?></h5>
                                        <span class="description-text">BIRTHDAY</span>
                                        </div>
                                        </div>
                                        <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                        <h5 class="description-header" style="font-size: 10px;"><?php echo $row['email'] ?></h5>
                                        <span class="description-text">EMAIL</span>
                                        </div>
                                        </div>
                                        <div class="col-sm-4">
                                        <div class="description-block">
                                        <h5 class="description-header" style="font-size: 10px;"><?php echo $row['course'] ?></h5>
                                        <span class="description-text">COURSE</span>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                    </div>
                        <?php 
                                }
                            }
                        ?>
                    </div>

                    <div class="row">

                    </div>
                </div>
            </div>





            <!-- member table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?php echo $organization ?> Member(s)</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Commitment Forms</h3>
                                </div>

                                <div class="card-body">
                                    <table id="example1" class="table table-head-fixed table-striped" style="font-size: 12px;">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Birthday</th>
                                                <th>Course</th>
                                                <th>View</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php 
                                                $select_user = " SELECT * FROM user_tbl WHERE user_type = 'user' AND organization = '$organization'; ";
                                                $result_user = mysqli_query($conn, $select_user);
                                                $result_user_count = mysqli_num_rows($result_user);

                                                if($result_user_count > 0)
                                                {
                                                    while($row = mysqli_fetch_assoc($result_user))
                                                    {
                                            ?>          
                                                        <tr>
                                                            <td> <?php echo $row['name'] ?> </td>
                                                            <td> <?php echo $row['email'] ?> </td>
                                                            <td> <?php echo $row['birthday'] ?> </td>
                                                            <td> <?php echo $row['course'] ?> </td>
                                                            <td> <a href="./details_user.php?details_id='<?php echo $row['id'] ?>'" class="btn btn-block btn-outline-warning"> View </a> </td>
                                                        </tr>   
                                            <?php 
                                                    }
                                                }
                                            ?>   
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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
<!-- ./wrapper -->

<!-- jQuery -->
<?php include_once './reusable/jquery.php'; ?>
</body>
</html>