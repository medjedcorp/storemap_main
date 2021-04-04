<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('categories')->insert([
        'category_code' => 'shoulder',
        'company_id' => '1',
        'category_name' => 'ショルダーバッグ',
        'display_flag' => '1',
      ]);
      DB::table('categories')->insert([
        'category_code' => 'wallet',
        'company_id' => '1',
        'category_name' => '財布',
        'display_flag' => '1',
      ]);
      DB::table('categories')->insert([
        'category_code' => 'tote',
        'company_id' => '1',
        'category_name' => 'トートバッグ',
        'display_flag' => '1',
      ]);
      DB::table('categories')->insert([
        'category_code' => 'ruck',
        'company_id' => '1',
        'category_name' => 'リュックサック',
        'display_flag' => '1',
      ]);
      DB::table('categories')->insert([
        'category_code' => 'porch',
        'company_id' => '1',
        'category_name' => 'ポーチ',
        'display_flag' => '1',
      ]);
      DB::table('categories')->insert([
        'category_code' => 'boston',
        'company_id' => '1',
        'category_name' => 'ボストンバッグ',
        'display_flag' => '1',
      ]);
      DB::table('categories')->insert([
        'category_code' => 'waist',
        'company_id' => '1',
        'category_name' => 'ウエストバッグ',
        'display_flag' => '1',
      ]);
      DB::table('categories')->insert([
        'category_code' => 'body',
        'company_id' => '1',
        'category_name' => 'ボディバッグ',
        'display_flag' => '1',
      ]);
      DB::table('categories')->insert([
        'category_code' => 'acc',
        'company_id' => '1',
        'category_name' => '小物',
        'display_flag' => '1',
      ]);
      DB::table('categories')->insert([
        'category_code' => 'others',
        'company_id' => '1',
        'category_name' => 'その他',
        'display_flag' => '1',
      ]);
      factory(App\Models\Category::class, 1000)->create();
    }
}
