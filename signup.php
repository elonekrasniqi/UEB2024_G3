 <?php

// Verifikimi i emailit përmes RegEx nga ana e serverit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['signup-form-fullname']);
    $email = trim($_POST['signup-form-email']);
    
    $emailPattern = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';

    // Verifikimi i emailit
    if (!preg_match($emailPattern, $email)) {
        echo '<script>alert("Invalid email address");</script>';
    } else {
        $password = trim($_POST['signup-form-password']);
        $confirmPassword = trim($_POST['signup-form-confirm-password']);

        // Verifikimi i fjalëkalimit
        if ($password !== $confirmPassword) {
            echo '<script>alert("Passwords do not match");</script>';
        } elseif (!validatePassword($password)) {
            echo '<script>alert("Invalid password format");</script>';
        } else {
            // Kontrollo nëse emaili dhe fjalëkalimi përputhen në skedar
            $userExists = checkUserCredentials($email, $password);
            if ($userExists) {
                echo '<script>alert("User with this email and password already exists, please login");</script>';
            } else {
                // Kodimi i fjalëkalimit me password_hash
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Perform further processing, e.g., save user data to a file
                $usersFile = 'user.txt'; // Emri i skedarit ku ruhen emrat e përdoruesve
                $userData = "$fullname|$email|$hashedPassword\n"; // Të dhënat e përdoruesit për të ruajtur

                // Ruaj të dhënat e përdoruesit në skedar
                file_put_contents($usersFile, $userData, FILE_APPEND);
                echo "<script>alert('Signup successful'); window.location.href ='index.php' </script>";
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
    $usersFile = 'user.txt'; // Emri i skedarit ku ruhen emrat e përdoruesve

    // Kontrollo nëse skedari ekziston dhe përmban të dhëna për emailin dhe fjalëkalimin e dhënë
    if (file_exists($usersFile)) {
        $fileContents = file_get_contents($usersFile);
        $lines = explode("\n", $fileContents);
        foreach ($lines as $line) {
            $userData = explode("|", $line);
            if (count($userData) === 3 && $userData[1] === $email && password_verify($password, $userData[2])) {
                return true; // Emaili dhe fjalëkalimi përputhen në skedar
            }
            // Kontrollo edhe për ekzistencën e emailit në skedar pa përmendur fjalëkalimin
            if (count($userData) >= 2 && $userData[1] === $email) {
                return true; // Emaili ekziston në skedar, nuk lejojë krijimin e llogarisë
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

        <script src="js/sign-up.js"></script>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/custom.js"></script>
        

</body>
</html>
