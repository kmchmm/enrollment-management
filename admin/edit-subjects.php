<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
  header('location:index.php');
} else {
  $id = intval($_GET['id']);
  date_default_timezone_set('Asia/Kolkata');
  $currentTime = date('d-m-Y h:i:s A', time());
  if (isset($_POST['submit'])) {
    $subjectcode = $_POST['subjectcode'];
    $subjectname = $_POST['subjectname'];
    $subjectunit = $_POST['subjectunit'];
    $seatlimit = $_POST['seatlimit'];
    $prerequisite = $_POST['prerequisite'];
    $ret = mysqli_query($bd, "update subjects set subjectCode='$subjectcode',subjectName='$subjectname',subjectUnit='$subjectunit',noofSeats='$seatlimit',prerequisite='$prerequisite',updationDate='$currentTime' where id='$id'");
    if ($ret) {
      $_SESSION['msg'] = "Subject Updated Successfully !!";
      header('location:subjects.php');
    } else {
      $_SESSION['msg'] = "Error : Subject not Updated";
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
    <title>Admin | Subject</title>
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
            <h1 class="page-head-line">Edit Subject </h1>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                Subject
              </div>
              <font color="green" style="padding-left: 1em;" align="center"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?></font>


              <div class="panel-body">
                <form name="dept" method="post">
                  <?php
                  $sql = mysqli_query($bd, "select * from subjects where id='$id'");
                  $cnt = 1;
                  while ($row = mysqli_fetch_array($sql)) {
                  ?>
                    <p><b>Last Updated at</b> :<?php echo htmlentities($row['updationDate']); ?></p>
                    <div class="form-group">
                      <label for="subjectcode">Subject Code </label>
                      <input type="text" class="form-control" id="subjectcode" name="subjectcode" placeholder="Subject Code" value="<?php echo htmlentities($row['subjectCode']); ?>" required />
                    </div>

                    <div class="form-group">
                      <label for="subjectname">Subject Name </label>
                      <input type="text" class="form-control" id="subjectname" name="subjectname" placeholder="Subject Name" value="<?php echo htmlentities($row['subjectName']); ?>" required />
                    </div>

                    <div class="form-group">
                      <label for="subjectunit">Subject unit </label>
                      <input type="text" class="form-control" id="subjectunit" name="subjectunit" placeholder="Subject Unit" value="<?php echo htmlentities($row['subjectUnit']); ?>" required />
                    </div>

                    <div class="form-group">
                      <label for="seatlimit">Seat limit </label>
                      <input type="text" class="form-control" id="seatlimit" name="seatlimit" placeholder="Seat limit" value="<?php echo htmlentities($row['noofSeats']); ?>" required />
                    </div>
                    <div class="form-group">
                    <label for="prerequisite">Prerequisite </label>
                    <select class="form-control" name="prerequisite" required="required">
                      <option value="">Select Session</option>
                      <?php
                      $sql = mysqli_query($bd, "select * from subjects");
                      while ($row = mysqli_fetch_array($sql)) {
                      ?>
                        <option value="<?php echo htmlentities($row['subjectName']); ?>"><?php echo htmlentities($row['subjectName']); ?></option>
                      <?php } ?>

                    </select>
                  </div>

                  <?php } ?>
                  <button type="submit" name="submit" class="btn btn-default"><i class=" fa fa-refresh "></i> Update</button>
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
  </body>

  </html>
<?php } ?>