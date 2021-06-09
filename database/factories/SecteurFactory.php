<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Secteur;
use Faker\Generator as Faker;

$factory->define(Secteur::class, function (Faker $faker) {
    return [
        'secteur_fr' => $faker->unique()->sentence,
        'secteur_ar' => $faker->unique()->sentence,
    ];
});
