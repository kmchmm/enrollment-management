<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
  header('location:index.php');
} else {

  if (isset($_POST['submit'])) {
    $session = $_POST['session'];
    $dept = $_POST['department'];
    $level = $_POST['level'];
    $sem = $_POST['sem'];
    $studentregno = $_POST['studentregno'];
    $course = $_POST['course'];

    $ret = "UPDATE courseenrolls SET session='$session', department='$dept', level = '$level', semester='$sem' WHERE studentRegno='" . $_SESSION['login'] . "'";
    if (mysqli_query($bd, $ret)) {
      $_SESSION['msg'] = "Student Registered Successfully !!";
    } else {
      $_SESSION['msg'] = "Error : Student  not Register";
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
    <title>Course Enroll</title>
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
            <h1 class="page-head-line">Course Enroll </h1>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                Course Enroll
              </div>
              <font color="green" align="center"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?></font>
              <?php $sql = mysqli_query($bd, "select * from students where StudentRegno='" . $_SESSION['login'] . "'");
              $cnt = 1;
              while ($row = mysqli_fetch_array($sql)) { ?>

                <div class="panel-body">
                  <form name="dept" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                      <label for="studentname">Student Name </label>
                      <input type="text" class="form-control" id="studentname" name="studentname" value="<?php echo htmlentities($row['studentName']); ?>" readonly />
                    </div>

                    <div class="form-group">
                      <label for="studentregno">Student ID No </label>
                      <input type="text" class="form-control" id="studentregno" name="studentregno" value="<?php echo htmlentities($row['StudentRegno']); ?>" placeholder="Student Reg no" readonly />

                    </div>


                    <div class="form-group">
                      <label for="Pincode">Pincode </label>
                      <input type="text" class="form-control" id="Pincode" name="Pincode" readonly value="<?php echo htmlentities($row['pincode']); ?>" required />
                    </div>

                    <div class="form-group">
                      <label for="course">Course </label>
                      <input type="hidden" class="form-control" id="course" name="course" readonly value="<?php echo htmlentities($row['course']); ?>" required />
                    </div>



                    <div class="form-group">
                      <label for="Pincode">Student Photo </label>
                      <?php if ($row['studentPhoto'] == "") { ?>
                        <img src="studentphoto/noimage.png" width="200" height="200"><?php } else { ?>
                        <img src="studentphoto/<?php echo htmlentities($row['studentPhoto']); ?>" width="200" height="200">
                      <?php } ?>
                    </div>
                  <?php } ?>


                  <?php
                  $sql = mysqli_query($bd, "select * from courseenrolls");
                  $cnt = 1;
                  while ($row = mysqli_fetch_array($sql)) { ?>
                    <div class="form-group">
                      <input type="hidden" class="form-control" id="course" name="course" readonly value="<?php echo htmlentities($row['course']); ?>" required />
                    </div>
                  <?php } ?>

                  <div class="form-group">
                    <label for="Session">Academic Year </label>
                    <select class="form-control" name="session" required="required">
                      <option value="">Select Session</option>
                      <?php
                      $sql = mysqli_query($bd, "select * from session");
                      while ($row = mysqli_fetch_array($sql)) {
                      ?>
                        <option value="<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['session']); ?></option>
                      <?php } ?>

                    </select>
                  </div>



                  <div class="form-group">
                    <label for="Department">Department </label>
                    <select class="form-control" name="department" required="required">
                      <option value="">Select Department</option>
                      <?php
                      $sql = mysqli_query($bd, "select * from department");
                      while ($row = mysqli_fetch_array($sql)) {
                      ?>
                        <option value="<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['department']); ?></option>
                      <?php } ?>

                    </select>
                  </div>


                  <div class="form-group">
                    <label for="Level">Level </label>
                    <select class="form-control" name="level" required="required">
                      <option value="">Select Level</option>
                      <?php
                      $sql = mysqli_query($bd, "select * from level");
                      while ($row = mysqli_fetch_array($sql)) {
                      ?>
                        <option value="<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['level']); ?></option>
                      <?php } ?>

                    </select>
                  </div>

                  <div class="form-group">
                    <label for="Semester">Semester </label>
                    <select class="form-control" name="sem" required="required">
                      <option value="">Select Semester</option>
                      <?php
                      $sql = mysqli_query($bd, "select * from semester");
                      while ($row = mysqli_fetch_array($sql)) {
                      ?>
                        <option value="<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['semester']); ?></option>
                      <?php } ?>

                    </select>
                  </div>



                  <button type="submit" name="submit" id="submit" class="btn btn-default">Enroll</button>
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


  </body>

  </html>
<?php } ?>