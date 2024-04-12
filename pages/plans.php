<?php 

@include '../configurations/config.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

if(isset($_SESSION['user_type']) && isset($_SESSION['user_name'])){
  $user_type = $_SESSION['user_type'];
  $user_name = $_SESSION['user_name'];
}


if(isset($_POST['submit'])){
    $organization = $_POST['organization'];
    $year = $_POST['year'];
    $president = $_POST['president'];
    $secretary = $_POST['secretary'];
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

        header('location:./plans.php');
        die();
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
                        <label for="org">Organization Name</label>
                        <input type="text" name="organization" class="form-control" id="org" placeholder="Organization Name">
                    </div>

                    <div class="form-group">
                        <label for="president">President Name</label>
                        <input type="text" name="president" class="form-control" id="president" placeholder="Organization President Name">
                    </div>

                    <div class="form-group">
                        <label for="secretary">Secretary Name</label>
                        <input type="text" name="secretary" class="form-control" id="secretary" placeholder="Organization Secretary Name">
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
                            $sql = " SELECT plans.id AS plan_id, 
                            plans.organization, 
                            plans.president, 
                            plans.secretary, 
                            plans.year, 
                            plans.status, 
                            objectives.objective,
                            activities.activity,
                            brief_description.description,
                            persons_involved.person,
                            target_date.date,
                            target_budget.budget
                            FROM plans 
                            INNER JOIN objectives ON plans.id = objectives.plan_id
                            INNER JOIN activities ON plans.id = activities.plan_id
                            INNER JOIN brief_description ON plans.id = brief_description.plan_id
                            INNER JOIN persons_involved ON plans.id = persons_involved.plan_id
                            INNER JOIN target_date ON plans.id = target_date.plan_id
                            INNER JOIN target_budget ON plans.id = target_budget.plan_id
                            WHERE user_id = $user_id
                            ; ";

                            $result = mysqli_query($conn, $sql);

                            if(mysqli_num_rows($result) > 0) {
                                $plans = array();

                                while($row = mysqli_fetch_assoc($result))
                                {
                                    if(!isset($plans[$row['plan_id']])) {
                                        $plans[$row['plan_id']] = array(
                                            'organization' => $row['organization'],
                                            'president' => $row['president'],
                                            'secretary' => $row['secretary'],
                                            'year' => $row['year'],
                                            'status' => $row['status'],
                                            'objectives' => array(),
                                            'activities' => array(),
                                            'brief_description' => array(),
                                            'persons_involved' => array(),
                                            'target_date' => array(),
                                            'target_budget' => array()
                                        );
                                    }

                                    if (!in_array($row['objective'], $plans[$row['plan_id']]['objectives'])) {
                                        $plans[$row['plan_id']]['objectives'][] = $row['objective'];
                                    }

                                    if (!in_array($row['activity'], $plans[$row['plan_id']]['activities'])) {
                                        $plans[$row['plan_id']]['activities'][] = $row['activity'];
                                    }

                                    if (!in_array($row['description'], $plans[$row['plan_id']]['brief_description'])) {
                                        $plans[$row['plan_id']]['brief_description'][] = $row['description'];
                                    }

                                    if (!in_array($row['person'], $plans[$row['plan_id']]['persons_involved'])) {
                                        $plans[$row['plan_id']]['persons_involved'][] = $row['person'];
                                    }

                                    if (!in_array($row['date'], $plans[$row['plan_id']]['target_date'])) {
                                        $plans[$row['plan_id']]['target_date'][] = $row['date'];
                                    }

                                    if (!in_array($row['budget'], $plans[$row['plan_id']]['target_budget'])) {
                                        $plans[$row['plan_id']]['target_budget'][] = $row['budget'];
                                    }
                                    // array_push($plans[$row['plan_id']]['target_budget'], $row['budget']);
                                    
                                }

                                foreach ($plans as $plan_id => $plan)
                                {
                        ?>
                                    <tr>
                                        <td> <?php echo $plan_id ?> </td>
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
                                        <td> <?php echo implode("<hr>", $plan['objectives']) ?> </td>
                                        <td> <?php echo implode("<hr>", $plan['activities']) ?> </td>
                                        <td> <?php echo implode("<hr>", $plan['brief_description']) ?> </td>
                                        <td> <?php echo implode("<hr>", $plan['persons_involved']) ?> </td>
                                        <td> <?php echo implode("<hr>", $plan['target_date']) ?> </td>
                                        <td> <?php echo implode("<hr>", $plan['target_budget']) ?> </td>

                                        <td> <a href="./details_renewal.php?details_id='<?php echo $plan_id ?>'" class="btn btn-block btn-outline-warning"> View </a> </td>
                                        <td> <a href="./update_plans.php?update_id='<?php echo $plan_id ?>'" class="btn btn-block btn-outline-info"> Edit </a> </td>
                                        <td> <a href="./delete_plans.php?delete_id='<?php echo $plan_id ?>'" class="delete btn btn-block btn-outline-danger"> Delete </a> </td>
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