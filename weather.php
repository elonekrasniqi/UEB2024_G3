<?php
$apiKey = '9599fb45dd28fca2d150a61ffe6e2898';
$location = 'Pristina';
$url = "http://api.openweathermap.org/data/2.5/weather?q=$location&APPID=$apiKey";

$response = @file_get_contents($url);

if ($response === false) {
    $error = error_get_last();
    if ($error !== null) {
        $errorMessage = $error['message'];
    } else {
        $errorMessage = 'Gabim në lidhjen me API.';
    }
    $weatherDescription = $errorMessage;
    $temperature = 'N/A';
} else {
    $weatherData = json_decode($response);

    if ($weatherData->cod == 404) {
        $weatherDescription = 'Qyteti nuk u gjet.';
        $temperature = 'N/A';
    } elseif (json_last_error() === JSON_ERROR_NONE) {
        $weatherDescription = $weatherData->weather[0]->description;
        // Convert temperature from Kelvin to Celsius
        $temperatureKelvin = $weatherData->main->temp;
        $temperatureCelsius = $temperatureKelvin - 273.15;
        $temperature = round($temperatureCelsius, 1); // Round to 1 decimal place
    } else {
        $weatherDescription = 'Nuk ka të dhëna të vlefshme për motin.';
        $temperature = 'N/A';
    }
}
?>
