<?php
session_start();
//var_dump($_SESSION);
// session per te ndryshuar permbajtjen varesisht cilen gjuhe selekton useri
if (isset($_GET['gjuha'])) {
    $gjuha_zgjedhur = $_GET['gjuha'];
    $_SESSION['gjuha'] = $gjuha_zgjedhur;

    if ($gjuha_zgjedhur == 'albanian') {
        header("Location: homepage-sh.php");
    } else {
        header("Location: homepage.php");
    }
    exit();
}

//cookie i pare, merr emrin nga forma per kontaktim dhe vendos alert
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle the contact form submission
    if (isset($_POST['submit'])) {
        $fullName = $_POST['contact-name'];
        setcookie('contact-name', $fullName, time() + (86400 * 30), "/"); // Cookie expires in 30 days
        echo "<script>alert('Thank you for contacting us, $fullName!');</script>";
    }

    //cookie i dyte, ndryshon ngjyren varesisht qfare vlere merr
    // Handle the volunteer form submission
    elseif (isset($_POST['volunteer-name'])) {
    $name = $_POST["volunteer-name"];
    $hash = md5($name); // Generate a hash from the name
    $color = substr($hash, 0, 6); // Take the first 6 characters of the hash
    setcookie("dynamicColor", $color, time() + (30 * 24 * 60 * 60), "/"); // Cookie valid for 30 days
    var_dump($color); // Add var_dump to display the color
}    
   
}
  // Handle the volunteer form submission
  elseif (isset($_POST['contact-name'])) {
    $name = $_POST["contact-name"];
    $hash = md5($name); // Generate a hash from the name
    $color = substr($hash, 0, 6); // Take the first 6 characters of the hash
    setcookie("dynamicColor", $color, time() + (30 * 24 * 60 * 60), "/"); // Cookie valid for 30 days
    var_dump($color); // Add var_dump to display the color
}    
   






//cookie i trete qe e merr emrin nga forma per vullnetare dhe vendos alert after submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submitform'])) {
        $fullNameVol = $_POST['volunteer-name'];
        setcookie('volunteer-name', $fullNameVol, time() + (86400 * 30), "/"); // Cookie expires in 30 days
        echo "<script>alert('Thank you for applying, $fullNameVol! We will contact you soon!');</script>";
        var_dump($fullNameVol); // Add var_dump to display the full name
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="images/sunny-hill-festival-logo.png" type="image/x-icon">

        <title>Sunny Hill Festival</title>

             
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;400;700&display=swap" rel="stylesheet">
                
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href="css/bootstrap-icons.css" rel="stylesheet">

        <link href="css/festival.css" rel="stylesheet">

    </head>
    
    <body>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    const youtubeLinks = document.querySelectorAll('a[data-artist]');
    youtubeLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const artistName = this.getAttribute('data-artist');
            document.cookie = `favoriteArtist=${artistName}; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/`;
            window.location.href = this.href;
        });
    });
});
</script>
        <style>
            #nav-Volenteer .custom-form {
            background-color:<?php echo $color; ?>;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); 
        }
        </style>

        <main>
        <header class="site-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12 d-flex flex-wrap">
                <strong class="text-dark">
                    <?php

                    // Kontrollo nëse përdoruesi është i kyçur
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                        echo "<span>Welcome, " . $_SESSION['fullname'] . "! </span>"; // Display the user's name in a separate span
                        echo "You have logged in " . $_SESSION['login_count'] . " times.";
                    }
                   
                    ?>
                </strong>
            </div>
            <div class="col-lg-6 col-12 d-flex flex-wrap justify-content-end">
                <?php
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                    echo '<strong class="text-dark me-3"><a href="logout.php" style="color: black;">Log Out</a></strong>'; // Shfaq linkun e logout-it vetëm kur është kyçur përdoruesi
                }
                ?>
            </div>
        </div>
    </div>
