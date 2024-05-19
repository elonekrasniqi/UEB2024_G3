<?php
session_start();

// Database connection function
function connectToDatabase() {
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '2302';
    $dbName = 'projektiueb';

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Verifying form data on form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['login-form-email']);
    $password = trim($_POST['login-form-password']);

    if (empty($email) || empty($password)) {
        echo "Email and password are required";
    } else {
        $conn = connectToDatabase();

        // Prepare and execute the query using prepared statements
        $stmt = $conn->prepare("SELECT * FROM tblusers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();  

        if ($result->num_rows > 0) {
            //Perdorimi i referencave ne vargje
            // Use reference to fetch associative array
            $row = &$result->fetch_assoc(); // Using reference for efficiency

            if (password_verify($password, $row['password'])) {
                //Perdorimi i referencave per ruajtjen e vlerave
                // Store user data in session using references
                $_SESSION['loggedin'] = true;
                $_SESSION['user'] = &$row; // Storing a reference to the user row

                // Use session for login count
                if (!isset($_SESSION['login_count'])) {
                    $_SESSION['login_count'] = 1;
                } else {
                    $_SESSION['login_count']++;
                }

                // Redirect after successful login
                header('Location: homepage.php');
                exit;
            } else {
                echo '<script>alert("Invalid email or password");</script>';
            }
        } else {
            echo '<script>alert("User not found");</script>';
        }

        $stmt->close();
        $conn->close();
    }
}
?>
