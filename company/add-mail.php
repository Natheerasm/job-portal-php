<?php


session_start();

if (empty($_SESSION['id_company'])) {
	header("Location: ../index.php");
	exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once("../db.php");

if (isset($_POST)) {
	$to  = $_POST['to'];
	$email  = $_POST['email'];
	$subject = mysqli_real_escape_string($conn, $_POST['subject']);
	$message = mysqli_real_escape_string($conn, $_POST['description']);
	//$companyname = $_POST['companyname'];
	$sql = "INSERT INTO mailbox (id_fromuser, fromuser, id_touser, subject, message) VALUES ('$_SESSION[id_company]', 'company', '$to', '$subject', '$message')";

	if ($conn->query($sql) == TRUE) {

		//Load Composer's autoloader
		require '../vendor/autoload.php';

		//Create an instance; passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
			//Server settings
			$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
			$mail->isSMTP();                                            //Send using SMTP
			$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			$mail->Username   = 'natheerasm@gmail.com';                     //SMTP username
			$mail->Password   = 'ppqebsehlfazjksn';                               //SMTP password
			$mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
			$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

			//Recipients
			$mail->setFrom('natheerasm@gmail.com');
			$mail->addAddress($email);
			//$mail->addAddress('asmnatheer@gmail.com');     //Add a recipient
			// $mail->addAddress('ellen@example.com');               //Name is optional
			// $mail->addReplyTo('info@example.com', 'Information');
			// $mail->addCC('cc@example.com');
			// $mail->addBCC('bcc@example.com');

			//Attachments
			// $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
			// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

			//Content
			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = $subject;
			$mail->Body    = $message;
			// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$mail->send();
			echo '<script>';
			echo 'alert("Message has been sent");';
			echo 'window.location.href = "inbox-mail.php";';
			echo '</script>';
			exit();
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	} else {
		echo $conn->error;
	}
} else {
	header("Location: inbox-mail.php");
	exit();
}
