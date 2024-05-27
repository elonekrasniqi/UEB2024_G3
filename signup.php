<?php
ini_set('display_errors', 1);
// Enable error reporting
error_reporting(E_ALL);

require_once 'db.php';

// Function to handle errors
function handleError($errno, $errstr, $errfile, $errline) {
    $errorMessage = "Error on line $errline in $errfile: $errstr";
    error_log($errorMessage);
    echo "Error occurred: $errorMessage";
}

// Set custom error handler to handle E_USER_ERROR
set_error_handler("handleError", E_USER_ERROR);

// Validate email address format using RegEx on the server side
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['signup-form-fullname']);
    $email = trim($_POST['signup-form-email']);
    
    $emailPattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';

    try {
        // Validate email format
        if (!preg_match($emailPattern, $email)) {
            throw new Exception("Invalid email address");
        } else {
            $password = trim($_POST['signup-form-password']);
            $confirmPassword = trim($_POST['signup-form-confirm-password']);

            // Validate password
            if ($password !== $confirmPassword) {
                throw new Exception("Passwords do not match");
            } elseif (!validatePassword($password)) {
                throw new Exception("Invalid password format");
            } else {
                // Check if email already exists in the database
                if (checkEmailExists($email)) {
                    throw new Exception("User with this email already exists, please login");
                } else {
                    // Hash the password using password_hash
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // Establish database connection
                    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

                    // Check connection
                    if ($conn->connect_error) {
                        throw new Exception("Connection failed: " . $conn->connect_error);
                    }

                    // Insert user into database
                    $stmt = $conn->prepare("INSERT INTO tblusers (name, email, password) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $fullname, $email, $hashedPassword);
                    $stmt->execute();
                    $stmt->close();
                    $conn->close();

                    echo "<script>alert('Signup successful'); window.location.href ='index.php' </script>";
                }
            }
        }
    } catch (Exception $e) {
        // Handle the exception
        handleError(E_USER_ERROR, $e->getMessage(), $e->getFile(), $e->getLine());
    }
}

// Function to validate password format
function validatePassword(&$password) {
    // Check password length
    if (strlen($password) < 8) {
        return false;
    }

    // Check for uppercase letters
    if (!preg_match('/[A-Z]/', $password)) {
        return false;
    }

    // Check for lowercase letters
    if (!preg_match('/[a-z]/', $password)) {
        return false;
    }

    // Check for numbers
    if (!preg_match('/\d/', $password)) {
        return false;
    }

    // Check for special characters
    if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)) {
        return false;
    }

    return true;
}

// Function to check if email exists in the database
function checkEmailExists($email) {
    global $dbHost, $dbUser, $dbPass, $dbName;
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Check if email exists in the users table
    $stmt = $conn->prepare("SELECT email FROM tblusers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows;
    $stmt->close();
    $conn->close();

    return $count > 0;
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="images/sunny-hill-festival-logo.png" type="image/x-icon">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Sunny Hill - Sign up</title>

        <!-- CSS FILES -->    
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;400;700&display=swap" rel="stylesheet">
                
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href="css/bootstrap-icons.css" rel="stylesheet">

        <link href="css/festival.css" rel="stylesheet">

    </head>
    
    <body>

        <main>

            <header class="site-header">
                <div class="container">
                    <div class="row">
                        
                        <div class="col-lg-12 col-12 d-flex flex-wrap">
                            <p class="d-flex me-4 mb-0">
                                <i class="bi-person custom-icon me-2"></i>
                                <strong class="text-dark">Welcome to Sunny Hill Festival 2024</strong>
                            </p>
                        </div>

                    </div>
                </div>
            </header>


            <section class="ticket-section section-padding" style="height:677px">
                    <div class="section-overlay"></div>
                
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-10 mx-auto">
                            <form class="custom-form signup-form mb-5 mb-lg-0" action="#" method="post" role="form">
    <h2 class="text-center mb-2">Sign Up</h2>
    <div class="signup-form-body">
        <div class="row">
            <div class="col-lg-12">
                <input type="text" name="signup-form-fullname" id="signup-form-fullname" class="form-control" placeholder="Full Name" required>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <input type="email" name="signup-form-email" id="signup-form-email" class="form-control" placeholder="Email address" required>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <input type="password" class="form-control" name="signup-form-password" id="signup-form-password" placeholder="Password" required>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <input type="password" class="form-control" name="signup-form-confirm-password" id="signup-form-confirm-password" placeholder="Confirm Password" required>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <button type="submit" class="form-control" id="signupButton">Sign Up</button>
            </div>
        </div>
        <div class="row mt-3" style="color: white;">
            <div class="col-lg-12 text-center">
                <span>Already have an account?</span> <a href="index.php">Login</a>
            </div>
        </div>
    </div>
</form>

</div>
</div>
</div>
                
</section>
</main>
        <script>
            //Përdorimi i AJAX-it për lexim dhe update-im nga një DB
          document.getElementById('signupButton').addEventListener('click', function(event) {
          event.preventDefault();

            var fullname = document.getElementById('signup-form-fullname').value;
            var email = document.getElementById('signup-form-email').value;
            var password = document.getElementById('signup-form-password').value;
            var confirmPassword = document.getElementById('signup-form-confirm-password').value;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'signup_ajax.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
            var response = xhr.responseText;
            alert(response);
            }
           };

            xhr.send('signup-form-fullname=' + encodeURIComponent(fullname) +
             '&signup-form-email=' + encodeURIComponent(email) +
             '&signup-form-password=' + encodeURIComponent(password) +
             '&signup-form-confirm-password=' + encodeURIComponent(confirmPassword));
           });
        </script>


        <script src="js/sign-up.js"></script>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/custom.js"></script>
        

</body>
</html>
