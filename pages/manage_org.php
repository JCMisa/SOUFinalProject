<?php 
@include '../configurations/config.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

if(isset($_POST['submit'])){
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    $organization = htmlspecialchars($organization);

    $college = mysqli_real_escape_string($conn, $_POST['college']);
    $college = htmlspecialchars($college);

    $dean = mysqli_real_escape_string($conn, $_POST['dean']);
    $dean = htmlspecialchars($dean);

    $select = " SELECT * FROM organizations WHERE name = '$organization'; ";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0){
        $_SESSION['status'] = "Organization already exist";
        $error[] = 'organization already exist!';
    }else{
        $insert = " INSERT INTO organizations(name, college_belong, college_dean) VALUES('$organization', '$college', '$dean'); ";
        mysqli_query($conn, $insert);
        $_SESSION['status'] = "Organization created successfully";
        header('location:./manage_org.php');
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
                            
                            <h1 class="m-0">Manage Organizations</h1>
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
                        <label for="organization">Organization Name</label>
                        <input type="text" name="organization" class="form-control" id="organization" placeholder="Organization Name">
                    </div>

                    <div class="form-group">
                        <?php 
                            $sql = "SELECT id, name FROM colleges";
                            $result = mysqli_query($conn, $sql);   
                        ?>
                        <label for="college">Select College</label>
                        <select name="college" class="custom-select" id="college">
                        <?php 
                        if($resultCheck = mysqli_num_rows($result)) {
                            while($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['name'] ?>"><?php echo $row['name'] ?></option>
                        <?php 
                            }
                        }
                        ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="dean">Dean Name</label>
                        <input type="text" name="dean" class="form-control" id="dean" placeholder="Dean Name">
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
                            <th>College Under</th>
                            <th>Dean</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $select_all_user = " SELECT * FROM organizations; "; 
                            $result_all = mysqli_query($conn, $select_all_user);
                            $resultCheck = mysqli_num_rows($result_all);

                            if($resultCheck > 0)
                            {
                                while($row = mysqli_fetch_assoc($result_all))
                                {
                        ?>
                                    <tr>
                                        <td> <?php echo $row['id'] ?> </td>
                                        <td> <?php echo $row['name'] ?> </td>
                                        <td> <?php echo $row['college_belong'] ?> </td>
                                        <td> <?php echo $row['college_dean'] ?> </td>

                                        <td> <a href="./update_org.php?update_id='<?php echo $row['id'] ?>'" class="btn btn-block btn-outline-info"> Edit </a> </td>
                                        <td> <a href="./delete_org.php?delete_id='<?php echo $row['id'] ?>'" class="delete btn btn-block btn-outline-danger"> Delete </a> </td>
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
                            <th>College Under</th>
                            <th>Dean</th>
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