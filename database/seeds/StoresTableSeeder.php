<?php

use Illuminate\Database\Seeder;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // DB::table('stores')->insert([
      //   'store_code' => 'crosscharmameyoko',
      //   'company_id' => '1',
      //   'store_name' => 'クロスチャーム アメ横店',
      //   'store_kana' => 'くろすちゃーむ　あめよこてん',
      //   'store_postcode' => '110-0005',
      //   'prefecture' => '東京都',
      //   'store_city' => '台東区',
      //   'store_adnum' => '上野6-4-9',
      //   'store_apart' => '',
      //   'store_phone_number' => '03-5826-4088',
      //   'store_fax_number' => '',
      //   'store_email' => 'ameyoko@tophouse.jp',
      //   'pause_flag' => '1',
      //   'store_img1' => '30989785_M.jpg',
      //   'store_img2' => '30989783_4.jpg',
      //   'store_img3' => 'ccameyoko.jpg',
      //   'store_info' => 'クロスチャームアメ横店の情報です。店長は三木さんです。よろしくお願いします。',
      //   'industry_id' => '2',
      //   'store_url' => 'http://www.tophouse.jp/shop/',
      //   'flyer_url' => 'https://image.rakuten.co.jp/plenty-one/cabinet/catalog/evidence11.jpg',
      //   'floor_guide' => '/storage/1/stores/floor_guide190219.gif',
      //   'location' => DB::raw("ST_GeomFromText('POINT(35.708747 139.774815)')"),
      //   // 'latitude' => '',
      //   // 'longitude' => '',
      // ]);
      DB::table('stores')->insert([
        'store_code' => 'crosscharmaruru',
        'company_id' => '1',
        'store_name' => 'クロスチャーム 橿原店',
        'store_kana' => 'くろすちゃーむ　かしはらてん',
        'store_postcode' => '634-0837',
        'prefecture' => '奈良県',
        'store_city' => '橿原市',
        'store_adnum' => '曲川町7-20-1',
        'store_apart' => 'イオンモール橿原アルル　サウスモール3F　中央',
        'store_phone_number' => '0744-47-2004',
        'store_fax_number' => '',
        'store_email' => 'aruru@tophouse.jp',
        'pause_flag' => '1',
        'store_img1' => 'thumbW480_photo1.jpg',
        'store_img2' => 'thumbW480_photo2.jpg',
        'store_img3' => 'ccieonmall_02.jpg',
        'store_info' => 'こんにちは。クロスチャームアルル店の情報です。店長は南さんです。よろしくお願いします。',
        'industry_id' => '2',
        'store_url' => 'http://www.tophouse.jp/shop/',
        'flyer_url' => 'https://image.rakuten.co.jp/plenty-one/cabinet/catalog/evidence07.jpg',
        // 'floor_guide' => '/storage/1/stores/super01.jpg',
        'location' => DB::raw("ST_GeomFromText('POINT(34.5062745 135.7627342)')"),
        // 'latitude' => '34.502314',
        // 'longitude' => '135.756254',
      ]);
      // DB::table('stores')->insert([
      //   'store_code' => 'crosscharmtokyobay',
      //   'company_id' => '1',
      //   'store_name' => 'クロスチャーム ららぽーと 東京ベイ店',
      //   'store_kana' => 'くろすちゃーむ　ららぽーととうきょうべいてん',
      //   'store_postcode' => '273-8530',
      //   'prefecture' => '千葉県',
      //   'store_city' => '船橋市',
      //   'store_adnum' => '浜町 2-1-1',
      //   'store_apart' => 'ららぽーとTOKYO-BAY 北館2F 2B05区画',
      //   'store_phone_number' => '047-421-7328',
      //   'store_fax_number' => '',
      //   'store_email' => 'lalatokyobay@tophouse.jp',
      //   'pause_flag' => '0',
      //   'store_img1' => 'lalatokyobay.jpg',
      //   'store_info' => 'こんばんわ。クロスチャームららぽーと店の情報です。難波くんがいますよ',
      //   'industry_id' => '2',
      //   'store_url' => 'http://www.tophouse.jp/shop/',
      //   'flyer_url' => '',
      //   'location' => DB::raw("ST_GeomFromText('POINT(35.686543 139.989664)')"),
      //   // 
      //   // 'latitude' => '35.686543',
      //   // 'longitude' => '139.989664',
      // ]);
      // factory(App\Models\Store::class, 1000)->create();
    }
}
