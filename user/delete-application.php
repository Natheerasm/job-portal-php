<?php
// Ensure that the session is started and user is logged in
session_start();
if (!isset($_SESSION['id_user'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit();
}

// Include your database connection file
require_once("../db.php");

// Check if the job post ID is provided in the URL
if (isset($_GET['id'])) {
    $jobPostId = $_GET['id'];

    // SQL to delete the job post application
    $sql = "DELETE FROM apply_job_post WHERE id_jobpost = '$jobPostId' AND id_user = '$_SESSION[id_user]'";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Redirect to a success page or the original page
        header("Location: my-application.php");
        exit();
    } else {
        // Handle errors, you might want to customize this part based on your requirements
        echo "Error deleting record: " . $conn->error;
    }
} else {
    // Redirect to an error page or handle the case when job post ID is not provided
    header("Location: error.php");
    exit();
}

// Close the database connection
$conn->close();
?>
