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

if(isset($_POST['submit'])){
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    $adviser = mysqli_real_escape_string($conn, $_POST['adviser']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $college = mysqli_real_escape_string($conn, $_POST['college']);
    $rank = mysqli_real_escape_string($conn, $_POST['rank']);
    $year = $_POST['year'];
    $commitment_user_id = $user_id;

    $query = " UPDATE commitment_tbl SET id = $id, organization = '$organization', adviser = '$adviser', address = '$address', contact = '$contact', college = '$college', rank = '$rank', year = '$year' WHERE id = $id; "; 
    $result = mysqli_query($conn, $query);

    if($result){
        header('location:./commitment.php');
        die();
    }else{
        die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
}

?>




<!-- doctype -->
<?php include_once './reusable/head.php'; ?>

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
                        <h1 class="m-0">Update Commitment Form</h1>
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
                            <label>Academic Rank</label>
                            <select name="rank" multiple class="custom-select" value="<?php echo $rank_ac; ?>">
                                <option value="Instructor I">Instructor I</option>
                                <option value="Instructor II">Instructor II</option>
                                <option value="Instructor	III">Instructor	III</option>
                                <option value="Assistant Professor I">Assistant Professor I</option>
                                <option value="Assistant Professor II">Assistant Professor II</option>
                                <option value="Assistant Professor III">Assistant Professor III</option>
                                <option value="Assistant Professor IV">Assistant Professor IV</option>
                                <option value="Associate Professor I">Associate Professor I</option>
                                <option value="Associate Professor II">Associate Professor II</option>
                                <option value="Associate Professor III">Associate Professor III</option>
                                <option value="Associate Professor IV">Associate Professor IV</option>
                                <option value="Associate Professor V">Associate Professor V</option>
                                <option value="Professor I">Professor I</option>
                                <option value="Professor II">Professor II</option>
                                <option value="Professor III">Professor III</option>
                                <option value="Professor IV">Professor IV</option>
                                <option value="Professor V">Professor V</option>
                                <option value="Professor VI">Professor VI</option>
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
                                    echo "<option value=\"$year\" $isDisabled>$year</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <input name="commitment_user_id" value="<?php echo $user_id; ?>" class="form-control" id="user_id" disabled hidden>
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