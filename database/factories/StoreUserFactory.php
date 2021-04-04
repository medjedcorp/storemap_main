<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\StoreUser;
use Faker\Generator as Faker;

$factory->define(App\Models\StoreUser::class, function (Faker $faker) {
    return [
        // 'store_id' => $faker->numberBetween(4,20),
        // 'user_id' => $faker->numberBetween(4,100),

        'store_id' => function () {
            return factory(App\Models\Store::class)->create()->id;
        },
        'user_id' => function () {
            return factory(App\Models\User::class)->create()->id;
        },
    ];
});