</header>


            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand" href="homepage.php" id="logo" style="transition: transform 0.3s ease; display: inline-block;">
                        Sunny Hill
                    </a>

                    <script>
                
                        document.getElementById("logo").onmouseover = function() {
                            this.style.transform = "scale(1.1)";
                        };
                        document.getElementById("logo").onmouseout = function() {
                            this.style.transform = "scale(1)";
                        };
                    
                        
                    </script>
                    
<a href="ticket.php" class="btn custom-btn d-lg-none ms-auto me-4">Buy Ticket</a>

<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav align-items-lg-center ms-auto me-lg-5">
        <li class="nav-item">
            <a class="nav-link click-scroll" href="#section_1" onclick="addEffect(this)">Home</a>
        </li>

        <li class="nav-item">
            <a class="nav-link click-scroll" href="#section_2" onclick="addEffect(this)">About</a>
        </li>

        <li class="nav-item">
            <a class="nav-link click-scroll" href="#section_3" onclick="addEffect(this)">Artists</a>
        </li>

        <li class="nav-item">
            <a class="nav-link click-scroll" href="#section_4" onclick="addEffect(this)">Schedule</a>
        </li>

        <li class="nav-item">
            <a class="nav-link click-scroll" href="#section_5" onclick="addEffect(this)">Pricing</a>
        </li>

        <li class="nav-item">
            <a class="nav-link click-scroll" href="#section_6" onclick="addEffect(this)">Contact</a>
        </li>
    </ul>

    <a href="ticket.php" class="btn custom-btn d-lg-block d-none" id="buyTicketBtn">Buy Ticket</a>
    <div class="dropdown">
    <button class="btn custom-btn d-lg-block d-none dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="margin-left: 45px;">
        Language
        </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="homepage.php?gjuha=albanian">Albanian</a></li>
            <li><a class="dropdown-item" href="homepage.php?gjuha=english">English</a></li>
            </ul>
    </div>
<script>
    
    var buyTicketBtn = document.getElementById("buyTicketBtn");

    
    buyTicketBtn.addEventListener("mouseenter", function() {
        this.style.backgroundColor = "#007bff"; 
        this.style.color = "#fff"; 
        this.style.transform = "scale(1.1)"; 
        this.style.transition = "all 0.3s ease"; 
    });

    
    buyTicketBtn.addEventListener("mouseleave", function() {
        this.style.backgroundColor = ""; 
        this.style.color = ""; 
        this.style.transform = ""; 
    });

    var LoginBtn = document.getElementById("LoginBtn");

    
    LoginBtn.addEventListener("mouseenter", function() {
    this.style.backgroundColor = "#007bff"; 
    this.style.color = "#fff"; 
    this.style.transform = "scale(1.1)"; 
    this.style.transition = "all 0.3s ease"; 
});


LoginBtn.addEventListener("mouseleave", function() {
    this.style.backgroundColor = ""; 
    this.style.color = ""; 
    this.style.transform = ""; 
});
</script>

</div>
</div>
</nav>

<script>
    function addEffect(element) {
       
        element.style.color = "#007bff" 
        element.style.fontWeight = "bold"; 
        element.style.transform = "scale(1.1)"; 
        element.style.transition = "transform 0.3s ease";
    }
