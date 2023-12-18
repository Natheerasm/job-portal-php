<?php
session_start();
require_once("db.php"); // Assuming this file has your database connection details.

// Function to get the client's IP address
function getRealIpAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

// Log the visitor's IP address
$ipAddress = getRealIpAddress();
$insertQuery = "INSERT INTO visitor_count (ip_address) VALUES ('$ipAddress')";
mysqli_query($conn, $insertQuery);

// Retrieve the total and daily visitor counts
$totalVisitorQuery = "SELECT COUNT(*) AS total FROM visitor_count";
$dailyVisitorQuery = "SELECT COUNT(*) AS today FROM visitor_count WHERE DATE(visit_time) = CURDATE()";

$totalVisitorResult = mysqli_query($conn, $totalVisitorQuery);
$dailyVisitorResult = mysqli_query($conn, $dailyVisitorQuery);

$totalVisitorCount = mysqli_fetch_assoc($totalVisitorResult)['total'];
$dailyVisitorCount = mysqli_fetch_assoc($dailyVisitorResult)['today'];

$totalUsersQuery = "SELECT COUNT(id_user) AS total_users FROM users";
$result = mysqli_query($conn, $totalUsersQuery);
// Check if the query was successful
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalUsers = $row['total_users'];
} else {
    // Handle the case where the query fails
    $totalUsers = "Error fetching total users";
}

// Query to get the total number of companies
$totalCompaniesQuery = "SELECT COUNT(id_company) AS total_companies FROM company";
$result = mysqli_query($conn, $totalCompaniesQuery);

