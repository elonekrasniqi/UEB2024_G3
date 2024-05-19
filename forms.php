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

// Kerkesa: Përdorimi i funksioneve me referencë
function modifyData(&$name, &$email, &$phone, &$company, &$message, &$messageLength) {
    $name = strtoupper($name); // Convert name to uppercase
    $company = strtoupper($company); // Convert company to uppercase
    $message = wordwrap($message, 70); // Wrap message to 70 characters per line
    
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

    

        // Call the function to modify data
        modifyData($name, $email, $phone, $company, $message);

        // Insert data into volunteers table
        $sql = "INSERT INTO volunteers (name, email, phone, company, message) VALUES ('$name', '$email', '$phone', '$company', '$message')";

        if ($conn->query($sql) !== TRUE) {
            // Log error
            error_log("Error: " . $sql . "<br>" . $conn->error);
        }
            
            header("Location: homepage.php");
            exit(); 
        }
    }


// Close database connection
$conn->close();
?>
