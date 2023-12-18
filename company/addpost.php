<!-- addpost.php -->
<?php
// To Handle Session Variables on This Page
session_start();

if (empty($_SESSION['id_company'])) {
	header("Location: ../index.php");
	exit();
}

require_once("../db.php");

// If the user actually clicked the Add Post Button
if (isset($_POST)) { // Check if 'jobtitle' is set in the form submission

	// Extract values from $_POST
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
	$stmt = $conn->prepare("INSERT INTO job_post(id_company, jobtitle, description, minimumsalary, maximumsalary, experience, qualification, responsibility, address, jobnature, categories, jobtype, vaccanices, closingdate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

	$stmt->bind_param("isssssssssssss", $_SESSION['id_company'], $jobtitle, $description, $minimumsalary, $maximumsalary, $experience, $qualification, $responsibility, $address, $jobnature, $categories, $jobtype, $vaccanices, $closingdate);

	if ($stmt->execute()) {
		$_SESSION['jobPostSuccess'] = true;
		header("Location: index.php");
		exit();
	} else {
		echo "Error: " . $stmt->error;
	}

	$stmt->close();
	$conn->close();
} else {
	header("Location: create-job-post.php");
	exit();
}
