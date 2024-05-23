<?php
session_start();
require_once 'db.php'; // Përfshi parametrat e lidhjes së bazës së të dhënave

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['login-form-email']);
    $password = trim($_POST['login-form-password']);

    if (empty($email) || empty($password)) {
        echo "Emaili dhe fjalëkalimi janë të detyrueshëm";
    } else {
        if (authenticateUser($email, $password)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['fullname'] = getUserFullname($email);
            $_SESSION['login_count'] = isset($_SESSION['login_count']) ? $_SESSION['login_count'] + 1 : 1;

            header('Location: homepage.php');
            exit;
        } else {
            echo '<script>alert("Emaili ose fjalëkalimi i pavlefshëm");</script>';
        }
    }
}

// Funksioni për të verifikuar të dhënat e përdoruesit nga tabela e përdoruesve në bazën e të dhënave
function authenticateUser($email, $password) {
    global $dbHost, $dbUser, $dbPass, $dbName; // Referencat po përdoren këtu për parametrat e lidhjes së bazës së të dhënave

    try {
        $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM tblusers WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return true;
        }
    } catch(PDOException $e) {
        die("Lidhja dështoi: " . $e->getMessage());
    }

    return false;
}

// Funksioni për të marrë emrin e plotë të përdoruesit nga tabela e përdoruesve
function getUserFullname($email) {
    global $dbHost, $dbUser, $dbPass, $dbName; // Referencat po përdoren këtu për parametrat e lidhjes së bazës së të dhënave

    try {
        $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT name FROM tblusers WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ? $user['name'] : 'false';
    } catch(PDOException $e) {
        die("Lidhja dështoi: " . $e->getMessage());
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
                <div class="container">

                </div>
            </nav>


            <section class="ticket-section section-padding" style="height:677px">
                <div class="section-overlay"></div>
            
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-10 mx-auto">
                            <form class="custom-form login-form mb-5 mb-lg-0" action="#" method="post" role="form">
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
                //validimi i emailit nga ana e klientit
                  function validateForm() {
                     var email = document.getElementById('login-form-email').value;
                     var emailPattern = /^\w+([\.-]?\w+)@\w+([\.-]?\w+)(\.\w{2,3})+$/;
                         if (!emailPattern.test(email)) {
                              alert("Invalid email address");
                              return false;
                         }
                         return true;
                   }
                   function validateForm() {
                                    var email = document.getElementById('login-form-email').value;
                                    var password = document.getElementById('login-form-password').value;
                                    var emailPattern = /^\w+([\.-]?\w+)@\w+([\.-]?\w+)(\.\w{2,3})+$/;

                                    if (!emailPattern.test(email)) {
                                        alert("Invalid email address");
                                        return false;
                                    }

                                    // Additional validation if needed (e.g., password length)

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