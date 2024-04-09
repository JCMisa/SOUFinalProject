<?php 
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

if(isset($_POST['submit']))
{
    $title = $_POST['event_title'];
    $description = $_POST['event_description'];
    $date = $_POST['date'];

    $sql = " INSERT INTO events_tbl(title, description, date) VALUES('$title', '$description', '$date'); ";
    $result = mysqli_query($conn, $sql);
    if(!$result){
        header('location:./error_pages/error.php');
        die();
    }
}
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"> 
            <?php
                $header_display = ($user_type !== "super_admin") ? "University " : "Manage ";
                echo $header_display . "Events";
            ?>
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
    <div class="row">
    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
    <div class="row">
    <div class="col-12 col-sm-4">
    <div class="info-box bg-light">
    <div class="info-box-content">
    <span class="info-box-text text-center text-muted">Estimated students</span>
    <span class="info-box-number text-center text-muted mb-0">2300</span>
    </div>
    </div>
    </div>
    <div class="col-12 col-sm-4">
    <div class="info-box bg-light">
    <div class="info-box-content">
    <span class="info-box-text text-center text-muted">University President</span>
    <span class="info-box-number text-center text-muted mb-0">Mr. Mario Briones</span>
    </div>
    </div>
    </div>
    <div class="col-12 col-sm-4">
    <div class="info-box bg-light">
    <div class="info-box-content">
    <span class="info-box-text text-center text-muted">Number of Courses</span>
    <span class="info-box-number text-center text-muted mb-0">20</span>
    </div>
    </div>
    </div>
    </div>
    <div class="row">
    <div class="col-12">
    <h4>Latest Events</h4>


    <div class="card">
        <div class="card-body">
            <div class="events-body">
                <?php 
                    $isHidden = ($user_type !== "super_admin") ? "d-none" : "";

                    $sql = " SELECT * FROM events_tbl; "; 
                    $result = mysqli_query($conn, $sql);
                    $result_count = mysqli_num_rows($result);

                    if($result_count > 0)
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                ?>
                            <div class="post clearfix">
                                <div class="user-block">
                                    <span class="font-weight-bold text-primary" style="font-size: 20px;"> <?php echo $row['title']; ?> </span>
                                    <span class="description">Date posted: <?php echo $row['date']; ?> </span>
                                </div>

                                <p>
                                    <?php 
                                        echo $row['description'];
                                    ?>
                                </p>
                                <div class="<?php echo $isHidden ?>">
                                    <a href="./update_event.php?update_id='<?php echo $row['id'] ?>'" class="btn btn-block btn-outline-info"> Edit </a>
                                    <a href="./delete_event.php?delete_id='<?php echo $row['id'] ?>'" class="btn btn-block btn-outline-danger"> Delete </a>
                                </div>
                            </div>
                <?php
                        }
                    }
                ?>
            </div>
        </div>
    </div>


    </div>
    </div>
    </div>
    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
    <h3 class="text-primary"><img src="../images/lspuLogo.png" alt="lspuLogo" class="brand-image img-circle elevation-3" width="30px" height="30px"> SOU | LSPU SPCC </h3>
    <p class="text-muted">
        The Student Organization Unit (SOU) at Laguna State Polytechnic University is a collective of student-led organizations that manage various aspects of each college within the university. These organizations play a crucial role in organizing events, managing the flow of information, and fostering a vibrant campus life. They work in coordination with the Office of Student Affairs and Services (OSAS) to ensure a holistic and enriching experience for all students.
    </p>
    <br>
    <div class="text-muted">
    <p class="text-sm">University Name
    <b class="d-block">Laguna State Polytechnic University - San Pablo City Campus</b>
    </p>
    <p class="text-sm">SOU Coordinator
    <b class="d-block">Mr. Al John A. Villareal</b>
    </p>
    </div>
        <h5 class="mt-5 text-muted">Add Event</h5>
        <?php 
            $isDisabled = ($user_type !== "super_admin") ? "disabled" : "";
        ?>
        <form method="post">
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Event Title</label>
                    <input type="text" name="event_title" class="form-control" id="title" placeholder="Enter short title" <?php echo $isDisabled ?>>
                </div>
                <div class="form-group">
                    <label for="pres">Event Description</label>
                    <input type="text" name="event_description" class="form-control" id="pres" placeholder="Enter event description" <?php echo $isDisabled ?>>
                </div>
                <div class="form-group">
                    <input type="text" name="date" value="<?php echo date("F d, Y"); ?>" class="form-control" id="date" hidden <?php echo $isDisabled ?>>
                </div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary" <?php echo $isDisabled ?>>Submit</button>
        </form>
    </div>
    </div>
    </div>
</div>
