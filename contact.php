<?php
// Include database connection parameters from config.php
require_once 'db.php';

// Initialize errors array
$errors = [];

// Set the cookie first (if needed)
$fullName = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Read the file containing logged-in user's emails
    $file_path = 'users.txt';

    // Check if the file exists
    if (file_exists($file_path)) {
        // Read the file contents into an array
        $logged_in_emails = file($file_path, FILE_IGNORE_NEW_LINES);

        // Get the entered email from the form
        $entered_email = $_POST['contact-email'];

        // Check if the entered email exists in the list of logged-in emails
        if (!in_array($entered_email, $logged_in_emails)) {
            // If the entered email doesn't exist, add an error message
            $errors[] = "You are not authorized to use this email address.";
        }
    } else {
        // Error opening file
        $errors[] = "Error: Unable to open file.";
    }

    // Continue processing only if there are no errors
    if (empty($errors)) {
        // Create database connection using information from config.php
        $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Sanitize and validate contact form data
        $fullName = mysqli_real_escape_string($conn, $_POST["contact-name"]);
        $name = strtoupper(mysqli_real_escape_string($conn, $_POST["contact-name"]));
        $email = mysqli_real_escape_string($conn, $_POST["contact-email"]);
        $company = strtoupper(mysqli_real_escape_string($conn, $_POST["contact-company"]));
        $message = wordwrap(mysqli_real_escape_string($conn, $_POST["contact-message"]), 70);

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        // Check if company is empty and set a default value
        if (empty($company)) {
            $company = "NO COMPANY";
        }

        // Check message length
        if (strlen($message) > 1000) {
            $errors[] = "Message is too long. Maximum length is 1000 characters.";
        }

        // If there are no errors, proceed with inserting data
        if (empty($errors)) {
            // Prepare the SQL statement using a prepared statement
            $stmt = $conn->prepare("INSERT INTO contact (name, email, company, message) VALUES (?, ?, ?, ?)");

            // Bind parameters to the prepared statement
            $stmt->bind_param("ssss", $name, $email, $company, $message);

            // Execute the prepared statement
            if ($stmt->execute()) {
                // Redirect back to homepage if insert is successful
                header("Location: homepage.php");
                exit();
            } else {
                // Log error
                error_log("Error: " . $stmt->error);
                $errors[] = "Error inserting data. Please try again later.";
            }

            // Close the statement
            $stmt->close();
        }

        // Close database connection
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
