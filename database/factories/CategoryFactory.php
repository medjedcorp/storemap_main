<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(App\Models\Category::class, function (Faker $faker) {
    return [
      'category_code'   =>  $faker->unique()->text($maxNbChars = 30),
      'company_id' => function () {
        return factory(App\Models\Company::class)->create()->id;
      },
      'category_name'      =>  $faker->realText($maxNbChars = 125),
      'display_flag'      =>  $faker->boolean,
    ];
});
