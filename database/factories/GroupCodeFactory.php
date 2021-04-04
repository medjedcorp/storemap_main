<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GroupCode;
use Faker\Generator as Faker;

$factory->define(App\Models\GroupCode::class, function (Faker $faker) {
    return [
      'company_id' => function () {
              return factory(App\Models\Company::class)->create()->id;
          },
      'group_code'      =>  $faker->unique()->uuid,
    ];
});
