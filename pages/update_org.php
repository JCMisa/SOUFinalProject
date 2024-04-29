<?php

@include '../configurations/config.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

$id = $_GET['update_id'];

$sql = " SELECT * FROM organizations WHERE id = $id; ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$organization_ac = $row['name'];
$college_ac = $row['college_belong'];
$dean_ac = $row['college_dean'];
$image_ac = $row['image'];

if(isset($_POST['submit'])){
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    $organization = htmlspecialchars($organization);

    $college = mysqli_real_escape_string($conn, $_POST['college']);
    $college = htmlspecialchars($college);

    $dean = mysqli_real_escape_string($conn, $_POST['dean']);
    $dean = htmlspecialchars($dean);

    $new_image = $_FILES['org_file']['name'];
    $fileSize = $_FILES["org_file"]["size"];
    $tmpName = $_FILES["org_file"]["tmp_name"];

    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $new_image);
    $imageExtension = strtolower(end($imageExtension));
    if(!in_array($imageExtension, $validImageExtension))
    {
        echo " <script> alert('Invalid Image Type'); </script> ";
    }
    $newImageName = uniqid('', true) . '.' . $imageExtension;
    $old_image = $image_ac;

    if($new_image != '')
    {
        $update_filename = $newImageName;
    }
    else
    {
        $update_filename = $old_image;
    }

    if(file_exists("../organization_uploads/".$newImageName))
    {
        echo "<script> alert('Image already exists'); </script>";
        header('location: ./manage_org.php');
        die();
    }

    $query = " UPDATE organizations SET name = '$organization', college_belong = '$college', college_dean = '$dean', image = '$update_filename' WHERE id = $id; "; 
    $result = mysqli_query($conn, $query);

    if($result){
        if($_FILES['org_file']['name'] != '')
        {
            move_uploaded_file($tmpName, '../organization_uploads/'.$newImageName);
            unlink("../organization_uploads/".$old_image);
        }
        $_SESSION['status'] = "Organization updated successfully";
        header('location:./manage_org.php');
        die();
    }else{
        die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
}

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
                            
                            <h1 class="m-0">Update Organization</h1>
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
            <form action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group">
                        <label for="org">Organization Name</label>
                        <input type="text" name="organization" class="form-control" id="org" placeholder="Organization Name" value="<?php echo $organization_ac; ?>">
                    </div>

                    <div class="form-group">
                        <?php 
                            $sql = "SELECT id, name FROM colleges";
                            $result = mysqli_query($conn, $sql);   
                        ?>
                        <label for="college">Select College</label>
                        <select name="college" class="custom-select" id="college" value="<?php echo $college_ac; ?>">
                        <?php 
                        if($resultCheck = mysqli_num_rows($result)) {
                            while($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row['name'] ?>" <?php if($college_ac === $row['name']) echo 'selected'; ?>><?php echo $row['name'] ?></option>
                        <?php 
                            }
                        }
                        ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="dean">Dean Name</label>
                        <input type="text" name="dean" class="form-control" id="dean" placeholder="Dean Name" value="<?php echo $dean_ac; ?>">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputFile">Organization Image</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="org_file" id="org_file" value="<?php echo $image_ac; ?>">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                <input hidden type="file" name="image_old" value="<?php echo $image_ac; ?>">
                            </div>
                        </div>
                    </div>
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