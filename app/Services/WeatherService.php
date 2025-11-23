<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getCurrentWeather()
    {
        $city = env('OPENWEATHER_CITY', 'Jakarta');
        $apiKey = env('OPENWEATHER_API_KEY');
        $units = env('OPENWEATHER_UNITS', 'metric');

        $url = "https://api.openweathermap.org/data/2.5/weather";

        $response = Http::get($url, [
            'q' => $city,
            'appid' => $apiKey,
            'units' => $units
        ]);

        if (!$response->successful()) {
            return null;
        }

        return $response->json();
    }
}
