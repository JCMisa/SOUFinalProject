<?php 

@include '../configurations/config.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

$query = " SELECT * FROM user_tbl WHERE id = $user_id ";
$result = mysqli_query($conn, $query);
$result_count = mysqli_num_rows($result);
if($result_count > 0){
    $row = mysqli_fetch_assoc($result);

    $organization_ac = $row['organization'];
}

if(isset($_SESSION['user_type']) && isset($_SESSION['user_name']) && isset($_SESSION['image'])){
  $user_type = $_SESSION['user_type'];
  $user_name = $_SESSION['user_name'];
  $user_image = $_SESSION['image'];
}

if(isset($_POST['submit_event'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $name = htmlspecialchars($name);

    $date_start = $_POST['date_start'];
    $date_end = $_POST['date_end'];

    $venue = mysqli_real_escape_string($conn, $_POST['venue']);
    $venue = htmlspecialchars($venue);

    $event_type = $_POST['event_type'];

    $status = $_POST['status'];
    $organization = $_POST['organization'];
    $event_user_id = $user_id;

    $filename = $_FILES['event_file']['name'];
    $destination = '../events_uploads/' . $filename;
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $file = $_FILES['event_file']['tmp_name'];
    $size = $_FILES['event_file']['size'];

    if(!in_array($extension, ['PDF', 'pdf', 'png', 'zip', 'docx'])) {
        echo "You cannot upload files of this type";
    }
    else{
        if(move_uploaded_file($file, $destination)){
            $sql = " INSERT INTO manage_events (name, date_start, date_end, venue, event_type, file, status, organization, user_id) 
            VALUES('$name', '$date_start', '$date_end', '$venue', '$event_type', '$filename', '$status', '$organization', $event_user_id); ";

            if(mysqli_query($conn, $sql)) {
                $_SESSION['status'] = "Event Created Successfully";
                header("Location: ./manage_events.php");
                die();
            }else{
                header("Location: ./error_pages/error.php");
                die();
            }
        }
        else {
            header('Location: ./error_pages/error.php');
            die();
        }
    }
};
?>





<!-- doctype -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SOU Management System</title>
    <?php include_once './reusable/head.php'; ?>

    <style></style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <?php include_once './reusable/preloader.php'; ?>

        <!-- Navbar -->
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

                        <h1 class="m-0">Manage Events</h1>
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
            <form action="" method="post" enctype="multipart/form-data">
                <div class="card-body">

                    <div class="form-group">
                        <label for="name">Activity Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Activity Name" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start">Activity Date/Time Start</label>
                                <input type="datetime-local" name="date_start" class="form-control" id="start" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end">Activity Date/Time End</label>
                                <input type="datetime-local" name="date_end" class="form-control" id="end" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="venue">Activity Venue</label>
                        <input type="text" name="venue" class="form-control" id="venue" placeholder="Activity Venue" required>
                    </div>

                    <div class="form-group">
                        <label for="event_type">Event Type</label>
                        <select name="event_type" class="custom-select" id="event_type">
                            <option value="" disabled selected> --Select Type-- </option>
                            <option value="in_campus"> In-Campus </option>
                            <option value="off_campus"> Off-Campus </option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="status" class="form-control" id="status" placeholder="Current Status" value="pending" hidden>
                    </div>

                    <div class="form-group">
                        <input type="text" name="organization" class="form-control" id="status" value="<?php echo $organization_ac ?>" hidden>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputFile">Upload File</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="event_file" id="event_file">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" name="submit_event" class="btn btn-primary">Submit</button>
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

    <!-- jQuery -->
    <?php include_once './reusable/jquery.php'; ?>
</body>
</html>