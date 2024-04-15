<?php
session_start();

// Verifikimi i të dhënave të postimit kur forma dërgohet
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['login-form-email'];
    $password = $_POST['login-form-password'];

    // Kontrolli i të dhënave të postimit
    if (empty($email) || empty($password)) {
        echo "Email and password are required";
    } else {
        // Kontrollo nëse përdoruesi ekziston dhe fjalëkalimi është i saktë
        if (authenticateUser($email, $password)) {
            // Ruaj të dhënat e përdoruesit në sesion
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['fullname'] = getUserFullname($email);

            
            if (!isset($_SESSION['login_count'])) {
                $_SESSION['login_count'] = 1;
            } else {
                $_SESSION['login_count']++;
            }



            // Ridrejto përdoruesin pas hyrjes së suksesshme
            header('Location: homepage.php');
            exit;
        } else {
            echo "Invalid email or password";
        }
    }
}

// Funksioni për të verifikuar të dhënat e përdoruesit
function authenticateUser($email, $password) {
    $usersFile = 'user.txt'; // Emri i skedarit ku ruhen të dhënat e përdoruesve

    // Kontrollo nëse skedari ekziston dhe përmban të dhëna për emailin dhe fjalëkalimin e dhënë
    if (file_exists($usersFile)) {
        $fileContents = file_get_contents($usersFile);
        $lines = explode("\n", $fileContents);
        foreach ($lines as $line) {
            $userData = explode("|", $line);
            if (count($userData) === 3 && $userData[1] === $email && password_verify($password, $userData[2])) {
                return true; // Emaili dhe fjalëkalimi përputhen në skedar
            }
        }
    }

    return false; // Emaili dhe fjalëkalimi nuk përputhen në skedar ose skedari nuk ekziston
}

// Funksioni për të marrë emrin e plotë të përdoruesit nga emaili
function getUserFullname($email) {
    $usersFile = 'user.txt'; // Emri i skedarit ku ruhen të dhënat e përdoruesve

    // Kontrollo nëse skedari ekziston dhe përmban të dhëna për emailin e dhënë
    if (file_exists($usersFile)) {
        $fileContents = file_get_contents($usersFile);
        $lines = explode("\n", $fileContents);
        foreach ($lines as $line) {
            $userData = explode("|", $line);
            if (count($userData) === 3 && $userData[1] === $email) {
                return $userData[0]; // Kthe emrin e plotë të përdoruesit
            }
        }
    }

    return ''; // Nëse emaili nuk gjendet në skedar ose skedari nuk ekziston
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