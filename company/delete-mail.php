<?php
session_start();

if (empty($_SESSION['id_company'])) {
    header("Location: ../index.php");
    exit();
}

require_once("../db.php");

if (isset($_GET['id_mail'])) {
    $mailId = $_GET['id_mail'];

    // Perform the delete operation
    $deleteSql = "DELETE FROM mailbox WHERE id_mailbox='$mailId' AND (id_fromuser='$_SESSION[id_company]' OR id_touser='$_SESSION[id_company]')";
    $deleteResult = $conn->query($deleteSql);

    // You might want to handle the deletion of related data in other tables (e.g., reply_mailbox) as needed.

    if ($deleteResult) {
        // Redirect back to the inbox after successful deletion
        header("Location: inbox-mail.php");
        exit();
    } else {
        // Handle errors, you can customize this part based on your needs
        echo "Error deleting message.";
    }
}
?>
