<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Store;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;

$factory->define(App\Models\Store::class, function (Faker $faker) {
  return [
    'store_code'      =>  $faker->word(),
    'company_id' => function () {
            return factory(App\Models\Company::class)->create()->id;
        },
    'store_name' =>  $faker->userName,
    'store_postcode' =>  $faker->postcode,
    'prefecture' => $faker->prefecture,
    'store_city' => $faker->city,
    'store_adnum' => $faker->streetAddress,
    'store_apart' => $faker->secondaryAddress,
    'store_phone_number' => $faker->phoneNumber,
    'store_fax_number' => $faker->phoneNumber,
    'store_email' =>  $faker->safeEmail,
    'pause_flag' =>  $faker->boolean,
    'store_img1'      =>  $faker->safeEmailDomain,
    'store_img2'      =>  $faker->safeEmailDomain,
    'store_img3'      =>  $faker->safeEmailDomain,
    'store_img4'      =>  $faker->safeEmailDomain,
    'store_img5'      =>  $faker->safeEmailDomain,
    'store_info'      =>  $faker->realText($faker->numberBetween(10,200)),
    'location' => DB::raw("ST_GeomFromText('POINT(".$faker->latitude($min = 20, $max = 45) ." ". $faker->longitude($min = 122, $max = 153) .")')"),
    'industry_id' =>  $faker->numberBetween($min = 1, $max = 33),
    'store_url'      =>  $faker->url,
    'flyer_img'      =>  $faker->safeEmailDomain,
    'floor_guide'      =>  $faker->safeEmailDomain,
    'pay_info'      =>  $faker->realText($faker->numberBetween(10,200)),
    'access'      =>  $faker->realText($faker->numberBetween(10,100)),
    'opening_hour'      =>  $faker->realText($faker->numberBetween(50,100)),
    'closed_day'      =>  $faker->realText($faker->numberBetween(20,100)),
    'parking'      =>  $faker->realText($faker->numberBetween(30,100)),
  ];
});
