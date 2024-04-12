<?php
session_start();

// Verifikimi i emailit përmes RegEx nga ana e serverit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['signup-form-email'];
    $fullname = $_POST['signup-form-fullname'];
    $password = $_POST['signup-form-password'];
    $confirmPassword = $_POST['signup-form-confirm-password'];
    $emailPattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';

    // Verifikimi i emailit
    if (!preg_match($emailPattern, $email)) {
        echo "Invalid email address";
    } else {
        $password = $_POST['signup-form-password'];
        $confirmPassword = $_POST['signup-form-confirm-password'];

        // Verifikimi i fjalëkalimit
        if ($password !== $confirmPassword) {
            echo "Passwords do not match";
        } elseif (!validatePassword($password)) {
            echo "Invalid password format";
        } else {
            // Kontrollo nëse emaili dhe fjalëkalimi përputhen në skedar
            $userExists = checkUserCredentials($email, $password);
            if ($userExists) {
                echo "User with this email and password already exists, please login";
            } else {
                // Kodimi i fjalëkalimit me password_hash
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Perform further processing, e.g., save user data to a file
                $usersFile = 'users.txt';   // Emri i skedarit ku ruhen emrat e përdoruesve
                file_put_contents($usersFile, $userData, FILE_APPEND); 
              

                $userData = " $fullname| $email|$hashedPassword\n";

                // Ruaj të dhënat e përdoruesit në skedar
                file_put_contents($usersFile, $userData, FILE_APPEND);
                echo "<script>alert('Signup successful');  window.location.href ='login.php' </script>";
            }
        }
    }
}

// Funksioni për të verifikuar fjalëkalimin sipas kritereve

function validatePassword($password) {
    // Kontrollo gjatësinë e fjalëkalimit
    if (strlen($password) < 8) {
        return false;
    }

    // Kontrollo përmbajtjen e karaktereve të fjalëkalimit
    if (!preg_match('/[A-Z]/', $password)) {
        return false; // Nuk ka asnjë shkronjë të madhe
    }

    if (!preg_match('/[a-z]/', $password)) {
        return false; // Nuk ka asnjë shkronjë të vogël
    }

    if (!preg_match('/\d/', $password)) {
        return false; // Nuk ka asnjë numër
    }

    if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)) {
        return false; // Nuk ka asnjë simbol të veçantë
    }

    return true; // Fjalëkalimi është i vlefshëm
}

function checkUserCredentials($email, $password) {
    $usersFile = 'users.txt'; // Emri i skedarit ku ruhen emrat e përdoruesve

    // Kontrollo nëse skedari ekziston dhe përmban të dhëna për emailin dhe fjalëkalimin e dhënë
    if (file_exists($usersFile)) {
        $fileContents = file_get_contents($usersFile);
        $lines = explode("\n", $fileContents);
        foreach ($lines as $line) {
            $userData = explode("|", $line);
            if (count($userData) === 2 && $userData[0] === $email && password_verify($password, $userData[1])) {
                return true; // Emaili dhe fjalëkalimi përputhen në skedar
            }
            // Kontrollo edhe për ekzistencën e emailit në skedar pa përmendur fjalëkalimin
            if (count($userData) >= 1 && $userData[0] === $email) {
                return true; // Emaili ekziston në skedar
            }
        }
    }

    return false; // Emaili dhe fjalëkalimi nuk përputhen në skedar ose skedari nuk ekziston
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


            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand" href="index.html">
                        Sunny Hill
                    </a>

                    <a href="ticket.html" class="btn custom-btn d-lg-none ms-auto me-4">Buy Ticket</a>
    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav align-items-lg-center ms-auto me-lg-5">
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="index.html#section_1">Home</a>
                            </li>
    
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="index.html#section_2">About</a>
                            </li>
    
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="index.html#section_3">Artists</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="index.html#section_4">Schedule</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="index.html#section_5">Pricing</a>
                            </li>
    
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="index.html#section_6">Contact</a>
                            </li>
                        </ul>

                        <a href="login.html" class="btn custom-btn d-lg-block d-none">Buy Ticket</a>
                    </div>
                </div>
            </nav>


            <section class="ticket-section section-padding">
                    <div class="section-overlay"></div>
                
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-10 mx-auto">
                                <form class="custom-form signup-form mb-5 mb-lg-0" action="#" method="post" role="form">
                                    <h2 class="text-center mb-4">Sign Up</h2>
                
                                    <div class="signup-form-body">
                                        <div class="row">
                                        <div class="col-lg-12">
                                        <input type="text" name="signup-form-fullname" id="signup-form-fullname" class="form-control" placeholder="Full Name" required>
                                        </div>
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
                                                <span>Already have an account?</span> <a href="login.php">Login</a>
                                            </div>
                                        </div>
                                        
                                          <script>
                                          //validimi i emailit nga ana e klientit
                                             function validateForm() {
                                                 var email = document.getElementById('login-form-email').value;
                                                 var emailPattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                                                 if (!emailPattern.test(email)) {
                                                     alert("Invalid email address");
                                                         return false;
                                                 }
                                                 return true;
                                             }
                                         </script>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                
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
            <div class="container">
                <div class="row">

                    <div class="col-lg-6 col-12 mb-4 pb-2">
                        <h5 class="site-footer-title mb-3">Links</h5>

                        <ul class="site-footer-links">
                            <li class="site-footer-link-item">
                                <a href="./index.html" class="site-footer-link">Home</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="./index.html#section_2" class="site-footer-link">About</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="./index.html#section_3" class="site-footer-link">Artists</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="./index.html#section_4" class="site-footer-link">Schedule</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="./index.html#section_5" class="site-footer-link">Pricing</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="./index.html#section_6" class="site-footer-link">Contact</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0">
                        <h5 class="site-footer-title mb-3">Have a question?</h5>

                        <p class="text-white d-flex">
                            <a href="mailto:info@sunnyhillfestival.com" class="site-footer-link">
                                info@sunnyhillfestival.com
                            </a>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6 col-11 mb-4 mb-lg-0 mb-md-0">
                        <h5 class="site-footer-title mb-3">Location</h5>

                        <p class="text-white d-flex mt-3 mb-2">
                            ENVER MALOKU, NR. 82, PRISHTINA 10000 KOSOVO</p>

                        <a class="link-fx-1 color-contrast-higher mt-3" href="index.html#section_6">
                            <span>Our Maps</span>
                            <svg class="icon" viewBox="0 0 32 32" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="16" cy="16" r="15.5"></circle><line x1="10" y1="18" x2="16" y2="12"></line><line x1="16" y1="12" x2="22" y2="18"></line></g></svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>

      

      
        <script src="js/sign-up.js"></script>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/custom.js"></script>
        

    </body>
</html>