</script>

            

            <section class="hero-section" id="section_1">
                <div class="section-overlay"></div>

                <div class="container d-flex justify-content-center align-items-center">
                    <div class="row">

                        <div class="col-12 mt-auto mb-5 text-center">

                            <h1 class="text-white mb-5">Sunny Hill Festival 2024</h1>

                            <a class="btn custom-btn smoothscroll" href="#section_2">Let's begin</a>
                        </div>

                        <div class="col-lg-12 col-12 mt-auto d-flex flex-column flex-lg-row text-center">
                            <div class="date-wrap">
                                <h5 class="text-white">
                                    <i class="custom-icon bi-clock me-2"></i>
                                    25 - 28<sup>th</sup>, July 2024
                                </h5>
                            </div>

                            <div class="location-wrap mx-auto py-3 py-lg-0">
                                <h5 class="text-white">
                                    <i class="custom-icon bi-geo-alt me-2" ></i>Sunny Hill Festival Park, Prishtina 10000, Kosova
                                </h5>
                            </div>

                           
                        </div>
                    </div>
                </div>

                <div class="video-wrap">
                    <video autoplay loop muted class="custom-video" poster="">
                        <source src="video/Video-79.mp4" type="video/mp4">

                        Your browser does not support the video tag
                    </video>
                </div>
            </section>


            <section class="about-section section-padding" id="section_2">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-12 mb-4 mb-lg-0 d-flex align-items-center">
                            <div class="services-info">
                                <h2 class="text-white mb-4">About Sunny Hill Festival 2024</h2>

                                <p class="text-white">SUNNY HILL Festival is the biggest music festival in Kosovo and based on the headliners, probably the biggest in South East Europe. International music festival of the highest standards, one that puts Prishtina – Kosovo on the festival map as a not to be missed cultural place, in a country that loves music and knows how to have fun. </p>

                            </div>
                        </div>

                        <div class="col-lg-6 col-12">
                            <div class="about-text-wrap">
                                <img src="images/sunny-hill-feature-image.jpg" class="about-image img-fluid">

                                <div class="about-text-info d-flex">
                                    <div class="d-flex">
                                        <i class="about-text-icon bi-person"></i>
                                    </div>


                                    <div class="ms-4">
                                        <h3>a happy moment</h3>

                                        <p class="mb-0">your amazing festival experience with us</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <?php

//Cookie 3 për të ruajtur zgjedhjen e artistit të preferuar të përdoruesit, duke lejuar faqen të ndërtojë përmbajtjen bazuar në preferencat e përdoruesit.
// Merr artistin e preferuar bazuar në kanalet e fundit të klikuara të YouTube nga përdoruesi


$html = ' <section class="artists-section section-padding" id="section_3">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 text-center">
                <h2 class="mb-4">Meet Artists</h2>
            </div>';
            $artists = [
                'Dua Lipa', 'Mc Kresha & Lyrical Son', 'Rihanna', 'Maluma', 'Martin Garrix', 'Maneskin'
            ];

// Kontrollojme nëse cookie është vendosur
if (isset($_COOKIE['favoriteArtist']) && in_array($_COOKIE['favoriteArtist'], $artists)) {
    $favoriteArtist = $_COOKIE['favoriteArtist'];
    // Lëvizja artistit te klikuar në pozicionin e parë
    $key = array_search($favoriteArtist, $artists);
    unset($artists[$key]);
    array_unshift($artists, $favoriteArtist);
}

// Vargu i ri për të ruajtur informacionin e artistit
$artistsInfo = [
    'Dua Lipa' => [
        'image' => 'images/artists/wallpapersden.com_dua-lipa-photoshoot-2020_1920x2026.jpg',
        'birthdate' => 'August 22 1995',
        'music' => 'Pop',
        'youtube' => 'http://www.youtube.com/@dualipa'
    ],
    'Mc Kresha & Lyrical Son' => [
        'image' => 'images/artists/Kresha-Lyrical-Son.jpg',
        'birthdate' => 'September 5 1984 & January 28, 1984',
        'music' => 'Hip Hop',
        'youtube' => 'http://www.youtube.com/@PINTofficial'
    ],
    'Rihanna' => [
        'image' => 'images/artists/rihanna_(1)1.jpg',
        'birthdate' => 'February 20 1988',
        'music' => 'Pop, R&B, EDM, Reggae',
        'youtube' => 'http://www.youtube.com/@rihanna'
    ],
    'Maluma' => [
        'image' => 'images/artists/cantante-colombiano-Maluma_1542456436_133521540_1200x675.jpg',
        'birthdate' => 'January 28 1994',
        'music' => 'Pop,Latin Trap',
        'youtube' => 'http://www.youtube.com/@Maluma_Official'
    ],
    'Martin Garrix' => [
        'image' => 'images/artists/Martin-Garrix-performs-on-stage.webp',
        'birthdate' => 'May 14 1996',
        'music' => 'DJ',
        'youtube' => 'https://www.youtube.com/user/martingarrix'
    ],
    'Maneskin' => [
        'image' => 'images/artists/Maneskin-by-Tommaso-Ottomano.jpg',
        'birthdate' => '2016',
        'music' => 'Rock',
        'youtube' => 'http://www.youtube.com/@ManeskinOfficial'
    ],
];


