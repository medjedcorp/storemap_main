<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Topic;
use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {
    return [
        'title' => $faker->realText(50),
        'info' => $faker->numberBetween(0,5),
        'content' => $faker->realText(800),
    ];
});
