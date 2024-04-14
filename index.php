<?php
session_start();

// Verifikimi i emailit përmes RegEx nga ana e serverit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['login-form-email'];
    
    $emailPattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';

    if (!preg_match($emailPattern, $email)) {
        echo "Invalid email address";
    } else {
        $password = $_POST['login-form-password'];

        // Perform further processing
        if (authenticateUser($email, $password)) {
            $_SESSION['loggedin'] = true; // Set session variable upon successful login
            echo "<script>alert('Login successful!'); window.location.href = 'homepage.php';</script>";
            exit();
        } else {
            echo "Invalid credentials";
        }
    }
}

// Funksioni për të verifikuar kredencialet e përdoruesit
function authenticateUser($email, $password) {
    $usersFile = 'user.txt'; // Emri i skedarit ku ruhen emrat e përdoruesve

    // Lexo përmbajtjen e skedarit dhe kërko për emailin dhe fjalëkalimin
    if (file_exists($usersFile)) {
        $fileContents = file_get_contents($usersFile);
        $lines = explode("\n", $fileContents);
        foreach ($lines as $line) {
            $userData = explode("|", $line);
            if (count($userData) === 2 && $userData[0] === $email && password_verify($password, $userData[1])) {
                return true; // Kredencialet janë të sakta
            }
        }
    }

    return false; // Kredencialet nuk janë gjetur ose skedari nuk ekziston
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


          
            <section class="ticket-section section-padding">
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


        
        <footer class="site-footer">
            <div class="site-footer-top">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-12">
                            <h2 class="text-white mb-lg-0">Sunny Hill Festival</h2>
                        </div>

                        <div class="col-lg-6 col-12 d-flex justify-content-lg-end align-items-center">
                            <ul class="social-icon d-flex justify-content-lg-end">
                               
                                <li class="social-icon-item">
                                    <a href="https://www.instagram.com/sunnyhillfestival/" class="social-icon-link">
                                        <span class="bi-instagram"></span>
                                    </a>
                                </li>

                                <li class="social-icon-item">
                                    <a href="http://www.youtube.com/@SunnyHillFestival" class="social-icon-link">
                                        <span class="bi-youtube"></span>
                                    </a>
                                </li>

                                <li class="social-icon-item">
                                    <a href="mailto:info@sunnyhillfestival.com" class="social-icon-link">
                                        <span class="bi-google"></span>
                                    </a>
                                </li>
                            
                                <li class="social-icon-item">
                                    <a href="https://www.facebook.com/sunnyhillfestival" class="social-icon-link">
                                        <span class="bi-facebook"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>



        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/custom.js"></script>

    </body>
</html>