<?php
session_start();

// Check if the user is not logged in, then redirect to the homepage
if (empty($_SESSION['id_user'])) {
    header("Location: ../index.php");
    exit();
}

require_once("../db.php");

// Check if the id_mail is set in the GET parameters
if (isset($_GET['id_mail'])) {
    $mailId = $_GET['id_mail'];

    // Perform the delete operation
    $deleteSql = "DELETE FROM mailbox WHERE id_mailbox = ? AND (id_fromuser = ? OR id_touser = ?)";
    
    // Use prepared statement to avoid SQL injection
    $stmt = $conn->prepare($deleteSql);
    
    // Bind parameters
    $stmt->bind_param("iii", $mailId, $_SESSION['id_user'], $_SESSION['id_user']);
    
    // Execute the statement
    $stmt->execute();
    
    // Check if the deletion was successful
    if ($stmt->affected_rows > 0) {
        // Display success message
        echo "Message deleted successfully.";

        // Redirect back to the inbox after successful deletion
        header("Location: inbox-mail.php");
        exit();
    } else {
        // Handle errors, you can customize this part based on your needs
        echo "Error deleting message.";
    }
    
    // Close the statement
    $stmt->close();
}

// The rest of your HTML code follows...
?>
