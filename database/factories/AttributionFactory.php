<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Models\Attribution::class, function (Faker $faker) {
    return [
        'attribution_fr' => $faker->unique()->name,
        'attribution_ar' => $faker->unique()->name,
        'secteur_id' => $faker->numberBetween(1, 12)
    ];
});
