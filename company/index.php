<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
if (empty($_SESSION['id_company'])) {
  header("Location: ../index.php");
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
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="ion ion-ios-bell-outline"></i></a>
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
          </li>
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg">
              <i class="ion ion-android-person d-lg-none"></i>
              <div class="d-sm-none d-lg-inline-block">Hi, <b><?php echo $_SESSION['name']; ?></b></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="profile.php" class="dropdown-item has-icon">
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
            <a href="index.php">Mac Lanka</a>
          </div>
          <div class="sidebar-user">
            <div class="sidebar-user-picture p-2">
              <?php
              $companyId = $_SESSION['id_company'] ?? null;
              $logoQuery = "SELECT `logo` FROM `company` WHERE `id_company` = $companyId";
              $logoResult = $conn->query($logoQuery);

              if ($logoResult && $logoResult->num_rows > 0)
                $logoFilename = $logoResult->fetch_assoc()['logo'];
              echo '<img src="../uploads/logo/' . $logoFilename . '" alt="Company Logo">';

              ?>
            </div>
            <div class="sidebar-user-details">
              <div class="user-name"><?php echo $_SESSION['name']; ?></div>
              <div class="user-role">
                Company Administrator
              </div>
            </div>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="active">
              <a href="index.php"><i class="ion ion-speedometer"></i><span>Dashboard</span></a>
            </li>

            <li class="menu-header">Components</li>
            <li>
              <a href="create-job-post.php"><i class="ion note-icon-pencil"></i><span>Create
                  Job
                  Post</span></a>
            </li>
            <li>
              <a href="my-job-post.php"><i class="ion note-icon-table"></i><span>My Job
                  Post</span></a>
            </li>
            <li>
              <a href="job-application.php"><i class="ion ion-ios-albums-outline"></i><span>Job
                  Application</span></a>
            </li>
            <li>
              <a href="inbox-mail.php"><i class="ion ion-ios-email"></i><span>Mail
                  Box</span></a>
            </li>
            <li>
              <a href="#" class="has-dropdown"><i class="ion ion-ios-settings "></i><span>Settings</span></a>
              <ul class="menu-dropdown">
                <li><a href="company-details-upadate.php"><i class="ion ion-ios-circle-outline"></i>Company Details</a>
                </li>
                <li><a href="owner-details-upadate.php"><i class="ion ion-ios-circle-outline"></i>Owner Details</a>
                </li>

              </ul>
            </li>
            <li>
              <a href="#"><i class="ion ion-ios-albums-outline"></i><span>Calender</span></a>
            </li>
          </ul>

        </aside>
      </div>
      <div class="main-content">
        <section class="section">

          <h1 class="section-header">
            <div>Company Dashboard</div>
          </h1>

          <header>
            <div class="row">
              <div class="col-lg-4 col-md-6 col-12">
                <div class="card card-sm-3">
                  <div class="card-icon bg-primary">
                    <i class="ion ion-ios-list"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>JOB POSTED</h4>
                    </div>
                    <?php
                    $sql = "SELECT * FROM job_post WHERE id_company='$_SESSION[id_company]'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                      $total = $result->num_rows;
                    } else {
                      $total = 0;
                    }

                    ?>
                    <div class="card-body">
                      <?php echo $total; ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 col-12">
                <div class="card card-sm-3">
                  <div class="card-icon bg-danger">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>APPLICATION FOR JOBS</h4>
                    </div>
                    <?php
                    $sql = "SELECT * FROM apply_job_post WHERE id_company='$_SESSION[id_company]'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                      $total = $result->num_rows;
                    } else {
                      $total = 0;
                    }
                    ?>
                    <div class="card-body">
                      <?php echo $total; ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 col-12">
                <div class="card card-sm-3">
                  <div class="card-icon bg-success">
                    <i class="ion ion-person-stalker"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4>REGISTERED CANDIDATES</h4>
                    </div>
                    <?php
                    $sql = "SELECT COUNT(*) as total_count FROM apply_job_post WHERE id_company = '$_SESSION[id_company]'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                      $row = $result->fetch_assoc();
                      $total = $row['total_count'];
                    } else {
                      $total = 0;
                    }
                    ?>
                    <div class="card-body">
                      <?php echo $total; ?>
                    </div>
                  </div>

                </div>
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