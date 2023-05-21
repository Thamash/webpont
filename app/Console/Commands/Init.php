<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Init extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setting up the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('migrate');
        Artisan::call('app:add-cities-to-database');
    }
}
