<?php
session_start();

if (isset($_SESSION['id_user']) || isset($_SESSION['id_company'])) {
    header("Location: index.php");
    exit();
}

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
    <style>
        .gradient-custom-2 {
            /* fallback for old browsers */
            background: #00B074;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, #00b074, #00b074, #00b074, #00b074);

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: -webkit-linear-gradient(to right, #00b074, #00b074, #00b074, #00b074);
        }

        #passwordError {
            display: none;
        }
    </style>

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
                    <?php if (empty($_SESSION['id_user']) && empty($_SESSION['id_company'])) { ?>
                        <div class="nav-item dropdown">
                            <a href="jobs.php" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Register</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="register-user.php" class="dropdown-item">User Register</a>
                                <a href="register-company.php" class="dropdown-item active">Company Register</a>
                            </div>
                        </div>
                </div>


                <div class="nav-item dropdown">
                    <a href="jobs.php" class="nav-link dropdown-toggle btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block" data-bs-toggle="dropdown">Login</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="login-user.php" class="dropdown-item">User Login</a>
                        <a href="login-company.php" class="dropdown-item">Company Login</a>
                    </div>
                </div>
                <?php } else {

                        if (isset($_SESSION['id_user'])) {
                ?>
                    <a href="../user-panel/dashboard.php" class="btn btn-secondary rounded-0 py-4 px-lg-5 d-none d-lg-block">DashBoard</a>
                <?php
                        } else if (isset($_SESSION['id_company'])) {
                ?>
                    <a href="../company-panel/dashboard.php" class="btn btn-secondary rounded-0 py-4 px-lg-5 d-none d-lg-block">DashBoard</a>
                <?php } ?>
                <a href="logout.php" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block">Logout<i class="fa fa-arrow-right  ms-3"></i></a>
            <?php } ?>

            </div>

        </nav>
    </div>
    <!-- Navbar End -->
    <form method="post" id="registerCompanies" action="addcompany.php" enctype="multipart/form-data">
        <!-- Login form -->
        <section class="h-100 gradient-form" style="background-color: #eee;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-xl-10">
                        <div class="card rounded-3 text-black">
                            <div class="row g-0">
                                <!-- image -->
                                <div class="text-center">
                                    <img src="img/login.jpg" style="width: 185px;" alt="logo">
                                    <h4 class="mt-1 mb-5 pb-1">CREATE YOUR PROFILE - COMPANY</h4>
                                </div>

                                <!-- 1st column -->

                                <div class="col-lg-6">
                                    <div class="card-body p-md-5 mx-md-4 ">

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example22">Full Name</label>
                                            <input class="form-control input-lg" type="text" name="name" placeholder="Full Name" required>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example22">Company Name</label>
                                            <input class="form-control input-lg" type="text" name="companyname" placeholder="Company Name" required>

                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example22">Email</label>
                                            <input class="form-control input-lg" type="text" name="email" placeholder="Email" required>

                                        </div>
                                        <?php
                                        //If Company already registered with this email then show error message.
                                        if (isset($_SESSION['registerError'])) {
                                        ?>
                                            <div>
                                                <p class="text-center" style="color: red;">Email Already Exists! Choose
                                                    A Different Email!</p>
                                            </div>
                                        <?php
                                            unset($_SESSION['registerError']);
                                        }
                                        ?>


                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example22">Website</label>
                                            <input class="form-control input-lg" type="text" name="website" placeholder="Website">

                                        </div>


                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example22">About your
                                                company</label>
                                            <textarea class="form-control input-lg" rows="4" name="aboutme" placeholder="Brief info about your company"></textarea>

                                        </div>

                                    </div>
                                </div>

                                <!-- 2nd column -->
                                <div class="col-lg-6">
                                    <div class="card-body p-md-5 mx-md-4  ">

                                        <!-- <div class="col-md-6 latest-job "> -->

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example22">Password</label>
                                            <input class="form-control input-lg" type="password" name="password" placeholder="Password" required>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example22">Confirm Password</label>
                                            <input class="form-control input-lg" type="password" name="cpassword" placeholder="Confirm Password" required>
                                        </div>

                                        <div class="form-group">
                                            <label id="passwordError" style="color: red;">Password Mismatch!!</label>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example22">Phone Number</label>
                                            <input class="form-control input-lg" type="text" name="contactno" placeholder="Phone Number" minlength="10" maxlength="10" autocomplete="off" onkeypress="return validatePhone(event);" required>

                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example22">Country</label>
                                            <select class="form-control input-lg" id="country" name="country" required>
                                            <option selected="" value="">Select Country</option>
                                                <?php
                                                $sql = "SELECT `id`, `name` FROM `countries` ORDER BY `id` = 206 DESC, `name` ASC";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<option value='" . $row['name'] . "' data-id='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>


                                        <div class="form-outline mb-4" id="stateDiv" style="display: none;">
                                            <label class="form-label" for="form2Example22">State</label>
                                            <select class="form-control  input-lg" id="state" name="state" required>
                                                <option value="" selected="">Select State</option>
                                            </select>

                                        </div>

                                        <div class="form-outline mb-4" id="cityDiv" style="display: none;">
                                            <label class="form-label" for="form2Example22">City</label>
                                            <select class="form-control  input-lg" id="city" name="city" required>
                                                <option selected="">Select City</option>
                                            </select>

                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example22">Attach Company
                                                Logo</label>
                                            <input type="file" name="image" class="btn btn-flat btn-danger form-control input-lg " style="color: black;" required>
                                        </div>
                                        <?php
                                        if (isset($_SESSION['uploadError'])) {
                                        ?>
                                            <div>
                                                <p class="text-center" style="color: red;">
                                                    <?php echo $_SESSION['uploadError']; ?>
                                                </p>
                                            </div>
                                        <?php
                                            unset($_SESSION['uploadError']);
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>

                            <div class="d-flex align-items-center justify-content-center pb-4">
                                <label><input type="checkbox"> I accept terms & conditions</label>

                            </div>
                            <div class="d-flex align-items-center justify-content-center pb-4">
                                <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit" style="padding: 10px 120px;">
                                    Register
                                </button>

                            </div>

    </form>
    <div class="d-flex align-items-center justify-content-center pb-4">
        <p class="mb-0 me-2">Already have an account?</p>
        <a href="login-company.php">
            <button type="button" class="btn btn-outline-danger">Login</button>
        </a>
    </div>
    </div>

    </div>
    </div>
    </div>
    </div>
    </div>

    </section>
    </form>
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
    <!-- jQuery 3 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="js/adminlte.min.js"></script>

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
    </script>

    <script>
        $("#country").on("change", function() {
            var id = $(this).find(':selected').attr("data-id");
            $("#state").find('option:not(:first)').remove();
            if (id != '') {
                $.post("state.php", {
                    id: id
                }).done(function(data) {
                    $("#state").append(data);
                });
                $('#stateDiv').show();
            } else {
                $('#stateDiv').hide();
                $('#cityDiv').hide();
            }
        });
    </script>

    <script>
        $("#state").on("change", function() {
            var id = $(this).find(':selected').attr("data-id");
            $("#city").find('option:not(:first)').remove();
            if (id != '') {
                $.post("city.php", {
                    id: id
                }).done(function(data) {
                    $("#city").append(data);
                });
                $('#cityDiv').show();
            } else {
                $('#cityDiv').hide();
            }
        });
    </script>

    <script>
        $("#registerCompanies").on("submit", function(e) {
            e.preventDefault();
            if ($('input[name="password"]').val() != $('input[name="cpassword"]').val()) {
                $('#passwordError').show();
            } else {
                $(this).unbind('submit').submit();
            }
        });
    </script>
</body>

</html>