<?php 

@include '../configurations/config.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

if(isset($_SESSION['user_type']) && isset($_SESSION['user_name']) && isset($_SESSION['image'])){
  $user_type = $_SESSION['user_type'];
  $user_name = $_SESSION['user_name'];
  $user_image = $_SESSION['image'];
}

$query = " SELECT * FROM user_tbl WHERE id = $user_id ";
$result = mysqli_query($conn, $query);
$result_count = mysqli_num_rows($result);
if($result_count > 0){
    $row = mysqli_fetch_assoc($result);

    $organization_ac = $row['organization'];
}

if(isset($_POST['submit'])){
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    $organization = htmlspecialchars($organization);
    
    $year = $_POST['year'];

    $president = mysqli_real_escape_string($conn, $_POST['president']);
    $president = htmlspecialchars($president);

    $secretary = mysqli_real_escape_string($conn, $_POST['secretary']);
    $secretary = htmlspecialchars($secretary);

    $status = $_POST['status'];
    $plans_user_id = $user_id;

    $objectives = $_POST['objectives'];
    $activities = $_POST['activities'];
    $descriptions = $_POST['descriptions'];
    $persons = $_POST['persons'];
    $dates = $_POST['dates'];
    $budgets = $_POST['budgets'];

    $current_year = (new DateTime)->format("Y");
    $select = " SELECT * FROM plans WHERE user_id = '$plans_user_id' && year = '$current_year'; ";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0)
    {
        $error[] = 'You already submmited a plan of activities form for this year.';
        header('location:./error_pages/conflict.php');
        die();
    }
    else
    {
        $sql = " INSERT INTO plans (organization, year, president, secretary, status, user_id) VALUES ('$organization', '$year', '$president', '$secretary', '$status', '$plans_user_id'); ";
        $result = mysqli_query($conn, $sql);

        $plan_id = mysqli_insert_id($conn);

        foreach ($objectives as $objective) {
            $objective = mysqli_real_escape_string($conn, $objective);
            $sql = " INSERT INTO objectives (plan_id, objective) VALUES ('$plan_id', '$objective'); ";
            $result = mysqli_query($conn, $sql);
        }

        foreach ($activities as $activity) {
            $activity = mysqli_real_escape_string($conn, $activity);
            $sql = " INSERT INTO activities (plan_id, activity) VALUES ('$plan_id', '$activity'); ";
            $result = mysqli_query($conn, $sql);
        }

        foreach ($descriptions as $description) {
            $description = mysqli_real_escape_string($conn, $description);
            $sql = " INSERT INTO brief_description (plan_id, description) VALUES ('$plan_id', '$description'); ";
            $result = mysqli_query($conn, $sql);
        }

        foreach ($persons as $person) {
            $person = mysqli_real_escape_string($conn, $person);
            $sql = " INSERT INTO persons_involved (plan_id, person) VALUES ('$plan_id', '$person'); ";
            $result = mysqli_query($conn, $sql);
        }

        foreach ($dates as $date) {
            $date = mysqli_real_escape_string($conn, $date);
            $sql = " INSERT INTO target_date (plan_id, date) VALUES ('$plan_id', '$date'); ";
            $result = mysqli_query($conn, $sql);
        }

        foreach ($budgets as $budget) {
            $budget = mysqli_real_escape_string($conn, $budget);
            $sql = " INSERT INTO target_budget (plan_id, budget) VALUES ('$plan_id', '$budget'); ";
            $result = mysqli_query($conn, $sql);
        }

        $_SESSION['status'] = "Plan Created Successfully";
        header('location:./plans.php');
        die();
    }
}


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
        $select = " SELECT * FROM application_upload WHERE form_type = 'plan_of_activities' && year = '$current_year' && user_id = $user_id; ";
        $result = mysqli_query($conn, $select);
        if(move_uploaded_file($file, $destination) && !mysqli_num_rows($result) > 0) {
            $status = $_POST['status_upload'];
            $form_type = $_POST['form_type'];
            $year = (new DateTime)->format("Y");
            $date_upload = date('m-d-Y');
            $date_approved = "";

            $sql = " INSERT INTO application_upload (name, size, downloads, uploader, status, year, user_id, form_type, date_upload, date_approved) VALUES('$filename', '$size', 0, '$user_name', '$status', '$year', $user_id, '$form_type', '$date_upload', '$date_approved'); ";

            if(mysqli_query($conn, $sql)) {
                echo "file uploaded successfully";
                header("Location: ./plans.php");
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

                        <h1 class="m-0">Plan of Activities</h1>
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
                        <label for="president">President Name</label>
                        <input type="text" name="president" class="form-control" id="president" placeholder="Organization President Name" required>
                    </div>

                    <div class="form-group">
                        <label for="secretary">Secretary Name</label>
                        <input type="text" name="secretary" class="form-control" id="secretary" placeholder="Organization Secretary Name" required>
                    </div>






                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group" id="objectiveContainer">
                                <label for="objectives">Objective</label>
                                <textarea name="objectives[]" class="form-control" id="objectives" rows="3" cols="50"></textarea>
                            </div>
                            <button type="button" onclick="addObjective()" class="btn btn-block btn-outline-info">Add More</button>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group" id="activityContainer">
                                <label for="activities">Activity</label>
                                <textarea name="activities[]" class="form-control" id="activities" rows="3" cols="50"></textarea>
                            </div>
                            <button type="button" onclick="addActivity()" class="btn btn-block btn-outline-info">Add More</button>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group" id="descriptionContainer">
                                <label for="descriptions">Description</label>
                                <textarea name="descriptions[]" class="form-control" id="descriptions" rows="3" cols="50"></textarea>
                            </div>
                            <button type="button" onclick="addDescription()" class="btn btn-block btn-outline-info">Add More</button>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group" id="personContainer">
                                <label for="persons">Person Involved</label>
                                <input type="text" name="persons[]" class="form-control" id="persons" placeholder="Person Involved">
                            </div>
                            <button type="button" onclick="addPerson()" class="btn btn-block btn-outline-info">Add More</button>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group" id="dateContainer">
                                <label for="dates">Target Date</label>
                                <input type="date" name="dates[]" class="form-control" id="dates">
                            </div>
                            <button type="button" onclick="addDate()" class="btn btn-block btn-outline-info">Add More</button>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group" id="budgetContainer">
                                <label for="budgets">Budget</label>
                                <input type="number" name="budgets[]" class="form-control" id="budgets" placeholder="Php 0.00">
                            </div>
                            <button type="button" onclick="addBudget()" class="btn btn-block btn-outline-info">Add More</button>
                        </div>
                    </div>

                    






                    <div class="form-group">
                        <input type="text" name="status" class="form-control" id="status" placeholder="Current Status" value="pending" hidden>
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
                </div>

                <div class="card-footer">
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>


            <br>
            <br>
            <br>


            <!-- table -->
            <div class="card">
            <div class="card-header">
            <h3 class="card-title">Plan of Activities List</h3>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Organization</th>
                            <th>President</th>
                            <th>Secretary</th>
                            <th>Academic Year</th>
                            <th>Status</th>
                            <th>Objectives</th>
                            <th>Activities</th>
                            <th>Brief Description</th>
                            <th>People Involved</th>
                            <th>Target Date</th>
                            <th>Budget</th>
                            <th>View</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM plans WHERE user_id = $user_id";
                            $result = mysqli_query($conn, $sql);

                            if(mysqli_num_rows($result) > 0) {

                                while($plan = mysqli_fetch_assoc($result))
                                {
                                    $sql2 = "SELECT objective FROM objectives WHERE plan_id = " . $plan['id'];
                                    $result2 = mysqli_query($conn, $sql2);
                                    $objectives = mysqli_fetch_all($result2, MYSQLI_ASSOC);

                                    $sql3 = "SELECT activity FROM activities WHERE plan_id = " . $plan['id'];
                                    $result3 = mysqli_query($conn, $sql3);
                                    $activities = mysqli_fetch_all($result3, MYSQLI_ASSOC);

                                    $sql4 = "SELECT description FROM brief_description WHERE plan_id = " . $plan['id'];
                                    $result4 = mysqli_query($conn, $sql4);
                                    $descriptions = mysqli_fetch_all($result4, MYSQLI_ASSOC);

                                    $sql5 = "SELECT person FROM persons_involved WHERE plan_id = " . $plan['id'];
                                    $result5 = mysqli_query($conn, $sql5);
                                    $people = mysqli_fetch_all($result5, MYSQLI_ASSOC);

                                    $sql6 = "SELECT date FROM target_date WHERE plan_id = " . $plan['id'];
                                    $result6 = mysqli_query($conn, $sql6);
                                    $dates = mysqli_fetch_all($result6, MYSQLI_ASSOC);

                                    $sql7 = "SELECT budget FROM target_budget WHERE plan_id = " . $plan['id'];
                                    $result7 = mysqli_query($conn, $sql7);
                                    $budgets = mysqli_fetch_all($result7, MYSQLI_ASSOC);
                        ?>
                                    <tr>
                                        <td> <?php echo $plan['id'] ?> </td>
                                        <td> <?php echo $plan['organization'] ?> </td>
                                        <td> <?php echo $plan['president'] ?> </td>
                                        <td> <?php echo $plan['secretary'] ?> </td>
                                        <td> <?php echo $plan['year'] ?> </td>
                                        <td> 
                                            <?php 
                                                if(strtolower($plan['status']) === 'pending')
                                                {
                                                    echo '<button type="button" class="btn btn-block bg-gradient-warning btn-sm">PENDING</button>';
                                                } else if(strtolower($plan['status']) === 'success'){
                                                    echo '<button type="button" class="btn btn-block bg-gradient-success btn-sm"> SUCCESS </button>';
                                                } else {
                                                    echo '<button type="button" class="btn btn-block bg-gradient-danger btn-sm">FAILED</button>';
                                                }
                                            ?> 
                                        </td>
                                        <td> 
                                            <?php 
                                                foreach($objectives as $objective)
                                                {
                                                    echo $objective['objective'];
                                                    echo "<hr>";
                                                } 
                                            ?> 
                                        </td>
                                        <td> 
                                            <?php 
                                                foreach($activities as $activity)
                                                {
                                                    echo $activity['activity'];
                                                    echo "<hr>";
                                                } 
                                            ?> 
                                        </td>
                                        <td> 
                                            <?php 
                                                foreach($descriptions as $description)
                                                {
                                                    echo $description['description'];
                                                    echo "<hr>";
                                                } 
                                            ?> 
                                        </td>
                                        <td> 
                                            <?php 
                                                foreach($people as $person)
                                                {
                                                    echo $person['person'];
                                                    echo "<hr>";
                                                } 
                                            ?> 
                                        </td>
                                        <td> 
                                            <?php 
                                                foreach($dates as $date)
                                                {
                                                    echo $date['date'];
                                                    echo "<hr>";
                                                } 
                                            ?> 
                                        </td>
                                        <td> 
                                            <?php 
                                                foreach($budgets as $budget)
                                                {
                                                    echo $budget['budget'];
                                                    echo "<hr>";
                                                } 
                                            ?> 
                                        </td>

                                        <td> <a href="./details_plans.php?details_id='<?php echo $plan['id'] ?>'" class="btn btn-block btn-outline-warning"> View </a> </td>
                                        <td> <a href="./update_plans.php?update_id='<?php echo $plan['id'] ?>'" class="btn btn-block btn-outline-info"> Edit </a> </td>
                                        <td> <a href="./delete_plans.php?delete_id='<?php echo $plan['id'] ?>'" class="delete btn btn-block btn-outline-danger"> Delete </a> </td>
                                    </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Organization</th>
                            <th>President</th>
                            <th>Secretary</th>
                            <th>Academic Year</th>
                            <th>Status</th>
                            <th>Objectives</th>
                            <th>Activities</th>
                            <th>Brief Description</th>
                            <th>People Involved</th>
                            <th>Target Date</th>
                            <th>Budget</th>
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
                    <h3 class="card-title">Upload Plan of Activities Form (With Signature)</h3>
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
                                    <option value="renewal" disabled>Renewal</option>
                                    <option value="commitment" disabled>Commitment</option>
                                    <option value="plan_of_activities" selected>Plan of Activities</option>
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
                    <h3 class="card-title">Plans Submission List</h3>
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
                                $select_filter = " SELECT * FROM application_upload WHERE user_id = '$user_id' AND form_type = 'plan_of_activities'; ";
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
    <script>
        function addObjective() {
            var container = document.querySelector("#objectiveContainer");
            var textarea =document.createElement("textarea");
            textarea.name = "objectives[]";
            textarea.id = "objectives";
            textarea.rows = 3;
            textarea.cols = 50;
            textarea.classList = "form-control";

            container.appendChild(document.createElement("br"));
            container.appendChild(textarea);
        }

        function addActivity() {
            var container = document.querySelector("#activityContainer");
            var textarea =document.createElement("textarea");
            textarea.name = "activities[]";
            textarea.id = "activities";
            textarea.rows = 3;
            textarea.cols = 50;
            textarea.classList = "form-control";

            container.appendChild(document.createElement("br"));
            container.appendChild(textarea);
        }

        function addDescription() {
            var container = document.querySelector("#descriptionContainer");
            var textarea =document.createElement("textarea");
            textarea.name = "descriptions[]";
            textarea.id = "descriptions";
            textarea.rows = 3;
            textarea.cols = 50;
            textarea.classList = "form-control";

            container.appendChild(document.createElement("br"));
            container.appendChild(textarea);
        }

        function addPerson() {
            var container = document.querySelector("#personContainer");
            var input =document.createElement("input");
            input.name = "persons[]";
            input.id = "persons";
            input.type = "text";
            input.classList = "form-control";
            input.placeholder = "Person Involved";

            container.appendChild(document.createElement("br"));
            container.appendChild(input);
        }

        function addDate() {
            var container = document.querySelector("#dateContainer");
            var input =document.createElement("input");
            input.name = "dates[]";
            input.id = "dates";
            input.type = "date";
            input.classList = "form-control";

            container.appendChild(document.createElement("br"));
            container.appendChild(input);
        }

        function addBudget() {
            var container = document.querySelector("#budgetContainer");
            var input =document.createElement("input");
            input.name = "budgets[]";
            input.id = "budgets";
            input.type = "number";
            input.classList = "form-control";
            input.placeholder = "Php 0.00";

            container.appendChild(document.createElement("br"));
            container.appendChild(input);
        }
    </script>
</body>
</html>