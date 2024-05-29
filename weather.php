<?php
// Definimi i çelësit API të OpenWeatherMap
$apiKey = '9599fb45dd28fca2d150a61ffe6e2898';

$location = 'Prishtine';

// Kërkesa HTTP GET në API për të marrë informacionin e motit
$url = "http://api.openweathermap.org/data/2.5/forecast?q=$location&appid=$apiKey&units=metric";
$response = @file_get_contents($url);

$weatherDescription = '';
$temperature = '';

if ($response) {
    $weatherData = json_decode($response);

    // Kontrolli nëse kemi të dhëna të vlefshme në përgjigje
    if (isset($weatherData->list) && count($weatherData->list) > 0) {
        // Përdorimi i parashikimit të parë për shembull
        $weatherDescription = $weatherData->list[0]->weather[0]->description;
        $temperature = $weatherData->list[0]->main->temp;
    } else {
        $weatherDescription = 'Nuk ka të dhëna të vlefshme për motin.';
        $temperature = 'N/A';
    }
} else {
    $weatherDescription = 'Gabim në marrjen e informacionit të motit.';
    $temperature = 'N/A';
}
?>
