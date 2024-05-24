<?php
// Include database connection parameters from config.php
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

        $fullName = mysqli_real_escape_string($conn, $_POST["contact-name"]);
        $name = strtoupper(mysqli_real_escape_string($conn, $_POST["contact-name"]));
        $email = mysqli_real_escape_string($conn, $_POST["contact-email"]);
        $company = strtoupper(mysqli_real_escape_string($conn, $_POST["contact-company"]));
        $message = wordwrap(mysqli_real_escape_string($conn, $_POST["contact-message"]), 70);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        if (empty($company)) {
            $company = "NO COMPANY";
        }

        if (strlen($message) > 1000) {
            $errors[] = "Message is too long. Maximum length is 1000 characters.";
        }

        if (empty($errors)) {
            $stmt = $conn->prepare("INSERT INTO contact (name, email, company, message) VALUES (?, ?, ?, ?)");

            $stmt->bind_param("ssss", $name, $email, $company, $message);

            if ($stmt->execute()) {
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
    echo "window.location.href = 'homepage.php';"; // Redirect to homepage
    echo "</script>";
    exit(); // Stop further execution of PHP code
}
?>
