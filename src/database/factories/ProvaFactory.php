<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Models\Prova;

$factory->define(Prova::class, function (Faker $faker) {
    return [
        'tipo_prova' => rand(3, 40)."km",
        'data' => $faker->date($format = 'Y-m-d', $max = 'now'),
    ];
});