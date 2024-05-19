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
        $fullName = $_POST['contact-name'];
        setcookie('contact-name', $fullName, time() + (86400 * 30), "/"); // Cookie expires in 30 days
        echo "<script>alert('Thank you for contacting us, $fullName!');</script>";

    
        //Kerkesa: Përdorimi i funksioneve me referencë
        function modifyData(&$name, &$email, &$company, &$message) {
            $name = strtoupper($name); // Convert name to uppercase
            $company = strtoupper($company); // Convert company to uppercase
            $message = wordwrap($message, 70); // Wrap message to 70 characters per line
        }

        // Call the function to modify data
        modifyData($name, $email, $company, $message);

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
