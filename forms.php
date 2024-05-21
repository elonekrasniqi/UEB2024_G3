<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "2302";
$dbname = "projektiueb";

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
    if (strlen($message) > 1000) {
        $errors[] = "Message is too long. Maximum length is 1000 characters.";
    }
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submitform"])) {
        // Read the file containing logged-in user's emails
        $file_path = 'users.txt';

        // Open the file for reading
        $handle = fopen($file_path, 'r');

        // Check if the file opened successfully
        if ($handle) {
            // Get the size of the file
            $file_size = filesize($file_path);

            // Check if file size retrieval was successful
            if ($file_size === false) {
                // Error accessing file size
                $errors[] = "Error: Unable to get the size of the file.";
            } else {
                // Read the file contents into a string
                $file_contents = fread($handle, $file_size);

                // Convert file contents to an array of emails
                $logged_in_emails = explode("\n", $file_contents);

                $entered_email = $_POST['volunteer-email'];

                // Check if the entered email exists in the list of logged-in emails
                if (!in_array($entered_email, $logged_in_emails)) {
                    // If the entered email doesn't exist, add an error message
                    $errors[] = "You are not authorized to use this email address.";

                    // Redirect back to the referring page
                    echo "<script>alert('You are not authorized to use this email address.'); window.history.back();</script>";
                    exit();
                }
            }

            // Close the file handle
            fclose($handle);
        } else {
            // Error opening file
            $errors[] = "Error: Unable to open file.";
        }

        // Continue processing only if there are no errors
        if (empty($errors)) {
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Sanitize and validate volunteer form data
            $name = mysqli_real_escape_string($conn, $_POST["volunteer-name"]);
            $email = mysqli_real_escape_string($conn, $_POST["volunteer-email"]);
            $phone = mysqli_real_escape_string($conn, $_POST["volunteer-phone"]);
            $company = mysqli_real_escape_string($conn, $_POST["volunteer-company"]);
            $message = mysqli_real_escape_string($conn, $_POST["volunteer-message"]);

            // Initialize errors array
            $errors = [];

            // Call the function to modify and validate data
            modifyAndValidateData($name, $email, $phone, $company, $message, $errors);

            // Check if there are any errors
            if (empty($errors)) {
                // Insert data into volunteers table
                $sql = "INSERT INTO volunteers (name, email, phone, company, message) VALUES ('$name', '$email', '$phone', '$company', '$message')";

                if ($conn->query($sql) !== TRUE) {
                    // Log error
                    error_log("Error: " . $sql . "<br>" . $conn->error);
                }

                header("Location: homepage.php");
                exit();
            } else {
                // Handle errors (e.g., display to user as alerts)
                echo "<script>";
                foreach ($errors as $error) {
                    echo "alert('$error');";
                }
                echo "</script>";

                // Redirect back to the referring page
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }

            // Close database connection
            $conn->close();
        }
    }
}
?>
