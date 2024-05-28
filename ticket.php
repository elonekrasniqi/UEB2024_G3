<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//Përdorimi i AJAX-it për lexim dhe update-im nga një PHP skriptë 
// Kontrolloni nëse kërkesa është bërë përmes AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajax'])) {
    // Trajtoni kërkesën AJAX këtu
    $emri = $_POST['ticket-form-name'];
    $email = $_POST['ticket-form-email'];
    // Vazhdoni me të dhënat e tjera dhe logjikën e përpunimit

    // Pas përpunimit, përgjigjuni me JSON ose thjesht një mesazh
    if ($numriBiletave < 1) {
        echo json_encode(['error' => 'Numri i biletave duhet të jetë më i madh se 1.']);
    } else {
        // Nëse kodi PHP ekzekutohet pa probleme
        if ($bileta->validoDate($dataBlerjes)) {
            if ($stmt->execute()) {
                echo json_encode(['success' => 'Blerja u krye me sukses!']);
            } else {
                echo json_encode(['error' => 'Database execute error.']);
            }
        } else {
            echo json_encode(['error' => 'Data e blerjes nuk është e vlefshme.']);
        }
    }
    exit; // Mbyllni këtë skriptë pasi keni përgjigjur AJAX
}

class Bileta {
    protected $emri;
    protected $cmimi;
    protected $dataBlerjes;

    public function __construct($emri, $cmimi, $dataBlerjes) {
        $this->emri = $emri;
        $this->cmimi = $cmimi;
        $this->dataBlerjes = $dataBlerjes;
    }

    public function getEmri() {
        return $this->emri;
    }

    public function getCmimi() {
        return $this->cmimi;
    }

    public function getDataBlerjes() {
        return $this->dataBlerjes;
    }

    public function ruajNeSkedar($user) {
        $data = $user->getEmri() . ',' . $this->emri . ',' . $this->cmimi . ',' . $this->dataBlerjes . "\n";
        file_put_contents('tickets.txt', $data, FILE_APPEND);
    }

    public function validoDate($data) {
        // Format valid: yyyy-mm-dd
        $pattern = "/^(19|20)\d\d-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/";
        if (preg_match($pattern, $data)) {
            // Kontrollojmë nëse data është para datës së fundit të lejuar (24 Korrik)
            $dataKufi = strtotime('2024-07-24');
            $dataVerifikimi = strtotime($data);
            $dataSot = strtotime(date("Y-m-d"));
            if ($dataVerifikimi <= $dataKufi && $dataVerifikimi >= $dataSot) {
                return true;
            }
        }
        return false;
    }
}

class EarlyBirdBileta extends Bileta {
    public function __construct($emri, $cmimi, $dataBlerjes) {
        parent::__construct($emri, $cmimi, $dataBlerjes);
    }
}

class StandardBileta extends Bileta {
    public function __construct($emri, $cmimi, $dataBlerjes) {
        parent::__construct($emri, $cmimi, $dataBlerjes);
    }
}

class User {
    private $emri;

    public function __construct($emri) {
        $this->emri = $emri;
    }

    public function getEmri() {
        return $this->emri;
    }
}

// Set custom error handler function
function customErrorHandler($errno, $errstr, $errfile, $errline, $errcontext = null) {
    error_log("Error occurred: $errstr in $errfile on line $errline", 0);

    if ($errcontext) {
        // Log additional context provided by $errcontext
        $additional_context = print_r($errcontext, true);
        error_log("Additional context: $additional_context", 0);
    }

    echo "<p>An error occurred. Please try again later.</p>";
}

// Set custom error handler
set_error_handler("customErrorHandler");

