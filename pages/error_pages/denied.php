<?php 
    @include '../configurations/config.php';
    session_start();

    if(isset($_POST['submit'])){
        $destination = $_POST['destination'];

        if($destination === "home") {
            header("location: ../index.php");
            die();
        }
        else if($destination === "application-form")
        {
            header("location: ../application.php");
            die();
        }
        else if($destination === "renewal-form")
        {
            header("location: ../renewal.php");
            die();
        }
        else if($destination === "commitment-form")
        {
            header("location: ../commitment.php");
            die();
        }
        else if($destination === "plans-form")
        {
            header("location: ../plans.php");
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
    <!-- custom style -->
    <link rel="stylesheet" href="./css/style.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-danger">403</h2>
            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-danger"></i> Access Denied!</h3>
                <p>
                You do not have the necessary permissions to access this page. Please check your credentials or contact the system administrator for assistance. Meanwhile, you may <a href="../index.php">return to dashboard</a> or try selecting a destination.
                </p>
                <form class="search-form" method="post">
                    <div class="input-group">
                        <select name="destination" id="" class="form-control">
                            <option value="home">Dashboard</option>
                            <option value="application-form">Application Form</option>
                            <option value="renewal-form">Renewal Form</option>
                            <option value="commitment-form">Commitment Form</option>
                            <option value="plans-form">Plan of Activities</option>
                        </select>
                        <div class="input-group-append">
                            <button type="submit" name="submit" class="btn btn-danger"><i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
</html>