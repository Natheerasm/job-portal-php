<?php

session_start();

if (empty($_SESSION['id_admin'])) {
  header("Location: index.php");
  exit();
}

require_once("../db.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" name="viewport">
  <title>Dashboard &mdash; Mac Lanka</title>

  <link rel="stylesheet" href="../dist/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../dist/modules/ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../dist/modules/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css">

  <link rel="stylesheet" href="../dist/modules/summernote/summernote-lite.css">
  <link rel="stylesheet" href="../dist/modules/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="../dist/css/demo.css">
  <link rel="stylesheet" href="../dist/css/style.css">
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="ion ion-navicon-round"></i></a>
            </li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="ion ion-search"></i></a></li>
          </ul>
          <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search">
            <button class="btn" type="submit"><i class="ion ion-search"></i></button>
          </div>
        </form>
        <ul class="navbar-nav navbar-right">
          <!-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="ion ion-ios-bell-outline"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Notifications
                <div class="float-right">
                  <a href="#">View All</a>
                </div>
              </div>
              <div class="dropdown-list-content">
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <img alt="image" src="../dist/img/avatar/avatar-1.jpeg" class="rounded-circle dropdown-item-img">
                  <div class="dropdown-item-desc">
                    <b>Kusnaedi</b> has moved task <b>Fix bug header</b> to <b>Done</b>
                    <div class="time">10 Hours Ago</div>
                  </div>
                </a>

              </div>
            </div>
          </li> -->
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg">
              <i class="ion ion-android-person d-lg-none"></i>
              <div class="d-sm-none d-lg-inline-block">Hi, Admin</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="dashboard.php" class="dropdown-item has-icon">
                <i class="ion ion-android-person"></i> Profile
              </a>
              <a href="logout.php" class="dropdown-item has-icon">
                <i class="ion ion-log-out"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <img src="../dist/img/mac.png" alt="Mono">
            <a href="dashboard.php">Mac Lanka</a>
          </div>
          <div class="sidebar-user">
            <div class="sidebar-user-picture">
              <img alt="image" src="../dist/img/avatar/avatar-1.jpeg">
            </div>
            <div class="sidebar-user-details">
              <div class="user-name">Natheer Asm</div>
              <div class="user-role">
                Administrator
              </div>
            </div>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="active">
              <a href="dashboard.php"><i class="ion ion-speedometer"></i><span>Dashboard</span></a>
            </li>

            <li class="menu-header">Components</li>
            <li>
              <a href="active-jobs.php" class="has-dropdownactive"><i class="ion ion-ios-albums-outline"></i><span>Active
                  Job</span></a>
            </li>
            <li>
              <a href="#" class="has-dropdown"><i class="ion ion-flag"></i><span>Account Details</span></a>
              <ul class="menu-dropdown">
                <li><a href="user-details.php"><i class="ion ion-ios-circle-outline"></i> User</a></li>
                <li><a href="companies.php"><i class="ion ion-ios-circle-outline"></i> Company</a></li>

              </ul>
            </li>
            <li>
              <a href="#" class="has-dropdownactive"><i class="ion ion-ios-albums-outline"></i><span>Calender</span></a>
            </li>
          </ul>

        </aside>
      </div>
      <div class="main-content">
        <section class="section">

          <h1 class="section-header">
            <div>Dashboard</div>
          </h1>

          <header>
            <div class="row">
              <div class="col-lg-4 col-md-6 col-12">
                <a href="companies.php" class="card-link">
                  <div class="card card-sm-3">
                    <div class="card-icon bg-primary">
                      <i class="ion ion-home"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>ACTIVE COMPANY REGISTERED</h4>
                      </div>
                      <?php
                      $sql = "SELECT * FROM company WHERE active='1'";
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        $totalno = $result->num_rows;
                      } else {
                        $totalno = 0;
                      }
                      ?>
                      <div class="card-body">
                        <?php echo $totalno; ?>
                      </div>
                    </div>
                  </div>
                </a>
              </div>

              <div class="col-lg-4 col-md-6 col-12">
                <a href="companies.php" class="card-link">
                  <div class="card card-sm-3">
                    <div class="card-icon bg-danger">
                      <i class="ion ion-ios-paper-outline"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4> PENDING COMPANY APPROVAL</h4>
                      </div>
                      <?php
                      $sql = "SELECT * FROM company WHERE active='2'";
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        $totalno = $result->num_rows;
                      } else {
                        $totalno = 0;
                      }
                      ?>
                      <div class="card-body">
                        <?php echo $totalno; ?>
                      </div>
                    </div>
                  </div>
                </a>
              </div>

              <div class="col-lg-4 col-md-6 col-12">
                <a href="user-details.php" class="card-link">
                  <div class="card card-sm-3">
                    <div class="card-icon bg-success">
                      <i class="ion ion-person-add"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>REGISTERED CANDIDATES</h4>
                      </div>
                      <?php
                      $sql = "SELECT * FROM users WHERE active='1'";
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        $totalno = $result->num_rows;
                      } else {
                        $totalno = 0;
                      }
                      ?>
                      <div class="card-body">
                        <?php echo $totalno; ?>
                      </div>
                    </div>
                  </div>
                </a>
              </div>

            </div>
            <div class="row">
              <div class="col-lg-4 col-md-6 col-12">
                <a href="user-details.php" class="card-link">
                  <div class="card card-sm-3">
                    <div class="card-icon bg-warning">
                      <i class="ion ion-paper-airplane"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>PENDING CANDIDATES CONFIRMATION</h4>
                      </div>
                      <?php
                      $sql = "SELECT * FROM users WHERE active='0'";
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        $totalno = $result->num_rows;
                      } else {
                        $totalno = 0;
                      }
                      ?>
                      <div class="card-body">
                        <?php echo $totalno; ?>
                      </div>
                    </div>
                  </div>
                </a>
              </div>

              <div class="col-lg-4 col-md-6 col-12">
                <a href="active-jobs.php" class="card-link">
                  <div class="card card-sm-3">
                    <div class="card-icon bg-dark">
                      <i class="ion ion-bookmark"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>TOTAL JOB POSTS</h4>
                      </div>
                      <?php
                      $sql = "SELECT * FROM job_post";
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        $totalno = $result->num_rows;
                      } else {
                        $totalno = 0;
                      }
                      ?>
                      <div class="card-body">
                        <?php echo $totalno; ?>
                      </div>
                    </div>
                  </div>
                </a>
              </div>

              <div class="col-lg-4 col-md-6 col-12">
                <a href="active-jobs.php" class="card-link">
                  <div class="card card-sm-3">
                    <div class="card-icon bg-info">
                      <i class="ion ion-android-add"></i>
                    </div>
                    <div class="card-wrap">
                      <div class="card-header">
                        <h4>TOTAL APPLICATIONS</h4>
                      </div>
                      <?php
                      $sql = "SELECT * FROM apply_job_post";
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        $totalno = $result->num_rows;
                      } else {
                        $totalno = 0;
                      }
                      ?>
                      <div class="card-body">
                        <?php echo $totalno; ?>
                      </div>
                    </div>
                  </div>
                </a>
              </div>


            </div>

          </header>
        </section>

      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2023 <div class="bullet"></div> Design By <a href="https://multinity.com/">Natheer As</a>
        </div>
        <div class="footer-right"></div>
      </footer>
    </div>
  </div>

  <script src="../dist/modules/jquery.min.js"></script>
  <script src="../dist/modules/popper.js"></script>
  <script src="../dist/modules/tooltip.js"></script>
  <script src="../dist/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="../dist/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="../dist/modules/scroll-up-bar/dist/scroll-up-bar.min.js"></script>
  <script src="../dist/js/sa-functions.js"></script>

  <script src="../dist/modules/chart.min.js"></script>
  <script src="../dist/modules/summernote/summernote-lite.js"></script>
  <script src="../dist/js/scripts.js"></script>
  <script src="../dist/js/custom.js"></script>
  <script src="../dist/js/demo.js"></script>
</body>

</html>