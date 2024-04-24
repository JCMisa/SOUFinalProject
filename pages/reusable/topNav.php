<?php
@include '../configurations/config.php';

if(isset($_POST["search"]))
{
  $keyword = $_POST['keyword'];

  if(
    stripos($keyword, 'Application') !== false ||
    stripos($keyword, 'App') !== false
    )
  {
    header('location: ./application.php');
    die();
  }
  else if(
    stripos($keyword, 'Renewal') !== false ||
    stripos($keyword, 'Ren') !== false
    )
  {
    header('location: ./renewal.php');
    die();
  }
  else if(
    stripos($keyword, 'Commitment') !== false ||
    stripos($keyword, 'Com') !== false
    )
  {
    header('location: ./commitment.php');
    die();
  }
  else if(
    stripos($keyword, 'Plan') !== false ||
    stripos($keyword, 'Act') !== false
    )
  {
    header('location: ./plans.php');
    die();
  }
  else
  {
    header('location: ./error_pages/error.php');
    die();
  }
}

if(isset($_POST['change_account'])){
  $id = mysqli_real_escape_string($conn, $_POST['id']);
  $id = htmlspecialchars($id);

  $query = "SELECT * FROM user_tbl WHERE id = '$id'";
  $result = mysqli_query($conn, $query);

  if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_array($result);

    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_name'] = $row['name'];
    $_SESSION['user_email'] = $row['email'];
    $_SESSION['user_type'] = $row['user_type'];
    $_SESSION['image'] = $row['image'];
    $_SESSION['organization'] = $row['organization'];
    $_SESSION['birthday'] = $row['birthday'];

    header('location:./index.php');
    die();
  }else{
    $loginError = "Account does not exist!";
  }
};

?>



<!-- Top Navbar -->
  <nav id="top" class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="./index.php" class="nav-link">Home</a>
      </li>
      <?php
      if($user_type === 'super_admin')
      {
        echo <<<MANAGE
          <li class="nav-item d-none d-sm-inline-block">
            <a href="./manage_user.php" class="nav-link">Accounts</a>
          </li>
        MANAGE;
      }
      ?>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="./identity/logout.php" class="nav-link">Logout</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- change account -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa-solid fa-angle-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <?php 
              $query1 = " SELECT * FROM user_tbl WHERE id = $user_id; ";
              $result1 = mysqli_query($conn, $query1);
              $row = mysqli_fetch_array($result1);
              $user_email = $row['email'];

              $query2 = " SELECT * FROM user_tbl WHERE email = '$user_email'; ";
              $result2 = mysqli_query($conn, $query2);

                $result_count = mysqli_num_rows($result2);

                if($result_count > 0)
                {
                  while($row = mysqli_fetch_assoc($result2))
                  {
            ?>
                    <form action="" method="post">
                      <input type="number" hidden name="id" value="<?php echo $row['id']; ?>">

                      <a href="#" class="dropdown-item">
                        <div class="media">
                          <img src="profile_images/<?php echo $row['image']; ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle" style="width: 30px; height: 30px;">
                          <div class="media-body">
                            <h3 class="dropdown-item-title">
                              <?php echo $row['name']; ?>
                              <button type="submit" name="change_account" class="btn float-right text-sm text-success"><i class="fa-solid fa-right-to-bracket"></i></button>
                            </h3>
                            <p class="text-sm"><?php echo $row['email']; ?></p>
                            <p class="text-sm text-muted"><i class="fa-solid fa-school"></i> <?php echo $row['organization']; ?> </p>
                          </div>
                        </div>
                      </a>
                      <div class="dropdown-divider"></div>
                    </form>
            <?php 
            }
          }
      ?>
      </div>
      </li>

      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline" method="post">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" name="keyword" placeholder="Search" id="search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit" name="search">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Notifications Dropdown Menu -->
      
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>