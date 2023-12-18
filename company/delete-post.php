<?php
session_start();

if (empty($_SESSION['id_company'])) {
    header("Location: ../index.php");
    exit();
}

require_once("../db.php");

// Check if the 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $jobPostId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Perform the deletion query
    // Note: Replace 'your_table_name' with the actual table name in your database
    $deleteQuery = "DELETE FROM job_post WHERE id_jobpost = $jobPostId";

    // Execute the query
    if ($conn->query($deleteQuery)) {
        // Redirect to a page after successful deletion
        header("Location: index.php");
        exit();
    } else {
        // Handle the case where deletion failed
        echo "Error: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
