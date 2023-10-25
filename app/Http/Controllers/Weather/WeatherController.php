<?php

namespace App\Http\Controllers\Weather;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WeatherController extends Controller
{
    public function index()
    {
        $apiKey = '95f1b088ea68e8aff51b9e1d19569390';
        $lat = 56.8796; 
        $lon = 24.6032; 
        $url = "https://api.openweathermap.org/data/2.5/forecast?lat={$lat}&lon={$lon}&appid={$apiKey}";
        
        $response = \Http::get($url);
        $hourlyData = json_decode($response->getBody());
        $forecastData = json_decode($response->getBody());

        // Prepare the data for the Chart.js chart
        $labels = []; // Array of timestamps
        $data = [];   // Array of temperature or other data

        // Filter data for the first day (24 hours)
        $today = date('Y-m-d');
        $dataCount = 0;
        $currentDay = null;

        foreach ($hourlyData->list as $entry) {
            $timestamp = $entry->dt; // Unix timestamp
            $date = date('Y-m-d', $timestamp);

            

            if ($date === $today) {
                $temperature = $entry->main->temp - 273.15; // Convert from Kelvin to Celsius
                $windSpeed = $entry->wind->speed;

                $labels[] = date('H:i', $timestamp);
                $data[] = $temperature;
                $windSpeedData[] = $windSpeed;


                $dataCount++;

                // You can stop after retrieving 24 hours of data for the first day
                if ($dataCount === 24) {
                    break;
                }
            }
        }

        $dailyForecasts = [];
        $minTemperature = PHP_INT_MAX;
        $maxTemperature = -PHP_INT_MAX;

        foreach ($forecastData->list as $entry) {
            $timestamp = $entry->dt; // Unix timestamp
            $date = date('Y-m-d', $timestamp);

            $carbonDate = Carbon::parse($date);
            $formattedDate = $carbonDate->isoFormat('MMM D'); // E.g., "Oct 24"

            // Check if the date has changed, indicating a new day
            if ($date !== $currentDay) {
                if ($currentDay !== null) {
                    // Store the min and max temperature for the previous day
                    $dailyForecasts[] = [
                        'day' => date('l', strtotime($currentDay)), // Day of the week
                        'date' => $formattedDate, // Date format
                        'icon' => $icon, // Weather icon code
                        'description' => $description,
                        'temp_min' => $minTemperature,
                        'temp_max' => $maxTemperature,
                    ];
                }

                // Reset the min and max temperature for the new day
                $minTemperature = PHP_INT_MAX;
                $maxTemperature = -PHP_INT_MAX;

                $currentDay = $date;
                $icon = $entry->weather[0]->icon;
                $description = $entry->weather[0]->description;
            }

            // Calculate the min and max temperatures for the current day
            $temperature = $entry->main->temp - 273.15; // Convert from Kelvin to Celsius
            if ($temperature < $minTemperature) {
                $minTemperature = $temperature;
            }
            if ($temperature > $maxTemperature) {
                $maxTemperature = $temperature;
            }
        }

        // Add the last day's data to the array
        if ($currentDay !== null) {
            $dailyForecasts[] = [
                'day' => date('l', strtotime($currentDay)), // Day of the week
                'date' => $formattedDate, // Date format
                'icon' => $icon, // Weather icon code
                'description' => $description,
                'temp_min' => $minTemperature,
                'temp_max' => $maxTemperature,
            ];
        }

        $translatedDailyForecasts = [];

        foreach ($dailyForecasts as $forecast) {
            $translatedForecast = [
                'day' => trans($forecast['day']), // Translate the day
                'date' => trans($forecast['date']), // Translate the date
                'icon' => $forecast['icon'], // No translation for icon
                'description' => trans($forecast['description']), // Translate the description
                'temp_min' => $forecast['temp_min'], // No translation for temperature
                'temp_max' => $forecast['temp_max'], // No translation for temperature
            ];

            $translatedDailyForecasts[] = $translatedForecast;
        }

        return view('weather.index', compact('labels', 'data', 'translatedDailyForecasts', 'windSpeedData'));
    }















}
