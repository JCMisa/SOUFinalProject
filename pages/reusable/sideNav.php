<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="../images/lspuLogo.png" alt="lspuLogo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SOU - LSPU SPCC</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->

          <li class="nav-header">MAIN</li>
          <!-- dashboard sidebar menu -->
          <li class="nav-item menu-open">
            <a href="./index.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <!-- forms sidebar menu -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Forms
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./application.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Application Form</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="renewal.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Renewal Form</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./commitment.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Commitment Form</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./plans.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Plan of Activities</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- form submissions sidebar menu -->
          <?php 
            if($user_type === 'super_admin')
            {
              echo <<<SUBMISSIONS
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-table"></i>
                    <p>
                      Form Submissions
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./application_submission.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Application</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./renewal_submission.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Renewal</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./commitment_submission.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Commitment</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./plans_submission.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Plans of Activities</p>
                      </a>
                    </li>
                  </ul>
                </li>
              SUBMISSIONS;
            }
          ?>
          <!-- lists sidebar menu -->
          <?php 
            if($user_type === 'super_admin' || $user_type === 'admin')
            {
              echo <<<LIST
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-table"></i>
                    <p>
                      List
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./application_list.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Application List</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./renewal_list.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Renewal List</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./commitment_list.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Commitment List</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="./plans_list.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Plans of Activities List</p>
                      </a>
                    </li>
                  </ul>
                </li>
              LIST;
            }
          ?>
          <!-- manage sidebar menu -->
          <?php
            if($user_type === 'super_admin')
            {
              echo <<<MANAGE
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                      Manage
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="./manage_user.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>User Accounts</p>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a href="./manage_org.php" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Organizations</p>
                      </a>
                    </li>
                  </ul>
                </li>
              MANAGE;
            }
          ?>

          <li class="nav-item">
            <a href="./identity/logout.php" class="nav-link">
              <i class="nav-icon fas fa-arrow-left"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>