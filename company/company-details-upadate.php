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
                            <div class="d-sm-none d-lg-inline-block">Hi, Google</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="profile.php" class="dropdown-item has-icon">
                                <i class="ion ion-android-person"></i> Profile
                            </a>
                            <a href="#" class="dropdown-item has-icon">
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
                        <li>
                            <a href="inbox-mail.php"><i class="ion ion-ios-email"></i><span>Mail
                                    Box</span></a>
                        </li>
                        <li class="active">
                            <a href="#" class="has-dropdown"><i class="ion ion-ios-settings "></i><span>Settings</span></a>
                            <ul class="menu-dropdown">
                                <li><a href="company-details-upadate.php"><i class="ion ion-ios-circle-outline"></i>Company Details</a>
                                </li>
                                <li><a href="owner-details-upadate.php"><i class="ion ion-ios-circle-outline"></i>Owner
                                        Details</a>
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
                        <div>Update Company Profile</div>
                    </h1>

                    <header>

                        <div class="card card-primary">
                            <div class="card-header">
                                <div class="float-right">

                                </div>
                                <h2>Company Profile</h2>
                                <h4>In this section you can change your company details</h4>
                            </div>
                            <div class="card-body">
                                <form action="update-company.php" method="post" enctype="multipart/form-data">
                                    <?php
                                    $sql = "SELECT * FROM company WHERE id_company='$_SESSION[id_company]'";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                    ?>
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label>Company Name</label>
                                                    <input type="text" class="form-control" name="companyname" value="<?php echo $row['companyname']; ?>" required="">
                                                </div>

                                                <div class="form-group col-6">
                                                    <label>Contact Number</label>
                                                    <input type="number" class="form-control" id="contactno" name="contactno" placeholder="Contact Number" onkeypress="return validatePhone(event);" minlength="10" maxlength="10" value="<?php echo $row['contactno']; ?>">
                                                </div>

                                                <div class="form-group col-6">
                                                    <label>Website</label>
                                                    <input type="text" class="form-control" name="website" value="<?php echo $row['website']; ?>" required="">
                                                </div>

                                                <div class="form-group col-6">
                                                    <label>City</label>
                                                    <input type="text" class="form-control" id="city" name="city" onkeypress="return validateName(event);" value="<?php echo $row['city']; ?>" placeholder="city">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>Email address</label>
                                                    <input type="email" class="form-control" id="email" placeholder="Email" value="<?php echo $row['email']; ?>" readonly>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>State</label>
                                                    <input type="text" class="form-control" id="state" onkeypress="return validateName(event);" name="state" placeholder="state" value="<?php echo $row['state']; ?>">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>About Me</label>
                                                    <textarea class="form-control" cols="30" rows="10" name="aboutme"><?php echo $row['aboutme']; ?>></textarea>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>Change Company Logo</label>
                                                    <input type="file" class="form-control" name="image">
                                                    <?php if ($row['logo'] != "") { ?>
                                                        <img src="../uploads/logo/<?php echo $row['logo']; ?>" class="img-responsive" style="max-height: 200px; max-width: 200px;">
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <div class="form-group col-3">
                                                <button type="submit" class="btn btn-success btn-block">
                                                    Update Profile
                                                </button>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </form>
                            </div>
                            <?php if (isset($_SESSION['uploadError'])) { ?>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <?php echo $_SESSION['uploadError']; ?>
                                    </div>
                                </div>
                            <?php unset($_SESSION['uploadError']);
                            } ?>
                        </div>

                    </header>
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

    <script src="https://cdn.tiny.cloud/1/g1ghxcom1f5rqhwbqhluuj2kgbkjqttljddopqkqghiw6n87/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../js/adminlte.min.js"></script>
    <script type="text/javascript">
        function validatePhone(event) {

            //event.keycode will return unicode for characters and numbers like a, b, c, 5 etc.
            //event.which will return key for mouse events and other events like ctrl alt etc. 
            var key = window.event ? event.keyCode : event.which;

            if (event.keyCode == 8 || event.keyCode == 46 || event.keyCode == 37 || event.keyCode == 39) {
                // 8 means Backspace
                //46 means Delete
                // 37 means left arrow
                // 39 means right arrow
                return true;
            } else if (key < 48 || key > 57) {
                // 48-57 is 0-9 numbers on your keyboard.
                return false;
            } else return true;
        }

        function validateName(event) {

            //event.keycode will return unicode for characters and numbers like a, b, c, 5 etc.
            //event.which will return key for mouse events and other events like ctrl alt etc. 
            var key = window.event ? event.keyCode : event.which;

            if (event.keyCode == 8 || event.keyCode == 127 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 32) {

                return true;
            } else if (key < 65 || key > 90 && key < 97 || key > 122) {
                // 65-90 97-122 is A-Z a-z alphabets on your keyboard.
                return false;
            } else return true;
        }
    </script>




    <script>
        // Get today's date in the format required for the 'min' attribute of the input type date
        const today = new Date().toISOString().split('T')[0];

        // Get the date for 10 years from today
        const tenYearsLater = new Date();
        tenYearsLater.setFullYear(tenYearsLater.getFullYear() + 10);
        const maxDate = tenYearsLater.toISOString().split('T')[0];

        // Set the 'min' and 'max' attributes for the input
        document.getElementById('dateInput').min = today;
        document.getElementById('dateInput').max = maxDate;
    </script>
</body>

</html>