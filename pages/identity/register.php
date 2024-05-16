<?php

@include '../../configurations/config.php';

session_start();

$nameError = "";
$passError = "";
$cPassError = "";
$orgError = "";
if(isset($_POST['submit'])){ //checks if input with type of submit is inside a form with method of post (if submit input is clicked, then condition will be true)

  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']); //real_esape is used to escape any special characters
  $pass = mysqli_real_escape_string($conn, $_POST['password']);
  $cpass = mysqli_real_escape_string($conn, $_POST['cpassword']);
  $organization = $_POST['organization'];
  $user_type = $_POST['user_type'];
  $birthday = $_POST['birthday'];
  $course = $_POST['course'];

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
  move_uploaded_file($tmpName, '../profile_images/'.$newImageName);

    if(strlen($pass) < 6)
    {
      $passError = "Password must be 6 characters and above.";
    }

    $name = htmlspecialchars($name);
    $email = htmlspecialchars($email);
    $pass = htmlspecialchars($pass);
    $cpass = htmlspecialchars($cpass);

    $select = " SELECT * FROM user_tbl WHERE name = '$name' AND email = '$email' AND organization = '$organization'; ";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0)
    {
      $nameError = "Account with the same identity already exist in the same organization.";
    }
    else
    {
      if($pass != $cpass){
        $cPassError = "Password not matched!";
      }else{
        $insert = "INSERT INTO user_tbl(name, email, password, user_type, organization, birthday, image, course) 
        VALUES('$name','$email','$pass','$user_type', '$organization', '$birthday', '$newImageName', '$course')";
        mysqli_query($conn, $insert);

        header('location:login.php');
        die();
      }
    }
};

?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SOU Management System | Register</title>

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

  <style>
    .register-page {
      background-image: linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.9)), url('../../images/lspu_bg.png');
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
    }
  </style>
</head>

<body class="hold-transition register-page">
  <?php
    if(isset($error)){
        foreach($error as $error){
          echo '<span class="error-msg">'.$error.'</span>';
        };
    };
  ?>


  <!-- /.register-box -->
  <div class="register-box">
    <div class="register-logo">
      <a href="../../index2.html"><b>SOU</b> | LSPU</a>
    </div>

    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Register a new account</p>

        <form action="" method="post" enctype="multipart/form-data">

          <div class="input-group mb-3" id="name-error">
              <span style="color: red; font-size: 12px;"><?php echo $nameError ?></span>
          </div>

          <div class="input-group mb-3">
            <input type="text" name="name" class="form-control" placeholder="Username" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text" id="eye-icon">
                <span class="fas fa-eye" style="cursor: pointer"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3" id="pass-error">
            <span style="color: red; font-size: 12px;"><?php echo $passError ?></span>
          </div>

          <div class="input-group mb-3">
            <input type="password" name="cpassword" id="c-password" class="form-control" placeholder="Confirm password" required>
            <div class="input-group-append">
              <div class="input-group-text" id="c-eye-icon">
                <span class="fas fa-eye" style="cursor: pointer"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3" id="c-pass-error">
            <span style="color: red; font-size: 12px;"><?php echo $cPassError ?></span>
          </div>


          <div class="input-group mb-3">
            <input type="text" name="course" id="course" class="form-control" value="BS Information Technology" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-school"></span>
              </div>
            </div>
          </div>


          <div class="input-group mb-3">
            <?php 
            $sql = "SELECT id, name FROM organizations";
            $result = mysqli_query($conn, $sql);   
            ?>
            <select name="organization" class="custom-select" id="organizations">
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



          <div class="input-group mb-3">
            <label for="dates">Birth Date</label>
            <div class="input-group">
              <input type="date" name="birthday" class="form-control" id="dates">
            </div>
          </div>



          <div class="input-group mb-3">
              <label for="exampleInputFile">Profile Picture</label>
              <div class="input-group">
                  <div class="custom-file">
                      <input type="file" class="custom-file-input" id="exampleInputFile" name="image" accept=".jpg, .jpeg, .png">
                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                  </div>
              </div>
          </div>



          <div class="input-group mb-3">
            <select name="user_type" hidden>
              <option value="user" selected>user</option>
              <option value="admin">admin</option>
              <option value="super_admin">super admin</option>
            </select>
          </div>

          <div class="row">
            <!-- /.col -->
            <div class="col-12">
              <button type="submit" name="submit" class="btn btn-primary btn-block">Register</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <a href="login.php" class="text-center">I already have an account</a>
      </div>
      <!-- /.form-box -->
    </div>
  </div>
  <!-- /.register-box -->

  <!-- jQuery -->
  <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- daterangepicker -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/2.7.0/browser/overlayscrollbars.browser.es6.min.js"></script>
  <!-- AdminLTE App -->
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
  <!-- custom js -->
  <script src="../js/app.min.js"></script>
  <script src="../js/graphs.js"></script>
  <script src="../js/customize.js"></script>
  <script>
    let nameError = document.getElementById("name-error");
    setTimeout(() => {
      nameError.style.display = 'none';
    }, 6000);

    let emailError = document.getElementById("email-error");
    setTimeout(() => {
      emailError.style.display = 'none';
    }, 6000);

    let passError = document.getElementById("pass-error");
    setTimeout(() => {
      passError.style.display = 'none';
    }, 6000);

    let cPassError = document.getElementById("c-pass-error");
    setTimeout(() => {
      cPassError.style.display = 'none';
    }, 6000);


    // <!-- show password -->
    let eyeIcon = document.getElementById('eye-icon');
    let password = document.getElementById('password');

    let cEyeIcon = document.getElementById('c-eye-icon');
    let cPassword = document.getElementById('c-password');

    eyeIcon.addEventListener('click', function(){
        if(password.type === 'password'){
            password.type = 'text';
        }else {
            password.type = 'password';
        }
    })

    cEyeIcon.addEventListener('click', function(){
        if(cPassword.type === 'password'){
            cPassword.type = 'text';
        }else {
            cPassword.type = 'password';
        }
    })
  </script>
</body>
</html>
