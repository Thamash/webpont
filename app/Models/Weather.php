<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_name'.
        'city_id',
        'lon',
        'lat',
        'temp',
        'pressure',
        'humidity',
        'temp_min',
        'temp_max',
    ];
}
