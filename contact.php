<?php

require_once 'db.php';

$errors = [];

$fullName = "";

// KERKESE - work with files fsize , fopen, fclose
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    $file_path = 'users.txt';
    $handle = fopen($file_path, 'r');

    if ($handle) {
        $file_contents = fread($handle, filesize($file_path));
        fclose($handle);

        $logged_in_emails = explode("\n", $file_contents);
        $entered_email = $_POST['contact-email'];

        if (!in_array($entered_email, $logged_in_emails)) {
            $errors[] = "You are not authorized to use this email address.";
        }
    } else {
        $errors[] = "Error: Unable to open file.";
    }

    if (empty($errors)) {
        $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        //-----------------------------------------------------------------------------------
        //perdorimi i funksioneve me referenca----> kerkese
        //percjellja e vlerave permes referencave -----> kerkese
        function modifyAndValidateData(&$name, &$email, &$company, &$message, &$errors) {
            // Convert name and company to uppercase
            $name = strtoupper($name);
            $company = strtoupper($company);

            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format.";
            }

            // Wrap message to 70 characters per line
            $message = wordwrap($message, 70);

            // Check message length
            if (strlen($message) > 800) {
                $errors[] = "Message is too long. Maximum length is 800 characters.";
            }
        }

        // Retrieve form data
        $name = $_POST['name'];
        $email = $_POST['contact-email'];
        $company = $_POST['company'];
        $message = $_POST['message'];

        // Modify and validate data
        modifyAndValidateData($name, $email, $company, $message, $errors);

        if (empty($errors)) {
            $stmt = $conn->prepare("INSERT INTO contact (name, email, company, message) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $company, $message);

            if ($stmt->execute()) {
                // Log email details 
                $to = $email;
                $subject = "Contact Form Submission";
                $body = "Name: $name\nCompany: $company\nMessage: $message";
                $headers = "From: webmaster@example.com";

                // Log email details
                error_log("Email details:\nTo: $to\nSubject: $subject\nBody: $body\nHeaders: $headers");

                header("Location: homepage.php");
                exit();
            } else {
                error_log("Error: " . $stmt->error);
                $errors[] = "Error inserting data. Please try again later.";
            }

            $stmt->close();
        }

        $conn->close();
    }
}

// Display errors as alerts
if (!empty($errors)) {
    echo "<script>";
    foreach ($errors as $error) {
        echo "alert('$error');";
    }
    echo "window.location.href = 'homepage.php';"; 
    echo "</script>";
    exit(); 
}
?>
