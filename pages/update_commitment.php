<?php

@include '../configurations/config.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

$id = $_GET['update_id'];

$sql = " SELECT * FROM commitment_tbl WHERE id = $id; ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$organization_ac = $row['organization'];
$adviser_ac = $row['adviser'];
$address_ac = $row['address'];
$contact_ac = $row['contact'];
$college_ac = $row['college'];
$rank_ac = $row['rank'];
$year_ac = $row['year'];
$status_ac = $row['status'];

if(isset($_POST['submit'])){
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    $organization = htmlspecialchars($organization);

    $adviser = mysqli_real_escape_string($conn, $_POST['adviser']);
    $adviser = htmlspecialchars($adviser);

    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $address = htmlspecialchars($address);

    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $contact = htmlspecialchars($contact);

    $college = mysqli_real_escape_string($conn, $_POST['college']);
    $college = htmlspecialchars($college);

    $rank = mysqli_real_escape_string($conn, $_POST['rank']);
    $rank = htmlspecialchars($rank);

    $commitment_user_id = $user_id;
    $status = $_POST['status'];

    $query = " UPDATE commitment_tbl SET id = $id, organization = '$organization', adviser = '$adviser', address = '$address', contact = '$contact', college = '$college', rank = '$rank', status = '$status' WHERE id = $id; "; 
    $result = mysqli_query($conn, $query);

    if($result){
        $_SESSION['status'] = "Commitment Updated Successfully";
        header('location:./commitment.php');
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
                            <a href="./commitment.php" class="button">
                                <div class="button-box">
                                    <span class="button-elem">
                                    <i class="bi bi-arrow-right"></i>
                                    </span>
                                    <span class="button-elem">
                                    <i class="bi bi-arrow-right"></i>
                                    </span>
                                </div>
                            </a>
                            
                            <h1 class="m-0">Update Commitment Form</h1>
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
                    <input type="text" name="organization" class="form-control" id="org" placeholder="Organization Name" value="<?php echo $organization_ac; ?>">
                </div>
                <div class="form-group">
                    <label for="adviser">Adviser Name</label>
                    <input type="text" name="adviser" class="form-control" id="adviser" placeholder="Adviser Name" value="<?php echo $adviser_ac; ?>">
                </div>
                <div class="form-group">
                    <label for="address">Home Address</label>
                    <input type="text" name="address" class="form-control" id="address" placeholder="Home Address" value="<?php echo $address_ac; ?>">
                </div>
                <div class="form-group">
                    <label for="contact">Contact No.</label>
                    <input type="text" name="contact" class="form-control" id="contact" placeholder="Contact No." value="<?php echo $contact_ac; ?>">
                </div>
                
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>College</label>
                            <select name="college" multiple class="custom-select" value="<?php echo $college_ac; ?>">
                                <option value="COLLEGE OF COMPUTER STUDIES (CCS)" <?php if($college_ac === "COLLEGE OF COMPUTER STUDIES (CCS)") echo 'selected'; ?>>COLLEGE OF COMPUTER STUDIES (CCS)</option>

                                <option value="COLLEGE OF ARTS AND SCIENCES (CAS)" <?php if($college_ac === "COLLEGE OF ARTS AND SCIENCES (CAS)") echo 'selected'; ?>>COLLEGE OF ARTS AND SCIENCES (CAS)</option>

                                <option value="COLLEGE OF BUSINESS, ADMINISTRATION AND ACCOUNTANCY (CBAA)" <?php if($college_ac === "COLLEGE OF BUSINESS, ADMINISTRATION AND ACCOUNTANCY (CBAA)") echo 'selected'; ?>>COLLEGE OF BUSINESS, ADMINISTRATION AND ACCOUNTANCY (CBAA)</option>

                                <option value="COLLEGE OF CRIMINAL JUSTICE EDUCATION (CCJE)" <?php if($college_ac === "COLLEGE OF CRIMINAL JUSTICE EDUCATION (CCJE)") echo 'selected'; ?>>COLLEGE OF CRIMINAL JUSTICE EDUCATION (CCJE)</option>

                                <option value="COLLEGE OF ENGINEERING (COE)" <?php if($college_ac === "COLLEGE OF ENGINEERING (COE)") echo 'selected'; ?>>COLLEGE OF ENGINEERING (COE)</option>

                                <option value="COLLEGE OF HOSPITALITY MANAGEMENT AND TOURISM (CHMT)" <?php if($college_ac === "COLLEGE OF HOSPITALITY MANAGEMENT AND TOURISM (CHMT)") echo 'selected'; ?>>COLLEGE OF HOSPITALITY MANAGEMENT AND TOURISM (CHMT)</option>

                                <option value="COLLEGE OF INDUSTRIAL TECHNOLOGY (CIT)" <?php if($college_ac === "COLLEGE OF INDUSTRIAL TECHNOLOGY (CIT)") echo 'selected'; ?>>COLLEGE OF INDUSTRIAL TECHNOLOGY (CIT)</option>

                                <option value="COLLEGE OF TEACHER EDUCATION (CTE)" <?php if($college_ac === "COLLEGE OF TEACHER EDUCATION (CTE)") echo 'selected'; ?>>COLLEGE OF TEACHER EDUCATION (CTE)</option>

                                <option value="SENIOR HIGH SCHOOL (SHS)" <?php if($college_ac === "SENIOR HIGH SCHOOL (SHS)") echo 'selected'; ?>>SENIOR HIGH SCHOOL (SHS)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Academic Rank</label>
                            <select name="rank" multiple class="custom-select" value="<?php echo $rank_ac; ?>">
                                <option value="Instructor I" <?php if($rank_ac === "Instructor I") echo 'selected'; ?>>Instructor I</option>

                                <option value="Instructor II" <?php if($rank_ac === "Instructor II") echo 'selected'; ?>>Instructor II</option>
                                
                                <option value="Instructor III" <?php if($rank_ac === "Instructor III") echo 'selected'; ?>>Instructor III</option>

                                <option value="Assistant Professor I" <?php if($rank_ac === "Assistant Professor I") echo 'selected'; ?>>Assistant Professor I</option>

                                <option value="Assistant Professor II" <?php if($rank_ac === "Assistant Professor II") echo 'selected'; ?>>Assistant Professor II</option>

                                <option value="Assistant Professor III" <?php if($rank_ac === "Assistant Professor III") echo 'selected'; ?>>Assistant Professor III</option>

                                <option value="Assistant Professor IV" <?php if($rank_ac === "Assistant Professor IV") echo 'selected'; ?>>Assistant Professor IV</option>

                                <option value="Associate Professor I" <?php if($rank_ac === "Associate Professor I") echo 'selected'; ?>>Associate Professor I</option>

                                <option value="Associate Professor II" <?php if($rank_ac === "Associate Professor II") echo 'selected'; ?>>Associate Professor II</option>

                                <option value="Associate Professor III" <?php if($rank_ac === "Associate Professor III") echo 'selected'; ?>>Associate Professor III</option>

                                <option value="Associate Professor IV" <?php if($rank_ac === "Associate Professor IV") echo 'selected'; ?>>Associate Professor IV</option>

                                <option value="Associate Professor V" <?php if($rank_ac === "Associate Professor V") echo 'selected'; ?>>Associate Professor V</option>

                                <option value="Professor I" <?php if($rank_ac === "Professor I") echo 'selected'; ?>>Professor I</option>

                                <option value="Professor II" <?php if($rank_ac === "Professor II") echo 'selected'; ?>>Professor II</option>

                                <option value="Professor III" <?php if($rank_ac === "Professor III") echo 'selected'; ?>>Professor III</option>

                                <option value="Professor IV" <?php if($rank_ac === "Professor IV") echo 'selected'; ?>>Professor IV</option>

                                <option value="Professor V" <?php if($rank_ac === "Professor V") echo 'selected'; ?>>Professor V</option>

                                <option value="Professor VI" <?php if($rank_ac === "Professor VI") echo 'selected'; ?>>Professor VI</option>
                            </select>
                        </div>
                    </div>

                   
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input name="commitment_user_id" value="<?php echo $user_id; ?>" class="form-control" id="user_id" disabled hidden>
                        </div>

                        <div class="form-group">
                            <input type="text" name="status" class="form-control" id="status" value="$status_ac" hidden>
                        </div>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                        </div>
                    </div>
                </div> -->
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