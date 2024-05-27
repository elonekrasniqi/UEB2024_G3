
<?php
//Përdorimi i AJAX-it për lexim dhe update-im nga një DB
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'db.php';

function handleError($errno, $errstr, $errfile, $errline) {
    $errorMessage = "Error on line $errline in $errfile: $errstr";
    error_log($errorMessage);
    echo "Error occurred: $errorMessage";
}

set_error_handler("handleError", E_USER_ERROR);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['signup-form-fullname']);
    $email = trim($_POST['signup-form-email']);
    
    $emailPattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';

    try {
        if (!preg_match($emailPattern, $email)) {
            throw new Exception("Invalid email address");
        } else {
            $password = trim($_POST['signup-form-password']);
            $confirmPassword = trim($_POST['signup-form-confirm-password']);

            if ($password !== $confirmPassword) {
                throw new Exception("Passwords do not match");
            } elseif (!validatePassword($password)) {
                throw new Exception("Invalid password format");
            } else {
                if (checkEmailExists($email)) {
                    throw new Exception("User with this email already exists, please login");
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

                    if ($conn->connect_error) {
                        throw new Exception("Connection failed: " . $conn->connect_error);
                    }

                    $stmt = $conn->prepare("INSERT INTO tblusers (name, email, password) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $fullname, $email, $hashedPassword);
                    $stmt->execute();
                    $stmt->close();
                    $conn->close();

                    echo "Signup successful";
                }
            }
        }
    } catch (Exception $e) {
        handleError(E_USER_ERROR, $e->getMessage(), $e->getFile(), $e->getLine());
    }
}

function validatePassword($password) {
    if (strlen($password) < 8) {
        return false;
    }

    if (!preg_match('/[A-Z]/', $password)) {
        return false;
    }

    if (!preg_match('/[a-z]/', $password)) {
        return false;
    }

    if (!preg_match('/\d/', $password)) {
        return false;
    }

    if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)) {
        return false;
    }

    return true;
}

function checkEmailExists($email) {
    global $dbHost, $dbUser, $dbPass, $dbName;
    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

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
