<?php

use Illuminate\Database\Seeder;

class StoreUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // DB::table('store_user')->insert([
      //   'user_id' => '1',
      //   'store_id' => '1'
      // ]);
      DB::table('store_user')->insert([
        'user_id' => '2',
        'store_id' => '1'
      ]);
      // DB::table('store_user')->insert([
      //   'user_id' => '2',
      //   'store_id' => '3'
      // ]);
      // DB::table('store_user')->insert([
      //   'user_id' => '2',
      //   'store_id' => '4'
      // ]);
      // DB::table('store_user')->insert([
      //   'user_id' => '2',
      //   'store_id' => '5'
      // ]);
      // DB::table('store_user')->insert([
      //   'user_id' => '3',
      //   'store_id' => '6'
      // ]);
    }
}
