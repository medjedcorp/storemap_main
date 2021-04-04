<?php

use Illuminate\Database\Seeder;

class ItemStoreTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $num = mt_rand(1000, 100000);
    $num2 = mt_rand(0, 100);
    DB::table('item_store')->insert([
      'item_id' => '1',
      'store_id' => '1',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '2',
      'store_id' => '1',
      'selling_flag' => '0',
      'price_type' => '1',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '3',
      'store_id' => '1',
      'selling_flag' => '1',
      'price_type' => '2',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '4',
      'store_id' => '1',
      'selling_flag' => '0',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '0',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '5',
      'store_id' => '1',
      'selling_flag' => '1',
      'price_type' => '1',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '1',
      'store_id' => '2',
      'selling_flag' => '1',
      'price_type' => '2',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '2',
      'store_id' => '2',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '3',
      'store_id' => '2',
      'selling_flag' => '0',
      'price_type' => '1',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '4',
      'store_id' => '2',
      'selling_flag' => '1',
      'price_type' => '2',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '5',
      'store_id' => '2',
      'selling_flag' => '0',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '0',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '1',
      'store_id' => '3',
      'selling_flag' => '1',
      'price_type' => '1',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '2',
      'store_id' => '3',
      'selling_flag' => '1',
      'price_type' => '2',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '3',
      'store_id' => '3',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '4',
      'store_id' => '3',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '5',
      'store_id' => '3',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '6',
      'store_id' => '1',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '6',
      'store_id' => '2',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '6',
      'store_id' => '3',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '7',
      'store_id' => '1',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '7',
      'store_id' => '2',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '7',
      'store_id' => '3',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '8',
      'store_id' => '1',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '8',
      'store_id' => '2',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '8',
      'store_id' => '3',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '9',
      'store_id' => '1',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '9',
      'store_id' => '2',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '9',
      'store_id' => '3',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '10',
      'store_id' => '1',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '10',
      'store_id' => '2',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '10',
      'store_id' => '3',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '11',
      'store_id' => '1',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '11',
      'store_id' => '2',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    DB::table('item_store')->insert([
      'item_id' => '11',
      'store_id' => '3',
      'selling_flag' => '1',
      'price_type' => '0',
      'price' => $num,
      'stock_amount' => $num2,
      'stock_set' => '1',
      'sort_num' => $num2,
    ]);
    factory(App\Models\ItemStore::class, 5000)->create();
  }
}
