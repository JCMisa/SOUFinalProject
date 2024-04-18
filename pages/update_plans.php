<?php

@include '../configurations/config.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

$id = $_GET['update_id'];

$sql = " SELECT * FROM plans WHERE id = $id; ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$organization_ac = $row['organization'];
$president_ac = $row['president'];
$secretary_ac = $row['secretary'];
$year_ac = $row['year'];
$status_ac = $row['status'];


$sql = " SELECT * FROM objectives WHERE plan_id = $id; ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$objectives_ac = $row['objective'];

$sql = " SELECT * FROM activities WHERE plan_id = $id; ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$activities_ac = $row['activity'];

$sql = " SELECT * FROM brief_description WHERE plan_id = $id; ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$descriptions_ac = $row['description'];

$sql = " SELECT * FROM persons_involved WHERE plan_id = $id; ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$persons_ac = $row['person'];

$sql = " SELECT * FROM target_date WHERE plan_id = $id; ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$dates_ac = $row['date'];

$sql = " SELECT * FROM target_budget WHERE plan_id = $id; ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$budgets_ac = $row['budget'];

if(isset($_POST['submit'])){
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    $organization = htmlspecialchars($organization);

    $president = mysqli_real_escape_string($conn, $_POST['president']);
    $president = htmlspecialchars($president);

    $secretary = mysqli_real_escape_string($conn, $_POST['secretary']);
    $secretary = htmlspecialchars($secretary);

    $status = $_POST['status'];

    // $objectives = $_POST['objectives'];
    $activities = $_POST['activities'];
    $descriptions = $_POST['descriptions'];
    $persons = $_POST['persons'];
    $dates = $_POST['dates'];
    $budgets = $_POST['budgets'];

    $plans_user_id = $user_id;

    $query = " UPDATE plans SET id = $id, organization = '$organization', president = '$president', secretary = '$secretary', status = '$status' WHERE id = $id; "; 
    $result = mysqli_query($conn, $query);


    // $sql = "SELECT id, objective FROM objectives WHERE plan_id = $id";
    // $result = mysqli_query($conn, $sql);
    
    // $objectives = $_POST['objectives'];
    // $i = 0;
    // while($row = mysqli_fetch_assoc($result))
    // {
    //     $objective_id = $row['id'];
    //     $objective = mysqli_real_escape_string($conn, $objectives[$i]);

    //     $query2 = " UPDATE objectives SET objective = '$objective' WHERE id = $objective_id AND plan_id = $id; ";
    //     $result2 = mysqli_query($conn, $query2);

    //     if($result2){
    //         header('location:./plans.php');
    //         die();
    //     }

    //     $i += 1;
    // }

    if($result){
        header('location:./plans.php');
        die();
    }else{
        die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
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
                            
                            <h1 class="m-0">Update Plan of Activities Form</h1>
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
                    <?php 
                        $sql = "SELECT * FROM plans WHERE user_id = $user_id";
                        $result = mysqli_query($conn, $sql);

                        if(mysqli_num_rows($result) > 0) 
                        {
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
                                <div class="form-group">
                                    <label for="org">Organization Name</label>
                                    <input type="text" name="organization" class="form-control" id="org" placeholder="Organization Name" value="<?php echo $plan['organization']; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="president">President Name</label>
                                    <input type="text" name="president" class="form-control" id="president" placeholder="Organization President Name" value="<?php echo $plan['president']; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="secretary">Secretary Name</label>
                                    <input type="text" name="secretary" class="form-control" id="secretary" placeholder="Organization Secretary Name" value="<?php echo $plan['secretary']; ?>">
                                </div>

                                <div class="row">
                                    <div class="col-sm-2">
                                        <?php 
                                            foreach($objectives as $objective)
                                            {
                                        ?> 
                                                <div class="form-group" id="objectiveContainer">
                                                    <label for="objectives">Objective</label>
                                                    <textarea name="objectives[]" class="form-control" id="objectives" rows="3" cols="50" disabled>
                                                        <?php echo $objective['objective']; ?>
                                                    </textarea>
                                                </div>
                                                <button disabled type="button" onclick="addObjective()" class="btn btn-block btn-outline-info">Add More</button>
                                        <?php 
                                            }
                                        ?>
                                    </div>

                                    <div class="col-sm-2">
                                        <?php 
                                            foreach($activities as $activity)
                                            {
                                        ?>
                                                <div class="form-group" id="activityContainer">
                                                    <label for="activities">Activity</label>
                                                    <textarea name="activities[]" class="form-control" id="activities" rows="3" cols="50" disabled>
                                                        <?php echo $activity['activity']; ?>
                                                    </textarea>
                                                </div>
                                                <button disabled type="button" onclick="addActivity()" class="btn btn-block btn-outline-info">Add More</button>
                                        <?php 
                                            }
                                        ?>
                                    </div>

                                    <div class="col-sm-2">
                                        <?php 
                                            foreach($descriptions as $description)
                                            {
                                        ?>
                                                <div class="form-group" id="descriptionContainer">
                                                    <label for="descriptions">Description</label>
                                                    <textarea name="descriptions[]" class="form-control" id="descriptions" rows="3" cols="50" disabled>
                                                        <?php echo $description['description']; ?>
                                                    </textarea>
                                                </div>
                                                <button disabled type="button" onclick="addDescription()" class="btn btn-block btn-outline-info">Add More</button>
                                        <?php 
                                            }
                                        ?>
                                    </div>

                                    <div class="col-sm-2">
                                        <?php 
                                            foreach($people as $person)
                                            {
                                        ?>
                                                <div class="form-group" id="personContainer">
                                                    <label for="persons">Person Involved</label>
                                                    <input disabled type="text" name="persons[]" class="form-control" id="persons" placeholder="Person Involved" value="<?php echo $person['person']; ?>">
                                                </div>
                                                <button disabled type="button" onclick="addPerson()" class="btn btn-block btn-outline-info">Add More</button>
                                        <?php 
                                            }
                                        ?>
                                    </div>

                                    <div class="col-sm-2">
                                        <?php 
                                            foreach($dates as $date)
                                            {
                                        ?>
                                                <div class="form-group" id="dateContainer">
                                                    <label for="dates">Target Date</label>
                                                    <input disabled type="date" name="dates[]" class="form-control" id="dates" value="<?php echo $date['date']; ?>">
                                                </div>
                                                <button disabled type="button" onclick="addDate()" class="btn btn-block btn-outline-info">Add More</button>
                                        <?php 
                                            }
                                        ?>
                                    </div>

                                    <div class="col-sm-2">
                                        <?php 
                                            foreach($budgets as $budget)
                                            {
                                        ?>
                                                 <div class="form-group" id="budgetContainer">
                                                    <label for="budgets">Budget</label>
                                                    <input disabled type="number" name="budgets[]" class="form-control" id="budgets" placeholder="Php 0.00" value="<?php echo $budget['budget']; ?>">
                                                </div>
                                                <button disabled type="button" onclick="addBudget()" class="btn btn-block btn-outline-info">Add More</button>
                                        <?php 
                                            }
                                        ?>
                                    </div>

                                </div>
                    <?php 
                            }
                        }
                    ?>
                    






                    <div class="form-group">
                        <input type="text" name="status" class="form-control" id="status" placeholder="Current Status" value="<?php echo $status_ac; ?>" hidden>
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
<!-- <script>
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
</script> -->
</body>
</html>