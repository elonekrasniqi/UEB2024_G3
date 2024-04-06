<?php

//cookie i pare i perdorur per ta ruajtur emrin e personit qe shkruan mesazh
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve form data
    $fullName = $_POST['contact-name'];

    // Set the cookie with the user's full name
    setcookie('user_name', $fullName, time() + (86400 * 30), "/"); // Cookie expires in 30 days
?>
    
    <script>
        var userName = '<?php echo $fullName; ?>';
        var alertBox = alert('Thank you for your message, ' + userName + '!');
       
    </script>
<?php
}
?>
<?php
// Cookie i dyte, ndryshon ngjyren varesisht se cfare vlere merr
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the name from the form
    $name = $_POST["volunteer-name"];
    
    // Generate a color based on the name
    $hash = md5($name); // Generate a hash from the name
    $color = substr($hash, 0, 6); // Take the first 6 characters of the hash
    
    // Set a cookie to remember the color
    setcookie("dynamicColor", $color, time() + (30 * 24 * 60 * 60), "/"); // Cookie valid for 30 days
} else {
    // Check if the dynamicColor cookie is set
    if (isset($_COOKIE["dynamicColor"])) {
        $color = $_COOKIE["dynamicColor"];
    }
}
?>

<?php
// Validimi i datës për muajin korrik të vitit 2024 me RegEx
function validateDate($date) {
    $pattern = '/^2024-07-(25|26|27|28)$/';
    return preg_match($pattern, $date);
}

