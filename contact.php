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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submit"])) {
        // Sanitize and validate contact form data
        $name = mysqli_real_escape_string($conn, $_POST["contact-name"]);
        $email = mysqli_real_escape_string($conn, $_POST["contact-email"]);
        $company = mysqli_real_escape_string($conn, $_POST["contact-company"]);
        $message = mysqli_real_escape_string($conn, $_POST["contact-message"]);

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
}

// Close database connection
$conn->close();
?>
