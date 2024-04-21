<?php 
@include '../configurations/config.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

if(isset($_POST['submit'])){
    $college = mysqli_real_escape_string($conn, $_POST['college']);
    $college = htmlspecialchars($college);

    $select = " SELECT * FROM colleges WHERE name = '$college'; ";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0){
        $_SESSION['status'] = "College already exist";
        $error[] = 'college already exist!';
    }else{
        $insert = " INSERT INTO colleges(name) VALUES('$college'); ";
        mysqli_query($conn, $insert);
        $_SESSION['status'] = "College created successfully";
        header('location:./manage_college.php');
        die();
    }
};

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
            <?php
                if(isset($_SESSION['status']))
                {
            ?>
                    <div class="update-notif" style="z-index:100000; font-size:20px; background-color:lightgreen; padding: 10px 40px; position:fixed; top:5%; right:0; border-radius:5px;">
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
                            
                            <h1 class="m-0">Manage Colleges</h1>
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
                    <div class="form-group">
                        <label for="college">College Name</label>
                        <input type="text" name="college" class="form-control" id="college" placeholder="College Name">
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>




            <!-- table -->
            <div class="card">
            <div class="card-header">
            <h3 class="card-title">Organizations List</h3>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $select = " SELECT * FROM colleges; "; 
                            $result_all = mysqli_query($conn, $select);
                            $resultCheck = mysqli_num_rows($result_all);

                            if($resultCheck > 0)
                            {
                                while($row = mysqli_fetch_assoc($result_all))
                                {
                        ?>
                                    <tr>
                                        <td> <?php echo $row['id'] ?> </td>
                                        <td> <?php echo $row['name'] ?> </td>
                                        <td> <a href="./update_college.php?update_id='<?php echo $row['id'] ?>'" class="btn btn-block btn-outline-info"> Edit </a> </td>
                                        <td> <a href="./delete_college.php?delete_id='<?php echo $row['id'] ?>'" class="delete btn btn-block btn-outline-danger"> Delete </a> </td>
                                    </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
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
<!-- ./wrapper -->

<!-- jQuery -->
<?php include_once './reusable/jquery.php'; ?>
</body>
</html>