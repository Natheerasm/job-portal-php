<?php
// To Handle Session Variables on This Page
session_start();

if (empty($_SESSION['id_user'])) {
	header("Location: index.php");
	exit();
}

// Including Database Connection From db.php file to avoid rewriting in all files
require_once("db.php");

// If the user actually clicked the apply button
if (isset($_GET['id'])) {
	$jobPostId = $_GET['id'];

	// Retrieve job post details
	$sql = "SELECT * FROM job_post WHERE id_jobpost=?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("i", $jobPostId);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$id_company = $row['id_company'];
	} else {
		// Job post not found
		header("Location: jobs.php");
		exit();
	}

	// Check if the user has applied to the job post or not
	$sql1 = "SELECT * FROM apply_job_post WHERE id_user=? AND id_jobpost=?";
	$stmt1 = $conn->prepare($sql1);
	$stmt1->bind_param("ii", $_SESSION['id_user'], $jobPostId);
	$stmt1->execute();
	$result1 = $stmt1->get_result();

	if ($result1->num_rows == 0) {
		// User has not applied, insert the application
		$applyDate = date("Y-m-d H:i:s"); // Get the current date and time

		$sql2 = "INSERT INTO apply_job_post(id_jobpost, id_company, id_user, apply_date) VALUES (?, ?, ?, ?)";
		$stmt2 = $conn->prepare($sql2);
		$stmt2->bind_param("iiis", $jobPostId, $id_company, $_SESSION['id_user'], $applyDate);

		if ($stmt2->execute()) {
			$_SESSION['jobApplySuccess'] = true;
			header("Location: user/index.php");
			exit();
		} else {
			// Log or display an error message
			echo "Error: " . $stmt2->error;
		}
	} else {
		// User has already applied
		$_SESSION['applyError'] = "You have already applied for this job.";
		header("Location: jobs.php");
		exit();
	}

	$stmt2->close();
	$stmt1->close();
	$stmt->close();
	$conn->close();
} else {
	// Invalid request, redirect to jobs.php
	header("Location: jobs.php");
	exit();
}
