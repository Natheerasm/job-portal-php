<?php
session_start();

if (empty($_SESSION['id_admin'])) {
    header("Location: index.php");
    exit();
}

require_once("../db.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Use prepared statement to prevent SQL injection
    $sql = "DELETE FROM users WHERE id_user = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_GET['id']); 

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: user-details.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
