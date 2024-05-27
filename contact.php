<?php

ob_start(); // Start output buffering

require_once 'db.php';
require 'C:\xampp\htdocs\UEB2024_G3\phpmailer\vendor\autoload.php'; // Include Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $file_path = 'users.txt';
    $handle = fopen($file_path, 'r');

    if ($handle) {
        $file_contents = fread($handle, filesize($file_path));
        fclose($handle);

        $logged_in_emails = array_unique(array_map('trim', explode("\n", $file_contents)));

        $entered_email = trim($_POST['contact-email']);

        if (!in_array($entered_email, $logged_in_emails)) {
            $errors[] = urlencode("You are not authorized to use this email address.");
        }

        // Set the recipient to the entered email if authorized
        $recipient = $entered_email;

        // Check if recipient email is valid
        if (empty($recipient) || !filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            $errors[] = urlencode("Recipient email is not valid.");
        }

    } else {
        $errors[] = urlencode("Error: Unable to open file.");
    }

    if (empty($errors)) {
        $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        function modifyAndValidateData(&$name, &$email, &$company, &$message, &$errors) {
            $name = strtoupper($name);
            $company = strtoupper($company);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = urlencode("Invalid email format.");
            }

            $message = wordwrap($message, 70);

            if (strlen($message) > 800) {
                $errors[] = urlencode("Message is too long. Maximum length is 800 characters.");
            }
        }

        $name = $_POST['contact-name'];
        $email = $_POST['contact-email'];
        $company = $_POST['contact-company'];
        $message = $_POST['contact-message'];

        modifyAndValidateData($name, $email, $company, $message, $errors);

        if (empty($errors)) {
            $stmt = $conn->prepare("INSERT INTO contact (name, email, company, message) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $company, $message);

            if ($stmt->execute()) {
                $mail = new PHPMailer(true);

                try {
                    $mail->SMTPDebug = 0;                      // Disable verbose debug output
                    $mail->isSMTP();                           // Set mailer to use SMTP
                    $mail->Host       = 'smtp.gmail.com';      // Specify main and backup SMTP servers
                    $mail->SMTPAuth   = true;                  // Enable SMTP authentication
                    $mail->Username   = 'projektiueb@gmail.com'; // SMTP username
                    $mail->Password   = 'afjh jufl ixsk mxol'; // SMTP password
                    $mail->SMTPSecure = 'tls';                 // Enable TLS encryption, `ssl` also accepted
                    $mail->Port       = 587;                   // TCP port to connect to

                    //Recipients
                    $mail->setFrom('no-reply@gmail.com', 'Mailer');
                    $mail->addAddress($recipient);             // Add a recipient

                    // Content
                    $mail->isHTML(true);                       // Set email format to HTML
                    $mail->Subject = "Kontakti";
                    $email_message = "\nFaleminderit qe kontaktuat. Do te ju kthejme pergjigje ne kohen sa me te shkurter.\n";
                    $email_message .= "Here are the details:\nName: $name\n";
                    $email_message .= "Email: $email\nCompany: $company\nMessage:\n$message\n";

                    $mail->Body    = nl2br($email_message);    // Convert new lines to <br> tags
                    $mail->AltBody = $email_message;           // Plain text version of the email

                    $mail->send();
                    header("Location: homepage.php?status=success");
                    exit();
                } catch (Exception $e) {
                    $errors[] = urlencode("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                }
            } else {
                $errors[] = urlencode("Error inserting data. Please try again later.");
            }

            $stmt->close();
        }

        $conn->close();
    }
}

if (!empty($errors)) {
    $errorString = implode('&', $errors); // Concatenate all errors
    header("Location: homepage.php?errors=$errorString"); 
    exit(); 
}

ob_end_flush(); // End output buffering and flush the output
?>
