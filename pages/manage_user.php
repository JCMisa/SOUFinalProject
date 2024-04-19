<?php 
@include '../configurations/config.php';
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $name = htmlspecialchars($name);

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $email = htmlspecialchars($email);

    $pass = mysqli_real_escape_string($conn, $_POST['password']);
    $pass = htmlspecialchars($pass);

    $cpass = mysqli_real_escape_string($conn, $_POST['cpassword']);
    $cpass = htmlspecialchars($cpass);

    $organization = $_POST['organization'];
    $user_type = $_POST['user_type'];

    $fileName = $_FILES["image"]["name"];
    $fileSize = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];

    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $fileName);
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
    move_uploaded_file($tmpName, './profile_images/'.$newImageName);



    $select = " SELECT * FROM user_tbl WHERE email = '$email' && password = '$pass' ";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0){

      $error[] = 'user already exist!';
    }else{

        if($pass != $cpass){
            $error[] = 'password not matched!';
        }else{
            $insert = "INSERT INTO user_tbl(name, email, password, user_type, image) VALUES('$name','$email','$pass','$user_type', '$newImageName')";
            mysqli_query($conn, $insert);

            $user_id = mysqli_insert_id($conn);

            foreach ($organization as $org) {
                $org = mysqli_real_escape_string($conn, $org);
                $sql = " INSERT INTO organization_tbl (user_id, organization) VALUES ('$user_id', '$org'); ";
                $result = mysqli_query($conn, $sql);
            }

            header('location:./manage_user.php');
            die();
        }
    }
};

if(isset($_SESSION['user_type']) && isset($_SESSION['user_name']) && isset($_SESSION['image'])){
  $user_type = $_SESSION['user_type'];
  $user_name = $_SESSION['user_name'];
  $user_image = $_SESSION['image'];
}

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'super_admin') {
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
                            
                            <h1 class="m-0">Manage Account</h1>
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
            
            <!-- form -->
            <form action="" method="post" enctype="multipart/form-data">
                <h5 class="m-0">Create Account</h5>
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="sample@email.com">
                </div>
                <div class="form-group password-input">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                    <div class="form-group-append" id="eye-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>
                <div class="form-group password-input">
                    <label for="password">Confirm Password</label>
                    <input type="password" name="cpassword" class="form-control" id="c-password" placeholder="Confirm password">
                    <div class="form-group-append" id="c-eye-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="exampleInputFile">Profile Picture</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile" name="image" accept=".jpg, .jpeg, .png">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Role</label>
                            <select name="user_type" multiple class="custom-select">
                                <option value="user">user</option>
                                <option value="admin">admin</option>
                                <option value="super_admin">super admin</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Organization</label>
                            <?php 
                            $sql = "SELECT id, name FROM organizations";
                            $result = mysqli_query($conn, $sql);   
                            ?>
                            <select name="organization[]" multiple class="custom-select" id="organizations">
                                <option value="none" disabled>--Select Organization--</option>
                                <?php 
                                if($resultCheck = mysqli_num_rows($result)) {
                                while($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <option value="<?php echo $row['name'] ?>"><?php echo $row['name'] ?></option>
                                <?php 
                                }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>




            <!-- table -->
            <div class="card">
            <div class="card-header">
            <h3 class="card-title">Account List</h3>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Organization</th>
                            <th>Profile</th>
                            <th>Role</th>
                            <th>View</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = " SELECT user_tbl.id AS user_id, 
                            user_tbl.name, 
                            user_tbl.email, 
                            user_tbl.password, 
                            user_tbl.user_type,
                            user_tbl.image,
                            organization_tbl.organization
                            FROM user_tbl 
                            INNER JOIN organization_tbl ON user_tbl.id = organization_tbl.user_id
                            ; ";

                            $result = mysqli_query($conn, $sql);
                            


                            if(mysqli_num_rows($result) > 0)
                            {
                                $users = array();
                                while($row = mysqli_fetch_assoc($result))
                                {
                                    if(!isset($users[$row['user_id']])) {
                                        $users[$row['user_id']] = array(
                                            'name' => $row['name'],
                                            'email' => $row['email'],
                                            'password' => $row['password'],
                                            'user_type' => $row['user_type'],
                                            'image' => $row['image'],
                                            'organization_tbl' => array(),
                                        );
                                    }

                                    if (!in_array($row['organization'], $users[$row['user_id']]['organization_tbl'])) {
                                        $users[$row['user_id']]['organization_tbl'][] = $row['organization'];
                                    }
                                }

                                foreach ($users as $user_id => $user)
                                {
                        ?>
                                    <tr>
                                        <td> <?php echo $user['name'] ?> </td>
                                        <td> <?php echo $user['email'] ?> </td>
                                        <td> <?php echo $user['password'] ?> </td>
                                        <td> <?php echo implode("<hr>", $user['organization_tbl']) ?> </td>
                                        <td> <img src="<?php echo './profile_images/'.$user['image'] ?>" alt="profile" width="40px" height="40px" /> </td>
                                        <td> <?php echo $user['user_type'] ?> </td>

                                        <td> <a href="./details_user.php?details_id=<?php echo $user_id ?>" class="btn btn-block btn-outline-warning"> View </a> </td>
                                        <td> <a href="./update_user.php?update_id='<?php echo $user_id ?>'" class="btn btn-block btn-outline-info"> Edit </a> </td>
                                        <td> <a href="./delete_user.php?delete_id='<?php echo $user_id ?>'" class="delete btn btn-block btn-outline-danger"> Delete </a> </td>
                                    </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Organization</th>
                            <th>Profile</th>
                            <th>Role</th>
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
<!-- ./wrapper -->

<!-- jQuery -->
<?php include_once './reusable/jquery.php'; ?>
<script>
    var select = document.getElementById('organizations');
    select.addEventListener('mousedown', function(e) {
        e.preventDefault();
        var select = this;
        var index = Array.from(select.options).findIndex(option => option === e.target);
        select.options[index].selected = !select.options[index].selected;
        return false;
    });
</script>
</body>
</html>