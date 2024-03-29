<?php 
@include '../configurations/config.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

$id = $_GET['details_id'];

$sql = " SELECT * FROM renewal_tbl WHERE id = $id; ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$organization_ac = $row['organization'];
$college_ac = $row['college'];
$year_ac = $row['year'];
$president_ac = $row['president'];
$status_ac = $row['status'];

if(isset($_POST['submit'])){
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    $college = mysqli_real_escape_string($conn, $_POST['college']);
    $year = $_POST['year'];
    $president = mysqli_real_escape_string($conn, $_POST['president']);
    $status = $_POST['status'];
    $renewal_user_id = $user_id;

    $query = " UPDATE renewal_tbl SET id = $id, organization = '$organization', college = '$college', year = '$year', president = '$president', status = '$status' WHERE id = $id; "; 
    $result = mysqli_query($conn, $query);

    if($result){
        header('location:./renewal.php');
        die();
    }else{
        die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
}

if(isset($_GET['details_id'])){
    $id = $_GET['details_id'];

    $sql = " SELECT * FROM renewal_tbl WHERE id = $id; ";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) <= 0)
    {
        $error[] = 'No record with id: '.$id;
    }
    $row = mysqli_fetch_assoc($result);

    $organization = $row['organization'];
    $college = $row['college'];
    $year = $row['year'];
    $president = $row['president'];
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

    <style>
    /*application form design goes here*/
    .application-container{
        width: 100%;
        height: 100%;
        font-size: 10px;
    }

    .application-header-text{
        margin: 0 auto;
        text-align: center;
        line-height: 1px;
    }

    .application-header-img{
        position: absolute;
        top: 0;
    }

    .application-header-img .images {
        gap: 78%;
    }

    .application-header-sub-text {
        margin-top: 5px;
        text-align: center;
    }

    .application-header-sub-text .subtext-2 {
        margin-top: 5px;
        font-size: 11px;
    }

    .application-body {
        margin-top: 5px;
    }

    .application-body .app-date {
        text-align: end;
        line-height: 1px;
    }

    .application-body .app-date .app-date-p {
        margin-right: 11px;
    }

    .application-body .app-body-director {
        margin-top: 5px;
        line-height: 1px;
    }
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
                            
                            <h1 class="m-0">Renewal Form Details</h1>
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

            <section class="content">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-5">
                            <!-- commitment form, to be continued... -->

                            <div class="application-container">
                                <div class="application-header">
                                    <div class="application-header-text row">
                                        <div class="col">
                                            <p>Republic of the Philippines</p>
                                            <p><strong>Laguna State Polytechnic University</strong></p>
                                            <p>Province of Laguna</p>
                                        </div>
                                    </div>

                                    <div class="application-header-img col">
                                        <div class="images row">
                                            <img src="../images/lspuLogo.png" alt="lspuLogo" width="40px" height="40px">
                                            <img src="../images/Bagong_Pilipinas_logo.png" alt="lspuLogo" width="40px" height="40px">
                                        </div>
                                    </div>

                                    <div class="application-header-sub-text">
                                        <h6 class="subtext-2"><strong>OFFICE OF STUDENT AFFAIRS AND SERVICES</strong></h6>
                                        <h6 class="subtext-2"><strong>APPLICATION FOR RECOGNITION/RENEWAL OF ACCREDITED STUDENT ORGANIZATION</strong></h6>
                                    </div>
                                </div>

                                <div class="application-body">
                                    <div class="app-date">
                                        <p>___________</p>
                                        <p class="app-date-p">Date</p>
                                    </div>

                                    <div class="app-body-director">
                                        <p><strong>THE DIRECTOR/CHAIRPERSON</strong></p>
                                        <p>Office of Student Affairs and Services</p>
                                        <p>LSPU</p>
                                    </div>
                                </div>

                                <div class="application-footer">

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
                                        <label for="president">President Name</label>
                                        <input type="text" name="president" class="form-control" id="president" placeholder="Organization President Name" value="<?php echo $president_ac; ?>">
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
                                            <input name="renewal_user_id" value="<?php echo $user_id; ?>" class="form-control" id="user_id" disabled hidden>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" name="submit" class="btn btn-block btn-outline-info"> Edit </button>
                                    <?php 
                                    $renewal_user_id = $user_id;
                                    $select_filter = " SELECT * FROM renewal_tbl WHERE user_id = '$renewal_user_id' ";
                                    $select_filter_result = mysqli_query($conn, $select_filter);
                                    $row = mysqli_fetch_assoc($select_filter_result)
                                    ?>
                                    <a href="./delete_renewal.php?delete_id='<?php echo $row['id'] ?>'" class="btn btn-block btn-outline-danger"> Delete </a>
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