<?php
session_start();

if (empty($_SESSION['id_company'])) {
    header("Location: ../index.php");
    exit();
}

require_once("../db.php");

// Check if an ID is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $postId = $_GET['id'];

    // Retrieve the existing job post data
    $postQuery = "SELECT * FROM job_post WHERE id_jobpost = $postId";
    $postResult = $conn->query($postQuery);

    if ($postResult && $postResult->num_rows > 0) {
        $postData = $postResult->fetch_assoc();
    } else {
        // Redirect if the job post with the given ID is not found
        header("Location: my-job-post.php");
        exit();
    }
} else {
    // Redirect if no ID is provided in the URL
    header("Location: my-job-post.php");
    exit();
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
    <script src="../js/tinymce/tinymce.min.js"></script>


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
                    <div class="sidebar-brand ">
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
                        <li class="">
                            <a href="index.php"><i class="ion ion-speedometer "></i><span>Dashboard</span></a>
                        </li>

                        <li class="menu-header">Components</li>
                        <li>
                            <a href="create-job-post.php"><i class="ion note-icon-pencil active"></i><span>Create
                                    Job
                                    Post</span></a>
                        </li>
                        <li class="active">
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
                        <div>Update Job Post</div>
                    </h1>

                    <header>

                        <div class="card card-primary">

                            <div class="card-body">
                                <form method="post" action="update-post.php">
                                    <input type="hidden" name="id_jobpost" value="<?php echo isset($postData['id_jobpost']) ? $postData['id_jobpost'] : ''; ?>">
                                    <div class="form-group col-12">
                                        <label for="jobtitle">Job Title</label>
                                        <input class="form-control" type="text" id="jobtitle" name="jobtitle" placeholder="Job Title" autofocus required="" value="<?php echo isset($postData['jobtitle']) ? $postData['jobtitle'] : ''; ?>">
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="description" class="d-block">Job Description</label>
                                        <?php
                                        // Retrieve and sanitize the description data
                                        $description = isset($postData['description']) ? nl2br(stripslashes($postData['description'])) : '';
                                        ?>
                                        <textarea class="form-control" id="description" name="description" rows="10" required=""><?php echo $description; ?></textarea>
                                    </div>


                                    <div class="form-group col-12">
                                        <label for="responsibility" class="d-block">Responsibility</label>
                                        <?php
                                        // Retrieve and sanitize the responsibility data
                                        $responsibility = isset($postData['responsibility']) ? stripslashes($postData['responsibility']) : '';

                                        // Explode the responsibilities into an array using the delimiter 'rn'
                                        $responsibilitiesArray = explode("rn", $responsibility);

                                        // Implode the responsibilities array back to a string with each responsibility on a new line
                                        $formattedResponsibility = implode("\n", $responsibilitiesArray);
                                        ?>
                                        <textarea class="form-control" id="responsibility" name="responsibility" rows="10" placeholder="Responsibility" required=""><?php echo $formattedResponsibility; ?></textarea>
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="qualification" class="d-block">Qualifications</label>
                                        <?php
                                        // Retrieve and sanitize the qualification data
                                        $qualification = isset($postData['qualification']) ? stripslashes($postData['qualification']) : '';

                                        // Explode the qualifications into an array using the delimiter 'rn'
                                        $qualificationsArray = explode("rn", $qualification);

                                        // Implode the qualifications array back to a string with each qualification on a new line
                                        $formattedQualification = implode("\n", $qualificationsArray);
                                        ?>
                                        <textarea class="form-control" id="qualification" name="qualification" rows="10" placeholder="Qualifications" required=""><?php echo $formattedQualification; ?></textarea>
                                    </div>



                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>Minimum Salary</label>
                                            <input type="number" class="form-control" id="minimumsalary" name="minimumsalary" required="" value="<?php echo isset($postData['minimumsalary']) ? $postData['minimumsalary'] : ''; ?>">
                                        </div>

                                        <div class="form-group col-6">
                                            <label>Maximum Salary</label>
                                            <input type="number" class="form-control" id="maximumsalary" name="maximumsalary" required="" value="<?php echo isset($postData['maximumsalary']) ? $postData['maximumsalary'] : ''; ?>">
                                        </div>

                                        <div class="form-group col-6">
                                            <label>Experiences</label>
                                            <input type="number" class="form-control" id="experience" name="experience" required="" value="<?php echo isset($postData['experience']) ? $postData['experience'] : ''; ?>">
                                        </div>

                                        <div class="form-group col-6">
                                            <label>Address</label>
                                            <input type="text" class="form-control" id="address" name="address" required="" value="<?php echo isset($postData['address']) ? $postData['address'] : ''; ?>">
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Job Nature</label>
                                            <select class="form-control" id="jobnature" name="jobnature" required="">
                                                <option <?php echo ($postData['jobnature'] == 'Full Time') ? 'selected' : ''; ?>>Full Time</option>
                                                <option <?php echo ($postData['jobnature'] == 'Part Time') ? 'selected' : ''; ?>>Part Time</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-6">
                                            <label>Job Categories</label>
                                            <select class="form-control" id="categories" name="categories" required="">
                                                <?php
                                                $sql = "SELECT * FROM job_categories ORDER BY CASE WHEN category_name = 'Others' THEN 1 ELSE 0 END, category_name ASC";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        $selected = ($postData['categories'] == $row['category_name']) ? 'selected' : '';
                                                        echo "<option value='" . $row['category_name'] . "' data-id='" . $row['id'] . "' $selected>" . $row['category_name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-6">
                                            <label>Job Type</label>
                                            <select class="form-control" id="jobtype" name="jobtype" required="">
                                                <option <?php echo ($postData['jobtype'] == 'On-site') ? 'selected' : ''; ?>>On-site</option>
                                                <option <?php echo ($postData['jobtype'] == 'Remote') ? 'selected' : ''; ?>>Remote</option>
                                                <option <?php echo ($postData['jobtype'] == 'Hybrid') ? 'selected' : ''; ?>>Hybrid</option>
                                            </select>
                                        </div>



                                        <div class="form-group col-6 ">
                                            <label>Job Vacancies</label>
                                            <input type="number" class="form-control" id="vaccanices" name="vaccanices" required="" value="<?php echo isset($postData['vaccanices']) ? $postData['vaccanices'] : ''; ?>">
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Closing Date</label>
                                            <input type="date" class="form-control" id="closingdate" name="closingdate" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+10 years')); ?>" required value="<?php echo isset($postData['closingdate']) ? $postData['closingdate'] : ''; ?>">
                                        </div>


                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Update
                                        </button>
                                    </div>
                                </form>
                            </div>
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



</body>

</html>