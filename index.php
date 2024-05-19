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

                // Save email to a file
                $file = fopen("users.txt", "a") or die("Unable to open file!");
                fwrite($file, $email . "\n");
                fclose($file);

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