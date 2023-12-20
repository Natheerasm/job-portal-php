 <?php

    //To Handle Session Variables on This Page
    session_start();

    if (empty($_SESSION['id_admin'])) {
        header("Location: ../index.php");
        exit();
    }


    //Including Database Connection From db.php file to avoid rewriting in all files
    require_once("../db.php");



    $sql1 = "SELECT * FROM job_post INNER JOIN company ON job_post.id_company=company.id_company WHERE id_jobpost='$_GET[id]'";
    $result1 = $conn->query($sql1);
    if ($result1->num_rows > 0) {
        $row = $result1->fetch_assoc();
    }

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
                         <a href="index.php">Mac Lanka</a>
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
                         <li>
                             <a href="dashboard.php"><i class="ion ion-speedometer"></i><span>Dashboard</span></a>
                         </li>

                         <li class="menu-header">Components</li>
                         <li class="active">
                             <a href="active-jobs.php" class="has-dropdownactive"><i class="ion ion-ios-albums-outline"></i><span>Active
                                     Job</span></a>
                         </li>
                         <li>
                             <a href="#" class="has-dropdown"><i class="ion ion-flag"></i><span>Account
                                     Details</span></a>
                             <ul class="menu-dropdown">
                                 <li><a href="user-details.php"><i class="ion ion-ios-circle-outline"></i> User</a></li>
                                 <li><a href="companies.php"><i class="ion ion-ios-circle-outline"></i>
                                         Company</a></li>

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
                         <div>View Post </div>
                     </h1>

                     <div class="section-body">
                         <!-- <div class="row mt-5"> -->
                         <div class="col-12">
                             <div class="card">

                                 <div class="card-body ">
                                     <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
                                         <div class="container ">
                                             <div class="row gy-5 gx-4 ">
                                                 <div class="col-lg-8">
                                                     <div class="d-flex align-items-center mb-5">
                                                         <img class="flex-shrink-0 img-fluid border rounded" src="../uploads/logo/<?php echo $row['logo']; ?>" alt="companylogo" style="width: 80px; height: 80px;">
                                                         <div class="text-start ps-4 m-4">
                                                             <h3 class="mb-3">Software Engineer
                                                                 <?php echo $row['jobtitle']; ?>
                                                             </h3>
                                                             <span class="text-truncate me-3"><i class="fa fa-building text-primary me-2"></i>Google
                                                                 <?php echo $row['companyname']; ?>
                                                             </span>
                                                             <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>
                                                                 <?php echo $row['city']; ?>,
                                                                 <?php echo $row['state']; ?>
                                                             </span>
                                                             <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i>
                                                                 <?php echo $row['jobtype']; ?>
                                                             </span>
                                                             <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>$
                                                                 <?php echo $row['minimumsalary']; ?> - $
                                                                 <?php echo $row['maximumsalary']; ?>
                                                             </span>
                                                         </div>
                                                     </div>
                                                     <div class="mb-5">

                                                         <h4 class="mb-3">Job description</h4>
                                                         <p>
                                                             <?php echo nl2br(stripcslashes($row['description'])); ?>
                                                         </p>

                                                         <h4 class="mb-3">Responsibility</h4>

                                                         <p>
                                                             <?php echo nl2br(stripcslashes($row['responsibility'])); ?>
                                                         </p>


                                                         <h4 class="mb-3">Qualifications</h4>
                                                         <p>
                                                             <?php echo nl2br(stripcslashes($row['qualification'])); ?>
                                                         </p>


                                                     </div>
                                                 </div>

                                                 <div class="col-lg-4">
                                                     <div class=" rounded p-5 mb-4 wow slideInUp" style="background-color :#EFFDF5;" data-wow-delay="0.1s">
                                                         <h4 class="mb-4">Job Summery</h4>
                                                         <p><i class="fa fa-angle-right text-primary me-2"></i> Published
                                                             On:
                                                             <?php echo date("d-M-Y", strtotime($row['createdat'])); ?>
                                                         </p>
                                                         <p><i class="fa fa-angle-right text-primary me-2"></i> Vacancy:
                                                             <?php echo $row['vaccanices']; ?> Position
                                                         </p>
                                                         <p><i class="fa fa-angle-right text-primary me-2"></i> Job Type:
                                                             
                                                             <?php echo $row['jobtype']; ?>
                                                         </p>
                                                         <p><i class="fa fa-angle-right text-primary me-2"></i> Job
                                                             Nature:
                                                             <?php echo $row['jobnature']; ?>
                                                         </p>
                                                         <p><i class="fa fa-angle-right text-primary me-2"></i> Salary: $
                                                             <?php echo $row['minimumsalary']; ?> - $
                                                             <?php echo $row['maximumsalary']; ?>
                                                         </p>
                                                         <p><i class="fa fa-angle-right text-primary me-2"></i> Location:
                                                             <?php echo $row['city']; ?>,
                                                             <?php echo $row['state']; ?>
                                                         </p>
                                                         <p class="m-0"><i class="fa fa-angle-right text-primary me-2"></i> Date
                                                             Line:
                                                             <?php echo date("d-M-Y", strtotime($row['closingdate'])); ?>
                                                         </p>
                                                     </div>
                                                     <div class=" rounded p-5 wow slideInUp" data-wow-delay="0.1s" style="background-color :#EFFDF5;">
                                                         <h4 class="mb-4">Company Detail</h4>
                                                         <h6 class="mb-4"> 
                                                             <?php echo $row['companyname']; ?>
                                                         </h6>
                                                         <p class="m-0">
                                                             <?php echo $row['aboutme']; ?>
                                                         </p>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>

                     </div>
                     <!-- </div> -->
             </div>
         </div>
     </div>
     </section>

     </div>
     <footer class="main-footer">
         <div class="footer-left">
             Copyright &copy; 2023 <div class="bullet"></div> Design By <a href="https://multinity.com/">Natheer
                 As</a>
         </div>
         <div class="footer-right"></div>
     </footer>
     </div>
     </div>
     <script>
         $(function() {
             $('#example2').DataTable({
                 'paging': true,
                 'lengthChange': false,
                 'searching': false,
                 'ordering': true,
                 'info': true,
                 'autoWidth': false
             });
         });
     </script>
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