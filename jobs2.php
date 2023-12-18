<?php
session_start();
require_once("db.php");

// Fetch categories for the dropdown
$categoryQuery = "SELECT `id`, `category_name` FROM `job_categories`";
$categoryResult = $conn->query($categoryQuery);

// Handle search parameters
if (isset($_GET['search'])) {
    $category = isset($_GET['category']) ? $_GET['category'] : "";
    $jobNature = isset($_GET['job_nature']) ? $_GET['job_nature'] : "";
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";

    // Base SQL query without any filters
    $sql = "SELECT jp.*, c.companyname, c.logo, c.city 
            FROM job_post jp
            JOIN company c ON jp.id_company = c.id_company
            WHERE 1=1";

    // Add filters based on user input
    if (!empty($category)) {
        $sql .= " AND jp.categories = '$category'";
    }

    if (!empty($jobNature)) {
        $sql .= " AND jp.jobnature = '$jobNature'";
    }

    if (!empty($keyword)) {
        $sql .= " AND (jp.jobtitle LIKE '%$keyword%' OR jp.description LIKE '%$keyword%')";
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
    <!-- Include your head content here (e.g., meta tags, stylesheets) -->
    <title>Job Listing</title>
</head>

<body>

    <?php include 'header.php'; ?>

    <!-- Jobs Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Job Listing</h1>

            <!-- Search filter Start -->
            <form method="GET" action="" class="container-fluid bg-primary mb-5 wow fadeIn" data-wow-delay="0.1s"
                style="padding: 35px; margin-top:20px;">
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
                                    <!-- Keyword input -->
                                    <input type="text" name="keyword" class="form-control border-0"
                                        placeholder="Keyword" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <!-- Search button -->
                            <button type="submit" name="search" class="btn btn-dark border-0 w-100"
                                aria-label="Search">Search</button>
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
                                            <img class="flex-shrink-0 img-fluid border rounded"
                                                src="./uploads/logo/<?php echo $row['logo']; ?>" alt="companylogo"
                                                style="width: 80px; height: 80px;">
                                            <div class="text-start ps-4">
                                                <h5 class="mb-3"><a
                                                        href="view-job-post.php?id=<?php echo $row['id_jobpost']; ?>">
                                                        <?php echo $row['jobtitle']; ?>
                                                    </a> </h5>
                                                <span class="text-truncate me-3"><i
                                                        class="fa fa-home text-primary me-2"></i>
                                                    <?php echo $row['companyname']; ?>
                                                </span>
                                                <span class="text-truncate me-3"><i
                                                        class="fa fa-map-marker-alt text-primary me-2"></i>
                                                    <?php echo $row['city']; ?> </span>
                                                <span class="text-truncate me-3"><i
                                                        class="bi bi-briefcase-fill text-primary me-2"></i>
                                                    <?php echo $row['jobtype']; ?>
                                                </span>
                                                <span class="text-truncate me-0"><i
                                                        class="far fa-money-bill-alt text-primary me-2"></i>$
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
                                                    <a class="btn btn-primary" href="">Apply Now</a>
                                                </div>
                                            <?php
                                        } else {
                                            ?>
                                                <!-- Sign In button for companies -->
                                                <div class="d-flex mb-3">
                                                    <a class="btn btn-primary" href=""><i
                                                            class="fas fa-sign-in-alt"></i></a>
                                                </div>
                                            <?php
                                        }
                                        ?>
                                            <!-- Closing Date -->
                                            <small class="text-truncate"><i
                                                    class="far fa-calendar-alt text-primary me-2"></i>
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
