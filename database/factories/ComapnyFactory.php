<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Company;
use Faker\Generator as Faker;

$factory->define(App\Models\Company::class, function (Faker $faker) {
    return [
//      'user_id' => function() {
//    return factory(App\Models\User::class)->create()->id;
//},
      'company_name' => $faker->company,
      // 'company_code' => $faker->unique()->userName,
      'company_postcode'  =>  $faker->postcode,
      'prefecture' =>  $faker->prefecture,
      'company_city'  =>  $faker->city,
      'company_adnum'  =>  $faker->streetAddress,
      'company_apart'  =>  $faker->secondaryAddress,
      'company_phone_number' =>  $faker->phoneNumber,
      'company_fax_number'      =>  $faker->phoneNumber,
      'manager_name'      =>  $faker->name,
      'site_url'      =>  $faker->url,
      'maker_flag'      =>  $faker->boolean(80),
      'gs1_company_prefix'      =>  $faker->unique()->numberBetween(4900000,4999999),
    ];
});
