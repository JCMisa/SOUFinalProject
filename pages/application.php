<?php 

@include '../configurations/config.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

if(isset($_POST['submit'])){
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    $president = mysqli_real_escape_string($conn, $_POST['president']);
    $year = $_POST['year'];
    $status = $_POST['status'];
    $application_user_id = $user_id;
    

    
    $current_year = (new DateTime)->format("Y");
    $select = " SELECT * FROM application_tbl WHERE user_id = '$application_user_id' && year = '$current_year'; ";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0){ //means there is an existing record where user_id = commitment_user_id and year = current year

        $error[] = 'You already submmited a application form for this year.';
        header('location:./error_pages/conflict.php');
        die();
    }else{
        $insert = "INSERT INTO application_tbl(organization, president, year, status, user_id) VALUES('$organization','$president','$year','$status',$application_user_id);";
        mysqli_query($conn, $insert);
        header('location:./application.php');
        die();
    }
};

if(isset($_SESSION['user_type']) && isset($_SESSION['user_name'])){
  $user_type = $_SESSION['user_type'];
  $user_name = $_SESSION['user_name'];
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

                        <h1 class="m-0">Application Form</h1>
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
            <!-- form -->
            <form action="" method="post">
            <div class="card-body">
                <div class="form-group">
                    <label for="org">Organization Name</label>
                    <input type="text" name="organization" class="form-control" id="org" placeholder="Organization Name">
                </div>
                <div class="form-group">
                    <label for="pres">President Name</label>
                    <input type="text" name="president" class="form-control" id="pres" placeholder="Organization President Name">
                </div>
                
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Academic Year</label>
                        <select name="year" multiple class="custom-select">
                            <?php
                            $currentYear = (new DateTime)->format("Y");
                            $startYear = 2024; // start year
                            $endYear = 2099; // end year

                            for ($year = $startYear; $year <= $endYear; $year++) {
                                $isDisabled = ($year !== (int)$currentYear) ? 'disabled' : '';
                                echo "<option value=\"$year\" $isDisabled>$year</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <input type="text" name="status" class="form-control" id="status" placeholder="Current Status" value="pending" hidden>
                </div>
                
                <div class="form-group">
                    <input name="application_user_id" value="<?php echo $user_id; ?>" class="form-control" id="user_id" disabled hidden>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>


            <br>
            <br>
            <br>
            <br>


            <!-- table -->
            <div class="card">
            <div class="card-header">
            <h3 class="card-title">Application List</h3>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Organization</th>
                            <th>President</th>
                            <th>Academic Year</th>
                            <th>Status</th>
                            <th>View</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $select_id = " SELECT * FROM application_tbl; "; 
                            $result_id = mysqli_query($conn, $select_id);
                            $result_id_count = mysqli_num_rows($result_id);
                            if($result_id_count > 0){
                                $row_id = mysqli_fetch_assoc($result_id);
                                $id = $row_id['id'];
                            }
                            else{
                                $error[] = 'No record available';
                            }
                            

                            $current_year = (new DateTime)->format("Y");
                            $application_user_id = $user_id;
                            $select_filter = " SELECT * FROM application_tbl WHERE user_id = '$application_user_id'; ";
                            $select_filter_result = mysqli_query($conn, $select_filter);
                            $resultCheck = mysqli_num_rows($select_filter_result);
                            if($resultCheck > 0)
                            {
                                while($row = mysqli_fetch_assoc($select_filter_result))
                                {
                        ?>
                                    <tr>
                                        <td> <?php echo $row['organization'] ?> </td>
                                        <td> <?php echo $row['president'] ?> </td>
                                        <td> <?php echo $row['year'] ?> </td>
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
                                        <td> <a href="./details_application.php?details_id='<?php echo $row['id'] ?>'" class="btn btn-block btn-outline-warning"> View </a> </td>
                                        <td> <a href="./update_application.php?update_id='<?php echo $row['id'] ?>'" class="btn btn-block btn-outline-info"> Edit </a> </td>
                                        <td> <a href="./delete_application.php?delete_id='<?php echo $row['id'] ?>'" class="btn btn-block btn-outline-danger"> Delete </a> </td>
                                    </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Organization</th>
                            <th>President</th>
                            <th>Academic Year</th>
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