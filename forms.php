<?php

// Include the database connection file
require_once 'db.php';

// Function to modify and validate form data by reference
function modifyAndValidateData(&$name, &$email, &$phone, &$company, &$message, &$errors) {
    // Convert name and company to uppercase
    $name = strtoupper($name);
    $company = strtoupper($company);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate phone number (basic validation)
    if (!preg_match("/^\+383[0-9]{8,13}$/", $phone)) {
        $errors[] = "Invalid phone number. Must start with +383 and be between 8 and 13 digits.";
    }

    // Wrap message to 70 characters per line
    $message = wordwrap($message, 70);

    // Check message length
    if (strlen($message) > 800) {
        $errors[] = "Message is too long. Maximum length is 800 characters.";
    }
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitform"])) {
    // Start the session to access session variables
    session_start();

    // Establish database connection
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the file exists and handle file operations
    $file_path = 'users.txt';
    if (file_exists($file_path)) {
        $handle = fopen($file_path, 'r');
        if ($handle) {
            $file_size = filesize($file_path);

            if ($file_size === false) {
                $errors[] = "Error: Unable to get the size of the file.";
            } else {
                $file_contents = fread($handle, $file_size);

                $logged_in_emails = explode("\n", $file_contents);

                $entered_email = $_POST['volunteer-email'];

                if (!in_array($entered_email, $logged_in_emails)) {
                    $errors[] = "You are not authorized to use this email address.";
                }
            }

            fclose($handle);
        } else {
            $errors[] = "Error: Unable to open file.";
        }
    } else {
        $errors[] = "Error: File not found.";
    }

    // If there are no errors so far, proceed with form data validation and insertion
    if (empty($errors)) {
        // Prepare and bind parameters for database insertion
        $stmt = $conn->prepare("INSERT INTO volunteers (name, email, phone, company, message, user_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $name, $email, $phone, $company, $message, $user_id);

        // Sanitize and validate form data
        $name = strtoupper(mysqli_real_escape_string($conn, $_POST["volunteer-name"]));
        $email = mysqli_real_escape_string($conn, $_POST["volunteer-email"]);
        $phone = mysqli_real_escape_string($conn, $_POST["volunteer-phone"]);
        $company = strtoupper(mysqli_real_escape_string($conn, $_POST["volunteer-company"]));
        $message = mysqli_real_escape_string($conn, $_POST["volunteer-message"]);

        // Retrieve user_id from session
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        // Call the modifyAndValidateData function to process data
        $errors = [];
        modifyAndValidateData($name, $email, $phone, $company, $message, $errors);

        // If there are no validation errors, execute the database insertion
        if (empty($errors)) {
            if ($stmt->execute()) {
                // Redirect to homepage if insertion is successful
                header("Location: homepage.php");
                exit();
            } else {
                // Log database insertion error
                error_log("Error: " . $stmt->error);
            }
        }
    }
    $conn->close();

    // Handle errors by displaying alerts and redirecting back
    if (!empty($errors)) {
        echo "<script>";
        foreach ($errors as $error) {
            echo "alert('$error');";
        }
        echo "window.history.back();"; // Redirect back to the referring page
        echo "</script>";
        exit(); // Stop further execution of PHP code
    }
}

?>
