<?php 
@include '../configurations/config.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

$id = $_GET['details_id'];

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
    $adviser = mysqli_real_escape_string($conn, $_POST['adviser']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $college = mysqli_real_escape_string($conn, $_POST['college']);
    $rank = mysqli_real_escape_string($conn, $_POST['rank']);
    $year = $_POST['year'];
    $commitment_user_id = $user_id;
    $status = $_POST['status'];

    $query = " UPDATE commitment_tbl SET id = $id, organization = '$organization', adviser = '$adviser', address = '$address', contact = '$contact', college = '$college', rank = '$rank', year = '$year', status = '$status' WHERE id = $id; "; 
    $result = mysqli_query($conn, $query);

    if($result){
        header('location:./commitment.php');
        die();
    }else{
        die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
}

if(isset($_GET['details_id'])){
    $id = $_GET['details_id'];

    $sql = " SELECT * FROM commitment_tbl WHERE id = $id; ";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) <= 0)
    {
        $error[] = 'No record with id: '.$id;
    }
    $row = mysqli_fetch_assoc($result);

    $organization = $row['organization'];
    $adviser = $row['adviser'];
    $address = $row['address'];
    $contact = $row['contact'];
    $college = $row['college'];
    $rank = $row['rank'];
    $year = $row['year'];
    $status = $row['status'];
}

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
                            
                            <h1 class="m-0">Commitment Form Details</h1>
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
                            <!-- commitment form, to be continued... -->
                            <!-- <div class="container" id="commitment-container">
                                <div class="row justify-content-center" id="commitment-inner">
                                    <div class="img-left">
                                        <img src="../images/lspuLogo.png" alt="lspuLogo" class="image" width="40px" height="40px">
                                    </div>

                                    <div class="row text-center mt-3">
                                        <div class="col">
                                            <p class="text-sm">Republic of the Philippines</p>
                                            <h4 class="text-sm">Laguna State Polytechnic University</h4>
                                            <p class="text-sm">Province of Laguna</p>
                                        </div>
                                    </div>

                                    <div class="img-right">
                                        <img src="../images/Bagong_Pilipinas_logo.png" alt="BPImage" class="image" width="40px" height="40px">
                                    </div>


                                    <div class="row text-center">
                                        <h3 id="osas"><strong>Office of Student Affairs and Services</strong></h3>
                                        <p><strong>COMMITMENT FORM</strong></p>
                                    </div>

                                    <div class="row text-start px-5">
                                        <p><strong>THE DIRECTOR/CHAIRPERSON</strong></p>
                                        <p><strong>OFFICE OF STUDENT AFFAIRS AND SERVICES</strong></p>
                                        <p><strong>LSPU</strong></p>

                                        <p class="indent"><strong>Thru: The Coordinator, Student Organization Unit</strong></p>

                                        <p>Sir,</p>
                                        <p class="indent">
                                            This letter is in connection with the application for recognition of <span class="underline">
                                                @Model.OrganizationName
                                            </span>
                                            as a LSPU Student Organization. I, the undersigned, have committed to serve as the organizations Faculty
                                            Adviser for the academic year @Model.SchoolYear - @(Model.SchoolYear+1), and will therefore assume full responsibility as provided in the guidelines for the recognition of student organizations.
                                        </p>
                                        <p class="indent">
                                            Furthermore, I certify to the correctness and completeness of the documents attached to the organization
                                            application for
                                            recognition.
                                        </p>
                                    </div>

                                    <div class="container px-5">
                                        <div class="d-flex justify-content-between">
                                            <div class="align-self-end">
                                            </div>
                                            <div>
                                                <div class="text-start  commitment-sign">
                                                    <p><strong>Very respectfully yours,</strong></p>

                                                    <div class="inputs">
                                                        <p>Name: &nbsp; <span class="underline"> @Model.AdvicerName </span></p>
                                                        <p>Signature: &nbsp; <span class="underline"> _______________ </span></p>
                                                        <p>College: &nbsp; <span class="underline"> @Model.College.CollegeName </span></p>
                                                        <p>Academic Rank: &nbsp; <span class="underline"> @Model.AcademicRank.RankName </span></p>
                                                        <p>Home Address: &nbsp; <span class="underline"> @Model.HomeAddress </span></p>

                                                        <p>Contact Number(s): &nbsp; <span class="underline"> @Model.ContactNo </span></p>
                                                        <p>Date: &nbsp; <span class="underline"> _______________ </span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row text-start px-5">
                                        <p>Noted:</p>
                                        <p class="indent" id="noted">________________________</p>
                                        <p class="indent">Dean.Assoc. Dean of College</p>
                                    </div>

                                    <div class="row text-center" id="coordinators">
                                        <p>Recommending Approval:</p>
                                        <p class="underline"><strong>AL JOHN A. VILLAREAL</strong></p>
                                        <p>Coordinator, Student Organization Unit</p>

                                        <p>Approved / Disapproved:</p>
                                        <p class="underline"><strong>DR. ALBERTO B. CASTILLO</strong></p>
                                        <p>Chairperson, Office of Student Affairs and Services</p>
                                    </div>

                                    <div class="container" id="commitment-footer">
                                        <ul class="list-unstyled d-flex justify-content-between">
                                            <li class="text-start">LSPU-OSAS-SF-003</li>
                                            <li class="text-center">Rev.1</li>
                                            <li class="text-end">09 November 2020</li>
                                        </ul>
                                    </div>
                                </div>
                            </div> -->

                            <div class="commitment-container">
                                <div class="commitment-header text-center d-flex align-items-center justify-content-center">
                                    <div class="header-container row">
                                        <ul class="row">
                                            <li><img src="../images/lspuLogo.png" alt="lspuLogo"></li>
                                            <li class="mt-3">
                                                <div class="col">
                                                    <ul style="margin-left: -50px;">
                                                        <li><?php echo $rank ?></li>
                                                        <li><?php echo $college ?></li>
                                                        <li><?php echo $year ?></li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li><img src="../images/Bagong_Pilipinas_logo.png" alt="lspuLogo"></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="commitment-body">

                                </div>
                                <div class="commitment-footer">

                                </div>
                            </div>
                        </div>
                        <div class="col-7">
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
                                                <label>Academic Year</label>
                                                <select name="year" multiple class="custom-select" value="<?php echo $year_ac; ?>">
                                                    <?php
                                                    $currentYear = (new DateTime)->format("Y");
                                                    $startYear = 2024; // Set your desired start year
                                                    $endYear = 2099; // Set your desired end year

                                                    for ($year = $startYear; $year <= $endYear; $year++) {
                                                        $isDisabled = ($year !== (int)$currentYear) ? 'disabled' : '';
                                                        echo "<option selected value=\"$year\" $isDisabled>$year</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input name="commitment_user_id" value="<?php echo $user_id; ?>" class="form-control" id="user_id" disabled hidden>
                                        </div>

                                        <?php
                                        if($user_type === 'super_admin')
                                        {
                                            echo <<<SHOWSTATUS
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <input type="text" name="status" class="form-control" id="status" value="$status_ac">
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
                                </div>

                                <div class="card-footer">
                                    <button type="submit" name="submit" class="btn btn-block btn-outline-info"> Edit </button>
                                    <?php 
                                    $commitment_user_id = $user_id;
                                    $select_filter = " SELECT * FROM commitment_tbl WHERE user_id = '$commitment_user_id' ";
                                    $select_filter_result = mysqli_query($conn, $select_filter);
                                    $row = mysqli_fetch_assoc($select_filter_result)
                                    ?>
                                    <a href="./delete_commitment.php?delete_id='<?php echo $row['id'] ?>'" class="btn btn-block btn-outline-danger"> Delete </a>
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