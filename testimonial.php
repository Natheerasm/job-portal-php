<!-- testimonial.php -->

<?php

//To Handle Session Variables on This Page
session_start();


//Including Database Connection From db.php file to avoid rewriting in all files
require_once("db.php");
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
                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="about.php" class="nav-item nav-link ">About</a>
                    <a href="jobs.php" class="nav-item nav-link">Job List</a>
                    <div class="nav-item dropdown ">
                        <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="category.php" class="dropdown-item ">Job Category</a>
                            <a href="testimonial.php" class="dropdown-item active">Testimonial</a>
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
    <div class="container-xxl py-5 bg-dark page-header mb-5">
        <div class="container my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Testimonial</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Testimonial</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Header End -->
    <!-- Testimonial Start -->

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






    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 text-center mt-4">
                <a class="btn btn-primary btn-lg py-3 px-5" href="#" onclick="toggleFeedbackForm()">Add Your Comment & Feedback</a>
            </div>
        </div>
    </div>


    <div class="container mt-4">
        <div class="text-center">
            <?php
            // Display feedback success message if set in session
            if (isset($_SESSION['feedbackSuccess']) && $_SESSION['feedbackSuccess']) {
                echo "<p id='success-message' class='alert alert-success'>Thank you for your feedback!</p>";
                unset($_SESSION['feedbackSuccess']); // Clear the session variable
            }

            // Display upload error message if set in session
            if (isset($_SESSION['uploadError'])) {
                echo "<p id='error-message' class='alert alert-danger'>Error: " . $_SESSION['uploadError'] . "</p>";
                unset($_SESSION['uploadError']); // Clear the session variable
            }
            ?>
        </div>
    </div>


    <!-- Testimonial End -->

    <div id="feedbackForm" class="col-6 mx-auto mt-5" style="display: none;">

        <h4 class="mb-4">Drop Your Feedback</h4>
        <form action="addfeedback.php" method="post" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-12 col-sm-6">
                    <input type="text" class="form-control" placeholder="Your Name" name="name" required>
                </div>
                <div class="col-12 col-sm-6">
                    <input type="email" class="form-control" placeholder="Your Email" name="email" required>
                </div>
                <div class="col-12 col-sm-6">
                    <input type="text" class="form-control" placeholder="Profession" name="profession" required>
                </div>
                <div class="col-12 col-sm-6">
                    <input type="file" class="form-control bg-white" name="image" required>
                </div>
                <div class="col-12">
                    <textarea class="form-control" rows="5" placeholder="Feedback" name="feedback" required></textarea>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">Submit</button>
                </div>
            </div>
        </form>


    </div>


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

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

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
        function toggleFeedbackForm() {
            var feedbackForm = document.getElementById("feedbackForm");
            feedbackForm.style.display = (feedbackForm.style.display === "none") ? "block" : "none";
        }
    </script>



</body>

</html>