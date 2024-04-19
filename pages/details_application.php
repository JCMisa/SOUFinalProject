<?php 
@include '../configurations/config.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

$id = $_GET['details_id'];

$sql = " SELECT * FROM application_tbl WHERE id = $id; ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$organization_ac = $row['organization'];
$president_ac = $row['president'];
$year_ac = $row['year'];
$status_ac = $row['status'];

if(isset($_POST['submit'])){
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    $organization = htmlspecialchars($organization);

    $president = mysqli_real_escape_string($conn, $_POST['president']);
    $president = htmlspecialchars($president);
    
    $status = $_POST['status'];
    $application_user_id = $user_id;

    $query = " UPDATE application_tbl SET id = $id, organization = '$organization', president = '$president', status = '$status' WHERE id = $id; "; 
    $result = mysqli_query($conn, $query);

    if($result){
        header('location:./application.php');
        die();
    }else{
        die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
}

if(isset($_GET['details_id'])){
    $id = $_GET['details_id'];

    $sql = " SELECT * FROM application_tbl WHERE id = $id; ";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) <= 0)
    {
        $error[] = 'No record with id: '.$id;
    }
    $row = mysqli_fetch_assoc($result);

    $organization = $row['organization'];
    $president = $row['president'];
    $year = $row['year'];
    $status = $row['status'];
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

    <style>
        /*application form design goes here*/
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

        .application-container{
            width: 100%;
            height: 100%;
            font-size: 10px;
        }

        .application-header-text{
            margin: 0 auto;
            text-align: center;
        }

        .application-header-text .lspu {
            font-family: Old English Text MT;
            font-size: 14px;
        }

        .application-header-img{
            width: 100%;
        }

        .application-header-img .images {
            margin-top: -50px;
            display: flex;
            justify-content: space-between;
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
            margin-top: 15px;
        }

        .application-body .app-date .app-date-p {
            margin-right: 11px;
        }

        .application-body .app-body-director {
            margin-top: 5px;
        }

        .application-body .app-body-content {
            font-size: 8px;
        }

        .application-body .respect {
            text-align: end;
            position: relative;
        }

        .application-body .respect .respect-content {
            width: auto;
            max-width: 400px;
            position: absolute;
            right: 15px;
            text-align: start;
        }

        .application-body .noted {
            margin-top: 100px;
        }

        .application-body .dean {
            text-align: end;
        }

        .application-footer {
            margin-top: 5px;
            text-align: center;
        }

        .application-footer .footer ul {
            gap: 120px;
        }

        @media print {
            .application-form, .main-footer {
                display: none;
            }

            p {
                margin-top: -8px;
            }

            .application-container {
                font-size: 20px;
                width: 100vw;
                height: 100vh;
                padding-right: 35px;
            }

            .application-header {
                margin-top: 20px;
            }

            .application-header-text p {
                margin-top: -10px;
            }

            .application-header-text .lspu {
                font-size: 25px;
            }

            .application-header-img {
                width: 90%;
            }

            .application-header-img .images {
                margin-top: -120px;
            }

            .application-header-img .images .img-1 {
                margin-left: 40px;
            }

            .application-header-img .images img {
                width: 80px;
                height: 80px;
            }

            .application-header-sub-text {
                margin-top: 70px;
            }

            .application-header-sub-text .subtext-2 {
                font-size: 25px;
            }

            .application-body .app-body-director  {
                margin-top: -20px;
            }

            .application-body .app-date {
                margin-right: 60px;
            }

            .application-body .app-date .app-date-p {
                margin-right: 19px;
            }

            .application-body .app-body-content {
                font-size: 18px;
            }

            .application-body .noted {
                margin-top: 17rem;
            }

            .application-body .noted .indent {
                text-indent: 30px;
            }

            .application-body .respect .respect-content {
                right: 30px;
            }

            .application-body .dean {
                margin-right: 40px;
            }

            .application-footer .approval {
                margin-top: -20px;
            }

            .application-footer {
                margin-top: 3rem;
            }

            .application-footer .footer ul {
                margin-top: -20px;
                gap: 320px;
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
                            <a href="./application.php" class="button">
                                <div class="button-box">
                                    <span class="button-elem">
                                    <i class="bi bi-arrow-right"></i>
                                    </span>
                                    <span class="button-elem">
                                    <i class="bi bi-arrow-right"></i>
                                    </span>
                                </div>
                            </a>
                            
                            <h1 class="m-0">Application Form Details</h1>
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

                            <div class="application-container">
                                <div class="application-header">
                                    <div class="application-header-text row">
                                        <div class="col">
                                            <p>Republic of the Philippines</p>
                                            <p class="lspu"><strong>Laguna State Polytechnic University</strong></p>
                                            <p>Province of Laguna</p>
                                        </div>
                                    </div>

                                    <div class="application-header-img col">
                                        <div class="images row">
                                            <img class="img-1" src="../images/lspuLogo.png" alt="lspuLogo" width="40px" height="40px">
                                            <img class="img-2" src="../images/Bagong_Pilipinas_logo.png" alt="lspuLogo" width="40px" height="40px">
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

                                    <p class="sir">Sir:</p>

                                    <div class="app-body-content">
                                        <p class="indent">
                                            I have the honor to apply for recognition/renewal of <span class="underline"><?php echo $organization ?></span>, a duly recognized organization in this University.
                                        </p>
                                        <p class="indent">
                                            In compliance with CHED Memo Order #9 s. 2013, Subj.: Enhanced Policies & Guidelines on Student Affairs and Services (Article VIII-Student Development, Section 19. Student Organizations and Activities) I am submitting for proper action the following requirements for recognition and accreditation.
                                        </p>
                                        <p class="indent">
                                            <ol>
                                                <li>Letter for application for recognition (4 copies)</li>
                                                <li>Constitution and By-Laws of the Organization (4 copies)</li>
                                                <li>Program of activities for one (1) year (4 copies)</li>
                                                <li>List of officers with signature, student I.D. Nos. and attached 2x2 I.D. picture (4 copies)</li>
                                                <li>List of members with signature, student I.D. number and attached 1x1 ID picture (4 copies)</li>
                                                <li>Accomplishment report (for renewal of accreditation) (4 copies)</li>
                                            </ol>
                                        </p>

                                        <p class="indent">
                                            It is understood that the provision to the LSPU Supplementary Rules and Regulations Governing Student Organizations in this official Recognition are good only for one (1) shool year subject to renewal unless revoked prior to this expiration.
                                        </p>

                                        <div class="respect">
                                            <div class="respect-content">
                                                <p>Respectfully yours,</p>
                                                <p class="underline"><?php echo $president ?></p>
                                                <p>Organization President</p>
                                                <p class="underline"><?php echo $organization ?></p>
                                                <p>Name of Organization</p>
                                            </div>
                                        </div>

                                        <div class="noted">
                                            <p>Noted:</p>
                                            <p>___________________________</p>
                                            <p>Adviser, Student Organization</p>
                                        </div>

                                        <div class="dean">
                                            <p>____________________________</p>
                                            <p>Dean/Assoc. Dean of College</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="application-footer">
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
                                            <li>LSPU-OSAS-SF-001</li>
                                            <li>Rev. 1</li>
                                            <li><?php echo date('d-F-Y') ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-7 application-form">
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
                                    
                                    <div class="row">
                                        <div class="form-group">
                                            <input name="application_user_id" value="<?php echo $user_id; ?>" class="form-control" id="user_id" disabled hidden>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" name="status" class="form-control" id="status" value="<?php echo $status_ac ?>" hidden>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" name="submit" class="btn btn-block btn-outline-info"> Edit </button>

                                    <?php 
                                    $id = $_GET['details_id'];
                                    $select_filter = " SELECT * FROM application_tbl WHERE id = $id ";
                                    $select_filter_result = mysqli_query($conn, $select_filter);
                                    $row = mysqli_fetch_assoc($select_filter_result)
                                    ?>
                                    <a href="./delete_application.php?delete_id='<?php echo $row['id'] ?>'" class="delete btn btn-block btn-outline-danger"> Delete </a>

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