echo '<section class="artists-section section-padding" id="section_3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <h2 class="mb-4">Meet Artists</h2>
            </div>';

foreach ($artists as $artist) {
    $artistInfo = $artistsInfo[$artist];
    echo '<div class="col-lg-5" id="' . strtolower(str_replace(' ', '-', $artist)) . '-section">
                <div class="artists-thumb">
                    <div class="artists-image-wrap">
                        <img src="' . $artistInfo['image'] . '" class="artists-image img-fluid">
                    </div>
                    <div class="artists-hover">
                        <p>
                            <strong>Name:</strong>
                            ' . $artist . '
                        </p>
                        <p>
                            <strong>Birthdate:</strong>
                            ' . $artistInfo['birthdate'] . '
                        </p>
                        <p>
                            <strong>Music:</strong>
                            ' . $artistInfo['music'] . '
                        </p>
                        <hr>
                        <p class="mb-0">
                            <strong>Youtube Channel:</strong>
                            <a href="' . $artistInfo['youtube'] . '" data-artist="' . $artist . '">' . $artist . ' </a>
                        </p>
                    </div>
                </div>
            </div>';
}
echo '</div>
    </div>
</section>';

    $html='   </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12 d-flex flex-wrap">
                <marquee behavior="scroll" direction="right">
                    <p class="d-flex me-4 mb-0">
                        <i class="bi-person custom-icon me-2"></i>
                        <strong style="color: white;">Other Artists Coming Soon...</strong>
                    </p>
                </marquee>
            </div>
        </div>
    </div>
