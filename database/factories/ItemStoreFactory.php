<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ItemStore;
use Faker\Generator as Faker;

$factory->define(App\Models\ItemStore::class, function (Faker $faker) {
    return [
        // 'store_id' => $faker->numberBetween(4, 1000),
        'store_id' => function () {
            return factory(App\Models\Store::class)->create()->id;
        },
        'item_id' => function () {
            return factory(App\Models\Item::class)->create()->id;
        },
        'catch_copy' => $faker->realText($faker->numberBetween(10,50)),
        'shelf_number' => $faker->colorName,
        'sort_num' => $faker->randomNumber($nbDigits = 3, $strict = false),
        'selling_flag' => $faker->boolean,
        'price_type' => $faker->numberBetween($min = 0, $max = 2),
        'price' => $faker->numberBetween($min = 10, $max = 9999999),
        'value' => $faker->randomNumber($nbDigits = 3, $strict = false),
        'start_date' => $faker->dateTimeAd,
        'end_date' => $faker->dateTimeAd,
        'stock_amount' => $faker->numberBetween($min = 1, $max = 100),
        'stock_set' => $faker->boolean,
    ];
});
