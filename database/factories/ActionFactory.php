<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Action;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Models\Action::class, function (Faker $faker) {
    return [
        'action_fr' => $faker->unique()->name,
        'action_ar' => $faker->unique()->name,
    ];
});
