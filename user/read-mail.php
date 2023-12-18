<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
if (empty($_SESSION['id_user'])) {
    header("Location: ../index.php");
    exit();
}

require_once("../db.php");

$sql = "SELECT * FROM mailbox WHERE id_mailbox='$_GET[id_mail]' AND (id_fromuser='$_SESSION[id_user]' OR id_touser='$_SESSION[id_user]')";
$result = $conn->query($sql);
if ($result->num_rows >  0) {
    $row = $result->fetch_assoc();
    if ($row['fromuser'] == "company") {
        $sql1 = "SELECT * FROM company WHERE id_company='$row[id_fromuser]'";
        $result1 = $conn->query($sql1);
        if ($result1->num_rows >  0) {
            $rowCompany = $result1->fetch_assoc();
        }
        $sql2 = "SELECT * FROM users WHERE id_user='$row[id_touser]'";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows >  0) {
            $rowUser = $result2->fetch_assoc();
        }
    } else {
        $sql1 = "SELECT * FROM company WHERE id_company='$row[id_touser]'";
        $result1 = $conn->query($sql1);
        if ($result1->num_rows >  0) {
            $rowCompany = $result1->fetch_assoc();
        }
        $sql2 = "SELECT * FROM users WHERE id_user='$row[id_fromuser]'";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows >  0) {
            $rowUser = $result2->fetch_assoc();
        }
    }
}

// if (!function_exists('formatGmailTime')) {
//     function formatGmailTime($timestamp)
//     {
//         $now = time();
//         $timeDiff = $now - strtotime($timestamp);

