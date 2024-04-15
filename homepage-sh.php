<?php // homepage ne gjuhen shqipe
session_start();

if (isset($_GET['gjuha'])) {
    $gjuha_zgjedhur = $_GET['gjuha'];
    $_SESSION['gjuha'] = $gjuha_zgjedhur;

    // Redirect the user to the desired page
    if ($gjuha_zgjedhur == 'albanian') {
        header("Location: index.php");
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
        echo "<script>alert('Faleminderit qe na kontaktuat, $fullName!');</script>";
    }
    //cookie i dyte, ndryshon ngjyren varesisht qfare vlere merr
    // Handle the volunteer form submission
    elseif (isset($_POST['volunteer-name'])) {
        $name = $_POST["volunteer-name"];
        $hash = md5($name); // Generate a hash from the name
        $color = substr($hash, 0, 6); // Take the first 6 characters of the hash
        setcookie("dynamicColor", $color, time() + (30 * 24 * 60 * 60), "/"); // Cookie valid for 30 days
    }
    
   
}
//cookie i trete qe e merr emrin nga forma per vullnetare dhe vendos alert after submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (isset($_POST['submitform'])) {
    $fullNameVol = $_POST['volunteer-name'];
    setcookie('volunteer-name', $fullNameVol, time() + (86400 * 30), "/"); // Cookie expires in 30 days
    echo "<script>alert('Faleminderit per aplikimin, $fullNameVol! Ne do t'iu kontaktojme shume shpejt!');</script>";
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

        <title>Festivali Sunny Hill</title>

             
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
                        echo "<span>Mireseerdhe, " . $_SESSION['fullname'] . "! </span>"; // Shfaq emrin e përdoruesit në një span të veçantë
                        echo "Kjo është hera " . $_SESSION['login_count'] . " që jeni kycur.";
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
                    <a class="navbar-brand" href="index.html" id="logo" style="transition: transform 0.3s ease; display: inline-block;">
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
                    
<a href="login.html" class="btn custom-btn d-lg-none ms-auto me-4">Blejë Tiketë</a>

<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav align-items-lg-center ms-auto me-lg-5">
        <li class="nav-item">
            <a class="nav-link click-scroll" href="#section_1" onclick="addEffect(this)">Kryesore</a>
        </li>

        <li class="nav-item">
            <a class="nav-link click-scroll" href="#section_2" onclick="addEffect(this)">Rreth nesh</a>
        </li>

        <li class="nav-item">
            <a class="nav-link click-scroll" href="#section_3" onclick="addEffect(this)">Aritstë</a>
        </li>

        <li class="nav-item">
            <a class="nav-link click-scroll" href="#section_4" onclick="addEffect(this)">Orari</a>
        </li>

        <li class="nav-item">
            <a class="nav-link click-scroll" href="#section_5" onclick="addEffect(this)">Caktimi</a>
        </li>

        <li class="nav-item">
            <a class="nav-link click-scroll" href="#section_6" onclick="addEffect(this)">Kontakt</a>
        </li>
    </ul>

    <a href="ticket.php" class="btn custom-btn d-lg-block d-none" id="buyTicketBtn">Blejë Tiketë</a>
    <div class="dropdown">
    <button class="btn custom-btn d-lg-block d-none dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="margin-left: 45px;">
        Gjuha
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

                            <h1 class="text-white mb-5">Festivali Sunny Hill 2024</h1>

                            <a class="btn custom-btn smoothscroll" href="#section_2">Le të fillojmë</a>
                        </div>

                        <div class="col-lg-12 col-12 mt-auto d-flex flex-column flex-lg-row text-center">
                            <div class="date-wrap">
                                <h5 class="text-white">
                                    <i class="custom-icon bi-clock me-2"></i>
                                    25 - 28<sup>th</sup>, Korrik 2024
                                </h5>
                            </div>

                            <div class="location-wrap mx-auto py-3 py-lg-0">
                                <h5 class="text-white">
                                    <i class="custom-icon bi-geo-alt me-2" ></i>Parku i Festivalit Sunny Hill, Prishtina 10000, Kosova
                                </h5>
                            </div>

                           
                        </div>
                    </div>
                </div>

                <div class="video-wrap">
    <video autoplay loop muted class="custom-video" poster="">
        <source src="video/Video-79.mp4" type="video/mp4">
        Shfletuesi juaj nuk e mbështet etiketën video
    </video>
