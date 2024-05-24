<?php

require_once 'db.php';

// Function to modify and validate data using references
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
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //KERKESE - work with files fsize , fopen, fclose
    $file_path = 'users.txt';

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

    
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO volunteers (name, email, phone, company, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $company, $message);

        $name = strtoupper(mysqli_real_escape_string($conn, $_POST["volunteer-name"]));
        $email = mysqli_real_escape_string($conn, $_POST["volunteer-email"]);
        $phone = mysqli_real_escape_string($conn, $_POST["volunteer-phone"]);
        $company = strtoupper(mysqli_real_escape_string($conn, $_POST["volunteer-company"]));
        $message = mysqli_real_escape_string($conn, $_POST["volunteer-message"]);

        
        $errors = [];

        modifyAndValidateData($name, $email, $phone, $company, $message, $errors);

        if (empty($errors)) {
            // Execute the prepared statement to insert data into volunteers table
            if ($stmt->execute()) {
                // Redirect to homepage if insertion is successful
                header("Location: homepage.php");
                exit();
            } else {
                // Log error
                error_log("Error: " . $stmt->error);
            }
        }
    }
    $conn->close();

    // Handle errors (e.g., display to user as alerts)
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
