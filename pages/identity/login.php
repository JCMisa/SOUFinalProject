<?php

@include '../../configurations/config.php';

session_start();

$loginError = "";
if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $name = htmlspecialchars($name);

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $email = htmlspecialchars($email);

   $pass = mysqli_real_escape_string($conn, $_POST['password']);
   $pass = htmlspecialchars($pass);

   $select = " SELECT * FROM user_tbl WHERE name = '$name' && email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

      $_SESSION['user_id'] = $row['id'];
      $_SESSION['user_name'] = $row['name'];
      $_SESSION['user_email'] = $row['email'];
      $_SESSION['user_type'] = $row['user_type'];
      $_SESSION['image'] = $row['image'];
      $_SESSION['organization'] = $row['organization'];
      $_SESSION['birthday'] = $row['birthday'];

      header('location:../index.php');
      die();
   }else{
      $loginError = "Account does not exist!";
   }

};
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SOU Management System | Login</title>

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
    .login-page {
      background-image: linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.9)), url('../../images/lspu_bg.png');
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
    }
  </style>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="../../app/index2.html" class="h1"><b>SOU</b> | LSPU</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="" method="post">
          <div class="input-group mb-3" id="login-error">
            <span style="color: red; font-size: 12px;"><?php echo $loginError ?></span>
          </div>

          <div class="input-group mb-3">
            <input type="text" name="name" class="form-control" placeholder="Username" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-id"></span>
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
              <div class="input-group-text" id="eye-icon" style="cursor: pointer">
                <span class="fas fa-eye"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-12">
              <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
          <div class="col-8">
            <a href="register.php" class="text-center">I don't have an account</a>
          </div>
        </form>

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

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
    let loginError = document.getElementById("login-error");
    setTimeout(() => {
      loginError.style.display = 'none';
    }, 6000);

    // <!-- show password -->
    let eyeIcon = document.getElementById('eye-icon');
    let password = document.getElementById('password');

    eyeIcon.addEventListener('click', function(){
        if(password.type === 'password'){
            password.type = 'text';
        }else {
            password.type = 'password';
        }
    })
  </script>
</body>

</html>