</section> <br>';
?>
<?php
        // Funksioni per te shtuar presjet ne mes te numrave brenda ditelindjeve
        function Manipulimi_ditelindja($html) {
            // Definojme me RegEx formatin e ditelindjes
            $pattern = '/(<strong>Birthdate:<\/strong>\s*)([A-Za-z]+\s+\d{1,2})\s+(\d{4})/';

            // Definojme zevendesimin e karakterit ne mes te ditelindjes
            $replacement = '$1$2, $3';

            // Shtojme presjen ne mes te ditelindjes me funksioni preg_replace
            $html_me_presje = preg_replace($pattern, $replacement, $html);

            return $html_me_presje;
        }

            // Shto presjen te datat e lindjes
            $html_me_presje = Manipulimi_ditelindja($html);

            // Outputi i HTML te modifikuar
            echo $html_me_presje;
            ?>



            <?php

                    $orari_html = '<section class="schedule-section section-padding" id="section_4">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h2 class="text-black mb-4">Festival Schedule</h2>
                                    <div class="table-responsive">
                                        <table class="schedule-table table table-dark">
                                            <colgroup>
                                                <col style="width: 25%;">
                                                <col style="width: 25%;">
                                                <col style="width: 25%;">
                                                <col style="width: 25%;">
                                            </colgroup>
                                            <thead>
                                                <tr>
                                                    <th scope="col">Day 1 - Thursday</th>
                                                    <th scope="col">Day 2 - Friday</th>
                                                    <th scope="col">Day 3 - Saturday</th>
                                                    <th scope="col">Day 4 - Sunday</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="background-color: #d9e3da76">
                                                        <h3>Dua Lipa</h3>
                                                        <p class="mb-2">08:00 PM 09:00 PM</p>
                                                        <p>Pop Performance</p>
                                                    </td>
                                                    <td style="background-color: #d9e3da76">
                                                        <h3>McKresha & LyricalSon</h3>
                                                        <p class="mb-2">08:00 PM 09:00 PM</p>
                                                        <p>Pop Performance</p>
                                                    </td>
                                                    <td style="background-color: #e3d9dbbe">
                                                        <h3>Surprise</h3>
                                                        <p class="mb-2">08:00 PM 09:00 PM</p>
                                                        <p>Surprise Performance</p>
                                                    </td>
                                                    <td style="background-color: #e3d9dbbe">
                                                        <h3>Surprise</h3>
                                                        <p class="mb-2">08:00 PM 09:00 PM</p>
                                                        <p>Surprise Performance</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color: #e3d9dbbe">
                                                        <h3>Surprise</h3>
                                                        <p class="mb-2">09:00 PM 10:00 PM</p>
                                                        <p>Surprise Performance</p>
                                                    </td>
                                                    <td style="background-color: #e3d9dbbe">
                                                        <h3>Surprise</h3>
                                                        <p class="mb-2">09:00 PM 10:00 PM</p>
                                                        <p>Surprise Performance</p>
                                                    </td>
                                                    <td style="background-color: #e3d9dbbe">
                                                        <h3>Surprise</h3>
                                                        <p class="mb-2">09:00 PM 10:00 PM</p>
                                                        <p>Surprise Performance</p>
                                                    </td>
                                                    <td style="background-color: #e3d9dbbe">
                                                        <h3>Surprise</h3>
                                                        <p class="mb-2">09:00 PM 10:00 PM</p>
                                                        <p>Surprise Performance</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color: #e3d9dbbe">
                                                        <h3>Surprise</h3>
                                                        <p class="mb-2">10:00 PM 11:00 PM</p>
                                                        <p>Surprise Performance</p>
                                                    </td>
                                                    <td style="background-color: #d9e3da76">
                                                        <h3>Martin Garrix</h3>
                                                        <p class="mb-2">10:00 PM 11:00 PM</p>
                                                        <p>DJ</p>
                                                    </td>
                                                    <td style="background-color: #e3d9dbbe">
                                                        <h3>Surprise</h3>
                                                        <p class="mb-2">10:00 PM 11:00 PM</p>
                                                        <p>Surprise Performance</p>
                                                    </td>
                                                    <td style="background-color: #d9e3da76">
                                                        <h3>Maneskin</h3>
                                                        <p class="mb-2">10:00 PM 11:00 PM</p>
                                                        <p>Rock</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color: #d9e3da76">
                                                        <h3>Maluma</h3>
                                                        <p class="mb-2">11:00 PM 12:00 PM</p>
                                                        <p>Rock & Roll</p>
                                                    </td>
                                                    <td style="background-color: #e3d9dbbe">
                                                        <h3>Surprise</h3>
                                                        <p class="mb-2">11:00 PM 12:00 PM</p>
                                                        <p>Surprise Performance</p>
                                                    </td>
                                                    <td style="background-color: #e3d9dbbe">
                                                        <h3>Surprise</h3>
                                                        <p class="mb-2">11:00 PM 12:00 PM</p>
                                                        <p>Surprise Performance</p>
                                                    </td>
                                                    <td style="background-color: #e3d9dbbe">
                                                        <h3>Surprise</h3>
                                                        <p class="mb-2">11:00 PM 12:00 PM</p>
                                                        <p>Surprise Performance</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="background-color: #e3d9dbbe">
                                                        <h3>Surprise</h3>
                                                        <p class="mb-2">12:00 PM 01:00 AM</p>
                                                        <p>Surprise Performance</p>
                                                    </td>
                                                    <td style="background-color: #e3d9dbbe">
                                                        <h3>Surprise</h3>
                                                        <p class="mb-2">12:00 PM 01:00 AM</p>
                                                        <p>Surprise Performance</p>
                                                    </td>
                                                    <td style="background-color: #d9e3da76">
                                                        <h3>Rihanna</h3>
                                                        <p class="mb-2">12:00 PM 01:00 AM</p>
                                                        <p>Pop Performance</p>
                                                    </td>
                                                    <td style="background-color: #e3d9dbbe">
                                                        <h3>Surprise</h3>
                                                        <p class="mb-2">12:00 PM 01:00 AM</p>
                                                        <p>Surprise Performance</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>';

                    // Shtimi i karakterit "-" ne mes te oreve
                    $orari_html_me_karaktere = preg_replace('/(\d{2}:\d{2} [AP]M) (\d{2}:\d{2} [AP]M)/', '$1 - $2', $orari_html);

                    echo $orari_html_me_karaktere;
                    ?>


            <section class="pricing-section section-padding section-bg" id="section_5">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-8 col-12 mx-auto">
                            <h2 class="text-center mb-4">Plans, you'd love</h2>
                        </div>
                        
                        <div class="col-lg-6 col-12">
                            <div class="pricing-thumb">
                                <div class="d-flex">
                                    <div>
                                        <h3><small>Early Bird</small> $120</h3>

                                        <p>Including good things:</p>
                                    </div>

                                    <p class="pricing-tag ms-auto">Save up to <span>50%</span></h2>
                                </div>

                                <ul class="pricing-list mt-3">
                                    <li class="pricing-list-item">platform for potential customers</li>

                                    <li class="pricing-list-item">digital experience</li>

                                    <li class="pricing-list-item">high-quality sound</li>

                                    <li class="pricing-list-item">standard content</li>
                                </ul>

                                <a class="link-fx-1 color-contrast-higher mt-4" href="ticket.php">
                                    <span>Buy Ticket</span>
                                    <svg class="icon" viewBox="0 0 32 32" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="16" cy="16" r="15.5"></circle><line x1="10" y1="18" x2="16" y2="12"></line><line x1="16" y1="12" x2="22" y2="18"></line></g></svg>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12 mt-4 mt-lg-0">
                            <div class="pricing-thumb">
                                <div class="d-flex">
                                    <div>
                                        <h3><small>Standard</small> $240</h3>

                                        <p>What makes a premium festava?</p>
                                    </div>
                                </div>

                                <ul class="pricing-list mt-3">
                                    <li class="pricing-list-item">platform for potential customers</li>

                                    <li class="pricing-list-item">digital experience</li>

                                    <li class="pricing-list-item">high-quality sound</li>

                                    <li class="pricing-list-item">premium content</li>
                                    
                                    <li class="pricing-list-item">live chat support</li>
                                </ul>

                                <a class="link-fx-1 color-contrast-higher mt-4" href="ticket.php">
                                    <span>Buy Ticket</span>
                                    <svg class="icon" viewBox="0 0 32 32" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="16" cy="16" r="15.5"></circle><line x1="10" y1="18" x2="16" y2="12"></line><line x1="16" y1="12" x2="22" y2="18"></line></g></svg>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <section class="contact-section section-padding" id="section_6">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-8 col-12 mx-auto">
                            <h2 class="text-center mb-4">Interested?</h2>

                            <nav class="d-flex justify-content-center">
                                <div class="nav nav-tabs align-items-baseline justify-content-center" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-ContactForm-tab" data-bs-toggle="tab" data-bs-target="#nav-ContactForm" type="button" role="tab" aria-controls="nav-ContactForm" aria-selected="false">
                                        <h5>Contact Form</h5>
                                    </button>

                                    <button class="nav-link" id="nav-ContactMap-tab" data-bs-toggle="tab" data-bs-target="#nav-ContactMap" type="button" role="tab" aria-controls="nav-ContactMap" aria-selected="false">
                                        <h5>Google Maps</h5>
                                    </button>

                                    <button class="nav-link" id="nav-Volenteer-tab" data-bs-toggle="tab" data-bs-target="#nav-Volenteer" type="button" role="tab" aria-controls="nav-Volenteer" aria-selected="false" style="margin-left: 10px;">
                                        <h5>Volunteer</h5>
                                    </button>
                                    <button class="nav-link" id="nav-History-tab" data-bs-toggle="tab" data-bs-target="#nav-History" type="button" role="tab" aria-controls="nav-History" aria-selected="false" style="margin-left: 10px;">
                                        <h5>History</h5>
                                    </button>
                                </div>
                            </nav>

                            <div class="tab-content shadow-lg mt-5" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-ContactForm" role="tabpanel" aria-labelledby="nav-ContactForm-tab">
                                    <form class="custom-form contact-form mb-5 mb-lg-0" action="#" method="post" role="form">
                                        <div class="contact-form-body">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <input type="text" name="contact-name" id="contact-name" class="form-control" placeholder="Full name" required>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <input type="email" name="contact-email" id="contact-email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Email address" required>
                                                </div>
                                            </div>

                                            <input type="text" name="contact-company" id="contact-company" class="form-control" placeholder="Company" required>

                                            <textarea name="contact-message" rows="3" class="form-control" id="contact-message" placeholder="Message"></textarea>

                                            <div class="col-lg-4 col-md-10 col-8 mx-auto">
                                                <button type="submit" name="submit" class="form-control">Send message</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="nav-ContactMap" role="tabpanel" aria-labelledby="nav-ContactMap-tab">
                                   
                                    <iframe  class="google-map"  src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d2931.9408125671703!2d21.124844999999997!3d42.704974!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNDLCsDQyJzE3LjkiTiAyMcKwMDcnMjkuNCJF!5e0!3m2!1sen!2s!4v1711551717110!5m2!1sen!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>

                                <div class="tab-pane fade" id="nav-Volenteer" role="tabpanel" aria-labelledby="nav-Volenteer-tab">
                                    <form class="custom-form contact-form mb-5 mb-lg-0" action="#" method="post" role="form">
                                        <div class="contact-form-body">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <input type="text" name="volunteer-name" id="volunteer-name" class="form-control" placeholder="Your full name" required>
                                                </div>
                                    
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <input type="email" name="volunteer-email" id="volunteer-email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Your email address" required>
                                                </div>
                                            </div>
                                    
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <input type="tel" name="volunteer-phone" id="volunteer-phone" class="form-control" placeholder="Your phone number" pattern="383-[0-9]{8}" required>
                                                </div>
                                    
                                                <div class="col-lg-6 col-md-6 col-12">
                                                    <input type="text" name="volunteer-company" id="volunteer-company" class="form-control" placeholder="Current job">
                                                </div>
                                            </div>
                                    
                                            <textarea name="volunteer-message" rows="3" class="form-control" id="volunteer-message" placeholder="Tell us why you want to volunteer and any relevant experience"></textarea>
                                    
                                            <div class="col-lg-4 col-md-10 col-8 mx-auto">
                                                <button type="submit" name="submitform" class="form-control">Submit Volunteer Application</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    
                                </div>
                                <div class="tab-pane fade" id="nav-History" role="tabpanel" aria-labelledby="nav-History-tab">

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12 mx-auto">
                <h3 class="text-center mb-4">Sunny Hill History</h3>
