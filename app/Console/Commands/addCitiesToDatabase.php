<?php

namespace App\Console\Commands;

use App\Models\City;
use Illuminate\Console\Command;

class addCitiesToDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-cities-to-database';

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
        $cities = [];

        try {
            $cities = json_decode(file_get_contents(storage_path() . "/data/current.city.list.json"), true);
        } catch (Exception $e) {
            throw new Exception('Unable to connect to the API server');
        }

        foreach ($cities as $city) {
            $this->saveCity($city);
        }
    }

    private function saveCity(array $city): void
    {
        $cityModel = new City;
        $cityModel->name = $city['name'];
        $cityModel->external_id = $city['id'];
        $cityModel->lat = (string)$city['coord']['lat'];
        $cityModel->lon = (string)$city['coord']['lon'];

        $cityModel->save();
    }
}
