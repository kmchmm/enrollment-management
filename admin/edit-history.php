<?php
session_start();
include('includes/config.php');
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Admin | View Subjects</title>
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
          <h1 class="page-head-line">View Subject </h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading ">
              <span>Enrolled subjects</span>
            </div>
            <font color="green" style="padding-left: 1em;" align="center"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?></font>

            <div class="panel-body">
              <form name="" method="POST" action="edithistory-actions.php">
                <div class="table-responsive table-bordered">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Student ID</th>
                        <th>Subject Name</th>
                        <th>Grade</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      if (isset($_POST['data_edit'])) {
                        $id = $_POST['edit_id'];

                        $query = "SELECT * FROM subjectenrolls WHERE studentRegno = '$id'";
                        $query_run = mysqli_query($bd, $query);
                        while ($row = mysqli_fetch_assoc($query_run)) {

                          // Do something with the values
                      ?>
                          <tr>
                            <td><input type="text" value="" name="id" id="id" style="border:none; background-color:transparent;" placeholder="<?php echo $row['id']; ?>" readonly></td>
                            <td><input type="text" value="<?php echo $row['studentRegno']; ?>" name="edited_id[]" id="edited_id" style="border:none; background-color:transparent;" placeholder="<?php echo $row['studentRegno']; ?>" readonly></td>
                            <td><input type="text" value="<?php echo $row['subjectName']; ?>" name="subname[]" id="subname" style="border:none; background-color:transparent;" placeholder="<?php echo $row['subjectName']; ?>" readonly></td>
                            <td><input type="text" value="<?php echo $row['grade']; ?>" name="grade[]" id="grade" placeholder="<?php echo $row['grade']; ?>"></td>
                            <td><input type="text" value="" name="" id="" style="border:none; background-color:transparent;" placeholder="<?php echo $row['status']; ?>" readonly></td>
                            </td>
                          </tr>
                      <?php }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
                <br>
                <input type="submit" value="Save" name="submit">
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
<?php  ?>