$date = '2024-07-25';
if (validateDate($date)) {
    echo 'Data është valide për muajin korrik të vitit 2024';
} else {
    echo 'Data nuk është valide për muajin korrik të vitit 2024';
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
<a href="login.html" class="btn custom-btn d-lg-none ms-auto me-4">Buy Ticket</a>

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

    <a href="login.html" class="btn custom-btn d-lg-block d-none" id="buyTicketBtn">Buy Ticket</a>

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
                                    <i class="custom-icon bi-geo-alt me-2" ></i>
                                                        Germia National Park in Prishtina
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


            <section class="artists-section section-padding" id="section_3">
                <div class="container">
                    <div class="row justify-content-center">

                        <div class="col-12 text-center">
                            <h2 class="mb-4">Meet Artists</h1>
                        </div>

                        

                        <div class="col-lg-5">
                            <div class="artists-thumb">
                                <div class="artists-image-wrap">
                                    <img src="images/artists/wallpapersden.com_dua-lipa-photoshoot-2020_1920x2026.jpg" class="artists-image img-fluid">
                                </div>

                                <div class="artists-hover">
                                    <p>
                                        <strong>Name:</strong>
                                        Dua Lipa
                                    </p>

                                    <p>
                                        <strong>Birthdate:</strong>
                                        August 22, 1995
                                    </p>

                                    <p>
                                        <strong>Music:</strong>
                                        Pop
                                    </p>

                                    <hr>

                                    <p class="mb-0">
                                        <strong>Youtube Channel:</strong>
                                        <a href="http://www.youtube.com/@dualipa">Dua Lipa Official</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="artists-thumb">
                                <div class="artists-image-wrap">
                                    <img src="images/artists/Kresha-Lyrical-Son.jpg" class="artists-image img-fluid">
                                </div>

                             <div class="artists-hover"> 
                                    <p>
                                        <strong>Name:</strong>
                                        Mc Kresha & Lyrical Son
                                    </p>

                                    <p>
                                        <strong>Birthdate:</strong>
                                        September 5, 1984 & January 28, 1984
                                    </p>

                                    <p>
                                        <strong>Music:</strong>
                                        Hip Hop
                                    </p>

                                    <hr>

                                    <p class="mb-0">
                                        <strong>Youtube Channel:</strong>
                                        <a href="http://www.youtube.com/@PINTofficial">PINT Official</a>
                                    </p>
                                </div>
                            </div>
                        </div>



                        <div class="col-lg-5">
                            <div class="artists-thumb">
                                <div class="artists-image-wrap">
                                    <img src="images/artists/rihanna_(1)1.jpg" class="artists-image img-fluid">
                                </div>

                                <div class="artists-hover">
                                    <p>
                                        <strong>Name:</strong>
                                    Rihanna
                                    </p>

                                    <p>
                                        <strong>Birthdate:</strong>
                                        February 20, 1988
                                    </p>

                                    <p>
                                        <strong>Music:</strong>
                                        Pop, R&B, EDM, Reggae
                                    </p>

                                    <hr>

                                    <p class="mb-0">
                                        <strong>Youtube Channel:</strong>
                                        <a href="http://www.youtube.com/@rihanna">Rihanna Official</a>
                                    </p>
                                </div>
                            </div>
                        </div>



                       

                        <div class="col-lg-6">
                            <div class="artists-thumb">
                                <div class="artists-image-wrap">
                                    <img src="images/artists/cantante-colombiano-Maluma_1542456436_133521540_1200x675.jpg" class="artists-image img-fluid">
                                </div>

                                <div class="artists-hover">
                                    <p>
                                        <strong>Name:</strong>
                                        Maluma
                                    </p>

                                    <p>
                                        <strong>Birthdate:</strong>
                                        January 28, 1994
                                    </p>

                                    <p>
                                        <strong>Music:</strong>
                                        Pop,Latin Trap
                                    </p>

                                    <hr>

                                    <p class="mb-0">
                                        <strong>Youtube Channel:</strong>
                                        <a href="http://www.youtube.com/@Maluma_Official">Maluma Official</a>
                                    </p>
                                </div>
                            </div>
                            </div>
                            <div class="col-lg-5">
                                    <div class="artists-image-wrap">

                            <div class="artists-thumb">
                                <img src="images/artists/Martin-Garrix-performs-on-stage.webp" class="artists-image img-fluid">

                                <div class="artists-hover">
                                    <p>
                                        <strong>Name:</strong>
                                        Martin Garrix
                                    </p>

                                    <p>
                                        <strong>Birthdate:</strong>
                                        May 14, 1996
                                    </p>

                                    <p>
                                        <strong>Music:</strong>
                                        DJ
                                    </p>

                                    <hr>

                                    <p class="mb-0">
                                        <strong>Youtube Channel:</strong>
                                        <a href="http://www.youtube.com/@brunomars">Martin Garrix Official</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-5">
                        <div class="artists-image-wrap">

                <div class="artists-thumb">
                    <img src="images/artists/Maneskin-by-Tommaso-Ottomano.jpg" class="artists-image img-fluid">

                    <div class="artists-hover">
                        <p>
                            <strong>Name:</strong>
                            Maneskin
                        </p>

                        <p>
                            <strong>Birthdate:</strong>
                            2016
                        </p>

                        <p>
                            <strong>Music:</strong>
                            Rock
                        </p>

                        <hr>

                        <p class="mb-0">
                            <strong>Youtube Channel:</strong>
                            <a href="http://www.youtube.com/@ManeskinOfficial">Maneskin Official</a>
                        </p>
                    </div>
                </div>
            </div>

        </div>
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
            </section>


            <section class="schedule-section section-padding" id="section_4">
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
                                            <td style="background-color:  #d9e3da76">
                                                <h3>Dua Lipa</h3>
                                                <p class="mb-2">08:00 - 09:00 PM</p>
                                                <p>Pop Performance</p>
                                            </td>
                                            <td style="background-color: #d9e3da76">
                                                <h3>McKresha & LyricalSon</h3>
                                                <p class="mb-2">08:00 - 09:00 PM</p>
                                                <p>Pop Performance</p>
                                            </td>
                                            <td style="background-color:  #e3d9dbbe">
                                                <h3>Surprise</h3>
                                                <p class="mb-2">08:00 - 09:00 PM</p>
                                                <p>Surprise Performance</p>
                                            </td>
                                            <td style="background-color: #e3d9dbbe">
                                            <h3>Surprise</h3>
                                            <p class="mb-2">08:00 - 09:00 PM</p>
                                            <p>Surprise Performance</p>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:  #e3d9dbbe">
                                                <h3>Surprise</h3>
                                                <p class="mb-2">09:00- 10:00 PM</p>
                                                <p>Surprise Performance</p>
                                            </td>
                                            <td style="background-color: #e3d9dbbe">
                                                <h3>Surprise</h3>
                                                <p class="mb-2">09:00 - 10:00 PM</p>
                                                <p>Surprise Performance</p>
                                            </td>
                                            <td style="background-color: #e3d9dbbe">
                                                <h3>Surprise</h3>
                                                <p class="mb-2">09:00 - 10:00 PM</p>
                                                <p>Surprise Performance</p>
                                            </td>
                                            <td style="background-color:#e3d9dbbe">
                                                <h3>Surprise</h3>
                                                <p class="mb-2">09:00 - 10:00 PM</p>
                                                <p>Surprise Performance</p>
                                            </td>
                                               
                                        </tr>
                                        <tr>
                                            <td style="background-color: #e3d9dbbe">
                                                <h3>Surprise</h3>
                                                <p class="mb-2">10:00- 11:00 PM</p>
                                                <p>Surprise Performance</p>
                                            </td>
                                            <td style="background-color:  #d9e3da76">
                                                <h3>Martin Garrix</h3>
                                                <p class="mb-2">10:00 - 11:00 PM</p>
                                                <p>DJ</p>
                                            </td>
                                            
                                            <td style="background-color: #e3d9dbbe">
                                                <h3>Surprise</h3>
                                                <p class="mb-2">10:00- 11:00 PM</p>
                                                <p>Surprise Performance</p>
                                            </td>
                                            <td style="background-color:  #d9e3da76">
                                                <h3>Maneskin</h3>
                                                <p class="mb-2">10:00 - 11:00 PM</p>
                                                <p>Rock</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #d9e3da76">
                                                <h3>Maluma</h3>
                                                <p class="mb-2">11:00 - 12:00 PM</p>
                                                <p>Rock & Roll</p>
                                            </td>
                                            <td style="background-color:#e3d9dbbe">
                                                <h3>Surprise</h3>
                                                <p class="mb-2">11:00 - 12:00 PM</p>
                                                <p>Surprise Performance</p>
                                            </td>
                                            <td style="background-color: #e3d9dbbe">
                                                <h3>Surprise</h3>
                                                <p class="mb-2">11:00 - 12:00 PM</p>
                                                <p>Surprise Performance</p>
                                            </td>
                                            <td style="background-color: #e3d9dbbe">
                                                <h3>Surprise</h3>
                                                <p class="mb-2">11:00 - 12:00 PM</p>
                                                <p>Surprise Performance</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: #e3d9dbbe">
                                                <h3>Surprise</h3>
                                                <p class="mb-2">12:00 PM- 01:00 AM</p>
                                                <p>Surprise Performance</p>
                                            </td>
                                            <td style="background-color: #e3d9dbbe">
                                                <h3>Surprise</h3>
                                                <p class="mb-2">12:00 PM- 01:00 AM</p>
                                                <p>Surprise Performance</p>
                                            </td>
                                            <td style="background-color:  #d9e3da76">
                                                <h3>Rihanna</h3>
                                                <p class="mb-2">12:00 PM- 01:00 AM</p>
                                                <p>Pop Performance</p>
                                            </td>
                                            <td style="background-color: #e3d9dbbe">
                                                <h3>Surprise</h3>
                                                <p class="mb-2">12:00 PM- 01:00 AM</p>
                                                <p>Surprise Performance</p>
                                            </td>
                                        </tr>
                                       

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            


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

                                <a class="link-fx-1 color-contrast-higher mt-4" href="ticket.html">
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

                                <a class="link-fx-1 color-contrast-higher mt-4" href="ticket.html">
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
                            <h2 class="text-center mb-4">Interested? Let's talk</h2>

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
                                                <button type="submit" class="form-control">Send message</button>
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
                                                <button type="submit" class="form-control">Submit Volunteer Application</button>
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

    </body>
</html>