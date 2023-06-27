<?php
session_start();
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    if (isset($_POST['submit'])) {
        $subjectcode = $_POST['subjectcode'];
        $subjectname = $_POST['subjectname'];
        $subjectunit = $_POST['subjectunit'];
        $seatlimit = $_POST['seatlimit'];

        $subjectnameIDnum = "$subjectcode";
        $search = "SELECT * FROM subjects WHERE subjectCode = '$subjectnameIDnum'";
        $result = $bd->query($search);
        if ($result->num_rows > 0) {
            $_SESSION['msg'] = "Error : Subject already existed";
        } else {
            $ret = mysqli_query($bd, "insert into subjects(subjectCode,subjectName,subjectUnit,noofSeats) values('$subjectcode','$subjectname','$subjectunit','$seatlimit')");
            if ($ret) {
                $_SESSION['msg'] = "Subject Created Successfully !!";
            } else {
                $_SESSION['msg'] = "Error : Subject not created";
            }
        }
        $sql = mysqli_query($bd, "select * from subjects");
        while ($row = mysqli_fetch_array($sql)) {
            if ($row['prerequisite'] != '') {
                if ($row['status'] != 'FAILED') {
                }
            }
        }
    }
    if (isset($_GET['del'])) {
        mysqli_query($bd, "delete from subjects where id = '" . $_GET['id'] . "'");
        $_SESSION['delmsg'] = "Subject deleted !!";
    }
?>

    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admin | Subjects</title>
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
                        <h1 class="page-head-line">Add Subject </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Subjects
                            </div>
                            <font color="green" style="padding-left: 1em;" align="center"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg'] = ""); ?></font>


                            <div class="panel-body">
                                <form name="dept" method="post">
                                    <div class="form-group">
                                        <label for="subjectcode">Subject Code </label>
                                        <input type="text" class="form-control" id="subjectcode" name="subjectcode" placeholder="Subject Code" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="subjectname">Subject Name </label>
                                        <input type="text" class="form-control" id="subjectname" name="subjectname" placeholder="Subject Name" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="subjectunit">Subject unit </label>
                                        <input type="text" class="form-control" id="subjectunit" name="subjectunit" placeholder="Subject Unit" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="seatlimit">Seat limit </label>
                                        <input type="text" class="form-control" id="seatlimit" name="seatlimit" placeholder="Seat limit" required />
                                    </div>

                                    <?php
                                    $sql = mysqli_query($bd, "select * from subjects");
                                    $cnt = 1;
                                    while ($row = mysqli_fetch_array($sql)) {
                                    ?>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="prerequisite" name="prerequisite" value="<?php echo $row['prerequisite'];?>"/>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <button type="submit" name="submit" class="btn btn-default">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <font color="red" style="padding-left: 1em;" align="center"><?php echo htmlentities($_SESSION['delmsg']); ?><?php echo htmlentities($_SESSION['delmsg'] = ""); ?></font>
                <div class="col-md-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Manage Subject
                        </div>

                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Subject Code</th>
                                            <th>Subject Name </th>
                                            <th>Subject Unit</th>
                                            <th>Seat limit</th>
                                            <th>Prerequisite</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = mysqli_query($bd, "select * from subjects");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($sql)) {
                                        ?>


                                            <tr>
                                                <td><?php echo $cnt; ?></td>
                                                <td><?php echo htmlentities($row['subjectCode']); ?></td>
                                                <td><?php echo htmlentities($row['subjectName']); ?></td>
                                                <td><?php echo htmlentities($row['subjectUnit']); ?></td>
                                                <td><?php echo htmlentities($row['noofSeats']); ?></td>
                                                <td><?php echo htmlentities($row['prerequisite']); ?></td>
                                                <td>
                                                    <a href="edit-subjects.php?id=<?php echo $row['id'] ?>">
                                                        <button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button> </a>
                                                    <a href="subjects.php?id=<?php echo $row['id'] ?>&del=delete" onClick="return confirm('Are you sure you want to delete?')">
                                                        <button class="btn btn-danger">Delete</button>
                                                    </a>
                                                </td>
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