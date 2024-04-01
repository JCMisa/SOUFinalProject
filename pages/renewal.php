<?php 

@include '../configurations/config.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

if(isset($_SESSION['user_type']) && isset($_SESSION['user_name'])){
  $user_type = $_SESSION['user_type'];
  $user_name = $_SESSION['user_name'];
}

if(isset($_POST['submit'])){
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    $college = mysqli_real_escape_string($conn, $_POST['college']);
    $year = $_POST['year'];
    $president = mysqli_real_escape_string($conn, $_POST['president']);
    $status = $_POST['status'];
    $renewal_user_id = $user_id;
    
    $current_year = (new DateTime)->format("Y");
    $select = " SELECT * FROM renewal_tbl WHERE user_id = '$renewal_user_id' && year = '$current_year'; ";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0){ //means there is an existing record where user_id = renewal_user_id and year = current year

        $error[] = 'You already submmited a renewal form for this year.';
        header('location:./error_pages/conflict.php');
        die();
    }else{
        $insert = "INSERT INTO renewal_tbl(organization, college, year, president, status, user_id) VALUES('$organization','$college','$year','$president','$status',$renewal_user_id);";
        mysqli_query($conn, $insert);
        header('location:./renewal.php');
        die();
    }
};

if(isset($_POST['save']))
{
    $filename = $_FILES['application_file']['name'];
    $destination = '../application_uploads/' . $filename;
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $file = $_FILES['application_file']['tmp_name'];
    $size = $_FILES['application_file']['size'];

    if(!in_array($extension, ['PDF', 'pdf', 'png', 'zip', 'docx'])) {
        echo "You cannot upload files of this type";
    }
    else {
        $current_year = (new DateTime)->format("Y");
        $select = " SELECT * FROM application_upload WHERE form_type = 'renewal' && year = '$current_year'; ";
        $result = mysqli_query($conn, $select);
        if(move_uploaded_file($file, $destination) && !mysqli_num_rows($result) > 0) {
            $status = $_POST['status_upload'];
            $form_type = $_POST['form_type'];
            $year = (new DateTime)->format("Y");

            $sql = " INSERT INTO application_upload (name, size, downloads, uploader, status, year, user_id, form_type) VALUES('$filename', '$size', 0, '$user_name', '$status', '$year', $user_id, '$form_type'); ";

            if(mysqli_query($conn, $sql)) {
                echo "file uploaded successfully";
                header("Location: ./renewal.php");
            }else{
                echo "failed to upload file";
            }
        }else {
            header('Location: ./error_pages/conflict.php');
        }
    }
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

                        <h1 class="m-0">Renewal Form</h1>
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
                    <label for="president">President Name</label>
                    <input type="text" name="president" class="form-control" id="president" placeholder="Organization President Name">
                </div>
                <div class="form-group">
                    <input type="text" name="status" class="form-control" id="status" placeholder="Current Status" value="pending" hidden>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>College</label>
                            <select name="college" multiple class="custom-select">
                                <option value="COLLEGE OF COMPUTER STUDIES (CCS)">COLLEGE OF COMPUTER STUDIES (CCS)</option>
                                <option value="COLLEGE OF ARTS AND SCIENCES (CAS)">COLLEGE OF ARTS AND SCIENCES (CAS)</option>
                                <option value="COLLEGE OF BUSINESS, ADMINISTRATION AND ACCOUNTANCY (CBAA)">COLLEGE OF BUSINESS, ADMINISTRATION AND ACCOUNTANCY (CBAA)</option>
                                <option value="COLLEGE OF CRIMINAL JUSTICE EDUCATION (CCJE)">COLLEGE OF CRIMINAL JUSTICE EDUCATION (CCJE)</option>
                                <option value="COLLEGE OF ENGINEERING (COE)">COLLEGE OF ENGINEERING (COE)</option>
                                <option value="COLLEGE OF HOSPITALITY MANAGEMENT AND TOURISM (CHMT)">COLLEGE OF HOSPITALITY MANAGEMENT AND TOURISM (CHMT)</option>
                                <option value="COLLEGE OF INDUSTRIAL TECHNOLOGY (CIT)">COLLEGE OF INDUSTRIAL TECHNOLOGY (CIT)</option>
                                <option value="COLLEGE OF TEACHER EDUCATION (CTE)">COLLEGE OF TEACHER EDUCATION (CTE)</option>
                                <option value="SENIOR HIGH SCHOOL (SHS)">SENIOR HIGH SCHOOL (SHS)</option>
                            </select>
                        </div>
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
                        <input name="renewal_user_id" value="<?php echo $user_id; ?>" class="form-control" id="user_id" disabled hidden>
                    </div>
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
                            $select_id = " SELECT * FROM renewal_tbl; "; 
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
                            $renewal_user_id = $user_id;
                            $select_filter = " SELECT * FROM renewal_tbl WHERE user_id = '$renewal_user_id' ";
                            $select_filter_result = mysqli_query($conn, $select_filter);
                            $resultCheck = mysqli_num_rows($select_filter_result);
                            if($resultCheck > 0)
                            {
                                while($row = mysqli_fetch_assoc($select_filter_result))
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
                                        <td> <a href="./details_renewal.php?details_id='<?php echo $row['id'] ?>'" class="btn btn-block btn-outline-warning"> View </a> </td>
                                        <td> <a href="./update_renewal.php?update_id='<?php echo $row['id'] ?>'" class="btn btn-block btn-outline-info"> Edit </a> </td>
                                        <td> <a href="./delete_renewal.php?delete_id='<?php echo $row['id'] ?>'" class="btn btn-block btn-outline-danger"> Delete </a> </td>
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

            <br>
            <br>
            <br>

            <!-- submission -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Upload Renewal Form (With Signature)</h3>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" name="status_upload" class="form-control" value="pending" hidden>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <select name="form_type" multiple class="custom-select" hidden>
                                    <option value="application" disabled>Application</option>
                                    <option value="renewal" selected>Renewal</option>
                                    <option value="commitment" disabled>Commitment</option>
                                    <option value="plan_of_activities" disabled>Plan of Activities</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Upload File</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="application_file" id="application_file">
                                </div>
                                <div class="input-group-append">
                                    <button type="submit" name="save" class="input-group-text btn btn-block bg-gradient-success btn-sm">Upload</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Renewal Submission List</h3>
                </div>

                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>File Name</th>
                                <th>Status</th>
                                <th>Submission Year</th>
                                <th>Uploader</th>
                                <th>Form Type</th>
                                <th>Size</th>
                                <th>Attempts</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $select_filter = " SELECT * FROM application_upload WHERE user_id = '$user_id' AND form_type = 'renewal'; ";
                                $select_filter_result = mysqli_query($conn, $select_filter);
                                $resultCheck = mysqli_num_rows($select_filter_result);
                                if($resultCheck > 0)
                                {
                                    while($row = mysqli_fetch_assoc($select_filter_result))
                                    {
                            ?>
                                        <tr>
                                            <td> <?php echo $row['id'] ?> </td>
                                            <td> <?php echo $row['name'] ?> </td>
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
                                            <td> <?php echo $row['year']; ?> </td>
                                            <td> <?php echo $row['uploader'] ?> </td>
                                            <td> <?php echo $row['form_type'] ?> </td>
                                            <td> <?php echo $row['size'] / 1000 . "KB"; ?> </td>
                                            <td> <?php echo $row['downloads'] ?> </td>
                                            
                                            <td> <a href="./delete_application_upload.php?delete_id='<?php echo $row['id'] ?>'" class="btn btn-block btn-outline-danger"> Delete </a>  </td>
                                        </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>File Name</th>
                                <th>Status</th>
                                <th>Submission Year</th>
                                <th>Uploader</th>
                                <th>Form Type</th>
                                <th>Size</th>
                                <th>Attempts</th>
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