// Database connection details
$servername = "localhost";
$username = "root";
$password = "Arlinda.Be2004";
$dbname = "projektiueb";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (Exception $e) {
    // Handle connection error
    customErrorHandler(E_USER_ERROR, "Connection failed: " . $e->getMessage(), __FILE__, __LINE__, null);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emri = $_POST["ticket-form-name"];
    $email = $_POST["ticket-form-email"];
    $telefoni = $_POST["ticket-form-phone"];
    $tipiBiletës = $_POST["TicketForm"];
    $numriBiletave = $_POST["ticket-form-number"];
    $dataBlerjes = trim($_POST["dataBlerjes"]);
    $message = $_POST["ticket-form-message"]; 
    $xhirollogaria = $_POST["bank-account-number"]; 

    // Validate number of tickets
    if ($numriBiletave < 1) {
        echo "<script>alert('Numri i biletave duhet të jetë më i madh se 1.')</script>";
    } else {
        // Continue with the ticket purchase process
        $user = new User($emri);

        if ($tipiBiletës == "earlybird") {
            $bileta = new EarlyBirdBileta("Early Bird Ticket", 120, $dataBlerjes);
        } elseif ($tipiBiletës == "standard") {
            $bileta = new StandardBileta("Standard Ticket", 240, $dataBlerjes);
        }

        // Validate purchase date
        if ($bileta->validoDate($dataBlerjes)) {
            $sql = "INSERT INTO tickets (emri, email, telefoni, xhirollogaria, bileta_emri, cmimi, data_blerjes, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                customErrorHandler(E_USER_ERROR, "Database prepare error: " . $conn->error, __FILE__, __LINE__, null);
            }

            $stmt->bind_param("ssssssss", $emri, $email, $telefoni, $xhirollogaria, $bileta_emri, $cmimi, $data_blerjes, $message);

            $emri = $user->getEmri();
            $email = $email;
            $telefoni = $telefoni;
            $xhirollogaria = $xhirollogaria;
            $bileta_emri = $bileta->getEmri();
            $cmimi = $bileta->getCmimi();
            $data_blerjes = $bileta->getDataBlerjes();
            $message = $message;
    
            if ($stmt->execute()) {
                echo '<script>alert("Blerja u krye me sukses!");</script>';
                echo '<script>window.location.href = "ticket.php";</script>';
                exit();
            } else {
                customErrorHandler(E_USER_ERROR, "Database execute error: " . $stmt->error, __FILE__, __LINE__, null);
            }
    
            $stmt->close();
        }
    }
}
    $conn->close();
    ?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/sunny-hill-festival-logo.png" type="image/x-icon">
    <title>Sunny Hill - Ticket HTML Form</title>
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
                <a class="navbar-brand" href="homepage.php">Sunny Hill</a>
                <a href="ticket.php" class="btn custom-btn d-lg-none ms-auto me-4">Buy Ticket</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav align-items-lg-center ms-auto me-lg-5">
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="homepage.php#section_1">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="homepage.php#section_2">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="homepage.php#section_3">Artists</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="homepage.php#section_4">Schedule</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="homepage.php#section_5">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="homepage.php#section_6">Contact</a>
                        </li>
                    </ul>
                    <a href="login.php" class="btn custom-btn d-lg-block d-none">Buy Ticket</a>
                </div>
            </div>
        </nav>



        <section class="ticket-section section-padding">
            <div class="section-overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-10 mx-auto">
                        <form class="custom-form ticket-form mb-5 mb-lg-0" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" role="form">
                        <input type="hidden" name="ajax" value="1">
                            <h2 class="text-center mb-4">Get started here</h2>
                            <div class="ticket-form-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <input type="text" name="ticket-form-name" id="ticket-form-name" class="form-control" placeholder="Full name" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <input type="email" name="ticket-form-email" id="ticket-form-email" class="form-control" placeholder="Email address" required>
                                    </div>
                                </div>
                                <input type="tel" class="form-control" name="ticket-form-phone" placeholder="Phone number (start with +)" pattern="\+[0-9]+" required="">
                                <h6>Choose Ticket Type</h6>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-check form-control">
                                        <input class="form-check-input" type="radio" name="TicketForm" id="flexRadioDefault1" value="earlybird" data-price="120">
                                        <label class="form-check-label" for="flexRadioDefault1">Early bird $120</label>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-check form-check-radio form-control">
                                            <input class="form-check-input" type="radio" name="TicketForm" id="flexRadioDefault2" value="standard" data-price="240">
                                            <label class="form-check-label" for="flexRadioDefault2">Standard $240</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="number" name="ticket-form-number" id="ticket-form-number" class="form-control" placeholder="Number of Tickets" required>
                                <textarea name="ticket-form-message" rows="3" class="form-control" id="ticket-form-message" placeholder="Additional Request"></textarea>
                                <input type="text" name="bank-account-number" id="bank-account-number" class="form-control" placeholder="Bank Account Number" required>
                                <input type="text" name="dataBlerjes" id="dataBlerjes" class="form-control" placeholder="Date of Purchase (yyyy-mm-dd)" required>
                                <div class="col-lg-4 col-md-10 col-8 mx-auto">
                                    <button type="submit" class="form-control">Buy Ticket</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
  


    <!-- JAVASCRIPT FILES -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/custom.js"></script>
    <script>
    //Përdorimi i AJAX-it për lexim dhe update-im nga një PHP skriptë 
    $(document).ready(function() {
    $('.ticket-form').on('submit', function(e) {
        e.preventDefault(); // Ndalo rifreskimin e faqes
        var formData = $(this).serialize(); // Merr të dhënat nga forma në formatin e duhur për dërgim

        $.ajax({
            type: 'POST',
            url: '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>',
            data: formData,
            success: function(response) {
                alert('Blerja u krye me sukses!');
                window.location.href = 'ticket.php'; // Ridrejto në faqe pas suksesit
            },
            error: function() {
                alert('Ka një problem me dërgimin e të dhënave.');
            }
        });
    });
    });
    </script>


</body>
</html>