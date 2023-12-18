<!-- addfeedback.php -->

<?php
session_start();
require_once("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $profession = mysqli_real_escape_string($conn, $_POST['profession']);
    
    $uploadOk = true;
    $folderDir = "uploads/feedback/";

    $base = basename($_FILES['image']['name']);
    $imageFileType = pathinfo($base, PATHINFO_EXTENSION);
    $file = uniqid() . "." . $imageFileType;
    $filename = $folderDir . $file;

    if (file_exists($_FILES['image']['tmp_name'])) {
        $allowedTypes = ['jpg', 'jpeg', 'png'];
        if (in_array($imageFileType, $allowedTypes) && $_FILES['image']['size'] < 500000) {
            move_uploaded_file($_FILES['image']['tmp_name'], $filename);
        } else {
            $_SESSION['uploadError'] = "Invalid file type or wrong size. Max Size Allowed: 500KB";
            $uploadOk = false;
        }
    } else {
        $_SESSION['uploadError'] = "Something Went Wrong. File Not Uploaded. Try Again.";
        $uploadOk = false;
    }

    if ($uploadOk) {
        $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);
        $submission_date = date("Y-m-d H:i:s");

        $sql = "INSERT INTO feedback (name, email, profession, image, feedback, submission_date) VALUES ('$name', '$email', '$profession', '$file', '$feedback', '$submission_date')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['feedbackSuccess'] = true;
            header("Location: testimonial.php"); 
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        header("Location: testimonial.php");
        exit();
    }

    $conn->close(); 
} else {
    header("Location: testimonial.php");
    exit();
}
?>
