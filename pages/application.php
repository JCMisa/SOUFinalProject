<?php 

@include '../configurations/config.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

$query = " SELECT * FROM user_tbl WHERE id = $user_id ";
$result = mysqli_query($conn, $query);
$result_count = mysqli_num_rows($result);
if($result_count > 0){
    $row = mysqli_fetch_assoc($result);

    $organization_ac = $row['organization'];
}

if(isset($_SESSION['user_type']) && isset($_SESSION['user_name']) && isset($_SESSION['image'])){
  $user_type = $_SESSION['user_type'];
  $user_name = $_SESSION['user_name'];
  $user_image = $_SESSION['image'];
}

if(isset($_POST['submit'])){
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    $organization = htmlspecialchars($organization);
    $president = mysqli_real_escape_string($conn, $_POST['president']);
    $president = htmlspecialchars($president);
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

        $_SESSION['status'] = "Application Created Successfully";
        header('location:./application.php');
        die();
    }
};



// if(isset($_POST['upload'])) {
//     $file = $_FILES['file'];

//     $fileName = $_FILES['file']['name'];
//     $fileTmpName = $_FILES['file']['tmp_name'];
//     $fileSize = $_FILES['file']['size'];
//     $fileError = $_FILES['file']['error'];
//     $fileType = $_FILES['file']['type'];

//     $fileExt = explode('.', $fileName);
//     $fileActualExt = strtolower(end($fileExt));

//     $allowed = array('pdf', 'jpg', 'jpeg', 'png');

//     if(in_array($fileActualExt, $allowed)) {
//         if($fileError === 0) {
//             if($fileSize < 1000000) {
//                 $fileNameNew = uniqid('', true).".".$fileActualExt;

//                 $fileDestination = 'downloads/'.$fileNameNew;
//                 move_uploaded_file($fileTmpName, $fileDestination);
//                 header("Location: ./index.php");
//             } else {
//                 echo "Your file is too big!";
//             }
//         } else {
//             echo "There was an error uploading your file!";
//         }
//     } else {
//         echo "You cannot upload files of this type!";
//     }
// }




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
        $select = " SELECT * FROM application_upload WHERE form_type = 'application' && year = '$current_year' && user_id = $user_id; ";
        $result = mysqli_query($conn, $select);
        if(move_uploaded_file($file, $destination) && !mysqli_num_rows($result) > 0) {
            $status = $_POST['status_upload'];
            $form_type = $_POST['form_type'];
            $year = (new DateTime)->format("Y");
            $date_upload = date('m-d-Y');
            $date_approved = "";

            $sql = " INSERT INTO application_upload (name, size, downloads, uploader, status, year, user_id, form_type, date_upload, date_approved) 
            VALUES('$filename', '$size', 0, '$user_name', '$status', '$year', $user_id, '$form_type', '$date_upload', '$date_approved'); ";

            if(mysqli_query($conn, $sql)) {
                echo "file uploaded successfully";
                header("Location: ./application.php");
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

    <style></style>
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
                    <?php 
                        $sql = "SELECT id, name FROM organizations";
                        $result = mysqli_query($conn, $sql);   
                    ?>
                    <label for="organization">Organization Name</label>
                    <select name="organization" class="custom-select" id="organization" value="<?php echo $organization_ac ?>">
                        <?php 
                        if($resultCheck = mysqli_num_rows($result)) {
                            while($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['name']?>" <?php if($organization_ac === $row['name']) echo 'selected'; ?>><?php echo $row['name'] ?></option>
                        <?php 
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="pres">President Name</label>
                    <input type="text" name="president" class="form-control" id="pres" placeholder="Organization President Name" required>
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
                                        <td> <a href="./delete_application.php?delete_id='<?php echo $row['id'] ?>'" class="delete btn btn-block btn-outline-danger"> Delete </a> </td>
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

            <br>
            <br>
            <br>

            <!-- submission -->

            <!-- <form action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="card-header">
                        <h3 class="card-title">Submit Application Form</h3>
                    </div>
                    <div class="form-group">
                        <input type="file" name="application_file" id="application_file">
                        <button type="submit" name="save" class="btn btn-inline bg-gradient-success btn-sm">Upload</button>
                    </div>
                </div>
            </form> -->

            

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Upload Application Form (With Signature)</h3>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" name="status_upload" class="form-control" value="pending" hidden>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <select name="form_type" multiple class="custom-select" hidden>
                                    <option value="application" selected>Application</option>
                                    <option value="renewal" disabled>Renewal</option>
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
                    <h3 class="card-title">Application Submission List</h3>
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
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $select_filter = " SELECT * FROM application_upload WHERE user_id = '$user_id' AND form_type = 'application'; ";
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
                                            <td> <?php echo $row['year'] ?> </td>
                                            <td> <?php echo $row['date_upload'] ?> </td>
                                            <td> <?php echo $row['date_approved'] ?> </td>
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
                                <th>Date Upload</th>
                                <th>Date Approved</th>
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