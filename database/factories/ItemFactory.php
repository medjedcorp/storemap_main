<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Item;
use Faker\Generator as Faker;

$factory->define(App\Models\Item::class, function (Faker $faker) {
  return [
    'company_id' => function () {
      return factory(App\Models\Company::class)->create()->id;
    },
    'barcode'       =>  $faker->unique()->ean13,
    'product_code'   =>  $faker->unique()->userName,
    'product_name' => $faker->realText($maxNbChars = 20, $indexSize = 2),
    'brand_name' => $faker->realText($maxNbChars = 20, $indexSize = 2),
    'category_id' => $faker->numberBetween(1, 50),
    'display_flag'      =>  $faker->boolean(80),
    'original_price' =>  $faker->randomNumber($nbDigits = 5, $strict = false),
    'description'      =>  $faker->realText($maxNbChars = 100, $indexSize = 2),
    // 'storemap_category_id'  =>  $faker->numberBetween(1, 19),
    'tag' => $faker->realText($maxNbChars = 100, $indexSize = 2),
    'item_status'      =>  $faker->boolean(80),
    'item_img1'      =>  $faker->safeEmailDomain,
    'item_img2'      =>  $faker->safeEmailDomain,
    'item_img3'      =>  $faker->safeEmailDomain,
    'item_img4'      =>  $faker->safeEmailDomain,
    'item_img5'      =>  $faker->safeEmailDomain,
    'item_img6'      =>  $faker->safeEmailDomain,
    'item_img7'      =>  $faker->safeEmailDomain,
    'item_img8'      =>  $faker->safeEmailDomain,
    'item_img9'      =>  $faker->safeEmailDomain,
    'item_img10'     =>  $faker->safeEmailDomain,
    'global_flag'    =>  $faker->boolean(80),
  ];
});
