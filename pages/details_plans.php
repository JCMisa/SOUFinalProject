<?php 
@include '../configurations/config.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

$id = $_GET['details_id'];

$sql = "SELECT * FROM plans WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);
$plan = mysqli_fetch_assoc($result);

$organization_ac = $plan['organization'];
$president_ac = $plan['president'];
$secretary_ac = $plan['secretary'];
$year_ac = $plan['year'];
$status_ac = $plan['status'];



$sql = "SELECT objective FROM objectives WHERE plan_id = " . $plan['id'];
$result = mysqli_query($conn, $sql);
$objectives = mysqli_fetch_all($result, MYSQLI_ASSOC);




if(isset($_POST['submit'])){
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    $organization = htmlspecialchars($organization);

    $president = mysqli_real_escape_string($conn, $_POST['president']);
    $president = htmlspecialchars($president);

    $secretary = mysqli_real_escape_string($conn, $_POST['secretary']);
    $secretary = htmlspecialchars($secretary);

    $status = $_POST['status'];
    $plans_user_id = $user_id;

    $query = " UPDATE plans SET id = $id, organization = '$organization', president = '$president', secretary = '$secretary', status = '$status' WHERE id = $id; "; 
    $result = mysqli_query($conn, $query);

    if($result){
        header('location:./plans.php');
        die();
    }else{
        die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
}

if(isset($_GET['details_id'])){
    $id = $_GET['details_id'];

    $sql = " SELECT * FROM plans WHERE id = $id; ";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) <= 0)
    {
        $error[] = 'No record with id: '.$id;
    }
    $row = mysqli_fetch_assoc($result);

    $organization = $row['organization'];
    $year = $row['year'];
    $president = $row['president'];
    $secretary = $row['secretary'];
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
        /*renewal form design goes here*/
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

        .renewal-container{
            width: 100%;
            height: 100%;
            font-size: 10px;
        }

        .renewal-header-text{
            margin: 0 auto;
            text-align: center;
        }

        .renewal-header-text .lspu {
            font-family: Old English Text MT;
            font-size: 14px;
        }

        .renewal-header-img{
            width: 100%;
        }

        .renewal-header-img .images {
            margin-top: -50px;
            display: flex;
            justify-content: space-between;
        }

        .renewal-header-sub-text {
            margin-top: 5px;
            text-align: center;
        }

        .renewal-header-sub-text .org-name {
            font-size: 14px;
        }

        .renewal-header-sub-text .subtext-2 {
            margin-top: 5px;
            font-size: 14px;
        }

        .renewal-header-sub-text .subtext-3 {
            margin-top: 5px;
            font-size: 12px;
        }

        .renewal-body {
            margin-top: 5px;
        }

        .renewal-body .app-body-director {
            margin-top: 25px;
        }

        .renewal-body .app-body-content {
            font-size: 10px;
        }

        .renewal-body .respect {
            text-align: end;
            position: relative;
        }

        .renewal-body .respect .respect-content {
            width: auto;
            max-width: 400px;
            position: absolute;
            right: 15px;
            text-align: start;
        }

        .renewal-body .noted {
            text-align: start;
            margin-top: 100px;
        }

        .renewal-body .adviser {
            text-align: start;
            margin-top: 50px;
        }

        .renewal-body .secretary {
            text-align: end;
            margin-top: -115px;
        }

        .renewal-body .dean {
            text-align: end;
            margin-top: 50px;
        }

        .renewal-footer {
            margin-top: 5px;
            text-align: center;
        }

        .renewal-footer .approval {
            margin-top: 35px;
        }

        .renewal-footer .footer ul {
            gap: 200px;
        }

        @media print {
            .renewal-form, .main-footer {
                display: none;
            }

            p {
                margin-top: -8px;
            }

            .renewal-container {
                font-size: 20px;
                width: 100vw;
                height: 100vh;
                padding-right: 47px;
            }

            .renewal-header {
                margin-top: 30px;
            }

            .renewal-header-text p {
                margin-top: -10px;
                font-size: 25px;
            }

            .renewal-header-text .lspu {
                font-size: 35px;
            }

            .renewal-header-img {
                width: 90%;
            }

            .renewal-header-img .images {
                margin-top: -120px;
            }

            .renewal-header-img .images .img-1 {
                margin-left: 60px;
            }

            .renewal-header-img .images img {
                width: 80px;
                height: 80px;
            }

            .renewal-header-sub-text {
                margin-top: 70px;
            }

            .renewal-header-sub-text .org-name {
                font-size: 26px;
            }

            .renewal-header-sub-text .subtext-2 {
                font-size: 35px;
            }

            .renewal-header-sub-text .subtext-3 {
                font-size: 20px;
            }

            .renewal-body .app-body-director  {
                margin-top: 25px;
            }

            .renewal-body .app-date {
                margin-right: 60px;
            }

            .renewal-body .app-date .app-date-p {
                margin-right: 19px;
            }

            .renewal-body .app-body-content {
                font-size: 25px;
            }

            .renewal-body .noted {
                margin-top: 7rem;
            }

            .renewal-body .noted .indent {
                text-indent: 30px;
            }

            .renewal-body .respect .respect-content {
                right: 30px;
            }

            .renewal-body .secretary {
                margin-right: 40px;
                margin-top: -230px;
            }

            .renewal-body .dean {
                margin-right: 40px;
            }

            .renewal-footer {
                margin-top: 3rem;
            }

            .renewal-footer .approval {
                margin-top: 150px;
            }

            .renewal-footer .footer ul {
                margin-top: 10px;
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
                            <a href="./plans.php" class="button">
                                <div class="button-box">
                                    <span class="button-elem">
                                    <i class="bi bi-arrow-right"></i>
                                    </span>
                                    <span class="button-elem">
                                    <i class="bi bi-arrow-right"></i>
                                    </span>
                                </div>
                            </a>
                            
                            <h1 class="m-0">Plans Form Details</h1>
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
                        <div class="col-7">
                            <!-- commitment form, to be continued... -->

                            <div class="renewal-container">
                                <div class="renewal-header">
                                    <div class="renewal-header-text row">
                                        <div class="col">
                                            <p>Republic of the Philippines</p>
                                            <p class="lspu"><strong>Laguna State Polytechnic University</strong></p>
                                            <p>Province of Laguna</p>
                                        </div>
                                    </div>

                                    <div class="renewal-header-img col">
                                        <div class="images row">
                                            <img class="img-1" src="../images/lspuLogo.png" alt="lspuLogo" width="40px" height="40px">
                                            <img class="img-2" src="../images/Bagong_Pilipinas_logo.png" alt="lspuLogo" width="40px" height="40px">
                                        </div>
                                    </div>

                                    <div class="renewal-header-sub-text">
                                        <span class="underline org-name"> <?php echo $organization_ac ?> </span>
                                        <h6 class="subtext-3" style="margin-top: -2px;"><strong>Name of Organization</strong></h6>
                                        <h6 class="subtext-2"><strong>PLAN OF ACTIVITIES</strong></h6>
                                        <h6 class="subtext-3"><strong> Semester AY <span class="underline"> <?php echo $year_ac ?> - <span class="underline"> <?php echo $year_ac + 1 ?> </span>  </strong></h6>
                                    </div>
                                </div>

                                <br>
                                
                                <div class="renewal-body">
                                    <div class="card">

                                    <div class="card-body p-0">
                                        <table class="table table-sm" style="border: 1px solid black;">
                                            <thead>
                                                <tr>
                                                    <th style="border-right: 1px solid black; border-bottom: 1px solid black;"> OBJECTIVE </th>
                                                    <th style="border-right: 1px solid black; border-bottom: 1px solid black;"> ACTIVITIES </th>
                                                    <th style="border-right: 1px solid black; border-bottom: 1px solid black;"> BRIEF DESCRIPTION </th>
                                                    <th style="border-right: 1px solid black; border-bottom: 1px solid black;"> PERSONS INVOLVED </th>
                                                    <th style="border-right: 1px solid black; border-bottom: 1px solid black;"> TARGET DATE </th>
                                                    <th style="border-bottom: 1px solid black;"> BUDGET </th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                            <tr>
                                                <td style="border-right: 1px solid black;">
                                                    <?php 
                                                        $sql = "SELECT * FROM objectives WHERE plan_id = $id";
                                                        $result = mysqli_query($conn, $sql);
                                                        
                                                        while($row = mysqli_fetch_assoc($result))
                                                        {
                                                    ?>
                                                            <?php echo $row['objective'] ?>
                                                            <hr>
                                                    <?php 
                                                        }
                                                    ?>
                                                </td>

                                                <td style="border-right: 1px solid black;">
                                                    <?php 
                                                        $sql = "SELECT * FROM activities WHERE plan_id = $id";
                                                        $result = mysqli_query($conn, $sql);
                                                        
                                                        while($row = mysqli_fetch_assoc($result))
                                                        {
                                                    ?>
                                                            <?php echo $row['activity'] ?>
                                                            <hr>
                                                    <?php 
                                                        }
                                                    ?>
                                                </td>

                                                <td style="border-right: 1px solid black;">
                                                    <?php 
                                                        $sql = "SELECT * FROM brief_description WHERE plan_id = $id";
                                                        $result = mysqli_query($conn, $sql);
                                                        
                                                        while($row = mysqli_fetch_assoc($result))
                                                        {
                                                    ?>
                                                            <?php echo $row['description'] ?>
                                                            <hr>
                                                    <?php 
                                                        }
                                                    ?>
                                                </td>

                                                <td style="border-right: 1px solid black;">
                                                    <?php 
                                                        $sql = "SELECT * FROM persons_involved WHERE plan_id = $id";
                                                        $result = mysqli_query($conn, $sql);
                                                        
                                                        while($row = mysqli_fetch_assoc($result))
                                                        {
                                                    ?>
                                                            <?php echo $row['person'] ?>
                                                            <hr>
                                                    <?php 
                                                        }
                                                    ?>
                                                </td>

                                                <td style="border-right: 1px solid black;">
                                                    <?php 
                                                        $sql = "SELECT * FROM target_date WHERE plan_id = $id";
                                                        $result = mysqli_query($conn, $sql);
                                                        
                                                        while($row = mysqli_fetch_assoc($result))
                                                        {
                                                    ?>
                                                            <?php echo $row['date'] ?>
                                                            <hr>
                                                    <?php 
                                                        }
                                                    ?>
                                                </td>

                                                <td style="border-right: 1px solid black;">
                                                    <?php 
                                                        $sql = "SELECT * FROM target_budget WHERE plan_id = $id";
                                                        $result = mysqli_query($conn, $sql);
                                                        
                                                        while($row = mysqli_fetch_assoc($result))
                                                        {
                                                    ?>
                                                            <?php echo $row['budget'] ?>
                                                            <hr>
                                                    <?php 
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>

                                    </div>

                                    <div class="app-body-content">
                                        <div class="noted">
                                            <p class="underline"> <?php echo $president_ac ?> </p>
                                            <p>Organization President</p>
                                        </div>

                                        <div class="adviser">
                                            <p>____________________________</p>
                                            <p>Faculty Adviser(s)</p>
                                        </div>

                                        <div class="secretary">
                                            <p class="underline"> <?php echo $secretary_ac ?> </p>
                                            <p>Organization Secretary</p>
                                        </div>

                                        <div class="dean">
                                            <p>____________________________</p>
                                            <p>Dean/Assoc. Dean of College</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="renewal-footer">
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
                                            <li>LSPU-OSAS-SF-004</li>
                                            <li>Rev. 1</li>
                                            <li><?php echo date('d-F-Y') ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-5 renewal-form">
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
                                    <div class="form-group">
                                        <label for="secretary">Secretary Name</label>
                                        <input type="text" name="secretary" class="form-control" id="secretary" placeholder="Organization Secretary Name" value="<?php echo $secretary_ac; ?>">
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="status" class="form-control" id="status" value="<?php echo $status_ac ?>" hidden>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input name="plans_user_id" value="<?php echo $user_id; ?>" class="form-control" id="user_id" disabled hidden>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" name="submit" class="btn btn-block btn-outline-info"> Edit </button>
                                    
                                    <?php 
                                    $id = $_GET['details_id'];
                                    $select_filter = " SELECT * FROM plans WHERE id = $id ";
                                    $select_filter_result = mysqli_query($conn, $select_filter);
                                    $row = mysqli_fetch_assoc($select_filter_result)
                                    ?>
                                    <a href="./delete_plans.php?delete_id='<?php echo $row['id'] ?>'" class="delete btn btn-block btn-outline-danger"> Delete </a>

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