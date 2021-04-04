<?php

use Illuminate\Database\Seeder;

class SubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('subscriptions')->insert([
        'id' => '1',
        'company_id' => '1',
        'name' => 'main',
      ]);
    }
}
