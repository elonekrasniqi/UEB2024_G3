<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "2302";
$dbname = "projektiueb";

// Initialize errors array
$errors = [];

// Set the cookie first
$fullName = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $fullName = mysqli_real_escape_string($conn, $_POST["contact-name"]);
    
    // Sanitize and validate contact form data
    $name = mysqli_real_escape_string($conn, $_POST["contact-name"]);
    $email = mysqli_real_escape_string($conn, $_POST["contact-email"]);
    $company = mysqli_real_escape_string($conn, $_POST["contact-company"]);
    $message = mysqli_real_escape_string($conn, $_POST["contact-message"]);

    // Call the function to modify and validate data
    if (!function_exists('modifyAndValidateData')) {
        function modifyAndValidateData(&$name, &$email, &$company, &$message, &$errors) {
            // Convert name and company to uppercase
            $name = strtoupper($name);
            $company = strtoupper($company);

            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format.";
            }

            // Check if company is empty and set a default value
            if (empty($company)) {
                $company = "NO COMPANY";
            }

            // Wrap message to 70 characters per line
            $message = wordwrap($message, 70);

            // Check message length
            if (strlen($message) > 1000) {
                $errors[] = "Message is too long. Maximum length is 1000 characters.";
            }
        }
    }

    // Call the function to modify and validate data
    modifyAndValidateData($name, $email, $company, $message, $errors);

    // Call the function to log contact data
    if (!function_exists('logContactData')) {
        function logContactData(&$name, &$email, &$company, &$message) {
            $logMessage = "Name: $name, Email: $email, Company: $company, Message: $message";
            error_log($logMessage);
        }
    }
    logContactData($name, $email, $company, $message);

    // Check if there are any errors
    if (empty($errors)) {
        // Insert data into contact table
        $sql = "INSERT INTO contact (name, email, company, message) VALUES ('$name', '$email', '$company', '$message')";

        if ($conn->query($sql) !== TRUE) {
            // Log error
            error_log("Error: " . $sql . "<br>" . $conn->error);
        } else {
            // Redirect back to homepage
            header("Location: homepage.php");
            exit();
        }
    }

    // Close database connection
    $conn->close();
}

// Display errors if any
if (!empty($errors)) {
    echo "<script>";
    foreach ($errors as $error) {
        echo "alert('$error');";
    }
    echo "</script>";
} 
?>
