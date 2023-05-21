<?php

namespace App\Http\Controllers;

use App\Models\Weather;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function getWeatherForCity(Request $request)
    {
        $city = $request->get('city');

        if(!$city) {
            throw new Exception('Missing city parameter');
        }

        $weatherData = Weather::where('city_name', $city)->whereBetween('created_at', [Carbon::now()->subHours(24), Carbon::now()])->get();

        return $weatherData;
    }

    public function getWeather(Request $request)
    {

        $weatherData = Weather::whereBetween('created_at', [Carbon::now()->subHours(24), Carbon::now()])->get();

        return $weatherData;
    }
}