</div>
</section>

<section class="about-section section-padding" id="section_2">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12 mb-4 mb-lg-0 d-flex align-items-center">
                <div class="services-info">
                    <h2 class="text-white mb-4">Rreth Sunny Hill Festival 2024</h2>
                    <p class="text-white">Festivali SUNNY HILL është festivali më i madh muzikor në Kosovë dhe bazuar në headliner-at, ndoshta më i madhi në Evropën Juglindore. Festivali ndërkombëtar i standardeve më të larta, një festival që vendos Prishtinën – Kosovën në hartën e festivaleve si një vend kulturor që nuk duhet humbur, në një vend që e do muzikën dhe di të argëtohet.</p>
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
                            <h3>moment i lumtur</h3>
                            <p class="mb-0">Kaloni ditë të mrekullueshme me ne</p>
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


// Vargu i ri për të ruajtur informacionin e artistit
$artistsInfo = [
    'Dua Lipa' => [
        'image' => 'images/artists/wallpapersden.com_dua-lipa-photoshoot-2020_1920x2026.jpg',
        'birthdate' => '22 Gusht 1995',
        'music' => 'Pop',
        'youtube' => 'http://www.youtube.com/@dualipa'
    ],
    'Mc Kresha & Lyrical Son' => [
        'image' => 'images/artists/Kresha-Lyrical-Son.jpg',
        'birthdate' => '5 Shtator 1984 & 28 Janar 1984',
        'music' => 'Hip Hop',
        'youtube' => 'http://www.youtube.com/@PINTofficial'
    ],
    'Rihanna' => [
        'image' => 'images/artists/rihanna_(1)1.jpg',
        'birthdate' => '20 Shkurt 1988',
        'music' => 'Pop, R&B, EDM, Reggae',
        'youtube' => 'http://www.youtube.com/@rihanna'
    ],
    'Maluma' => [
        'image' => 'images/artists/cantante-colombiano-Maluma_1542456436_133521540_1200x675.jpg',
        'birthdate' => '28 Janar 1994',
        'music' => 'Pop, Latin Trap',
        'youtube' => 'http://www.youtube.com/@Maluma_Official'
    ],
    'Martin Garrix' => [
        'image' => 'images/artists/Martin-Garrix-performs-on-stage.webp',
        'birthdate' => '14 Maj 1996',
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
                <h2 class="mb-4">Takohu me Artistët</h2>
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
                            <strong>Emri:</strong>
                            ' . $artist . '
                        </p>
                        <p>
                            <strong>Datelindja:</strong>
                            ' . $artistInfo['birthdate'] . '
                        </p>
                        <p>
                            <strong>Muzika:</strong>
                            ' . $artistInfo['music'] . '
                        </p>
                        <hr>
                        <p class="mb-0">
                            <strong>Kanali Youtube:</strong>
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
                        <strong style="color: white;">Artistë të tjerë së shpejti...</strong>
                    </p>
                </marquee>
            </div>
        </div>
    </div>
</section> <br>';
?>
<?php
// Funksioni për të shtuar presjet në mes të numrave brenda datëlindjeve
function Manipulimi_ditelindja($html) {
    // Definojmë me RegEx formatin e datëlindjes
    $pattern = '/(<strong>Datelindja:<\/strong>\s*)([A-Za-z]+\s+\d{1,2})\s+(\d{4})/';

    // Definojmë zëvendësimin e karakterit në mes të datëlindjes
    $replacement = '$1$2, $3';

    // Shtojmë presjen në mes të datëlindjes me funksionin preg_replace
    $html_me_presje = preg_replace($pattern, $replacement, $html);

    return $html_me_presje;
}

// Shto presjen te datat e lindjes
$html_me_presje = Manipulimi_ditelindja($html);

// Outputi i HTML të modifikuar
echo $html_me_presje;
?>


<?php
$orari_html = '<section class="schedule-section section-padding" id="section_4">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-black mb-4">Orari i Festivalit</h2>
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
                                <th scope="col">Dita 1 - E Enjte</th>
                                <th scope="col">Dita 2 - E Premte</th>
                                <th scope="col">Dita 3 - E Shtunë</th>
                                <th scope="col">Dita 4 - E Diel</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="background-color: #d9e3da76">
                                    <h3>Dua Lipa</h3>
                                    <p class="mb-2">08:00 PM 09:00 PM</p>
                                    <p>Performancë Pop</p>
                                </td>
                                <td style="background-color: #d9e3da76">
                                    <h3>McKresha & LyricalSon</h3>
                                    <p class="mb-2">08:00 PM 09:00 PM</p>
                                    <p>Performancë Pop</p>
                                </td>
                                <td style="background-color: #e3d9dbbe">
                                    <h3>Surprizë</h3>
                                    <p class="mb-2">08:00 PM 09:00 PM</p>
                                    <p>Performancë Surprizë</p>
                                </td>
                                <td style="background-color: #e3d9dbbe">
                                    <h3>Surprizë</h3>
                                    <p class="mb-2">08:00 PM 09:00 PM</p>
                                    <p>Performancë Surprizë</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: #e3d9dbbe">
                                    <h3>Surprizë</h3>
                                    <p class="mb-2">09:00 PM 10:00 PM</p>
                                    <p>Performancë Surprizë</p>
                                </td>
                                <td style="background-color: #e3d9dbbe">
                                    <h3>Surprizë</h3>
                                    <p class="mb-2">09:00 PM 10:00 PM</p>
                                    <p>Performancë Surprizë</p>
                                </td>
                                <td style="background-color: #e3d9dbbe">
                                    <h3>Surprizë</h3>
                                    <p class="mb-2">09:00 PM 10:00 PM</p>
                                    <p>Performancë Surprizë</p>
                                </td>
                                <td style="background-color: #e3d9dbbe">
                                    <h3>Surprizë</h3>
                                    <p class="mb-2">09:00 PM 10:00 PM</p>
                                    <p>Performancë Surprizë</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: #e3d9dbbe">
                                    <h3>Surprizë</h3>
                                    <p class="mb-2">10:00 PM 11:00 PM</p>
                                    <p>Performancë Surprizë</p>
                                </td>
                                <td style="background-color: #d9e3da76">
                                    <h3>Martin Garrix</h3>
                                    <p class="mb-2">10:00 PM 11:00 PM</p>
                                    <p>DJ</p>
                                </td>
                                <td style="background-color: #e3d9dbbe">
                                    <h3>Surprizë</h3>
                                    <p class="mb-2">10:00 PM 11:00 PM</p>
                                    <p>Performancë Surprizë</p>
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
                                    <h3>Surprizë</h3>
                                    <p class="mb-2">11:00 PM 12:00 PM</p>
                                    <p>Performancë Surprizë</p>
                                </td>
                                <td style="background-color: #e3d9dbbe">
                                    <h3>Surprizë</h3>
                                    <p class="mb-2">11:00 PM 12:00 PM</p>
                                    <p>Performancë Surprizë</p>
                                </td>
                                <td style="background-color: #e3d9dbbe">
                                    <h3>Surprizë</h3>
                                    <p class="mb-2">11:00 PM 12:00 PM</p>
                                    <p>Performancë Surprizë</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: #e3d9dbbe">
                                    <h3>Surprizë</h3>
                                    <p class="mb-2">12:00 PM 01:00 AM</p>
                                    <p>Performancë Surprizë</p>
                                </td>
                                <td style="background-color: #e3d9dbbe">
                                    <h3>Surprizë</h3>
                                    <p class="mb-2">12:00 PM 01:00 AM</p>
                                    <p>Performancë Surprizë</p>
                                </td>
                                <td style="background-color: #d9e3da76">
                                    <h3>Rihanna</h3>
                                    <p class="mb-2">12:00 PM 01:00 AM</p>
                                    <p>Performancë Pop</p>
                                </td>
                                <td style="background-color: #e3d9dbbe">
                                    <h3>Surprizë</h3>
                                    <p class="mb-2">12:00 PM 01:00 AM</p>
                                    <p>Performancë Surprizë</p>
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
    <h2 class="text-center mb-4">Plani, do t'ju pëlqejë</h2>
</div>

<div class="col-lg-6 col-12">
    <div class="pricing-thumb">
        <div class="d-flex">
            <div>
                <h3><small>Early Bird</small> $120</h3>
                <p>Duke përfshirë gjëra të mira:</p>
            </div>
            <p class="pricing-tag ms-auto">Ruaj deri në <span>50%</span></p>
        </div>
        <ul class="pricing-list mt-3">
            <li class="pricing-list-item">platformë për klientë të mundshëm</li>
            <li class="pricing-list-item">përvojë dixhitale</li>
            <li class="pricing-list-item">zë cilësor</li>
            <li class="pricing-list-item">përmbajtje standard</li>
        </ul>
        <a class="link-fx-1 color-contrast-higher mt-4" href="ticket.php">
            <span>Bleni Biletën</span>
            <svg class="icon" viewBox="0 0 32 32" aria-hidden="true">
                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="16" cy="16" r="15.5"></circle>
                    <line x1="10" y1="18" x2="16" y2="12"></line>
                    <line x1="16" y1="12" x2="22" y2="18"></line>
                </g>
            </svg>
        </a>
    </div>
</div>

<div class="col-lg-6 col-12 mt-4 mt-lg-0">
    <div class="pricing-thumb">
        <div class="d-flex">
            <div>
                <h3><small>Standard</small> $240</h3>
                <p>Çfarë e bën një festival premium?</p>
            </div>
        </div>
        <ul class="pricing-list mt-3">
            <li class="pricing-list-item">platformë për klientë të mundshëm</li>
            <li class="pricing-list-item">përvojë dixhitale</li>
            <li class="pricing-list-item">zë cilësor</li>
            <li class="pricing-list-item">përmbajtje premium</li>
            <li class="pricing-list-item">mbështetje live chat</li>
        </ul>
        <a class="link-fx-1 color-contrast-higher mt-4" href="ticket.php">
            <span>Bleni Biletën</span>
            <svg class="icon" viewBox="0 0 32 32" aria-hidden="true">
                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="16" cy="16" r="15.5"></circle>
                    <line x1="10" y1="18" x2="16" y2="12"></line>
                    <line x1="16" y1="12" x2="22" y2="18"></line>
                </g>
            </svg>
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
                <h2 class="text-center mb-4">Të interesuar? Le të bisedojmë</h2>
                <nav class="d-flex justify-content-center">
                    <div class="nav nav-tabs align-items-baseline justify-content-center" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-ContactForm-tab" data-bs-toggle="tab" data-bs-target="#nav-ContactForm" type="button" role="tab" aria-controls="nav-ContactForm" aria-selected="false">
                            <h5>Formulari i Kontaktit</h5>
                        </button>
                        <button class="nav-link" id="nav-ContactMap-tab" data-bs-toggle="tab" data-bs-target="#nav-ContactMap" type="button" role="tab" aria-controls="nav-ContactMap" aria-selected="false">
                            <h5>Harta</h5>
                        </button>
                        <button class="nav-link" id="nav-Volenteer-tab" data-bs-toggle="tab" data-bs-target="#nav-Volenteer" type="button" role="tab" aria-controls="nav-Volenteer" aria-selected="false" style="margin-left: 10px;">
                            <h5>Vullnetare</h5>
                        </button>
                    </div>
                </nav>
                <div class="tab-content shadow-lg mt-5" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-ContactForm" role="tabpanel" aria-labelledby="nav-ContactForm-tab">
                        <form class="custom-form contact-form mb-5 mb-lg-0" action="#" method="post" role="form">
                            <div class="contact-form-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <input type="text" name="contact-name" id="contact-name" class="form-control" placeholder="Emri i plotë" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <input type="email" name="contact-email" id="contact-email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Adresa email" required>
                                    </div>
                                </div>
                                <input type="text" name="contact-company" id="contact-company" class="form-control" placeholder="Kompania" required>
                                <textarea name="contact-message" rows="3" class="form-control" id="contact-message" placeholder="Mesazhi"></textarea>
                                <div class="col-lg-4 col-md-10 col-8 mx-auto">
                                    <button type="submit" name="submit" class="form-control">Dërgo mesazhin</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-ContactMap" role="tabpanel" aria-labelledby="nav-ContactMap-tab">
                        <iframe class="google-map" src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d2931.9408125671703!2d21.124844999999997!3d42.704974!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNDLCsDQyJzE3LjkiTiAyMcKwMDcnMjkuNCJF!5e0!3m2!1sen!2s!4v1711551717110!5m2!1sen!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="tab-pane fade" id="nav-Volenteer" role="tabpanel" aria-labelledby="nav-Volenteer-tab">
                        <form class="custom-form contact-form mb-5 mb-lg-0" action="#" method="post" role="form">
                            <div class="contact-form-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <input type="text" name="volunteer-name" id="volunteer-name" class="form-control" placeholder="Emri juaj i plotë" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <input type="email" name="volunteer-email" id="volunteer-email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Adresa juaj email" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <input type="tel" name="volunteer-phone" id="volunteer-phone" class="form-control" placeholder="Numri juaj i telefonit" pattern="383-[0-9]{8}" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <input type="text" name="volunteer-company" id="volunteer-company" class="form-control" placeholder="Puna aktuale">
                                    </div>
                                </div>
                                <textarea name="volunteer-message" rows="3" class="form-control" id="volunteer-message" placeholder="Tregoni përse dëshironi të jeni vullnetar dhe përvoja relevante"></textarea>
                                <div class="col-lg-4 col-md-10 col-8 mx-auto">
                                    <button type="submit" name="submitform" class="form-control">Dërgo Aplikimin per Vullnetare</button>
                                </div>
                            </div>
                        </form>
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
                            <h2 class="text-white mb-lg-0">Festivali Sunny Hill</h2>
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
    <h5 class="site-footer-title mb-3">Linqet</h5>
    <ul class="site-footer-links">
        <li class="site-footer-link-item">
            <a href="#section_1" class="site-footer-link">Faqja kryesore</a>
        </li>
        <li class="site-footer-link-item">
            <a href="#section_2" class="site-footer-link">Rreth nesh</a>
        </li>
        <li class="site-footer-link-item">
            <a href="#section_3" class="site-footer-link">Artistë</a>
        </li>
        <li class="site-footer-link-item">
            <a href="#section_4" class="site-footer-link">Orari</a>
        </li>
        <li class="site-footer-link-item">
            <a href="#section_5" class="site-footer-link">Caktimi</a>
        </li>
        <li class="site-footer-link-item">
            <a href="#section_6" class="site-footer-link">Kontakt</a>
        </li>
    </ul>
</div>

<div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0">
    <h5 class="site-footer-title mb-3">Keni një pyetje?</h5>
    <p class="text-white d-flex">
        <a href="mailto:info@sunnyhillfestival.com" class="site-footer-link">info@sunnyhillfestival.com</a>
    </p>
</div>

<div class="col-lg-3 col-md-6 col-11 mb-4 mb-lg-0 mb-md-0">
    <h5 class="site-footer-title mb-3">Vendndodhja</h5>
    <p class="text-white d-flex mt-3 mb-2">ENVER MALOKU, NR. 82, PRISHTINA 10000 KOSOVO</p>
    <a class="link-fx-1 color-contrast-higher mt-3" href="#section_6">
        <span>Hartat Tona</span>
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
