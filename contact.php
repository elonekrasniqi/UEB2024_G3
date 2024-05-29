<?php

ob_start(); // Fillon buferimin e output-it

require_once 'db.php';
require 'C:\xampp\htdocs\UEB2024_G3\vendor\autoload.php'; // Përfshin autoload-in e Composer-it

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$errors = []; // Deklaro varg për të mbajtur gabimet

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $file_path = 'users.txt';
    $handle = fopen($file_path, 'r');

    if ($handle) {
        $file_contents = fread($handle, filesize($file_path));
        fclose($handle);

        $logged_in_emails = explode("\n", $file_contents);
        $entered_email = $_POST['contact-email'];

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
        $errors[] = "Error: Unable to open file.";
    }

    if (empty($errors)) {
        $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        function modifyAndValidateData(&$name, &$email, &$company, &$message, &$errors) {
            $name = strtoupper($name);
            $company = strtoupper($company);

            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = urlencode("Invalid email format.");
            }

            // Wrap message to 70 characters per line
            $message = wordwrap($message, 70);

            // Check message length
            if (strlen($message) > 800) {
                $errors[] = urlencode("Message is too long. Maximum length is 800 characters.");
            }
        }

        $name = $_POST['contact-name'];
        $email = $_POST['contact-email'];
        $company = $_POST['contact-company'];
        $message = $_POST['contact-message'];

        // Modify and validate data
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

                    // Marrësit
                    $mail->setFrom('no-reply@gmail.com', 'Mailer');
                    $mail->addAddress($recipient);             // Shton një marrës
                    $mail->addReplyTo('info_sunnyhill@gmail.com', 'Information');
                    $mail->addCC('cc@gmail.com');
                    $mail->addBCC('bcc@gmail.com');

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
                error_log("Error: " . $stmt->error);
                $errors[] = "Error inserting data. Please try again later.";
            }

            $stmt->close();
        }

        $conn->close();
    }
}

if (!empty($errors)) {
    // Krijimi i një vargu me mesazhet e gabimeve
    $errorMessages = [];
    foreach ($errors as $error) {
        $errorMessages[] = "alert('{$error}');";
    }
    $errorString = implode(' ', $errorMessages);

    // Përdorimi i JavaScript për të shfaqur alertat me mesazhet e gabimeve
    echo "<script>{$errorString} window.location.href = 'homepage.php';</script>";

    exit();
}

ob_end_flush(); // Përfundon buferimin e output-it dhe pastron output-in
