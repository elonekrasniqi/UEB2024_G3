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

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submitform"])) {
        // Sanitize and validate volunteer form data
        $name = mysqli_real_escape_string($conn, $_POST["volunteer-name"]);
        $email = mysqli_real_escape_string($conn, $_POST["volunteer-email"]);
        $phone = mysqli_real_escape_string($conn, $_POST["volunteer-phone"]);
        $company = mysqli_real_escape_string($conn, $_POST["volunteer-company"]);
        $message = mysqli_real_escape_string($conn, $_POST["volunteer-message"]);

        // Insert data into volunteers table
        $sql = "INSERT INTO volunteers (name, email, phone, company, message) VALUES ('$name', '$email', '$phone', '$company', '$message')";

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
