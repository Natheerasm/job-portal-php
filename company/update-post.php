<?php
// Include your database connection code
require_once("../db.php");
session_start();

if (empty($_SESSION['id_company'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['jobtitle'], $_POST['id_jobpost'])) { 

    // Extract values from $_POST
    $id_jobpost = mysqli_real_escape_string($conn, $_POST['id_jobpost']);
    $jobtitle = mysqli_real_escape_string($conn, $_POST['jobtitle']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $minimumsalary = mysqli_real_escape_string($conn, $_POST['minimumsalary']);
    $maximumsalary = mysqli_real_escape_string($conn, $_POST['maximumsalary']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);
    $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
    $responsibility = mysqli_real_escape_string($conn, $_POST['responsibility']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $jobnature = mysqli_real_escape_string($conn, $_POST['jobnature']);
    $categories = mysqli_real_escape_string($conn, $_POST['categories']);
    $jobtype = mysqli_real_escape_string($conn, $_POST['jobtype']);
    $vaccanices = mysqli_real_escape_string($conn, $_POST['vaccanices']);
    $closingdate = mysqli_real_escape_string($conn, $_POST['closingdate']);

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE job_post SET jobtitle=?, description=?, minimumsalary=?, maximumsalary=?, experience=?, qualification=?, responsibility=?, address=?, jobnature=?, categories=?, jobtype=?, vaccanices=?, closingdate=? WHERE id_jobpost=? AND id_company=?");
    $stmt->bind_param("sssssssssssssss", $jobtitle, $description, $minimumsalary, $maximumsalary, $experience, $qualification, $responsibility, $address, $jobnature, $categories, $jobtype, $vaccanices, $closingdate, $id_jobpost, $_SESSION['id_company']);

    if ($stmt->execute()) {
        // Successfully updated
        header("Location: my-job-post.php");
        exit();
    } else {
        // Handle the case where the update fails
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Handle the case where $_POST['jobtitle'] or $_POST['id_jobpost'] is not set
    header("Location: my-job-post.php");
    exit();
}