// Check if the query was successful
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalCompanies = $row['total_companies'];
} else {
    // Handle the case where the query fails
    $totalCompanies = "Error fetching total companies";
}
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Mac Lanka</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
        .counter-box {
            display: block;
            background: #EFFDF5;
            padding: 40px 20px 37px;
            text-align: center;
            box-shadow: 0 0 45px rgba(0, 0, 0, .08);

        }

        .counter-box p {
            margin: 5px 0 0;
            padding: 0;
            color: #00B074;
            font-size: 18px;
            font-weight: 500
        }

        .counter-box i {
            font-size: 60px;
            margin: 0 0 15px;
            color: #d2d2d2
        }

        .counter {
            display: block;
            font-size: 32px;
            font-weight: 700;
            color: #666;
            line-height: 28px
        }

        .counter-box.colored {
            background: #00B074;
        }

        .counter-box.colored p,
        .counter-box.colored i,
        .counter-box.colored .counter {
            color: #fff
        }
    </style>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar Start -->
        <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
            <a href="index.php" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
                <h1 class="m-0 text-primary">
                    <span style="font-size: 30px;">Mac Lanka</span>
                    <span style="font-size: 15px;">Job Hub</span>
                </h1>
            </a>

            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="index.php" class="nav-item nav-link active">Home</a>
                    <a href="about.php" class="nav-item nav-link">About</a>
                    <a href="jobs.php" class="nav-item nav-link">Job List</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="category.php" class="dropdown-item">Job Category</a>
                            <a href="testimonial.php" class="dropdown-item">Testimonial</a>
                            <a href="contact.php" class="dropdown-item">Contact</a>
                            <a href="cv.php" class="dropdown-item">CV Generator</a>
                        </div>
                    </div>
                    <?php if (empty($_SESSION['id_user']) && empty($_SESSION['id_company'])) { ?>
                        <div class="nav-item dropdown">
                            <a href="jobs.php" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Register</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="register-user.php" class="dropdown-item">User Register</a>
                                <a href="register-company.php" class="dropdown-item">Company Register</a>
                            </div>
                        </div>

                        <div class="nav-item dropdown">
                            <a href="" class="nav-link dropdown-toggle btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block" data-bs-toggle="dropdown">Login</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="login-user.php" class="dropdown-item">User Login</a>
                                <a href="login-company.php" class="dropdown-item">Company Login</a>
                            </div>
                        </div>

                        <?php } else {

                        if (isset($_SESSION['id_user'])) {
                        ?>
                            <a href="user/index.php" class="btn btn-secondary rounded-0 py-4 px-lg-5 d-none d-lg-block">DashBoard</a>
                        <?php
                        } else if (isset($_SESSION['id_company'])) {
                        ?>
                            <a href="company/index.php" class="btn btn-secondary rounded-0 py-4 px-lg-5 d-none d-lg-block">DashBoard</a>
                        <?php } ?>
                        <a href="logout.php" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block">Logout<i class="fa fa-arrow-right  ms-3"></i></a>
                    <?php } ?>

                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->

    <!-- Carousel Start -->
    <div class="container-fluid p-0">
        <div class="owl-carousel header-carousel position-relative">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/job-1.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(43, 57, 64, .5);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-10 col-lg-8">
                                <h1 class="display-3 text-white animated slideInDown mb-4">Find The Perfect Job That You Deserved</h1>
                                <p class="fs-5 fw-medium text-white mb-4 pb-2">Unlock Your Career Potential with Mac
                                    Lanka Job Hub -Your Gateway to Professional Success!</p>
                                <a href="jobs.php" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Search A Job</a>
                                <a href="jobs.php" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">Find A Talent</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/job-9.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(43, 57, 64, .5);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-10 col-lg-8">
                                <h1 class="display-3 text-white animated slideInDown mb-4">Find The Best Startup Job That Fit You</h1>
                                <p class="fs-5 fw-medium text-white mb-4 pb-2">Embark on a transformative journey towards realizing your professional aspirations with Mac Lanka Job Hub – the ultimate catalyst for career fulfillment. Our platform is dedicated to guiding you towards opportunities that align with your dreams and expertise.</p>
                                <a href="jobs.php" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Search A Job</a>
                                <a href="jobs.php" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">Find A Talent</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->
    <!-- Carousel Start -->
    <!-- <div class="container-fluid p-0">
        <div class="owl-carousel header-carousel position-relative">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/carousel-2.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(43, 57, 64, .5);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-10 col-lg-8">
                                <h1 class="display-3 text-white animated slideInDown mb-4">Find The Perfect Job That
                                    You Deserved</h1>
                                <p class="fs-5 fw-medium text-white mb-4 pb-2">Unlock Your Career Potential with Mac
                                    Lanka Job Hub -Your Gateway to Professional Success!</p>
                                <a href="jobs.php" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Search
                                    A Job</a>
                               
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div> -->



    <!-- Carousel End -->

    <!-- Category Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Explore By Category</h1>
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <a class="cat-item rounded p-4" href="jobs.php">
                        <i class="fa fa-3x fa-wrench text-primary mb-4"></i>
                        <h6 class="mb-3">Software Engineer</h6>
                        <?php
                        $sql = "SELECT * FROM job_post WHERE categories= 'Software Engineer'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $totalno = $result->num_rows;
                        } else {
                            $totalno = 0;
                        }
                        ?>
                        <p class="mb-0"> <?php echo $totalno; ?> Vacancy</p>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <a class="cat-item rounded p-4" href="jobs.php">
                        <i class="fa fa-3x fa-network-wired text-primary mb-4"></i>
                        <?php
                        $sql = "SELECT * FROM job_post WHERE categories= 'Network Engineer'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $totalno = $result->num_rows;
                        } else {
                            $totalno = 0;
                        }
                        ?>
                        <h6 class="mb-3">Network Engineer</h6>
                        <p class="mb-0"> <?php echo $totalno; ?> Vacancy</p>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <a class="cat-item rounded p-4" href="jobs.php">
                        <i class="fa fa-3x fa-mobile-alt text-primary mb-4"></i>
                        <h6 class="mb-3">Mobile App Developer</h6>
                        <?php
                        $sql = "SELECT * FROM job_post WHERE categories= 'Mobile App Developer'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $totalno = $result->num_rows;
                        } else {
                            $totalno = 0;
                        }
                        ?>
                        <p class="mb-0"> <?php echo $totalno; ?> Vacancy</p>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <a class="cat-item rounded p-4" href="jobs.php">
                        <i class="fa fa-3x fa-tasks text-primary mb-4"></i>
                        <h6 class="mb-3">IT Project Manager</h6>
                        <?php
                        $sql = "SELECT * FROM job_post WHERE categories= 'IT Project Manager'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $totalno = $result->num_rows;
                        } else {
                            $totalno = 0;
                        }
                        ?>
                        <p class="mb-0"> <?php echo $totalno; ?> Vacancy</p>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <a class="cat-item rounded p-4" href="jobs.php">
                        <i class="fa fa-3x fa-bug text-primary mb-4"></i>
                        <h6 class="mb-3">QA Tester</h6>
                        <?php
                        $sql = "SELECT * FROM job_post WHERE categories= 'QA Tester'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $totalno = $result->num_rows;
                        } else {
                            $totalno = 0;
                        }
                        ?>
                        <p class="mb-0"> <?php echo $totalno; ?> Vacancy</p>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <a class="cat-item rounded p-4" href="jobs.php">
                        <i class="fa fa-3x fa-laptop-code text-primary mb-4"></i>
                        <h6 class="mb-3">Full Stack Developer</h6>
                        <?php
                        $sql = "SELECT * FROM job_post WHERE categories= 'Full Stack Developer'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $totalno = $result->num_rows;
                        } else {
                            $totalno = 0;
                        }
                        ?>
                        <p class="mb-0"> <?php echo $totalno; ?> Vacancy</p>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <a class="cat-item rounded p-4" href="jobs.php">
                        <i class="fa fa-3x fa-chart-line text-primary mb-4"></i>
                        <h6 class="mb-3">Data Scientist</h6>
                        <?php
                        $sql = "SELECT * FROM job_post WHERE categories= 'Data Scientist'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $totalno = $result->num_rows;
                        } else {
                            $totalno = 0;
                        }
                        ?>
                        <p class="mb-0"> <?php echo $totalno; ?> Vacancy</p>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <a class="cat-item rounded p-4" href="jobs.php">
                        <i class="fa fa-3x fa-drafting-compass text-primary mb-4"></i>
                        <h6 class="mb-3">UI/UX Designer</h6>
                        <?php
                        $sql = "SELECT * FROM job_post WHERE categories= 'UI/UX Designer'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            $totalno = $result->num_rows;
                        } else {
                            $totalno = 0;
                        }
                        ?>
                        <p class="mb-0"> <?php echo $totalno; ?> Vacancy</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Category End -->

    <!-- Jobs Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Job Listing</h1>
            <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.3s">
                <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                    <li class="nav-item">
                        <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill" href="#tab-1">
                            <h6 class="mt-n1 mb-0">Featured</h6>
                        </a>
                    </li>
                </ul>
            </div>
            <?php
            $sql = "SELECT * FROM job_post Order By Rand() Limit 4";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $sql1 = "SELECT * FROM company WHERE id_company='$row[id_company]'";
                    $result1 = $conn->query($sql1);
                    if ($result1->num_rows > 0) {
                        while ($row1 = $result1->fetch_assoc()) {
            ?>
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane fade show p-0 active">
                                    <div class="job-item p-4 mb-4">
                                        <div class="row g-4">
                                            <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                                <img class="flex-shrink-0 img-fluid border rounded" src="./uploads/logo/<?php echo $row1['logo']; ?>" alt="companylogo" style="width: 80px; height: 80px;">
                                                <div class="text-start ps-4">
                                                    <h5 class="mb-3"><a href="view-job-post.php?id=<?php echo $row['id_jobpost']; ?>">
                                                            <?php echo $row['jobtitle']; ?>
                                                        </a> </h5>
                                                    <span class="text-truncate me-3"><i class="fa fa-home text-primary me-2"></i>
                                                        <?php echo $row1['companyname']; ?>
                                                    </span>
                                                    <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i> <?php echo $row1['city']; ?> </span>
                                                    <span class="text-truncate me-3"><i class="bi bi-briefcase-fill text-primary me-2"></i>
                                                        <?php echo $row['jobtype']; ?>
                                                    </span>
                                                    <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>$
                                                        <?php echo $row['maximumsalary']; ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                                                <?php
                                                if (isset($_SESSION["id_user"]) && empty($_SESSION['companyLogged'])) {
                                                ?>
                                                    <div class="d-flex mb-3">
                                                        <a class="btn btn-primary" href="">Apply Now</a>
                                                    </div>
                                                <?php
                                                } else {
                                                ?>
                                                    <div class="d-flex mb-3">
                                                        <a class="btn btn-primary" href=""><i class="fas fa-sign-in-alt"></i></a>
                                                    </div>
                                                <?php
                                                }
                                                ?>

                                                <small class="text-truncate"><i class="far fa-calendar-alt text-primary me-2"></i>
                                                    <?php echo $row['closingdate']; ?>

                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

            <?php
                        }
                    }
                }
            } else {

                echo '<div class ="text-center mb-5" >No job posts found.</div>';
            }
            ?>



            <div class="d-flex justify-content-center">
                <a class="btn btn-primary py-3 px-5 " href="jobs.php">Browse More Jobs</a>
            </div>
        </div>
    </div>

    <div class="container">
        <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Visitor Counter</h1>
        <div class="container-xxl py-5">
            <div class="row wow fadeInUp" data-wow-delay="0.5s">
                <!-- Display the counts on the web page -->
                <div class="four col-md-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="counter-box colored">
                        <i class="fa fa-user text-white mb-4"></i>
                        <span class="counter" id="daily"><?php echo $dailyVisitorCount; ?></span>
                        <p>Daily Visitor</p>
                    </div>
                </div>
                <div class="four col-md-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="counter-box">
                        <i class="fa fa-users text-primary mb-4"></i>
                        <span class="counter" id="total"><?php echo $totalVisitorCount; ?></span>
                        <p>Total Visitor</p>
                    </div>
                </div>


                <div class="four col-md-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="counter-box">
                        <i class="fa fa-user-plus text-primary mb-4"></i>
                        <span class="counter" id="totalUsers">
                            <?php
                            echo $totalUsers;
                            ?>
                        </span>
                        <p>Total Users</p>
                    </div>
                </div>

                <div class="four col-md-3 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="counter-box">
                        <i class="fa fa-building text-primary mb-4"></i>
                        <span class="counter" id="totalCompany">
                            <?php
                            echo $totalCompanies;
                            ?>
                        </span>
                        <p>Total Companies</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>






    <!-- Testimonial Start -->
    <?php
    function displayRandomTestimonial($conn)
    {
        $query = "SELECT `id`, `name`, `email`, `profession`, `image`, `feedback`, `submission_date` FROM `feedback` ORDER BY RAND() LIMIT 1";
        $result = $conn->query($query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
    ?>
            <div class="testimonial-item bg-light rounded p-4">
                <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                <p><?php echo $row['feedback']; ?></p>
                <div class="d-flex align-items-center">
                    <?php
                    if (!empty($row['image'])) {
                        $imageUrl = "uploads/feedback/" . $row['image'];
                    ?>
                        <img class="img-fluid flex-shrink-0 rounded" src="<?php echo $imageUrl; ?>" style="width: 50px; height: 50px;">
                    <?php } else { ?>
                        <img class="img-fluid flex-shrink-0 rounded" src="img/testimonial-1.jpg" style="width: 50px; height: 50px;">
                    <?php } ?>
                    <div class="ps-3">
                        <h5 class="mb-1"><?php echo $row['name']; ?></h5>
                        <small><?php echo $row['profession']; ?></small>
                    </div>
                </div>
            </div>
    <?php
        } else {
            echo '<p>No feedback available.</p>';
        }
    }

    ?>

    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <h1 class="text-center mb-5">Our Clients Say!!!</h1>
            <div class="owl-carousel testimonial-carousel">
                <?php displayRandomTestimonial($conn); ?>
                <?php displayRandomTestimonial($conn); ?>
                <?php displayRandomTestimonial($conn); ?>
                <?php displayRandomTestimonial($conn); ?>
            </div>
        </div>
    </div>

    <!-- Testimonial End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Company</h5>
                    <a class="btn btn-link text-white-50" href="">About Us</a>
                    <a class="btn btn-link text-white-50" href="">Contact Us</a>
                    <a class="btn btn-link text-white-50" href="">Our Services</a>
                    <a class="btn btn-link text-white-50" href="">Privacy Policy</a>
                    <a class="btn btn-link text-white-50" href="">Terms & Condition</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Quick Links</h5>
                    <a class="btn btn-link text-white-50" href="">About Us</a>
                    <a class="btn btn-link text-white-50" href="">Contact Us</a>
                    <a class="btn btn-link text-white-50" href="">Our Services</a>
                    <a class="btn btn-link text-white-50" href="">Privacy Policy</a>
                    <a class="btn btn-link text-white-50" href="">Terms & Condition</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Contact</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, Eravur, Sri lanka</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+94 769424096</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@maclanka.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Newsletter</h5>
                    <p>Unlock your career potential.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">

                        <strong>Copyright &copy;2023 <a href="jonsnow.netai.net">Mac Lanka</a>.</strong> All
                        rights
                        reserved.

                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a class="border-bottom" href="https://github.com/Natheerasm">Natheer asm</a>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="">Home</a>
                            <a href="">Cookies</a>
                            <a href="">Help</a>
                            <a href="">FQAs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>
        $(document).ready(function() {

            $('.counter').each(function() {
                $(this).prop('Counter', 0).animate({
                    Counter: $(this).text()
                }, {
                    duration: 4000,
                    easing: 'swing',
                    step: function(now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            });

        });
    </script>

    <script>
        fetch('https://api64.ipify.org?format=json')
            .then(response => response.json())
            .then(data => {
                const clientIP = data.ip;

                console.log(clientIP);
                // Send clientIP to your server using AJAX or other means
            })
            .catch(error => console.error('Error fetching IP:', error));
    </script>


</body>

</html>