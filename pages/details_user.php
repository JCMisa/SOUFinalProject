<?php 
@include '../configurations/config.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}


$id = $_GET['details_id'];

$sql = " SELECT * FROM user_tbl WHERE id = $id; ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$name_ac = $row['name'];
$email_ac = $row['email'];
$password_ac = $row['password'];
$user_type_ac = $row['user_type'];
$organization_ac = $row['organization'];
$birthday_ac = $row['birthday'];
$image_ac = $row['image'];
$course_ac = $row['course'];

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $name = htmlspecialchars($name);

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $email = htmlspecialchars($email);

    $pass = mysqli_real_escape_string($conn, $_POST['password']);
    $pass = htmlspecialchars($pass);

    $user_type = $_POST['user_type'];

    $organization = $_POST['organization'];

    $birthday = $_POST['birthday'];

    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $course = htmlspecialchars($course);

    $new_image = $_FILES['image']['name'];
    $fileSize = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];

    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $new_image);
    $imageExtension = strtolower(end($imageExtension));
    if(!in_array($imageExtension, $validImageExtension))
    {
        echo " <script> alert('Invalid Image Type'); </script> ";
    }
    else if($fileSize > 2000000)
    {
        echo " <script> alert('Image Size is Too Large'); </script> ";
    }

    $newImageName = uniqid('', true) . '.' . $imageExtension;
    $old_image = $image_ac;

    if($new_image != '')
    {
        $update_filename = $newImageName;
    }
    else
    {
        $update_filename = $old_image;
    }

    if(file_exists("profile_images/".$newImageName))
    {
        echo "<script> alert('Image already exists'); </script>";
        header('location: ./manage_user.php');
        die();
    }

    $query = " UPDATE user_tbl SET id = $id, name = '$name', email = '$email', password = '$pass', user_type = '$user_type', organization = '$organization', birthday = '$birthday', image = '$update_filename', course = '$course' WHERE id = $id; "; 
    $result = mysqli_query($conn, $query);

    if($result){
        if($_FILES['image']['name'] != '')
        {
            move_uploaded_file($tmpName, './profile_images/'.$newImageName);
            unlink("./profile_images/".$old_image);
        }
        $_SESSION['status'] = "Profile Updated Successfully";
        header('location:./details_user.php?details_id='. $id);
        die();
    }else{
        die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
}

if(isset($_GET['details_id'])){
    $id = $_GET['details_id'];

    $sql = " SELECT * FROM user_tbl WHERE id = $id; ";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) <= 0)
    {
        $error[] = 'No record with id: '.$id;
    }
    $row = mysqli_fetch_assoc($result);

    $id = $row['id'];
    $name = $row['name'];
    $email = $row['email'];
    $pass = $row['password'];
    $user_role = $row['user_type'];
    $organization = $row['organization'];
    $birthday = $row['birthday'];
    $image = $row['image'];
    $course = $row['course'];
}

if(isset($_SESSION['user_type']) && isset($_SESSION['user_name']) && isset($_SESSION['image'])){
  $user_type = $_SESSION['user_type'];
  $user_name = $_SESSION['user_name'];
  $user_image = $_SESSION['image'];
}

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'super_admin' && $_SESSION['user_type'] != 'admin') {
    // If the user is not an super admin, redirect them to a access denied page
    header('Location: ./error_pages/denied.php');
    die();
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
        .password-input {
            position: relative;
        }

        .form-group-append {
            position: absolute;
            right: 10px;
            top: 70%;
            transform: translateY(-50%);
            cursor: pointer;
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
            <?php
                if(isset($_SESSION['status']))
                {
            ?>
                    <div class="update-notif" style="z-index:100000; font-size:20px; background-color: #4CAF50; padding: 10px 20px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.7); position:fixed; top:5%; right:0; border-radius:5px;">
                        <p style="color: white;"><?php echo $_SESSION['status'] ?></p>
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
                            <?php
                                $locator = ($user_type === 'super_admin') ? "./manage_user.php" : "./manage_members.php"; 
                            ?>
                            <a href="<?php echo $locator ?>" class="button">
                                <div class="button-box">
                                    <span class="button-elem">
                                    <i class="bi bi-arrow-right"></i>
                                    </span>
                                    <span class="button-elem">
                                    <i class="bi bi-arrow-right"></i>
                                    </span>
                                </div>
                            </a>
                            
                            <h1 class="m-0">Account Details</h1>
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
                            <div class="container-fluid mt-5">
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle" src="./profile_images/<?php echo $image_ac ?>" alt="User profile picture" style="height: 100px">
                                        </div>
                                        <h3 class="profile-username text-center"> <?php echo $name_ac ?> </h3>
                                        <p class="text-muted text-center"> <?php echo $user_type_ac ?> </p>
                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>ID</b> <a class="float-right"> <?php echo $id ?> </a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Email</b> <a class="float-right"> <?php echo $email_ac ?> </a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Password</b> <a class="float-right"><?php echo $password_ac ?> </a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Birthday</b> <a class="float-right"><?php echo $birthday_ac ?> </a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Organization</b> <a class="float-right"><?php echo $organization_ac ?> </a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Course</b> <a class="float-right"><?php echo $course_ac ?> </a>
                                            </li>
                                        </ul>
                                        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-7">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?php echo $name_ac; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="sample@email.com" value="<?php echo $email_ac; ?>">
                                    </div>
                                    <div class="form-group password-input">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" value="<?php echo $password_ac; ?>">
                                        <div class="form-group-append" id="eye-icon">
                                            <i class="fas fa-eye"></i>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Profile Picture</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile" name="image" accept=".jpg, .jpeg, .png" value="<?php echo $image_ac; ?>">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                <input hidden type="file" name="image_old" value="<?php echo $image_ac; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="course">Course</label>
                                        <input type="text" name="course" class="form-control" id="course" placeholder="Course" value="<?php echo $course_ac; ?>">
                                    </div>
                                    
                                    <div class="row">
                                        <?php 
                                            $isDisplayed = ($user_type !== 'super_admin') ? "none" : "";
                                        ?>
                                        <div class="col-sm-6" style="display: <?php echo $isDisplayed ?>">
                                            <div class="form-group">
                                                <label>Organization</label>
                                                <?php 
                                                $sql = "SELECT id, name FROM organizations";
                                                $result = mysqli_query($conn, $sql);   
                                                ?>
                                                <select name="organization" class="custom-select" id="organizations" value="<?php echo $organization_ac; ?>">>
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
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="dates">Birth Date</label>
                                                <input type="date" name="birthday" class="form-control" id="dates" value="<?php echo $birthday_ac; ?>">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Role</label>
                                                <select name="user_type" multiple class="custom-select" value="<?php echo $user_type_ac; ?>">>
                                                    <option value="user" <?php if($user_type_ac === "user") echo 'selected'; ?>>user</option>
                                                    <option value="admin" <?php if($user_type_ac === "admin") echo 'selected'; ?>>admin</option>
                                                    <option style="display: <?php echo $isDisplayed ?>" value="super_admin" <?php if($user_type_ac === "super_admin") echo 'selected'; ?>>super admin</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" name="submit" class="btn btn-block btn-outline-info"> Edit </button>
                                    <?php 
                                    $id = $_GET['details_id'];
                                    $sql = " SELECT * FROM user_tbl WHERE id = $id; ";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    ?>
                                    <a href="./delete_user.php?delete_id='<?php echo $row['id'] ?>'" class="delete btn btn-block btn-outline-danger"> Delete </a>
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