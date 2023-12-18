<?php
session_start();
require_once("db.php");

// Fetch categories for the dropdown
//$categoryQuery = "SELECT `id`, `category_name` FROM `job_categories` ORDER BY `category_name` ASC";
$categoryQuery = "SELECT * FROM job_categories ORDER BY CASE WHEN category_name = 'Others' THEN 1 ELSE 0 END, category_name ASC";
$categoryResult = $conn->query($categoryQuery);


// Handle search parameters
if (isset($_POST['search'])) {
    $category = isset($_POST['category']) ? $_POST['category'] : "";
    $jobNature = isset($_POST['job_nature']) ? $_POST['job_nature'] : "";
    $jobType = isset($_POST['job_type']) ? $_POST['job_type'] : "";
    $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";

    // Base SQL query without any filters
    $sql = "SELECT jp.*, c.companyname, c.logo, c.city 
    FROM job_post jp
    JOIN company c ON jp.id_company = c.id_company
    WHERE 1=1";

    if (!empty($category)) {
        $sql .= " AND jp.categories IN (SELECT category_name FROM job_categories WHERE id = $category)";
    }


    if (!empty($jobNature)) {
        $sql .= " AND jp.jobnature = '$jobNature'";
    }

    if (!empty($jobType)) {
        $sql .= " AND jp.jobtype = '$jobType'";
    }

    if (!empty($keyword)) {
        $sql .= " AND (jp.jobtitle LIKE '%$keyword%' OR jp.description OR c.companyname LIKE '%$keyword%')";
    }

    // Finalize the SQL query
    $sql .= " ORDER BY jp.createdat DESC";

    $result = $conn->query($sql);
} else {
    // Default query without filters
    $sql = "SELECT jp.*, c.companyname, c.logo, c.city 
            FROM job_post jp
            JOIN company c ON jp.id_company = c.id_company
            ORDER BY jp.createdat DESC";

    $result = $conn->query($sql);
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
                    <a href="index.php" class="nav-item nav-link ">Home</a>
                    <a href="about.php" class="nav-item nav-link">About</a>
                    <a href="jobs.php " class="nav-item nav-link active">Job List</a>
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


    <!-- Header End -->
    <div class="container-xxl py-5 bg-dark page-header1 mb-5">
        <div class="container my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Job List</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Job List</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Header End -->

    <!-- Jobs Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Job Listing</h1>

            <!-- Search filter Start -->
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="container-fluid bg-primary mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px; margin-top:20px;">
                <div class="container">
                    <div class="row g-2">
                        <div class="col-md-10">
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <!-- Category dropdown -->
                                    <select name="category" class="form-select border-0">
                                        <option selected disabled>Category</option>
                                        <?php
                                        // Display categories in the dropdown
                                        if ($categoryResult->num_rows > 0) {
                                            while ($category = $categoryResult->fetch_assoc()) {
                                                echo '<option value="' . $category['id'] . '">' . $category['category_name'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <!-- Job Nature dropdown -->
                                    <select name="job_nature" class="form-select border-0" placeholder="Job Nature">
                                        <option selected disabled>Job Nature</option>
                                        <option>Full time</option>
                                        <option>Part time</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <!-- Job Nature dropdown -->
                                    <select name="job_type" class="form-select border-0" placeholder="Job Type">
                                        <option selected disabled>Job Type</option>
                                        <option>On-site</option>
                                        <option>Remote</option>
                                        <option>Hybrid</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <!-- Keyword input -->
                                    <input type="text" name="keyword" class="form-control border-0" placeholder="Keyword" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <!-- Search button -->
                            <button type="submit" name="search" class="btn btn-dark border-0 w-100" aria-label="Search">Search</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Search filter End -->

            <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.3s">

                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <!-- Display job post details -->
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane fade show p-0 active">
                                <div class="job-item p-4 mb-4">
                                    <div class="row g-4">
                                        <div class="col-sm-12 col-md-8 d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid border rounded" src="./uploads/logo/<?php echo $row['logo']; ?>" alt="companylogo" style="width: 80px; height: 80px;">
                                            <div class="text-start ps-4">
                                                <h5 class="mb-3"><a href="view-job-post.php?id=<?php echo $row['id_jobpost']; ?>">
                                                        <?php echo $row['jobtitle']; ?>
                                                    </a> </h5>
                                                <span class="text-truncate me-3"><i class="fa fa-home text-primary me-2"></i>
                                                    <?php echo $row['companyname']; ?>
                                                </span>
                                                <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>
                                                    <?php echo $row['city']; ?> </span>
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
                                                <!-- Apply Now button for users -->
                                                <div class="d-flex mb-3">
                                                    <a class="btn btn-primary" href="view-job-post.php?id=<?php echo $row['id_jobpost']; ?>">Apply Now</a>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <!-- Sign In button for companies -->
                                                <div class="d-flex mb-3">
                                                    <a class="btn btn-primary" href=""><i class="fas fa-sign-in-alt"></i></a>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                            <!-- Closing Date -->
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
                } else {
                    echo "No results found.";
                }
                ?>
            </div>

        </div>
    </div>
    </div>
    </div>
    </div>
    <!-- Jobs End -->

    <?php include 'footer.php'; ?>

</body>

</html>