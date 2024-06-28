<?php
session_start(); // Fillon ose rihap sesionin në fillim të skedarit

function merrDatenAktuale() {
    return date("Y-m-d");
}

// Kontrolli i datës aktuale
$dataAktuale = merrDatenAktuale();

// Kontrolli i kufirit të datës për blerjen e biletave
$limitData = '2024-07-23';
if ($dataAktuale > $limitData) {
    echo json_encode(array("status" => "error", "message" => "Nuk mund të blini bileta pas datës 23 korrik 2024."));
    exit();
} else {
    // Kontrolli i metodës së kërkesës (POST) për të kryer veprimet e blerjes së biletave
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Database credentials
        $dbHost = 'localhost';
        $dbUser = 'root';
        $dbPass = '2302';
        $dbName = 'projektiueb';

        // Establish database connection
        $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
        if ($conn->connect_error) {
            echo json_encode(array("status" => "error", "message" => "Connection failed: " . $conn->connect_error));
            exit();
        }

        // Pjesa e kodit për përpunimin e formës dhe blerjen e biletave
        $emri = $_POST["ticket-form-name"];
        $email = $_POST["ticket-form-email"];
        $telefoni = $_POST["ticket-form-phone"];
        $tipiBiletës = $_POST["TicketForm"];
        $numriBiletave = $_POST["ticket-form-number"];
        $message = $_POST["ticket-form-message"];
        $xhirollogaria = $_POST["bank-account-number"];
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        // Validimi i numrit të biletave
        if ($numriBiletave < 1) {
            echo json_encode(array("status" => "error", "message" => "Numri i biletave duhet të jetë më i madh se 1."));
            exit();
        } else {
            // Krijimi i objektit User
            $user = new User($emri);

            if ($tipiBiletës == "earlybird") {
                $bileta = new EarlyBirdBileta("Early Bird Ticket", 120);
            } elseif ($tipiBiletës == "standard") {
                $bileta = new StandardBileta("Standard Ticket", 240);
            }

            $sql = "INSERT INTO tickets (emri, email, telefoni, xhirollogaria, bileta_emri, cmimi, message, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            $stmt->bind_param("sssssssi", $emri, $email, $telefoni, $xhirollogaria, $bileta_emri, $cmimi, $message, $user_id);
            $emri = $user->getEmri();
            $bileta_emri = $bileta->getEmri();
            $cmimi = $bileta->getCmimi();

    
        }

        $conn->close();
    }
}

// Klasa User
class User {
    private $emri;

    public function __construct($emri) {
        $this->emri = $emri;
    }

    public function getEmri() {
        return $this->emri;
    }
}

// Klasa Bileta
class Bileta {
    protected $emri;
    protected $cmimi;

    public function __construct($emri, $cmimi) {
        $this->emri = $emri;
        $this->cmimi = $cmimi;
    }

    public function getEmri() {
        return $this->emri;
    }

    public function getCmimi() {
        return $this->cmimi;
    }
}

// Klasa EarlyBirdBileta
class EarlyBirdBileta extends Bileta {
    public function __construct($emri, $cmimi) {
        parent::__construct($emri, $cmimi);
    }
}

// Klasa StandardBileta
class StandardBileta extends Bileta {
    public function __construct($emri, $cmimi) {
        parent::__construct($emri, $cmimi);
    }
}
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
                        <form class="custom-form ticket-form mb-5 mb-lg-0" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  method="post" role="form">
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
                                <input type="number" name="ticket-form-number" id="ticket-form-number" min="1" class="form-control" placeholder="Number of Tickets" required>
                                <textarea name="ticket-form-message" rows="3" class="form-control" id="ticket-form-message" placeholder="Additional Request"></textarea>
                                <input type="text" name="bank-account-number" id="bank-account-number" class="form-control" placeholder="Bank Account Number" required>
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

</body>
</html>