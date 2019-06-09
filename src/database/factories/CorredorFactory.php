<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Corredor;
use Faker\Generator as Faker;

$factory->define(Corredor::class, function (Faker $faker) {
    return [
        'nome' => $faker->name,
        'cpf' => '10822178087',
        'data_nascimento' => $faker->date($format = 'Y-m-d', $max = 'now'),
    ];
});