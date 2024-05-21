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
    // Read the file containing logged-in user's emails
    $file_path = 'users.txt';

    // Open the file for reading
    $handle = fopen($file_path, 'r');

    // Check if the file opened successfully
    if ($handle) {
        // Read the file contents into a string
        $file_contents = fread($handle, filesize($file_path));

        // Close the file handle
        fclose($handle);

        // Convert file contents to an array of emails
        $logged_in_emails = explode("\n", $file_contents);

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
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            header("Location: homepage.php");
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
            }
        }

        // Redirect back to homepage
        header("Location: homepage.php");
        exit();

        // Close database connection
        $conn->close();
    }
}

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
