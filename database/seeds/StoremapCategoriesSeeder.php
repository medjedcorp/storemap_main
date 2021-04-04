<?php

use Illuminate\Database\Seeder;
use App\Models\StoremapCategory;

class StoremapCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('storemap_categories')->insert([
        'smcategory_name' => 'CD、音楽ソフト、チケット',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => 'DIY、工具',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => 'DVD、映像ソフト',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => 'アウトドア、釣り、旅行用品',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => 'キッチン、日用品、文具',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => 'ゲーム、おもちゃ',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => 'コスメ、美容、ヘアケア',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => 'スポーツ',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => 'スマホ、タブレット、パソコン',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => 'ダイエット、健康',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => 'テレビ、オーディオ、カメラ',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => 'ファッション',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => 'ペット用品、生き物',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => 'ベビー、キッズ、マタニティ',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => 'レンタル、各種サービス',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => '家具、インテリア',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => '家電',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => '花、ガーデニング',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => '楽器、手芸、コレクション',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => '車、バイク、自転車',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => '食品',
      ]);
      DB::table('storemap_categories')->insert([
        'smcategory_name' => '本、雑誌、コミック',
      ]);
     }
}
