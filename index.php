<?php
session_start();
require_once 'db.php'; // Përfshi parametrat e lidhjes së bazës së të dhënave

function connectToDatabase() {
    global $dbHost, $dbUser, $dbPass, $dbName;
    try {
        $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
        if ($conn->connect_error) {
            throw new Exception($conn->connect_error, $conn->connect_errno);
        }
        return $conn;
    } catch (Exception $e) {
        handleDatabaseError($e->getCode(), $e->getMessage());
        return null;
    }
}

function handleDatabaseError($errno, $errstr) {
    $error_message = "Gabim në Lidhjen me Bazën e të Dhënave [$errno]: $errstr";
    error_log($error_message . PHP_EOL, 3, 'database_errors.log');
    echo "<script>alert('Ndodhi një gabim me bazën e të dhënave. Ju lutemi provoni përsëri më vonë.');</script>";
}


function verifyCredentials(&$email, &$password, &$conn) {
    // Për të siguruar që ndryshimet në $email reflektohen jashtë funksionit
    $email = trim($email);
    $password = trim($password);

    $stmt = $conn->prepare("SELECT * FROM tblusers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            return $row;
        }
    }
    return null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['login-form-email'];
    $password = $_POST['login-form-password'];

    if (empty($email) || empty($password)) {
        echo "Emaili dhe fjalëkalimi janë të detyrueshëm";
    } else {
        $conn = connectToDatabase();
        if ($conn) {
            $user = verifyCredentials($email, $password, $conn);

            if ($user) {
                $_SESSION['loggedin'] = true;
                $_SESSION['user'] = $user; 
                $_SESSION['name'] = $user['name']; 

                if (!isset($_SESSION['login_count'])) {
                    $_SESSION['login_count'] = 1;
                } else {
                    $_SESSION['login_count']++;
                }

                $file = fopen("users.txt", "a") or die("Unable to open file!");
                fwrite($file, $email . "\n");
                fclose($file);

                header('Location: homepage.php');
                exit;
            } else {
                echo '<script>alert("Invalid email or password");</script>';
            }
            $conn->close();
        }
    }
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
    <title>Sunny Hill - Log in</title>
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

    <nav class="navbar navbar-expand-lg">
        <div class="container"></div>
    </nav>

    <section class="ticket-section section-padding" style="height:677px">
        <div class="section-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-10 mx-auto">
                    <form class="custom-form login-form mb-5 mb-lg-0" action="#" method="post" role="form" onsubmit="return validateForm();">
                        <h2 class="text-center mb-4">Login</h2>
                        <div class="login-form-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="email" name="login-form-email" id="login-form-email" class="form-control" placeholder="Email address" required>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <input type="password" class="form-control" name="login-form-password" id="login-form-password" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <button type="submit" class="form-control">Login</button>
                                </div>
                            </div>
                            <div class="row mt-3" style="color: white;">
                                <div class="col-lg-12 text-center">
                                    <span>Don't have an account?</span> <a href="signup.php">Sign Up</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            function validateForm() {
                var email = document.getElementById('login-form-email').value;
                var password = document.getElementById('login-form-password').value;
                var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

                if (!emailPattern.test(email)) {
                    alert("Invalid email address");
                    return false;
                }

                return true;
            }
        </script>
    </section>
</main>

<!-- JAVASCRIPT FILES -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.sticky.js"></script>
<script src="js/custom.js"></script>
</body>
</html>