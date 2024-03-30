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

    <style>
        /*commitment form design goes here*/
        p {
            margin-top: -15px;
        }

        ul {
            list-style-type: none;
        }

        .indent {
            text-indent: 15px;
        }

        .underline {
            text-decoration: underline;
        }

        .commitment-container{
            width: 100%;
            height: 100%;
            font-size: 10px;
        }

        .commitment-header-text{
            margin: 0 auto;
            text-align: center;
        }

        .commitment-header-text .lspu {
            font-family: Old English Text MT;
            font-size: 14px;
        }

        .commitment-header-img{
            width: 100%;
        }

        .commitment-header-img .images {
            margin-top: -50px;
            display: flex;
            justify-content: space-between;
        }

        .commitment-header-sub-text {
            margin-top: 5px;
            text-align: center;
        }

        .commitment-header-sub-text .subtext-2 {
            margin-top: 5px;
            font-size: 11px;
        }

        .commitment-body {
            margin-top: 5px;
        }

        .commitment-body .app-body-director {
            margin-top: 20px;
        }

        .commitment-body .app-body-content {
            font-size: 8px;
        }

        .commitment-body .respect {
            text-align: end;
            position: relative;
        }

        .commitment-body .respect .respect-content {
            width: auto;
            max-width: 400px;
            position: absolute;
            right: 10px;
            text-align: start;
        }

        .commitment-body .noted {
            margin-top: 100px;
        }

        .commitment-footer {
            margin-top: 25px;
            text-align: center;
        }

        .commitment-footer .footer ul {
            gap: 120px;
        }

        @media print {
            .commitment-form, .main-footer {
                display: none;
            }

            p {
                margin-top: 10px;
            }

            .commitment-container {
                font-size: 20px;
                width: 100vw;
                height: 100vh;
                padding-right: 15px;
            }

            .commitment-header {
                margin-top: 20px;
            }

            .commitment-header-text p {
                margin-top: -10px;
            }

            .commitment-header-text .lspu {
                font-size: 25px;
            }

            .commitment-header-img {
                width: 90%;
            }

            .commitment-header-img .images {
                margin-top: -120px;
            }

            .commitment-header-img .images .img-1 {
                margin-left: 40px;
            }

            .commitment-header-img .images img {
                width: 80px;
                height: 80px;
            }

            .commitment-header-sub-text {
                margin-top: 70px;
            }

            .commitment-header-sub-text .subtext-2 {
                font-size: 25px;
            }

            .commitment-body .app-body-content {
                font-size: 18px;
            }

            .commitment-body .noted {
                margin-top: 30rem;
            }

            .commitment-body .noted .indent {
                text-indent: 30px;
            }

            .commitment-footer {
                margin-top: 3rem;
            }

            .commitment-footer .footer ul {
                margin-top: 10px;
                gap: 350px;
            }
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
                            <div class="commitment-container">
                                <div class="commitment-header">
                                    <div class="commitment-header-text row">
                                        <div class="col">
                                            <p>Republic of the Philippines</p>
                                            <p class="lspu"><strong>Laguna State Polytechnic University</strong></p>
                                            <p>Province of Laguna</p>
                                        </div>
                                    </div>

                                    <div class="commitment-header-img">
                                        <div class="images row">
                                            <img class="img-1" src="../images/lspuLogo.png" alt="lspuLogo" width="40px" height="40px">
                                            <img class="img-2" src="../images/Bagong_Pilipinas_logo.png" alt="BPLogo" width="40px" height="40px">
                                        </div>
                                    </div>

                                    <div class="commitment-header-sub-text">
                                        <h6 class="subtext-2"><strong>OFFICE OF STUDENT AFFAIRS AND SERVICES</strong></h6>
                                        <h6 class="subtext-2"><strong>COMMITMENT FORM</strong></h6>
                                    </div>
                                </div>

                                <div class="commitment-body">
                                    <div class="app-body-director">
                                        <p><strong>THE DIRECTOR/CHAIRPERSON</strong></p>
                                        <p><strong>Office of Student Affairs and Services</strong></p>
                                        <p><strong>LSPU</strong></p>
                                    </div>

                                    <p class="indent">
                                        <strong>Thru: The Coordinator, Student Organization Unit</strong>
                                    </p>

                                    <p class="sir">Sir,</p>

                                    <div class="app-body-content">
                                        <p class="indent">
                                            This letter is in connection with the application for recognition of <span class="underline"><?php echo $organization ?></span> as a LSPU Student Organization.
                                        </p>
                                        <p class="indent">
                                            I, the undersigned, have committed to serve as the organizations Faculty Adviser for the academic year <span class="underline"><?php echo $year ?></span> - <span class="underline"><?php echo $year+1 ?></span>, and will therefore assume full responsibility as provided in the guidelines for the recognition of student organizations.
                                        </p>
                                        <p class="indent">
                                            Furthermore, I certify to the correctness and completeness of the documents attached to the organization application for recognition.
                                        </p>

                                        <div class="respect">
                                            <div class="respect-content">
                                                <p>Very respectfully yours,</p>
                                                <p>Name: <span class="underline"><?php echo $adviser ?></span></p>
                                                <p>Signature: ___________________________________</p>
                                                <p>College: <span class="underline"><?php echo $college ?></span></p>
                                                <p>Academic Rank: <span class="underline"><?php echo $rank ?></span></p>
                                                <p>Home Address: <span class="underline"><?php echo $address ?></span></p>
                                                <p>Contact Number(s): <span class="underline"><?php echo $contact ?></span></p>
                                                <p>Date: ___________________________________</p>
                                            </div>
                                        </div>

                                        <div class="noted">
                                            <p>Noted:</p>
                                            <p class="indent">___________________________</p>
                                            <p class="indent">Dean/Assoc. Dean of College</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="commitment-footer">
                                    <div class="approval">
                                        <p>Recommending Approval:</p>
                                        <p class="underline">AL JOHN A. VILLAREAL</p>
                                        <p>Coordinator, Student Organization Unit</p>

                                        <p>Approved/Disapproved:</p>

                                        <p class="underline">DR. ALBERTO B. CASTILLO</p>
                                        <p>Chairperson, Office of Student Affairs and Services</p>
                                    </div>

                                    <div class="footer row">
                                        <ul class="row">
                                            <li>LSPU-OSAS-SF-003</li>
                                            <li>Rev. 1</li>
                                            <li><?php echo date('d-F-Y') ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="commitment-form col-7">
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

                                    <a href="#" class="btn btn-block btn-outline-success" id="print_application"> Convert to PDF </a>

                                    <script>
                                        let printApp = document.getElementById("print_application")

                                        printApp.addEventListener("click", function () {
                                            window.print();
                                        })
                                    </script>
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