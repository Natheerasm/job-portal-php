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
                            <div class="d-sm-none d-lg-inline-block">Hi, Google</div>
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
                        <li>
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
                        <li class="active">
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
                        <div>Mail Box</div>
                    </h1>

                    <div class="section-body">

                        <!-- <div class="row mt-5"> -->
                        <div class="col-12">

                            <div class="card">

                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-3">
                                            <a href="create-mail.php" class="btn btn-primary btn-block mb-3">Compose Mail</a>
                                        </div>
                                        <div class="col-3">
                                            <a href="inbox-mail.php" class="btn btn-secondary btn-block mb-3">Inbox</a>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h3 class="card-title">Sent</h3>


                                                <div class="float-right">
                                                    <form>

                                                        <div class="input-group">
                                                            <!-- <input type="text" class="form-control" placeholder="Search Mail"> -->
                                                            <div class="input-group-btn">
                                                                <!-- <button class="btn btn-secondary"><i class="ion ion-search"></i></button> -->
                                                            </div>
                                                        </div>
                                                    </form>


                                                </div>
                                                <!-- /.card-tools -->
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body p-0">
                                                <div class="mailbox-controls">
                                                    <!-- Check all button -->
                                                    <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                                                    </button>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-sm">
                                                            <i class="far fa-trash-alt"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-default btn-sm">
                                                            <i class="fas fa-reply"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-default btn-sm">
                                                            <i class="fas fa-share"></i>
                                                        </button>
                                                    </div>
                                                    <!-- /.btn-group -->
                                                    <button type="button" class="btn btn-default btn-sm">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>

                                                    <!-- /.float-right -->
                                                </div>
                                                <div class="table-responsive mailbox-messages">
                                                    <table id="example1" class="table table-hover table-striped">
                                                        <th></th>
                                                        <th>Sender Name</th>
                                                        <th>Subject</th>
                                                        <th>Date</th>
                                                        <tbody>
                                                            <?php
                                                            $sql = "SELECT m.*, u.firstname, u.lastname 
                                                            FROM mailbox m 
                                                            JOIN users u ON m.id_touser = u.id_user  
                                                            WHERE m.id_fromuser = '$_SESSION[id_company]'
                                                            ORDER BY m.createdAt DESC";
                                                            $result = $conn->query($sql);
                                                            if ($result->num_rows > 0) {
                                                                while ($row = $result->fetch_assoc()) {
                                                            ?>

                                                                    <tr>
                                                                        <td>
                                                                            <div class="icheck-primary">
                                                                                <input type="checkbox" value="" id="check1">
                                                                                <label for="check1"></label>
                                                                            </div>
                                                                        </td>

                                                                        <td class="mailbox-name"><a href="read-mail.php?id_mail=<?php echo $row['id_mailbox']; ?>"><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></a></td>
                                                                        <td class="mailbox-subject"><b><a href="read-mail.php?id_mail=<?php echo $row['id_mailbox']; ?>"><?php echo $row['subject']; ?></b></a></td>
                                                                        <td class="mailbox-date"><?php echo date("d-M-Y h:i a", strtotime($row['createdAt'])); ?></td>
                                                                    </tr>

                                                            <?php
                                                                }
                                                            }
                                                            ?>

                                                        </tbody>
                                                    </table>
                                                    <!-- /.table -->
                                                </div>
                                                <!-- /.mail-box-messages -->
                                            </div>
                                            <!-- /.card-body -->

                                        </div>
                                        <!-- /.card -->
                                    </div>

                                    <nav>
                                        <ul class="pagination">
                                            <li class="page-item disabled">
                                                <span class="page-link">Previous</span>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">1</a>
                                            </li>
                                            <li class="page-item active">
                                                <span class="page-link">
                                                    2
                                                    <span class="sr-only">(current)</span>
                                                </span>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">3</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">Next</a>
                                            </li>
                                        </ul>
                                    </nav>

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

    <!-- jQuery 3 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../js/adminlte.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script>
        $(function() {
            $('#example1').DataTable();
        })
    </script>
</body>

</html>