<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
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
        <title>Enroll History</title>
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/css/style.css" rel="stylesheet" />
    </head>

    <body>
        <?php include('includes/header.php'); ?>

        <?php if ($_SESSION['alogin'] != "") {
            include('includes/menubar.php');
        }
        ?>

        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Enroll History </h1>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Enroll History
                            </div>

                            <div class="panel-body">
                                <div class="table-responsive table-bordered">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Student Name</th>
                                                <th>Student Reg no</th>
                                                <th>Course Name</th>
                                                <th>Academic Year</th>
                                                <th>Semester</th>
                                                <th>Enrollment Date</th>
                                                <th>Select</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = mysqli_query($bd, "SELECT courseenrolls.course AS cid, course.courseName AS courname,session.session AS session,department.department AS dept,courseenrolls.enrollDate AS edate ,semester.semester AS sem,students.studentName AS sname,students.StudentRegno AS sregno 
                                        FROM courseenrolls 
                                        JOIN course ON course.id=courseenrolls.course 
                                        JOIN session ON session.id=courseenrolls.session 
                                        JOIN department ON department.id=courseenrolls.department   
                                        JOIN semester ON semester.id=courseenrolls.semester 
                                        JOIN students ON students.StudentRegno=courseenrolls.studentRegno ");
                                            $cnt = 1;
                                            while ($row = mysqli_fetch_array($sql)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $cnt; ?></td>
                                                    <td><?php echo htmlentities($row['sname']); ?></td>
                                                    <td><?php echo htmlentities($row['sregno']); ?></td>
                                                    <td><?php echo htmlentities($row['courname']); ?></td>
                                                    <td><?php echo htmlentities($row['session']); ?></td>
                                                    <td><?php echo htmlentities($row['sem']); ?></td>
                                                    <td><?php echo htmlentities($row['edate']); ?></td>
                                                    <form action="edit-history.php" method="post">
                                                        <td>
                                                            <input type="hidden" name="edit_id" value="<?php echo $row['sregno']; ?>">
                                                            <button class="edit-button btn btn-primary" id="editBtn" name="data_edit"><span>View Subjects</span></button>
                                                        </td>
                                                    </form>
                                                </tr>
                                            <?php
                                                $cnt++;
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
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