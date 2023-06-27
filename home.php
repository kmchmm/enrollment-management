<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

?>

    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Student Profile</title>
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/css/style.css" rel="stylesheet" />
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    </head>

    <body>
        <?php include('includes/header.php'); ?>


        <section class="menu-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="navbar-collapse collapse ">
                            <ul id="menu-top" class="nav navbar-nav navbar-right">
                                <li>
                                    <button><i class='bx bxs-bell'></i></button>
                                </li>
                                <li>
                                    <a href="logout.php">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Home </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6 home">
                        <ul>
                            <div class="home-navigation">
                                <div>
                                    <li>
                                        <a href="my-profile.php">
                                            <img src="assets/img/profile.png" alt="smashicons">
                                            Student Profile
                                        </a>
                                    </li>
                                </div>
                                <div>
                                    <li>
                                        <a href="enroll.php">
                                            <img src="assets/img/course.png" alt="Freepik">
                                            Enroll this Semester
                                        </a>
                                    </li>
                                </div>
                                <div>
                                    <li>
                                        <a href="enroll-subject.php">
                                            <img src="assets/img/subjects.png" alt="itim2101">
                                            Add Subjects
                                        </a>
                                    </li>
                                </div>

                            </div>
                            <div class="home-navigation">
                                <div>
                                    <li>
                                        <a href="enroll-history.php">
                                            <img src="assets/img/enroll.png" alt="Freepik">
                                            Enroll History
                                        </a>
                                    </li>
                                </div>
                                <div>
                                    <li>
                                        <a href="#">
                                            <img src="assets/img/evaluation.png" alt="smashicons">
                                            Evaluation
                                        </a>
                                    </li>
                                </div>
                                <div>
                                    <li>
                                        <a href="change-password.php">
                                            <img src="assets/img/cog.png" alt="Dave Gandy">
                                            Settings
                                        </a>
                                    </li>
                                </div>
                        </ul>
                    </div>
                </div>

            </div>

        </div>





        </div>
        </div>
        <?php include('includes/footer.php'); ?>
        <script src="assets/js/jquery-1.11.1.js"></script>
        <script src="assets/js/bootstrap.js"></script>


    </body>

    </html>
<?php } ?>