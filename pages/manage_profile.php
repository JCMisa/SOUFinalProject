<?php 
@include '../configurations/config.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}


$id = $_GET['id'];

$sql = " SELECT * FROM user_tbl WHERE id = $id; ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$name_ac = $row['name'];
$email_ac = $row['email'];
$password_ac = $row['password'];
$user_type_ac = $row['user_type'];
$image_ac = $row['image'];


if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $name = htmlspecialchars($name);

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $email = htmlspecialchars($email);

    $pass = mysqli_real_escape_string($conn, $_POST['password']);
    $pass = htmlspecialchars($pass);

    $user_type = $_POST['user_type'];

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

    $query = " UPDATE user_tbl SET id = $id, name = '$name', email = '$email', password = '$pass', user_type = '$user_type', image = '$update_filename' WHERE id = $id; "; 
    $result = mysqli_query($conn, $query);

    if($result){
        if($_FILES['image']['name'] != '')
        {
            move_uploaded_file($tmpName, './profile_images/'.$newImageName);
            unlink("./profile_images/".$old_image);
        }
        header('location:./manage_profile.php?id='.$id);
        die();
    }else{
        die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
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
                            
                            <h1 class="m-0">Manage Profile</h1>
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

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <select name="user_type" multiple class="custom-select" value="<?php echo $user_type_ac; ?>" hidden>
                                                    <option value="user" <?php if($user_type_ac === "user") echo 'selected'; ?>>user</option>
                                                    <option value="admin" <?php if($user_type_ac === "admin") echo 'selected'; ?>>admin</option>
                                                    <option value="super_admin" <?php if($user_type_ac === "super_admin") echo 'selected'; ?>>super admin</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" name="submit" class="btn btn-block btn-outline-info"> Edit </button>
                                    <?php 
                                    $id = $_GET['id'];
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