//         if ($timeDiff < 60) {
//             return 'Just now';
//         } elseif ($timeDiff < 3600) {
//             $minutes = floor($timeDiff / 60);
//             return ($minutes > 1) ? $minutes . ' minutes ago' : 'a minute ago';
//         } elseif ($timeDiff < 86400) {
//             $hours = floor($timeDiff / 3600);
//             return ($hours > 1) ? $hours . ' hours ago' : 'an hour ago';
//         } else {
//             return date("M d, Y h:i A", strtotime($timestamp));
//         }
//     }
// }

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
    <style>
        #passwordError {
            display: none;
        }
    </style>
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
                    <il class="mr-3">
                        <a href="../index.php" class="btn btn-success  btn-block ">Home Page</a>
                    </il>
                    <il class="mr-3">
                        <a href="../jobs.php" class="btn btn-danger btn-block ">View Job List</a>
                    </il>
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
                            <div class="d-sm-none d-lg-inline-block">Hi, <?php echo $_SESSION['name']; ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="profile.html" class="dropdown-item has-icon">
                                <i class="ion ion-android-person"></i> Profile
                            </a>
                            <a href="../logout.php" class="dropdown-item has-icon">
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
                            <img alt="image" src="../dist/img/avatar/avatar-4.jpeg">
                        </div>
                        <div class="sidebar-user-details">
                            <div class="user-name"><?php echo $_SESSION['name']; ?></div>
                            <div class="user-role">
                                User
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
                            <a href="my-application.php" c><i class="ion ion-ios-list"></i><span>My Applications</span></a>
                        </li>

                        <li class="active">
                            <a href="inbox-mail.php"><i class="ion ion-ios-email"></i><span>Mail
                                    Box</span></a>
                        </li>
                        <li>
                            <a href="#" class="has-dropdown"><i class="ion ion-ios-settings "></i><span>Settings</span></a>
                            <ul class="menu-dropdown">
                                <li><a href="user-details-upadate.php"><i class="ion ion-ios-circle-outline"></i>User
                                        Details</a>
                                </li>
                                <li><a href="user-account.php"><i class="ion ion-ios-circle-outline"></i>Account
                                        Details</a>
                                </li>

                            </ul>
                        </li>
                        <li>
                            <a href="calender.html"><i class="ion ion-ios-albums-outline"></i><span>Calender</span></a>
                        </li>
                    </ul>

                </aside>
            </div>
            <div class="main-content ">
                <section class="section ">

                    <h1 class="section-header">
                        <div>Mail Box</div>
                    </h1>

                    <div class="section-body ">

                        <!-- <div class="row mt-5"> -->
                        <div class="col-12">

                            <div class="card">

                                <div class="card-body ">
                                    <a href="inbox-mail.php" class="btn btn-primary btn-block mb-3 col-2">Back to
                                        Inbox</a>

                                    <div class="col-md-9">
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h3 class="card-title">Read Mail</h3>

                                                <div class="card-tools">
                                                    <a href="#" class="btn btn-tool" title="Previous"><i class="fas fa-chevron-left"></i></a>
                                                    <a href="#" class="btn btn-tool" title="Next"><i class="fas fa-chevron-right"></i></a>
                                                </div>
                                            </div>

                                            <div class="card-body p-md-4">
                                                <div class="mailbox-read-info">
                                                    <h5> Subject: <?php echo $row['subject']; ?></h5>

                                                    <h6>From: < <?php echo $rowCompany['companyname']; ?>><i class="mdi mdi-chevron-right"></i> to me
                                                            <span class="mailbox-read-time float-right"><?php echo date("d-M-Y h:i a", strtotime($row['createdAt'])); ?></span>
                                                    </h6>
                                                </div>

                                                <div class="mailbox-controls with-border text-center">

                                                    <button type="button" class="btn btn-default btn-sm" data-container="body" title="Reply">
                                                        <i class="fas fa-reply"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-default btn-sm" data-container="body" title="Forward">
                                                        <i class="fas fa-share"></i>
                                                    </button>
                                                </div>

                                            </div>
                                            <div class="mailbox-read-info ml-3">
                                                <h6 class="pb-4">Hi <?php echo $_SESSION['name']; ?></h6>
                                            </div>

                                            <div class="mailbox-read-message ml-3">
                                                <p class=""> <?php echo stripcslashes($row['message']); ?></p>

                                            </div>

                                        </div>



                                        <!-- /.card-footer -->
                                        <div class="card-footer">
                                            <div class="float-right">
                                                <button type="button" class="btn btn-info" id="toggleReplySection"><i class="fas fa-reply"></i> Reply</button>

                                                <a href="delete-mail.php?id_mail=<?php echo $row['id_mailbox']; ?>" class="btn btn-danger" id="deleteMail">
                                                    <i class="far fa-trash-alt"></i> Delete
                                                </a>


                                            </div>
                                            <!-- /.card-footer -->
                                        </div>
                                        <!-- /.card -->
                                    </div>


                                </div>
                                <!-- </div> -->
                            </div>
                            <!-- Reply mail -->
                            <div id="replySection" style="display: none;">
                                <div class="card-body p-md-4 col-md-9">

                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h3 class="card-title">Reply Mail</h3>
                                        </div>

                                        <div class="mailbox-read-message">
                                            <form action="reply-mailbox.php" method="post">
                                                <div class="form-group col-12">
                                                    <textarea class="form-control " id="description" name="description" placeholder="Re-Reply"></textarea>
                                                    <input type="hidden" name="id_mail" value="<?php echo $_GET['id_mail']; ?>">
                                                </div>
                                                <div class="form-group  card-footer">
                                                    <button type="submit" class="btn btn-info"><i class="fas fa-reply"></i> Reply</button>

                                                </div>
                                            </form>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="card-body p-md-4 col-md-9">
                                <div class="card card-primary card-outline">
                                    <?php

                                    $sqlReply = "SELECT * FROM reply_mailbox WHERE id_mailbox='$_GET[id_mail]'";
                                    $resultReply = $conn->query($sqlReply);
                                    if ($resultReply->num_rows > 0) {
                                        while ($rowReply =  $resultReply->fetch_assoc()) {
                                    ?>
                                            <div class="box box-primary">
                                                <div class="box-body no-padding">
                                                    <div class="mailbox-read-info">
                                                        <div class="card-body p-md-4">
                                                            <div class="mailbox-read-info">
                                                                <h5 class="card-title">Reply Message</h5>
                                                                <h6 class="card-title">From: <?php if ($rowReply['usertype'] == "company") {
                                                                                                    echo $rowCompany['companyname'];
                                                                                                } else {
                                                                                                    echo $rowUser['firstname'];
                                                                                                } ?>
                                                                    <span class="mailbox-read-time float-right"><?php echo date("d-M-Y h:i a", strtotime($rowReply['createdAt'])); ?></span>

                                                                    <!-- <span class="mailbox-read-time float-right"><?php //echo formatGmailTime($rowReply['createdAt']); 
                                                                                                                        ?></span> -->
                                                                </h6>
                                                            </div>
                                                            <div class="mailbox-read-message">
                                                                <?php echo stripcslashes($rowReply['message']); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr color="blue">
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
            </div>
        </div>
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


    <script>
        // JavaScript to toggle the visibility of the "Reply Mail" section
        document.getElementById('toggleReplySection').addEventListener('click', function() {
            var replySection = document.getElementById('replySection');
            replySection.style.display = (replySection.style.display === 'none' || replySection.style.display === '') ? 'block' : 'none';
        });
    </script>
</body>

</html>