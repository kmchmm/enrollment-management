<?php
session_start();

include('includes/config.php');

if (isset($_POST['submit'])) {
    $grades = $_POST['grade'];
    $ids = $_POST['edited_id'];
    $subnames = $_POST['subname'];

    for ($i = 0; $i < count($grades); $i++) {
        $grade = $grades[$i];
        $id = $ids[$i];
        $subname = $subnames[$i];

        // Check if the grade is valid
        if (!is_numeric($grade) || $grade < 0 || $grade > 5) {
            $_SESSION['msg'] = "Uploaded";
            header('Location: edit-history.php');
            exit();
        }

        // Determine the status based on the grade
        if ($grade <= 3) {
            $status = 'passed';
            $sql = "UPDATE subjectenrolls SET grade='$grade', status='$status' WHERE studentRegno='$id' AND subjectName='$subname'";
            $_SESSION['msg'] = "Uploaded";

        } else {
            $status = 'failed';
            $sql = "UPDATE subjectenrolls SET grade='$grade', status='$status' WHERE studentRegno='$id' AND subjectName='$subname'";
            $_SESSION['msg'] = "Uploaded";
        }

        $query_run = mysqli_query($bd, $sql);
    }

    // Redirect the user to another page to avoid resubmission
    header('Location: edit-history.php');
    exit();
}
?>