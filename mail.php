<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once 'conf.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: Invalid email format. Please go back and try again.");
    }
    
    // Store user data in the session
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USERNAME;
        $mail->Password   = SMTP_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = SMTP_PORT;

        $mail->setFrom(SMTP_USERNAME, 'Systems Admin');
        $mail->addAddress($email, $name);
        $mail->isHTML(true);
        $mail->Subject = 'Complete Your ICS 2.2 Registration';
        $mail->Body    = '
            Hello ' . htmlspecialchars($name) . ',<br><br>
            Please click on the link below to continue your registration:<br><br>
            <a href="http://localhost/IAP/iap/registration_page.php">Click Here to Continue Registration</a><br><br>
            Regards,<br>Systems Admin
        ';

        $mail->send();
        echo 'A verification email has been sent. Please check your inbox.';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request method.";
}
?>