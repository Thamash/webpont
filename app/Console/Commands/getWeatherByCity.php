<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Weather;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class getWeatherByCity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-weather-by-city';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cities = City::all();

        foreach ($cities as $city) {
            $response = [];

            try {
                $response = Http::get(env("OPEN_WEATHER_API_URL") . "/weather?lat={$city['lat']}&lon={$city['lon']}&APPID=".env("OPEN_WEATHER_API_KEY")."&units=metric");
            } catch (Exception $e) {
                throw new Exception('Unable to connect to the API server');
            }
            $weatherData = json_decode($response->body(), true);

            $this->saveWeatherData($weatherData);
        }
    }

    private function saveWeatherData(array $weatherData): void
    {
        $weatherModel = new Weather;

        $weatherModel->city_name = $weatherData['name'];
        $weatherModel->city_id = $weatherData['id'];
        $weatherModel->lon = (string)$weatherData['coord']['lon'];
        $weatherModel->lat = (string)$weatherData['coord']['lat'];
        $weatherModel->temp = (string)$weatherData['main']['temp'];
        $weatherModel->pressure = (string)$weatherData['main']['pressure'];
        $weatherModel->humidity = (string)$weatherData['main']['humidity'];
        $weatherModel->temp_min = (string)$weatherData['main']['temp_min'];
        $weatherModel->temp_max = (string)$weatherData['main']['temp_max'];

        $weatherModel->save();
    }
}
