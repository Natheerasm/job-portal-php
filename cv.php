<?php

//To Handle Session Variables on This Page
session_start();

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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border" style="width: 3rem; height: 3rem; color:#00B074" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar Start -->
        <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
            <a href="index.php" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
                <h1 class="m-0 " style="color:#00B074">
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
                            <a href="testimonial.php" class="dropdown-item">Testimonial</a>
                            <a href="contact.php" class="dropdown-item">Contact</a>
                            <a href="cv.php" class="dropdown-item active">CV Generator</a>
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
                        <a href="#" class="nav-link dropdown-toggle btn rounded-0 py-4 px-lg-5 d-none d-lg-block" style="background-color: #00B074; color: #ffffff;" data-bs-toggle="dropdown">Login</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="login-user.php" class="dropdown-item">User Login</a>
                                <a href="login-company.php" class="dropdown-item">Company Login</a>
                            </div>
                        </div>

                        <?php } else {

                        if (isset($_SESSION['id_user'])) {
                        ?>
                            <a href="../user/index.php" class="btn btn-secondary rounded-0 py-4 px-lg-5 d-none d-lg-block">DashBoard</a>
                        <?php
                        } else if (isset($_SESSION['id_company'])) {
                        ?>
                            <a href="../company/index.php" class="btn btn-secondary rounded-0 py-4 px-lg-5 d-none d-lg-block">DashBoard</a>
                        <?php } ?>
                        <a href="logout.php" class="btn  rounded-0 py-4 px-lg-5 d-none d-lg-block" style="background-color: #00B074; color: #ffffff;" >Logout<i class="fa fa-arrow-right  ms-3"></i></a>
                    <?php } ?>

                </div>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->


    <!-- Header End -->
    <div class="container-xxl py-5 bg-dark page-header mb-5">
        <div class="container my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">CV Generator</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item" ><a href="#" style="color:#00B074">Home</a></li> 
                    <li class="breadcrumb-item"><a href="#"style="color:#00B074">Pages</a></li> 
                    <li class="breadcrumb-item text-white active" aria-current="page">CV Generator</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Header End -->


    <!-- 404 Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container text-center">
            <div class="row justify-content-center">

                <div class="nav">
                    <button id="cmd" onclick="printpdf()" class="navbtn"><i class="fas fa-download"></i></button>
                    <form>
                        <input type="hidden" id="custinfo" name="custinfo">
                        <button class="navbtn"><i class="fas fa-save"></i></button>
                    </form>
                    <button class="navbtn" href=""><i class="fas fa-home"></i></button>
                </div>

                <div class="resume" id="resume">
                    <section id="print">
                        <div class="head">
                            <div class="main">
                                <span class="name" contenteditable="true">YOUR</span> <span contenteditable="true">NAME</span>
                                <div class="post" contenteditable="true">YOUR JOB PROFILE</div>
                            </div>
                            <div class="contacts">
                                <span contenteditable="true" class="content">231-3212-2132</span><span class="symbol"> <i class="fas fa-phone"></i></span><br>
                                <span contenteditable="true" class="content">samplemail@email.in</span><span class="symbol"> <i class="fas fa-envelope"></i></span><br>
                                <span contenteditable="true" class="content">linkedin/username.com</span><span class="symbol"> <i class="fab fa-linkedin"></i></span><br>
                                <span contenteditable="true" class="content">sample street-India</span><span class="symbol"> <i class="fas fa-map-marker-alt"></i></i></span>
                            </div>
                        </div>

                        <div class="line" style="height:fit-content"></div>
                        <div class="mainbody">
                            <div class="leftside">
                                <span class="title">MY SKILLS</span><br><br>
                                <div>
                                    <div class="skill"><span><input type="checkbox" class="input-checkbox"></span><span><i class="fas fa-chevron-circle-right"></i></span> <span contenteditable="true">write
                                            your skill here</span></div>
                                    <div id="skills"></div>
                                    <button id="skilladd" type="button" class="btn btn-success" onclick="addskill()"><i class="fas fa-plus-circle"></i> Skill</button>
                                    <button id="skillrem" type="button" class="btn btn-danger" onclick="remskill(event)"><i class="fas fa-minus-circle"></i> Skill</button>
                                </div>
                                <br><br><span class="title">LANGUAGES</span><br><br>
                                <div>
                                    <div class="language"><span><input type="checkbox" class="input-checkbox"></span><span contenteditable="true">LANGNAME</span> - <span contenteditable="true">level u
                                            know</span></div>
                                    <div id="languages"></div>
                                    <button id="langadd" type="button" class="btn btn-success" onclick="addLang()"><i class="fas fa-plus-circle"></i> Language</button>

                                    <button id="langrem" type="button" class="btn btn-danger" onclick="remLang(event)"><i class="fas fa-minus-circle"></i> Language</button>
                                </div>
                                <br><br><span class="title">ACHIEVEMENTS</span><br><br>
                                <div>
                                    <div class="achieve"><span><input type="checkbox" class="input-checkbox"></span><span contenteditable="true">Write your achievement</span></div>
                                    <div id="achievement"></div>
                                    <button id="achadd" type="button" class="btn btn-success" onclick="addAch()"><i class="fas fa-plus-circle"></i> Achievement</button>

                                    <button id="achrem" type="button" class="btn btn-danger" onclick="remAch(event)" style="margin-top: 0;"><i class="fas fa-minus-circle"></i> Achievement</button>
                                </div>
                                <br><br><span class="title">INTERESTS</span><br><br>
                                <div>
                                    <div class="achieve"><span><input type="checkbox" class="input-checkbox"></span><span contenteditable="true">Write interest</span></div>
                                    <div id="interest"></div>
                                    <button id="Intadd" type="button" class="btn btn-success" onclick="addInt()"><i class="fas fa-plus-circle"></i> Interest</button>

                                    <button id="Intrem" type="button" class="btn btn-danger" onclick="remInt(event)"><i class="fas fa-minus-circle"></i> Interest</button>
                                </div>
                            </div>

                            <div class="border"></div>
                            <div class="rightside">
                                <span class="title">PROFILE</span><br><br>
                                <div contenteditable="true">
                                    Here u can write the basic information about your career like your forte, something about
                                    yourself that
                                    you want your interviewer to know. Try to keep it brief and only provide necessary information.
                                    Do not include information which is
                                    already written in your resume in some other section.</div>
                                <br><br><span class="title">EDUCATION</span><br><br>
                                <div>
                                    <div id="education">
                                        <div class="edublock">
                                            <span><input type="checkbox" class="input-checkbox"></span>
                                            <span class="education-head" contenteditable="true">YOUR DEGREE</span>
                                            <div><span contenteditable="true">Institute name</span> - <span contenteditable="true">Passing Year</span></div>
                                        </div>
                                    </div>

                                    <button id="eduadd" type="button" class="btn btn-success" onclick="addedu()"><i class="fas fa-plus-circle"></i> Education</button>

                                    <button id="edurem" type="button" class="btn btn-danger" onclick="remedu(event)"><i class="fas fa-minus-circle"></i> Education</button>
                                </div>
                                <br><br>
                                <div class="new-section-div">
                                    <div><span><input type="checkbox" class="input-checkbox"></span><span class="title" contenteditable="true">NEW SECTION</span><br><br>
                                        <div contenteditable="true">
                                            This is the description part of your new section. Try to stay within limit and write
                                            something which has less
                                            than 400 characters. The spaces and symbols you use will also be included so use them
                                            for an indentation effect.</div>
                                    </div>

                                    <div id="newsec"></div>
                                    <button id="secadd" type="button" class="btn btn-success" onclick="addsec()"><i class="fas fa-plus-circle"></i> Section</button>

                                    <button id="secrem" type="button" class="btn btn-danger" onclick="remsec(event)"><i class="fas fa-minus-circle"></i> Section</button>
                                </div>
                            </div>
                    </section>
                </div>
                <!-- <div class="col-lg-6">
                    <i class="bi bi-exclamation-triangle display-1 text-primary"></i>
                    <h1 class="display-1">404</h1>
                    <h1 class="mb-4">Page Not Found</h1>
                    <p class="mb-4">We’re sorry, the page you have looked for does not exist in our website! Maybe go to
                        our home page or try to use a search?</p>
                    <a class="btn btn-primary py-3 px-5" href="">Go Back To Home</a>
                </div> -->
            </div>
        </div>
    </div>
    <!-- 404 End -->


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
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Newsletter</h5>
                    <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn  py-2 position-absolute top-0 end-0 mt-2 me-2"style="background-color: #00B074; color: #ffffff;" >SignUp</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved.

                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
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
    <a href="#" class="btn btn-lg  btn-lg-square back-to-top" style="background-color: #00B074; color: #ffffff;" ><i class="bi bi-arrow-up"></i></a>
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


    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.0/html2pdf.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>