<div class="sort-links">
    <?php
    echo generateSortLink('Lowest Year', 'yearAscending') . ' | ';
    echo generateSortLink('Highest Year', 'yearDescending') . ' | ';
    echo generateSortLink('Lowest Number', 'attendeesAscending') . ' | ';
    echo generateSortLink('Highest Number', 'attendeesDescending');
    ?>
</div><br>
<ul id="festivalList">
    <?php
  $history = [
    "2022" => [
        "year" => "2022",
        "attendees" => 12000,
        "description" => "The 2022 Sunny Hill festival showcased a diverse range of performances and activities, attracting a large audience from around the world.",
    ],
    "2021" => [
        "year" => "2021",
        "attendees" => 11500,
        "description" => "In 2021, the Sunny Hill festival celebrated its 4th anniversary with special events and performances, drawing a record-breaking number of attendees.",
    ],
    "2020" => [
        "year" => "2020",
        "attendees" => 10000,
        "description" => "Despite challenges posed by the pandemic, the 2020 festival successfully transitioned to virtual platforms, engaging audiences globally.",
    ],
    "2019" => [
        "year" => "2019",
        "attendees" => 8500,
        "description" => "The 2019 festival featured a theme of cultural diversity, with performances and exhibitions highlighting traditions from various regions.",
    ],
    "2018" => [
        "year" => "2018",
        "attendees" => 7200,
        "description" => "In 2018, the Sunny Hill festival expanded its program to include workshops and interactive experiences, attracting both local and international participants.",
    ],
];


    // Function to generate sort links with JavaScript sorting
    function generateSortLink($text, $sortType)
    {
        return "<a href=\"{$_SERVER['PHP_SELF']}?sortBy=$sortType\">$text</a>";
    }

    if (isset($_GET['sortBy'])) {
        $sortBy = $_GET['sortBy'];
        switch ($sortBy) {
            case 'yearAscending':
                ksort($history); // Sort by year in ascending order
                break;
            case 'yearDescending':
                krsort($history); // Sort by year in descending order
                break;
            case 'attendeesAscending':
                // Temporary array to hold attendees data for sorting
                $tempArray = [];
                foreach ($history as $key => $value) {
                    $tempArray[$key] = $value['attendees'];
                }
                // Sort the temporary array by attendees in ascending order
                asort($tempArray);
                // Rearrange the original $history array based on sorted attendees data
                $sortedHistory = [];
                foreach ($tempArray as $key => $attendees) {
                    $sortedHistory[$key] = $history[$key];
                }
                $history = $sortedHistory; // Update the sorted array
                break;
            case 'attendeesDescending':
                // Temporary array to hold attendees data for sorting
                $tempArray = [];
                foreach ($history as $key => $value) {
                    $tempArray[$key] = $value['attendees'];
                }
                // Sort the temporary array by attendees in descending order
                arsort($tempArray);
                // Rearrange the original $history array based on sorted attendees data
                $sortedHistory = [];
                foreach ($tempArray as $key => $attendees) {
                    $sortedHistory[$key] = $history[$key];
                }
                $history = $sortedHistory; // Update the sorted array
                break;
            default:
                // Default sorting by year ascending
                ksort($history);
                break;
        }
    }
    // Display sorted festival history
    foreach ($history as $item) {
        $year = $item['year'];
        $attendees = $item['attendees'];
        $description = $item['description'];

    echo "<li><strong>$year:</strong> $attendees attendees</li>";
    echo "<p><em>$description</em></p>";
    }
    ?>
</ul>



<script>
    document.querySelectorAll('.sort-links a').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const sortBy = this.getAttribute('href').split('=')[1];
        const currentURL = new URL(window.location.href);
        currentURL.searchParams.set('sortBy', sortBy);
        window.history.replaceState({}, '', currentURL);
        window.location.reload();
    });
});
</script>
</div>
                </div>
            </div>
        </div>
    </div>
</div>
                            </div>
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
                                <a href="#section_1" class="site-footer-link">Home</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#section_2" class="site-footer-link">About</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#section_3" class="site-footer-link">Artists</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#section_4" class="site-footer-link">Schedule</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#section_5" class="site-footer-link">Pricing</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#section_6" class="site-footer-link">Contact</a>
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

                        <a class="link-fx-1 color-contrast-higher mt-3" href="#section_6">
                            <span>Our Maps</span>
                            <svg class="icon" viewBox="0 0 32 32" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="16" cy="16" r="15.5"></circle><line x1="10" y1="18" x2="16" y2="12"></line><line x1="16" y1="12" x2="22" y2="18"></line></g></svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>


        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/click-scroll.js"></script>
        <script src="js/custom.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>


    </body>
</html>