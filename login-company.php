<?php
session_start();

if (isset($_SESSION['id_user']) || isset($_SESSION['id_company'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>JobEntry - Job Portal Website Template</title>
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



    <style>
        .gradient-custom-2 {
            /* fallback for old browsers */
            background: #00B074;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, #00b074, #00b074, #00b074, #00b074);

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: -webkit-linear-gradient(to right, #00b074, #00b074, #00b074, #00b074);
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
                    <a href="index.php" class="nav-item nav-link ">Home</a>
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

                    <div class="nav-item dropdown">
                        <a href="jobs.php" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Register</a>
                        <div class="dropdown-menu rounded-0 m-0">
                            <a href="register-user.php" class="dropdown-item">User Register</a>
                            <a href="register-company.php" class="dropdown-item">Company Register</a>
                        </div>
                    </div>
                </div>

                <div class="nav-item dropdown">
                    <a href="jobs.php" class="nav-link dropdown-toggle btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block active" data-bs-toggle="dropdown">Login</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="login-user.php" class="dropdown-item">User Login</a>
                        <a href="login-company.php" class="dropdown-item active">Company Login</a>
                    </div>
                </div>

            </div>

        </nav>
    </div>
    <!-- Navbar End -->

    <!-- Login form -->
    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">

                                    <div class="text-center">
                                        <img src="img/login.jpg" style="width: 185px;" alt="logo">
                                        <h4 class="mt-1 mb-5 pb-1">Company Login</h4>
                                    </div>


                                    <p class="alert alert-info">Please login to your account</p>

                                    <?php
                                    //If Company have successfully registered then show them this success message
                                    //Todo: Remove Success Message without reload?
                                    if (isset($_SESSION['registerCompleted'])) {
                                    ?>
                                        <div>
                                            <p class="alert alert-danger">You Have Registered Successfully! Your Account Approval Is Pending By Admin</p>
                                        </div>
                                    <?php
                                        unset($_SESSION['registerCompleted']);
                                    }
                                    ?>
                                    <?php
                                    //If Company Failed To log in then show error message.
                                    if (isset($_SESSION['loginError'])) {
                                    ?>
                                        <div>
                                            <p class="alert alert-danger">Invalid Email/Password! Try Again!</p>
                                        </div>
                                    <?php
                                        unset($_SESSION['loginError']);
                                    }
                                    ?>
                                    <?php
                                    if (isset($_SESSION['companyLoginError'])) {
                                    ?>
                                        <div>
                                            <p class="alert alert-danger">
                                                <?php echo $_SESSION['companyLoginError'] ?>
                                            </p>
                                        </div>
                                    <?php
                                        unset($_SESSION['companyLoginError']);
                                    }
                                    ?>

                                    <form method="post" action="checkcompanylogin.php">
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example11">Username</label>
                                            <input type="email" id="email" class="form-control" name="email" placeholder="Enter email address" />

                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example22">Password</label>
                                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" />

                                        </div>

                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit" style="padding: 10px 120px;">
                                                Log in
                                            </button>
                                        </div>


                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <p class="mb-0 me-2">Don't have an account?</p>
                                            <a href="register-company.php">
                                                <button type="button" class="btn btn-outline-danger">Create
                                                    new</button>
                                            </a>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <!-- <img src="img/job-1.jpg" /> -->
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                          
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4">We are more than just a company</h4>
                                    <p class="small mb-0">At the core of our identity is a commitment to innovation, collaboration, and making a positive impact. Join us on a journey where every individual contributes to a greater purpose, creating a workplace that transcends the ordinary.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- Login form End -->

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
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>

</body>

</html>