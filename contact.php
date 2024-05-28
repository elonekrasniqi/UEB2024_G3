<?php

ob_start(); // Fillon buferimin e output-it

require_once 'db.php';
require 'C:\xampp\htdocs\UEB2024_G3\vendor\autoload.php'; // Përfshin autoload-in e Composer-it

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

        // Përcakton marrësin te email-i i futur nëse është i autorizuar
        $recipient = $entered_email;

        // Kontrollon nëse email-i i marrësit është valid
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

        $name = filter_var($_POST['contact-name'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['contact-email'], FILTER_SANITIZE_EMAIL);
        $company = filter_var($_POST['contact-company'], FILTER_SANITIZE_STRING);
        $message = filter_var($_POST['contact-message'], FILTER_SANITIZE_STRING);

        modifyAndValidateData($name, $email, $company, $message, $errors);

        if (empty($errors)) {
            $stmt = $conn->prepare("INSERT INTO contact (name, email, company, message) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $company, $message);

            if ($stmt->execute()) {
                $mail = new PHPMailer(true);

                try {
                    $mail->SMTPDebug = 0;                      // Çaktivizon output-in e debug-ut të detajuar
                    $mail->isSMTP();                           // Përcakton mailer për të përdorur SMTP
                    $mail->Host       = 'smtp.gmail.com';      // Specifikon serverët kryesorë dhe rezervë SMTP
                    $mail->SMTPAuth   = true;                  // Aktivizon autentifikimin SMTP
                    $mail->Username   = 'projektiueb@gmail.com'; // Emri i përdoruesit SMTP
                    $mail->Password   = 'afjh jufl ixsk mxol'; // Fjalëkalimi SMTP
                    $mail->SMTPSecure = 'tls';                 // Aktivizon enkriptimin TLS, `ssl` gjithashtu pranohet
                    $mail->Port       = 587;                   // Porti TCP për të lidhur

                    // Marrësit
                    $mail->setFrom('no-reply@gmail.com', 'Mailer');
                    $mail->addAddress($recipient);             // Shton një marrës
                    $mail->addReplyTo('info_sunnyhill@gmail.com', 'Information');
                    $mail->addCC('cc@gmail.com');
                    $mail->addBCC('bcc@gmail.com');

                    // Përmbajtja
                    $mail->isHTML(true);                       // Përcakton formatin e email-it në HTML
                    $mail->Subject = "Kontakti";
                    $email_message = "\nFaleminderit qe kontaktuat. Do te ju kthejme pergjigje ne kohen sa me te shkurter.\n";
                    $email_message .= "Here are the details:\nName: $name\n";
                    $email_message .= "Email: $email\nCompany: $company\nMessage:\n$message\n";

                    $mail->Body    = nl2br($email_message);    // Konverton rreshtat e rinj në tag-et <br>
                    $mail->AltBody = $email_message;           // Versioni me tekst të thjeshtë i email-it

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
    $errorString = implode('&', $errors); // Konkatenon të gjitha gabimet
    header("Location: homepage.php?errors=$errorString"); 
    exit(); 
}

ob_end_flush(); // Përfundon buferimin e output-it dhe pastron output-in

?>
