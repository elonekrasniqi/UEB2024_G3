<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "2302";
$dbname = "projektiueb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
        }
    }
}

// Close database connection
$conn->close();
?>
