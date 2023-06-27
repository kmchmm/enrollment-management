<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {


    if (isset($_POST['submit'])) {
        $studentregnos = isset($_POST['studentregno']) ? $_POST['studentregno'] : array();
        $studentnames = isset($_POST['studentname']) ? $_POST['studentname'] : array();
        $pincodes = isset($_POST['Pincode']) ? $_POST['Pincode'] : array();

        $query = mysqli_query($bd, "SELECT * FROM subjectenrolls WHERE studentRegno='" . $_SESSION['login'] . "'");
        $row = mysqli_fetch_assoc($query);
        $queryStud = mysqli_query($bd, "SELECT * FROM students WHERE StudentRegno='" . $_SESSION['login'] . "'");
        $rowStud = mysqli_fetch_assoc($queryStud);
        $querySub = mysqli_query($bd, "SELECT * FROM subjects");
        $rowSub = mysqli_fetch_assoc($querySub);
        $prerequisiteCheck = isset($rowSub['id']);

        if (!empty($rowStud)) {
            $status = isset($row['status']) ? $row['status'] : '';
            $subStatus = isset($rowStud['subjectStatus']) ? $rowStud['subjectStatus'] : '';
            if (isset($row['prerequisite'])) {
                $sql = mysqli_query($bd, "SELECT * FROM subjectenrolls WHERE prerequisite = ''");
                $result = mysqli_fetch_assoc($sql);
                $prerequisiteStudent = isset($result['prerequisite']);
            }
        } else {
            $subStatus = '';
        }

        $subjectNames = isset($_POST['subjectName']) ? $_POST['subjectName'] : array();



        foreach ($subjectNames as $subjectName) {
            $subjectData = explode(',', $subjectName);
            $subjectNameValue = $subjectData[0];
            $prerequisiteValue = isset($subjectData[1]) ? $subjectData[1] : '';

            foreach ($studentregnos as $studentregno) {
                foreach ($studentnames as $studentname) {
                    foreach ($pincodes as $pincode) {
                        if (!empty($studentregno) && !empty($studentname) && !empty($pincode)) {
                            if ($subStatus == 1) {
                                if (empty($row)) {
                                    if (!empty($prerequisiteSubject)) {
                                        $_SESSION['msg'] = "ERROR row!";
                                    } else {
                                        $sql = "INSERT INTO subjectenrolls (subjectName, prerequisite, studentRegno, studentName, pincode) 
                                            VALUES ('$subjectNameValue', '$prerequisiteValue', '$studentregno', '$studentname', '$pincode')";
                                        mysqli_query($bd, $sql);
                                        $_SESSION['msg'] = "Subject enrollment success!";
                                    }
                                } else if (($status === 'passed' && !empty($prerequisiteStudent))) {
                                    $sql = "INSERT INTO subjectenrolls (subjectName, prerequisite, studentRegno, studentName, pincode) 
                                    VALUES ('$subjectNameValue', '$prerequisiteValue', '$studentregno', '$studentname', '$pincode')";
                                    mysqli_query($bd, $sql); 

                                    $_SESSION['msg'] = "Subject enrolled!";
                                } else if($status === 'failed'){
                                    $_SESSION['msg'] = "Subject Failed!";
                                } else if($status === 'passed'){
                                    $_SESSION['msg'] = "Subject Passed!";
                                } else if ($status === 'failed' && !empty($prerequisiteStudent)) {
                                    $_SESSION['msg'] = "You failed the prerequisite, you cant take this subject!";
                                } else {
                                    $_SESSION['msg'] = "Failed to take subject! ";
                                }
                            } else {
                                if (!empty($prerequisiteCheck)) {
                                    $sql = "INSERT INTO subjectenrolls (subjectName, prerequisite, studentRegno, studentName, pincode) 
                                    VALUES ('$subjectNameValue', '$prerequisiteValue', '$studentregno', '$studentname', '$pincode')";
                                    mysqli_query($bd, $sql);

                                    $sql1 = "UPDATE students SET subjectStatus = 1 WHERE StudentRegno='" . $_SESSION['login'] . "'";
                                    mysqli_query($bd, $sql1);

                                    $_SESSION['msg'] = "Subject enrollment successful!";
                                } else {
                                    $_SESSION['msg'] = "Can't take subject, it has prerequisite!";
                                }
                            }
                        } else {
                            $_SESSION['msg'] = "Please fill out all fields";
                        }
                    }
                }
            }
        }
    }


?>

    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Subject Enroll</title>
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/css/style.css" rel="stylesheet" />
    </head>

    <body>
        <?php include('includes/header.php'); ?>
        <!-- LOGO HEADER END-->
        <?php if ($_SESSION['login'] != "") {
            include('includes/menubar.php');
        }
        ?>
        <!-- MENU SECTION END-->
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Add Subjects </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Add Subjects
                            </div>
                            <font color="green" align="center"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?></font>
                            <?php $sql = mysqli_query($bd, "select * from students where StudentRegno='" . $_SESSION['login'] . "'");
                            $cnt = 1;
                            while ($row = mysqli_fetch_array($sql)) { ?>

                                <div class="panel-body">
                                    <form name="dept" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="studentname">Student Name </label>
                                            <input type="text" class="form-control" id="studentname" name="studentname[]" value="<?php echo htmlentities($row['studentName']); ?>" readonly />
                                        </div>

                                        <div class="form-group">
                                            <label for="studentregno">Student ID No </label>
                                            <input type="text" class="form-control" id="studentregno" name="studentregno[]" value="<?php echo htmlentities($row['StudentRegno']); ?>" placeholder="Student Reg no" readonly />

                                        </div>



                                        <div class="form-group">
                                            <label for="Pincode">Pincode </label>
                                            <input type="text" class="form-control" id="Pincode" name="Pincode[]" readonly value="<?php echo htmlentities($row['pincode']); ?>" required />
                                        </div>


                                    <?php } ?>

                                    <?php $sql = mysqli_query($bd, "select * from subjectenrolls where studentRegno='" . $_SESSION['login'] . "'");
                                    $cnt = 1;
                                    while ($row = mysqli_fetch_array($sql)) { ?>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="grade" name="grade" readonly value="<?php echo htmlentities($row['grade']); ?>" required />
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="status" name="status" readonly value="<?php echo htmlentities($row['status']); ?>" required />
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="prerequisite" name="prerequisite" readonly value="<?php echo htmlentities($row['prerequisite']); ?>" required />
                                        </div>
                                    <?php } ?>

                                    <div class="form-group">
                                        <div id="appendSubjects">
                                            <div>
                                                <label for="subjectName">Subject </label>
                                                <div style="display:flex; justify-content:space-between;">
                                                    <select class="form-control" name="subjectName[]" required="required">
                                                        <option value="">Select Subject to Add</option>
                                                        <?php
                                                        $sql = mysqli_query($bd, "select * from subjects");
                                                        while ($row = mysqli_fetch_array($sql)) {
                                                        ?>
                                                            <option value="<?php echo htmlentities($row['subjectName']); ?>, <?php echo htmlentities($row['prerequisite']); ?>"><?php echo htmlentities($row['subjectName']); ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                    <input type="button" name="subjectAdd" id="subjectAdd" value="&#x002B;" class="btn btn-primary">
                                                </div>
                                            </div>
                                        </div>



                                    </div>


                                    <button type="submit" name="submit" id="submit" class="btn btn-default">Enroll Subjects</button>
                                    </form>
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
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script>
            function courseAvailability() {
                $("#loaderIcon").show();
                jQuery.ajax({
                    url: "check_availability.php",
                    data: 'cid=' + $("#course").val(),
                    type: "POST",
                    success: function(data) {
                        $("#course-availability-status1").html(data);
                        $("#loaderIcon").hide();
                    },
                    error: function() {}
                });
            }
        </script>

        <script>
            $(document).ready(function() {
                var html = '<span><label for="subjectName">Add more subject</label><div style="display:flex; justify-content:space-between;"><select class="form-control" name="subjectName[]" required="required"><option value="">Select Subject to Add</option><?php $sql = mysqli_query($bd, "select * from subjects");
                                                                                                                                                                                                                                                                    while ($row = mysqli_fetch_array($sql)) { ?> <option value = "<?php echo htmlentities($row['subjectName']); ?>" > <?php echo htmlentities($row['subjectName']); ?><?php } ?></select > <input type = "button" name = "subjectRemove" id = "subjectRemove" value = "&#8722;" class = "btn btn-danger" ></span> ';

                var max = 10;
                var x = 1;

                $("#subjectAdd").click(function() {
                    if (x <= max) {
                        $("#appendSubjects").append(html);
                        x++;
                    }
                });
                $("#appendSubjects").on('click', '#subjectRemove', function() {
                    $(this).closest('span').remove();
                    x--;
                });
            });
            $
        </script>

    </body>

    </html>
<?php } ?>